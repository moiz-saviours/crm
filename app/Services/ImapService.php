<?php

namespace App\Services;

use Exception;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class ImapService
{
    private $connection;
     private $config;
   

public function connect(array $imapConfig): bool
{
    // Save globally for other methods
    $this->config = $imapConfig;

    // Build mailbox string correctly
    $mailbox = sprintf(
        "{%s:%d/%s%s%s}INBOX",
        $this->config['host'],
        $this->config['port'],
        $this->config['protocol'],
        $this->config['encryption'] ? '/' . $this->config['encryption'] : '',
        !$this->config['validate_cert'] ? '/novalidate-cert' : ''
    );


    $this->connection = @imap_open(
        $mailbox,
        $this->config['username'],
        $this->config['password']
    );
   

    if (!$this->connection) {
        logger()->error('IMAP connection failed: ' . imap_last_error());
    }

    return $this->connection !== false;
}


    public function disconnect(): void
    {
        if ($this->connection) {
            imap_close($this->connection);
            $this->connection = null;
        }
    }

    public function getFolders(): array
    {
        if (!$this->connection) {
            throw new Exception('IMAP not connected');
        }

        $folders = imap_list($this->connection, $this->getMailboxString(), '*');
        $result = [];

        foreach ($folders as $folder) {
            $folderName = str_replace($this->getMailboxString(), '', $folder);
            $result[] = [
                'name' => $folderName,
                'full_name' => $folder,
                'delimiter' => '.',
            ];
        }

        return $result;
    }
    private function generateUuidFromMessageId(?string $messageId): string
    {
        if (empty($messageId)) {
            return 'email-' . uniqid() . '-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
        }

        $clean = preg_replace('/[^a-zA-Z0-9]/', '', $messageId);

        if (strlen($clean) === 0) {
            return 'email-' . uniqid() . '-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
        }

        $half = intdiv(strlen($clean), 2);
        $firstHalf = substr($clean, 0, $half);
        $secondHalf = substr($clean, $half);

        return 'email-' . $firstHalf . strrev($secondHalf);
    }


    public function selectFolder(string $folder = 'INBOX'): bool
    {
        return imap_reopen($this->connection, $this->getMailboxString() . $folder);
    }

    private function inlineEmailCss(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // Extract <style> CSS
        preg_match_all('/<style\b[^>]*>(.*?)<\/style>/is', $html, $matches);
        $css = implode(' ', $matches[1] ?? []);

        // Remove <style> tags so they don’t apply globally
        $htmlWithoutStyles = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $html);

        // Convert CSS → inline styles
        $inliner = new CssToInlineStyles();
        return $inliner->convert($htmlWithoutStyles, $css);
    }

    public function getEmails(string $folder = 'INBOX', int $limit = 50, int $offset = 0): array
    {
        $this->selectFolder($folder);

        $totalEmails = @imap_num_msg($this->connection) ?: 0;
        $emails = [];

        if ($totalEmails <= 0) {
            return [];
        }

        $start = max(1, $totalEmails - $offset - $limit + 1);
        $end   = max(1, $totalEmails - $offset);


        
   for ($i = $end; $i >= $start; $i--) {
    try {
        $header    = @imap_headerinfo($this->connection, $i) ?: new \stdClass();
        $structure = @imap_fetchstructure($this->connection, $i) ?: null;
        $attachments = $this->getAttachments($i, $structure);

        $body = $this->getMessageBody($i, $structure);

        if (!empty($body['html'])) {
            $body['html'] = $this->inlineEmailCss($body['html']);
        }

        $from = $this->parseAddress($header->from ?? []);
        $fromEmail = strtolower($from[0]['email'] ?? '');

        // ✅ Only allow developer@pivotbookwriting.com
        if ($fromEmail !== 'developer@pivotbookwriting.com') {
            continue;
        }

        $emails[] = [
            'uid'            => @imap_uid($this->connection, $i) ?: null,
            'uuid'           => $this->generateUuidFromMessageId($header->message_id ?? ''),
            'message_id'     => $header->message_id ?? '',
            'subject'        => $this->decodeHeader($header->subject ?? '(No Subject)'),
            'from'           => $from ?: [['name' => 'Unknown', 'email' => 'Unknown']],
            'to'             => $this->parseAddress($header->to ?? []) ?: [['name' => '', 'email' => 'Unknown']],
            'cc'             => $this->parseAddress($header->cc ?? []),
            'date'           => $this->safeDate($header->date ?? null),
            'size'           => $header->Size ?? 0,
            'seen'           => isset($header->Unseen) ? !$header->Unseen : false,
            'flagged'        => $header->Flagged ?? false,
            'answered'       => $header->Answered ?? false,
            'deleted'        => $header->Deleted ?? false,
            'draft'          => $header->Draft ?? false,
            'has_attachments' => $this->hasAttachments($structure),
            'thread_id'      => $this->getThreadId($header) ?? '',
            'body'           => $body,
            'attachments' => $attachments, // ✅ added
        ];
    } catch (\Throwable $e) {
        continue; // skip bad emails
    }
}


        return $emails;
    }

    /**
     * Safely parse date.
     */
    private function safeDate(?string $date): ?string
    {
        if (empty($date)) {
            return null;
        }

        try {
            return date('Y-m-d H:i:s', strtotime($date));
        } catch (\Throwable $e) {
            return null;
        }
    }



    public function getEmail(string $uid, string $folder = 'INBOX'): ?array
    {
        $this->selectFolder($folder);

        $messageNum = imap_msgno($this->connection, $uid);
        if (!$messageNum) {
            return null;
        }

        $header = imap_headerinfo($this->connection, $messageNum);
        $structure = imap_fetchstructure($this->connection, $messageNum);

        $body = $this->getMessageBody($messageNum, $structure);
        $attachments = $this->getAttachments($messageNum, $structure);

        return [
            'uid' => $uid,
            'message_id' => $header->message_id ?? '',
            'subject' => $this->decodeHeader($header->subject ?? ''),
            'from' => $this->parseAddress($header->from ?? []),
            'to' => $this->parseAddress($header->to ?? []),
            'cc' => $this->parseAddress($header->cc ?? []),
            'bcc' => $this->parseAddress($header->bcc ?? []),
            'reply_to' => $this->parseAddress($header->reply_to ?? []),
            'date' => isset($header->date) ? date('Y-m-d H:i:s', strtotime($header->date)) : null,
            'size' => $header->Size ?? 0,
            'seen' => !$header->Unseen,
            'flagged' => $header->Flagged,
            'answered' => $header->Answered,
            'deleted' => $header->Deleted,
            'draft' => $header->Draft,
            'body' => $body,
            'attachments' => $attachments,
            'thread_id' => $this->getThreadId($header),
            'references' => $header->references ?? '',
            'in_reply_to' => $header->in_reply_to ?? '',
        ];
    }

    public function markAsRead(string $uid): bool
    {
        $messageNum = imap_msgno($this->connection, $uid);
        return imap_setflag_full($this->connection, $uid, "\\Seen", ST_UID);
    }

    public function markAsUnread(string $uid): bool
    {
        $messageNum = imap_msgno($this->connection, $uid);
        return imap_clearflag_full($this->connection, $uid, "\\Seen", ST_UID);
    }

    public function flagMessage(string $uid): bool
    {
        return imap_setflag_full($this->connection, $uid, "\\Flagged", ST_UID);
    }

    public function unflagMessage(string $uid): bool
    {
        return imap_clearflag_full($this->connection, $uid, "\\Flagged", ST_UID);
    }

    public function deleteMessage(string $uid): bool
    {
        return imap_delete($this->connection, $uid, ST_UID);
    }

    public function moveMessage(string $uid, string $targetFolder): bool
    {
        return imap_mail_move($this->connection, $uid, $targetFolder, ST_UID);
    }

    public function getThreads(string $folder = 'INBOX'): array
    {
        $emails = $this->getEmails($folder, 1000);
        $threads = [];

        foreach ($emails as $email) {
            $threadId = $email['thread_id'];
            if (!isset($threads[$threadId])) {
                $threads[$threadId] = [
                    'id' => $threadId,
                    'subject' => $email['subject'],
                    'participants' => [],
                    'messages' => [],
                    'last_date' => $email['date'],
                    'message_count' => 0,
                    'unread_count' => 0,
                ];
            }

            $threads[$threadId]['messages'][] = $email;
            $threads[$threadId]['message_count']++;

            if (!$email['seen']) {
                $threads[$threadId]['unread_count']++;
            }

            // Update participants
            $from = $email['from'][0] ?? null;
            if ($from && !in_array($from['email'], array_column($threads[$threadId]['participants'], 'email'))) {
                $threads[$threadId]['participants'][] = $from;
            }

            // Update last date
            if ($email['date'] > $threads[$threadId]['last_date']) {
                $threads[$threadId]['last_date'] = $email['date'];
            }
        }

        // Sort threads by last date
        usort($threads, function ($a, $b) {
            return strtotime($b['last_date']) - strtotime($a['last_date']);
        });

        return array_values($threads);
    }

    private function getMailboxString(): string
    {
        return sprintf(
            "{%s:%d/%s%s}",
            $this->config['host'],
            $this->config['port'],
            $this->config['protocol'],
            $this->config['encryption'] ? '/' . $this->config['encryption'] : ''
        );
    }

    private function decodeHeader(string $header): string
    {
        $decoded = imap_mime_header_decode($header);
        $result = '';

        foreach ($decoded as $part) {
            $result .= $part->text;
        }

        return $result;
    }

    private function parseAddress(array $addresses): array
    {
        $result = [];

        foreach ($addresses as $address) {
            $result[] = [
                'name' => isset($address->personal) ? $this->decodeHeader($address->personal) : '',
                'email' => $address->mailbox . '@' . $address->host,
            ];
        }

        return $result;
    }

    private function hasAttachments($structure): bool
    {
        if (isset($structure->parts)) {
            foreach ($structure->parts as $part) {
                if (isset($part->disposition) && strtolower($part->disposition) === 'attachment') {
                    return true;
                }
            }
        }

        return false;
    }

    private function getMessageBody(int $messageNum, $structure): array
    {
        $body = ['text' => '', 'html' => ''];

        if (isset($structure->parts)) {
            foreach ($structure->parts as $partNum => $part) {
                $this->extractBodyPart($messageNum, $part, $partNum + 1, $body);
            }
        } else {
            $this->extractBodyPart($messageNum, $structure, 1, $body);
        }

        return $body;
    }

    private function extractBodyPart(int $messageNum, $part, string $partNum, array &$body): void
    {
        $data = imap_fetchbody($this->connection, $messageNum, $partNum);

        // Decode based on encoding
        if (isset($part->encoding)) {
            switch ($part->encoding) {
                case 3: // Base64
                    $data = base64_decode($data);
                    break;
                case 4: // Quoted-printable
                    $data = quoted_printable_decode($data);
                    break;
            }
        }

        // Check content type
        $contentType = strtolower($part->subtype ?? '');

        if ($contentType === 'plain') {
            $body['text'] = $data;
        } elseif ($contentType === 'html') {
            $body['html'] = $data;
        }

        // Handle multipart
        if (isset($part->parts)) {
            foreach ($part->parts as $subPartNum => $subPart) {
                $this->extractBodyPart($messageNum, $subPart, $partNum . '.' . ($subPartNum + 1), $body);
            }
        }
    }

    private function getAttachments(int $messageNum, $structure): array
    {
        $attachments = [];

        if (isset($structure->parts)) {
            foreach ($structure->parts as $partNum => $part) {
                $this->extractAttachment($messageNum, $part, $partNum + 1, $attachments);
            }
        }

        return $attachments;
    }

