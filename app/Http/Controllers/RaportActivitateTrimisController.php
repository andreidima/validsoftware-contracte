<?php

namespace App\Http\Controllers;

use App\RaportActivitateTrimis;
use Illuminate\Http\Request;

class RaportActivitateTrimisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $search_client = \Request::get('search_client'); //<-- we use global request to get the param of URI   
        $search_contract_nr = \Request::get('search_contract_nr');     
        $search_data_inceput = \Request::get('search_data_inceput');
        $search_data_sfarsit = \Request::get('search_data_sfarsit');
        $rapoarte_activitate_trimise = RaportActivitateTrimis::with('contract', 'client')
            ->whereHas('contract', function ($query) use ($search_contract_nr) {
                $query->where('contract_nr', 'like', '%' . $search_contract_nr . '%');
            })
            ->when($search_data_inceput, function ($query, $search_data_inceput) {
                return $query->whereDate('created_at', '>=', $search_data_inceput);
            })
            ->when($search_data_sfarsit, function ($query, $search_data_sfarsit) {
                // return $query->whereDate('created_at', '<=', \Carbon\Carbon::parse($search_data_sfarsit)->addDay());
                return $query->whereDate('created_at', '<=', $search_data_sfarsit);
            })
            // ->oldest()
            ->latest()
            ->simplePaginate(25);

        return view('rapoarte_activitate_trimise.index', 
            compact('rapoarte_activitate_trimise', 'search_contract_nr', 'search_data_inceput', 'search_data_sfarsit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RaportActivitateTrimis  $raportActivitateTrimis
     * @return \Illuminate\Http\Response
     */
    public function show(RaportActivitateTrimis $raportActivitateTrimis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RaportActivitateTrimis  $raportActivitateTrimis
     * @return \Illuminate\Http\Response
     */
    public function edit(RaportActivitateTrimis $raportActivitateTrimis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RaportActivitateTrimis  $raportActivitateTrimis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RaportActivitateTrimis $raportActivitateTrimis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RaportActivitateTrimis  $raportActivitateTrimis
     * @return \Illuminate\Http\Response
     */
    public function destroy(RaportActivitateTrimis $raportActivitateTrimis)
    {
        //
    }
}
