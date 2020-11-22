<?php

namespace App\Http\Controllers;

use App\ServiceAnydesk;
use App\ServiceClient;
use Illuminate\Http\Request;

class ServiceAnydeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');

        $anydeskuri = ServiceAnydesk::with('client')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            // ->whereHas('client', function ($query) use ($search_nume) {
            //     $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
            // })
            ->latest()
            ->simplePaginate(25);

        return view('service.anydeskuri.index', compact('anydeskuri', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clienti = ServiceClient::all();
        $clienti = $clienti->sortBy('nume')->values();

        return view('service.anydeskuri.create', compact('clienti'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('here');
        $anydesk = ServiceAnydesk::make($this->validateRequest($request));
        // $service_fisa->client_id = $client->id;
        $anydesk->save();

        return redirect('/service/anydeskuri')->with('status', 'AnyDeskul pentru "' . $anydesk->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceAnydesk  $anydesk
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceAnydesk $anydesk)
    {
        $clienti = ServiceClient::all();
        $clienti = $clienti->sortBy('nume')->values();

        return view('service.anydeskuri.edit', compact('anydesk', 'clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceAnydesk  $anydesk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceAnydesk $anydesk)
    {
        $anydesk->update($this->validateRequest());

        return redirect('service/anydeskuri')->with('status', 'AnyDeskul pentru "' . $anydesk->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceAnydesk  $anydesk
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceAnydesk $anydesk)
    {
        $anydesk->delete();

        return redirect('/service/anydeskuri')->with('status', 'AnyDeskul pentru "' . $anydesk->nume . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request = null)
    {
        return request()->validate([
            'client_id' => [''],
            'nume' => ['max:90'],
            'telefon' => ['max:90'],
            'email' => ['max:90'],
            'cod_anydesk' => ['max:90'],
            'observatii' => ['max:2000'],
        ]);
    }
}
