<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailuriClientiController extends Controller
{
    public function index()
    {
        $clienti = \App\Client::select('email')->distinct()->get();

        $serviceClienti = \App\ServiceClient::select('email')->distinct()->get();

        return view('utile.emailuriClienti', compact('clienti', 'serviceClienti'));
    }
}
