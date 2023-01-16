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

        // if (intval($ofertari->solicitata) === 0){
        //     $message = $this->view('emails.ofertareHtml');
        // } else {
        //     $message = $this->markdown('emails.ofertare');
        // }
        $message = $this->view('emails.ofertareHtml');

        $message->subject( $ofertari->email_subiect ?? 'Ofertare ValidSoftware Servicii Informatice');

        if ($ofertari->pdf_in_email === 1){
            $pdf = \PDF::loadView('ofertari.export.ofertare-pdf', compact('ofertari'))
                ->setPaper('a4', 'portrait');
            $pdf->getDomPDF()->set_option("enable_php", true);

            $message->attachData(
                $pdf->output(),
                ((intval($ofertari->solicitata) === 0) ? 'Ofertarea' : 'Cererea') .
                ' Validsoftware nr. ' . $ofertari->nr_document . (isset($ofertari->data_emitere) ? (' din ' . \Carbon\Carbon::parse($ofertari->data_emitere)->isoFormat('DD.MM.YYYY')) : '') .
                    // ' - ' . ($ofertari->client->nume ?? '') . '.pdf'
                    '.pdf'
            );
        }

        return $message;
    }
}
