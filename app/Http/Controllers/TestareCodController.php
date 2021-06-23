<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestareCodController extends Controller
{
    public function testareCod(Request $request)
    {
        $nr_document = \App\Variabila::Nr_document();
        if ($request->view_type === 'html') {
            return view('cron-jobs.fisiere-particularizate-pdf.Notulae-Botanicae-Horti-Agrobotanici-pdf', compact('nr_document'));
        } elseif ($request->view_type === 'pdf') {
            $pdf = \PDF::loadView('cron-jobs.fisiere-particularizate-pdf.Notulae-Botanicae-Horti-Agrobotanici-pdf', compact('nr_document'))
                ->setPaper('a4', 'portrait');
            return $pdf->download('Raport activitate site ' . \Carbon\Carbon::now()->subMonth()->isoFormat('MMMM YYYY') . '.pdf');
            // return $pdf->stream();
        }

    }

    public function CopyToClipboard()
    {
        return view('testare_cod.copy_to_clipboard');
    }
}
