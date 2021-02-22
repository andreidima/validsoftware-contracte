<?php

namespace App\Http\Controllers;

use App\ServiceClient;
use App\ServiceServiciu;
use Illuminate\Http\Request;

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
        $clienti = ServiceClient::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            // ->where('tip', 'service')
            ->latest()
            ->Paginate(25);
            
        return view('service.clienti.index', compact('clienti', 'search_nume'));
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
        return redirect('/clienti')->with('status', 'Clientul "' . $clienti->nume . '" a fost șters cu succes!');
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
}
