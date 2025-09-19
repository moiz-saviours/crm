<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use DOMDocument;
use Illuminate\Support\Facades\Log;
class OutgoingEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $toEmails;
    public $ccEmails;
    public $bccEmails;
    public $fromEmail;
    public $fromName;
    public $attachments;
    public $emailId;
    public $renderedHtml;
    public $renderedText;

    public function __construct(
        string $subject,
        string $content,
        array $toEmails,
        array $ccEmails = [],
        array $bccEmails = [],
        string $fromEmail = '',
        string $fromName = '',
        array $attachments = [],
        ?int $emailId = null
    ) {
        $this->subject = $subject;
        $this->content = $this->wrapUrlsForTracking($content, $emailId);
        $this->toEmails = $toEmails;
        $this->ccEmails = $ccEmails;
        $this->bccEmails = $bccEmails;
        $this->fromEmail = $fromEmail ?: config('mail.from.address');
        $this->fromName = $fromName ?: config('mail.from.name');
        $this->attachments = $attachments;
        $this->emailId = $emailId;
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

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address($this->fromEmail, $this->fromName),
            subject: $this->subject,
            to: $this->toEmails,
            cc: $this->ccEmails,
            bcc: $this->bccEmails
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin.customers.contacts.components.outgoing-template',
            with: [
                'subject' => $this->subject,
                'content' => $this->content,
                'toEmails' => $this->toEmails,
                'fromEmail' => $this->fromEmail,
                'fromName' => $this->fromName,
                'emailId' => $this->emailId,
            ]
        );
    }

    public function attachments(): array
    {
        $emailAttachments = [];
        foreach ($this->attachments as $attachment) {
            try {
                $filePath = storage_path('app/public/' . $attachment['storage_path']);
                if (file_exists($filePath)) {
                    $emailAttachments[] = Attachment::fromPath($filePath)
                        ->as($attachment['original_name'])
                        ->withMime($attachment['mime_type']);
                } else {
                    Log::warning('Attachment file not found', [
                        'path' => $filePath,
                        'original_name' => $attachment['original_name'],
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to attach file', [
                    'attachment' => $attachment,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        return $emailAttachments;
    }

    public function build()
    {
        // Render the view to get HTML and text content
        $view = $this->content()->view;
        $data = $this->content()->with;
        $this->renderedHtml = view($view, $data)->render();
        $this->renderedText = strip_tags($this->renderedHtml);
        return $this;
    }
}