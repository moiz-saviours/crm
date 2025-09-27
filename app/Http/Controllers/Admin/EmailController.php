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
            // ALL: return emails that involve the customer OR involve any of my pseudo emails
            $query->where(function ($q) use ($customerEmail, $auth_pseudo_emails) {
                // 1) any email where the customer is the sender OR in recipients
                $q->where('from_email', $customerEmail)
                    ->orWhereJsonContains('to', ['email' => $customerEmail])
                    ->orWhereJsonContains('cc', ['email' => $customerEmail])
                    ->orWhereJsonContains('bcc', ['email' => $customerEmail]);
                // 2) OR any email where one of my pseudo addresses is sender OR appears in recipients
                if (!empty($auth_pseudo_emails)) {
                    $q->orWhere(function ($sub) use ($auth_pseudo_emails) {
                        // sender is one of my addresses
                        $sub->whereIn('from_email', $auth_pseudo_emails);
                        // OR recipient contains one of my addresses
                        foreach ($auth_pseudo_emails as $addr) {
                            $sub->orWhereJsonContains('to', ['email' => $addr])
                                ->orWhereJsonContains('cc', ['email' => $addr])
                                ->orWhereJsonContains('bcc', ['email' => $addr]);
                        }
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
                    'message_id' => $email->message_id ?? [],
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
            $page   = (int) $request->query('page', 1);
            $limit  = (int) $request->query('limit', default: 100);

            if (empty($customerEmail)) {
                return response()->json(['error' => 'Customer email is required'], 400);
            }

            return response()->json(
                $this->getEmails($customerEmail, $folder, $page, $limit)
            );
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
            // Store email record
            $toWithNames = $this->getRecipientsWithNames($toEmails);
            $ccWithNames = $this->getRecipientsWithNames($ccEmails, 'cc');
            $bccWithNames = $this->getRecipientsWithNames($bccEmails, 'bcc');

            //=================
            // after validation and $sender checks...

            $threadFromRequest   = $request->input('thread_id');
            $inReplyToRequest    = $request->input('in_reply_to');
            $referencesRequest   = $request->input('references'); // could be string or JSON

            $fromEmail = $validated['from'];
            $fromName  = $this->getSenderName($sender, $fromEmail);

            // 1) create a message-id for this outgoing email
            $appDomain = parse_url(config('app.url'), PHP_URL_HOST) ?: (explode('@', $fromEmail)[1] ?? 'localhost');
            $messageId = '<' . (string) Str::uuid() . '@' . $appDomain . '>';

            // 2) choose thread_id
            if (!empty($threadFromRequest)) {
                $threadId = $threadFromRequest;
            } elseif (!empty($inReplyToRequest)) {
                // try to find parent and reuse its thread_id
                $parent = Email::where('message_id', $inReplyToRequest)->first();
                $threadId = $parent ? $parent->thread_id : md5($validated['subject'] . $fromEmail . time());
            } else {
                $threadId = md5($validated['subject'] . $fromEmail . time());
            }

            // 3) build references header (append parent if provided)
            $references = $referencesRequest;
            if (!empty($inReplyToRequest)) {
                // if incoming references already a serialized array or string, just append
                $references = trim(($referencesRequest ? $referencesRequest . ' ' : '') . $inReplyToRequest);
            }

            //=================


            $email = Email::create([
                'pseudo_record_id' => $sender->id,
                'thread_id' => $threadId,
                'message_id' => $messageId,
                'in_reply_to' => $inReplyToRequest,
                'references' => $references,
                'from_email' => $fromEmail,
                'from_name' => $fromName,
                'to' => $this->getRecipientsWithNames($validated['to']),
                'cc' => $this->getRecipientsWithNames($validated['cc'] ?? [], 'cc'),
                'bcc' => $this->getRecipientsWithNames($validated['bcc'] ?? [], 'bcc'),
                'subject' => $validated['subject'],
                'body_html' => null,
                'body_text' => null,
                'imap_folder' => 'Sent',
                'type' => 'outgoing',
                'folder' => 'sent',
                'is_read' => true,
                'message_date' => now(),
                'sent_at' => null, // set after successful send
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
            // prepare HTML/text content (wrap URLs etc)
            $content = $this->wrapUrlsForTracking($validated['email_content'], $email->id);
            $textContent = strip_tags($content);

            // update email body in DB (without tracking pixel or with, your choice)
            $email->update(['body_html' => $content, 'body_text' => $textContent]);

            // PHPMailer setup (your existing config)
            $mailer = new PHPMailer(true);
            $mailer->isSMTP();
            $mailer->Host = $sender->server_host;
            $mailer->Port = 465;
            $mailer->SMTPSecure = 'ssl';
            $mailer->SMTPAuth = true;
            $mailer->Username = $sender->server_username ?? $sender->pseudo_email;
            $mailer->Password = $sender->server_password;

            $mailer->setFrom($fromEmail, $fromName);
            $mailer->Subject = $validated['subject'];
            $mailer->isHTML(true);

            // Set Message-ID / In-Reply-To / References headers
            $mailer->addCustomHeader('Message-ID', $messageId);
            if (!empty($inReplyToRequest)) {
                $mailer->addCustomHeader('In-Reply-To', $inReplyToRequest);
            }
            if (!empty($references)) {
                $mailer->addCustomHeader('References', $references);
            }

            // Add tracking pixel to the mail body (optional: you may not want it stored in DB)
            $trackingPixel = '<img src="' . route('emails.track.open', ['id' => $email->id]) . '" width="1" height="1" alt="" />';
            $mailer->Body = $content . $trackingPixel;
            $mailer->AltBody = $textContent;

            // add recipients (your code)
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

            // mark sent_at and update DB
            $email->update(['sent_at' => now()]);
            Log::info('Email sent successfully', [
                'email_id' => $email->id,
                'from' => $fromEmail,
                'to' => $toEmails,
                'subject' => $validated['subject'],
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
