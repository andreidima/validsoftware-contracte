<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FisaService extends Mailable
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

        $message = $this->markdown('emails.fisa-service');
        $message->subject($cron_job->subiect);
        foreach ($cron_job->fisiere as $fisier) {
            $message->attachFromStorage($fisier->path . $fisier->nume);
        }

        return $message;
    }
}
