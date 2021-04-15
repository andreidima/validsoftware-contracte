<?php

namespace App\Http\Controllers;

use App\ServiceServiciuCategorie;

use Illuminate\Http\Request;

class ServiceServiciuCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');

        $categorii = ServiceServiciuCategorie::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            // ->orderBy('nume')
            ->latest()
            ->simplePaginate(25);

        return view('service.servicii.categorii.index', compact('categorii', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service.servicii.categorii.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categorie = ServiceServiciuCategorie::create($this->validateRequest($request));

        return redirect('/service/servicii/categorii')->with('status',
            'Categoria "' . $categorie->nume . '", a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceServiciuCategorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceServiciuCategorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceServiciuCategorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceServiciuCategorie $categorie)
    {
        return view('service.servicii.categorii.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceServiciuCategorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceServiciuCategorie  $categorie)
    {
        $categorie->update($this->validateRequest());

        return redirect('service/servicii/categorii')->with('status',
            'Categoria "' . $categorie->nume . '" a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceServiciuCategorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceServiciuCategorie  $categorie)
    {
        $categorie->delete();

        return redirect('/service/servicii/categorii')->with('status',
            'Categoria "' . $categorie->nume . '" a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request = null)
    {
        return request()->validate([
            'nume' => ['required', 'max:100']
        ]);
    }
}
