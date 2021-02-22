<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientCatrePartener extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $partener;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client, $partener)
    {
        $this->client = $client;
        $this->partener = $partener;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $client = $this->client;
        $partener = $this->partener;

        $message = $this->markdown('emails.client-catre-partener');

        $pdf = \PDF::loadView('emails.atasamente.oferta-de-servicii-pdf')
            ->setPaper('a4', 'portrait');

        $message->subject('Date Service Partener Focșani');
        $message->attachData(
            $pdf->output(),
            'Validsoftware - Oferta de servicii.pdf'
        );

        return $message;
    }
}
