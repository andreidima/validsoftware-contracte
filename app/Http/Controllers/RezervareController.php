<?php

namespace App\Http\Controllers;

use App\Rezervare;
use App\Oras;
use App\Tarif;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RezervareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function show(Rezervare $rezervare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function edit(Rezervare $rezervare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rezervare $rezervare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rezervare $rezervare)
    {
        //
    }



    /**
     * Returnarea oraselor de sosire
     */
    public function orase_rezervari(Request $request)
    {
        $pret_adult = 0;
        $pret_copil = 0;
        $pret_animal_mic = 0;
        $pret_animal_mare = 0;
        $tur_retur = 0;
        $raspuns = '';
        switch ($_GET['request']) {
            case 'orase_plecare':
                $raspuns = Oras::select('id', 'nume', 'tara')
                    ->where('tara', $request->traseu)
                    ->orderBy('nume')
                    ->get();
                break;
            case 'orase_sosire':
                $raspuns = Oras::select('id', 'nume', 'tara')
                    ->where('tara', '<>', $request->traseu)
                    ->orderBy('nume')
                    ->get();
                break;
            case 'preturi':
                if (($request->oras) && ($request->tur_retur)) {
                    $traseu = Oras::select('id', 'nume', 'traseu')
                        ->where('id', $request->oras)
                        ->first();
                    if ($request->tur_retur == 'false'){
                        $tur_retur = 0;
                    } else{
                        $tur_retur = 1;
                    }
                    $raspuns = Tarif::all()
                        ->where('traseu_id', $traseu->traseu)
                        ->where('tur_retur', $tur_retur)
                        ->first();
                    $pret_adult = $raspuns->adult;
                    $pret_copil = $raspuns->copil;
                    $pret_animal_mic = $raspuns->animal_mic;
                    $pret_animal_mare = $raspuns->animal_mare;
                } else {
                    $raspuns = '';
                }

                break;
            default:
                break;
        }
        return response()->json([
            'raspuns' => $raspuns,
            'pret_adult' => $pret_adult,
            'pret_copil' => $pret_copil,
            'pret_animal_mic' => $pret_animal_mic,
            'pret_animal_mare' => $pret_animal_mare,
        ]);
    }

    public function testare_axios(Request $request)
    {
        $traseu = Oras::select('id', 'nume', 'traseu')
            ->where('id', 114)
            ->first();
        $raspuns = Tarif::all()
            ->where('traseu_id', $traseu->traseu)
            ->where('tur_retur', 1)
            ->first();
        // $pret_adult = $raspuns->adult;
        // $pret_copil = $raspuns->copil;
        // $pret_animal_mic = $raspuns->animal_mic;
        // $pret_animal_mare = $raspuns->animal_mare;
        dd($traseu, $raspuns);
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request, $rezervari = null)
    {
        // dd ($request->_method);
        return request()->validate([
            // 'cursa_id' =>['nullable', 'numeric', 'max:999'],
            'traseu' => ['required'],
            'oras_plecare' => [ 'required', 'integer', 'max:999'],
            'oras_sosire' => [ 'required', 'integer', 'max:999'],
            'tur_retur' => [''],
            // 'statie_id' => ['nullable', 'numeric', 'max:999'],
            // 'statie_imbarcare' => ['nullable'],
            'nr_adulti' => [ 'required', 'integer', 'between:1,100'],
            'nr_copii' => [ 'nullable', 'integer', 'between:0,100'],
            'nr_animale_mici' => [ 'nullable', 'integer', 'between:0,10'],
            'nr_animale_mari' => [ 'nullable', 'integer', 'between:0,10'],
            'data_plecare' => [ 'required', 'max:50'],
            // 'data_intoarcere' => [ 'required_if:tur_retur,true', 'max:50'],
            // 'ora_id' =>[ 'required', 'nullable', 'max:99'],
            'nume' => ($request->_method === "PATCH") ?
                ['required', 'max:200',
                    Rule::unique('rezervari')->ignore($rezervari->id)->where(function ($query) use($rezervari,$request) {
                        return $query->where('telefon', $request->telefon)
                                    ->where('data_cursa', $request->data_cursa);
                    }),        
                ]
                :
                ['required', 'max:200',
                    Rule::unique('rezervari')->where(function ($query) use($rezervari,$request) {
                        return $query->where('telefon', $request->telefon)
                                    ->where('data_plecare', $request->data_plecare);
                    }),        
                ],
            'telefon' => [ 'required', 'regex:/^[0-9 ]+$/', 'max: 100'],
            'email' => [ 'required', 'email', 'max:100'],
            // 'pret_total' => ['nullable', 'numeric', 'max:999999'],
            'adresa' => ['max:2000'],
            'observatii' => ['max:2000'],
            // 'comision_agentie' => [ 'nullable', 'numeric', 'max:999999'],
            // 'tip_plata_id' => [''],
            
            // 'retur_ora_id' =>[ 'required_if:retur,true', 'nullable', 'max:99'],
            // 'retur_data_cursa' => [ 'required_if:retur,true', 'max:50'],
            // 'retur_zbor_oras_decolare' => ['max:100'],
            // 'retur_zbor_ora_decolare' => ['max:100'],
            // 'retur_zbor_ora_aterizare' => ['max:100'],
            
            // 'plata_online' => [''],
            // 'adresa' => ['required_if:plata_online,true', 'nullable', 'max:99'],

            // 'order_id' => [''],
            // 'user_id' => [''],
            // 'status' => [''],
            // 'plata_cu_card' => [''],
            // 'acord_de_confidentialitate' => auth()->user() === null ? ['required'] : [''],
            // 'oferta' => [''],
        ],
        [
            // 'ora_id.required' => 'Câmpul Ora de plecare este obligatoriu.',
            'telefon.regex' => 'Câmpul Telefon poate conține doar cifre și spații.',
            'nume.unique' => 'Această Rezervare este deja înregistrată.',
            // 'adresa.required_if' => 'Câmpul Adresa este obligatoriu dacă este selectată plata cu card'
        ]
        );
    }

    public function pdfexport(Request $request, Rezervare $rezervari)
    {
        if ($request->view_type === 'rezervare-html') {
            return view('rezervari.export.rezervare-pdf', compact('rezervari'));
        } elseif ($request->view_type === 'rezervare-pdf') {
            $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervari'))
                ->setPaper('a4');
                    // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
                    return $pdf->download('Rezervare ' . $rezervari->nume . '.pdf');
        }
        // elseif($request->view_type === 'fisa-de-date-a-imobilului-pdf'){
        //     $pdf = PDF::loadView('registru.export.pdf-fisa-de-date-a-imobilului', ['registre' => $registre]) ->setPaper('a4');
        //     return $pdf->download($registru->id.'.pdf');
        // }
        // else{
        // } 
    }


    //
    // Functii pentru Multi Page Form pentru Clienti
    //
        /**
     * Show the step 1 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervarePasul1(Request $request)
    {
        return view('rezervari.guest-create/adauga-rezervare-pasul-1');
    }

    /**
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdaugaRezervarePasul1(Request $request)
    {       
        $request->session()->forget('rezervare');
        $rezervare = Rezervare::make($this->validateRequest($request));

        // calcularea pretului total
        $tarife = DB::table('tarife')
            ->where([
                ['traseu_id', $rezervare->traseu],
                ['tur_retur', ($rezervare->tur_retur=='true' ? 1 : 0)]
            ])
            ->first();
        $rezervare->pret_total = $tarife->adult * $rezervare->nr_adulti +
                                $tarife->copil * $rezervare->nr_copii +
                                $tarife->animal_mic * $rezervare->nr_animale_mici +
                                $tarife->animal_mare * $rezervare->nr_animale_mari;

        $request->session()->put('rezervare', $rezervare);
        // dd($rezervare, $tarife);
        return redirect('/adauga-rezervare-pasul-2');
    }

        /**
     * Show the step 2 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervarePasul2(Request $request)
    {
        $rezervare = $request->session()->get('rezervare');
        return view('rezervari.guest-create/adauga-rezervare-pasul-2',compact('rezervare', $rezervare));
    }

    /**
     * Post Request to store step2 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdaugaRezervarePasul2(Request $request)
    {       
        // if(empty($request->session()->get('rezervare'))){
        //     $rezervare = new Rezervare();
        //     $rezervare->fill($this->validateRequest());
        //     $request->session()->put('rezervare', $rezervare);
        // }else{
        //     $rezervare = $request->session()->get('rezervare');
        //     $rezervare->fill($this->validateRequest());
        //     $request->session()->put('rezervare', $rezervare);
        // }

        $rezervare = $request->session()->get('rezervare');
        $rezervare->created_at = \Carbon\Carbon::now();
        $rezervare->tip_plata_id = 1;


        // aflarea id-ului cursei in functie de orasele introduse
        $cursa = Cursa::select('id', 'pret_adult', 'pret_copil')
            ->where('id', $rezervare->cursa_id)
            ->first();

        // calcularea pretului total
        $rezervare->pret_total = $cursa->pret_adult * $rezervare->nr_adulti + $cursa->pret_copil * $rezervare->nr_copii;


        $rezervare_array = $rezervare->toArray();
        $plata_online = $rezervare_array['plata_online'];
        unset($rezervare_array['cursa'], $rezervare_array['statie'], $rezervare_array['ora'], $rezervare_array['tip_plata'], $rezervare_array['id'],
            $rezervare_array['plata_online'], $rezervare_array['adresa']);
            
        
        // Verificare rezervare duplicat
        $request_verificare_duplicate = new Request([
            'nume' => $request->session()->get('rezervare.nume'),
            'telefon' => $request->session()->get('rezervare.telefon'),
            'data_cursa' => $request->session()->get('rezervare.data_cursa'),
            'ora_id' => $request->session()->get('rezervare.ora_id')
        ]);

        $this->validate($request_verificare_duplicate, [
            'nume' => ['required', 'max:100', 'unique:rezervari,nume,NULL,id,telefon,' . $request_verificare_duplicate->telefon . ',data_cursa,' . $request_verificare_duplicate->data_cursa . ',ora_id,' . $request_verificare_duplicate->ora_id]
        ],
        [
            'nume.unique' => 'Această Rezervare este deja înregistrată.'
        ]);

        
        //Inserarea rezervarii in baza de date
        $id = DB::table('rezervari')->insertGetId($rezervare_array);
        
        // $id = $rezervari->save->insertGetId;
        
        $rezervare->id = $id;

        // $rezervare->data_cursa = \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervare->data_cursa)->format('d.m.Y');

        $request->session()->put('rezervare', $rezervare);

        // dd($plata_online);

        // if($rezervari->save()){
        //     dd(Response::json(array('success' => true, 'last_insert_id' => $rezervari->id), 200));
        // };
        // dd($request);
        // $rezervare = $request->session()->get('rezervare');
        // if (!empty($rezervare->data_cursa)){
        //     $rezervare->data_cursa = \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervare->data_cursa)->format('d.m.Y');
        // }
        // $request->session()->put('rezervare', $rezervare);
        // dd($request->session()->get('rezervare'));        

        // Trimitere email
        if (!empty($rezervare->email)) {
            \Mail::to($rezervare->email)->send(
                new BiletClient($rezervare)
            );
        }

        if ($plata_online == 1){
            return redirect('/trimitere-catre-plata');
        }else{
        return redirect('/adauga-rezervare-pasul-3');
        }
    }

        /**
     * Show the step 3 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervarePasul3(Request $request)
    {
        // if ((Auth::check()) && (Auth::user()->id == 355)) {
        //     dd($request->session()->get('rezervare'), $request->orderId);
        // }

        // if (Session::has('rezervare')) {
        //     $rezervare = $request->session()->get('rezervare');
        // }else {
        //     $payment = DB::table('payment_notifications')->where('order_id', $request->orderId)->first();
        //     $rezervare = DB::table('rezervari')->where('id', $payment->rezervare_id)->first();
        // }

        if ($request->has('orderId')) {
            $plata_online = \App\PlataOnline::where('order_id', $request->orderId)->latest()->first();
            $rezervare = \App\Rezervare::where('id', $plata_online->rezervare_id)->first();

            $request->session()->put('plata_online', $plata_online);
            $request->session()->forget('rezervare');
            $request->session()->put('rezervare_id', $rezervare->id);

            // dd($rezervare, $rezervare->ora->ora);

            return view('rezervari.guest-create/adauga-rezervare3', compact('rezervare', 'plata_online'));

        } else {
            $rezervare = $request->session()->get('rezervare');
            
            return view('rezervari.guest-create/adauga-rezervare3', compact('rezervare'));
        }

        // $request->session()->forget('rezervare');
        // $request->session()->flush();
        // dd (session()); 
    }

    public function pdfexportguest(Request $request)
    {
        if (Session::has('plata_online')) {
            $rezervari = \App\Rezervare::where('id', $request->session()->get('rezervare_id'))->first();
            // dd($rezervari);
        }else {
            $rezervari = $request->session()->get('rezervare');
        }

        // dd($rezervari);
        $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervari'))
            ->setPaper('a4');
                return $pdf->download('Rezervare ' . $rezervari->nume . '.pdf');
    }
}