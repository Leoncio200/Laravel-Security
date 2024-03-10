<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user=$user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $url = URL::temporarySignedRoute('login.verify',now()->addMinutes(5), ['id' => $this->user->id]);
        return new Content(
            view: 'email.welcome',
            with:[
                "name"=>$this->user->name,
                "enlace"=>$url
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
