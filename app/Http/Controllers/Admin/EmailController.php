<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerContact;
use App\Models\Email;
use App\Models\EmailAttachment;
use App\Models\UserPseudoRecord;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Artisan;
use DOMDocument;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Mail\OutgoingEmail;
use Illuminate\Support\Str;

class EmailController extends Controller
{
    public function getEmails($customerEmail, $folder = "all", $page = 1, $limit = 100)
    {
        $user = Auth::guard('admin')->user();
        $auth_pseudo_emails = UserPseudoRecord::where('morph_id', $user->id)
            ->where('morph_type', get_class($user))
            ->where('imap_type', 'imap')
            ->pluck('pseudo_email')
            ->toArray();

        $query = Email::with('events');
        if ($folder == 'inbox') {
            $query->where('from_email', $customerEmail)
                ->where(function ($q) use ($auth_pseudo_emails) {
                    foreach ($auth_pseudo_emails as $email) {
                        $q->orWhereJsonContains('to', ['email' => $email])
                            ->orWhereJsonContains('cc', ['email' => $email])
                            ->orWhereJsonContains('bcc', ['email' => $email]);
                    }
                });
        } elseif ($folder == 'sent') {
            $query->whereIn('from_email', $auth_pseudo_emails);
        } elseif ($folder == 'drafts') {
            $query->where('folder', 'drafts')
                ->whereIn('from_email', $auth_pseudo_emails);
        } elseif ($folder == 'spam') {
            $query->where('folder', 'spam')
                ->where(function ($q) use ($customerEmail, $auth_pseudo_emails) {
                    $q->where('from_email', $customerEmail)
                        ->orWhereIn('from_email', $auth_pseudo_emails);
                });
        } elseif ($folder == 'trash') {
            $query->where('folder', 'trash');
        } elseif ($folder == 'archive') {
            $query->where('folder', 'archive');
        } else {
            $query->where(function ($q) use ($customerEmail, $auth_pseudo_emails) {
                // 1) Client is sender or in recipients
                $q->where('from_email', $customerEmail)
                    ->orWhereJsonContains('to', ['email' => $customerEmail])
                    ->orWhereJsonContains('cc', ['email' => $customerEmail])
                    ->orWhereJsonContains('bcc', ['email' => $customerEmail]);

                // 2) OR Client ↔ Pseudo communication
                if (!empty($auth_pseudo_emails)) {
                    $q->orWhere(function ($sub) use ($customerEmail, $auth_pseudo_emails) {
                        // Case A: Client → My pseudo
                        $sub->where('from_email', $customerEmail)
                            ->where(function ($nested) use ($auth_pseudo_emails) {
                                foreach ($auth_pseudo_emails as $addr) {
                                    $nested->orWhereJsonContains('to', ['email' => $addr])
                                        ->orWhereJsonContains('cc', ['email' => $addr])
                                        ->orWhereJsonContains('bcc', ['email' => $addr]);
                                }
                            });

                        // Case B: My pseudo → Client
                        $sub->orWhere(function ($nested) use ($customerEmail, $auth_pseudo_emails) {
                            $nested->whereIn('from_email', $auth_pseudo_emails)
                                ->where(function ($nn) use ($customerEmail) {
                                    $nn->orWhereJsonContains('to', ['email' => $customerEmail])
                                        ->orWhereJsonContains('cc', ['email' => $customerEmail])
                                        ->orWhereJsonContains('bcc', ['email' => $customerEmail]);
                                });
                        });
                    });
                }
            });
        }


        if ($folder !== 'all') {
            $query->where('folder', $folder);
        }

        $offset = ($page - 1) * $limit;

        $emails = $query->orderBy('message_date', 'desc')
            ->with(['attachments' => function ($q) {
                $q->select('id', 'email_id', 'original_name', 'size', 'mime_type', 'storage_path');
            }])
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($email) {
                return [
                    'uuid' => 'email-' . $email->id,
                    'thread_id' => $email->thread_id ?? [],
                    'message_id' => $email->message_id ?? '',
                    'references' => $email->references ?? [],


                    'from' => [
                        'name' => $email->from_name,
                        'email' => $email->from_email,
                    ],
                    'to' => $email->to ?? [],
                    'cc' => $email->cc ?? [],
                    'bcc' => $email->bcc ?? [],
                    'subject' => $email->subject,
                    'folder' => $email->folder,
                    'type' => $email->type,
                    'date' => $email->message_date,
                    'body' => [
                        'html' => $email->body_html,
                        'text' => $email->body_text,
                    ],
                    'attachments' => $email->attachments->map(function ($attachment) {
                        return [
                            'filename' => $attachment->original_name,
                            'type' => $attachment->mime_type,
                            'size' => $attachment->size,
                            'download_url' => $attachment->storage_path ? Storage::url($attachment->storage_path) : null,
                        ];
                    })->toArray(),
                    'open_count' => $email->events->where('event_type', 'open')->count(),
                    'click_count' => $email->events->where('event_type', 'click')->count(),
                    'bounce_count' => $email->events->where('event_type', 'bounce')->count(),
                    'spam_count' => $email->events->where('event_type', 'spam')->count(),
                    'events' => $email->events->map(function ($event) {
                        $icons = [
                            'open' => 'fa-envelope-open',
                            'click' => 'fa-mouse-pointer',
                            'bounce' => 'fa-exclamation-triangle',
                            'spam' => 'fa-ban',
                        ];
                        return [
                            'id' => $event->id,
                            'event_type' => $event->event_type,
                            'created_at' => $event->created_at,
                            'icon' => $icons[$event->event_type] ?? 'fa-info-circle',
                        ];
                    })->values()->toArray(),
                ];
            })
            ->values()
            ->toArray();
        return [
            'emails' => $emails,
            'page'   => $page,
            'limit'  => $limit,
            'count'  => count($emails),
        ];
    }

