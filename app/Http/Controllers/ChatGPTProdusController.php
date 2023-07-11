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

        $search_site = \Request::get('search_site');
        $search_nume = \Request::get('search_nume');
        $searchStocMinim = \Request::get('searchStocMinim');
        $searchStocMaxim = \Request::get('searchStocMaxim');
        $searchVanzariMinim = \Request::get('searchVanzariMinim');
        $searchVanzariMaxim = \Request::get('searchVanzariMaxim');
        $searchNrRaspunsuriOAI = \Request::get('searchNrRaspunsuriOAI');
        $campSortare = \Request::get('campSortare');;
        $ordineSortare = \Request::get('ordineSortare');;

        if(isset($_GET['butonSortare'])) {
            $arr = explode(".", $_GET['butonSortare'], 2);
            $campSortare = $arr[0];
            $ordineSortare = $arr[1];
        }
        if (!isset($campSortare)) {
            $campSortare = 'created_at';
            $ordineSortare = 'desc';
        }

        $siteuri = ChatGPTSite::select('id', 'nume')->where('tip', 2)->get();

        $query = ChatGPTProdus::with('site')
            ->when($search_site, function ($query, $search_site) {
                return $query->whereHas('site', function ($query) use ($search_site) {
                    return $query->where('id', $search_site);
                });
            })
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($searchStocMinim, function ($query, $searchStocMinim) {
                return $query->where('stoc', '>=', $searchStocMinim);
            })
            ->when($searchStocMaxim, function ($query, $searchStocMaxim) {
                return $query->where('stoc', '<=', $searchStocMaxim);
            })
            ->when($searchVanzariMinim, function ($query, $searchVanzariMinim) {
                return $query->where('quantity', '>=', $searchVanzariMinim);
            })
            ->when($searchVanzariMaxim, function ($query, $searchVanzariMaxim) {
                return $query->where('quantity', '<=', $searchVanzariMaxim);
            })
            ->withCount('raspunsuriOAI')
            ->when(!is_null($searchNrRaspunsuriOAI), function ($query, $searchNrRaspunsuriOAI) {
                return $query->having('raspunsuri_o_a_i_count', request('searchNrRaspunsuriOAI'));
            })
            ->orderBy($campSortare, $ordineSortare);

        // if (isset($_GET['butonSortareStoc'])) {
        //     ($sortareStoc === "crescator") ? ($sortareStoc = "descrescator") : $sortareStoc = "crescator";
        //     $query->when($sortareStoc === "crescator", function ($query){
        //         return $query->orderBy('stoc');
        //     }, function ($query){
        //         return $query->orderBy('stoc', 'desc');
        //     });
        // } else if (isset($_GET['butonSortareVanzari'])) {
        //     ($sortareVanzari === "crescator") ? ($sortareVanzari = "descrescator") : $sortareVanzari = "crescator";
        //     $query->when($sortareVanzari === "crescator", function ($query){
        //         return $query->orderBy('quantity');
        //     }, function ($query){
        //         return $query->orderBy('quantity', 'desc');
        //     });
        // } else {
        //     $query->latest();
        // }

        $produseNrTotal = $query->count();
        $produse = $query->simplePaginate(25);

        return view('chatGPT.produse.index', compact('siteuri', 'produse', 'produseNrTotal', 'search_site', 'search_nume', 'searchStocMinim', 'searchStocMaxim', 'searchVanzariMinim', 'searchVanzariMaxim', 'searchNrRaspunsuriOAI', 'campSortare', 'ordineSortare'));
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
            'link_imagine_fata' => 'max:500',
            'link_imagine_spate' => 'max:500',
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
            'content' => 'Nume produs: ' . '"' . strip_tags($request->produs_nume) . '"'
        ];

        $messages[] = [
            'role' => "user",
            'content' => 'Categorie produs: ' . '"' . strip_tags($request->produs_categorie) . '"'
        ];

        $messages[] = [
            'role' => "user",
            'content' => 'Link Produs: ' . '"' . strip_tags($request->produs_url) . '"'
        ];

        $messages[] = [
            'role' => "user",
            'content' => 'Descriere produs: ' . '"' . strip_tags($request->produs_descriere) . '"'
        ];

        $messages[] = [
            'role' => "user",
            'content' => strip_tags($produs->site->descriere ?? '')
        ];

        // dd($request);
        // $raspunsOAI = new ChatGPTRaspunsOAI;
        // $raspunsOAI->prompt_id = $request->prompt_id;
        // $raspunsOAI->prompt_trimis = $request->promptText;
        // $raspunsOAI->raspuns_primit = $response->choices[0]->message->content ?? '';
        // $raspunsOAI->save();

        // $raspunsOAI->produse()->attach($request->produs_id);
        // echo "
        //     <div style='text-align:center; padding: 20px'>
        //         <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-right:20px;' href='/chat-gpt/produse'>Produse</a>
        //         <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;' href='/chat-gpt/raspunsuri-oai'>Răspunsuri</a>
        //     </div>
        // ";
        // dd('stop');

        $response = $this->callOpenAI($messages);

        // Print response
        // dd($response);
        // echo '<h3>Prompt:</h3>';
        // echo '<pre>'; print_r($messages); echo '</pre>';
        // echo '<br><br><br><br>';

        // echo '<h3>Prompt content:</h3>';
        // foreach ($messages as $mesaj) {
        //     echo $mesaj['content'] . '<br><br>';
        // }
        // echo '<br><br><br><br>';

        // $promptContent = '';
        // foreach ($messages as $mesaj) {
        //     $promptContent .= $mesaj['content'];
        //     $promptContent .= '<br><br>';
        // }
        // echo '<h3>
        //         Prompt content:
        //         <div id="copyPaste">
        //             <a class="btn btn-sm p-0 border-0"
        //                 v-if="canCopy"
        //                 @click="copy(' . $promptContent . ')">
        //                 <small title="Copy to clipboard" id="appId" aria-describedby="">
        //                     Hihi <i class="far fa-clone"></i>
        //                 </small>
        //             </a>
        //         </div>
        //     </h3>';
        // echo $promptContent;
        // echo '<br><br><br><br>';

        // echo '<h3>Răspuns:</h3>';
        // $response->choices[0]->message->content = str_replace("\n", "<br />", $response->choices[0]->message->content);
        // echo $response->choices[0]->message->content;


        $raspunsOAI = new ChatGPTRaspunsOAI;
        $raspunsOAI->prompt_id = $request->prompt_id;
        $promptTrimis = '';
        foreach ($messages as $mesaj) {
            $promptTrimis .= $mesaj['content'] . '<br><br>';
        }
        $raspunsOAI->prompt_trimis = $promptTrimis;
        $raspunsOAI->raspuns_primit = $response->choices[0]->message->content ?? '';
        $raspunsOAI->save();

        $raspunsOAI->produse()->attach($request->produs_id);

        return view('chatGPT.produse.diverse.raspunsInterogareOAI', compact('messages', 'promptTrimis', 'response'));
        // $user->roles()->attach($roleId);
        // $raspunsOAI->context = '';
        // dd($raspunsOAI);
        echo "
            <br>
            <div style='text-align:center; padding: 20px'>
                <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-right:20px;' href='/chat-gpt/produse'>Produse</a>
                <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-right:20px;' href='/chat-gpt/raspunsuri-oai'>Răspunsuri</a>";
        if (isset($produs->site->link_chatgpt)){
            echo "
                <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-right:20px;'
                    href='" . ($produs->site->link_chatgpt ?? '') . "' target='_blank'>Chat GPT</a>";
        }
        if (isset($produs->link_imagine_fata)){
            echo "
                <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;'
                    href='" . ($produs->link_imagine_fata ?? '') . "' target='_blank'>Imagine față</a>";
        } else{
            echo "Fără imagine";
        }
        echo "</div>";
    }
}
