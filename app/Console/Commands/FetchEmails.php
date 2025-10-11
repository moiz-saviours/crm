<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserPseudoRecord;
use App\Models\Email;
use App\Models\EmailAttachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Illuminate\Support\Str;

class FetchEmails extends Command
{
    protected $signature = 'emails:fetch {--limit=100} {--account=*} {--new-only} {--address=*}';
    protected $description = 'Fetch emails from IMAP accounts';

    private $imapConnection;
    private $baseMailboxString;

    public function handle()
    {
        ini_set('max_execution_time', 300);
        $startTime = microtime(true);
        $this->info('Starting email fetch process...');

        try {
            $accounts = $this->getAccounts();

            if ($accounts->isEmpty()) {
                $this->error('No active IMAP accounts found.');
                return 0;
            }

            $this->line("Found {$accounts->count()} active IMAP accounts.");
            foreach ($accounts as $account) {
                $this->info("Fetching emails for: {$account->pseudo_email}");
                $this->fetchAccountEmails($account);
            }

            $endTime = microtime(true);
            $totalTime = round($endTime - $startTime, 2);
            $this->info("Email fetch process completed successfully. Total time taken: {$totalTime} seconds.");
            return 1;
        } catch (\Exception $e) {
            $this->error("Something went wrong please try again");
            Log::error('IMAP Fatal Error', ['error' => $e->getMessage()]);
            return 0;
        } finally {
            $this->closeConnection();
            $endTime = microtime(true);
            $totalTime = round($endTime - $startTime, 2);
            $this->info("Total time taken by command: {$totalTime} seconds.");
        }
    }

    private function getAccounts()
    {
        $this->line('Retrieving active IMAP accounts...');

        // Require --account option, otherwise return nothing
        $accountEmails = (array) $this->option('account');
        if (empty($accountEmails)) {
            $this->warn("No account emails provided via --account option.");
            return collect();
        }

        $accounts = UserPseudoRecord::where('imap_type', 'imap')
            ->where('status', 1)
            ->where('is_verified', 1)
            ->whereNotNull(['server_host', 'server_username', 'server_password'])
            ->whereIn('pseudo_email', $accountEmails)
            ->get();

        if ($accounts->isEmpty()) {
            $this->warn("No matching accounts found for the provided criteria.");
        }

        return $accounts;
    }


    //GET ALL FOLDERS
    private function fetchAccountEmails(UserPseudoRecord $account)
    {
        $startTime = microtime(true);
        $this->line("Connecting to IMAP server for {$account->pseudo_email}...");

        try {
            $this->connectImap($account);

            $this->line('Fetching available folders...');
            $folders = @imap_list($this->imapConnection, $this->baseMailboxString, '*') ?: [];
            $this->comment("Found " . count($folders) . " folders for {$account->pseudo_email}");

            foreach ($folders as $folder) {
                $this->line("Processing folder: {$folder}");
                $this->fetchFolderEmails($account, $folder);
            }

            $endTime = microtime(true);
            $accountTime = round($endTime - $startTime, 2);
            $this->comment("Completed processing for {$account->pseudo_email}. Time taken: {$accountTime} seconds.");
        } catch (\Exception $e) {
            $this->error("Error for {$account->pseudo_email}: {$e->getMessage()}");
            Log::error('IMAP Account Error', ['account' => $account->id, 'error' => $e->getMessage()]);
            $endTime = microtime(true);
            $accountTime = round($endTime - $startTime, 2);
            $this->comment("Processing for {$account->pseudo_email} failed. Time taken: {$accountTime} seconds.");
        }
    }

    //GET INBOX ONLY

    //     private function fetchAccountEmails(UserPseudoRecord $account)
    // {
    //     $startTime = microtime(true);
    //     $this->line("Connecting to IMAP server for {$account->pseudo_email}...");

    //     try {
    //         $this->connectImap($account);

    //         // Only fetch INBOX
    //         $inbox = $this->baseMailboxString . 'INBOX';
    //         $this->line("Processing folder: {$inbox}");
    //         $this->fetchFolderEmails($account, $inbox);

    //         $endTime = microtime(true);
    //         $accountTime = round($endTime - $startTime, 2);
    //         $this->comment("Completed processing for {$account->pseudo_email}. Time taken: {$accountTime} seconds.");
    //     } catch (\Exception $e) {
    //         $this->error("Error for {$account->pseudo_email}: {$e->getMessage()}");
    //         Log::error('IMAP Account Error', ['account' => $account->id, 'error' => $e->getMessage()]);
    //         $endTime = microtime(true);
    //         $accountTime = round($endTime - $startTime, 2);
    //         $this->comment("Processing for {$account->pseudo_email} failed. Time taken: {$accountTime} seconds.");
    //     }
    // }