private function extractAttachment(int $messageNum, $part, string $partNum, array &$attachments): void
    {
        if (isset($part->disposition) && strtolower($part->disposition) === 'attachment') {
            $filename = '';

            if (isset($part->dparameters)) {
                foreach ($part->dparameters as $param) {
                    if (strtolower($param->attribute) === 'filename') {
                        $filename = $param->value;
                        break;
                    }
                }
            }

            if (!$filename && isset($part->parameters)) {
                foreach ($part->parameters as $param) {
                    if (strtolower($param->attribute) === 'name') {
                        $filename = $param->value;
                        break;
                    }
                }
            }

            // Get the attachment content
            $attachmentData = imap_fetchbody($this->connection, $messageNum, $partNum);
            
            // Decode based on encoding
            if (isset($part->encoding)) {
                switch ($part->encoding) {
                    case 3: // Base64
                        $attachmentData = base64_decode($attachmentData);
                        break;
                    case 4: // Quoted-printable
                        $attachmentData = quoted_printable_decode($attachmentData);
                        break;
                }
            }

            // Get MIME type
            $mimeType = $this->getMimeType($part);
            
            // Create data URI for direct download
            $base64Data = base64_encode($attachmentData);
            $downloadUrl = "data:{$mimeType};base64,{$base64Data}";

            $attachments[] = [
                'filename' => $this->decodeHeader($filename),
                'size' => $part->bytes ?? strlen($attachmentData),
                'type' => $part->subtype ?? 'unknown',
                'mime_type' => $mimeType,
                'part_number' => $partNum,
                'download_url' => $downloadUrl, // ✅ Direct download URL
            ];
        }

        if (isset($part->parts)) {
            foreach ($part->parts as $subPartNum => $subPart) {
                $this->extractAttachment($messageNum, $subPart, $partNum . '.' . ($subPartNum + 1), $attachments);
            }
        }
    }

    /**
     * Get MIME type from email part structure
     */
    private function getMimeType($part): string
    {
        $primaryType = strtolower($part->type ?? 0);
        $subType = strtolower($part->subtype ?? 'unknown');

        $typeMap = [
            0 => 'text',      // TYPETEXT
            1 => 'multipart', // TYPEMULTIPART  
            2 => 'message',   // TYPEMESSAGE
            3 => 'application', // TYPEAPPLICATION
            4 => 'audio',     // TYPEAUDIO
            5 => 'image',     // TYPEIMAGE
            6 => 'video',     // TYPEVIDEO
            7 => 'model',     // TYPEMODEL
            8 => 'other'      // TYPEOTHER
        ];

        $primaryTypeName = $typeMap[$primaryType] ?? 'application';
        
        return "{$primaryTypeName}/{$subType}";
    }

    /**
     * Alternative method: Get attachment download URL by UID and part number
     */
    public function getAttachmentDownloadUrl(string $uid, string $partNumber, string $folder = 'INBOX'): ?string
    {
        $this->selectFolder($folder);
        
        $messageNum = imap_msgno($this->connection, $uid);
        if (!$messageNum) {
            return null;
        }

        $structure = imap_fetchstructure($this->connection, $messageNum);
        $part = $this->getPartByNumber($structure, $partNumber);
        
        if (!$part) {
            return null;
        }

        // Get the attachment content
        $attachmentData = imap_fetchbody($this->connection, $messageNum, $partNumber);
        
        // Decode based on encoding
        if (isset($part->encoding)) {
            switch ($part->encoding) {
                case 3: // Base64
                    $attachmentData = base64_decode($attachmentData);
                    break;
                case 4: // Quoted-printable
                    $attachmentData = quoted_printable_decode($attachmentData);
                    break;
            }
        }

        // Get MIME type
        $mimeType = $this->getMimeType($part);
        
        // Create data URI for direct download
        $base64Data = base64_encode($attachmentData);
        return "data:{$mimeType};base64,{$base64Data}";
    }

    /**
     * Helper method to get specific part by part number
     */
    private function getPartByNumber($structure, string $partNumber)
    {
        $parts = explode('.', $partNumber);
        $currentPart = $structure;
        
        foreach ($parts as $partIndex) {
            $index = intval($partIndex) - 1;
            
            if (isset($currentPart->parts) && isset($currentPart->parts[$index])) {
                $currentPart = $currentPart->parts[$index];
            } else {
                return null;
            }
        }
        
        return $currentPart;
    }

    private function getThreadId($header): string
    {
        // Use message-id or references for threading
        if (isset($header->references)) {
            $references = explode(' ', trim($header->references));
            return array_shift($references);
        }

        if (isset($header->in_reply_to)) {
            return $header->in_reply_to;
        }

        return $header->message_id ?? uniqid();
    }
}
