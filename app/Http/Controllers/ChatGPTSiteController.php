<?php

namespace App\Http\Controllers;

use App\ChatGPTSite;
use Illuminate\Http\Request;

use Carbon\Carbon;

class ChatGPTSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('chatGPTSiteReturnUrl');

        $search_nume = \Request::get('search_nume');

        $siteuri = ChatGPTSite::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->simplePaginate(25);

        return view('chatGPT.siteuri.index', compact('siteuri', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('chatGPTSiteReturnUrl') ?? $request->session()->put('chatGPTSiteReturnUrl', url()->previous());

        return view('chatGPT.siteuri.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $site = ChatGPTSite::create($this->validateRequest($request));

        return redirect($request->session()->get('chatGPTSiteReturnUrl') ?? ('/chat-gpt/siteuri'))->with('status', 'Siteul "' . $site->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChatGPTSite  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ChatGPTSite $site)
    {
        $request->session()->get('chatGPTSiteReturnUrl') ?? $request->session()->put('chatGPTSiteReturnUrl', url()->previous());

        return view('chatGPT.siteuri.show', compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChatGPTSite  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ChatGPTSite $site)
    {
        $request->session()->get('chatGPTSiteReturnUrl') ?? $request->session()->put('chatGPTSiteReturnUrl', url()->previous());

        return view('chatGPT.siteuri.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChatGPTSite  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatGPTSite $site)
    {
        $site->update($this->validateRequest($request, $site));

        return redirect($request->session()->get('chatGPTSiteReturnUrl') ?? ('/chat-gpt/siteuri'))->with('status', 'Siteul „' . ($site->nume ?? '') . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChatGPTSite  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatGPTSite $site)
    {
        $site->delete();

        return back()->with('status', 'Siteul „' . ($site->nume ?? '') . '” a fost șters cu succes!');
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
            'url' => 'max:500',
            'descriere' => '',
        ]);
    }
}
