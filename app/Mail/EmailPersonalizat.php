<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailPersonalizat extends Mailable
{
    use Queueable, SerializesModels;

    public $fisa;
    public $email_text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fisa, $email_text)
    {
        $this->fisa = $fisa;
        $this->email_text = $email_text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fisa = $this->fisa;
        $email_text = $this->email_text;

        $message = $this->markdown('emails.email-personalizat');
        $message->subject('Fișă service');

        return $message;
    }
}
