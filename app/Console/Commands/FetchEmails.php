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
    protected $signature = 'emails:fetch {--limit=10} {--account=*} {--new-only} {--address=*}';
    protected $description = 'Fetch emails from IMAP accounts';

    private $imapConnection;
    private $baseMailboxString;

    //php artisan emails:fetch --limit=10 --account=hasnat.developer@pivotbookwriting.com --account=hasnat.khan@stellers.org --address=moiz.saviours@gmail.com --address=hasnat.khan@stellers.org
  public function handle()
{
    // dd($this->option('account'),$this->option('address'));
    $startTime = microtime(true); // Record start time
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

        $endTime = microtime(true); // Record end time
        $totalTime = round($endTime - $startTime, 2); // Calculate total time in seconds
        $this->info("Email fetch process completed successfully. Total time taken: {$totalTime} seconds.");
        return 1;
    } catch (\Exception $e) {
        $this->error("Something went wrong please try again");
        Log::error('IMAP Fatal Error', ['error' => $e->getMessage()]);
        return 0;
    } finally {
        $this->closeConnection();
        $endTime = microtime(true); // Ensure end time is recorded even on error
        $totalTime = round($endTime - $startTime, 2); // Calculate total time in seconds
        $this->info("Total time taken by command: {$totalTime} seconds.");
    }
}

   private function getAccounts()
{
    $this->line('Retrieving active IMAP accounts...');
    $query = UserPseudoRecord::where('imap_type', 'imap')
        ->where('status', 1)
        ->where('is_verified', 1)
        ->whereNotNull(['server_host', 'server_username', 'server_password']);

    if ($accountEmails = $this->option('account')) {
        $this->line("Filtering for specific account emails: " . implode(', ', $accountEmails));
        $query->whereIn('pseudo_email', $accountEmails);
    }

    $accounts = $query->get();
    if ($accounts->isEmpty()) {
        $this->warn("No matching accounts found for the provided criteria.");
    }
    return $accounts;
}

    private function fetchAccountEmails(UserPseudoRecord $account)
{
    $startTime = microtime(true); // Record start time for account
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

        $endTime = microtime(true); // Record end time
        $accountTime = round($endTime - $startTime, 2); // Calculate account processing time
        $this->comment("Completed processing for {$account->pseudo_email}. Time taken: {$accountTime} seconds.");
    } catch (\Exception $e) {
        $this->error("Error for {$account->pseudo_email}: {$e->getMessage()}");
        Log::error('IMAP Account Error', ['account' => $account->id, 'error' => $e->getMessage()]);
        $endTime = microtime(true); // Record end time on error
        $accountTime = round($endTime - $startTime, 2); // Calculate account processing time
        $this->comment("Processing for {$account->pseudo_email} failed. Time taken: {$accountTime} seconds.");
    }
}

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
            // Search for emails where the address appears in FROM, TO, CC, or BCC
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

            // Collect From addresses
            if (isset($headers->from)) {
                $emailAddresses[] = $headers->from[0]->mailbox . '@' . $headers->from[0]->host;
            }

            // Collect To addresses
            if (isset($headers->to)) {
                $emailAddresses = array_merge(
                    $emailAddresses,
                    array_map(fn($addr) => $addr->mailbox . '@' . $addr->host, $headers->to)
                );
            }

            // Collect CC addresses
            if (isset($headers->cc)) {
                $emailAddresses = array_merge(
                    $emailAddresses,
                    array_map(fn($addr) => $addr->mailbox . '@' . $addr->host, $headers->cc)
                );
            }

            // Collect BCC addresses
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
        if (!$overview) {
            $this->warn("Skipping email #{$emailNumber}: No overview data");
            return;
        }

        // Skip if exists
        if (
            isset($overview->message_id) &&
            Email::where('message_id', $overview->message_id)
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
        $email = Email::create([
            'pseudo_record_id' => $account->id,
            'thread_id' => $this->generateThreadId($headers),
            'message_id' => $overview->message_id ?? null,
            'from_email' => $headers->from[0]->mailbox . '@' . $headers->from[0]->host,
            'from_name' => $headers->from[0]->personal ?? null,
            'to' => $this->parseAddresses($headers->to ?? null),
            'cc' => $this->parseAddresses($headers->cc ?? null),
            'subject' => $overview->subject ?? 'No Subject',
            'body_html' => $body['html'] ?? null,
            'body_text' => $body['text'] ?? null,
            'imap_uid' => @imap_uid($this->imapConnection, $emailNumber),
            'imap_folder' => $folder,
            'type' => $this->getEmailType($headers, $account),
            'folder' => $this->mapFolder($folder),
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
            if ($part->type != 0) continue; // Only text parts

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

    private function processAttachments(int $emailNumber, $structure, Email $email)
    {
        if (!isset($structure->parts)) {
            $this->line("No attachments found for email #{$emailNumber}");
            return 0;
        }

        $attachmentCount = 0;

        foreach ($structure->parts as $i => $part) {
            if ($part->type == 0) continue; // Skip text parts

            $filename = $this->getAttachmentFilename($part);
            if (!$filename) {
                $this->line("No filename found for part " . ($i + 1));
                continue;
            }

            $this->line("Processing attachment: {$filename}");
            try {
                $content = @imap_fetchbody($this->imapConnection, $emailNumber, $i + 1);
                if (!$content) {
                    $this->warn("Failed to fetch attachment content: {$filename}");
                    continue;
                }

                if ($part->encoding == 3) {
                    $this->line("Decoding base64 attachment: {$filename}");
                    $content = imap_base64($content);
                }
                if ($part->encoding == 4) {
                    $this->line("Decoding quoted-printable attachment: {$filename}");
                    $content = imap_qprint($content);
                }

                // Determine MIME type
                $mimeType = $this->getAttachmentMimeType($part, $filename);

                $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
                $storagePath = "attachments/{$email->id}/" . uniqid() . "_{$filename}";

                $this->line("Saving attachment to: {$storagePath}");
                if (Storage::put($storagePath, $content)) {
                    EmailAttachment::create([
                        'email_id' => $email->id,
                        'original_name' => $filename,
                        'storage_name' => basename($storagePath),
                        'size' => strlen($content),
                        'storage_path' => $storagePath,
                        'mime_type' => $mimeType, // Add MIME type
                    ]);

                    $attachmentCount++;
                    $this->comment("Attachment saved: {$filename} (size: " . strlen($content) . " bytes, MIME type: {$mimeType})");
                    Log::debug("Attachment processed", [
                        'email_id' => $email->id,
                        'filename' => $filename,
                        'size' => strlen($content),
                        'mime_type' => $mimeType
                    ]);
                }
            } catch (\Exception $e) {
                $this->error("Attachment processing failed for {$filename}: {$e->getMessage()}");
                Log::warning("Attachment processing failed", [
                    'email_id' => $email->id,
                    'filename' => $filename,
                    'error' => $e->getMessage()
                ]);
            }
        }

        if ($attachmentCount > 0) {
            Log::info("Attachments processed", [
                'email_id' => $email->id,
                'attachment_count' => $attachmentCount
            ]);
            $this->comment("Processed {$attachmentCount} attachments for email #{$emailNumber}");
        }

        return $attachmentCount;
    }

    private function getAttachmentFilename($part)
    {
        if (isset($part->dparameters)) {
            foreach ($part->dparameters as $param) {
                if (strtolower($param->attribute) == 'filename') {
                    return $param->value;
                }
            }
        }

        if (isset($part->parameters)) {
            foreach ($part->parameters as $param) {
                if (strtolower($param->attribute) == 'name') {
                    return $param->value;
                }
            }
        }

        return null;
    }

    private function parseDate($date)
    {
        $this->line("Parsing date: {$date}");
        return $date && ($timestamp = strtotime($date)) ? date('Y-m-d H:i:s', $timestamp) : now();
    }

    private function generateThreadId($headers)
    {
        if (isset($headers->in_reply_to)) {
            // $this->line("Generating thread ID from in_reply_to");
            return md5($headers->in_reply_to);
        }
        if (isset($headers->references)) {
            // $this->line("Generating thread ID from references");
            return md5(explode(' ', $headers->references)[0] ?? '');
        }

        $from = $headers->from[0]->mailbox . '@' . $headers->from[0]->host;
        $this->line("Generating thread ID from subject and sender");
        return md5(($headers->subject ?? '') . $from . time());
    }

    private function parseAddresses($addresses)
    {
        if (!$addresses) {
            // $this->line("No addresses to parse");
            return null;
        }

        // $this->line("Parsing email addresses");
        return array_map(fn($addr) => [
            'email' => $addr->mailbox . '@' . $addr->host,
            'name' => $addr->personal ?? null
        ], $addresses);
    }

    private function getEmailType($headers, $account)
    {
        $from = $headers->from[0]->mailbox . '@' . $headers->from[0]->host;
        $type = $from === $account->pseudo_email ? 'outgoing' : 'incoming';
        // $this->line("Determined email type: {$type}");
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
        // Check if the part has a MIME type
        if (isset($part->subtype)) {
            $mimeType = strtolower("{$part->type}/{$part->subtype}");
            $this->line("Detected MIME type from IMAP structure: {$mimeType}");
            return $mimeType;
        }

        // Fallback to guessing MIME type based on file extension
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
}
