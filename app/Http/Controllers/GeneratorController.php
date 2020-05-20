<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;

class GeneratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $clienti = Client::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->latest()
            ->Paginate(25);
            
        return view('generator.index', compact('clienti', 'search_nume'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function genereaza(Client $client = null, $director = null, $fisier = null)
    {
        // dd($fisier);
        return view('generator.fisiere.' . $director . '/' . $fisier , compact('client'));
        // switch ($tip_fisier) {
        //     case 'magazin-online/protectia-datelor-cu-caracter-personal':
        //         return view('generator.fisiere.magazin-online/protectia-datelor-cu-caracter-personal', compact('client'));
        //         break;
        //     case 'termeni-si-conditii':
        //         return view('generator.fisiere.termeni-si-conditii', compact('client'));
        //         break;
        //     case 'politica-de-confidentialitate':
        //         return view('generator.fisiere.politica-de-confidentialitate', compact('client'));
        //         break;
        //     case 'politica-cookies':
        //         return view('generator.fisiere.politica-cookies', compact('client'));
        //         break;
        //     default:
        //         return redirect('generator');
        // }
        
    }
}
