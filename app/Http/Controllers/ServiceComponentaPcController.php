<?php

namespace App\Http\Controllers;

use App\ServiceComponentaPc;
use App\ServiceComponentaPcCategorie;

use Illuminate\Http\Request;

class ServiceComponentaPcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_categorie_id = \Request::get('search_categorie_id');

        $componente_pc = ServiceComponentaPc::with('categorie')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_categorie_id, function ($query, $search_categorie_id) {
                return $query->where('categorie_id', $search_categorie_id);
            })
            ->latest()
            ->simplePaginate(25);

        $categorii = ServiceComponentaPcCategorie::orderBy('nume')->get();

        return view('service.componente_pc.index', compact('componente_pc', 'categorii', 'search_nume', 'search_categorie_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorii = ServiceComponentaPcCategorie::orderBy('nume')->get();

        return view('service.componente_pc.create', compact('categorii'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $componenta_pc = ServiceComponentaPc::create($this->validateRequest($request));

        return redirect('/service/componente-pc')->with('status',
            'Componenta "' . $componenta_pc->nume . '" a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceComponentaPc  $componenta_pc
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceComponentaPc $componenta_pc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceComponentaPc  $componenta_pc
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceComponentaPc $componenta_pc)
    {
        $categorii = ServiceComponentaPcCategorie::orderBy('nume')->get();

        return view('service.componente_pc.edit', compact('componenta_pc'), compact('categorii'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceComponentaPc  $componenta_pc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceComponentaPc $componenta_pc)
    {
        $componenta_pc->update($this->validateRequest());

        return redirect('/service/componente-pc')->with('status',
            'Componenta "' . $componenta_pc->nume . '" a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceComponentaPc  $componenta_pc
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceComponentaPc $componenta_pc)
    {
        $componenta_pc->delete();

        return redirect('/service/componente-pc')->with('status',
            'Componenta "' . $componenta_pc->nume . '" a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request = null)
    {
        return request()->validate([
            'nume' => 'required|max:250',
            'categorie_id' => 'required'
        ]);
    }
}
