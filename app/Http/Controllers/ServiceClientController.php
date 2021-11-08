<?php

namespace App\Http\Controllers;

use App\ServiceClient;
use App\ServiceServiciu;
use App\ServicePartener;
use App\Mail\ClientCatrePartener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_telefon = \Request::get('search_telefon');
        $clienti = ServiceClient::with('emailuri_trimise_client_catre_partener')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_telefon, function ($query, $search_telefon) {
                return $query->where('telefon', 'like', '%' . $search_telefon . '%');
            })
            // ->where('tip', 'service')
            ->latest()
            ->Paginate(25);

        $parteneri = ServicePartener::orderBy('nume')->get();

        return view('service.clienti.index', compact('clienti', 'parteneri', 'search_nume', 'search_telefon'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $servicii = ServiceServiciu::orderBy('nume')->get();
        return view('service.clienti.create', compact('servicii'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $client = ServiceClient::create(array_merge($this->validateRequest($request),['tip' => 'service']));
        $client = ServiceClient::create($this->validateRequest($request));

        return redirect($client->path())->with('status', 'Clientul "' . $client->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceClient  $client
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceClient $clienti)
    {
        return view('service.clienti.show', compact('clienti'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceClient  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceClient $clienti)
    {
        $servicii = ServiceServiciu::orderBy('nume')->get();

        return view('service.clienti.edit', compact('clienti', 'servicii'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceClient  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceClient $clienti)
    {
        $clienti->update($this->validateRequest($request));

        $clienti->servicii_review()->sync($request->input('servicii_selectate'));

        return redirect($clienti->path())->with('status', 'Clientul "' . $clienti->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceClient  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceClient $clienti)
    {
        $clienti->delete();
        return redirect('/service/clienti')->with('status', 'Clientul "' . $clienti->nume . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'nume' => ['required', 'max:100'],
            'nr_ord_reg_com' => ['max:50'],
            'cui' => ['max:50'],
            'adresa' => ['max:180'],
            'iban' => ['max:100'],
            'banca' => ['max:100'],
            'reprezentant' => ['max:100'],
            'reprezentant_functie' => ['max:100'],
            'telefon' => ['numeric', 'digits:10'],
            'email' => ['nullable', 'max:180'],
            'site_web' => ['nullable', 'max:180'],
            'review_google' => ['']
        ]);
    }

    public function trimiteEmail(Request $request, ServiceClient $client)
    {
        $validator = Validator::make($request->toArray(), [
            'partener_id' => ['required']
        ]);
        if ($validator->fails()) {
            return redirect('/service/clienti')->with('error', 'Selectati un partener către care doriți să se trimită emailul.');
        }

        $validator = Validator::make($client->toArray(), [
            'email' => ['email:rfc,dns']
        ]);
        if ($validator->fails()) {
            return redirect('/service/clienti')->with('error', 'Emailul Clientului nu este o adresă de e-mail validă.');
        }

        $partener = ServicePartener::where('id', $request->partener_id)->first();
        $validator = Validator::make($partener->toArray(), [
            'email' => ['email:rfc,dns']
        ]);
        if ($validator->fails()) {
            return redirect('/service/clienti')->with('error', 'Emailul Partenerului nu este o adresă de e-mail validă.');
        }

        // dd($partener, $client);

        // Extragere din baza de date a emailurilor interne ale firmei catre care sa se trimita mesajul cu BCC
        $emailuri_bcc = \App\Variabila::select('valoare')->where('nume', 'emailuri_service_bcc')->first()->valoare;
        $emailuri_bcc = str_replace(' ', '', $emailuri_bcc);
        $emailuri_bcc = explode(',', $emailuri_bcc);

        \Mail::mailer('service')
            ->to($client->email)
            ->cc($partener->email)
            ->bcc($emailuri_bcc)
            ->send(
                new ClientCatrePartener($client, $partener)
            );
        $mesaj_trimis = new \App\MesajTrimis;
        $mesaj_trimis->inregistrare_id = $client->id;
        $mesaj_trimis->categorie = 'Client';
        $mesaj_trimis->subcategorie = 'Partener';
        $mesaj_trimis->save();
        return back()->with('status', 'Clientului ' . $client->nume . ' i-a fost trimis Email cu Partenerul „' . $partener->nume . '”, cu succes!');

        // $servicii = ServiceServiciu::orderBy('nume')->get();

        // return view('service.clienti.edit', compact('clienti', 'servicii'));
    }

    // Afisarea tuturor emailurilor clientilor de service pentru folosirea lor externa. de trimitere mesaje in masă
    public function emailuri()
    {
        $clienti = ServiceClient::select('email')
            ->where('email', '<>' , null)
            ->orderBy('email', 'asc')
            ->get();

        return view('service.clienti.diverse.emailuri', compact('clienti'));
    }
}
