<?php

namespace App\Http\Controllers;

use App\ServiceFisa;
use App\ServiceClient;
use App\ServiceServiciu;
use Illuminate\Http\Request;
use App\Mail\FisaIntrareService;
use App\Mail\FisaIesireService;
use App\Mail\EmailPersonalizat;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
            // ->withCount(['mesaje_trimise_fisa_intrare', 'mesaje_trimise_fisa_iesire'])
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

        $servicii = ServiceServiciu::
            orderBy('nume')
            ->get();

        $urmatorul_document_nr = \DB::table('variabile')->where('nume', 'nr_document')->first()->valoare;

        return view('service.fise.create', compact('clienti', 'servicii',  'urmatorul_document_nr'));
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
        
        $service_fisa->servicii()->attach($request->input('servicii_selectate'));
        
        // Dubla Incrementare nr_document
        \App\Variabila::Nr_document();
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

        $servicii = ServiceServiciu::
            orderBy('nume')
            ->get();

        return view('service.fise.edit', compact('fise', 'clienti', 'servicii'));
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
        
        $fise->servicii()->sync($request->input('servicii_selectate'));

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
            'telefon' => ['numeric', 'digits:10'],
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
            'nr_intrare' => ['required', 'numeric'],
            'nr_iesire' => ['required', 'numeric'],
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

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function trimiteEmail(Request $request, ServiceFisa $fisa)
    {   
        // Verificare daca exista email corect catre care sa se trimita mesajul
        $validator = Validator::make($fisa->client->toArray(), [
            'email' => ['email:rfc,dns']
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

        // Trimiterea mesajului
        if ($request->tip_fisa === 'fisa-intrare'){
            \Mail::mailer('service')
                ->to($fisa->client->email)                       
                ->bcc($emailuri_bcc)
                ->send(
                    new FisaIntrareService($fisa)
                );              
            $mesaj_trimis = new \App\MesajTrimis;
            $mesaj_trimis->inregistrare_id = $fisa->id;
            $mesaj_trimis->categorie = 'Fise';
            $mesaj_trimis->subcategorie = 'Intrare';
            $mesaj_trimis->save();
            return back()->with('status', 'Emailul cu „Fișa de intrare nr. ' . $fisa->nr_intrare . '” a fost trimis către „' . $fisa->client->email . '” cu succes!');
        } elseif ($request->tip_fisa === 'fisa-iesire'){
            \Mail::mailer('service')
                ->to($fisa->client->email)                       
                ->bcc($emailuri_bcc)
                ->send(
                    new FisaIesireService($fisa)
                ); 
            $mesaj_trimis = new \App\MesajTrimis;
            $mesaj_trimis->inregistrare_id = $fisa->id;
            $mesaj_trimis->categorie = 'Fise';
            $mesaj_trimis->subcategorie = 'Iesire';
            $mesaj_trimis->save();       
            return back()->with('status', 'Emailul cu „Fișa de ieșire nr. ' . $fisa->nr_iesire . '” a fost trimis către „' . $fisa->client->email . '” cu succes!');
        } elseif ($request->tip_fisa === 'email-personalizat') {
            $email_text = $request->email_personalizat;
            \Mail::mailer('service')
                ->to($fisa->client->email)
                ->bcc($emailuri_bcc)
                ->send(
                    new EmailPersonalizat($fisa, $email_text)
                );
            $mesaj_trimis = new \App\MesajTrimis;
            $mesaj_trimis->inregistrare_id = $fisa->id;
            $mesaj_trimis->categorie = 'Fise';
            $mesaj_trimis->subcategorie = 'Personalizat';
            $mesaj_trimis->text = $email_text;
            $mesaj_trimis->save();
            return back()->with('status', 'Emailul personalizat a fost trimis către „' . $fisa->client->email . '” cu succes!');
        }

    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function pdfExport(Request $request, ServiceFisa $fise)
    {   
        $fisa = $fise;
        if ($request->view_type === 'fisa-pdf-intrare') {
            $pdf = \PDF::loadView('service.fise.export.fisa-intrare-service-pdf', compact('fisa'))
                ->setPaper('a4', 'portrait');
                return $pdf->download('Fisa intrare service nr. ' . $fisa->nr_intrare . '.pdf');        
        }elseif ($request->view_type === 'fisa-pdf-iesire') {
            $pdf = \PDF::loadView('service.fise.export.fisa-iesire-service-pdf', compact('fisa'))
                ->setPaper('a4', 'portrait');
                return $pdf->download('Fisa iesire service nr. ' . $fisa->nr_iesire . '.pdf');
        }
    }

    public function wordExport(Request $request, ServiceFisa $fise)
    {
        if ($request->view_type === 'fisa-html') {
            //render html
        } elseif ($request->view_type === 'fisa-word-intrare') {
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

            $html = '<br />';
            $html .= '<p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE INTRARE IN SERVICE</p>';
            $html .= '<p style="text-align: center; font-weight: bold;">Nr. ' . $fise->nr_intrare . (isset($fise->data_receptie) ? (' din ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY')) : '') .
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
                    ';

            $html .= '<br /><br />';
            // $html .= '
            //         <table align="center" style="width: 100%">
            //             <tr>
            //                 <td style="width:50%" align="center"><b>Beneficiar,</b>
            //                     <br/>' . $fise->client->nume .
            //                     '<br /><br />' . $fise->client->reprezentant_functie .
            //                     '<br />' . $fise->client->reprezentant . '</td>                            
            //                 <td style="width:30%" align="center"><b>Prestator,</b>
            //                     <br/>Dima P. Valentin PFA
            //                     <br/>
            //                     <br/>
            //                     <b>Tehnician service</b>
            //                     <br/>' .
            //                     $fise->tehnician_service .
            //                     '
            //                     <br/>
            //                     <img src="images/semnatura si stampila.png" width="100"/>
            //                 </td>
            //             </tr>
            //         </table>
            //     ';

            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

            $table = $section->addTable();
            $table->addRow(null, array('tblHeader' => true, 'cantSplit' => true));
            $cell = $table->addCell(10000);
            $html = '
                    <table align="center" style="width: 100%">
                        <tr style="page-break-inside: avoid;">
                            <td style="width:50%; page-break-inside: avoid;" align="center"><b>Beneficiar,</b>
                                <br/>' . $fise->client->nume .
                                '<br /><br />' . $fise->client->reprezentant_functie .
                                '<br />' . $fise->client->reprezentant . '</td>                            
                            <td style="width:30%; page-break-inside: avoid;" align="center"><b>Prestator,</b>
                                <br/>Validsoftware - Servicii Informatice
                            </td>
                        </tr>
                    </table>
                ';  
            \PhpOffice\PhpWord\Shared\Html::addHtml($cell, $html, false, false);


            $footer = $section->addFooter();
            $footer->addPreserveText('Pagina {PAGE} din {NUMPAGES}', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            try {
                Storage::makeDirectory('fisiere_temporare');
                $objWriter->save(storage_path(
                    'app/fisiere_temporare/' .
                        'Fisa service de intrare nr. ' . $fise->nr_intrare .
                        ' din data de ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY') .
                        ' - ' . ($fise->client->nume ?? '') . '.docx'
                ));
            } catch (Exception $e) { }

            return response()->download(storage_path(
                'app/fisiere_temporare/' .
                    'Fisa service de intrare nr. ' . $fise->nr_intrare .
                    ' din data de ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY') .
                    ' - ' . ($fise->client->nume ?? '') . '.docx'
            ));

        } elseif ($request->view_type === 'fisa-word-iesire') {
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

            $html = '<br />';
            $html .= '<p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE IEȘIRE DIN SERVICE</p>';
            $html .= '<p style="text-align: center; font-weight: bold;">Nr. ' . $fise->nr_iesire . (isset($fise->data_receptie) ? (' din ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY')) : '') .
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
                    <br />';  


                $html .='<ul><b>Servicii efectuate:</b>';
                foreach ($fise->servicii as $serviciu) {
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

                    
                $html .= '<br />

                    <p style="text-align:left; font-weight: bold;">Observatii</p>
                    <p style="text-align:justify;">' .
                        $fise->observatii .
                    '</p>
                    <br />                    
                    ';

            $html .= '<br /><br />';
            // $html .= '
            //         <table align="center" style="width: 100%">
            //             <tr style="page-break-inside: avoid;">
            //                 <td style="width:50%; page-break-inside: avoid;" align="center"><b>Beneficiar,</b>
            //                     <br/>' . $fise->client->nume .
            //                     '<br /><br />' . $fise->client->reprezentant_functie .
            //                     '<br />' . $fise->client->reprezentant . 'dd</td>                            
            //                 <td style="width:30%; page-break-inside: avoid;" align="center"><b>Prestator,</b>
            //                     <br/>Dima P. Valentin PFA
            //                     <br/>
            //                     <br/>
            //                     <b>Tehnician service</b>
            //                     <br/>' .
            //                     $fise->tehnician_service .
            //                     '
            //                     <br/>
            //                     <img src="images/semnatura si stampila.png" width="100"/>
            //                 </td>
            //             </tr>
            //         </table>
            //     ';            

            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

            $table = $section->addTable();
            $table->addRow(null, array('tblHeader' => true, 'cantSplit' => true));
            $cell = $table->addCell(10000);
            $html = '
                    <table align="center" style="width: 100%">
                        <tr style="page-break-inside: avoid;">
                            <td style="width:50%; page-break-inside: avoid;" align="center"><b>Beneficiar,</b>
                                <br/>' . $fise->client->nume .
                                '<br /><br />' . $fise->client->reprezentant_functie .
                                '<br />' . $fise->client->reprezentant . '</td>                            
                            <td style="width:30%; page-break-inside: avoid;" align="center"><b>Prestator,</b>
                                <br/>Validsoftware - Servicii Informatice
                            </td>
                        </tr>
                    </table>
                ';  
            \PhpOffice\PhpWord\Shared\Html::addHtml($cell, $html, false, false);


            $footer = $section->addFooter();
            $footer->addPreserveText('Pagina {PAGE} din {NUMPAGES}', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            try {
                Storage::makeDirectory('fisiere_temporare');
                $objWriter->save(storage_path(
                    'app/fisiere_temporare/' .
                        'Fisa service de iesire nr. ' . $fise->nr_iesire .
                        ' din data de ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY') .
                        ' - ' . ($fise->client->nume ?? '') . '.docx'
                ));
            } catch (Exception $e) { }

            return response()->download(storage_path(
                'app/fisiere_temporare/' .
                    'Fisa service de iesire nr. ' . $fise->nr_iesire .
                    ' din data de ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY') .
                    ' - ' . ($fise->client->nume ?? '') . '.docx'
            ));
        }
    }

}
