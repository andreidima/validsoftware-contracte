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
        $search_stare = \Request::get('search_stare');
        $search_tipFormulare = \Request::get('search_tipFormulare');
        $search_categorie = \Request::get('search_categorie');
        $search_clasa = \Request::get('search_clasa');
        $search_grupaDeToxicitate = \Request::get('search_grupaDeToxicitate');
        $search_producator = \Request::get('search_producator');
        $search_substanteActive_nume = \Request::get('search_substanteActive_nume');  
        $search_utilizari_cultura = \Request::get('search_utilizari_cultura');
        $search_utilizari_agent = \Request::get('search_utilizari_agent');
        $search_utilizari_nume = \Request::get('search_utilizari_nume');  
        // dd($search_stare);
        $produse = Produs::
                when($search_nume, function ($query, $search_nume) {
                    return $query->where('nume', 'like', '%' . $search_nume . '%');
                })
            ->when($search_stare, function ($query, $search_stare) {
                    return $query->where('stare', 'like', '%' . $search_stare . '%');
                })
            ->when($search_tipFormulare, function ($query, $search_tipFormulare) {
                return $query->where('tipFormulare', 'like', '%' . $search_tipFormulare . '%');
            })
            ->when($search_categorie, function ($query, $search_categorie) {
                return $query->where('categorie', 'like', '%' . $search_categorie . '%');
            })
            ->when($search_clasa, function ($query, $search_clasa) {
                return $query->where('clasa', 'like', '%' . $search_clasa . '%');
            })
            ->when($search_grupaDeToxicitate, function ($query, $search_grupaDeToxicitate) {
                return $query->where('grupaDeToxicitate', 'like', '%' . $search_grupaDeToxicitate . '%');
            })
            ->when($search_producator, function ($query, $search_producator) {
                return $query->where('producator', 'like', '%' . $search_producator . '%');
            })
            ->when($search_substanteActive_nume, function ($query, $search_substanteActive_nume) {
                return $query->where('substanteActive_nume', 'like', '%' . $search_substanteActive_nume . '%');
            })
            ->when($search_utilizari_cultura, function ($query, $search_utilizari_cultura) {
                return $query->where('utilizari_cultura', 'like', '%' . $search_utilizari_cultura . '%');
            })
            ->when($search_utilizari_agent, function ($query, $search_utilizari_agent) {
                return $query->where('utilizari_agent', 'like', '%' . $search_utilizari_agent . '%');
            })
            ->when($search_utilizari_nume, function ($query, $search_utilizari_nume) {
                return $query->where('utilizari_nume', 'like', '%' . $search_utilizari_nume . '%');
            })
            ->groupBy('nume')
            ->Paginate(25);

        $lista_stari = Produs::select('stare')->groupBy('stare')->get();
        $tipuri_formulare = Produs::select('tipFormulare')->groupBy('tipFormulare')->get();
        $categorii = Produs::select('categorie')->groupBy('categorie')->get();
        $clase = Produs::select('clasa')->groupBy('clasa')->get();
        $grupe_toxicitate = Produs::select('grupaDeToxicitate')->groupBy('grupaDeToxicitate')->get();
        $utilizari_agenti = Produs::select('utilizari_agent')->groupBy('utilizari_agent')->get();
        // dd($lista_stari);
                
        return view('produse.index', compact('produse', 
            'lista_stari', 'tipuri_formulare', 'categorii', 'clase', 'grupe_toxicitate', 'utilizari_agenti',
            'search_nume', 'search_stare', 'search_tipFormulare', 'search_categorie', 'search_clasa',
            'search_grupaDeToxicitate', 'search_producator', 'search_substanteActive_nume', 
            'search_utilizari_cultura', 'search_utilizari_agent', 'search_utilizari_nume'  
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produse.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produse = Produs::make($this->validateRequest());
        // $this->authorize('update', $proiecte);
        $produse->save();

        return redirect('/produse')->with('status', 'Produsul "'.$produse->nume.'" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function show(Produs $produse)
    {
        $tratamente_tinta = Produs::select('nume', 'utilizari_cultura', 'utilizari_agent', 'utilizari_nume', 'utilizari_doza', 'utilizari_pauza', 'utilizari_nrTrat')
            // ->groupBy('nume')
            ->having('nume', $produse->nume)
            ->get();

        return view('produse.show', compact('produse', 'tratamente_tinta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function edit(Produs $produse)
    {
        return view('produse.edit', compact('produse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produs $produse)
    {
        // $this->authorize('update', $proiecte);

        $produse->update($this->validateRequest());

        return redirect('/produse')->with('status', 'Produsul "'.$produse->nume.'" a fost modificat cu succes!');

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
        return redirect('/produse')->with('status', 'Produsul "' . $produse->nume . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        // dd ($request->_method);
        return request()->validate([
            'nume' =>['nullable', 'max:250'],
            'pret' => [ 'nullable', 'regex:/^(\d+(.\d{1,2})?)?$/', 'max:9999999'],
            'cantitate' => [ 'nullable', 'numeric', 'max:9999999999'],
            'cod_de_bare' => ['nullable', 'max:999999999999'],
            'descriere' => ['nullable', 'max:250'],
        ],
        [            
            'pret.regex' => 'Câmpul Preț nu este completat corect.',
        ]
        );
    }

    /**
     * Vanzare de produse. Scaderea cantitatii produsului
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function vanzari(Request $request)
    {         
        return view ('produse/vanzari');
    }

    public function vanzariDescarcaProdus(Request $request)
    { 
        if (isset($request->cod_de_bare)){
            $produs = Produs::where('cod_de_bare', $request->cod_de_bare)->first();

            if (isset($produs->id)){
                if (!is_numeric($request->nr_de_bucati) || $request->nr_de_bucati < 1 || $request->nr_de_bucati != round($request->nr_de_bucati)) {
                    return redirect ('produse/vanzari')->with('error', 'Numărul de bucăți nu este o valoare întreagă pozitivă: "' . $request->nr_de_bucati . '"!');
                }
                if (($produs->cantitate - $request->nr_de_bucati) < 0){
                    return redirect ('produse/vanzari')->with('error', 'Sunt mai puțin de "' . $request->nr_de_bucati . '" produse pe stoc!');
                }
                $produs->cantitate = $produs->cantitate - $request->nr_de_bucati;
                $produs->update();

                if ($request->session()->has('produse_vandute')) { 
                    $request->session()->push('produse_vandute', '' . $request->nr_de_bucati . ' buc. ' . $produs->nume); 

                } else {
                    $request->session()->put('produse_vandute', []);
                    $request->session()->push('produse_vandute', '' . $request->nr_de_bucati . ' buc. ' . $produs->nume);
                }                

                return redirect ('produse/vanzari')->with('success', 'A fost vândut ' . $request->nr_de_bucati . ' buc. "' . $produs->nume . '"!');
            } else{
                return redirect ('produse/vanzari')->with('error', 'Nu se află nici un produs in baza de date, care să aibă codul: "' . $request->cod_de_bare . '"!');
            }
        } else {
            return redirect ('produse/vanzari')->with('warning', 'Introdu un cod de bare!');
        } 
        
        return view ('produse/vanzari');
    }

    public function vanzariGolesteCos(Request $request)
    {         
        $request->session()->forget('produse_vandute');
        return view ('produse/vanzari');
    }

    /**
     * Adaugare produs in sesiune pentru comparatie
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function comparatieAdaugaProdus(Request $request)
    {
        if ($request->session()->has('produse_vandute')) {
            $request->session()->push('produse_pentru_comparatie', '' . $request->nr_de_bucati . ' buc. ' . $produs->nume); 
        } else {
                    $request->session()->put('produse_vandute', []);
                    $request->session()->push('produse_vandute', '' . $request->nr_de_bucati . ' buc. ' . $produs->nume);
                }  

        return view('produse/vanzari');
    }
}
