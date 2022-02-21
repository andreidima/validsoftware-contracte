<?php

namespace App\Http\Controllers;

use App\ServiceLicenta;
use Illuminate\Http\Request;

class ServiceLicentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_observatii = \Request::get('search_observatii');

        $licente = ServiceLicenta::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_observatii, function ($query, $search_observatii) {
                return $query->where('observatii', 'like', '%' . $search_observatii . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('service.licente.index', compact('licente', 'search_nume', 'search_observatii'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service.licente.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $licenta = ServiceLicenta::create($this->validateRequest());

        return redirect('/service/licente')->with('status',
            'Licența "' . $licenta->nume . '" a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceLicenta  $licenta
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceLicenta $licenta)
    {
        return view('service.licente.show', compact('licenta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceLicenta  $licenta
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ServiceLicenta $licenta)
    {
        return view('service.licente.edit', compact('licenta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceLicenta  $licenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceLicenta $licenta)
    {
        $licenta->update($this->validateRequest());

        return redirect('/service/licente')->with('status',
            'Licența "' . $licenta->nume . '" a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceLicenta  $licenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceLicenta $licenta)
    {
        $licenta->delete();

        return redirect('/service/licente')->with('status',
            'Licența "' . $licenta->nume . '" a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request = null)
    {
        return request()->validate([
            'nume' => 'required|max:500',
            'link' => 'nullable|max:500',
            'cantitate' => 'nullable|numeric|min:0|max:500',
            'observatii' => 'nullable|max:1000',
        ]);
    }

    public function schimbaCantitatea(Request $request, ServiceLicenta $licenta)
    {
        switch ($request->input('action')) {
            case 'minus':
                $licenta->cantitate--;
                $licenta->update();
                return back()->with('status', 'Cantitatea licenței „' . $licenta->nume . '” a fost scazută cu 1 bucată');
                break;
            case 'plus':
                $licenta->cantitate++;
                $licenta->update();
                return back()->with('status', 'Cantitatea licenței „' . $licenta->nume . '” a fost crescută cu 1 bucată');
                break;
            }
        return back();
    }
}
