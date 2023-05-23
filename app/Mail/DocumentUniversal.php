<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Carbon\Carbon;

class DocumentUniversal extends Mailable
{
    use Queueable, SerializesModels;

    public $documentUniversal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($documentUniversal)
    {
        $this->documentUniversal = $documentUniversal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $documentUniversal = $this->documentUniversal;


        // $message = $this->markdown('emails.documentUniversal');
        // $message = $this->view('emails.documentUniversalHtml');
        $message = $this->view('emails.documentUniversal');

        $pdf = \PDF::loadView('documenteUniversale.export.documentUniversalPdf', compact('documentUniversal'))
            ->setPaper('a4', 'portrait');

        // $documentUniversal->document_universal = str_replace('$nr_document', $documentUniversal->nr_document, $documentUniversal->document_universal);
        // $documentUniversal->document_universal = str_replace('$data_emitere', (isset($documentUniversal->data_emitere) ? (Carbon::parse($documentUniversal->data_emitere)->isoFormat('DD.MM.YYYY')) : ''), $documentUniversal->document_universal);
        // $documentUniversal->document_universal = str_replace('$client_nume', ($documentUniversal->client->nume ?? ''), $documentUniversal->document_universal);

        // $pdf = \PDF::loadHtml($documentUniversal->document_universal,'UTF-8')->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $message->subject($documentUniversal->email_subiect);
        $message->attachData(
            $pdf->output(),
            $documentUniversal->titlu_document . ' nr. ' . $documentUniversal->nr_document . ' din ' .
                (isset($documentUniversal->data_emitere) ? (Carbon::parse($documentUniversal->data_emitere)->isoFormat('DD.MM.YYYY')) : '') . '.pdf'
        );

        foreach ($documentUniversal->fisiere as $fisier){
            // dd(storage_path($fisier->path . $fisier->nume));
            $message->attach(storage_path('app/' . $fisier->path . $fisier->nume));
        }

        return $message;
    }
}
