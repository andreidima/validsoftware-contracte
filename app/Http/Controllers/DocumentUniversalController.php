<?php

namespace App\Http\Controllers;

use App\DocumentUniversal;
use App\Firma;
use App\Client;
use App\Variabila;
use DB;
use Illuminate\Http\Request;

use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentUniversalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_titlu_document = \Request::get('search_titlu_document');
        $search_nume = \Request::get('search_nume');

        $documenteUniversale = DocumentUniversal::with('fisiere')
            ->leftJoin('clienti', 'documente_universale.client_id', '=', 'clienti.id')
            ->select('documente_universale.*', 'clienti.nume')
            ->when($search_titlu_document, function ($query, $search_titlu_document) {
                return $query->where('documente_universale.titlu_document', 'like', '%' . $search_titlu_document . '%');
            })
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('clienti.nume', 'like', '%' . $search_nume . '%');
            })
            ->latest('documente_universale.created_at')
            ->withCount('fisiere')
            ->simplePaginate(25);

        return view('documenteUniversale.index', compact('documenteUniversale', 'search_titlu_document', 'search_nume'));
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

        return view('documenteUniversale.create', compact('firme', 'clienti', 'urmatorul_document_nr'));
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
        $documentUniversal = DocumentUniversal::create($this->validateRequest($request));

        return redirect($documentUniversal->path())->with('status',
            'Documentul Nr."' . $documentUniversal->nr_document . '", pentru clientul "' . ($documentUniversal->client->nume ?? '') . '", a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DocumentUniversal  $ofertare
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentUniversal $documentUniversal)
    {
        return view('documenteUniversale.show', compact('documentUniversal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DocumentUniversal  $documentUniversal
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentUniversal $documentUniversal)
    {
        $firme = Firma::select('id', 'nume')->orderBy('nume')->get();

        $clienti = Client::select('id', 'nume', 'telefon')
            ->orderBy('nume')
            ->get();

        return view('documenteUniversale.edit', compact('documentUniversal', 'firme', 'clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DocumentUniversal  $documentUniversal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentUniversal $documentUniversal)
    {
        $documentUniversal->update($this->validateRequest($request, $documentUniversal));

        return redirect($documentUniversal->path())->with('status',
            'Documentul Nr."' . $documentUniversal->nr_document . '", pentru clientul "' . ($documentUniversal->client->nume ?? '') . '", a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DocumentUniversal  $documentUniversal
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentUniversal $documentUniversal)
    {
        $documentUniversal->delete();
        return redirect('/documente-universale')->with('status',
            'Documentul Nr."' . $documentUniversal->nr_document . '", pentru clientul "' . ($documentUniversal->client->nume ?? '') . '", a fost șters cu succes!');
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
            'titlu_document' => 'required|max:200',
            'document_universal' => ['required'],
            'email_subiect' => 'required',
            'email_text' => 'required',
        ]);
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function pdfExport(Request $request, DocumentUniversal $documentUniversal)
    {
        // $documentUniversal->document_universal = str_replace('$nr_document', $documentUniversal->nr_document, $documentUniversal->document_universal);
        // $documentUniversal->document_universal = str_replace('$data_emitere', (isset($documentUniversal->data_emitere) ? (Carbon::parse($documentUniversal->data_emitere)->isoFormat('DD.MM.YYYY')) : ''), $documentUniversal->document_universal);
        // $documentUniversal->document_universal = str_replace('$client_nume', ($documentUniversal->client->nume ?? ''), $documentUniversal->document_universal);


        if ($request->view_type === 'html') {
            return view('documenteUniversale.export.documentUniversalPdf', compact('documentUniversal'));
        } elseif ($request->view_type === 'pdf') {
            $pdf = \PDF::loadView('documenteUniversale.export.documentUniversalPdf', compact('documentUniversal'))
                ->setPaper('a4', 'portrait');
            $pdf->getDomPDF()->set_option("enable_php", true);
            return $pdf->download(
                $documentUniversal->titlu_document . ' nr. ' . $documentUniversal->nr_document . (isset($documentUniversal->data_emitere) ? (' din data de ' . Carbon::parse($documentUniversal->data_emitere)->isoFormat('DD.MM.YYYY')) : '') .
                    ' - ' . ($documentUniversal->client->nume ?? '') . '.pdf'
            );
            // return $pdf->stream();
        }
    }

    protected function trimiteEmail(Request $request, DocumentUniversal $documentUniversal)
    {
        $emailuri_to = $documentUniversal->client->email ?? '';
        if(empty($emailuri_to)) {
            return back()->with('error', 'Clientul ' . $documentUniversal->client->nume . ' nu are email completat.');
        };

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
                new \App\Mail\DocumentUniversal($documentUniversal)
            );
        $mesaj_trimis = new \App\MesajTrimis;
        $mesaj_trimis->inregistrare_id = $documentUniversal->id;
        $mesaj_trimis->categorie = 'Document universal';
        // $mesaj_trimis->subcategorie = '';
        $mesaj_trimis->save();
        return back()->with('status', 'Emailul a fost trimis către „' . ($documentUniversal->client->email ?? '') . '” cu succes!');
    }

    public function duplicaDocumentUniversal(Request $request, DocumentUniversal $documentUniversal)
    {
        $documentUniversal = $documentUniversal->replicate();

        $documentUniversal->nr_document = Variabila::Nr_document(); // se da un nr nou
        $documentUniversal->created_at = Carbon::now();
        $documentUniversal->updated_at = Carbon::now();

        $documentUniversal->save();

        return redirect()->action(
            'DocumentUniversalController@edit',
            ['documentUniversal' => $documentUniversal->id]
        );
    }
}
