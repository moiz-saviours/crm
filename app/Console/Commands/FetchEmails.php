<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserPseudoRecord;
use App\Models\Email;
use App\Models\EmailAttachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FetchEmails extends Command
{
    protected $signature = 'emails:fetch {--limit=10 : Number of emails to fetch} {--account= : Specific account ID} {--new-only : Fetch only new emails}';
    protected $description = 'Fetch emails from IMAP accounts using PHP IMAP extension';

    private $imapConnection;
    private $baseMailboxString;

    public function handle()
    {
        try {
            $limit = (int) $this->option('limit');
            $accountId = $this->option('account');
            $newOnly = $this->option('new-only');

            // Get active IMAP accounts
            $query = UserPseudoRecord::where('imap_type', 'imap')
                ->where('status', 1)
                ->where('is_verified', 1)
                ->whereNotNull('server_host')
                ->whereNotNull('server_username')
                ->whereNotNull('server_password');

            if ($accountId) {
                $query->where('id', $accountId);
            }

            $accounts = $query->get();

            if ($accounts->isEmpty()) {
                $this->error('No active IMAP accounts found.');
                return 0;
            }

            foreach ($accounts as $account) {
                $this->info("Fetching emails for account: {$account->pseudo_email}");
                $this->fetchAccountEmails($account, $limit, $newOnly);
            }

            $this->info('Email fetching completed.');
            return 1;
        } catch (\Exception $e) {
            $this->error('Fatal error in email fetching: ' . $e->getMessage());
            Log::error('Fatal IMAP Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine()
            ]);
            return 0;
        } finally {
            if ($this->imapConnection && is_resource($this->imapConnection)) {
                imap_close($this->imapConnection);
                $this->imapConnection = null;
            }
        }
    }

    private function fetchAccountEmails(UserPseudoRecord $account, int $limit, bool $newOnly = false)
    {
        try {
            // Connect to IMAP server
            $this->connectImap($account);

            if (!$this->imapConnection) {
                $this->error("Failed to connect to IMAP server for {$account->pseudo_email}");
                return;
            }

            // Get mailbox list
            $folders = $this->getMailboxes();

            if (empty($folders)) {
                $this->error("No mailboxes found for {$account->pseudo_email}");
                return;
            }

            foreach ($folders as $folder) {
                try {
                    $this->info("Checking folder: {$folder}");
                    $this->fetchAllEmails($account, $folder, $limit);
                } catch (\Exception $e) {
                    $this->error("Error processing folder {$folder}: " . $e->getMessage());
                    Log::error('IMAP Folder Error', [
                        'account' => $account->id,
                        'folder' => $folder,
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }
        } catch (\Exception $e) {
            $this->error("Error fetching emails for {$account->pseudo_email}: " . $e->getMessage());
            Log::error('IMAP Fetch Error', [
                'account' => $account->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function connectImap(UserPseudoRecord $account): void
    {
        try {
            $port = $account->server_port ?: 993;

            $this->baseMailboxString = sprintf(
                '{%s:%d/imap/ssl/novalidate-cert}',
                $account->server_host,
                $port
            );

            // Clear any previous IMAP errors
            imap_errors();

            // Open INBOX first
            $this->imapConnection = @imap_open(
                $this->baseMailboxString . 'INBOX',
                $account->server_username,
                $account->server_password,
                OP_READONLY,
                1
            );

            if (!$this->imapConnection) {
                $lastError = imap_last_error();
                throw new \Exception("IMAP connection failed: " . ($lastError ?: 'Unknown error'));
            }

            $this->info("Successfully connected to IMAP server for {$account->pseudo_email}");
        } catch (\Exception $e) {
            $this->error("IMAP connection error: " . $e->getMessage());
            throw $e;
        }
    }

    private function getMailboxes(): array
    {
        try {
            return @imap_list($this->imapConnection, $this->baseMailboxString, '*') ?: [];
        } catch (\Exception $e) {
            $this->error("Error getting mailboxes: " . $e->getMessage());
            return [];
        }
    }

    private function fetchUnseenEmails(UserPseudoRecord $account, string $folder, int $limit)
    {
        try {
            // Search for unseen emails
            $emails = @imap_search($this->imapConnection, 'UNSEEN');

            if (!$emails) {
                $this->info("No new emails in folder: " . basename($folder));
                return;
            }

            // Limit results
            $emails = array_slice($emails, 0, $limit);

            $this->info("Found " . count($emails) . " new emails in " . basename($folder));

            foreach ($emails as $emailNumber) {
                $this->processEmail($account, $folder, $emailNumber);
            }
        } catch (\Exception $e) {
            $this->error("Error fetching new emails: " . $e->getMessage());
            Log::error('Fetch New Emails Error', [
                'account' => $account->id,
                'folder' => $folder,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function fetchAllEmails(UserPseudoRecord $account, string $folder, int $limit)
    {
        try {
            for ($i = 1; $i <= $limit; $i++) {
                $this->processEmail($account, $folder, $i);
            }
        } catch (\Exception $e) {
            $this->error("Error fetching all emails: " . $e->getMessage());
            Log::error('Fetch All Emails Error', [
                'account' => $account->id,
                'folder' => $folder,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function processEmail(UserPseudoRecord $account, string $folder, int $count)
    {
        try {
            // Get email overview
            $overview = @imap_fetch_overview($this->imapConnection, $count, 0);
            $this->info(json_encode($overview));
            if (!$overview || !isset($overview)) {
                $this->error("No overview for email #{$count}");
                return;
            }
            $overview = $overview[0];

            // // Check if email already exists
            if (isset($overview->message_id)) {
                $existingEmail = Email::where('message_id', $overview->message_id)
                    ->where('pseudo_record_id', $account->id)
                    ->first();

                if ($existingEmail) {
                    $this->info("Email already exists: " . ($overview->subject ?? 'No Subject'));
                    return;
                }
            }

            // Get full email headers
            $headers = @imap_headerinfo($this->imapConnection, $count);

            if (!$headers) {
                $this->error("Failed to get headers for email #{$count}");
                return;
            }

            // Validate required header fields
            if (!isset($headers->from) || !is_array($headers->from) || empty($headers->from)) {
                $this->error("Invalid or missing 'from' header for email #{$count}");
                return;
            }

            // Get email body and structure
            $structure = @imap_fetchstructure($this->imapConnection, $count);
            $body = $this->getEmailBody($count, $structure);

            // Determine email type and folder
            $emailType = $this->determineEmailType($headers, $account);
            $emailFolder = $this->determineEmailFolder($folder);

            // Get UID safely
            $uid = @imap_uid($this->imapConnection, $count);

            // Create email record
            $email = Email::create([
                'pseudo_record_id' => $account->id,
                'thread_id' => $this->generateThreadId($headers),
                'message_id' => $overview->message_id ?? null,
                'in_reply_to' => $overview->in_reply_to ?? null,
                'references' => $overview->references ?? null,
                'from_email' => $headers->from[0]->mailbox . '@' . $headers->from[0]->host,
                'from_name' => $headers->from[0]->personal ?? null,
                'to' => $this->parseAddresses($headers->to ?? null),
                'cc' => $this->parseAddresses($headers->cc ?? null),
                'bcc' => $this->parseAddresses($headers->bcc ?? null),
                'subject' => $overview->subject ?? 'No Subject',
                'body_html' => $body['html'] ?? null,
                'body_text' => $body['text'] ?? null,
                'imap_uid' => $uid ?: null,
                'imap_folder' => $folder,
                'imap_flags' => $this->getImapFlags($overview),
                'type' => $emailType,
                'folder' => $emailFolder,
                'is_read' => isset($overview->seen) && $overview->seen,
                'message_date' => $this->parseMessageDate($overview->date ?? null),
                'received_at' => now(),
            ]);

            // Process attachments
            if ($structure) {
                $this->processAttachments($count, $structure, $email);
            }

            $this->info("Stored email: " . ($overview->subject ?? 'No Subject'));
        } catch (\Exception $e) {
            $this->error("Error processing email #{$count}: " . $e->getMessage());
            Log::error('Email Processing Error', [
                'account' => $account->id,
                'email_number' => $count,
                'folder' => $folder,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }




    private function parseMessageDate($date): string
    {
        try {
            if (empty($date)) {
                return now()->format('Y-m-d H:i:s');
            }

            $timestamp = strtotime($date);
            if ($timestamp === false) {
                return now()->format('Y-m-d H:i:s');
            }

            return date('Y-m-d H:i:s', $timestamp);
        } catch (\Exception $e) {
            Log::warning('Date parsing error', ['date' => $date, 'error' => $e->getMessage()]);
            return now()->format('Y-m-d H:i:s');
        }
    }

    private function getEmailBody(int $emailNumber, $structure)
    {
        $body = ['html' => null, 'text' => null];

        try {
            if (!$structure || !isset($structure->parts)) {
                // Simple email, no attachments
                $content = @imap_body($this->imapConnection, $emailNumber);

                if ($content === false) {
                    return $body;
                }

                if (isset($structure->type) && $structure->type == 0) {
                    if (isset($structure->subtype)) {
                        if (strtoupper($structure->subtype) == 'HTML') {
                            $body['html'] = $content;
                        } else {
                            $body['text'] = $content;
                        }
                    } else {
                        $body['text'] = $content;
                    }
                }

                return $body;
            }

            // Multipart email
            foreach ($structure->parts as $partNumber => $part) {
                $partNumber++; // Part numbers start from 1

                try {
                    if (isset($part->type) && $part->type == 0) { // Text content
                        $content = @imap_fetchbody($this->imapConnection, $emailNumber, $partNumber);

                        if ($content === false) {
                            continue;
                        }

                        // Decode content
                        if (isset($part->encoding)) {
                            if ($part->encoding == 3) {
                                $content = imap_base64($content);
                            } elseif ($part->encoding == 4) {
                                $content = imap_qprint($content);
                            }
                        }

                        if (isset($part->subtype)) {
                            if (strtoupper($part->subtype) == 'HTML') {
                                $body['html'] = $content;
                            } elseif (strtoupper($part->subtype) == 'PLAIN') {
                                $body['text'] = $content;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning('Error processing email part', [
                        'email_number' => $emailNumber,
                        'part_number' => $partNumber,
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }
        } catch (\Exception $e) {
            Log::error('Email body extraction error', [
                'email_number' => $emailNumber,
                'error' => $e->getMessage()
            ]);
        }

        return $body;
    }

    private function processAttachments(int $emailNumber, $structure, Email $email)
    {
        try {
            if (!isset($structure->parts) || !is_array($structure->parts)) {
                return;
            }

            foreach ($structure->parts as $partNumber => $part) {
                $partNumber++; // Part numbers start from 1

                try {
                    if (!isset($part->ifdparameters) && !isset($part->ifparameters)) {
                        continue;
                    }

                    $filename = null;

                    // Get filename from parameters
                    if (isset($part->ifdparameters) && $part->ifdparameters && isset($part->dparameters)) {
                        foreach ($part->dparameters as $param) {
                            if (
                                isset($param->attribute) && isset($param->value) &&
                                strtolower($param->attribute) == 'filename'
                            ) {
                                $filename = $param->value;
                                break;
                            }
                        }
                    }

                    if (!$filename && isset($part->ifparameters) && $part->ifparameters && isset($part->parameters)) {
                        foreach ($part->parameters as $param) {
                            if (
                                isset($param->attribute) && isset($param->value) &&
                                strtolower($param->attribute) == 'name'
                            ) {
                                $filename = $param->value;
                                break;
                            }
                        }
                    }

                    if ($filename && isset($part->type) && $part->type != 0) { // Not text content
                        $content = @imap_fetchbody($this->imapConnection, $emailNumber, $partNumber);

                        if ($content === false) {
                            continue;
                        }

                        // Decode content
                        if (isset($part->encoding)) {
                            if ($part->encoding == 3) {
                                $content = imap_base64($content);
                            } elseif ($part->encoding == 4) {
                                $content = imap_qprint($content);
                            }
                        }

                        // Sanitize filename
                        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
                        $storagePath = 'attachments/' . $email->id . '/' . uniqid() . '_' . $filename;

                        // Store attachment
                        if (Storage::put($storagePath, $content)) {
                            EmailAttachment::create([
                                'email_id' => $email->id,
                                'original_name' => $filename,
                                'storage_name' => basename($storagePath),
                                'mime_type' => $this->getMimeType($part),
                                'size' => strlen($content),
                                'storage_path' => $storagePath,
                                'content_id' => $part->id ?? null,
                                'is_inline' => isset($part->disposition) && $part->disposition == 'inline',
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning('Attachment processing error', [
                        'email_id' => $email->id,
                        'part_number' => $partNumber,
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }
        } catch (\Exception $e) {
            Log::error('Attachments processing error', [
                'email_id' => $email->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function getMimeType($part)
    {
        try {
            $typeMap = [
                0 => 'text/plain',
                1 => 'text/multipart',
                2 => 'message/rfc822',
                3 => 'application/octet-stream',
                4 => 'application/octet-stream',
                5 => 'application/octet-stream',
            ];

            return $typeMap[$part->type ?? 3] ?? 'application/octet-stream';
        } catch (\Exception $e) {
            return 'application/octet-stream';
        }
    }

    private function determineEmailType($headers, UserPseudoRecord $account): string
    {
        try {
            if (!isset($headers->from) || !is_array($headers->from) || empty($headers->from)) {
                return 'incoming';
            }

            $fromEmail = $headers->from[0]->mailbox . '@' . $headers->from[0]->host;

            if ($fromEmail === $account->pseudo_email) {
                return 'outgoing';
            }

            return 'incoming';
        } catch (\Exception $e) {
            return 'incoming';
        }
    }

    private function determineEmailFolder(string $imapFolder): string
    {
        try {
            $folderMap = [
                'INBOX' => 'inbox',
                'Sent' => 'sent',
                'Sent Items' => 'sent',
                'Drafts' => 'drafts',
                'Spam' => 'spam',
                'Junk' => 'spam',
                'Trash' => 'trash',
                'Deleted' => 'trash',
                'Deleted Items' => 'trash',
                'Archive' => 'archive',
            ];

            $folderName = basename($imapFolder);
            return $folderMap[$folderName] ?? 'inbox';
        } catch (\Exception $e) {
            return 'inbox';
        }
    }

    private function generateThreadId($headers): string
    {
        try {
            if (isset($headers->in_reply_to) && $headers->in_reply_to) {
                return md5($headers->in_reply_to);
            }

            if (isset($headers->references) && $headers->references) {
                $refs = explode(' ', $headers->references);
                if (!empty($refs)) {
                    return md5($refs[0]);
                }
            }

            $subject = isset($headers->subject) ? $headers->subject : 'No Subject';
            $from = '';

            if (isset($headers->from) && is_array($headers->from) && !empty($headers->from)) {
                $from = $headers->from[0]->mailbox . '@' . $headers->from[0]->host;
            }

            return md5($subject . $from . time());
        } catch (\Exception $e) {
            return md5('default_thread_' . time() . rand(1000, 9999));
        }
    }

    private function parseAddresses($addresses): ?array
    {
        try {
            if (!$addresses || !is_array($addresses)) {
                return null;
            }

            $result = [];
            foreach ($addresses as $address) {
                if (isset($address->mailbox) && isset($address->host)) {
                    $result[] = [
                        'email' => $address->mailbox . '@' . $address->host,
                        'name' => $address->personal ?? null
                    ];
                }
            }

            return empty($result) ? null : $result;
        } catch (\Exception $e) {
            Log::warning('Address parsing error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function getImapFlags($overview): array
    {
        try {
            return [
                'seen' => isset($overview->seen) && $overview->seen,
                'answered' => isset($overview->answered) && $overview->answered,
                'flagged' => isset($overview->flagged) && $overview->flagged,
                'deleted' => isset($overview->deleted) && $overview->deleted,
                'draft' => isset($overview->draft) && $overview->draft,
            ];
        } catch (\Exception $e) {
            return [
                'seen' => false,
                'answered' => false,
                'flagged' => false,
                'deleted' => false,
                'draft' => false,
            ];
        }
    }

    public function __destruct()
    {
        try {
            if ($this->imapConnection && is_resource($this->imapConnection)) {
                imap_close($this->imapConnection);
                $this->imapConnection = null;
            }
        } catch (\Exception $e) {
            // Silently handle cleanup errors
        }
    }
}
