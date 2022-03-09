<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $messages;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $messages)
    {
        $this->user = $user;
        $this->messages = $messages;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $body = view('users.associate_user_mail', ['user' => $this->user, 'messages' => $this->messages]);

        return $this->subject('Criação de Usuário')
            ->view('email.body_email_base')
            ->with(['text' => $body->render()]);
    }
}
