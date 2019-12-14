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
        $clienti = Client::select('id', 'nume')
            ->orderBy('nume')
            ->get();
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
        // dd($request);
        $contract = Contract::create($this->validateRequest($request));

        return redirect($contract->path())->with('status', 
            'Contractul Nr."' . $contract->contract_nr . '", pentru clientul "' . ($contract->client->nume ?? '') . '", a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contracte)
    {
        return view('contracte.show', compact('contracte'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contracte)
    {
        $clienti = Client::select('id', 'nume')
            ->orderBy('nume')
            ->get();

        return view('contracte.edit', compact('contracte', 'clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contracte)
    {
        $this->validateRequest($request, $contracte);
        $contracte->update($request->except(['date']));

        return redirect($contracte->path())->with('status', 
            'Contractul Nr."' . $contracte->contract_nr . '", pentru clientul "' . ($contracte->client->nume ?? '') . '", a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contracte)
    {
        $contracte->delete();
        return redirect('/contracte')->with('status', 
            'Contractul Nr."' . $contracte->contract_nr . '", pentru clientul "' . ($contracte->client->nume ?? '') . '", a fost șters cu succes!');
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
            'contract_nr' => ['required', 'numeric'],
            'contract_data' => [''],
            'data_incepere' => [''],
            'anexa' => ['']
        ]);
    }
}
