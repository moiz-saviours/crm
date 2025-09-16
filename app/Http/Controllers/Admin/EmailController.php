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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Artisan;
class EmailController extends Controller
{
public function fetch(Request $request)
    {
        try {
            $customerEmail = $request->query('customer_email');
            $folder = $request->query('folder', 'inbox');
            $page = (int) $request->query('page', 1);
            $limit = (int) $request->query('limit', 100);
            $offset = ($page - 1) * $limit;

            // Log the request parameters for debugging
            Log::info('Fetching emails from database', [
                'customer_email' => $customerEmail,
                'folder' => $folder,
                'page' => $page,
                'limit' => $limit,
            ]);

            if (!$customerEmail) {
                return response()->json(['error' => 'Customer email is required'], 400);
            }

            // Fetch emails from the database
            $query = Email::where(function ($q) use ($customerEmail, $folder) {
                // Include sent emails (outgoing) where customerEmail is the sender for 'sent' or 'all' folders
                if ($folder === 'sent' || $folder === 'all') {
                    $q->orWhere(function ($subQ) use ($customerEmail) {
                        $subQ->where('from_email', $customerEmail)
                             ->where('type', 'outgoing');
                    });
                }
                // Include received emails where customerEmail is in to, cc, or bcc
                $q->orWhereJsonContains('to', [['email' => $customerEmail]])
                  ->orWhereJsonContains('cc', [['email' => $customerEmail]])
                  ->orWhereJsonContains('bcc', [['email' => $customerEmail]]);
            });

            // Filter by folder if specified
            // if ($folder !== 'all') {
            //     $query->where('folder', $folder);
            // }
            
            // Apply pagination
            $emails = $query->orderBy('message_date', 'desc')
                ->skip($offset)
                ->take($limit)
                ->with(['attachments' => function ($q) {
                    $q->select('id', 'email_id', 'original_name as filename', 'size', 'mime_type as type', 'storage_path');
                }])
                ->get()
                ->map(function ($email) {
                    // Format email data to match the expected structure for the view
                    return [
                        'uuid' => 'email-' . $email->id,
                        'from' => [
                            [
                                'name' => $email->from_name,
                                'email' => $email->from_email,
                            ],
                        ],
                        'to' => $email->to ?? [],
                        'subject' => $email->subject,
                        'date' => $email->message_date,
                        'body' => [
                            'html' => $email->body_html,
                            'text' => $email->body_text,
                        ],
                        'attachments' => $email->attachments->map(function ($attachment) {
                            return [
                                'filename' => $attachment->filename,
                                'type' => $attachment->type,
                                'size' => $attachment->size,
                                'download_url' => $attachment->storage_path ? Storage::url($attachment->storage_path) : null,
                            ];
                        })->toArray(),
                    ];
                });

            // Get available folders from the database
            $folders = Email::where(function ($q) use ($customerEmail) {
                $q->where('from_email', $customerEmail)
                  ->orWhereJsonContains('to', [['email' => $customerEmail]])
                  ->orWhereJsonContains('cc', [['email' => $customerEmail]])
                  ->orWhereJsonContains('bcc', [['email' => $customerEmail]]);
            })
                ->distinct()
                ->pluck('folder')
                ->filter()
                ->values()
                ->toArray();
            return response()->json([
                'emails' => $emails,
                'folders' => $folders,
                'folder' => $folder,
                'page' => $page,
                'limit' => $limit,
            ]);
        } catch (\Exception $e) {
            Log::error('Something went wrong please try again', [
                'error' => $e->getMessage(),
                'customer_email' => $customerEmail,
                'folder' => $folder,
            ]);
            return response()->json(['error' => 'Failed to fetch emails. Please try again later.'], 500);
        }
    }

