<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailPartenerInstiintareClient extends Mailable
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

        $message = $this->markdown('emails.email-partener-instiintare-client');

        $pdf = \PDF::loadView('service.fise.export.fisa-intrare-service-pdf', compact('fisa'))
            ->setPaper('a4', 'portrait');

        $message->subject('Trimitere echipament în service partener');
        $message->attachData(
            $pdf->output(),
            'Fisa echipamentului.pdf'
        );

        return $message;
    }
}
