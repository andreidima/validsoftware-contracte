<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ChatGPTSite;
use App\ChatGPTProdus;
use App\ChatGPTPrompt;
use App\ChatGPTRaspunsOAI;

class ChatGPTInterogareOAIController extends Controller
{
    public function interogareOAI(Request $request)
    {
        $siteuri = ChatGPTSite::select('id', 'nume')->where('tip', 2)->orderBy('nume')->get();
        $produse = ChatGPTProdus::select('id' , 'site_id', 'nume', 'categorie')->orderBy('nume')->get();
        $prompturiCategorii = ChatGPTPrompt::select('categorie')->distinct()->orderBy('categorie')->get();
        $prompturi = ChatGPTPrompt::get();

        return view('chatGPT.interogariOAI.interogareOAI', compact('siteuri', 'produse', 'prompturiCategorii', 'prompturi'));
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

        $produs = ChatGPTProdus::with('site')->where('id', $request->produseAdaugateInContext[0])->first();
        $messages[] = [
            'role' => "user",
            'content' => strip_tags($produs->site->descriere ?? '')
        ];

        foreach ($request->produseAdaugateInContext as $produs_id) {
            $produs = ChatGPTProdus::with('site')->where('id', $request->produs_id)->first();

            $messages[] = [
                'role' => "user",
                'content' => "Nume produs: " . strip_tags($produs->nume)
            ];

            $messages[] = [
                'role' => "user",
                'content' => "Categorie produs: " . strip_tags($produs->categorie)
            ];

            $messages[] = [
                'role' => "user",
                'content' => "Link Produs: " . strip_tags($produs->url)
            ];

            $messages[] = [
                'role' => "user",
                'content' => "Descriere produs: " . strip_tags($produs->descriere)
            ];
        }
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
        echo '<h3>Prompt:</h3>';
        echo '<pre>'; print_r($messages); echo '</pre>';
        echo '<br><br><br><br>';

        // echo '<h3>Prompt content:</h3>';
        // foreach ($messages as $mesaj) {
        //     echo $mesaj['content'] . '<br><br>';
        // }
        // echo '<br><br><br><br>';

        echo '<h3>Răspuns:</h3>';
        $response->choices[0]->message->content = str_replace("\n", "<br />", $response->choices[0]->message->content);
        echo $response->choices[0]->message->content;


        $raspunsOAI = new ChatGPTRaspunsOAI;
        $raspunsOAI->prompt_id = $request->prompt_id;
        $raspunsOAI->prompt_trimis = $request->promptText;
        $raspunsOAI->raspuns_primit = $response->choices[0]->message->content ?? '';
        $raspunsOAI->save();

        // $raspunsOAI->produse()->attach($request->produs_id);
        $raspunsOAI->produse()->attach($request->produseAdaugateInContext);

        echo "
            <br>
            <div style='text-align:center; padding: 20px'>
                <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-right:20px;' href='/chat-gpt/produse'>Produse</a>
                <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;' href='/chat-gpt/raspunsuri-oai'>Răspunsuri</a>
            </div>
        ";
    }
}
