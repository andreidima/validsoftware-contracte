<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FisaIntrareService extends Mailable
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

        $message = $this->markdown('emails.fisa-intrare-service');
        $message->subject('Fișă intrare service');      

        $pdf = \PDF::loadView('service.fise.export.fisa-intrare-service-pdf', compact('fisa'))
            ->setPaper('a4', 'portrait');
        $message->attachData($pdf->output(), 
            'Fisa intrare service nr. ' . $fisa->nr_intrare . '.pdf');

        return $message;
    }
}
