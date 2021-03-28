<?php

namespace App\Http\Controllers;

use App\ServiceComponentaPcCategorie;
use Illuminate\Http\Request;

class ServiceComponentaPcCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');

        $categorii = ServiceComponentaPcCategorie::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->orderBy('nume')
            ->simplePaginate(25);

        return view('service.componente_pc_categorii.index', compact('categorii', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service.componente_pc.categorii.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categorie = ServiceComponentaPcCategorie::create($this->validateRequest($request));

        return redirect('/service/componente-pc/categorii')->with('status',
            'Categoria "' . $categorie->nume . '" a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceComponentaPcCategorie  $serviceServiciu
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceComponentaPcCategorie $serviceComponentaPcCategorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceComponentaPcCategorie  $serviceServiciu
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceComponentaPcCategorie $serviceComponentaPcCategorie)
    {
        return view('service.componente_pc.categorii.edit', compact('serviceComponentaPcCategorie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceComponentaPcCategorie  $serviceComponentaPcCategorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceComponentaPcCategorie $serviceComponentaPcCategorie)
    {
        $serviceComponentaPcCategorie->update($this->validateRequest());

        return redirect('/service/componente-pc/categorii')->with('status',
            'Categoria "' . $serviceComponentaPcCategorie->nume . '" a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceComponentaPcCategorie  $serviceComponentaPcCategorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceComponentaPcCategorie $serviceComponentaPcCategorie)
    {
        $serviceComponentaPcCategorie->delete();

        return redirect('/service/componente-pc/categorii')->with('status',
            'Categoria "' . $serviceComponentaPcCategorie->nume . '" a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request = null)
    {
        return request()->validate([
            'nume' => ['required', 'max:250']
        ]);
    }
}
