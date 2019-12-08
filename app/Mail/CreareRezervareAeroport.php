<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreareRezervareAeroport extends Mailable
{
    use Queueable, SerializesModels;

    public $rezervare;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rezervare)
    {
        $this->rezervare = $rezervare;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $rezervare = $this->rezervare;
        $pdf = \PDF::loadView('rezervari-aeroport.export.rezervare-aeroport-pdf', compact('rezervare'))
            ->setPaper('a4');

        return $this->markdown('mail.creare-rezervare-aeroport')
            ->attachData($pdf->output(), 'Rezervare Alsimy Mond Travel.pdf');
    }
}
