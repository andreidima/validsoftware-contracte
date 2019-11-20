<?php

namespace App\Http\Controllers;

use App\Rezervare;
use App\Oras;
use App\Tarif;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

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
            'data_intoarcere' => [ 'required_if:tur_retur,true', 'max:50'],
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

        //Schimbare tur_retur din "true or false" din vue, in "0 or 1" pentru baza de date
        ($rezervare->tur_retur === "true") ? ($rezervare->tur_retur = 1) : ($rezervare->tur_retur = 0);
        
        // dd($rezervare);

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
        $request->session()->put('tarife', $tarife);
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
        $tarife = $request->session()->get('tarife');
        
        
        // dd($rezervare, $tarife);

        // $tarife = DB::table('tarife')
        //     ->where([
        //         ['traseu_id', $rezervare->traseu],
        //         ['tur_retur', ($rezervare->tur_retur=='true' ? 1 : 0)]
        //     ])
        //     ->first();

        return view('rezervari.guest-create/adauga-rezervare-pasul-2',compact('rezervare', 'tarife'));
    }

    /**
     * Post Request to store step2 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdaugaRezervarePasul2(Request $request)
    {   
        $rezervare = $request->session()->get('rezervare');
        $rezervare->created_at = \Carbon\Carbon::now();

        $tarife = $request->session()->get('tarife');
        
        // calcularea pretului total
        // $tarife = DB::table('tarife')
        //     ->where([
        //         ['traseu_id', $rezervare->traseu],
        //         ['tur_retur', ($rezervare->tur_retur=='true' ? 1 : 0)]
        //     ])
        //     ->first();
        $rezervare->pret_total = $tarife->adult * $rezervare->nr_adulti +
                                $tarife->copil * $rezervare->nr_copii +
                                $tarife->animal_mic * $rezervare->nr_animale_mici +
                                $tarife->animal_mare * $rezervare->nr_animale_mari;            
        
        // Verificare rezervare duplicat
        $request_verificare_duplicate = new Request([
            'nume' => $request->session()->get('rezervare.nume'),
            'telefon' => $request->session()->get('rezervare.telefon'),
            'data_plecare' => $request->session()->get('rezervare.data_plecare')
        ]);

        $this->validate($request_verificare_duplicate, [
            'nume' => ['required', 'max:100', 'unique:rezervari,nume,NULL,id,telefon,' . $request_verificare_duplicate->telefon . ',data_plecare,' . $request_verificare_duplicate->data_plecare]
        ],
        [
            'nume.unique' => 'Această Rezervare este deja înregistrată.'
        ]);

        //Schimbare tur_retur din "true or false" din vue, in "0 or 1" pentru baza de date
        // ($rezervare->tur_retur === "true") ? ($rezervare->tur_retur = 1) : ($rezervare->tur_retur = 0);

        $rezervare_array = $rezervare->toArray();
        unset($rezervare_array['traseu'], $rezervare_array['oras_plecare_nume'], $rezervare_array['oras_sosire_nume']);
        
        //Inserarea rezervarii in baza de date
        $id = DB::table('rezervari')->insertGetId($rezervare_array);
        
        // $id = $rezervari->save->insertGetId;
        
        $rezervare->id = $id;


        $request->session()->put('rezervare', $rezervare);
      

        // Trimitere email
        // if (!empty($rezervare->email)) {
        //     \Mail::to($rezervare->email)->send(
        //         new BiletClient($rezervare)
        //     );
        // }

        // if ($plata_online == 1){
        //     return redirect('/trimitere-catre-plata');
        // }else{
        // return redirect('/adauga-rezervare-pasul-3');
        // }
        return redirect('/adauga-rezervare-pasul-3');
    }

        /**
     * Show the step 3 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervarePasul3(Request $request)
    {
        if ($request->has('orderId')) {
            $plata_online = \App\PlataOnline::where('order_id', $request->orderId)->latest()->first();
            $rezervare = \App\Rezervare::where('id', $plata_online->rezervare_id)->first();

            $request->session()->put('plata_online', $plata_online);
            $request->session()->forget('rezervare');
            $request->session()->put('rezervare_id', $rezervare->id);

            // dd($rezervare, $rezervare->ora->ora);

            return view('rezervari.guest-create/adauga-rezervare-pasul-3', compact('rezervare', 'plata_online'));

        } else {
            $rezervare = $request->session()->get('rezervare');
            
            return view('rezervari.guest-create/adauga-rezervare-pasul-3', compact('rezervare'));
        }

        // $request->session()->forget('rezervare');
        // $request->session()->flush();
        // dd (session()); 
    }

    public function pdfExportGuest(Request $request)
    {
        if (Session::has('plata_online')) {
            $rezervare = \App\Rezervare::where('id', $request->session()->get('rezervare_id'))->first();
            // dd($rezervare);
        }else {
            $rezervare = $request->session()->get('rezervare');
        }
        
        $tarife = $request->session()->get('tarife');

        // $tarife = DB::table('tarife')
        //     ->where([
        //         ['traseu_id', $rezervari->traseu],
        //         ['tur_retur', ($rezervari->tur_retur == 'true' ? 1 : 0)]
        //     ])
        //     ->first();

        if ($request->view_type === 'rezervare-html') {
            return view('rezervari.export.rezervare-pdf', compact('rezervare', 'tarife'));
        } elseif ($request->view_type === 'rezervare-pdf') {
        $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervare', 'tarife'))
            ->setPaper('a4');
                return $pdf->download('Rezervare ' . $rezervare->nume . '.pdf');
        }
    }
}
