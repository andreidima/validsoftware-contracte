<?php

namespace App\Http\Controllers;

use App\ChatGPTPrompt;
use App\ChatGPTRaspunsOAI;
use Illuminate\Http\Request;

use Carbon\Carbon;

class ChatGPTRaspunsOAIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('chatGPTRaspunsOAIReturnUrl');

        // $search_nume = \Request::get('search_nume');

        $raspunsuri = ChatGPTRaspunsOAI::
            // when($search_nume, function ($query, $search_nume) {
            //     return $query->where('nume', 'like', '%' . $search_nume . '%');
            // })
            simplePaginate(25);

        return view('chatGPT.raspunsuriOAI.index', compact('raspunsuri'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $siteuri = ChatGPTSite::select('id', 'nume')->orderBy('nume')->get();

        $request->session()->get('chatGPTRaspunsOAIReturnUrl') ?? $request->session()->put('chatGPTRaspunsOAIReturnUrl', url()->previous());

        return view('chatGPT.produse.create', compact('siteuri'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produs = ChatGPTRaspunsOAI::create($this->validateRequest($request));

        return redirect($request->session()->get('chatGPTRaspunsOAIReturnUrl') ?? ('/chat-gpt/produse'))->with('status', 'RaspunsOAIul "' . $produs->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChatGPTRaspunsOAI  $produs
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ChatGPTRaspunsOAI $produs)
    {
        $request->session()->get('chatGPTRaspunsOAIReturnUrl') ?? $request->session()->put('chatGPTRaspunsOAIReturnUrl', url()->previous());

        return view('chatGPT.produse.show', compact('produs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChatGPTRaspunsOAI  $produs
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ChatGPTRaspunsOAI $produs)
    {
        $siteuri = ChatGPTSite::select('id', 'nume')->orderBy('nume')->get();

        $request->session()->get('chatGPTRaspunsOAIReturnUrl') ?? $request->session()->put('chatGPTRaspunsOAIReturnUrl', url()->previous());

        return view('chatGPT.produse.edit', compact('produs', 'siteuri'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChatGPTRaspunsOAI  $produs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatGPTRaspunsOAI $produs)
    {
        $produs->update($this->validateRequest($request, $produs));

        return redirect($request->session()->get('chatGPTRaspunsOAIReturnUrl') ?? ('/chat-gpt/produse'))->with('status', 'RaspunsOAIul „' . ($produs->nume ?? '') . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChatGPTRaspunsOAI  $produs
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatGPTRaspunsOAI $produs)
    {
        $produs->delete();

        return back()->with('status', 'RaspunsOAIul „' . ($produs->nume ?? '') . '” a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'site_id' => 'required',
            'nume' => '',
            'url' => '',
            'descriere' => '',
        ]);
    }
}
