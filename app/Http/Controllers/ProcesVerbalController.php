<?php

namespace App\Http\Controllers;

use App\ProcesVerbal;
use App\Firma;
use App\Client;
use App\Variabila;
use DB;
use Illuminate\Http\Request;

use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProcesVerbalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');

        $proceseVerbale = ProcesVerbal::
            leftJoin('clienti', 'procese_verbale.client_id', '=', 'clienti.id')
            ->select('procese_verbale.*', 'clienti.nume')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('clienti.nume', 'like', '%' . $search_nume . '%');
            })
            ->latest('procese_verbale.created_at')
            ->simplePaginate(25);

        return view('proceseVerbale.index', compact('proceseVerbale', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $firme = Firma::select('id', 'nume')->orderBy('nume')->get();

        $clienti = Client::select('id', 'nume', 'telefon')
            ->orderBy('nume')
            ->get();

        $urmatorul_document_nr = \DB::table('variabile')->where('nume', 'nr_document')->first()->valoare;

        return view('proceseVerbale.create', compact('firme', 'clienti', 'urmatorul_document_nr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \App\Variabila::Nr_document();
        $procesVerbal = ProcesVerbal::create($this->validateRequest($request));

        return redirect($procesVerbal->path())->with('status',
            'Procesul Verbal Nr."' . $procesVerbal->nr_document . '", pentru clientul "' . ($procesVerbal->client->nume ?? '') . '", a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProcesVerbal  $ofertare
     * @return \Illuminate\Http\Response
     */
    public function show(ProcesVerbal $procesVerbal)
    {
        return view('proceseVerbale.show', compact('procesVerbal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProcesVerbal  $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcesVerbal $procesVerbal)
    {
        $firme = Firma::select('id', 'nume')->orderBy('nume')->get();

        $clienti = Client::select('id', 'nume', 'telefon')
            ->orderBy('nume')
            ->get();

        return view('proceseVerbale.edit', compact('procesVerbal', 'firme', 'clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProcesVerbal  $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProcesVerbal $procesVerbal)
    {
        $procesVerbal->update($this->validateRequest($request, $procesVerbal));

        return redirect($procesVerbal->path())->with('status',
            'Procesul Verbal Nr."' . $procesVerbal->nr_document . '", pentru clientul "' . ($procesVerbal->client->nume ?? '') . '", a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProcesVerbal  $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcesVerbal $procesVerbal)
    {
        $procesVerbal->delete();
        return redirect('/procese-verbale')->with('status',
            'Procesul Verbal Nr."' . $procesVerbal->nr_document . '", pentru clientul "' . ($procesVerbal->client->nume ?? '') . '", a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'nr_document' => ['required', 'numeric'],
            'data_emitere' => ['required'],
            'firma_id' => ['required'],
            'client_id' => ['required'],
            'proces_verbal' => ['required'],
            'email_subiect' => 'required',
            'email_text' => 'required',
        ]);
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function pdfExport(Request $request, ProcesVerbal $procesVerbal)
    {
        if ($request->view_type === 'html') {
            return view('proceseVerbale.export.procesVerbalPdf', compact('procesVerbal'));
        } elseif ($request->view_type === 'pdf') {
            $pdf = \PDF::loadView('proceseVerbale.export.procesVerbalPdf', compact('procesVerbal'))
                ->setPaper('a4', 'portrait');
            $pdf->getDomPDF()->set_option("enable_php", true);
            return $pdf->download(
                'Proces Verbal nr. ' . $procesVerbal->nr_document . (isset($procesVerbal->data_emitere) ? (' din data de ' . Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY')) : '') .
                    ' - ' . ($procesVerbal->client->nume ?? '') . '.pdf'
            );
            // return $pdf->stream();
        }
    }

    protected function trimiteEmail(Request $request, ProcesVerbal $procesVerbal)
    {
        $emailuri_to = $procesVerbal->client->email ?? '';
        $emailuri_to = str_replace(' ', '', $emailuri_to);
        $emailuri_to = explode(',', $emailuri_to);
        // Verificare daca exista email corect catre care sa se trimita mesajul
        $validator = Validator::make($emailuri_to, [
            '*' => ['email:rfc,dns']
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Extragere din baza de date a emailurilor interne ale firmei catre care sa se trimita mesajul cu BCC
        $emailuri_bcc = \App\Variabila::select('valoare')->where('nume', 'emailuri_service_bcc')->first()->valoare;
        $emailuri_bcc = str_replace(' ', '', $emailuri_bcc);
        $emailuri_bcc = explode(',', $emailuri_bcc);
        // Verificare daca exista email corect catre care sa se trimita mesajul
        $validator = Validator::make($emailuri_bcc, [
            '*' => ['email:rfc,dns']
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

// dd($emailuri_to, $emailuri_bcc);
        // Trimiterea mesajului
        \Mail::mailer('comunicare')
            ->to($emailuri_to)
            ->bcc($emailuri_bcc)
            ->send(
                new \App\Mail\ProcesVerbal($procesVerbal)
            );
        $mesaj_trimis = new \App\MesajTrimis;
        $mesaj_trimis->inregistrare_id = $procesVerbal->id;
        $mesaj_trimis->categorie = 'Proces verbal';
        // $mesaj_trimis->subcategorie = '';
        $mesaj_trimis->save();
        return back()->with('status', 'Emailul a fost trimis către „' . ($procesVerbal->client->email ?? '') . '” cu succes!');
    }

    public function duplicaProcesVerbal(Request $request, ProcesVerbal $procesVerbal)
    {
        $procesVerbal = $procesVerbal->replicate();

        $procesVerbal->nr_document = Variabila::Nr_document(); // se da un nr nou
        $procesVerbal->created_at = Carbon::now();
        $procesVerbal->updated_at = Carbon::now();

        $procesVerbal->save();

        return redirect()->action(
            'ProcesVerbalController@edit',
            ['procesVerbal' => $procesVerbal->id]
        );
    }
}
