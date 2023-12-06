<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class AdminInfo extends Mailable
{
    use Queueable, SerializesModels;

    public $supporter;
    public $salesforceID;

    /**
     * Create a new message instance.
     */
    public function __construct($supporter, $salesforceID)
    {
        $this->supporter = $supporter;
        $this->salesforceID = $salesforceID;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Neuer Eintrag im Mitgliederformular / Nouvelle entrée dans le formulaire des membres: {$this->supporter->data["fname"]} {$this->supporter->data["lname"]}",
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.admin-info',
            with: [
                "supporter" => $this->supporter,
                "salesforceID" => $this->salesforceID
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
