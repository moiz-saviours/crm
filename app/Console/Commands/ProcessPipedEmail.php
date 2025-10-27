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

class ProcessPipedEmail extends Command
{
    protected $signature = 'email:pipe';
    protected $description = 'Process piped email from stdin (email forwarding)';

    public function handle()
    {        
        // Read email content from stdin
        $rawEmail = '';
        $stdin = fopen('php://stdin', 'r');
        
        while (!feof($stdin)) {
            $rawEmail .= fread($stdin, 1024);
        }
        fclose($stdin);

        if (empty($rawEmail)) {
            $this->error('No email content received from stdin');
            Log::error('Piped email: No content received');
            return 1;
        }

        try {
            $this->info('Processing piped email...');
            
            // Parse the raw email
            $parsedData = $this->parseRawEmail($rawEmail);
            
            // Find the appropriate account
            $account = $this->findAccount($parsedData['to']);
            
            if (!$account) {
                $this->error('No matching account found for: ' . $parsedData['to']);
                Log::error('Piped email: No account found', ['to' => $parsedData['to']]);
                return 1;
            }

            $this->info("Processing email for account: {$account->pseudo_email}");

            // Process the email using similar logic to your IMAP command
            $this->processPipedEmail($account, $parsedData, $rawEmail);

            $this->info('Piped email processed successfully');
            return 0;

        } catch (\Exception $e) {
            $this->error('Error processing piped email: ' . $e->getMessage());
            Log::error('Piped Email Processing Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    /**
     * Parse raw email content into structured data
     */
    private function parseRawEmail($rawEmail)
    {
        $lines = explode("\n", $rawEmail);
        $data = [
            'headers' => [],
            'body' => '',
            'from' => '',
            'to' => '',
            'subject' => '',
            'text' => '',
            'html' => '',
            'attachments' => []
        ];

        $isBody = false;
        $bodyLines = [];
        $currentHeader = '';

        foreach ($lines as $line) {
            if (!$isBody && trim($line) === '') {
                $isBody = true;
                continue;
            }

            if (!$isBody) {
                // Parse headers
                if (preg_match('/^([A-Za-z\-]+):\s*(.+)$/', $line, $matches)) {
                    $currentHeader = strtolower($matches[1]);
                    $data['headers'][$currentHeader] = trim($matches[2]);
                } elseif ($currentHeader && preg_match('/^\s+(.+)$/', $line, $matches)) {
                    // Multi-line header
                    $data['headers'][$currentHeader] .= ' ' . trim($matches[1]);
                }
            } else {
                $bodyLines[] = $line;
            }
        }

        // Extract basic fields from headers
        $data['from'] = $data['headers']['from'] ?? '';
        $data['to'] = $data['headers']['to'] ?? '';
        $data['subject'] = $data['headers']['subject'] ?? '';
        $data['body'] = implode("\n", $bodyLines);
        $data['text'] = $data['body'];

        // Parse MIME parts if present
        $this->parseMimeParts($data);

        // Extract clean email addresses
        $data['from_email'] = $this->extractEmail($data['from']);
        $data['to_email'] = $this->extractEmail($data['to']);

        return $data;
    }

    /**
     * Extract email address from header field
     */
    private function extractEmail($field)
    {
        if (preg_match('/<(.+?)>/', $field, $matches)) {
            return $matches[1];
        }
        
        // Try to extract email from string
        preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $field, $matches);
        return $matches[0] ?? $field;
    }

    /**
     * Basic MIME parsing for multipart emails
     */
    private function parseMimeParts(&$data)
    {
        $boundary = $this->extractBoundary($data['headers']);
        
        if (!$boundary) {
            // Single part email
            $contentType = strtolower($data['headers']['content-type'] ?? '');
            if (str_contains($contentType, 'text/html')) {
                $data['html'] = $data['body'];
                $data['text'] = strip_tags($data['body']);
            } else {
                $data['text'] = $data['body'];
                $data['html'] = nl2br($data['body']);
            }
            return;
        }

        // Simple boundary-based parsing
        $parts = explode("--{$boundary}", $data['body']);
        
        foreach ($parts as $part) {
            if (empty(trim($part)) || trim($part) === '--') {
                continue;
            }

            $partHeaders = [];
            $partBody = '';
            $partLines = explode("\n", $part);
            $inHeaders = true;

            foreach ($partLines as $line) {
                if ($inHeaders && trim($line) === '') {
                    $inHeaders = false;
                    continue;
                }

                if ($inHeaders) {
                    if (preg_match('/^([A-Za-z\-]+):\s*(.+)$/', $line, $matches)) {
                        $partHeaders[strtolower($matches[1])] = trim($matches[2]);
                    }
                } else {
                    $partBody .= $line . "\n";
                }
            }

            $contentType = strtolower($partHeaders['content-type'] ?? '');
            $disposition = strtolower($partHeaders['content-disposition'] ?? '');

            if (str_contains($contentType, 'text/plain')) {
                $data['text'] = trim($partBody);
            } elseif (str_contains($contentType, 'text/html')) {
                $data['html'] = trim($partBody);
            } elseif (str_contains($disposition, 'attachment') || str_contains($disposition, 'inline')) {
                $data['attachments'][] = [
                    'headers' => $partHeaders,
                    'content' => $partBody,
                    'filename' => $this->extractFilename($partHeaders)
                ];
            }
        }

        // Fallback if no HTML found
        if (empty($data['html']) && !empty($data['text'])) {
            $data['html'] = nl2br($data['text']);
        }
    }

    /**
     * Extract boundary from content-type header
     */
    private function extractBoundary($headers)
    {
        $contentType = $headers['content-type'] ?? '';
        if (preg_match('/boundary="?([^";]+)"?/', $contentType, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }

    /**
     * Extract filename from headers
     */
    private function extractFilename($headers)
    {
        $disposition = $headers['content-disposition'] ?? '';
        if (preg_match('/filename="?([^"]+)"?/', $disposition, $matches)) {
            return $matches[1];
        }

        $contentType = $headers['content-type'] ?? '';
        if (preg_match('/name="?([^"]+)"?/', $contentType, $matches)) {
            return $matches[1];
        }

        return 'attachment_' . uniqid();
    }

    /**
     * Find user account based on recipient email
     */
    private function findAccount($toEmail)
    {
        $cleanToEmail = $this->extractEmail($toEmail);
        
        return UserPseudoRecord::where('pseudo_email', $cleanToEmail)
            ->where('status', 1)
            ->where('is_verified', 1)
            ->first();
    }

    /**
     * Process the piped email and save to database
     */
    private function processPipedEmail(UserPseudoRecord $account, array $parsedData, $rawEmail)
    {
        // Generate message ID if not present
        $messageId = $parsedData['headers']['message-id'] ?? null;
        $normalizedMessageId = $this->normalizeMsgId($messageId);

        // Check for duplicates
        if ($normalizedMessageId && Email::where('message_id', $normalizedMessageId)
            ->where('pseudo_record_id', $account->id)
            ->exists()) {
            $this->warn('Email already exists, skipping');
            return;
        }

        // Process HTML body with CssToInlineStyles (same as your IMAP command)
        $inlinedHtml = null;
        if (!empty($parsedData['html'])) {
            $cssToInlineStyles = new CssToInlineStyles();
            $inlinedHtml = $cssToInlineStyles->convert($parsedData['html']);
            
            // Strip unwanted tags using DOMDocument (same as your IMAP command)
            $doc = new \DOMDocument();
            @$doc->loadHTML($inlinedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $bodyTag = $doc->getElementsByTagName('body')->item(0);
            if ($bodyTag) {
                $inlinedHtml = $doc->saveHTML($bodyTag);
            }
        }

        // Extract threading headers (same as your IMAP command)
        $threadingHeaders = [
            'in_reply_to' => $parsedData['headers']['in-reply-to'] ?? null,
            'references' => $parsedData['headers']['references'] ?? null
        ];

        // Determine email type
        $fromEmail = $parsedData['from_email'];
        $type = $fromEmail === $account->pseudo_email ? 'outgoing' : 'incoming';
        $folder = $type === 'outgoing' ? 'sent' : 'inbox';

        // Parse addresses (similar to your IMAP command)
        $toAddresses = $this->parseAddressesFromHeader($parsedData['to']);
        $ccAddresses = $this->parseAddressesFromHeader($parsedData['headers']['cc'] ?? '');

        // Create email record
        $email = Email::create([
            'pseudo_record_id' => $account->id,
            'thread_id' => $this->generateThreadId($parsedData),
            'message_id' => $normalizedMessageId,
            'in_reply_to' => $this->normalizeMsgId($threadingHeaders['in_reply_to']),
            'references' => $threadingHeaders['references'],
            'from_email' => $fromEmail,
            'from_name' => $this->extractName($parsedData['from']),
            'to' => $toAddresses,
            'cc' => $ccAddresses,
            'subject' => $parsedData['subject'] ?: 'No Subject',
            'body_html' => $inlinedHtml ?? $parsedData['html'] ?? null,
            'body_text' => $parsedData['text'] ?? null,
            'imap_uid' => null, // Not applicable for piped emails
            'imap_folder' => 'INBOX', // Default folder for piped emails
            'type' => $type,
            'folder' => $folder,
            'is_read' => false,
            'message_date' => $this->parseDateFromHeaders($parsedData['headers']),
            'received_at' => now(),
        ]);

        $this->info("Email saved successfully (ID: {$email->id})");

        // Process attachments
        if (!empty($parsedData['attachments'])) {
            $this->processPipedAttachments($email, $parsedData['attachments']);
        }
    }

    /**
     * Parse addresses from header (similar to your IMAP command)
     */
    private function parseAddressesFromHeader($header)
    {
        if (empty($header)) {
            return null;
        }

        $addresses = [];
        
        // Extract email addresses with names
        preg_match_all('/(?:"([^"]*)"\s*)?<?([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})>?/', $header, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $addresses[] = [
                'email' => $match[2],
                'name' => !empty($match[1]) ? $match[1] : null
            ];
        }

        return $addresses;
    }

    /**
     * Extract name from email header field
     */
    private function extractName($field)
    {
        if (preg_match('/"([^"]*)"/', $field, $matches)) {
            return $matches[1];
        }
        
        $email = $this->extractEmail($field);
        $name = str_replace($email, '', $field);
        $name = trim($name, ' "<>');
        
        return !empty($name) ? $name : null;
    }

    /**
     * Parse date from headers
     */
    private function parseDateFromHeaders($headers)
    {
        $date = $headers['date'] ?? null;
        if (empty($date)) {
            return now();
        }

        $timestamp = strtotime($date);
        return $timestamp ? date('Y-m-d H:i:s', $timestamp) : now();
    }

    /**
     * Generate thread ID (same logic as your IMAP command)
     */
    private function generateThreadId($parsedData)
    {
        $messageId = $this->normalizeMsgId($parsedData['headers']['message-id'] ?? '');
        $inReplyTo = $this->normalizeMsgId($parsedData['headers']['in-reply-to'] ?? '');
        $references = $parsedData['headers']['references'] ?? '';
        $subject = $parsedData['subject'] ?? '';

        // 1. Check In-Reply-To header
        if ($inReplyTo) {
            $parent = Email::where('message_id', $inReplyTo)->first();
            if ($parent) {
                return $parent->thread_id;
            }
        }

        // 2. Check References header
        if (!empty($references)) {
            $refs = preg_split('/\s+/', trim($references));
            $refs = array_filter($refs);

            foreach (array_reverse($refs) as $ref) {
                $normalizedRef = $this->normalizeMsgId($ref);
                $parent = Email::where('message_id', $normalizedRef)->first();
                if ($parent) {
                    return $parent->thread_id;
                }
            }
        }

        // 3. Subject-based threading
        $cleanSubject = $this->cleanSubject($subject);
        if ($cleanSubject) {
            $existingThread = Email::where('subject', 'like', '%' . $cleanSubject . '%')
                ->orWhere('subject', 'like', '%Re: ' . $cleanSubject . '%')
                ->orWhere('subject', 'like', '%Fwd: ' . $cleanSubject . '%')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($existingThread) {
                return $existingThread->thread_id;
            }
        }

        // 4. Fallback to message ID or UUID
        return $messageId ?: (string) Str::uuid();
    }

    /**
     * Clean subject (same as your IMAP command)
     */
    private function cleanSubject($subject)
    {
        if (empty($subject)) return '';

        $clean = preg_replace('/^(Re:|Fwd:|FW:)\s*/i', '', $subject);
        return trim($clean);
    }

    /**
     * Normalize message ID (same as your IMAP command)
     */
    private function normalizeMsgId($id)
    {
        if (empty($id)) {
            return null;
        }

        $normalized = trim($id, " <>\t\n\r");

        // If it contains @, extract the UUID part
        if (str_contains($normalized, '@')) {
            $parts = explode('@', $normalized);
            $uuidPart = $parts[0];

            if (Str::isUuid($uuidPart)) {
                return $uuidPart;
            }
        }

        return $normalized;
    }

    /**
     * Process attachments for piped email
     */
    private function processPipedAttachments(Email $email, array $attachments)
    {
        $attachmentCount = 0;

        foreach ($attachments as $attachment) {
            try {
                $filename = $attachment['filename'];
                $content = $attachment['content'];
                $headers = $attachment['headers'];
                
                $mimeType = strtolower($headers['content-type'] ?? 'application/octet-stream');
                $contentId = isset($headers['content-id']) ? trim($headers['content-id'], '<>') : null;
                $isInline = str_contains(strtolower($headers['content-disposition'] ?? ''), 'inline');

                $size = strlen($content);
                $sizeInMb = $size / (1024 * 1024);

                $attachmentAttributes = [
                    'email_id' => $email->id,
                    'original_name' => $filename,
                    'mime_type' => $mimeType,
                    'size' => $size,
                    'content_id' => $contentId,
                    'is_inline' => $isInline,
                    'extension' => pathinfo($filename, PATHINFO_EXTENSION) ?: $this->getExtensionFromMimeType($mimeType),
                ];

                // Handle storage based on size (same as your IMAP command)
                if ($sizeInMb > 2) {
                    $storageName = 'attachments/' . uniqid('email_' . $email->id . '_') . '.' . $attachmentAttributes['extension'];
                    try {
                        Storage::disk('public')->put($storageName, $content);
                        $attachmentAttributes['storage_name'] = $storageName;
                        $attachmentAttributes['storage_path'] = Storage::disk('public')->path($storageName);
                    } catch (\Exception $e) {
                        Log::error('Piped Attachment Storage Error', [
                            'email_id' => $email->id,
                            'filename' => $filename,
                            'error' => $e->getMessage(),
                        ]);
                        continue;
                    }
                } else {
                    $attachmentAttributes['base64_content'] = base64_encode($content);
                }

                EmailAttachment::create($attachmentAttributes);
                $attachmentCount++;
                $this->info("Attachment saved: {$filename}");

            } catch (\Exception $e) {
                $this->error("Failed to process attachment {$filename}: {$e->getMessage()}");
                Log::error('Piped Attachment Save Error', [
                    'email_id' => $email->id,
                    'filename' => $filename,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->comment("Processed {$attachmentCount} attachments");
    }

    /**
     * Get file extension from MIME type
     */
    private function getExtensionFromMimeType($mimeType)
    {
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