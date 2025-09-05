<?php

namespace App\Http\Controllers;

use App\Ofertare;
use App\OfertareServiciu;
use App\Firma;
use App\Client;
use App\Variabila;
use DB;
use Illuminate\Http\Request;

use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OfertareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_email_subiect = \Request::get('search_email_subiect');

        $ofertari = Ofertare::
            when($search_email_subiect, function ($query, $search_email_subiect) {
                return $query->where('email_subiect', 'like', '%' . $search_email_subiect . '%');
            })
            ->leftJoin('clienti', 'ofertari.client_id', '=', 'clienti.id')
            ->select('ofertari.*', 'clienti.nume')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('clienti.nume', 'like', '%' . $search_nume . '%');
            })
            ->latest('ofertari.created_at')
            ->simplePaginate(25);


        // $ofertari = Ofertare::first();
        // $html = '';
        // foreach ($ofertari as $ofertare){
        //     foreach ($ofertare->servicii as $serviciu) {
        //         $html .= $serviciu->nume;
        //     }
        // }
        // dd($html);

        return view('ofertari.index', compact('ofertari', 'search_nume', 'search_email_subiect'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $firme = Firma::select('id', 'nume')->orderBy('nume')->get();

        $clienti = Client::select('id', 'nume', 'telefon')
            ->orderBy('nume')
            ->get();

        $servicii = OfertareServiciu::
            orderBy('nume')
            ->get();

        $urmatorul_document_nr = \DB::table('variabile')->where('nume', 'nr_document')->first()->valoare;

        return view('ofertari.create', compact('firme', 'clienti', 'servicii', 'urmatorul_document_nr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $array = $request->input('servicii_selectate');
        // dd($array, $array->toArray());
        // dd($array->pluck('key'), array_values($array));


        \App\Variabila::Nr_document();
        $ofertare = Ofertare::create($this->validateRequest($request));
        $ofertare->servicii()->attach($request->input('servicii_selectate'));
        // $ofertare->servicii()->attach([1, 2]);

        return redirect($ofertare->path())->with('status',
            'Ofertarea Nr."' . $ofertare->nr_document . '", pentru clientul "' . ($ofertare->client->nume ?? '') . '", a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ofertare  $ofertare
     * @return \Illuminate\Http\Response
     */
    public function show(Ofertare $ofertari)
    {
        return view('ofertari.show', compact('ofertari'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ofertare  $ofertare
     * @return \Illuminate\Http\Response
     */
    public function edit(Ofertare $ofertari)
    {
        $firme = Firma::select('id', 'nume')->orderBy('nume')->get();

        $clienti = Client::select('id', 'nume', 'telefon')
            ->orderBy('nume')
            ->get();

        $servicii = OfertareServiciu::
            orderBy('nume')
            ->get();

        return view('ofertari.edit', compact('ofertari', 'firme', 'clienti', 'servicii'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ofertare  $ofertare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ofertare $ofertari)
    {
        // dd($request);
        // $this->validateRequest($request, $ofertari);
        // $ofertari->update($request->except(['date']));
        $ofertari->update($this->validateRequest($request, $ofertari));
        $ofertari->servicii()->sync($request->input('servicii_selectate'));

        return redirect($ofertari->path())->with('status',
            'Ofertarea Nr."' . $ofertari->nr_document . '", pentru clientul "' . ($ofertari->client->nume ?? '') . '", a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ofertare  $ofertare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ofertare $ofertari)
    {
        $ofertari->delete();
        return redirect('/ofertari')->with('status',
            'Ofertarea Nr."' . $ofertari->nr_document . '", pentru clientul "' . ($ofertari->client->nume ?? '') . '", a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'nr_document' => ['required', 'numeric'],
            'data_emitere' => [''],
            'limba' => ['required'],
            'firma_id' => ['required'],
            'client_id' => ['required'],
            'data_cerere' => [''],
            'descriere_solicitare' => [''],
            'propunere_tehnica_si_comerciala' => [''],
            'pret' => ['nullable', 'numeric', 'max:99999'],
            'solicitata' => 'required',
            'pdf_in_email' => 'required',
            'email_subiect' => 'required_if:solicitata,0',
            'email_text' => 'required_if:solicitata,0',
        ]);
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function trimiteEmail(Request $request, Ofertare $ofertari)
    {
        $emailuri_to = $ofertari->client->email ?? '';
        $emailuri_to = str_replace(' ', '', $emailuri_to);
        $emailuri_to = explode(',', $emailuri_to);
        // Verificare daca exista email corect catre care sa se trimita mesajul
        $validator = Validator::make($emailuri_to, [
            '*' => ['email:rfc,dns']
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Extragere din baza de date a emailurilor interne ale firmei catre care sa se trimita mesajul cu BCC
        $emailuri_bcc = \App\Variabila::select('valoare')->where('nume', 'emailuri_service_bcc')->first()->valoare;
        $emailuri_bcc = str_replace(' ', '', $emailuri_bcc);
        $emailuri_bcc = explode(',', $emailuri_bcc);
        // Verificare daca exista email corect catre care sa se trimita mesajul
        $validator = Validator::make($emailuri_bcc, [
            '*' => ['email:rfc,dns']
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

            // Trimiterea mesajului
        if (intval($ofertari->solicitata) === 1) {
            \Mail::mailer('comunicare')
                ->to($emailuri_to)
                ->bcc($emailuri_bcc)
                ->send(
                    new \App\Mail\Ofertare($ofertari)
                );
            $mesaj_trimis = new \App\MesajTrimis;
            $mesaj_trimis->inregistrare_id = $ofertari->id;
            $mesaj_trimis->categorie = 'Ofertare';
            // $mesaj_trimis->subcategorie = '';
            $mesaj_trimis->save();
            return back()->with('status', 'Emailul a fost trimis către „' . $ofertari->client->email . '” cu succes!');
        }else if (intval($ofertari->solicitata) === 0){
            // Trimiterea mesajului
            \Mail::mailer('comunicare')
                // ->to('contact@validsoftware.ro')
                ->to([])
                ->bcc($emailuri_to)
                ->send(
                    new \App\Mail\Ofertare($ofertari)
                );
            $mesaj_trimis = new \App\MesajTrimis;
            $mesaj_trimis->inregistrare_id = $ofertari->id;
            $mesaj_trimis->categorie = 'Ofertare';
            // $mesaj_trimis->subcategorie = '';
            $mesaj_trimis->save();
            return back()->with('status', 'Emailul a fost trimis către „' . $ofertari->client->email . '” cu succes!');
        }else{
            return back()->with('error', 'Emailul nu s-a putut trimite către „' . $ofertari->client->email . '”.');
        }
    }

    public function duplicaOfertare(Request $request, Ofertare $ofertare)
    {
        $ofertare = $ofertare->replicate();

        $ofertare->nr_document = Variabila::Nr_document(); // se da un nr nou ofertareului
        $ofertare->created_at = Carbon::now();
        $ofertare->updated_at = Carbon::now();

        $ofertare->save();

        return redirect()->action(
            'OfertareController@edit',
            ['ofertari' => $ofertare->id]
        );

        // return redirect('/contracte')->with('status',
        //     'Contractul Nr."' . $contract->contract_nr . '", pentru clientul "' . ($contract->client->nume ?? '') . '", a fost duplicat cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function pdfExport(Request $request, Ofertare $ofertari)
    {
        if ($request->view_type === 'ofertare-html') {
            return view('ofertari.export.ofertare-pdf', compact('ofertari'));
        } elseif ($request->view_type === 'ofertare-pdf') {
            $pdf = \PDF::loadView('ofertari.export.ofertare-pdf', compact('ofertari'))
                ->setPaper('a4', 'portrait');
            $pdf->getDomPDF()->set_option("enable_php", true);
            return $pdf->download(
                ((intval($ofertari->solicitata) === 0) ? 'Ofertarea' : 'Cererea') .
                ' Validsoftware nr. ' . $ofertari->nr_document . (isset($ofertari->data_emitere) ? (' din ' . Carbon::parse($ofertari->data_emitere)->isoFormat('DD.MM.YYYY')) : '') .
                    // ' - ' . ($ofertari->client->nume ?? '') . '.pdf'
                    '.pdf'
            );
        }
    }



    /**
     * @changed 2025-09-03
     * @reason  Replaced old function with new implementation (chatGPT generated)
     */
    public function wordExport(Request $request, Ofertare $ofertari)
    {
            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            $phpWord->setDefaultFontName('Times New Roman');
            $phpWord->setDefaultFontSize(12);

            $phpWord->setDefaultParagraphStyle(
                array(
                    // 'align'      => 'both',
                    // 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
                    // 'spacing'    => 120,
                )
            );

            $section = $phpWord->addSection(
                array(
                    'marginLeft'   => 1200,
                    'marginRight'  => 1200,
                    'marginTop'    => 0,
                    'marginBottom' => 700,
                    'headerHeight' => 2000,
                    'footerHeight' => 0,
                )
            );

            $header = $section->addHeader();
            // $header->addImage('images/contract-header.jpg', array('width' => 80, 'height' => 80));
            // $header->addImage('images/contract-header.jpg');
            $header->addImage(
                'images/contract-header.jpg',
                array(
                    'width'            => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(15.7),
                    // 'height'           => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(10),
                    'positioning'      => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                    'posHorizontal'    => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_CENTER,
                    'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
                    'posVerticalRel'   => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
                    'marginLeft'       => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(0),
                    'marginTop'        => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(0),
                    // 'marginBottom'     => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(10),
                )
            );



            $html = '<p style="text-align: center;">Ofertarea Nr. <b>' . $ofertari->nr_document . '</b>' .
                    (isset($ofertari->data_emitere) ? (' din <b>' . Carbon::parse($ofertari->data_emitere)->isoFormat('DD.MM.YYYY')) . '</b>' : '') .
                '</p><br />';


            if($ofertari->solicitata === 1){
                $html .= '<b>Introducere</b>';

                $html .= '<p style="text-align: justify;">' .
                            '          Documentul curent reprezintă răspunsul <b>' . ($ofertari->firma->nume ?? '') . '</b> la cererea de servicii primită de la <b>' .
                            $ofertari->client->nume . '</b>, în data de <b>' .
                            (isset($ofertari->data_cerere) ? (Carbon::parse($ofertari->data_cerere)->isoFormat('DD.MM.YYYY')) : '..........') . '</b>.' .
                        '</p>' .
                    '<br />';
            }

            $html .= '<b>Despre noi</b>';

            $html .= '<p style="text-align: justify;">' .
                    '          Suntem o firmă din Focșani, înființată în anul 2012, orientată pe dezvoltarea de servicii informatice și consultanță IT. ' .
                    'Produsele informatice pe care le oferim acoperă atât clienți din sectorul public/ privat din România, cât și cei de pe piața internațională. ' .
                    'Pentru mai multe detalii legate de activitatea noastră, vă invităm să accesați secțiunea <i>Portofoliu</i> de la adresa https://validsoftware.ro' .
                '</p>' .
                '<br />';

            $html .= '<p style="text-align: left;">' .
                        '<b>Ce vă oferim</b>' .
                    '</p>';

            $html .= '<p style="text-align: justify;">' .
                    '          Venim în întâmpinarea nevoilor dumneavoastră prin servicii de achiziționare și găzduire domenii, realizare site-uri web, dezvoltare software personalizat, promovare online, consultanță IT, precum și servicii multimedia, utilizând tehnologii de actualitate.' .
                    '</p>' .
                '<br />';

            $html .= '<b>Echipă și scop</b>';

            $html .= '<p style="text-align: justify;">' .
                    '          Echipa noastră este formată din specialiști, absolvenți de studii superioare în domeniul IT, dar și în domenii conexe. Scopul nostru este furnizarea de servicii integrate, pentru a oferi clienților noștri creșterea competitivității și performanței activităților pe care le desfășoară.' .
                    '</p>' .
                '<br />';

            $html .= '<p style="text-align: left;">' .
                        '<b>Tehnologie</b>' .
                    '</p>';

            $html .= '<p style="text-align: justify;">' .
                    '          Adoptăm tehnologii de ultimă oră și ne bazăm pe spiritul de inovație al colegilor noștri. Oferim calitate și eficiență, finalizând cu succes proiectele, indiferent dacă acestea implică soluții simple sau complexe.' .
                    '</p>' .
                '<br />';

            $html .= '
                    <table align="center" style="width: 100%">
                        <tr>
                            <td style="width:70%" align="center">
                            &nbsp;
                            </td>
                            <td style="width:30%; text-align: center;" align="center">
                                ' . ($ofertari->firma->nume ?? '') . '
                                <br/>
                                ' .
                                ((isset($ofertari->firma->nume_semnatura) && file_exists('images/' . ($ofertari->firma->nume_semnatura ?? ''))) ? ('<img src="images/' . ($ofertari->firma->nume_semnatura ?? '') . '" width="100"/>') : '') .
                                '
                            </td>
                        </tr>
                    </table>
                ';

            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

            $section->addPageBreak();

            if ($ofertari->descriere_solicitare){
                $html = '<br />' .
                        '<p style="text-align: left;">' .
                            '<b>Descriere solicitare</b>' .
                        '</p>';
                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

                $descriere_solicitare = str_replace('<br>', '<br/>', $ofertari->descriere_solicitare);

                $descriere_solicitare = str_replace('class="ql-align-right ql-direction-rtl"', 'dir="rtl"', $descriere_solicitare);

                $descriere_solicitare = str_replace('class', 'style', $descriere_solicitare);

                $descriere_solicitare = str_replace('ql-size-small', 'font-size:10px;', $descriere_solicitare);
                $descriere_solicitare = str_replace('ql-size-large', 'font-size:20px;', $descriere_solicitare);
                $descriere_solicitare = str_replace('ql-size-huge', 'font-size:26px;', $descriere_solicitare);

                $descriere_solicitare = str_replace('ql-align-justify', 'text-align:justify;', $descriere_solicitare);
                $descriere_solicitare = str_replace('ql-align-center', 'text-align:center;', $descriere_solicitare);
                $descriere_solicitare = str_replace('ql-align-right', 'text-align:right;', $descriere_solicitare);

                $descriere_solicitare = str_replace('ql-indent-1', 'text-indent: 40px;', $descriere_solicitare);
                $descriere_solicitare = str_replace('ql-indent-2', 'text-indent: 80px;', $descriere_solicitare);
                $descriere_solicitare = str_replace('ql-indent-3', 'text-indent: 120px;', $descriere_solicitare);
                $descriere_solicitare = str_replace('ql-indent-4', 'text-indent: 160px;', $descriere_solicitare);
                $descriere_solicitare = str_replace('ql-indent-5', 'text-indent: 200px;', $descriere_solicitare);

                $descriere_solicitare = str_replace('color: rgb(230, 0, 0);', 'color: #ff0000;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(255, 153, 0);', 'color: #ff9900;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(255, 255, 0);', 'color: #ffff00;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(0, 138, 0);', 'color: #008a00;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(0, 102, 204);', 'color: #0066cc;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(153, 51, 255);', 'color: #9933ff;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(255, 255, 255);', 'color: #ffffff;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(250, 204, 204);', 'color: #facccc;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(255, 235, 204);', 'color: #ffebcc;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(255, 255, 204);', 'color: #ffffcc;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(204, 232, 204);', 'color: #cce8cc;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(204, 224, 245);', 'color: #cce0f5;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(235, 214, 255);', 'color: #ebd6ff;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(187, 187, 187);', 'color: #bbbbbb;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(240, 102, 102);', 'color: #f06666;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(255, 194, 102);', 'color: #ffc266;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(255, 255, 102);', 'color: #ffff66;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(102, 185, 102);', 'color: #66b966;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(102, 163, 224);', 'color: #66a3e0;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(194, 133, 255);', 'color: #c285ff;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(136, 136, 136);', 'color: #888888;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(161, 0, 0);', 'color: #a10000;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(178, 107, 0);', 'color: #b26b00;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(178, 178, 0);', 'color: #b2b200;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(0, 97, 0);', 'color: #006100;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(0, 71, 178);', 'color: #0047b2;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(107, 36, 178);', 'color: #6b24b2;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(68, 68, 68);', 'color: #444444;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(92, 0, 0);', 'color: #5c0000;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(102, 61, 0);', 'color: #663d00;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(102, 102, 0);', 'color: #666600;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(0, 55, 0);', 'color: #003700;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(0, 41, 102);', 'color: #002966;', $descriere_solicitare);
                $descriere_solicitare = str_replace('color: rgb(61, 20, 102);', 'color: #3d1466;', $descriere_solicitare);

                $descriere_solicitare = str_replace('background-color: rgb(230, 0, 0);', 'background-color: #ff0000;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(255, 153, 0);', 'background-color: #ff9900;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(255, 255, 0);', 'background-color: #ffff00;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(0, 138, 0);', 'background-color: #008a00;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(0, 102, 204);', 'background-color: #0066cc;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(153, 51, 255);', 'background-color: #9933ff;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(255, 255, 255);', 'background-color: #ffffff;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(250, 204, 204);', 'background-color: #facccc;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(255, 235, 204);', 'background-color: #ffebcc;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(255, 255, 204);', 'background-color: #ffffcc;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(204, 232, 204);', 'background-color: #cce8cc;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(204, 224, 245);', 'background-color: #cce0f5;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(235, 214, 255);', 'background-color: #ebd6ff;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(187, 187, 187);', 'background-color: #bbbbbb;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(240, 102, 102);', 'background-color: #f06666;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(255, 194, 102);', 'background-color: #ffc266;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(255, 255, 102);', 'background-color: #ffff66;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(102, 185, 102);', 'background-color: #66b966;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(102, 163, 224);', 'background-color: #66a3e0;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(194, 133, 255);', 'background-color: #c285ff;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(136, 136, 136);', 'background-color: #888888;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(161, 0, 0);', 'background-color: #a10000;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(178, 107, 0);', 'background-color: #b26b00;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(178, 178, 0);', 'background-color: #b2b200;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(0, 97, 0);', 'background-color: #006100;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(0, 71, 178);', 'background-color: #0047b2;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(107, 36, 178);', 'background-color: #6b24b2;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(68, 68, 68);', 'background-color: #444444;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(92, 0, 0);', 'background-color: #5c0000;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(102, 61, 0);', 'background-color: #663d00;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(102, 102, 0);', 'background-color: #666600;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(0, 55, 0);', 'background-color: #003700;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(0, 41, 102);', 'background-color: #002966;', $descriere_solicitare);
                $descriere_solicitare = str_replace('background-color: rgb(61, 20, 102);', 'background-color: #3d1466;', $descriere_solicitare);



                /**
                 * @added   2025.09.03
                 * @reason  To fix export errors
                 */
                // 1) Make every <br> (with or without attributes) self-closed
                $descriere_solicitare = preg_replace_callback(
                    '~<\s*br\b([^>]*)>~i',
                    function($m) {
                        $attrs = rtrim($m[1], " \t\n\r\0\x0B/"); // clean trailing spaces/slash
                        return '<br' . $attrs . '/>';
                    },
                    $descriere_solicitare
                );
                // 2) Remove a <br/> immediately before </p> (common Quill artifact)
                $descriere_solicitare = preg_replace('~<br\s*/>\s*</p>~i', '</p>', $descriere_solicitare);



                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $descriere_solicitare, false, false);
            }


            $html = '<br />' .
                    '<p style="text-align: left;">' .
                        '<b>Propunere tehnică și comercială</b>' .
                    '</p>';
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

            $propunere_tehnica_si_comerciala = str_replace('<br>', '<br/>', $ofertari->propunere_tehnica_si_comerciala);

            $propunere_tehnica_si_comerciala = str_replace('class="ql-align-right ql-direction-rtl"', 'dir="rtl"', $propunere_tehnica_si_comerciala);

            $propunere_tehnica_si_comerciala = str_replace('class', 'style', $propunere_tehnica_si_comerciala);

            $propunere_tehnica_si_comerciala = str_replace('ql-size-small', 'font-size:10px;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-size-large', 'font-size:20px;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-size-huge', 'font-size:26px;', $propunere_tehnica_si_comerciala);

            $propunere_tehnica_si_comerciala = str_replace('ql-align-justify', 'text-align:justify;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-align-center', 'text-align:center;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-align-right', 'text-align:right;', $propunere_tehnica_si_comerciala);

            $propunere_tehnica_si_comerciala = str_replace('ql-indent-1', 'text-indent: 40px;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-indent-2', 'text-indent: 80px;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-indent-3', 'text-indent: 120px;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-indent-4', 'text-indent: 160px;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-indent-5', 'text-indent: 200px;', $propunere_tehnica_si_comerciala);

            $propunere_tehnica_si_comerciala = str_replace('color: rgb(230, 0, 0);', 'color: #ff0000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 153, 0);', 'color: #ff9900;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 255, 0);', 'color: #ffff00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 138, 0);', 'color: #008a00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 102, 204);', 'color: #0066cc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(153, 51, 255);', 'color: #9933ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 255, 255);', 'color: #ffffff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(250, 204, 204);', 'color: #facccc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 235, 204);', 'color: #ffebcc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 255, 204);', 'color: #ffffcc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(204, 232, 204);', 'color: #cce8cc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(204, 224, 245);', 'color: #cce0f5;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(235, 214, 255);', 'color: #ebd6ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(187, 187, 187);', 'color: #bbbbbb;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(240, 102, 102);', 'color: #f06666;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 194, 102);', 'color: #ffc266;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 255, 102);', 'color: #ffff66;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(102, 185, 102);', 'color: #66b966;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(102, 163, 224);', 'color: #66a3e0;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(194, 133, 255);', 'color: #c285ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(136, 136, 136);', 'color: #888888;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(161, 0, 0);', 'color: #a10000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(178, 107, 0);', 'color: #b26b00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(178, 178, 0);', 'color: #b2b200;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 97, 0);', 'color: #006100;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 71, 178);', 'color: #0047b2;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(107, 36, 178);', 'color: #6b24b2;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(68, 68, 68);', 'color: #444444;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(92, 0, 0);', 'color: #5c0000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(102, 61, 0);', 'color: #663d00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(102, 102, 0);', 'color: #666600;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 55, 0);', 'color: #003700;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 41, 102);', 'color: #002966;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(61, 20, 102);', 'color: #3d1466;', $propunere_tehnica_si_comerciala);

            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(230, 0, 0);', 'background-color: #ff0000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 153, 0);', 'background-color: #ff9900;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 255, 0);', 'background-color: #ffff00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 138, 0);', 'background-color: #008a00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 102, 204);', 'background-color: #0066cc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(153, 51, 255);', 'background-color: #9933ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 255, 255);', 'background-color: #ffffff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(250, 204, 204);', 'background-color: #facccc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 235, 204);', 'background-color: #ffebcc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 255, 204);', 'background-color: #ffffcc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(204, 232, 204);', 'background-color: #cce8cc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(204, 224, 245);', 'background-color: #cce0f5;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(235, 214, 255);', 'background-color: #ebd6ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(187, 187, 187);', 'background-color: #bbbbbb;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(240, 102, 102);', 'background-color: #f06666;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 194, 102);', 'background-color: #ffc266;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 255, 102);', 'background-color: #ffff66;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(102, 185, 102);', 'background-color: #66b966;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(102, 163, 224);', 'background-color: #66a3e0;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(194, 133, 255);', 'background-color: #c285ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(136, 136, 136);', 'background-color: #888888;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(161, 0, 0);', 'background-color: #a10000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(178, 107, 0);', 'background-color: #b26b00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(178, 178, 0);', 'background-color: #b2b200;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 97, 0);', 'background-color: #006100;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 71, 178);', 'background-color: #0047b2;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(107, 36, 178);', 'background-color: #6b24b2;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(68, 68, 68);', 'background-color: #444444;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(92, 0, 0);', 'background-color: #5c0000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(102, 61, 0);', 'background-color: #663d00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(102, 102, 0);', 'background-color: #666600;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 55, 0);', 'background-color: #003700;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 41, 102);', 'background-color: #002966;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(61, 20, 102);', 'background-color: #3d1466;', $propunere_tehnica_si_comerciala);



            /**
             * @added   2025.09.03
             * @reason  To fix export errors
             */
            // 1) Make every <br> (with or without attributes) self-closed
            $propunere_tehnica_si_comerciala = preg_replace_callback(
                '~<\s*br\b([^>]*)>~i',
                function($m) {
                    $attrs = rtrim($m[1], " \t\n\r\0\x0B/"); // clean trailing spaces/slash
                    return '<br' . $attrs . '/>';
                },
                $propunere_tehnica_si_comerciala
            );
            // 2) Remove a <br/> immediately before </p> (common Quill artifact)
            $propunere_tehnica_si_comerciala = preg_replace('~<br\s*/>\s*</p>~i', '</p>', $propunere_tehnica_si_comerciala);



            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $propunere_tehnica_si_comerciala, false, false);


            $html ='<ul>';
            foreach ($ofertari->servicii as $serviciu) {
                $html .= '<li>' . $serviciu->nume;
                    if ($serviciu->pret){
                        $html .= ' - ' . $serviciu->pret . ' RON';
                    }
                    if ($serviciu->recurenta){
                        $html .= '/ ' . $serviciu->recurenta;
                    }
                $html .= '</li>';
            }
            $html .='</ul>';
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);


            $html = '
                <br /><br />
                    <table align="center" style="width: 100%">
                        <tr>
                            <td style="width:70%" align="center">
                            &nbsp;
                            </td>
                            <td style="width:30%; text-align: center;" align="center">
                                ' . ($ofertari->firma->nume ?? '') . '
                                <br/>
                                ' .
                                ((isset($ofertari->firma->nume_semnatura) && file_exists('images/' . ($ofertari->firma->nume_semnatura ?? ''))) ? ('<img src="images/' . ($ofertari->firma->nume_semnatura ?? '') . '" width="100"/>') : '') .
                                '
                            </td>
                        </tr>
                    </table>
                ';

            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

            $footer = $section->addFooter();
            $footer->addPreserveText('Pagina {PAGE} din {NUMPAGES}', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));


        if ($request->view_type === 'ofertare-html') {
            echo $html;
        } elseif ($request->view_type === 'ofertare-word') {
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            try {
                Storage::makeDirectory('fisiere_temporare');
                $objWriter->save(storage_path(
                    'app/fisiere_temporare/' .
                    'Ofertarea nr. ' . $ofertari->nr_document .
                    (isset($ofertari->data_emitere) ? (' din data de ' . Carbon::parse($ofertari->data_emitere)->isoFormat('DD.MM.YYYY')) : '') .
                    ' - ' . ($ofertari->client->nume ?? '') . '.docx'
                ));
            } catch (Exception $e) { }

            return response()->download(storage_path(
                'app/fisiere_temporare/' .
                    'Ofertarea nr. ' . $ofertari->nr_document .
                    (isset($ofertari->data_emitere) ? (' din data de ' . Carbon::parse($ofertari->data_emitere)->isoFormat('DD.MM.YYYY')) : '') .
                    ' - ' . ($ofertari->client->nume ?? '') . '.docx'
            ));
        }
    }


}
