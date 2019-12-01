<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreareRezervare extends Mailable
{
    use Queueable, SerializesModels;

    public $rezervare;
    public $tarife;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rezervare, $tarife)
    {
        $this->rezervare = $rezervare;
        $this->tarife = $tarife;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $rezervare = $this->rezervare;
        $tarife = $this->tarife;
        $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervare', 'tarife'))
            ->setPaper('a4');

        return $this->markdown('mail.creare-rezervare')
            ->attachData($pdf->output(), 'Rezervare Alsimy Mond Travel.pdf');
    }
}