public function fetch(Request $request)
{
    try {
        $customerEmail = urldecode(trim($request->query('customer_email')));
        $folder = $request->query('folder', 'all');
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 100);

        if (empty($customerEmail)) {
            return response()->json(['error' => 'Customer email is required'], 400);
        }

        $data = $this->getEmails($customerEmail, $folder, $page, $limit);
        
        // Render Blade partial for each email
        $htmlEmails = array_map(function ($email) {
            return view('admin.customers.contacts.timeline.partials.card-box.email', ['email' => $email])->render();
        }, $data['emails']);

        return response()->json([
            'emails' => $htmlEmails, // Array of rendered HTML strings
            'page' => $data['page'],
            'limit' => $data['limit'],
            'count' => $data['count'],
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Processing complete.',
            'details' => $e->getMessage(),
        ], 500);
    }
}

    public function fetchNewEmails(Request $request)
    {
        try {
            $customerEmail = $request->query('customer_email');
            if (!$customerEmail) {
                return response()->json(['error' => 'Customer email is required'], 400);
            }
            $user = Auth::guard('admin')->user();
            $pseudoEmails = UserPseudoRecord::where('morph_id', $user->id)
                ->where('morph_type', get_class($user))
                ->where('imap_type', 'imap')
                ->pluck('pseudo_email')
                ->toArray();
            if (empty($pseudoEmails)) {
                return response()->json(['error' => 'No IMAP accounts found for the current user'], 400);
            }
            $command = ['emails:fetch', '--address=' . $customerEmail];
            foreach ($pseudoEmails as $email) {
                $command[] = '--account=' . $email;
            }
            $exitCode = Artisan::call(implode(' ', $command));
            if ($exitCode !== 1) {
                Log::error('Failed to run emails:fetch command', [
                    'customer_email' => $customerEmail,
                    'pseudo_emails' => $pseudoEmails,
                    'exit_code' => $exitCode,
                    'file' => __FILE__,
                    'line' => __LINE__,
                    'error' => isset($e) ? $e->getMessage() : null,
                ]);
                return response()->json(['error' => 'Failed to fetch new emails'], 500);
            }
            return response()->json(['success' => true, 'message' => 'New emails fetched successfully']);
        } catch (\Exception $e) {
            Log::error('Error fetching new emails', [
                'customer_email' => $customerEmail,
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'error' => 'Failed to fetch new emails. Please try again later.',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function sendEmail(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'email_content' => 'required|string',
            'to' => 'required|array|min:1',
            'to.*' => 'required|email',
            'from' => 'required|email',
            'cc' => 'sometimes|array',
            'cc.*' => 'email',
            'bcc' => 'sometimes|array',
            'bcc.*' => 'email',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:10240',
        ], [
            'to.min' => 'No valid recipients specified.',
            'to.*.email' => 'One or more recipients are not valid email addresses.',
        ]);

        try {
            $sender = $this->findSender($validated['from']);
            if (!$sender) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sender not authorized or not found',
                ], 403);
            }

            if (!$sender instanceof UserPseudoRecord || empty($sender->server_password) || empty($sender->server_host)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or missing SMTP credentials for sender',
                ], 403);
            }

            $toEmails = $validated['to'] ?? [];
            $ccEmails = $validated['cc'] ?? [];
            $bccEmails = $validated['bcc'] ?? [];
            if (empty($toEmails)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid recipients specified',
                ], 400);
            }

            $fromEmail = $validated['from'];
            $fromName = $this->getSenderName($sender, $fromEmail);
            $toWithNames = $this->getRecipientsWithNames($toEmails);
            $ccWithNames = $this->getRecipientsWithNames($ccEmails, 'cc');
            $bccWithNames = $this->getRecipientsWithNames($bccEmails, 'bcc');

            // Handle thread, message ID, and references
            $threadFromRequest = $request->input('thread_id');
            $inReplyToRequest = $request->input('in_reply_to');
            $referencesRequest = $request->input('references'); // could be string or JSON

            // Create a message-id for this outgoing email
            $appDomain = parse_url(config('app.url'), PHP_URL_HOST) ?: (explode('@', $fromEmail)[1] ?? 'localhost');
            $messageId = '<' . (string) Str::uuid() . '@' . $appDomain . '>';

            // Choose thread_id
            if (!empty($threadFromRequest)) {
                $threadId = $threadFromRequest;
            } elseif (!empty($inReplyToRequest)) {
                // Try to find parent and reuse its thread_id
                $parent = Email::where('message_id', $inReplyToRequest)->first();
                $threadId = $parent ? $parent->thread_id : md5($validated['subject'] . $fromEmail . time());
            } else {
                $threadId = md5($validated['subject'] . $fromEmail . time());
            }

            // Build references header
            $references = $referencesRequest;
            if (!empty($inReplyToRequest)) {
                $references = trim(($referencesRequest ? $referencesRequest . ' ' : '') . $inReplyToRequest);
            }

            // Handle reply: Fetch original email and concatenate with new content
            $emailContent = $validated['email_content'];
            $textContent = strip_tags($emailContent);
            $subject = $validated['subject'];

            if (!empty($inReplyToRequest)) {
                $originalEmail = Email::where('message_id', $inReplyToRequest)->first();
                if ($originalEmail) {
                    // Get the original email's body (prefer HTML if available, fallback to text)
                    $originalBody = $originalEmail->body_html ?: $originalEmail->body_text;
                    $originalFrom = $originalEmail->from_name ?: $originalEmail->from_email;
                    $originalDate = $originalEmail->message_date->format('D, M d, Y \a\t H:i:s');

                    // Format the original email as a quoted reply
                    $quotedBody = "<br><br><div style='border-left: 2px solid #ccc; padding-left: 10px;'>";
                    $quotedBody .= "<p>From: {$originalFrom}<br>";
                    $quotedBody .= "Sent: {$originalDate}<br>";
                    $quotedBody .= "Subject: {$originalEmail->subject}</p>";
                    $quotedBody .= $originalBody;
                    $quotedBody .= "</div>";

                    // Concatenate new content with quoted original content
                    $emailContent = $emailContent . $quotedBody;

                    // Text version for AltBody
                    $textQuotedBody = "\n\n> From: {$originalFrom}\n> Sent: {$originalDate}\n> Subject: {$originalEmail->subject}\n\n";
                    $textQuotedBody .= strip_tags($originalBody);
                    $textContent = strip_tags($emailContent) . $textQuotedBody;

                    // Add "Re:" prefix to subject if not already present
                    if (!str_starts_with(strtolower($subject), 're:')) {
                        $subject = 'Re: ' . $subject;
                    }
                } else {
                    // Log if original email not found
                    Log::warning('Original email not found for in_reply_to', [
                        'in_reply_to' => $inReplyToRequest,
                    ]);
                }
            }
            // Store email record
            $email = Email::create([
                'pseudo_record_id' => $sender->id,
                'thread_id' => $threadId,
                'message_id' => $messageId,
                'in_reply_to' => $inReplyToRequest,
                'references' => $references,
                'from_email' => $fromEmail,
                'from_name' => $fromName,
                'to' => $toWithNames,
                'cc' => $ccWithNames,
                'bcc' => $bccWithNames,
                'subject' => $subject,
                'body_html' => $emailContent,
                'body_text' => $textContent,
                'imap_folder' => 'Sent',
                'type' => 'outgoing',
                'folder' => 'sent',
                'is_read' => true,
                'message_date' => now(),
                'sent_at' => null, // Set after successful send
            ]);

            // Store attachments
            $storedAttachments = [];
            if ($request->hasFile('attachments')) {
                $attachmentsDir = 'attachments/outgoing/' . uniqid();
                foreach ($request->file('attachments') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $storageName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
                    $storagePath = $file->storeAs($attachmentsDir, $storageName, 'public');
                    $storedAttachments[] = [
                        'original_name' => $originalName,
                        'storage_name' => $storageName,
                        'storage_path' => $storagePath,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ];
                    // Store attachment record
                    EmailAttachment::create([
                        'email_id' => $email->id,
                        'original_name' => $originalName,
                        'storage_name' => $storageName,
                        'storage_path' => $storagePath,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
            }

            // Wrap URLs for tracking
            $content = $this->wrapUrlsForTracking($emailContent, $email->id);
            $textContent = strip_tags($content);

            // Update email body in DB
            $email->update(['body_html' => $content, 'body_text' => $textContent]);

            // PHPMailer setup
            $mailer = new PHPMailer(true);
            $mailer->isSMTP();
            $mailer->Host = $sender->server_host;
            $mailer->Port = 465;
            $mailer->SMTPSecure = 'ssl';
            $mailer->SMTPAuth = true;
            $mailer->Username = $sender->server_username ?? $sender->pseudo_email;
            $mailer->Password = $sender->server_password;

            $mailer->setFrom($fromEmail, $fromName);
            $mailer->Subject = $subject;
            $mailer->isHTML(true);

            // Set Message-ID / In-Reply-To / References headers
            $mailer->addCustomHeader('Message-ID', $messageId);
            if (!empty($inReplyToRequest)) {
                $mailer->addCustomHeader('In-Reply-To', $inReplyToRequest);
            }
            if (!empty($references)) {
                $mailer->addCustomHeader('References', $references);
            }

            // Add tracking pixel to the mail body
            $trackingPixel = '<img src="' . route('emails.track.open', ['id' => $email->id]) . '" width="1" height="1" alt="" />';
            $mailer->Body = $content . $trackingPixel;
            $mailer->AltBody = $textContent;

            // Add recipients
            foreach ($toWithNames as $r) {
                $mailer->addAddress($r['email'], $r['name'] ?? '');
            }
            foreach ($ccWithNames as $r) {
                $mailer->addCC($r['email'], $r['name'] ?? '');
            }
            foreach ($bccWithNames as $r) {
                $mailer->addBCC($r['email'], $r['name'] ?? '');
            }

            // Add attachments
            foreach ($storedAttachments as $attachment) {
                $filePath = storage_path('app/public/' . $attachment['storage_path']);
                if (file_exists($filePath)) {
                    $mailer->addAttachment(
                        $filePath,
                        $attachment['original_name'],
                        'base64',
                        $attachment['mime_type']
                    );
                } else {
                    Log::warning('Attachment file not found', [
                        'path' => $filePath,
                        'original_name' => $attachment['original_name'],
                    ]);
                }
            }

            // Send email
            $mailer->send();

            // Mark sent_at and update DB
            $email->update(['sent_at' => now()]);
            Log::info('Email sent successfully', [
                'email_id' => $email->id,
                'from' => $fromEmail,
                'to' => $toEmails,
                'subject' => $subject,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully',
                'email_id' => $email->id,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Email sending failed', [
                'error' => $e->getMessage(),
                'from' => $validated['from'] ?? null,
                'to' => $validated['to'] ?? null,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Please try again.',
            ], 500);
        }
    }

    /**
     * Fetch Recipients names for email addresses
     */
    private function getRecipientsWithNames(array $emails, string $type = 'to'): array
    {
        return array_map(function ($email) use ($type) {
            $model = $type == 'to'
                ? CustomerContact::where('email', $email)->whereNotNull('name')->first() ?? UserPseudoRecord::where('pseudo_email', $email)->whereNotNull('pseudo_name')->first()
                : UserPseudoRecord::where('pseudo_email', $email)->whereNotNull('pseudo_name')->first() ?? CustomerContact::where('email', $email)->whereNotNull('name')->first();
            return ['email' => $email, 'name' => $model instanceof UserPseudoRecord ? $model->pseudo_name : $model?->name];
        }, $emails);
    }

    protected function wrapUrlsForTracking(string $content, ?int $emailId): string
    {
        if (!$emailId) {
            return $content;
        }
        $doc = new DOMDocument();
        @$doc->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $links = $doc->getElementsByTagName('a');
        foreach ($links as $link) {
            if ($link->hasAttribute('href')) {
                $originalUrl = $link->getAttribute('href');
                if (!preg_match('/^https?:\/\//i', $originalUrl)) {
                    continue;
                }
                $trackingUrl = route('emails.track.click', ['id' => $emailId]) . '?url=' . urlencode($originalUrl);
                $link->setAttribute('href', $trackingUrl);
            }
        }
        return $doc->saveHTML();
    }

    private function parseEmailListForStorage(array $emails): ?array
    {
        if (empty($emails)) {
            return null;
        }
        $parsed = [];
        foreach ($emails as $emailStr) {
            if (preg_match('/^(.*?)[\s<]?(.*?@[\w\.-]+)[\s>]?$/', trim($emailStr), $matches)) {
                $name = trim($matches[1]) ?: null;
                $email = trim($matches[2]);
                $parsed[] = [
                    'email' => $email,
                    'name' => $name,
                ];
            } else {
                $parsed[] = [
                    'email' => $emailStr,
                    'name' => null,
                ];
            }
        }
        return $parsed;
    }

    private function findSender(string $email): ?object
    {
        return UserPseudoRecord::where('pseudo_email', $email)
            ->where('imap_type', 'imap')
            ->first();
    }

    private function getSenderName($sender, string $defaultEmail): string
    {
        return $sender->pseudo_name ?? explode('@', $defaultEmail)[0];
    }
}
