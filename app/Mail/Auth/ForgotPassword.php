<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

use App\Models\User;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public string $resetLink = '',
        public array $style = [],

    ){
        $this->user = $user;
        $this->resetLink = URL::temporarySignedRoute(
                                'atheer.forgot-password.show', now()->addHours(1), ['forgot_password' => $user->id, 'user' => $user->id]
                            );
        $this->setStyle();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('ahmed@reflectionstravel.net', 'Ahmed Aboelsaoud'),
            subject: 'Forgot Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'atheer::emails.simple.auth.forgot-password',
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

    private function setStyle()
    {
        $this->style['button-success'] = 'margin: auto;background-color:#51b9ff;border-radius:5px;color:#ffffff;display:inline-block;font-family:\'Cabin\', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;';
    }
}
