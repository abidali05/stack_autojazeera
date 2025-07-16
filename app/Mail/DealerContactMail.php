<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DealerContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dealerContact;
    public $dealerName;

    /**
     * Create a new message instance.
     */
    public function __construct($dealerContact, $dealerName)
    {
        $this->dealerContact = $dealerContact;
        $this->dealerName = $dealerName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Dealer Contact Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
		return $this->subject('Dealer Contact Mail')
                ->view('emails.dealer_contact')
                ->with(['dealerContact' => $this->dealerContact,
                		'dealerName' => $this->dealerName
					   ]);
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
