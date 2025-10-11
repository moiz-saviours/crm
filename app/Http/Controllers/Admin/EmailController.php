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
use Illuminate\Support\Facades\Response;

class EmailController extends Controller
{



    private function getExtensionFromMimeType(string $mimeType): string
    {
        $extensions = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'application/zip' => 'zip',
        ];
        return $extensions[strtolower($mimeType)] ?? 'bin';
    }
    private function normalizeMsgId($id)
    {
        if (empty($id)) {
            return null;
        }

        $normalized = trim($id, " <>\t\n\r");

        // If it contains @, extract the UUID part (your sent emails use UUIDs)
        if (str_contains($normalized, '@')) {
            $parts = explode('@', $normalized);
            $uuidPart = $parts[0];

            // Check if it's a valid UUID
            if (Str::isUuid($uuidPart)) {
                return $uuidPart;
            }
        }

        return $normalized;
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

        $emailContent = $validated['email_content'] ?? '';
        $totalImageSize = 0;

        // Find all base64 images in the email content
        preg_match_all('/data:image\/[^;]+;base64,([A-Za-z0-9+\/=]+)/', $emailContent, $matches);

        foreach ($matches[1] as $base64String) {
            $decoded = base64_decode($base64String, true);
            if ($decoded !== false) {
                $totalImageSize += strlen($decoded);
            }
        }

        // 5 MB limit for total embedded image size
        $maxTotalSize = 5 * 1024 * 1024;

        if ($totalImageSize > $maxTotalSize) {
            return response()->json([
                'success' => false,
                'message' => 'Embedded images are too large. Please reduce total image size (max 5 MB).'
            ], 422);
        }

        // Optional: validate overall HTML size
        $totalContentSize = strlen($emailContent);
        if ($totalContentSize > 7 * 1024 * 1024) { // 7 MB total
            return response()->json([
                'success' => false,
                'message' => 'Email content is too large. Please simplify or reduce embedded content (max 7 MB).'
            ], 422);
        }




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
            // Generate a clean UUID for message ID (no domain)
            $messageId = (string) Str::uuid() . '@' . (parse_url(config('app.url'), PHP_URL_HOST) ?? 'localhost');

            // --- choose thread id ---
            // --- choose thread id ---
            if (!empty($threadFromRequest)) {
                $threadId = $threadFromRequest;
            } elseif (!empty($inReplyToRequest)) {
                // Normalize the in_reply_to to match your database format
                $normalizedInReplyTo = $this->normalizeMsgId(trim($inReplyToRequest));
                $parent = Email::where('message_id', $normalizedInReplyTo)->first();

                if ($parent) {
                    $threadId = $parent->thread_id;
                    Log::info('Found parent email for threading', [
                        'parent_id' => $parent->id,
                        'parent_message_id' => $parent->message_id,
                        'thread_id' => $threadId
                    ]);
                } else {
                    // If parent not found, use the in_reply_to as thread ID
                    $threadId = $normalizedInReplyTo;
                    Log::warning('Parent email not found for in_reply_to, using it as thread ID', [
                        'in_reply_to' => $normalizedInReplyTo
                    ]);
                }
            } else {
                // New email → use this message-id as thread id
                $threadId = $this->normalizeMsgId($messageId);
            }

            // Build references header
            $references = '';
            if (!empty($referencesRequest)) {
                $references = is_array($referencesRequest) ? implode(' ', $referencesRequest) : $referencesRequest;
            }

            if (!empty($inReplyToRequest)) {
                $normalizedInReplyTo = $this->normalizeMsgId(trim($inReplyToRequest));
                $references = trim(($references ? $references . ' ' : '') . $normalizedInReplyTo);

                // Also ensure the parent's references are included
                $parent = Email::where('message_id', $normalizedInReplyTo)->first();
                if ($parent && !empty($parent->references)) {
                    $parentRefs = $parent->references;
                    $references = trim("{$parentRefs} {$references}");
                }
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
            // Handle forward
            $forwardIdRequest = $request->input('forward_id');
            if (!empty($forwardIdRequest)) {
                $originalEmail = Email::where('message_id', $forwardIdRequest)->first();
                if ($originalEmail) {
                    // Preserve original plain text content exactly as it is
                    $originalBodyHtml = $originalEmail->body_html;
                    $originalBodyText = $originalEmail->body_text;

                    $originalFrom = $originalEmail->from_name ?: $originalEmail->from_email;
                    $originalDate = $originalEmail->message_date->format('D, M d, Y \a\t H:i:s');

                    // Build forwarded section in HTML
                    $quotedBody = "<br><br><div style='border-left: 2px solid #ccc; padding-left: 10px;'>";
                    $quotedBody .= "<p>----- Forwarded Message -----<br>";
                    $quotedBody .= "From: {$originalFrom}<br>";
                    $quotedBody .= "Sent: {$originalDate}<br>";
                    $quotedBody .= "To: " . implode(', ', array_column($originalEmail->to ?? [], 'email')) . "<br>";
                    $quotedBody .= "Subject: {$originalEmail->subject}</p>";
                    $quotedBody .= $originalBodyHtml ?: nl2br(e($originalBodyText));
                    $quotedBody .= "</div>";

                    // Concatenate forwarded section with current content
                    $emailContent = $emailContent . $quotedBody;

                    // Preserve the original plain text body for body_text (unaltered)
                    $textContent = $originalBodyText;

                    // Add "Fwd:" prefix if missing
                    if (!str_starts_with(strtolower($subject), 'fwd:')) {
                        $subject = 'Fwd: ' . $subject;
                    }
                } else {
                    Log::warning('Original email not found for forward_id', [
                        'forward_id' => $forwardIdRequest,
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

            // Store attachments based on size
            $storedAttachments = [];

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $mimeType = $file->getMimeType();
                    $size = $file->getSize();
                    $extension = $file->getClientOriginalExtension() ?: $this->getExtensionFromMimeType($mimeType);

                    // Calculate size in MB
                    $sizeInMb = $size / (1024 * 1024);

                    $attachmentAttributes = [
                        'email_id' => $email->id,
                        'original_name' => $originalName,
                        'mime_type' => $mimeType,
                        'size' => $size,
                        'extension' => $extension,
                    ];

                    if ($sizeInMb > 2) {
                        // Store as file if > 2MB
                        $storageName = 'attachments/' . uniqid('email_' . $email->id . '_') . '.' . $extension;
                        try {
                            Storage::disk('public')->put($storageName, file_get_contents($file->getRealPath()));
                            $attachmentAttributes['storage_name'] = $storageName;
                            $attachmentAttributes['storage_path'] = Storage::disk('public')->path($storageName);
                            $storedAttachments[] = $attachmentAttributes + ['content' => file_get_contents($file->getRealPath())];
                            Log::info("Stored attachment {$originalName} as file: {$storageName}");
                        } catch (\Exception $e) {
                            Log::error('Failed to store attachment as file', [
                                'email_id' => $email->id,
                                'original_name' => $originalName,
                                'error' => $e->getMessage(),
                            ]);
                            continue;
                        }
                    } else {
                        // Store as base64 in database if ≤ 2MB
                        $attachmentAttributes['base64_content'] = base64_encode(file_get_contents($file->getRealPath()));
                        $storedAttachments[] = $attachmentAttributes + ['content' => file_get_contents($file->getRealPath())];
                        Log::info("Stored attachment {$originalName} as base64 in database");
                    }
                    // Store attachment record in DB
                    try {
                        EmailAttachment::create($attachmentAttributes);
                        Log::info("Attachment {$originalName} saved successfully for email #{$email->id}");
                    } catch (\Exception $e) {
                        Log::error('Failed to save attachment to database', [
                            'email_id' => $email->id,
                            'original_name' => $originalName,
                            'error' => $e->getMessage(),
                        ]);
                        continue;
                    }
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

            $mailer->addCustomHeader('Message-ID', "<{$messageId}>");
            if (!empty($inReplyToRequest)) {
                $mailer->addCustomHeader('In-Reply-To', "<{$inReplyToRequest}>");
            }
            if (!empty($references)) {
                // normalize space-separated list, wrap each in <>
                $refList = collect(explode(' ', $references))
                    ->filter()
                    ->map(fn($r) => '<' . trim($r, '<> ') . '>')
                    ->implode(' ');
                $mailer->addCustomHeader('References', $refList);
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
                if (isset($attachment['storage_path']) && Storage::disk('public')->exists($attachment['storage_name'])) {
                    // File-based attachment
                    $mailer->addAttachment(
                        $attachment['storage_path'],
                        $attachment['original_name'],
                        'binary',
                        $attachment['mime_type']
                    );
                } elseif (isset($attachment['base64_content'])) {
                    // Base64 attachment
                    $mailer->addStringAttachment(
                        base64_decode($attachment['base64_content']),
                        $attachment['original_name'],
                        'binary',
                        $attachment['mime_type']
                    );
                } else {
                    Log::warning('Attachment data not found', [
                        'email_id' => $email->id,
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

        $pattern = '/(https?:\/\/[^\s<]+)/i';
        $content = preg_replace_callback($pattern, function ($matches) {
            $url = $matches[1];
            return "<a href=\"{$url}\">{$url}</a>";
        }, $content);

        // Load HTML safely
        $doc = new \DOMDocument();
        @$doc->loadHTML(
            mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        // Process links
        $links = $doc->getElementsByTagName('a');
        foreach ($links as $link) {
            if ($link->hasAttribute('href')) {
                $originalUrl = $link->getAttribute('href');

                if (!preg_match('/^https?:\/\//i', $originalUrl)) {
                    continue;
                }

                if (strpos($originalUrl, route('emails.track.click', ['id' => $emailId])) === 0) {
                    continue;
                }

                $encoded = urlencode(base64_encode($originalUrl));
                $trackingUrl = route('emails.track.click', ['id' => $emailId]) . '?url=' . $encoded;

                $link->setAttribute('href', $trackingUrl);
                $link->setAttribute('target', '_blank');
                $link->setAttribute('rel', 'noopener noreferrer');
            }
        }

        return $doc->saveHTML() ?: $content;
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

    public function download($id)
    {
        try {
            $attachment = EmailAttachment::findOrFail($id);

            // Check if attachment is stored as a file
            if ($attachment->storage_path && Storage::disk('public')->exists($attachment->storage_name)) {
                return Storage::disk('public')->download(
                    $attachment->storage_name,
                    $attachment->original_name,
                    ['Content-Type' => $attachment->mime_type]
                );
            }

            // Check if attachment is stored as base64
            if ($attachment->base64_content) {
                $decoded = base64_decode($attachment->base64_content);
                if ($decoded === false) {
                    return response()->json(['error' => 'Failed to decode attachment data'], 500);
                }

                return Response::make($decoded, 200, [
                    'Content-Type' => $attachment->mime_type ?? 'application/octet-stream',
                    'Content-Disposition' => 'attachment; filename="' . ($attachment->original_name ?? 'attachment.' . $attachment->extension) . '"',
                ]);
            }

            return response()->json(['error' => 'Attachment data not found'], 404);
        } catch (\Exception $e) {
            \Log::error('Attachment Download Error', [
                'attachment_id' => $id,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Failed to download attachment'], 500);
        }
    }
}
