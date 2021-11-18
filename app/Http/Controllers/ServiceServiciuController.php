<?php

namespace App\Http\Controllers;

use App\ServiceServiciu;
use App\ServiceServiciuCategorie;

use Illuminate\Http\Request;

class ServiceServiciuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');

        $servicii = ServiceServiciu::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->orderBy('nr_de_ordine')
            ->simplePaginate(25);

        return view('service.servicii.index', compact('servicii', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorii = ServiceServiciuCategorie::orderBy('nume')->get();

        return view('service.servicii.create', compact('categorii'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Reordonare dupa numar de ordine
        if (is_null($request->nr_de_ordine)){
            $request->merge([
                'nr_de_ordine' => ServiceServiciu::max('nr_de_ordine') + 1,
            ]);
        } else {
            $servicii_vechi = ServiceServiciu::where('nr_de_ordine', '>=', $request->nr_de_ordine)->orderBy('nr_de_ordine')->get();
            $nr_de_ordine = $request->nr_de_ordine;
            foreach ($servicii_vechi as $serviciu_vechi){
                $nr_de_ordine ++;
                $serviciu_vechi->nr_de_ordine = $nr_de_ordine;
                $serviciu_vechi->save();
            }
        }

        $serviciu = ServiceServiciu::create($this->validateRequest($request));

        return redirect('/service/servicii')->with('status',
            'Serviciul "' . $serviciu->nume . '", pentru service, a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceServiciu  $serviceServiciu
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceServiciu $serviceServiciu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceServiciu  $serviceServiciu
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceServiciu $servicii)
    {
        $categorii = ServiceServiciuCategorie::orderBy('nume')->get();

        return view('service.servicii.edit', compact('servicii', 'categorii'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceServiciu  $serviceServiciu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceServiciu $servicii)
    {
        // Reordonare dupa numar de ordine
        if (is_null($request->nr_de_ordine)){
            $request->merge([
                'nr_de_ordine' => ServiceServiciu::max('nr_de_ordine') + 1,
            ]);
        } else if ($servicii->nr_de_ordine != $request->nr_de_ordine){
            $servicii_vechi = ServiceServiciu::where('nr_de_ordine', '>=', $request->nr_de_ordine)->orderBy('nr_de_ordine')->get();
            $nr_de_ordine = $request->nr_de_ordine;
            foreach ($servicii_vechi as $serviciu_vechi){
                $nr_de_ordine ++;
                $serviciu_vechi->nr_de_ordine = $nr_de_ordine;
                $serviciu_vechi->save();
            }
        }

        $servicii->update($this->validateRequest());

        return redirect('service/servicii')->with('status',
            'Serviciul "' . $servicii->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceServiciu  $serviceServiciu
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceServiciu $servicii)
    {
        $servicii->delete();

        return redirect('/service/servicii')->with('status',
            'Serviciul "' . $servicii->nume . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request = null)
    {
        return request()->validate([
            'nume' => ['required', 'max:250'],
            'pret' => ['nullable', 'between:0.01,99999.99'],
            'categorie_id' => 'nullable',
            'link_review_site' => ['nullable', 'max:250'],
            'nr_de_ordine' => 'nullable|numeric'
        ]);
    }
}
