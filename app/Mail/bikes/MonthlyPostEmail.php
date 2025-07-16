<?php

namespace App\Mail\bikes;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MonthlyBikePostEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $posts;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $posts)
    {
        $this->user = $user;
        $this->posts = $posts;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Latest Bike Ads',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
		 return $this->subject('Your Monthly Posts')
                ->view('emails.bikes.monthly_post')
                ->with(['user' => $this->user, 'posts' => $this->posts
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
