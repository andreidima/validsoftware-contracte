<?php

namespace App\Http\Controllers;

use App\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $search_nume = \Request::get('search_nume');
        // $contracte = Client::when($search_nume, function ($query, $search_nume) {
        //         return $query->where('nume', 'like', '%' . $search_nume . '%');
        //     })
        //     ->latest()
        //     ->Paginate(25);
        // return view('contracte.index', compact('contracte', 'search_nume'));

        $contracte = Client::all()
            ->latest()
            ->Paginate(25);

        return view('contracte.index', compact('contracte'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contracte.create');
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
    public function show(Client $contracte)
    {
        return view('contracte.show', compact('contracte'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $contracte)
    {
        return view('contracte.edit', compact('contracte'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $contracte)
    {
        $this->validateRequest($request, $contracte);
        $contracte->update($request->all());

        return redirect($contracte->path())->with('status', 'Clientul "' . $contracte->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $contracte)
    {
        $contracte->delete();
        return redirect('/contracte')->with('status', 'Clientul "' . $contracte->nume . '" a fost șters cu succes!');
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
            'telefon' => ['max:100'],
            'email' => ['nullable', 'email', 'max:100']
        ]);
    }
}
