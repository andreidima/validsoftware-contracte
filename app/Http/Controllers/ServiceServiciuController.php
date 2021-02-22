<?php

namespace App\Http\Controllers;

use App\ServiceServiciu;
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
            ->orderBy('nume')
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
        return view('service.servicii.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        return view('service.servicii.edit', compact('servicii'));
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
            'link_review_site' => ['required', 'max:250']
        ]);
    }
}
