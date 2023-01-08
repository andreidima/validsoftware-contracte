<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProcesVerbal extends Mailable
{
    use Queueable, SerializesModels;

    public $procesVerbal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($procesVerbal)
    {
        $this->procesVerbal = $procesVerbal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $procesVerbal = $this->procesVerbal;

        // $message = $this->markdown('emails.procesVerbal');
        $message = $this->view('emails.procesVerbalHtml');

        // $pdf = \PDF::loadView('proceseVerbale.export.procesVerbalPdf', compact('procesVerbal'))
        //     ->setPaper('a4', 'portrait');
        $procesVerbal->proces_verbal = str_replace('$id', $procesVerbal->id, $procesVerbal->proces_verbal);
        $procesVerbal->proces_verbal = str_replace('$data_emitere', (isset($procesVerbal->data_emitere) ? (Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY')) : ''), $procesVerbal->proces_verbal);
        $pdf = \PDF::loadHtml($procesVerbal->proces_verbal,'UTF-8')->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $message->subject($procesVerbal->email_subiect);
        $message->attachData(
            $pdf->output(),
            'Proces Verbal ValidSoftware, nr. ' . $procesVerbal->nr_document . '.pdf'
        );

        return $message;
    }
}
