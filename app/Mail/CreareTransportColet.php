<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreareTransportColet extends Mailable
{
    use Queueable, SerializesModels;

    public $colet;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($colet)
    {
        $this->colet = $colet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $colet = $this->colet;
        $pdf = \PDF::loadView('rezervari.export.colet-pdf', compact('colet'))
            ->setPaper('a4');

        return $this->markdown('mail.creare-colet')
            ->attachData($pdf->output(), 'Colet Alsimy Mond Travel.pdf');
    }
}
