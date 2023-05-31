<?php

namespace App\Http\Controllers;

use App\ChatGPTSite;
use App\ChatGPTProdus;
use App\ChatGPTPrompt;
use App\ChatGPTRaspunsOAI;
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
            'nume' => 'max:500',
            'categorie' => 'max:500',
            'url' => 'max:500',
            'descriere' => '',
        ]);
    }

    protected function interogareOAI(Request $request, ChatGPTProdus $produs)
    {
        $prompturiCategorii = ChatGPTPrompt::select('categorie')->distinct()->orderBy('categorie')->get();
        $prompturi = ChatGPTPrompt::get();

        return view('chatGPT.produse.diverse.interogareOAI', compact('produs', 'prompturiCategorii', 'prompturi'));
    }

    function callOpenAI($messages) {
        $url = "https://api.openai.com/v1/chat/completions";
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer " . \Config::get('variabile.chat_gpt_oai_key')
        ];
        $data = [
            "model" => "gpt-3.5-turbo",
            // "messages" => [
            //     [
            //         "role" => "user",
            //         "content" => $prompt
            //     ]
            // ]
            "messages" => $messages
        ];
// dd($messages, json_encode($data));
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
        $messages[] = [
            'role' => "system",
            'content' => strip_tags($request->promptText)
        ];

        $produs = ChatGPTProdus::with('site')->where('id', $request->produs_id)->first();
        $messages[] = [
            'role' => "user",
            'content' => strip_tags($produs->site->descriere ?? '')
        ];

        $messages[] = [
            'role' => "user",
            'content' => "Nume produs: " . strip_tags($request->produs_nume)
        ];

        $messages[] = [
            'role' => "user",
            'content' => "Link Produs: " . strip_tags($request->produs_url)
        ];

        $messages[] = [
            'role' => "user",
            'content' => "Descriere produs: " . strip_tags($request->descriere)
        ];

        // dd($request);
        // $raspunsOAI = new ChatGPTRaspunsOAI;
        // $raspunsOAI->prompt_id = $request->prompt_id;
        // $raspunsOAI->prompt_trimis = $request->promptText;
        // $raspunsOAI->prompt_id = $response->choices[0]->message->content;
        // $raspunsOAI->context = '';
        // dd($raspunsOAI);

        $response = $this->callOpenAI($messages);

        // Print response
        // dd($response);
        echo '<h3>Prompt:</h3><br>';
        echo '<pre>'; print_r($messages); echo '</pre>';
        echo '<br><br><br><br><br><br>';

        echo '<h3>Prompt content:</h3><br>';
        foreach ($messages as $mesaj) {
            echo $mesaj['content'] . '<br><br>';
        }
        echo '<br><br><br><br><br><br>';

        echo '<h3>Răspuns:</h3><br>';
        $response->choices[0]->message->content = str_replace("\n", "<br />", $response->choices[0]->message->content);
        echo $response->choices[0]->message->content;

        $raspunsOAI = new ChatGPTRaspunsOAI;
        // dd($response->choices[0]->message->content);


    }
}
