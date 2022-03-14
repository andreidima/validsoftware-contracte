<?php

namespace App\Http\Controllers;

use App\OfertareServiciu;

use Illuminate\Http\Request;

class OfertareServiciuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        // $search_nume = 'a';

        $ofertari_servicii = OfertareServiciu::
            orderBy('nume')
            ->simplePaginate(25);

        return view('ofertari-servicii.index', compact('ofertari_servicii', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ofertari-servicii.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ofertare_serviciu = OfertareServiciu::create($this->validateRequest($request));

        return redirect('/ofertari-servicii')->with('status',
            'Serviciul "' . $ofertare_serviciu->nume . '", pentru ofertări, a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ofertare  $ofertare
     * @return \Illuminate\Http\Response
     */
    public function show(OfertareServiciu $ofertari_servicii)
    {
        return view('ofertari.show', compact('ofertari'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ofertare  $ofertare
     * @return \Illuminate\Http\Response
     */
    public function edit(OfertareServiciu $ofertari_servicii)
    {
        return view('ofertari-servicii.edit', compact('ofertari_servicii'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ofertare  $ofertare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfertareServiciu $ofertari_servicii)
    {
        $this->validateRequest($request, $ofertari_servicii);
        $ofertari_servicii->update($request->all());

        return redirect('/ofertari-servicii')->with('status',
            'Serviciul "' . $ofertari_servicii->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ofertare  $ofertare
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfertareServiciu $ofertari_servicii)
    {
        $ofertari_servicii->delete();

        return redirect('/ofertari-servicii')->with('status',
            'Serviciul "' . $ofertari_servicii->nume . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'nume' => ['required', 'max:1000'],
            'pret' => ['nullable', 'between:0.01,99999.99'],
            'recurenta' => ['nullable', 'max:100']
        ]);
    }
}
