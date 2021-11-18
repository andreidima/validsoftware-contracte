<?php

namespace App\Http\Controllers;

use App\ServiceFisa;
use App\ServiceClient;
use App\ServicePartener;
use App\ServiceServiciu;
use App\ServiceServiciuCategorie;
use Illuminate\Http\Request;
use App\Mail\FisaIntrareService;
use App\Mail\FisaIesireService;
use App\Mail\EmailPersonalizat;
use App\Mail\EmailPartener;
use App\Mail\EmailPartenerInstiintareClient;

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
        $search_numar_intrare = \Request::get('search_numar_intrare');
        $search_nume = \Request::get('search_nume');
        $search_telefon = \Request::get('search_telefon');
        $search_cu_plata = \Request::get('search_cu_plata') ?? 1;
        // $search_cu_plata = ($search_cu_plata == '0') ? null : $search_cu_plata;
        $search_gratuit = \Request::get('search_gratuit') ?? 1;
        $search_in_lucru = \Request::get('search_in_lucru') ?? 1;
        $search_finalizate = \Request::get('search_finalizate') ?? 1;
        $search_service = \Request::get('search_service') ?? 1;
        $search_donatie = \Request::get('search_donatie') ?? 1;

            // dd($search_cu_plata);
        $service_fise = ServiceFisa::with('mesaje_trimise_fisa_iesire')
            ->leftJoin('service_clienti', 'service_fise.client_id', '=', 'service_clienti.id')
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
            ->when($search_numar_intrare, function ($query, $search_numar_intrare) {
                return $query->where('service_fise.nr_intrare', $search_numar_intrare);
            })
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('service_clienti.nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_telefon, function ($query, $search_telefon) {
                return $query->where('service_clienti.telefon', 'like', '%' . $search_telefon . '%');
            })
            // ->where(function ($query, $search_cu_plata, $search_gratuit, $search_donatie) {
            ->where(function ($query) use ($search_cu_plata, $search_gratuit) {
                if ($search_cu_plata == '1'){
                    if ($search_gratuit == '1'){
                        $query->where('service_fise.id', '>', 0); // se vor scoate toate inregistrarile
                    } else if ($search_gratuit == '0'){
                        $query->where('service_fise.cost', '<>', 0);
                    }
                } else if ($search_cu_plata == '0'){
                    if ($search_gratuit == '1'){
                        $query->where('cost', 0);
                    } else if ($search_gratuit == '0'){
                        $query->where('service_fise.id', '<', 0); // nu se va scoate nici o inregistrare
                    }
                }
                return $query;
            })
            ->where(function ($query) use ($search_in_lucru, $search_finalizate) {
                if ($search_in_lucru == '1'){
                    if ($search_finalizate == '1'){
                        $query->where('service_fise.id', '>', 0); // se vor scoate toate inregistrarile
                    } else if ($search_finalizate == '0'){
                        // $query->whereDoesntHave('mesaje_trimise_fisa_iesire')
                        //     ->whereDoesntHave('sms_trimise_fisa_iesire');
                        $query->where('service_fise.inchisa', 0);
                    }
                } else if ($search_in_lucru == '0'){
                    if ($search_finalizate == '1'){
                        // $query->whereHas('mesaje_trimise_fisa_iesire')
                        //     ->orwhereHas('sms_trimise_fisa_iesire');
                        $query->where('service_fise.inchisa', 1);
                    } else if ($search_finalizate == '0'){
                        $query->where('service_fise.id', '<', 0); // nu se va scoate nici o inregistrare
                    }
                }
                return $query;
            })
            ->where(function ($query) use ($search_service, $search_donatie) {
                if ($search_service == '1'){
                    if ($search_donatie == '1'){
                        $query->where('service_fise.id', '>', 0); // se vor scoate toate inregistrarile
                    } else if ($search_donatie == '0'){
                        $query->where('service_fise.donatie', 0);
                    }
                } else if ($search_service == '0'){
                    if ($search_donatie == '1'){
                        $query->where('service_fise.donatie', 1);
                    } else if ($search_donatie == '0'){
                        $query->where('service_fise.id', '<', 0); // nu se va scoate nici o inregistrare
                    }
                }
                return $query;
            })
            // ->when($search_in_lucru, function ($query) {
            //     return $query->whereDoesntHave('mesaje_trimise_fisa_iesire')
            //                 ->whereDoesntHave('sms_trimise_fisa_iesire');
            // })
            // ->where('service_fise.donatie', $search_donatie)
            // ->withCount(['mesaje_trimise_fisa_intrare', 'mesaje_trimise_fisa_iesire'])
            ->latest('service_fise.created_at')
            ->withCount('fisiere')
            ->simplePaginate(15);

        $service_fise_cu_plata = ServiceFisa::
            // whereDoesntHave('mesaje_trimise_fisa_iesire')
            // ->whereDoesntHave('sms_trimise_fisa_iesire')
            where('service_fise.inchisa', 0)
            ->where('cost', '<>', 0)
            ->count();

        $service_fise_gratuite = ServiceFisa::
            // whereDoesntHave('mesaje_trimise_fisa_iesire')
            // ->whereDoesntHave('sms_trimise_fisa_iesire')
            where('service_fise.inchisa', 0)
            ->where('cost', 0)
            ->count();

        return view('service.fise.index', compact('service_fise', 'search_numar_intrare',
            'search_nume', 'search_telefon', 'search_cu_plata', 'search_gratuit', 'search_in_lucru', 'search_finalizate', 'search_donatie', 'search_service',
            'service_fise_cu_plata', 'service_fise_gratuite'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clienti = ServiceClient::orderBy('nume')->get();
        $parteneri = ServicePartener::orderBy('nume')->get();
        $servicii = ServiceServiciu::orderBy('nume')->get();
        $categorii_servicii = ServiceServiciuCategorie::orderBy('nume')->get();

        $urmatorul_document_nr = \DB::table('variabile')->where('nume', 'nr_document')->first()->valoare;

        return view('service.fise.create', compact('clienti', 'parteneri', 'servicii', 'categorii_servicii', 'urmatorul_document_nr'));
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
            'Fișa de service pentru clientul "' . ($service_fisa->client->nume ?? '') . '", a fost adăugată cu succes!');
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
        $clienti = ServiceClient::orderBy('nume')->get();
        $parteneri = ServicePartener::orderBy('nume')->get();
        $servicii = ServiceServiciu::orderBy('nume')->get();
        $servicii_curente_selectate = $fise->servicii->pluck('id')->toArray();
        // dd($servicii_curente_selectate);
        $categorii_servicii = ServiceServiciuCategorie::orderBy('nume')->get();

        return view('service.fise.edit', compact('fise', 'clienti', 'parteneri', 'servicii', 'servicii_curente_selectate', 'categorii_servicii'));
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
        // dd($request);
        $client = ServiceClient::where('id', $request->client_deja_inregistrat)->first();
        if (isset($client)){
            $client->update($this->validateRequestClient($request));
        } else {
            $client = ServiceClient::make($this->validateRequestClient($request));
            $client->save();
        }

        $fise->update($this->validateRequestFisa($request, $fise));
        $fise->update(['client_id' => $client->id]);

        $fise->servicii()->sync($request->input('servicii_selectate'));

        return redirect($fise->path())->with('status',
            'Fișa de service pentru clientul "' . ($fise->client->nume ?? '') . '", a fost modificată cu succes!');
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
            'telefon' => ['nullable', 'numeric', 'digits:10'],
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
            'partener_id' => ['nullable'],
            'nr_intrare' => ['required', 'numeric'],
            'nr_iesire' => ['required', 'numeric'],
            'tehnician_service' => ['max:90'],
            'data_receptie' => [''],
            'consultanta_it' => [''],
            'instalare_anydesk' => [''],
            'descriere_echipament' => [''],
            'defect_reclamat' => [''],
            'defect_constatat' => [''],
            'rezultat_service' => [''],
            // 'link_qr' => ['nullable', 'max:1000'],
            // 'link_qr_descriere' => ['nullable', 'max:1000'],
            'observatii' => [''],
            'data_ridicare' => [''],
            'durata_interventie' => [''],
            'cost' => [''],
            'donatie' => [''],
            'casare' => [''],
            'observatii_interne' => [''],
        ]);
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function trimiteEmail(Request $request, ServiceFisa $fisa)
    {
        // Verificare daca exista email CLIENT corect catre care sa se trimita mesajul.
        // In cazul in care se trimite email catre partener, emailul catre client nu este obligatoriu
        if ($request->tip_fisa !== 'email-partener-si-client') {
                $validator = Validator::make($fisa->client->toArray(), [
                    'email' => ['email:rfc,dns']
                ]);

                if ($validator->fails()) {
                    return back()
                                ->withErrors($validator)
                                ->withInput();
                }
        } else{
            if(isset($fisa->client->email)){
                $validator = Validator::make($fisa->client->toArray(), [
                    'email' => ['email:rfc,dns']
                ]);

                if ($validator->fails()) {
                    return back()
                                ->withErrors($validator)
                                ->withInput();
                }
            }

                // Verificare daca emailul partenerului este corect
                $validator = Validator::make($fisa->partener->toArray(), [
                    'email' => ['email:rfc,dns']
                ]);
                if ($validator->fails()) {
                    return back()
                        // ->withErrors($validator)
                        ->withErrors('Emailul Partenerului nu este o adresă de e-mail validă.')
                        ->withInput();
                }
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
            // Daca este Email pentru Fisa iesire service, se inchide automat si Fisa service
            $fisa->update(['inchisa'=>1]);

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
        } elseif ($request->tip_fisa === 'email-partener-si-client') {
            //Trimitere email catre partener si salvarea actiunii in baza de date
            \Mail::mailer('service')
                ->to($fisa->partener->email)
                ->bcc($emailuri_bcc)
                ->send(
                    new EmailPartener($fisa)
                );
            $mesaj_trimis = new \App\MesajTrimis;
            $mesaj_trimis->inregistrare_id = $fisa->id;
            $mesaj_trimis->categorie = 'Fise';
            $mesaj_trimis->subcategorie = 'Partener';
            $mesaj_trimis->save();

            //Trimitere email catre client si salvarea actiunii in baza de date
            if(isset($fisa->client->email)){
                \Mail::mailer('service')
                    ->to($fisa->client->email)
                    ->bcc($emailuri_bcc)
                    ->send(
                        new EmailPartenerInstiintareClient($fisa)
                    );
                $mesaj_trimis = new \App\MesajTrimis;
                $mesaj_trimis->inregistrare_id = $fisa->id;
                $mesaj_trimis->categorie = 'Fise';
                $mesaj_trimis->subcategorie = 'PartenerClient';
                $mesaj_trimis->save();
            }

            return back()->with('status', 'Emailurile către client (' . $fisa->client->email . ') și către partener (' . $fisa->partener->email . ') au fost trimise cu succes!');
        }

    }

    /**
     * Buton de deschidere sau inchidere fisa
     */
    protected function DeschideInchide(Request $request, ServiceFisa $fise)
    {
        if ($fise->inchisa === 1){
            $fise->inchisa = 0;
            $fise->update();
            return back()->with('status', 'Fișa de service pentru clientul „' . ($fise->client->nume ?? '') . '”, a fost deschisă cu succes!');
        } else {
            $fise->inchisa = 1;
            $fise->update();
            return back()->with('status', 'Fișa de service pentru clientul „' . ($fise->client->nume ?? '') . '”, a fost închisă cu succes!');
        }
    }

    /**
     *
     */
    protected function pdfExport(Request $request, ServiceFisa $fise)
    {
        $fisa = $fise;
        if ($request->view_type === 'fisa-pdf-intrare') {
            $pdf = \PDF::loadView('service.fise.export.fisa-intrare-service-pdf', compact('fisa'))
                ->setPaper('a4', 'portrait');
            if ($fisa->consultanta_it === 1) {
                return $pdf->download('Fisa intrare consultanta nr. ' . $fisa->nr_intrare . '.pdf');
            } else {
                return $pdf->download('Fisa intrare service nr. ' . $fisa->nr_intrare . '.pdf');
            }
        }elseif ($request->view_type === 'fisa-html-iesire') {
            return view('service.fise.export.fisa-iesire-service-pdf', compact('fisa'));
        }elseif ($request->view_type === 'fisa-pdf-iesire') {
            $pdf = \PDF::loadView('service.fise.export.fisa-iesire-service-pdf', compact('fisa'))
                ->setPaper('a4', 'portrait');
            if ($fisa->consultanta_it === 1) {
                return $pdf->download('Fisa iesire consultanta nr. ' . $fisa->nr_intrare . '.pdf');
            } else {
                return $pdf->download('Fisa iesire service nr. ' . $fisa->nr_intrare . '.pdf');
            }
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
                    'headerHeight' => 2700,
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

            if ($fise->consultanta_it === 1){
                $html .= '<p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE INTRARE CONSULTANȚĂ IT</p>';
            }
            else {
                $html .= '<p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE INTRARE ÎN SERVICE</p>';
            }

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
                '.</p>';
            $html .= '<br />';

            $html .= '<p style="text-align:left; font-weight: bold;">Descriere echipament</p>
                    <p style="text-align:justify;">' .
                        $fise->descriere_echipament .
                    '</p>
                    <br />

                    <p style="text-align:left; font-weight: bold;">Serviciu solicitat sau defect reclamat</p>
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
                        (($fise->consultanta_it === 1) ? 'Fisa de intrare consultanta nr. ' : 'Fisa service de intrare nr. ') . $fise->nr_intrare .
                        ' din data de ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY') .
                        ' - ' . ($fise->client->nume ?? '') . '.docx'
                ));
            } catch (Exception $e) { }

            return response()->download(storage_path(
                'app/fisiere_temporare/' .
                    (($fise->consultanta_it === 1) ? 'Fisa de intrare consultanta nr. ' : 'Fisa service de intrare nr. ') . $fise->nr_intrare .
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
                    'headerHeight' => 2700,
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

            if ($fise->consultanta_it === 1) {
                $html .= '<p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE IEȘIRE CONSULTANȚĂ IT</p>';
            } else {
                $html .= '<p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE IEȘIRE DIN SERVICE</p>';
            }

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
                '.</p>';
            $html .= '<br />';

            $html .= '<p style="text-align:left; font-weight: bold;">Descriere echipament</p>
                    <p style="text-align:justify;">' .
                        $fise->descriere_echipament .
                    '</p>
                    <br />

                    <p style="text-align:left; font-weight: bold;">Serviciu solicitat sau defect reclamat</p>
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

            if (count($fise->servicii)){
                $html .='<ul><b>Servicii efectuate:</b>';
                foreach ($fise->servicii->sortBy('nr_de_ordine') as $serviciu) {
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

                $html .= '<br />';
            }

            if ($fise->instalare_anydesk === 1) {
                $html .='
                    <p style="text-align:left; font-weight: bold;">Important</p>
                    <p style="text-align:justify;">Pentru suport tehnic de la distanță am instalat și aplicația AnyDesk. În cazul în care întâmpinați probleme în utilizarea calculatorului, vă rugăm să ne contactați la service@validsoftware.ro sau 0785 709 027.</p>
                    <br />
                    ';
            }

            if ($fise->observatii) {
                $html .='
                    <p style="text-align:left; font-weight: bold;">Observatii</p>
                    <p style="text-align:justify;">' .
                        $fise->observatii .
                    '</p>
                    <br />
                    ';
            }

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
                        (($fise->consultanta_it === 1) ? 'Fisa de iesire consultanta nr. ' : 'Fisa service de iesire nr. ') . $fise->nr_iesire .
                        ' din data de ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY') .
                        ' - ' . ($fise->client->nume ?? '') . '.docx'
                ));
            } catch (Exception $e) { }

            return response()->download(storage_path(
                'app/fisiere_temporare/' .
                    (($fise->consultanta_it === 1) ? 'Fisa de iesire consultanta nr. ' : 'Fisa service de iesire nr. ') . $fise->nr_iesire .
                    ' din data de ' . \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY') .
                    ' - ' . ($fise->client->nume ?? '') . '.docx'
            ));
        }
    }

}
