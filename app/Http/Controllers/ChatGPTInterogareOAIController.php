<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ChatGPTSite;

class ChatGPTInterogareOAIController extends Controller
{
    public function interogareOAI(Request $request)
    {
        $siteuri = ChatGPTSite::orderBy('nume')->get();

        return view('chatGPT.interogariOAI.interogareOAI', compact('siteuri'));
    }
}
