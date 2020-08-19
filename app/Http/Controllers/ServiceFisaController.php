<?php

namespace App\Http\Controllers;

use App\ServiceFisa;
use App\ServiceClient;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class ServiceFisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_numar = \Request::get('search_numar');
        $search_nume = \Request::get('search_nume');
            
        $service_fise = ServiceFisa::
            leftJoin('service_clienti', 'service_fise.client_id', '=', 'service_clienti.id')
            ->select(
                'service_fise.*', 
                'service_clienti.nume',                
                'service_clienti.nr_ord_reg_com',                
                'service_clienti.cui',                
                'service_clienti.adresa',                
                'service_clienti.iban',                
                'service_clienti.banca',                
                'service_clienti.reprezentant',                
                'service_clienti.reprezentant_functie',                
                'service_clienti.telefon',                
                'service_clienti.email',                
                'service_clienti.site_web'
            )
            ->when($search_numar, function ($query, $search_numar) {
                return $query->where('service_fise.nr_fisa', $search_numar);
            })
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('service_clienti.nume', 'like', '%' . $search_nume . '%');
            })
            ->latest('service_fise.created_at')
            ->simplePaginate(25);

        return view('service.fise.index', compact('service_fise', 'search_numar', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clienti = ServiceClient::all();
        $clienti = $clienti->sortBy('nume')->values();

        $urmatorul_document_nr = \DB::table('variabile')->where('nume', 'nr_document')->first()->valoare;

        return view('service.fise.create', compact('clienti', 'urmatorul_document_nr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = ServiceClient::where('id', $request->client_deja_inregistrat)->first();
        if (isset($client)){
            $client->update($this->validateRequestClient($request));
        } else {
            $client = ServiceClient::make($this->validateRequestClient($request));
            $client->save();
        }

        $service_fisa = ServiceFisa::make($this->validateRequestFisa($request));
        $service_fisa->client_id = $client->id;
        $service_fisa->save();
        
        // Incrementare nr_document
        \App\Variabila::Nr_document();

        return redirect($service_fisa->path())->with('status', 
            'Fișa de service Nr."' . $service_fisa->nr_fisa . '", pentru clientul "' . ($service_fisa->client->nume ?? '') . '", a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceFisa  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceFisa $fise)
    {
        return view('service.fise.show', compact('fise'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceFisa  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceFisa $fise)
    {
        $clienti = ServiceClient::all();
        $clienti = $clienti->sortBy('nume')->values();

        return view('service.fise.edit', compact('fise', 'clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceFisa  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceFisa $fise)
    {
        $client = ServiceClient::where('id', $request->client_deja_inregistrat)->first();
        if (isset($client)){
            $client->update($this->validateRequestClient($request));
        } else {
            $client = ServiceClient::make($this->validateRequestClient($request));
            $client->save();
        }

        $fise->update($this->validateRequestFisa($request, $fise));

        return redirect($fise->path())->with('status', 
            'Fișa de service Nr."' . $fise->nr_fisa . '", pentru clientul "' . ($fise->client->nume ?? '') . '", a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceFisa  $fisaService
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceFisa $fise)
    {
        $fise->delete();
        return redirect('/service/fise')->with('status', 'Fișa "' . $fise->nr_fisa . '" a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequestClient(Request $request)
    {
        return request()->validate([
            'client_id' =>['nullable'],
            'nume' => ['required', 'max:100'],
            'nr_ord_reg_com' => ['max:50'],
            'cui' => ['max:50'],
            'adresa' => ['max:180'],
            'iban' => ['max:100'],
            'banca' => ['max:100'],
            'reprezentant' => ['max:100'],
            'reprezentant_functie' => ['max:100'],
            'telefon' => ['max:100'],
            'email' => ['nullable', 'max:180'],
            'site_web' => ['nullable', 'max:180'],
        ]);
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequestFisa(Request $request)
    {
        return request()->validate([
            'nr_fisa' => ['required', 'numeric'],
            'tehnician_service' => ['max:90'],
            'data_receptie' => [''],
            'descriere_echipament' => [''],
            'defect_reclamat' => [''],
            'defect_constatat' => [''],
            'rezultat_service' => [''],
            'observatii' => [''],
            'data_ridicare' => ['']
        ]);
    }

    public function wordExport(Request $request, ServiceFisa $fise)
    {
        if ($request->view_type === 'fisa-html') {
            //render html
        } elseif ($request->view_type === 'fisa-word') {
            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            $phpWord->setDefaultFontName('Times New Roman');
            $phpWord->setDefaultFontSize(12);

            $phpWord->setDefaultParagraphStyle(
                array(
                    'align'      => 'both',
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
                    'headerHeight' => 1700,
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

            $html = '<p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE INTRARE IN SERVICE</p>';
            $html .= '<p style="text-align: center; font-weight: bold;">Nr. ' . $fise->nr_fisa . (isset($fise->data_receptie) ? (' din ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY')) : '') .
                '</p>';
            $html .= '<br />';

            $html .= '<p style="text-align:justify;">' .
                'Beneficiar ' . ($fise->client->nume ?? '') .
                (isset($fise->client->adresa) ? ', din ' . ($fise->client->adresa) : '') .
                (isset($fise->client->nr_ord_reg_com) ? ', Nr. Reg. Comerțului: ' . ($fise->client->nr_ord_reg_com) : '') .
                (isset($fise->client->cui) ? ', CUI: ' . ($fise->client->cui) : '') .
                (isset($fise->client->iban) ? ', IBAN: ' . ($fise->client->iban) : '') .
                (isset($fise->client->banca) ? ', Banca ' . ($fise->client->banca) : '') .
                (isset($fise->client->reprezentant) ? ', Reprezentant ' . ($fise->client->reprezentant) : '') .
                (isset($fise->client->reprezentant_functie) ? ', în funcția de ' . ($fise->client->reprezentant_functie) : '') .
                (isset($fise->client->telefon) ? ', telefon: ' . ($fise->client->telefon) : '') .
                (isset($fise->client->email) ? ', email: ' . ($fise->client->email) : '') . 
                (isset($fise->client->site_web) ? ', site web: ' . ($fise->client->site_web) : '') .
                '</p>';
            $html .= '<br />';

            $html .= '<p style="text-align:left; font-weight: bold;">Descriere echipament</p>
                    <p style="text-align:justify;">' .
                        $fise->descriere_echipament .
                    '</p>
                    <br />

                    <p style="text-align:left; font-weight: bold;">Defect reclamat</p>
                    <p style="text-align:justify;">' .
                        $fise->defect_reclamat .
                    '</p>
                    <br />

                    <p style="text-align:left; font-weight: bold;">Defect constatat</p>
                    <p style="text-align:justify;">' .
                        $fise->defect_constatat .
                    '</p>
                    <br />

                    <p style="text-align:left; font-weight: bold;">Rezultat service</p>
                    <p style="text-align:justify;">' .
                        $fise->rezultat_service .
                    '</p>
                    <br />

                    <p style="text-align:left; font-weight: bold;">Observatii</p>
                    <p style="text-align:justify;">' .
                        $fise->observatii .
                    '</p>
                    <br />

                    <p style="text-align:left; font-weight: bold;">Tehnician service: ' .
                        $fise->tehnician_service .
                    '</p>
                    <br />

                    <input type="checkbox" />sdfsdf

                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" />
<label for="vehicle1"> I have a bike</label>
                    ';

            // if ($contracte->abonament_lunar === 1) {
            //     $html .= '<li><b>Dima P. Valentin</b> va genera lunar un raport de activitate, care va fi inaintat beneficiarului. </li>';
            // }

            // $html .= '<br /><br />';
            // $html .= '
            //         <table align="center" style="width: 100%">
            //             <tr>
            //                 <td style="width:50%" align="center"><b>Achizitor,</b>
            //                     <br/>' . $contracte->client->nume .
            //     '<br /><br />' . $contracte->client->reprezentant_functie .
            //     '<br />' . $contracte->client->reprezentant . '</td>                            
            //                 <td style="width:50%" align="center"><b>Prestator,</b>
            //                     <br/>Dima P. Valentin PFA
            //                     <br/>
            //                     <img src="images/semnatura si stampila.png" width="100"/></td>
            //             </tr>
            //         </table>
            //     ';

            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);



            // $section->addPageBreak();


            // $html = '<p style="text-align: center; font-weight: bold; font-size: 21px;">Plan de lucru</p>
            //         <br />
            //         <p style="font-weight: bold;">Anexa nr. 01 ' . (isset($contracte->contract_data) ? (' din ' . \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('D.MM.YYYY')) : '') .
            //     ' la CONTRACTUL DE PRESTARE DE SERVICII INFORMATICE Nr. ' .
            //     $contracte->contract_nr . (isset($contracte->contract_data) ? (' din ' . \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('D.MM.YYYY')) : '') .
            //     '</p>
            //         <br /><br />
            //     <ol>
            //             <li><b>Durata</b>: prezentul Plan de lucru acoperă toată perioada de valabilitate a prezentului contract.</li>
            //             <li>Următoarele servicii vor fi acoperite de Planul de lucru</li>
            //                 <ol>
            //                     <li>Analiză specificații tehnice și implementare soluții informatice;</li>
            //                     <li>Integrare servicii ale unor terți;</li>
            //                     <li>suport și consultanță prin email/ telefon.</li>
            //                 </ol>
            //     </ol>
            // ';
            // $html .= '<br />';

            // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);


            // $anexa = str_replace('<br>', '<br/>', $contracte->anexa);

            // $anexa = str_replace('class="ql-align-right ql-direction-rtl"', 'dir="rtl"', $anexa);

            // $anexa = str_replace('class', 'style', $anexa);

            // $anexa = str_replace('ql-size-small', 'font-size:10px;', $anexa);
            // $anexa = str_replace('ql-size-large', 'font-size:20px;', $anexa);
            // $anexa = str_replace('ql-size-huge', 'font-size:26px;', $anexa);

            // $anexa = str_replace('ql-align-justify', 'text-align:justify;', $anexa);
            // $anexa = str_replace('ql-align-center', 'text-align:center;', $anexa);
            // $anexa = str_replace('ql-align-right', 'text-align:right;', $anexa);

            // $anexa = str_replace('ql-indent-1', 'text-indent: 40px;', $anexa);
            // $anexa = str_replace('ql-indent-2', 'text-indent: 80px;', $anexa);
            // $anexa = str_replace('ql-indent-3', 'text-indent: 120px;', $anexa);
            // $anexa = str_replace('ql-indent-4', 'text-indent: 160px;', $anexa);
            // $anexa = str_replace('ql-indent-5', 'text-indent: 200px;', $anexa);

            // $anexa = str_replace('color: rgb(230, 0, 0);', 'color: #ff0000;', $anexa);
            // $anexa = str_replace('color: rgb(255, 153, 0);', 'color: #ff9900;', $anexa);
            // $anexa = str_replace('color: rgb(255, 255, 0);', 'color: #ffff00;', $anexa);
            // $anexa = str_replace('color: rgb(0, 138, 0);', 'color: #008a00;', $anexa);
            // $anexa = str_replace('color: rgb(0, 102, 204);', 'color: #0066cc;', $anexa);
            // $anexa = str_replace('color: rgb(153, 51, 255);', 'color: #9933ff;', $anexa);
            // $anexa = str_replace('color: rgb(255, 255, 255);', 'color: #ffffff;', $anexa);
            // $anexa = str_replace('color: rgb(250, 204, 204);', 'color: #facccc;', $anexa);
            // $anexa = str_replace('color: rgb(255, 235, 204);', 'color: #ffebcc;', $anexa);
            // $anexa = str_replace('color: rgb(255, 255, 204);', 'color: #ffffcc;', $anexa);
            // $anexa = str_replace('color: rgb(204, 232, 204);', 'color: #cce8cc;', $anexa);
            // $anexa = str_replace('color: rgb(204, 224, 245);', 'color: #cce0f5;', $anexa);
            // $anexa = str_replace('color: rgb(235, 214, 255);', 'color: #ebd6ff;', $anexa);
            // $anexa = str_replace('color: rgb(187, 187, 187);', 'color: #bbbbbb;', $anexa);
            // $anexa = str_replace('color: rgb(240, 102, 102);', 'color: #f06666;', $anexa);
            // $anexa = str_replace('color: rgb(255, 194, 102);', 'color: #ffc266;', $anexa);
            // $anexa = str_replace('color: rgb(255, 255, 102);', 'color: #ffff66;', $anexa);
            // $anexa = str_replace('color: rgb(102, 185, 102);', 'color: #66b966;', $anexa);
            // $anexa = str_replace('color: rgb(102, 163, 224);', 'color: #66a3e0;', $anexa);
            // $anexa = str_replace('color: rgb(194, 133, 255);', 'color: #c285ff;', $anexa);
            // $anexa = str_replace('color: rgb(136, 136, 136);', 'color: #888888;', $anexa);
            // $anexa = str_replace('color: rgb(161, 0, 0);', 'color: #a10000;', $anexa);
            // $anexa = str_replace('color: rgb(178, 107, 0);', 'color: #b26b00;', $anexa);
            // $anexa = str_replace('color: rgb(178, 178, 0);', 'color: #b2b200;', $anexa);
            // $anexa = str_replace('color: rgb(0, 97, 0);', 'color: #006100;', $anexa);
            // $anexa = str_replace('color: rgb(0, 71, 178);', 'color: #0047b2;', $anexa);
            // $anexa = str_replace('color: rgb(107, 36, 178);', 'color: #6b24b2;', $anexa);
            // $anexa = str_replace('color: rgb(68, 68, 68);', 'color: #444444;', $anexa);
            // $anexa = str_replace('color: rgb(92, 0, 0);', 'color: #5c0000;', $anexa);
            // $anexa = str_replace('color: rgb(102, 61, 0);', 'color: #663d00;', $anexa);
            // $anexa = str_replace('color: rgb(102, 102, 0);', 'color: #666600;', $anexa);
            // $anexa = str_replace('color: rgb(0, 55, 0);', 'color: #003700;', $anexa);
            // $anexa = str_replace('color: rgb(0, 41, 102);', 'color: #002966;', $anexa);
            // $anexa = str_replace('color: rgb(61, 20, 102);', 'color: #3d1466;', $anexa);

            // $anexa = str_replace('background-color: rgb(230, 0, 0);', 'background-color: #ff0000;', $anexa);
            // $anexa = str_replace('background-color: rgb(255, 153, 0);', 'background-color: #ff9900;', $anexa);
            // $anexa = str_replace('background-color: rgb(255, 255, 0);', 'background-color: #ffff00;', $anexa);
            // $anexa = str_replace('background-color: rgb(0, 138, 0);', 'background-color: #008a00;', $anexa);
            // $anexa = str_replace('background-color: rgb(0, 102, 204);', 'background-color: #0066cc;', $anexa);
            // $anexa = str_replace('background-color: rgb(153, 51, 255);', 'background-color: #9933ff;', $anexa);
            // $anexa = str_replace('background-color: rgb(255, 255, 255);', 'background-color: #ffffff;', $anexa);
            // $anexa = str_replace('background-color: rgb(250, 204, 204);', 'background-color: #facccc;', $anexa);
            // $anexa = str_replace('background-color: rgb(255, 235, 204);', 'background-color: #ffebcc;', $anexa);
            // $anexa = str_replace('background-color: rgb(255, 255, 204);', 'background-color: #ffffcc;', $anexa);
            // $anexa = str_replace('background-color: rgb(204, 232, 204);', 'background-color: #cce8cc;', $anexa);
            // $anexa = str_replace('background-color: rgb(204, 224, 245);', 'background-color: #cce0f5;', $anexa);
            // $anexa = str_replace('background-color: rgb(235, 214, 255);', 'background-color: #ebd6ff;', $anexa);
            // $anexa = str_replace('background-color: rgb(187, 187, 187);', 'background-color: #bbbbbb;', $anexa);
            // $anexa = str_replace('background-color: rgb(240, 102, 102);', 'background-color: #f06666;', $anexa);
            // $anexa = str_replace('background-color: rgb(255, 194, 102);', 'background-color: #ffc266;', $anexa);
            // $anexa = str_replace('background-color: rgb(255, 255, 102);', 'background-color: #ffff66;', $anexa);
            // $anexa = str_replace('background-color: rgb(102, 185, 102);', 'background-color: #66b966;', $anexa);
            // $anexa = str_replace('background-color: rgb(102, 163, 224);', 'background-color: #66a3e0;', $anexa);
            // $anexa = str_replace('background-color: rgb(194, 133, 255);', 'background-color: #c285ff;', $anexa);
            // $anexa = str_replace('background-color: rgb(136, 136, 136);', 'background-color: #888888;', $anexa);
            // $anexa = str_replace('background-color: rgb(161, 0, 0);', 'background-color: #a10000;', $anexa);
            // $anexa = str_replace('background-color: rgb(178, 107, 0);', 'background-color: #b26b00;', $anexa);
            // $anexa = str_replace('background-color: rgb(178, 178, 0);', 'background-color: #b2b200;', $anexa);
            // $anexa = str_replace('background-color: rgb(0, 97, 0);', 'background-color: #006100;', $anexa);
            // $anexa = str_replace('background-color: rgb(0, 71, 178);', 'background-color: #0047b2;', $anexa);
            // $anexa = str_replace('background-color: rgb(107, 36, 178);', 'background-color: #6b24b2;', $anexa);
            // $anexa = str_replace('background-color: rgb(68, 68, 68);', 'background-color: #444444;', $anexa);
            // $anexa = str_replace('background-color: rgb(92, 0, 0);', 'background-color: #5c0000;', $anexa);
            // $anexa = str_replace('background-color: rgb(102, 61, 0);', 'background-color: #663d00;', $anexa);
            // $anexa = str_replace('background-color: rgb(102, 102, 0);', 'background-color: #666600;', $anexa);
            // $anexa = str_replace('background-color: rgb(0, 55, 0);', 'background-color: #003700;', $anexa);
            // $anexa = str_replace('background-color: rgb(0, 41, 102);', 'background-color: #002966;', $anexa);
            // $anexa = str_replace('background-color: rgb(61, 20, 102);', 'background-color: #3d1466;', $anexa);

            // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $anexa, false, false);


            // $html = '<br /><br />';
            // $html .= '
            //         <table align="center" style="width: 100%">
            //             <tr>
            //                 <td style="width:50%" align="center"><b>Achizitor,</b>
            //                     <br/>' . $contracte->client->nume .
            //     '<br /><br />' . $contracte->client->reprezentant_functie .
            //     '<br />' . $contracte->client->reprezentant . '</td>                            
            //                 <td style="width:50%" align="center"><b>Prestator,</b>
            //                     <br/>Dima P. Valentin PFA
            //                     <br/>
            //                     <img src="images/semnatura si stampila.png" width="100"/></td>
            //             </tr>
            //         </table>
            //     ';

            // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);


            $footer = $section->addFooter();
            $footer->addPreserveText('Pagina {PAGE} din {NUMPAGES}', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            try {
                Storage::makeDirectory('fisiere_temporare');
                $objWriter->save(storage_path(
                    'app/fisiere_temporare/' .
                        'Fisa service nr. ' . $fise->nr_fisa .
                        ' din data de ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY') .
                        ' - ' . ($fise->client->nume ?? '') . '.docx'
                ));
            } catch (Exception $e) { }

            return response()->download(storage_path(
                'app/fisiere_temporare/' .
                    'Fisa service nr. ' . $fise->nr_fisa .
                    ' din data de ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY') .
                    ' - ' . ($fise->client->nume ?? '') . '.docx'
            ));

            // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
            // try {
            //     $objWriter->save(storage_path('Contract.html'));
            // } catch (Exception $e) { }

            // return response()->download(storage_path('Contract.html'));

        }
    }

}
