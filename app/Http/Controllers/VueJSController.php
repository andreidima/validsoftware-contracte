<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceClient;

class VueJSController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete()
    {
        return view('vuejsAutocomplete');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocompleteSearch(Request $request)
    {
        $client_nume = $request->client_nume;
        $data = ServiceClient::where('nume','like','%'.$client_nume.'%')
            ->orderBy('nume')
            ->get();

        return response()->json($data);
    }
}