    public function fetchNewEmails(Request $request)
    {
        try {
            $customerEmail = $request->query('customer_email');
            if (!$customerEmail) {
                return response()->json(['error' => 'Customer email is required'], 400);
            }
            // Get current user's pseudo emails
            $pseudoEmails = UserPseudoRecord::where('morph_id', auth()->id())
                ->where('imap_type', 'imap')
                ->pluck('pseudo_email')
                ->toArray();

            if (empty($pseudoEmails)) {
                return response()->json(['error' => 'No IMAP accounts found for the current user'], 400);
            }

            // Build the Artisan command
            $command = ['emails:fetch', '--address=' . $customerEmail];
            foreach ($pseudoEmails as $email) {
                $command[] = '--account=' . $email;
            }

            // Run the Artisan command
            $exitCode = Artisan::call(implode(' ', $command));

            if ($exitCode !== 0) {
                Log::error('Failed to run emails:fetch command', [
                    'customer_email' => $customerEmail,
                    'pseudo_emails' => $pseudoEmails,
                    'exit_code' => $exitCode,
                ]);
                return response()->json(['error' => 'Failed to fetch new emails'], 500);
            }

            return response()->json(['success' => true, 'message' => 'New emails fetched successfully']);
        } catch (\Exception $e) {
            Log::error('Error fetching new emails', [
                'customer_email' => $customerEmail,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Failed to fetch new emails. Please try again later.'], 500);
        }
    }

    public function sendEmail(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'email_content' => 'required|string',
            'to' => 'required|string',
            'from' => 'required|email',
            'cc' => 'sometimes|string|nullable',
            'bcc' => 'sometimes|string|nullable',
            'attachments.*' => 'sometimes|file|mimes:pdf,doc,docx,jpg,png,zip|max:10240', // 10MB max per file
        ]);

        try {
            $sender = $this->findSender($request->from);
            if (!$sender) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sender not authorized or not found'
                ], 403);
            }

            // Check if sender is UserPseudoRecord and has SMTP credentials
            if (!$sender instanceof UserPseudoRecord || empty($sender->server_password) || empty($sender->server_host)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or missing SMTP credentials for sender'
                ], 403);
            }

            $toEmails = $this->parseEmailList($request->to);
            $ccEmails = $this->parseEmailList($request->cc);
            $bccEmails = $this->parseEmailList($request->bcc);

            if (empty($toEmails)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid recipients specified'
                ], 400);
            }

            $fromEmail = $request->from;
            $fromName = $this->getSenderName($sender, $fromEmail);

            // Parse addresses for storage
            $parsedTo = $this->parseEmailListForStorage($toEmails);
            $parsedCc = $this->parseEmailListForStorage($ccEmails);
            $parsedBcc = $this->parseEmailListForStorage($bccEmails);

            // Handle attachments
            $attachments = null;
            $storedAttachments = [];
            if ($request->hasFile('attachments')) {
                $attachmentsDir = 'attachments/outgoing/' . uniqid();
                foreach ($request->file('attachments') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $storageName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
                    $storagePath = $attachmentsDir . '/' . $storageName;
                    if (Storage::put($storagePath, file_get_contents($file->getRealPath()))) {
                        $mimeType = $file->getMimeType();
                        $storedAttachments[] = [
                            'original_name' => $originalName,
                            'storage_name' => $storageName,
                            'storage_path' => $storagePath,
                            'size' => $file->getSize(),
                            'mime_type' => $mimeType,
                        ];
                    }
                }
                $attachments = $storedAttachments;
            }

            // Store email in database as outgoing
            $email = Email::create([
                'pseudo_record_id' => $sender->id,
                'thread_id' => md5($validated['subject'] . $fromEmail . time()),
                'message_id' => null,
                'from_email' => $fromEmail,
                'from_name' => $fromName,
                'to' => $parsedTo,
                'cc' => $parsedCc,
                'bcc' => $parsedBcc,
                'subject' => $validated['subject'],
                'body_html' => $validated['email_content'],
                'body_text' => strip_tags($validated['email_content']),
                'imap_uid' => null,
                'imap_folder' => 'Sent',
                'type' => 'outgoing',
                'folder' => 'sent',
                'is_read' => true,
                'message_date' => now(),
                'received_at' => now(),
            ]);

            // Store attachments if any
            if (!empty($storedAttachments)) {
                foreach ($storedAttachments as $att) {
                    EmailAttachment::create([
                        'email_id' => $email->id,
                        'original_name' => $att['original_name'],
                        'storage_name' => $att['storage_name'],
                        'size' => $att['size'],
                        'storage_path' => $att['storage_path'],
                        'mime_type' => $att['mime_type'],
                    ]);
                }
            }

            // Send the email using PHPMailer with SMTP credentials
            $this->sendMail(
                $validated,
                $toEmails,
                $fromEmail,
                $fromName,
                $ccEmails,
                $bccEmails,
                $attachments,
                $sender
            );

            Log::info('Email sent and stored successfully', [
                'email_id' => $email->id,
                'from' => $fromEmail,
                'to' => $toEmails,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully',
                'email_id' => $email->id,
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Email sending failed', [
                'error' => $e->getMessage(),
                'from' => $request->from ?? null,
                'to' => $request->to ?? null,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Please try again.'
            ], 500);
        }
    }

    private function sendMail(
        array $validated,
        array $toEmails,
        string $fromEmail,
        string $fromName,
        array $ccEmails,
        array $bccEmails,
        ?array $attachments = null,
        UserPseudoRecord $sender
    ): void {
        // Look for SMTP-specific credentials if available
        $smtpRecord = $sender->imap_type === 'smtp'
            ? $sender
            : UserPseudoRecord::where('pseudo_email', $sender->pseudo_email)
                ->where('imap_type', 'smtp')
                ->first();

        $smtpCredentials = $smtpRecord ?? $sender;

        // Validate SMTP credentials
        if (empty($smtpCredentials->server_host) || empty($smtpCredentials->server_password)) {
            throw new Exception('Missing SMTP host or password');
        }

        // Initialize PHPMailer
        $mailer = new PHPMailer(true);
        try {
            // Server settings
            $mailer->isSMTP();
            $mailer->Host = $smtpCredentials->server_host;
            $mailer->Port = 465;
            $mailer->SMTPSecure = 'ssl';
            $mailer->SMTPAuth = true;
            $mailer->Username = $smtpCredentials->server_username ?? $smtpCredentials->pseudo_email;
            $mailer->Password = $smtpCredentials->server_password;

            // Sender and recipients
            $mailer->setFrom($fromEmail, $fromName);
            $mailer->addReplyTo($fromEmail, $fromName);
            $mailer->addCustomHeader('Return-Path', $fromEmail);

            foreach ($toEmails as $toEmail) {
                $mailer->addAddress($toEmail);
            }

            foreach ($ccEmails as $ccEmail) {
                $mailer->addCC($ccEmail);
            }

            foreach ($bccEmails as $bccEmail) {
                $mailer->addBCC($bccEmail);
            }

            // Attachments
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $mailer->addAttachment(
                        Storage::path($attachment['storage_path']),
                        $attachment['original_name'],
                        'base64',
                        $attachment['mime_type']
                    );
                }
            }

            // Content
            $mailer->isHTML(true);
            $mailer->Subject = $validated['subject'];
            $mailer->Body = $validated['email_content'];
            $mailer->AltBody = strip_tags($validated['email_content']);

            // Send the email
            $mailer->send();

        } catch (Exception $e) {
            throw new Exception('PHPMailer error: ' . $mailer->ErrorInfo);
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
        return Admin::where('email', $email)
            ->orWhere('pseudo_email', $email)
            ->first()
            ?? User::where('email', $email)
            ->orWhere('pseudo_email', $email)
            ->first()
            ?? UserPseudoRecord::where('pseudo_email', $email)
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
        return is_array($parsed) ? array_filter($parsed) : [];
    }
}