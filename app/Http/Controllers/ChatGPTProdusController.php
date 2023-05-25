<?php

namespace App\Http\Controllers;

use App\ChatGPTSite;
use App\ChatGPTProdus;
use App\ChatGPTPrompt;
use Illuminate\Http\Request;

use Carbon\Carbon;

class ChatGPTProdusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('chatGPTProdusReturnUrl');

        $search_nume = \Request::get('search_nume');

        $produse = ChatGPTProdus::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->simplePaginate(25);

        return view('chatGPT.produse.index', compact('produse', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $siteuri = ChatGPTSite::select('id', 'nume')->orderBy('nume')->get();

        $request->session()->get('chatGPTProdusReturnUrl') ?? $request->session()->put('chatGPTProdusReturnUrl', url()->previous());

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
        $produs = ChatGPTProdus::create($this->validateRequest($request));

        return redirect($request->session()->get('chatGPTProdusReturnUrl') ?? ('/chat-gpt/produse'))->with('status', 'Produsul "' . $produs->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChatGPTProdus  $produs
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ChatGPTProdus $produs)
    {
        $request->session()->get('chatGPTProdusReturnUrl') ?? $request->session()->put('chatGPTProdusReturnUrl', url()->previous());

        return view('chatGPT.produse.show', compact('produs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChatGPTProdus  $produs
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ChatGPTProdus $produs)
    {
        $siteuri = ChatGPTSite::select('id', 'nume')->orderBy('nume')->get();

        $request->session()->get('chatGPTProdusReturnUrl') ?? $request->session()->put('chatGPTProdusReturnUrl', url()->previous());

        return view('chatGPT.produse.edit', compact('produs', 'siteuri'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChatGPTProdus  $produs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatGPTProdus $produs)
    {
        $produs->update($this->validateRequest($request, $produs));

        return redirect($request->session()->get('chatGPTProdusReturnUrl') ?? ('/chat-gpt/produse'))->with('status', 'Produsul „' . ($produs->nume ?? '') . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChatGPTProdus  $produs
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatGPTProdus $produs)
    {
        $produs->delete();

        return back()->with('status', 'Produsul „' . ($produs->nume ?? '') . '” a fost șters cu succes!');
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

    protected function interogareOAI(Request $request, ChatGPTProdus $produs)
    {
        $prompturiCategorii = ChatGPTPrompt::select('categorie')->distinct()->orderBy('categorie')->get();
        $prompturi = ChatGPTPrompt::get();

        return view('chatGPT.produse.diverse.interogareOAI', compact('produs', 'prompturiCategorii', 'prompturi'));
    }

    function callOpenAI($prompt) {
        $url = "https://api.openai.com/v1/chat/completions";
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer " . \Config::get('variabile.chat_gpt_oai_key')
        ];
        $data = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role" => "user",
                    "content" => $prompt
                ]
            ]
        ];

        $options = [
            "http" => [
                "method" => "POST",
                "header" => $headers,
                "content" => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return json_decode($result);
    }

    protected function postInterogareOAI(Request $request)
    {
        // dd($request);
        // dd(\Config::get('variabile.cron_job_key'));
        // dd(\Config::get('variabile.chat_gpt_oai_key'));
        // Build prompt with product data
        $fullPrompt = $request->promptText;
        $fullPrompt .= "\nNume produs: " . $request->produs_nume;
        $fullPrompt .= "\nLink Produs: " . $request->produs_url;
        $fullPrompt .= "\nDescriere produs: " . $request->produs_descriere;

        $produs = ChatGPTProdus::with('site')->where('id', $request->produs_id)->first();

        $fullPrompt .= "\n" . $produs->site->descriere ?? '';
// dd($request->promptText, $fullPrompt);
        // Call OpenAI API
        $response = $this->callOpenAI($fullPrompt);

        // Print response
        // dd($response);
        echo 'Prompt:<br>';
        echo $fullPrompt;
        echo '<br><br><br><br><br><br>';
        echo 'Rășpuns:<br>';
        echo $response->choices[0]->message->content;
    }
}
