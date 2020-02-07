<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompleteRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;
    private $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@labot.inc')
            ->subject('会員登録完了のお知らせ')
            ->view('emails.complete_registration')
            ->with(['name' => $this->name]);
    }
}
