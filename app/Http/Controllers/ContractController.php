<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Firma;
use App\Client;
use App\Fisier;

use DB;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        // $contracte = Client::when($search_nume, function ($query, $search_nume) {
        //         return $query->where('nume', 'like', '%' . $search_nume . '%');
        //     })
        //     ->latest()
        //     ->Paginate(25);
        // return view('contracte.index', compact('contracte', 'search_nume'));

        $contracte = Contract::with('client', 'fisiere')
            ->whereHas('client', function ($query) use($search_nume){
                $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
            })
            ->latest()
            ->withCount('fisiere')
            ->Paginate(25);

        // $contracte = DB::table('contracte')
        //     ->leftJoin('clienti', 'contracte.client_id', '=', 'clienti.id')
        //     ->rightJoin('fisiere', 'contracte.id', '=', 'fisiere.contract_id')
        //     ->select(DB::raw('
        //                 contracte.*,
        //                 clienti.nume as client_nume
        //         '))
        //     ->Paginate(25);
        // dd($contracte);

        return view('contracte.index', compact('contracte', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $firme = Firma::select('id', 'nume')->orderBy('nume')->get();
        $clienti = Client::select('id', 'nume')->orderBy('nume')->get();

        $urmatorul_contract_nr = \DB::table('variabile')->where('nume', 'nr_document')->first()->valoare;

        return view('contracte.create', compact('firme', 'clienti', 'urmatorul_contract_nr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \App\Variabila::Nr_document();
        $contract = Contract::create($this->validateRequest($request));

        return redirect($contract->path())->with('status',
            'Contractul Nr."' . $contract->contract_nr . '", pentru clientul "' . ($contract->client->nume ?? '') . '", a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contracte)
    {
        return view('contracte.show', compact('contracte'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contracte)
    {
        $firme = Firma::select('id', 'nume')->orderBy('nume')->get();
        $clienti = Client::select('id', 'nume')->orderBy('nume')->get();

        return view('contracte.edit', compact('firme', 'contracte', 'clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contracte)
    {
        $this->validateRequest($request, $contracte);
        $contracte->update($request->except(['date']));

        return redirect($contracte->path())->with('status',
            'Contractul Nr."' . $contracte->contract_nr . '", pentru clientul "' . ($contracte->client->nume ?? '') . '", a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contracte)
    {
        if ($contracte->fisiere()->exists()){
            return back()->with('error', 'Contractul are fișiere atașate. Pentru a putea șterge contractul nr. "' . $contracte->contract_nr . '", ștergeți mai întâi fișierele atașate acestuia.');
        }else{
            $contracte->delete();
            return redirect('/contracte')->with('status',
                'Contractul Nr."' . $contracte->contract_nr . '", pentru clientul "' . ($contracte->client->nume ?? '') . '", a fost șters cu succes!');
        }

    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'firma_id' => ['required'],
            'client_id' => ['required'],
            'contract_nr' => ['required', 'numeric'],
            'contract_data' => [''],
            'data_incepere' => [''],
            'abonament_lunar' => [''],
            'pret' => ['nullable', 'numeric', 'max:99999'],
            'anexa' => ['']
        ]);
    }

    public function wordExport(Request $request, Contract $contracte)
    {
        if ($request->view_type === 'contract-html') {
            // return back();
        } elseif ($request->view_type === 'contract-word') {
            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true); // pentru gestionare caracterelor speciale, altfel da eroare, gen la „&”

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
                    'headerHeight' => 3100,
                    'footerHeight' => 0,
                )
            );

            $header = $section->addHeader();
            // $section->setHeaderHeight(500);
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
                    // 'marginBottom'     => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(20),
                )
            );

            // $section->
            //     addText('CONTRACT DE FURNIZARE SERVICII INFORMATICE',
            //         array('size' => 14, 'bold' => true),
            //         array('align' => 'center')
            //     );
            // $section->
            //     addText('Nr. '. $contracte->contract_nr .
            //         (isset($contracte->contract_data) ?
            //             (' din ' . \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('D.MM.YYYY')) : ''),
            //         array('bold' => true),
            //         array('align' => 'center')
            //     );
            // $section->addTextBreak(1);
            // $section->addText(
            //     'Prezentul contract intră în vigoare începând cu data de ' .
            //     (isset($contracte->data_incepere) ? (\Carbon\Carbon::parse($contracte->data_incepere)->isoFormat('D.MM.YYYY')) : '..........') .
            //     ' între ' . $contracte->client->nume .
            //     ', cu sediul în ' . $contracte->client->adresa .
            //     ', Cod Unic de Înregistrare CUI ' . $contracte->client->cui .
            //     ', reprezentată de ' . $contracte->client->reprezentant .
            //     ', având funcţia de ' . $contracte->client->reprezentant_functie .
            //     ' și'
            //     );

            // $textrun = $section->addTextRun();
            // $textrun->addText('Dima P. Valentin P.F.A.', array('bold' => true));
            // $textrun->addText(', Nr. Reg. Comerțului F39/811/28.05.2012, CIF 30249594, cont IBAN RO 52BTRL RONC RT02 8243 7501, deschis la Banca Transilvania.');

            // $section->addTextBreak(1);

            // $predefinedMultilevelStyle = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER_NESTED);
            // $section->addListItem('Termeni generali', 0, array('bold' => true), $predefinedMultilevelStyle);
            // $section->addListItem('Termeni generali', 0, array('bold' => true), $predefinedMultilevelStyle);
            // $listItemRun = $section->addListItemRun(1, $predefinedMultilevelStyle);
            // $listItemRun->addListItem('Contractul se referă la prestarea de servicii informatice de către', 1, null, $predefinedMultilevelStyle);

            // $section = $phpWord->addSection();

            $html = '<p style="text-align: center; font-weight: bold; font-size: 21px;">CONTRACT DE FURNIZARE SERVICII INFORMATICE</p>';
            $html .= '<p style="text-align: center; font-weight: bold;">Nr. ' . $contracte->contract_nr .
                (isset($contracte->contract_data) ? (' din ' . \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('DD.MM.YYYY')) : '') .
                '</p>';
            $html .= '<br />';
            $html .= '<p style="text-align:justify;">' .
                'Prezentul contract intră în vigoare începând cu data de ' .
                (isset($contracte->data_incepere) ? (\Carbon\Carbon::parse($contracte->data_incepere)->isoFormat('DD.MM.YYYY')) : '..........') .
                ' între <b>' . $contracte->client->nume . '</b>' .
                ', cu sediul în ' . $contracte->client->adresa .
                ', Cod Unic de Înregistrare CUI ' . $contracte->client->cui .
                ', reprezentată de ' . $contracte->client->reprezentant .
                ', având funcţia de ' . $contracte->client->reprezentant_functie .
                ' și' .
                '</p><p>' .
                '<b>' . ($contracte->firma->nume ?? '') .  '</b>' .
                ', Nr. Reg. Comerțului ' . ($contracte->firma->nr_reg_com ?? '') .
                ', CIF ' . ($contracte->firma->cif ?? '') .
                ', cont IBAN ' . ($contracte->firma->cont_iban ?? '') .
                ', deschis la ' . ($contracte->firma->cont_deschis_la ?? '') .
                '.</p>';
            $html .= '<br />';
            $html .= '<ol>
                        <li><p style="font-weight: bold;">Termeni generali</p></li>
                            <ol>
                                <li>Contractul se referă la prestarea de servicii informatice de către <b>' . ($contracte->firma->nume ?? '') . '</b> în beneficiul <b>'. $contracte->client->nume . '</b>.</li>
                                <li>Contractul este valabil până la terminarea sa în conformitate cu condiţiile incluse mai jos în prezentul document.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Relaţie contractuală</p></li>
                            <ol>
                                <li><b>' . ($contracte->firma->nume ?? '') . '</b> va desfăşura activităţile aferente prezentului contract la sediul <b>' . $contracte->client->nume . '</b> sau la sediul propriu.</li>
                                <li><b></b> nu are autoritatea de a-şi asuma responsabilităţi sau obligaţii în locul <b>' . $contracte->client->nume . '</b> şi nu poate reprezenta <b>' . $contracte->client->nume . '</b> în nici un fel de situaţii.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Relaţie contractuală</p></li>
                            <ol>
                                <li>Serviciile pe care <b></b> se angajează să le efectueze în beneficiul <b>' . $contracte->client->nume . '</b> sunt specificate în “Planul de lucru – Anexa”, dar nu se limitează numai la acestea.</li>
                                <li><b>' . $contracte->client->nume . '</b> şi <b>' . ($contracte->firma->nume ?? '') . '</b> vor cădea de acord asupra serviciilor suplimentare care trebuie efectuate sau asupra celor care nu mai sunt necesare.</li>
                                <li>Calitatea serviciilor furnizate de <b>' . ($contracte->firma->nume ?? '') . '</b> va fi conformă cu cerinţele  <b>' . $contracte->client->nume . '</b>.</li>
                                <li><b>' . ($contracte->firma->nume ?? '') . '</b> are obligaţia de a livra produsele şi de a presta serviciile prevăzute în contract cu profesionalismul şi promptitudinea cuvenite angajamentului asumat şi în conformitate cu propunerea sa tehnică.</li>
                                <li><b>' . ($contracte->firma->nume ?? '') . '</b> este pe deplin responsabil pentru prestarea serviciilor în conformitate cu graficul de prestare convenit şi de siguranţa tuturor operaţiunilor şi metodelor de prestare utilizate pe toată durata contractului. </li>';

                    if (($contracte->abonament_lunar === 1) && ($contracte->pret != null)){
                        $html .= '<li><b>' . ($contracte->firma->nume ?? '') . '</b> va emite lunar o factură, în valoare de ' . $contracte->pret . ' RON (TVA 0), pentru serviciile prestate. </li>';
                    }

                $html .= '</ol>
                            <br/>
                        <li><p style="font-weight: bold;">Responsabilităţile <b>' . $contracte->client->nume . '</b></p></li>
                            <ol>
                                <li><b>' . $contracte->client->nume . '</b> are obligaţia de a pune la dispoziţia <b>' . ($contracte->firma->nume ?? '') . '</b> toate informaţiile pe care <b>' . ($contracte->firma->nume ?? '') . '</b> le consideră necesare în mod rezonabil pentru îndeplinirea contractului.</li>
                                <li><b>' . $contracte->client->nume . '</b> are obligaţia de a efectua plata către <b>' . ($contracte->firma->nume ?? '') . '</b> în termen de 30 zile de la emiterea facturii de către acesta.</li>
                                <li>În cazul în care <b>' . $contracte->client->nume . '</b> nu onorează facturile în termen de 30 zile de la expirarea perioadei prevăzute la clauza 4.b, <b>' . ($contracte->firma->nume ?? '') . '</b> are dreptul de a sista prestarea serviciilor sau de a diminua ritmul prestării. Imediat ce <b>' . $contracte->client->nume . '</b> onorează factura, <b>' . ($contracte->firma->nume ?? '') . '</b> va relua prestarea serviciilor în cel mai scurt timp posibil.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Recepţie şi verificări</p></li>
                            <ol>
                                <li><b>' . $contracte->client->nume . '</b> are dreptul de a verifica modul de prestare şi calitatea serviciilor.</li>';

                    if ($contracte->abonament_lunar === 1){
                        $html .= '<li><b>Dima P. Valentin</b> va genera lunar un raport de activitate, care va fi inaintat beneficiarului. </li>';
                    }

                $html .= '</ol>
                            <br/>
                        <li><p style="font-weight: bold;">Forţa majoră</p></li>
                            <ol>
                                <li>Forţa majoră este constatată de o autoritate competentă.</li>
                                <li>Forţa majoră exonerează părţile contractante de îndeplinirea obligaţiilor asumate prin prezentul contract, pe toată perioada în care aceasta acţionează.</li>
                                <li>Îndeplinirea contractului va fi suspendată în perioada de acţiune a forţei majore, dar fără a prejudicia drepturile ce li se cuveneau părţilor până la apariţia acesteia.</li>
                                <li>Partea contractantă care invocă forţa majoră are obligaţia de a notifica celeilalte părţi, imediat şi în mod complet, producerea acesteia şi de a lua orice măsuri care îi stau la dispoziţie în vederea limitării consecinţelor.</li>
                                <li>Dacă forţa majoră acţionează sau se estimează că va acţiona o perioadă mai mare de 6 luni, fiecare parte va avea dreptul să notifice celeilalte părţi încetarea de plin drept a prezentului contract, fără ca vreuna dintre părţi să poată pretinde celeilalte daune-interese.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Soluţionarea litigiilor</p></li>
                            <ol>
                                <li><b>' . $contracte->client->nume . '</b> şi <b>' . ($contracte->firma->nume ?? '') . '</b> vor face toate eforturile pentru a rezolva pe cale amiabilă, prin tratative directe, orice neînţelegere sau dispută care se poate ivi între ei în cadrul sau în legătură cu îndeplinirea contractului, conform procedurii concilierii directe reglementată de Codul de Procedură Civilă.</li>
                                <li>Dacă după 15 zile de la începerea acestor tratative <b>' . $contracte->client->nume . '</b> şi <b>' . ($contracte->firma->nume ?? '') . '</b> nu reuşesc să rezolve în mod amiabil o divergenţă contractuală, fiecare parte poate solicita ca disputa să se soluționeze de către instanțele judecătorești.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Modificări</p></li>
                            <ol>
                                <li>Orice modificare a prezentului contract trebuie să fie făcută în scris, sub formă de act adiţional.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Legea aplicabilă contractului</p></li>
                            <ol>
                                <li>Contractul va fi interpretat conform legilor din România.</li>
                            </ol>
                    </ol>
                ';
            $html .= '<br /><br />';
            $html .= '
                    <table align="center" style="width: 100%">
                        <tr>
                            <td style="width:50%" align="center"><b>Achizitor,</b>
                                <br/>' . $contracte->client->nume .
                                '<br /><br />' . $contracte->client->reprezentant_functie .
                                '<br />' . $contracte->client->reprezentant . '</td>
                            <td style="width:50%" align="center"><b>Prestator,</b>
                                <br/>' . ($contracte->firma->nume ?? '') . '
                                <br/>
                                <img src="images/semnatura_stampila.jpg" width="100"/></td>
                        </tr>
                    </table>
                ';


            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
            // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, true);

            $section->addPageBreak();

            $html = '<p style="text-align: center; font-weight: bold; font-size: 21px;">Plan de lucru</p>
                    <br />
                    <p style="font-weight: bold;">Anexa nr. 01 ' .
                        (isset($contracte->contract_data) ? (' din ' . \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('D.MM.YYYY')) : '') .
                        ' la CONTRACTUL DE PRESTARE DE SERVICII INFORMATICE Nr. ' .
                        $contracte->contract_nr .
                        (isset($contracte->contract_data) ? (' din ' . \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('D.MM.YYYY')) : '') .
                    '</p>
                    <br /><br />
                <ol>
                        <li><b>Durata</b>: prezentul Plan de lucru acoperă toată perioada de valabilitate a prezentului contract.</li>
                        <li>Următoarele servicii vor fi acoperite de Planul de lucru</li>
                            <ol>
                                <li>Analiză specificații tehnice și implementare soluții informatice;</li>
                                <li>Integrare servicii ale unor terți;</li>
                                <li>suport și consultanță prin email/ telefon.</li>
                            </ol>
                </ol>
            ';
            $html .= '<br />';

            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);


            $anexa = str_replace('<br>', '<br/>', $contracte->anexa);

            $anexa = str_replace('class="ql-align-right ql-direction-rtl"', 'dir="rtl"', $anexa);

            $anexa = str_replace('class', 'style', $anexa);

            $anexa = str_replace('ql-size-small', 'font-size:10px;', $anexa);
            $anexa = str_replace('ql-size-large', 'font-size:20px;', $anexa);
            $anexa = str_replace('ql-size-huge', 'font-size:26px;', $anexa);

            $anexa = str_replace('ql-align-justify', 'text-align:justify;', $anexa);
            $anexa = str_replace('ql-align-center', 'text-align:center;', $anexa);
            $anexa = str_replace('ql-align-right', 'text-align:right;', $anexa);

            $anexa = str_replace('ql-indent-1', 'text-indent: 40px;', $anexa);
            $anexa = str_replace('ql-indent-2', 'text-indent: 80px;', $anexa);
            $anexa = str_replace('ql-indent-3', 'text-indent: 120px;', $anexa);
            $anexa = str_replace('ql-indent-4', 'text-indent: 160px;', $anexa);
            $anexa = str_replace('ql-indent-5', 'text-indent: 200px;', $anexa);

            $anexa = str_replace('color: rgb(230, 0, 0);', 'color: #ff0000;', $anexa);
            $anexa = str_replace('color: rgb(255, 153, 0);', 'color: #ff9900;', $anexa);
            $anexa = str_replace('color: rgb(255, 255, 0);', 'color: #ffff00;', $anexa);
            $anexa = str_replace('color: rgb(0, 138, 0);', 'color: #008a00;', $anexa);
            $anexa = str_replace('color: rgb(0, 102, 204);', 'color: #0066cc;', $anexa);
            $anexa = str_replace('color: rgb(153, 51, 255);', 'color: #9933ff;', $anexa);
            $anexa = str_replace('color: rgb(255, 255, 255);', 'color: #ffffff;', $anexa);
            $anexa = str_replace('color: rgb(250, 204, 204);', 'color: #facccc;', $anexa);
            $anexa = str_replace('color: rgb(255, 235, 204);', 'color: #ffebcc;', $anexa);
            $anexa = str_replace('color: rgb(255, 255, 204);', 'color: #ffffcc;', $anexa);
            $anexa = str_replace('color: rgb(204, 232, 204);', 'color: #cce8cc;', $anexa);
            $anexa = str_replace('color: rgb(204, 224, 245);', 'color: #cce0f5;', $anexa);
            $anexa = str_replace('color: rgb(235, 214, 255);', 'color: #ebd6ff;', $anexa);
            $anexa = str_replace('color: rgb(187, 187, 187);', 'color: #bbbbbb;', $anexa);
            $anexa = str_replace('color: rgb(240, 102, 102);', 'color: #f06666;', $anexa);
            $anexa = str_replace('color: rgb(255, 194, 102);', 'color: #ffc266;', $anexa);
            $anexa = str_replace('color: rgb(255, 255, 102);', 'color: #ffff66;', $anexa);
            $anexa = str_replace('color: rgb(102, 185, 102);', 'color: #66b966;', $anexa);
            $anexa = str_replace('color: rgb(102, 163, 224);', 'color: #66a3e0;', $anexa);
            $anexa = str_replace('color: rgb(194, 133, 255);', 'color: #c285ff;', $anexa);
            $anexa = str_replace('color: rgb(136, 136, 136);', 'color: #888888;', $anexa);
            $anexa = str_replace('color: rgb(161, 0, 0);', 'color: #a10000;', $anexa);
            $anexa = str_replace('color: rgb(178, 107, 0);', 'color: #b26b00;', $anexa);
            $anexa = str_replace('color: rgb(178, 178, 0);', 'color: #b2b200;', $anexa);
            $anexa = str_replace('color: rgb(0, 97, 0);', 'color: #006100;', $anexa);
            $anexa = str_replace('color: rgb(0, 71, 178);', 'color: #0047b2;', $anexa);
            $anexa = str_replace('color: rgb(107, 36, 178);', 'color: #6b24b2;', $anexa);
            $anexa = str_replace('color: rgb(68, 68, 68);', 'color: #444444;', $anexa);
            $anexa = str_replace('color: rgb(92, 0, 0);', 'color: #5c0000;', $anexa);
            $anexa = str_replace('color: rgb(102, 61, 0);', 'color: #663d00;', $anexa);
            $anexa = str_replace('color: rgb(102, 102, 0);', 'color: #666600;', $anexa);
            $anexa = str_replace('color: rgb(0, 55, 0);', 'color: #003700;', $anexa);
            $anexa = str_replace('color: rgb(0, 41, 102);', 'color: #002966;', $anexa);
            $anexa = str_replace('color: rgb(61, 20, 102);', 'color: #3d1466;', $anexa);

            $anexa = str_replace('background-color: rgb(230, 0, 0);', 'background-color: #ff0000;', $anexa);
            $anexa = str_replace('background-color: rgb(255, 153, 0);', 'background-color: #ff9900;', $anexa);
            $anexa = str_replace('background-color: rgb(255, 255, 0);', 'background-color: #ffff00;', $anexa);
            $anexa = str_replace('background-color: rgb(0, 138, 0);', 'background-color: #008a00;', $anexa);
            $anexa = str_replace('background-color: rgb(0, 102, 204);', 'background-color: #0066cc;', $anexa);
            $anexa = str_replace('background-color: rgb(153, 51, 255);', 'background-color: #9933ff;', $anexa);
            $anexa = str_replace('background-color: rgb(255, 255, 255);', 'background-color: #ffffff;', $anexa);
            $anexa = str_replace('background-color: rgb(250, 204, 204);', 'background-color: #facccc;', $anexa);
            $anexa = str_replace('background-color: rgb(255, 235, 204);', 'background-color: #ffebcc;', $anexa);
            $anexa = str_replace('background-color: rgb(255, 255, 204);', 'background-color: #ffffcc;', $anexa);
            $anexa = str_replace('background-color: rgb(204, 232, 204);', 'background-color: #cce8cc;', $anexa);
            $anexa = str_replace('background-color: rgb(204, 224, 245);', 'background-color: #cce0f5;', $anexa);
            $anexa = str_replace('background-color: rgb(235, 214, 255);', 'background-color: #ebd6ff;', $anexa);
            $anexa = str_replace('background-color: rgb(187, 187, 187);', 'background-color: #bbbbbb;', $anexa);
            $anexa = str_replace('background-color: rgb(240, 102, 102);', 'background-color: #f06666;', $anexa);
            $anexa = str_replace('background-color: rgb(255, 194, 102);', 'background-color: #ffc266;', $anexa);
            $anexa = str_replace('background-color: rgb(255, 255, 102);', 'background-color: #ffff66;', $anexa);
            $anexa = str_replace('background-color: rgb(102, 185, 102);', 'background-color: #66b966;', $anexa);
            $anexa = str_replace('background-color: rgb(102, 163, 224);', 'background-color: #66a3e0;', $anexa);
            $anexa = str_replace('background-color: rgb(194, 133, 255);', 'background-color: #c285ff;', $anexa);
            $anexa = str_replace('background-color: rgb(136, 136, 136);', 'background-color: #888888;', $anexa);
            $anexa = str_replace('background-color: rgb(161, 0, 0);', 'background-color: #a10000;', $anexa);
            $anexa = str_replace('background-color: rgb(178, 107, 0);', 'background-color: #b26b00;', $anexa);
            $anexa = str_replace('background-color: rgb(178, 178, 0);', 'background-color: #b2b200;', $anexa);
            $anexa = str_replace('background-color: rgb(0, 97, 0);', 'background-color: #006100;', $anexa);
            $anexa = str_replace('background-color: rgb(0, 71, 178);', 'background-color: #0047b2;', $anexa);
            $anexa = str_replace('background-color: rgb(107, 36, 178);', 'background-color: #6b24b2;', $anexa);
            $anexa = str_replace('background-color: rgb(68, 68, 68);', 'background-color: #444444;', $anexa);
            $anexa = str_replace('background-color: rgb(92, 0, 0);', 'background-color: #5c0000;', $anexa);
            $anexa = str_replace('background-color: rgb(102, 61, 0);', 'background-color: #663d00;', $anexa);
            $anexa = str_replace('background-color: rgb(102, 102, 0);', 'background-color: #666600;', $anexa);
            $anexa = str_replace('background-color: rgb(0, 55, 0);', 'background-color: #003700;', $anexa);
            $anexa = str_replace('background-color: rgb(0, 41, 102);', 'background-color: #002966;', $anexa);
            $anexa = str_replace('background-color: rgb(61, 20, 102);', 'background-color: #3d1466;', $anexa);

            // if($anexa){
            //     $section->addPageBreak();
                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $anexa, false, false);
            // }


            $html = '<br /><br />';
            $html .= '
                    <table align="center" style="width: 100%">
                        <tr>
                            <td style="width:50%" align="center"><b>Achizitor,</b>
                                <br/>' . $contracte->client->nume .
                '<br /><br />' . $contracte->client->reprezentant_functie .
                '<br />' . $contracte->client->reprezentant . '</td>
                            <td style="width:50%" align="center"><b>Prestator,</b>
                                <br/>' . ($contracte->firma->nume ?? '') . '
                                <br/>
                                <img src="images/semnatura_stampila.jpg" width="100"/></td>
                        </tr>
                    </table>
                ';

            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

            $footer = $section->addFooter();
            $footer->addPreserveText('Pagina {PAGE} din {NUMPAGES}', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            try {
                Storage::makeDirectory('fisiere_temporare');
                $objWriter->save(storage_path(
                    'app/fisiere_temporare/' .
                    'Contract nr. ' . $contracte->contract_nr .
                    ' din data de ' . \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('DD.MM.YYYY') .
                    ' - ' . ($contracte->client->nume ?? '') . '.docx'
                ));
            } catch (Exception $e) { }

            return response()->download(storage_path(
                'app/fisiere_temporare/' .
                'Contract nr. ' . $contracte->contract_nr .
                ' din data de ' . \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('DD.MM.YYYY') .
                ' - ' . ($contracte->client->nume ?? '') . '.docx'
            ));

            // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
            // try {
            //     $objWriter->save(storage_path('Contract.html'));
            // } catch (Exception $e) { }

            // return response()->download(storage_path('Contract.html'));

        }
    }

    /**
     * Upload files.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUploadPost(Request $request, Contract $contracte)
    {
        $request->validate([
            'fisier' => 'required|mimes:pdf,xlx,csv,doc,docx|max:2048',
        ]);

        $fisier = request()->file('fisier');
        $fileName = pathinfo($fisier->getClientOriginalName(), PATHINFO_FILENAME) . ' ' .
            \Carbon\Carbon::now()->isoFormat('HHMMSSDDMMYY') . '.' .
            $fisier->extension();
        // $filePath = "contracte/" . date("Y") . '/' . date("m");
        $filePath = "contracte/" . $contracte->contract_nr . '/';
        // dd($fisier, $fileName, $filePath);
        $fisier->storeAs($filePath, $fileName);
        // $request->fisier->move(public_path($filePath), $fileName);

        // Storage::disk('local')->put($filePath, $fileName);

        $fisier_database = new Fisier;
        $fisier_database->contract_id = $contracte->id;
        $fisier_database->path = $filePath;
        $fisier_database->nume = $fileName;
        $fisier_database->save();

        return back()->with('success', 'Fișierul "' . $fileName . '" a fost încărcat cu succes');
    }

    /**
     * Download files.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileDownload(Request $request, Fisier $fisier)
    {
        // dd($fisier);
        $cale_si_fisier = $fisier->path . $fisier->nume;

        // $headers = array(
        //     'Content-Type: application/pdf',
        // );

        return Storage::download($cale_si_fisier);
    }

    /**
     * Delete files.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileDelete(Request $request, Fisier $fisier)
    {
        // dd($fisier);
        $cale_si_fisier = $fisier->path . $fisier->nume;

        // $headers = array(
        //     'Content-Type: application/pdf',
        // );

        return Storage::delete($cale_si_fisier);
    }
}
