<?php

namespace App\Http\Controllers;

use App\ServiceFisa;
use App\ServiceClient;
use Illuminate\Http\Request;

class ServiceFisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_numar = \Request::get('search_numar');
        $search_nume = \Request::get('search_nume');
            
        $service_fise = ServiceFisa::
            leftJoin('service_clienti', 'service_fise.client_id', '=', 'service_clienti.id')
            ->select(
                'service_fise.*', 
                'service_clienti.nume',                
                'service_clienti.nr_ord_reg_com',                
                'service_clienti.cui',                
                'service_clienti.adresa',                
                'service_clienti.iban',                
                'service_clienti.banca',                
                'service_clienti.reprezentant',                
                'service_clienti.reprezentant_functie',                
                'service_clienti.telefon',                
                'service_clienti.email',                
                'service_clienti.site_web'
            )
            ->when($search_numar, function ($query, $search_numar) {
                return $query->where('service_fise.nr_fisa', $search_numar);
            })
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('service_clienti.nume', 'like', '%' . $search_nume . '%');
            })
            ->latest('service_fise.created_at')
            ->simplePaginate(25);

        return view('service.fise.index', compact('service_fise', 'search_numar', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clienti = ServiceClient::all();
        $clienti = $clienti->sortBy('nume')->values();

        $urmatorul_document_nr = \DB::table('variabile')->where('nume', 'nr_document')->first()->valoare;

        return view('service.fise.create', compact('clienti', 'urmatorul_document_nr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = ServiceClient::where('id', $request->client_deja_inregistrat)->first();
        if (isset($client)){
            $client->update($this->validateRequestClient($request));
        } else {
            $client = ServiceClient::make($this->validateRequestClient($request));
            $client->save();
        }

        $service_fisa = ServiceFisa::make($this->validateRequestFisa($request));
        $service_fisa->client_id = $client->id;
        $service_fisa->save();
        
        // Incrementare nr_document
        \App\Variabila::Nr_document();

        return redirect($service_fisa->path())->with('status', 
            'Fișa de service Nr."' . $service_fisa->nr_fisa . '", pentru clientul "' . ($service_fisa->client->nume ?? '') . '", a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceFisa  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceFisa $fise)
    {
        return view('service.fise.show', compact('fise'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceFisa  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceFisa $fise)
    {
        $clienti = ServiceClient::all();
        $clienti = $clienti->sortBy('nume')->values();

        return view('service.fise.edit', compact('fise', 'clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceFisa  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceFisa $fise)
    {
        $client = ServiceClient::where('id', $request->client_deja_inregistrat)->first();
        if (isset($client)){
            $client->update($this->validateRequestClient($request));
        } else {
            $client = ServiceClient::make($this->validateRequestClient($request));
            $client->save();
        }

        $fise->update($this->validateRequestFisa($request, $fise));

        return redirect($fise->path())->with('status', 
            'Fișa de service Nr."' . $fise->nr_fisa . '", pentru clientul "' . ($fise->client->nume ?? '') . '", a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceFisa  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceFisa $fisaService)
    {
        //
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequestClient(Request $request)
    {
        return request()->validate([
            'client_id' =>['nullable'],
            'nume' => ['required', 'max:100'],
            'nr_ord_reg_com' => ['max:50'],
            'cui' => ['max:50'],
            'adresa' => ['max:180'],
            'iban' => ['max:100'],
            'banca' => ['max:100'],
            'reprezentant' => ['max:100'],
            'reprezentant_functie' => ['max:100'],
            'telefon' => ['max:100'],
            'email' => ['nullable', 'max:180'],
            'site_web' => ['nullable', 'max:180'],
        ]);
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequestFisa(Request $request)
    {
        return request()->validate([
            'nr_fisa' => ['required', 'numeric'],
            'tehnician_service' => ['max:90'],
            'data_receptie' => [''],
            'descriere_echipament' => [''],
            'defect_reclamat' => [''],
            'defect_constatat' => [''],
            'rezultat_service' => [''],
            'observatii' => [''],
            'data_ridicare' => ['']
        ]);
    }
}
