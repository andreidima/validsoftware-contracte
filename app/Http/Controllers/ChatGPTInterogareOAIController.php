<?php

namespace App\Http\Controllers;

use App\ChatGPTSite;
use App\ChatGPTProdus;
use App\ChatGPTPrompt;
use Illuminate\Http\Request;

use Carbon\Carbon;

class ChatGPTInterogareOAIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function interogare(Request $request)
    {
        $siteuri = ChatGPTSite::select('id', 'nume')->get();
        $produse = ChatGPTProdus::select('id', 'site_id', 'nume')->get();

        $prompturiCategorii = ChatGPTPrompt::select('categorie')->distinct()->get();
        $prompturi = ChatGPTPrompt::select('id', 'nume', 'categorie')->get();

        return view('chatGPT.interogariOAI.interogare', compact('siteuri', 'produse', 'prompturiCategorii', 'prompturi'));
    }
}
