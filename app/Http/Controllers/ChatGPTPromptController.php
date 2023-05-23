<?php

namespace App\Http\Controllers;

use App\ChatGPTPrompt;
use Illuminate\Http\Request;

use Carbon\Carbon;

class ChatGPTPromptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('chatGPTPromptReturnUrl');

        $search_nume = \Request::get('search_nume');

        $prompturi = ChatGPTPrompt::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->simplePaginate(25);

        return view('chatGPT.prompturi.index', compact('prompturi', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('chatGPTPromptReturnUrl') ?? $request->session()->put('chatGPTPromptReturnUrl', url()->previous());

        return view('chatGPT.prompturi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prompt = ChatGPTPrompt::create($this->validateRequest($request));

        return redirect($request->session()->get('chatGPTPromptReturnUrl') ?? ('/chat-gpt/prompturi'))->with('status', 'Promptul "' . $prompt->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChatGPTPrompt  $prompt
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ChatGPTPrompt $prompt)
    {
        $request->session()->get('chatGPTPromptReturnUrl') ?? $request->session()->put('chatGPTPromptReturnUrl', url()->previous());

        return view('chatGPT.prompturi.show', compact('prompt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChatGPTPrompt  $prompt
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ChatGPTPrompt $prompt)
    {
        $request->session()->get('chatGPTPromptReturnUrl') ?? $request->session()->put('chatGPTPromptReturnUrl', url()->previous());

        return view('chatGPT.prompturi.edit', compact('prompt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChatGPTPrompt  $prompt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatGPTPrompt $prompt)
    {
        $prompt->update($this->validateRequest($request, $prompt));

        return redirect($request->session()->get('chatGPTPromptReturnUrl') ?? ('/chat-gpt/prompturi'))->with('status', 'Promptul „' . ($prompt->nume ?? '') . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChatGPTPrompt  $prompt
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatGPTPrompt $prompt)
    {
        $prompt->delete();

        return back()->with('status', 'Promptul „' . ($prompt->nume ?? '') . '” a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'nume' => 'max:500',
            'categorie' => 'max:500',
            'text' => '',
        ]);
    }
}
