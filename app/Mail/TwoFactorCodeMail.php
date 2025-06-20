<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public string $message_id;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $code,$message_id)
    {
        $this->user = $user;
        $this->code = $code;
        $this->message_id = $message_id;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Two-Factor Authentication Code',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.two-factor-code',
            with: [
                'user' => $this->user,
                'code' => $this->code,
                'message_id' => $this->message_id,
                'ipAddress' => request()->ip(),
                'time' => now()->format('Y-m-d H:i:s T'),
            ],
        );
    }
}
