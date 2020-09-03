<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FisaIesireService extends Mailable
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

        $message = $this->markdown('emails.fisa-iesire-service');
        $message->subject('Fișă ieșire service');      

        $pdf = \PDF::loadView('service.fise.export.fisa-iesire-service-pdf', compact('fisa'))
            ->setPaper('a4', 'portrait');
        $message->attachData($pdf->output(), 
            'Fisa iesire service nr. ' . $fisa->nr_iesire . '.pdf');

        return $message;
    }
}
