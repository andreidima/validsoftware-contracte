<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Ofertare extends Mailable
{
    use Queueable, SerializesModels;

    public $ofertari;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ofertari)
    {
        $this->ofertari = $ofertari;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ofertari = $this->ofertari;

        // $message = $this->markdown('emails.ofertare');
        $message = $this->view('emails.ofertareHtml');

        $pdf = \PDF::loadView('ofertari.export.ofertare-pdf', compact('ofertari'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $message->subject( $ofertari->email_subiect ?? 'Ofertare ValidSoftware Servicii Informatice');
        $message->attachData(
            $pdf->output(),
            'Ofertare nr. ' . $ofertari->nr_document . '.pdf'
        );

        return $message;
    }
}
