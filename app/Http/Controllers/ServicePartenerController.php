<?php

namespace App\Http\Controllers;

use App\ServicePartener;
use Illuminate\Http\Request;

class ServicePartenerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $parteneri = ServicePartener::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            // ->where('tip', 'service')
            ->latest()
            ->simplePaginate(25);
            
        return view('service.parteneri.index', compact('parteneri', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service.parteneri.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $client = ServicePartener::create(array_merge($this->validateRequest($request),['tip' => 'service']));
        $partener = ServicePartener::create($this->validateRequest($request));

        return redirect($partener->path())->with('status', 'Partenerul de Service "' . $partener->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServicePartener  $client
     * @return \Illuminate\Http\Response
     */
    public function show(ServicePartener $partener)
    {
        return view('service.parteneri.show', compact('partener'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServicePartener  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicePartener $partener)
    {
        return view('service.parteneri.edit', compact('partener'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServicePartener  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServicePartener $partener)
    {
        $this->validateRequest($request, $partener);
        $partener->update($request->all());

        return redirect($partener->path())->with('status', 'Partenerul de Service "' . $partener->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServicePartener  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicePartener $partener)
    {
        $partener->delete();
        return redirect('/service/parteneri')->with('status', 'Partenerul de Service "' . $partener->nume . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'nume' => ['required', 'max:100'],
            'cui' => ['nullable', 'max:50'],
            'adresa' => ['nullable', 'max:180'],
            'telefon' => ['nullable', 'numeric', 'digits:10'],
            'email' => ['nullable', 'max:180'],
            'google_maps_link' => ['nullable', 'max:200']
        ]);
    }
}
