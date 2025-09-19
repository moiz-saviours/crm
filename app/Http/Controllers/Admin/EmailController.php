<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Mail\OutgoingEmail;

class EmailController extends Controller
{
    public function getEmails($customerEmail, $folder = "all")
    {
        $query = Email::where(function ($q) use ($customerEmail) {
            $q->where('from_email', $customerEmail)
                ->orWhereJsonContains('to', ['email' => $customerEmail])
                ->orWhereJsonContains('cc', ['email' => $customerEmail])
                ->orWhereJsonContains('bcc', ['email' => $customerEmail]);
        });

        if ($folder !== 'all') {
            $query->where('folder', $folder);
        }

        $emails = $query->orderBy('message_date', 'desc')
            ->with(['attachments' => function ($q) {
                $q->select('id', 'email_id', 'original_name', 'size', 'mime_type', 'storage_path');
            }])
            ->get()
            ->map(function ($email) {
                return [
                    'uuid' => 'email-' . $email->id,
                    'from' => [[
                        'name'  => $email->from_name,
                        'email' => $email->from_email,
                    ]],
                    'to' => $email->to ?? [],
                    'subject' => $email->subject,
                    'date' => $email->message_date,
                    'body' => [
                        'html' => $email->body_html,
                        'text' => $email->body_text,
                    ],
                    'attachments' => $email->attachments->map(function ($attachment) {
                        return [
                            'filename' => $attachment->original_name,
                            'type'     => $attachment->mime_type,
                            'size'     => $attachment->size,
                            'download_url' => $attachment->storage_path ? Storage::url($attachment->storage_path) : null,
                        ];
                    })->toArray(),
                ];
            })
            ->values()
            ->toArray();

        $folders = Email::where(function ($q) use ($customerEmail) {
            $q->where('from_email', $customerEmail)
                ->orWhereJsonContains('to', ['email' => $customerEmail])
                ->orWhereJsonContains('cc', ['email' => $customerEmail])
                ->orWhereJsonContains('bcc', ['email' => $customerEmail]);
        })
            ->distinct()
            ->pluck('folder')
            ->filter()
            ->values()
            ->toArray();

        return ['emails' => $emails, 'folders' => $folders, 'folder' => $folder];
    }

    public function fetch(Request $request)
    {
        try {
            $customerEmail = $request->query('customer_email');
            $folder = $request->query('folder', 'all');

            if (!$customerEmail) {
                return response()->json(['error' => 'Customer email is required'], 400);
            }

            return response()->json($this->getEmails($customerEmail, $folder));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch emails. Please try again later.',
                'details' => $e->getMessage() // optional for debugging
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
        // Validate request data
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'email_content' => 'required|string',
            'to' => 'required|string',
            'from' => 'required|email',
            'cc' => 'nullable|string',
            'bcc' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:10240',
        ]);

        try {
            // Find sender (UserPseudoRecord)
            $sender = $this->findSender($validated['from']);
            if (!$sender) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sender not authorized or not found',
                ], 403);
            }

            // Validate SMTP credentials
            if (!$sender instanceof UserPseudoRecord || empty($sender->server_password) || empty($sender->server_host)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or missing SMTP credentials for sender',
                ], 403);
            }

            // Parse email lists, with fallback for missing cc/bcc
            $toEmails = $this->parseEmailList($validated['to']);
            $ccEmails = $this->parseEmailList($validated['cc'] ?? '');
            $bccEmails = $this->parseEmailList($validated['bcc'] ?? '');

            if (empty($toEmails)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid recipients specified',
                ], 400);
            }

            $fromEmail = $validated['from'];
            $fromName = $this->getSenderName($sender, $fromEmail);

            // Store email record
            $email = Email::create([
                'pseudo_record_id' => $sender->id,
                'thread_id' => md5($validated['subject'] . $fromEmail . time()),
                'message_id' => null,
                'from_email' => $fromEmail,
                'from_name' => $fromName,
                'to' => json_encode($toEmails),
                'cc' => json_encode($ccEmails),
                'bcc' => json_encode($bccEmails),
                'subject' => $validated['subject'],
                'body_html' => null,
                'body_text' => null,
                'imap_uid' => null,
                'imap_folder' => 'Sent',
                'type' => 'outgoing',
                'folder' => 'sent',
                'is_read' => true,
                'message_date' => now(),
                'received_at' => now(),
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

            // Configure SMTP
            $smtpRecord = $sender->imap_type === 'smtp'
                ? $sender
                : UserPseudoRecord::where('pseudo_email', $sender->pseudo_email)
                    ->where('imap_type', 'smtp')
                    ->first();
            $smtpCredentials = $smtpRecord ?? $sender;

            if (empty($smtpCredentials->server_host) || empty($smtpCredentials->server_password)) {
                throw new \Exception('Missing SMTP host or password');
            }

            Config::set('mail.mailers.smtp', [
                'transport' => 'smtp',
                'host' => $smtpCredentials->server_host,
                'port' => $smtpCredentials->server_port ?? 465,
                'encryption' => $smtpCredentials->server_encryption ?? 'ssl',
                'username' => $smtpCredentials->server_username ?? $smtpCredentials->pseudo_email,
                'password' => $smtpCredentials->server_password,
                'timeout' => null,
                'auth_mode' => null,
            ]);
            Config::set('mail.default', 'smtp');
            Config::set('mail.from', ['address' => $fromEmail, 'name' => $fromName]);

            // Create Mailable instance
            $mailable = new OutgoingEmail(
                subject: $validated['subject'],
                content: $validated['email_content'],
                toEmails: $toEmails,
                ccEmails: $ccEmails,
                bccEmails: $bccEmails,
                fromEmail: $fromEmail,
                fromName: $fromName,
                attachments: $storedAttachments,
                emailId: $email->id
            );

            // Render content for storage
            try {
                $mailable->build(); // Ensure content is rendered
                $email->update([
                    'body_html' => $mailable->renderedHtml,
                    'body_text' => $mailable->renderedText,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to render email content', [
                    'error' => $e->getMessage(),
                    'email_id' => $email->id,
                    'subject' => $validated['subject'],
                ]);
                throw new \Exception('Failed to render email template: ' . $e->getMessage());
            }

            // Queue the email
            Mail::queue($mailable);

            Log::info('Email queued for sending', [
                'email_id' => $email->id,
                'from' => $fromEmail,
                'to' => $toEmails,
                'subject' => $validated['subject'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email queued for sending',
                'email_id' => $email->id,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Email sending failed', [
                'error' => $e->getMessage(),
                'from' => $validated['from'] ?? null,
                'to' => $validated['to'] ?? null,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to queue email. Please try again.',
            ], 500);
        }
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

    private function parseEmailList(?string $emails): array
    {
        if (empty($emails)) {
            return [];
        }
        $parsed = json_decode($emails, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ValidationException('Invalid email list format');
        }
        return is_array($parsed) ? array_filter($parsed) : [];
    }
}
