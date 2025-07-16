<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class upgrade_plan extends Mailable
{
    use Queueable, SerializesModels;
    //public $otp;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //$this->otp = $otp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Plan Upgraded Successfully',
        );
    }

    /**
     * Get the message content definition.
     */

	public function build()
    {
		 return $this->subject('Plan Upgraded Successfully')
                ->view('emails.upgrade_plan');
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
