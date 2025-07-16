<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionBuy extends Mailable
{
    use Queueable, SerializesModels;
    public $product;

    /**
     * Create a new message instance.
     */
    public function __construct($product)
    {
       $this->product = $product;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Plan Subscribed Successfully',
        );
    }

    /**
     * Get the message content definition.
     */

	public function build()
    {
		 return $this->subject('Plan Subscribed Successfully')
                ->view('emails.subscription_buy', ['product' => $this->product]);
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
