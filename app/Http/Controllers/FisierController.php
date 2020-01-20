<?php

namespace App\Http\Controllers;

use App\Fisier;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class FisierController extends Controller
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
     * @param  \App\Fisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function show(Fisier $fisier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function edit(Fisier $fisier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fisier $fisier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fisier $fisiere)
    {
        // dd($fisiere);
        $fisiere->delete();

        $cale_si_fisier = $fisiere->path . $fisiere->nume;
        Storage::delete($cale_si_fisier);

        // return redirect('/contracte')->with('status', 'Fișierul "' . $fisiere->nume . '" a fost șters cu succes!');
        return back()->with('status', 'Fișierul "' . $fisiere->nume . '" a fost șters cu succes!');
    }
}
