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
use Illuminate\Support\Facades\Hash;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        // Generar número aleatorio de 4 dígitos
        $randomCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        // Guardar el código generado hasheado en el campo 'code' del usuario
        $this->user->code = Hash::make($randomCode);
        $this->user->save();

        $url = route('login.verify', ['id' => $this->user->id]);
        if ($this->user->rol_id == 1) {
            // Si el ID del usuario es 1, redirigir a email.welcomeAdmin
            return new Content(
                view: 'email.welcomeAdmin',
                 with: [
                    'name' => $this->user->name,    "enlace"=>$url,
                    "randomCode" => $randomCode, ]);
        } elseif ($this->user->rol_id || $this->user->rol_id == 3) {
            // Si el ID del usuario es 2 o 3, redirigir a email.welcome
            return new Content(view: 'email.welcome', with: ['name' => $this->user->name,    "enlace"=>$url,
            "randomCode" => $randomCode, ]);
        } else {
            // Si el ID del usuario no coincide con ninguna condición, lanzar una excepción o manejar el caso de acuerdo a tus necesidades
            throw new \Exception('ID de usuario no válido');
        }
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
