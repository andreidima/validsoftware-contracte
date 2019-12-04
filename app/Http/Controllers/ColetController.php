<?php

namespace App\Http\Controllers;

use App\Colet;
use App\Oras;
use Illuminate\Http\Request;
use Session;
use DB;

class ColetController extends Controller
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
     * @param  \App\Colet  $colet
     * @return \Illuminate\Http\Response
     */
    public function show(Colet $colet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Colet  $colet
     * @return \Illuminate\Http\Response
     */
    public function edit(Colet $colet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Colet  $colet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Colet $colet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Colet  $colet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colet $colet)
    {
        //
    }




    /**
     * Returnarea oraselor de sosire
     */
    public function orase_colete(Request $request)
    {
        $raspuns = '';
        switch ($_GET['request']) {
            case 'orase_plecare':
                $raspuns = Oras::select('id', 'nume', 'tara')
                    ->where('tara', $request->traseu)
                    ->orderBy('nume')
                    ->get();
                break;
            case 'orase_sosire':
                if ($request->traseu <> 0) {
                    $raspuns = Oras::select('id', 'nume', 'tara')
                        ->where('tara', '<>', $request->traseu)
                        ->orderBy('nume')
                        ->get();
                }
                break;
            default:
                break;
        }
        return response()->json([
            'raspuns' => $raspuns,
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
        return request()->validate(
            [
                // 'cursa_id' =>['nullable', 'numeric', 'max:999'],
                'traseu' => ['required'],
                'oras_plecare' => ['required', 'integer', 'max:999'],
                'oras_sosire' => ['required', 'integer', 'max:999'],
                'numar_colete' => ['required', 'integer', 'between:1,100'],
                'detalii_colete' => ['max:2000'],
                'nume' =>['required', 'max:200'],
                // 'nume' => ($request->_method === "PATCH") ?
                //     [
                //         'required', 'max:200',
                //         Rule::unique('rezervari')->ignore($rezervari->id)->where(function ($query) use ($rezervari, $request) {
                //             return $query->where('telefon', $request->telefon)
                //                 ->where('data_cursa', $request->data_cursa);
                //         }),
                //     ]
                //     : [
                //         'required', 'max:200',
                //         Rule::unique('rezervari')->where(function ($query) use ($rezervari, $request) {
                //             return $query->where('telefon', $request->telefon)
                //                 ->where('data_plecare', $request->data_plecare);
                //         }),
                //     ],
                'telefon' => ['required', 'regex:/^[0-9 ]+$/', 'max: 100'],
                'email' => ['required', 'email', 'max:100'],
                'adresa' => ['max:2000'],
                'observatii' => ['max:2000'],
                'document_de_calatorie' => ['', 'max:20'],
                'expirare_document' => ['', 'max:50'],
                'serie_document' => ['', 'max:20'],
                'cnp' => ['', 'max:20'],
                'acord_de_confidentialitate' => ['required'],
                'termeni_si_conditii' => ['required'],
            ],
            [
                'telefon.regex' => 'Câmpul Telefon poate conține doar cifre și spații.',
                'nume.unique' => 'Această Rezervare este deja înregistrată.',
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
    public function adaugaColetPasul1(Request $request)
    {
        return view('colete.guest-create/adauga-colet-pasul-1');
    }

    /**
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdaugaColetPasul1(Request $request)
    {
        $request->session()->forget('colet');
        $colet = Colet::make($this->validateRequest($request));

        $request->session()->put('colet', $colet);
        // dd($rezervare, $tarife);
        return redirect('/adauga-colet-pasul-2');
    }

    /**
     * Show the step 2 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaColetPasul2(Request $request)
    {
        $colet = $request->session()->get('colet');

        return view('colete.guest-create/adauga-colet-pasul-2', compact('colet'));
    }

    /**
     * Post Request to store step2 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdaugaColetPasul2(Request $request)
    {
        $colet = $request->session()->get('colet');
        $colet->created_at = \Carbon\Carbon::now();       

        $colet_array = $colet->toArray();
        unset($colet_array['traseu'], $colet_array['oras_plecare_nume'], $colet_array['oras_sosire_nume'],
                $colet_array['acord_de_confidentialitate'], $colet_array['termeni_si_conditii']);

        //Inserarea rezervarii in baza de date
        $id = DB::table('colete')->insertGetId($colet_array);

        // $id = $rezervari->save->insertGetId;

        $colet->id = $id;


        $request->session()->put('colet', $colet);


        // Trimitere email
        \Mail::to('andrei.dima@usm.ro')->send(
            new CreareTransportColet($colet)
        );
        // \Mail::to('alsimy_mond_travel@yahoo.com')->send(
        //     new CreareRezervare($rezervare, $tarife)
        // );

        return redirect('/adauga-colet-pasul-3');
    }

    /**
     * Show the step 3 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaColetPasul3(Request $request)
    {
        $colet = $request->session()->get('colet');

        return view('colete.guest-create/adauga-colet-pasul-3', compact('colet'));
        
    }

    public function pdfExportGuest(Request $request)
    {
        $colet = $request->session()->get('colet');

        if ($request->view_type === 'colet-html') {
            return view('colete.export.colet-pdf', compact('colet'));
        } elseif ($request->view_type === 'colet-pdf') {
            $pdf = \PDF::loadView('colete.export.colet-pdf', compact('colet'))
                ->setPaper('a4');
            return $pdf->download('Rezervare ' . $colet->nume . '.pdf');
        }
    }
}