    private function connectImap(UserPseudoRecord $account)
    {
        $port = $account->server_port ?: 993;
        $this->baseMailboxString = sprintf('{%s:%d/imap/ssl/novalidate-cert}', $account->server_host, $port);

        $this->line("Attempting IMAP connection to {$account->server_host}:{$port}");
        $this->imapConnection = @imap_open(
            $this->baseMailboxString . 'INBOX',
            $account->server_username,
            $account->server_password,
            OP_READONLY
        );

        if (!$this->imapConnection) {
            throw new \Exception("IMAP connection failed: " . imap_last_error());
        }
        $this->comment('IMAP connection established successfully.');
    }

    private function fetchFolderEmails(UserPseudoRecord $account, string $folder)
    {
        $limit = (int) $this->option('limit');
        $newOnly = $this->option('new-only');
        $addresses = $this->option('address') ?: [];

        $this->line("Opening folder: {$folder}");
        if (!@imap_reopen($this->imapConnection, $folder)) {
            $this->error("Failed to open folder: {$folder}. Error: " . imap_last_error());
            return;
        }

        $totalEmails = imap_num_msg($this->imapConnection);
        $this->line("Total emails in folder: {$totalEmails}");

        if ($totalEmails == 0) {
            $this->comment("No emails found in folder: {$folder}");
            return;
        }

        $emails = [];
        if ($newOnly && empty($addresses)) {
            $this->line("Searching for unseen emails (limit: {$limit})...");
            $emails = @imap_search($this->imapConnection, 'UNSEEN') ?: [];
            $emails = array_slice($emails, 0, $limit);
            $this->comment("Found " . count($emails) . " unseen emails.");
        } elseif (empty($addresses)) {
            $this->line("Fetching recent emails (limit: {$limit}, total: {$totalEmails})...");
            $start = max(1, $totalEmails - $limit + 1);
            $emails = range($start, $totalEmails);
            $this->comment("Processing " . count($emails) . " recent emails.");
        } else {
            $this->line("Searching for emails with addresses: " . implode(', ', $addresses));
            $searchEmails = [];
            foreach ($addresses as $address) {
                $fromSearch = @imap_search($this->imapConnection, "FROM \"$address\"") ?: [];
                $toSearch = @imap_search($this->imapConnection, "TO \"$address\"") ?: [];
                $ccSearch = @imap_search($this->imapConnection, "CC \"$address\"") ?: [];
                $bccSearch = @imap_search($this->imapConnection, "BCC \"$address\"") ?: [];
                $searchEmails = array_unique(array_merge($searchEmails, $fromSearch, $toSearch, $ccSearch, $bccSearch));
            }
            if ($newOnly) {
                $this->line("Filtering for unseen emails among address matches...");
                $unseenEmails = @imap_search($this->imapConnection, 'UNSEEN') ?: [];
                $searchEmails = array_intersect($searchEmails, $unseenEmails);
            }
            $emails = array_slice($searchEmails, 0, $limit);
            $this->comment("Found " . count($emails) . " emails matching addresses" . ($newOnly ? " (unseen only)" : "") . ".");
        }

        if (empty($emails)) {
            $this->comment("No emails to process in folder: {$folder}");
            return;
        }

        foreach ($emails as $emailNumber) {
            if ($emailNumber <= 0) {
                $this->warn("Invalid email number: {$emailNumber}. Skipping...");
                continue;
            }
            $this->line("Processing email #{$emailNumber}...");
            $this->processEmail($account, $folder, $emailNumber);
        }
    }
    /**
     * Extract threading headers from raw email headers
     */
    private function extractThreadingHeaders($rawHeaders)
    {
        $threadingHeaders = [
            'in_reply_to' => null,
            'references' => null
        ];

        if (empty($rawHeaders)) {
            return $threadingHeaders;
        }

        // Extract In-Reply-To header
        if (preg_match('/In-Reply-To:\s*(.*)/i', $rawHeaders, $matches)) {
            $threadingHeaders['in_reply_to'] = trim($matches[1]);
        }

        // Extract References header
        if (preg_match('/References:\s*(.*)/i', $rawHeaders, $matches)) {
            $threadingHeaders['references'] = trim($matches[1]);
        }

        return $threadingHeaders;
    }
    private function processEmail(UserPseudoRecord $account, string $folder, int $emailNumber)
    {
        try {
            $this->line("Fetching headers for email #{$emailNumber}");
            $headers = @imap_headerinfo($this->imapConnection, $emailNumber);
            if (!$headers || !isset($headers->from[0])) {
                $this->warn("Skipping email #{$emailNumber}: Invalid headers");
                return;
            }

            $addresses = $this->option('address') ?: [];
            if (!empty($addresses)) {
                $this->line("Validating email #{$emailNumber} against provided addresses...");
                $emailAddresses = [];

                if (isset($headers->from)) {
                    $emailAddresses[] = $headers->from[0]->mailbox . '@' . $headers->from[0]->host;
                }

                if (isset($headers->to)) {
                    $emailAddresses = array_merge(
                        $emailAddresses,
                        array_map(fn($addr) => $addr->mailbox . '@' . $addr->host, $headers->to)
                    );
                }

                if (isset($headers->cc)) {
                    $emailAddresses = array_merge(
                        $emailAddresses,
                        array_map(fn($addr) => $addr->mailbox . '@' . $addr->host, $headers->cc)
                    );
                }

                if (isset($headers->bcc)) {
                    $emailAddresses = array_merge(
                        $emailAddresses,
                        array_map(fn($addr) => $addr->mailbox . '@' . $addr->host, $headers->bcc)
                    );
                }

                $emailAddresses = array_unique($emailAddresses);
                $matches = array_intersect($emailAddresses, $addresses);
                if (empty($matches)) {
                    $this->line("Skipping email #{$emailNumber}: No matching addresses found");
                    return;
                }
                $this->comment("Email #{$emailNumber} matches addresses: " . implode(', ', $matches));
            }

            $overview = @imap_fetch_overview($this->imapConnection, $emailNumber)[0] ?? null;

            // Get raw headers for threading information
            $rawHeaders = @imap_fetchheader($this->imapConnection, $emailNumber);
            $threadingHeaders = $this->extractThreadingHeaders($rawHeaders);

            $this->line("Threading headers found - In-Reply-To: " . ($threadingHeaders['in_reply_to'] ?? 'None') . ", References: " . ($threadingHeaders['references'] ?? 'None'));

            // Normalize message ID for duplicate check
            $normalizedMessageId = $this->normalizeMsgId($overview->message_id ?? '');

            if (!$overview) {
                $this->warn("Skipping email #{$emailNumber}: No overview data");
                return;
            }

            if (
                $normalizedMessageId &&
                Email::where('message_id', $normalizedMessageId)
                ->where('pseudo_record_id', $account->id)
                ->exists()
            ) {
                $this->line("Skipping email #{$emailNumber}: Already exists");
                return;
            }

            $this->line("Fetching structure for email #{$emailNumber}");
            $structure = @imap_fetchstructure($this->imapConnection, $emailNumber);
            $body = $this->getEmailBody($emailNumber, $structure);

            $this->line("Creating email record for #{$emailNumber}");

            // Process HTML body with CssToInlineStyles and strip unwanted tags
            $inlinedHtml = null;
            if (!empty($body['html'])) {
                $cssToInlineStyles = new CssToInlineStyles();
                $inlinedHtml = $cssToInlineStyles->convert($body['html']);
                $this->line("Applied inline CSS to HTML body for email #{$emailNumber}");

                // Use DOMDocument to strip DOCTYPE, html, head, meta, and title tags
                $doc = new \DOMDocument();
                @$doc->loadHTML($inlinedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $bodyTag = $doc->getElementsByTagName('body')->item(0);
                if ($bodyTag) {
                    $inlinedHtml = $doc->saveHTML($bodyTag);
                    $this->line("Stripped DOCTYPE, html, head, meta, and title tags for email #{$emailNumber}");
                } else {
                    $this->warn("No body tag found in HTML for email #{$emailNumber}, keeping inlined HTML");
                }
            }

            // Decode the subject if it's MIME-encoded
            $decodedSubject = $overview->subject ?? 'No Subject';
            if (function_exists('imap_mime_header_decode')) {
                $decodedParts = imap_mime_header_decode($overview->subject);
                $decodedSubject = '';
                foreach ($decodedParts as $part) {
                    $decodedSubject .= $part->text;
                }
            } elseif (function_exists('mb_decode_mimeheader')) {
                $decodedSubject = mb_decode_mimeheader($decodedSubject);
            }

            $email = Email::create([
                'pseudo_record_id' => $account->id,
                'thread_id' => $this->generateThreadId($headers, $decodedSubject),
                'message_id' => $normalizedMessageId,
                'in_reply_to' => $this->normalizeMsgId($threadingHeaders['in_reply_to'] ?? null),
                'references' => $threadingHeaders['references'] ?? null,
                'from_email' => $headers->from[0]->mailbox . '@' . $headers->from[0]->host,
                'from_name' => $headers->from[0]->personal ?? null,
                'to' => $this->parseAddresses($headers->to ?? null),
                'cc' => $this->parseAddresses($headers->cc ?? null),
                'subject' => $decodedSubject,
                'body_html' => $inlinedHtml ?? $body['html'] ?? null,
                'body_text' => $body['text'] ?? null,
                'imap_uid' => @imap_uid($this->imapConnection, $emailNumber),
                'imap_folder' => $folder,
                'type' => $this->getEmailType($headers, $account),
                'folder' => $this->getEmailType($headers, $account) === 'outgoing' ? 'sent' : $this->mapFolder($folder),
                'is_read' => isset($overview->seen) && $overview->seen,
                'message_date' => $this->parseDate($overview->date ?? null),
                'received_at' => now(),
            ]);

            $this->comment("Email #{$emailNumber} saved successfully (ID: {$email->id})");

            if ($structure) {
                $this->line("Processing attachments for email #{$emailNumber}");
                $attachmentCount = $this->processAttachments($emailNumber, $structure, $email);
                if ($attachmentCount > 0) {
                    $this->comment("Processed {$attachmentCount} attachments for email #{$emailNumber}");
                }
            }
        } catch (\Exception $e) {
            $this->error("Error processing email #{$emailNumber}: {$e->getMessage()}");
            Log::error('Email Processing Error', [
                'account' => $account->id,
                'email' => $emailNumber,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function getEmailBody(int $emailNumber, $structure)
    {
        $this->line("Fetching body for email #{$emailNumber}");
        $body = ['html' => null, 'text' => null];

        if (!$structure || !isset($structure->parts)) {
            $content = @imap_body($this->imapConnection, $emailNumber);
            if ($content && isset($structure->subtype)) {
                $body[strtoupper($structure->subtype) == 'HTML' ? 'html' : 'text'] = $content;
                $this->line("Fetched single-part body (type: {$structure->subtype})");
            }
            return $body;
        }

        foreach ($structure->parts as $i => $part) {
            if ($part->type != 0) continue;

            $content = @imap_fetchbody($this->imapConnection, $emailNumber, $i + 1);
            if (!$content) continue;

            if ($part->encoding == 3) {
                $this->line("Decoding base64 content for part " . ($i + 1));
                $content = imap_base64($content);
            }
            if ($part->encoding == 4) {
                $this->line("Decoding quoted-printable content for part " . ($i + 1));
                $content = imap_qprint($content);
            }

            if (isset($part->subtype)) {
                $key = strtoupper($part->subtype) == 'HTML' ? 'html' : 'text';
                $body[$key] = $content;
                $this->line("Stored {$key} content for part " . ($i + 1));
            }
        }

        return $body;
    }

    private function processAttachments(int $emailNumber, $structure, Email $email): int
    {
        $attachmentCount = 0;
        if (!isset($structure->parts) || empty($structure->parts)) {
            $this->line("No parts found in structure for email #{$emailNumber}");
            return $attachmentCount;
        }

        foreach ($structure->parts as $partNumber => $part) {
            // Check if the part is a valid attachment (has disposition of ATTACHMENT or INLINE)
            if (!isset($part->ifdisposition) || !isset($part->disposition) || !in_array(strtoupper($part->disposition), ['ATTACHMENT', 'INLINE'])) {
                $this->line("Skipping part #{$partNumber} for email #{$emailNumber}: Not an attachment");
                continue;
            }

            $attachmentCount++;
            $this->line("Processing attachment part #{$partNumber} for email #{$emailNumber}");

            // Get attachment details
            $filename = $this->getAttachmentName($part);
            $filename = $filename ?: "attachment-{$partNumber}." . $this->getExtension($part);
            $mimeType = $this->getMimeType($part);
            // Safely handle content_id
            $contentId = isset($part->ifid) && isset($part->id) && is_string($part->id) ? trim($part->id, '<>') : null;
            $isInline = strtoupper($part->disposition) === 'INLINE';

            // Fetch attachment data
            $attachmentData = @imap_fetchbody($this->imapConnection, $emailNumber, $partNumber + 1);
            if (!$attachmentData) {
                $this->warn("Failed to fetch attachment data for part #{$partNumber} in email #{$emailNumber}");
                continue;
            }

            // Decode attachment data based on encoding
            switch ($part->encoding) {
                case 3: // BASE64
                    $attachmentData = base64_decode($attachmentData);
                    break;
                case 4: // QUOTED-PRINTABLE
                    $attachmentData = quoted_printable_decode($attachmentData);
                    break;
                default:
                    // No additional decoding needed
                    break;
            }

            if ($attachmentData === false || $attachmentData === null) {
                $this->warn("Failed to decode attachment data for part #{$partNumber} in email #{$emailNumber}");
                continue;
            }

            // Calculate attachment size (in bytes)
            $size = strlen($attachmentData);
            $sizeInMb = $size / (1024 * 1024); // Convert to MB

            // Prepare attachment attributes
            $attachmentAttributes = [
                'email_id' => $email->id,
                'original_name' => $filename,
                'mime_type' => $mimeType,
                'size' => $size,
                'content_id' => $contentId,
                'is_inline' => $isInline,
                'extension' => pathinfo($filename, PATHINFO_EXTENSION) ?: $this->getExtension($part),
            ];

            // Handle attachment storage based on size
            if ($sizeInMb > 2) {
                // Store as file if > 2MB
                $storageName = 'attachments/' . uniqid('email_' . $email->id . '_') . '.' . $attachmentAttributes['extension'];
                try {
                    Storage::disk('public')->put($storageName, $attachmentData);
                    $attachmentAttributes['storage_name'] = $storageName;
                    $attachmentAttributes['storage_path'] = Storage::disk('public')->path($storageName);
                    $this->line("Stored attachment {$filename} as file: {$storageName}");
                } catch (\Exception $e) {
                    $this->error("Failed to store attachment {$filename} as file: {$e->getMessage()}");
                    Log::error('Attachment Storage Error', [
                        'email_id' => $email->id,
                        'part' => $partNumber,
                        'error' => $e->getMessage(),
                    ]);
                    continue;
                }
            } else {
                // Store as base64 in database if <= 2MB
                $attachmentAttributes['base64_content'] = base64_encode($attachmentData);
                $this->line("Stored attachment {$filename} as base64 in database");
            }

            // Save attachment record
            try {
                EmailAttachment::create($attachmentAttributes);
                $this->comment("Attachment {$filename} saved successfully for email #{$emailNumber}");
            } catch (\Exception $e) {
                $this->error("Failed to save attachment {$filename}: {$e->getMessage()}");
                Log::error('Attachment Save Error', [
                    'email_id' => $email->id,
                    'part' => $partNumber,
                    'error' => $e->getMessage(),
                ]);
                continue;
            }
        }

        return $attachmentCount;
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        $this->line("Parsing date: {$date}");

        $timestamp = strtotime($date);

        return $timestamp ? date('Y-m-d H:i:s', $timestamp) : null;
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
            if (\Illuminate\Support\Str::isUuid($uuidPart)) {
                return $uuidPart;
            }
        }

        return $normalized;
    }

    private function generateThreadId($headers, $subject = '')
    {
        // Get raw headers for threading information
        $emailNumber = $headers->Msgno ?? 0; // Get the email number from headers
        $rawHeaders = @imap_fetchheader($this->imapConnection, $emailNumber);
        $threadingHeaders = $this->extractThreadingHeaders($rawHeaders);

        $messageId = $this->normalizeMsgId($headers->message_id ?? '');
        $inReplyTo = $this->normalizeMsgId($threadingHeaders['in_reply_to'] ?? '');
        $references = $threadingHeaders['references'] ?? '';

        $this->line("Threading analysis - Message ID: {$messageId}, In-Reply-To: {$inReplyTo}, References: {$references}, Subject: {$subject}");

        // 1. Check In-Reply-To header
        if ($inReplyTo) {
            $this->line("Checking In-Reply-To: {$inReplyTo}");

            $parent = Email::where('message_id', $inReplyTo)->first();
            if ($parent) {
                $this->line("Found parent via In-Reply-To: {$parent->thread_id}");
                return $parent->thread_id;
            }
        }

        // 2. Check References header (all references)
        if (!empty($references)) {
            $refs = preg_split('/\s+/', trim($references));
            $refs = array_filter($refs);

            $this->line("Checking References: " . implode(', ', $refs));

            // Check all references from newest to oldest
            foreach (array_reverse($refs) as $ref) {
                $normalizedRef = $this->normalizeMsgId($ref);
                $this->line("Checking reference: {$normalizedRef}");

                $parent = Email::where('message_id', $normalizedRef)->first();
                if ($parent) {
                    $this->line("Found parent via References: {$parent->thread_id}");
                    return $parent->thread_id;
                }
            }
        }

        // 3. Subject-based threading
        $cleanSubject = $this->cleanSubject($subject);
        if ($cleanSubject) {
            $this->line("Trying subject-based threading: {$cleanSubject}");

            $existingThread = Email::where('subject', 'like', '%' . $cleanSubject . '%')
                ->orWhere('subject', 'like', '%Re: ' . $cleanSubject . '%')
                ->orWhere('subject', 'like', '%Fwd: ' . $cleanSubject . '%')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($existingThread) {
                $this->line("Found thread via subject: {$existingThread->thread_id}");
                return $existingThread->thread_id;
            }
        }

        // 4. Fallback to message ID
        $finalThreadId = $messageId ?: (string) \Illuminate\Support\Str::uuid();
        $this->line("Using fallback thread ID: {$finalThreadId}");

        return $finalThreadId;
    }

    private function cleanSubject($subject)
    {
        if (empty($subject)) return '';

        // Remove common prefixes and trim
        $clean = preg_replace('/^(Re:|Fwd:|FW:)\s*/i', '', $subject);
        return trim($clean);
    }



    private function parseAddresses($addresses)
    {
        if (!$addresses) {
            return null;
        }

        return array_map(fn($addr) => [
            'email' => $addr->mailbox . '@' . $addr->host,
            'name' => $addr->personal ?? null
        ], $addresses);
    }

    private function getEmailType($headers, $account)
    {
        $from = $headers->from[0]->mailbox . '@' . $headers->from[0]->host;
        $type = $from === $account->pseudo_email ? 'outgoing' : 'incoming';
        return $type;
    }

    private function mapFolder($folder)
    {
        $map = [
            'INBOX' => 'inbox',
            'Sent' => 'sent',
            'Sent Items' => 'sent',
            'Drafts' => 'drafts',
            'Spam' => 'spam',
            'Junk' => 'spam',
            'Trash' => 'trash',
            'Deleted' => 'trash',
            'Deleted Items' => 'trash'
        ];

        $mapped = $map[basename($folder)] ?? 'inbox';
        $this->line("Mapped folder {$folder} to {$mapped}");
        return $mapped;
    }

    private function getAttachmentMimeType($part, string $filename): string
    {
        if (isset($part->subtype)) {
            $mimeType = strtolower("{$part->type}/{$part->subtype}");
            $this->line("Detected MIME type from IMAP structure: {$mimeType}");
            return $mimeType;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $this->line("No MIME type in IMAP structure, guessing based on extension: {$extension}");

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'zip' => 'application/zip',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'txt' => 'text/plain',
        ];

        $mimeType = $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
        $this->line("Assigned MIME type: {$mimeType}");
        return $mimeType;
    }

    private function closeConnection()
    {
        if ($this->imapConnection && is_resource($this->imapConnection)) {
            $this->line('Closing IMAP connection...');
            @imap_close($this->imapConnection);
            $this->comment('IMAP connection closed.');
        }
    }

    private function getAttachmentName($part): ?string
    {
        if (isset($part->ifdparameters) && $part->dparameters) {
            foreach ($part->dparameters as $param) {
                if (strtolower($param->attribute) === 'filename') {
                    return $param->value;
                }
            }
        }
        if (isset($part->ifparameters) && $part->parameters) {
            foreach ($part->parameters as $param) {
                if (strtolower($param->attribute) === 'name') {
                    return $param->value;
                }
            }
        }
        return null;
    }

    private function getMimeType($part): string
    {
        $type = $part->type ?? 0;
        $types = ['text', 'multipart', 'message', 'application', 'audio', 'image', 'video', 'other'];
        $primary = $types[$type] ?? 'application';
        $subtype = $part->subtype ?? 'octet-stream';
        return strtolower("{$primary}/{$subtype}");
    }

    private function getExtension($part): string
    {
        $mimeType = $this->getMimeType($part);
        $extensions = [
            'application/pdf' => 'pdf',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'text/plain' => 'txt',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        ];
        return $extensions[$mimeType] ?? 'bin';
    }
}
