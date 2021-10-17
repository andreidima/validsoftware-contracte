<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CronJobTrimitere extends Mailable
{
    use Queueable, SerializesModels;

    public $cron_job;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cron_job)
    {
        $this->cron_job = $cron_job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cron_job = $this->cron_job;

        $message = $this->markdown('emails.cronjob');
        $message->subject($cron_job->subiect);
        foreach ($cron_job->fisiere as $fisier){
            $message->attachFromStorage($fisier->path . $fisier->nume);
        }

        //Adaugare fisier particular pentru "Notulae Botanicae Horti Agrobotanici"
        if($cron_job->id === 1) {
            $nr_document = \App\Variabila::Nr_document();

            $pdf = \PDF::loadView('cron-jobs.fisiere-particularizate-pdf.Notulae-Botanicae-Horti-Agrobotanici-pdf', compact('nr_document'))
                ->setPaper('a4', 'portrait');
            $message->attachData($pdf->output(),
                'Raport activitate site ' . \Carbon\Carbon::now()->subMonth()->isoFormat('MMMM YYYY') . '.pdf');
        }

        //Adaugare fisier particular pentru "Scoala Gimnaziala Stefan cel Mare Focsani"
        if($cron_job->id === 1) {
            $nr_document = \App\Variabila::Nr_document();

            $pdf = \PDF::loadView('cron-jobs.fisiere-particularizate-pdf.Scoala-Gimnaziala-Stefan-cel-Mare-Focsani-pdf', compact('nr_document'))
                ->setPaper('a4', 'portrait');
            $message->attachData($pdf->output(),
                'Raport activitate site ' . \Carbon\Carbon::now()->subMonth()->isoFormat('MMMM YYYY') . '.pdf');
        }


        return $message;
    }
}
