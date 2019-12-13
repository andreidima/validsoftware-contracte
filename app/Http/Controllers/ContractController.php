<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Client;
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

        $contracte = Contract::latest()
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
        $clienti = Client::select('id', 'nume')->get();
        $urmatorul_contract_nr = Contract::max('contract_nr') + 1;

        return view('contracte.create', compact('clienti', 'urmatorul_contract_nr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contract = Contract::create($this->validateRequest($request));

        return redirect($contract->path())->with('status', 
            'Contractul "' . $contract->contract_nr . '", pentru clientul "' . $contract->client . '", a fost adăugat cu succes!');
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
            'client_id' => ['required'],
            'contract_nr' => ['numeric'],
            'contract_data' => [''],
            'data_incepere' => [''],
            'anexa' => ['']
        ]);
    }
}
