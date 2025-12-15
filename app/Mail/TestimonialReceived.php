<?php

namespace App\Mail;

use App\Models\Testimonial;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestimonialReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $testimonial;

    /**
     * Create a new message instance.
     */
    public function __construct(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Terima Kasih - ' . ucfirst($this->testimonial->type) . ' Anda Telah Kami Terima',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.testimonial-received',
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
