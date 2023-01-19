<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Carbon\Carbon;

class Contract extends Mailable
{
    use Queueable, SerializesModels;

    public $contracte;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contracte)
    {
        $this->contracte = $contracte;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $contracte = $this->contracte;

        $message = $this->view('emails.contractHtml');

        $message->subject( $contracte->email_subiect ?? 'Contract ValidSoftware Servicii Informatice');

        $pdf = \PDF::loadView('contracte.export.contract-pdf', compact('contracte'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $message->attachData(
            $pdf->output(),
            'Contract nr. ' . $contracte->contract_nr .
            (isset($contracte->contract_data) ? (' din data de ' . Carbon::parse($contracte->contract_data)->isoFormat('DD.MM.YYYY')) : '') .
            ' - ' . ($contracte->client->nume ?? '') . '.pdf'
        );

        return $message;
    }
}
