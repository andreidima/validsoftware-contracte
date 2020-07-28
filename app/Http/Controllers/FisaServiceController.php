<?php

namespace App\Http\Controllers;

use App\FisaService;
use Illuminate\Http\Request;

class FisaServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clienti = \App\Client::all();
        $clienti = $clienti->where('tip', 'service')->sortBy('nume')->values();

        $urmatorul_document_nr = \DB::table('variabile')->where('nume', 'nr_document')->first()->valoare;

        return view('fise-service.create', compact('clienti', 'urmatorul_document_nr'));
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
     * @param  \App\FisaService  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function show(FisaService $fisaService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FisaService  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function edit(FisaService $fisaService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FisaService  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FisaService $fisaService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FisaService  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function destroy(FisaService $fisaService)
    {
        //
    }
}
