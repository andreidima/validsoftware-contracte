<?php

namespace App\Http\Controllers;

use App\Variabila;
use Illuminate\Http\Request;

class VariabilaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $variabile = Variabila::
            // select()
            simplePaginate(25);

        return view('variabile.index', compact('variabile'));
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
     * @param  \App\Variabila  $variabila
     * @return \Illuminate\Http\Response
     */
    public function show(Variabila $variabila)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Variabila  $variabila
     * @return \Illuminate\Http\Response
     */
    public function edit(Variabila $variabile)
    {
        return view('variabile.edit', compact('variabile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Variabila  $variabila
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variabila $variabile)
    {
        $variabile->update($request->all());

        return redirect('/variabile')->with(
            'status',
            'Variabila "' . $variabile->nume . '" a fost modificată cu succes!'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Variabila  $variabila
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variabila $variabila)
    {
        //
    }
}
