<?php

namespace App\Http\Controllers;

use App\MesajTrimis;

use Illuminate\Http\Request;

class MesajTrimisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');

        $ofertari = Ofertare::
            leftJoin('clienti', 'ofertari.client_id', '=', 'clienti.id')
            ->select('ofertari.*', 'clienti.nume')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('clienti.nume', 'like', '%' . $search_nume . '%');
            })
            ->latest('ofertari.created_at')
            ->simplePaginate(25);


        // $ofertari = Ofertare::first();
        // $html = '';
        // foreach ($ofertari as $ofertare){
        //     foreach ($ofertare->servicii as $serviciu) {
        //         $html .= $serviciu->nume;
        //     } 
        // }
        // dd($html);

        return view('ofertari.index', compact('ofertari', 'search_nume'));
    }
}
