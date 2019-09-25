<?php

namespace App\Http\Controllers;

use App\Produs;
use Illuminate\Http\Request;

class ProdusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume'); //<-- we use global request to get the param of URI        
        $produse = Produs::
                when($search_nume, function ($query, $search_nume) {
                    return $query->where('nume', 'like', '%' . $search_nume . '%');
                })
            ->Paginate(25);
                
        return view('produse.index', compact('produse'));
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
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function show(Produs $produs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function edit(Produs $produs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produs $produs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produs $produse)
    {
        // $this->authorize('delete', $produse);
        // dd($produse);
        $produse->delete();
        return redirect('/produse')->with('status', 'Produsul "' . $produse->nume . '" a fost șters cu succes!');;
    }
}
