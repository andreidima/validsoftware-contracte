<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $clienti = Client::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            // ->where('tip', '!=', 'service')
            ->latest()
            ->simplePaginate(25);

        return view('clienti.index', compact('clienti', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clienti.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = Client::create($this->validateRequest($request));

        return redirect($client->path())->with('status', 'Clientul "' . $client->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $clienti)
    {
        return view('clienti.show', compact('clienti'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $clienti)
    {
        return view('clienti.edit', compact('clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $clienti)
    {
        $this->validateRequest($request, $clienti);
        $clienti->update($request->all());

        return redirect($clienti->path())->with('status', 'Clientul "' . $clienti->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $clienti)
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
            'nume' => ['required', 'max:200'],
            'nume_scurt' => ['required', 'max:200'],
            'nr_ord_reg_com' => ['max:50'],
            'cui' => ['max:50'],
            'adresa' => ['max:180'],
            'iban' => ['max:100'],
            'banca' => ['max:100'],
            'reprezentant' => ['max:100'],
            'reprezentant_functie' => ['max:100'],
            'telefon' => ['max:100'],
            'email' => ['nullable'],
            'email_dpo' => ['nullable', 'max:100'],
            'site_web' => ['nullable', 'max:180']
        ]);
    }
}
