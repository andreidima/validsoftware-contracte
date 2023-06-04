<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ChatGPTSite;
use App\ChatGPTProdus;

class ChatGPTInterogareOAIController extends Controller
{
    public function interogareOAI(Request $request)
    {
        $siteuri = ChatGPTSite::orderBy('nume')->get();

        $produse = ChatGPTProdus::select('id' , 'site_id', 'nume', 'categorie')->orderBy('nume')->get();

        return view('chatGPT.interogariOAI.interogareOAI', compact('siteuri', 'produse'));
    }

    public function postInterogareOAI(Request $request)
    {
        dd($request);
    }
}
