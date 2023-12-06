<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupporterWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public $lang;
    public $supporter;
    public $supporterType;
    public $subjects = [
        "German" => "Willkommen bei der LOS! 🎉",
        "French" => "Bienvenu-e-x à la LOS ! 🎉",
    ];

    /**
     * Create a new message instance.
     */
    public function __construct($lang, $supporter, $supporterType)
    {
        $this->lang = $lang;
        $this->supporter = $supporter;
        $this->supporterType = $supporterType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjects[$this->lang],
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: "mail.{$this->supporterType}-welcome-{$this->lang}",
            with: [
                "supporter" => $this->supporter
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
