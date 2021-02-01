<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailPartener extends Mailable
{
    use Queueable, SerializesModels;

    public $fisa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fisa)
    {
        $this->fisa = $fisa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fisa = $this->fisa;

        $message = $this->markdown('emails.email-partener');

        $pdf = \PDF::loadView('service.fise.export.fisa-catre-partener-pdf', compact('fisa'))
            ->setPaper('a4', 'portrait');

        $message->subject('Trimitere echipament');
        $message->attachData(
            $pdf->output(),
            'Fisa echipamentului.pdf'
        );

        return $message;
    }
}
