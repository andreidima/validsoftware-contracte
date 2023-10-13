<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        Contract
    </title>
    <style>
        /* html {
            margin: 0px 0px;
        } */
        /** Define the margins of your page **/
        @page {
            margin: 0px 0px;
        }

        header {
            position: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 13px;
            margin-top: 4.5cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        * {
            /* padding: 0; */
            text-indent: 0;
        }

        table{
            border-collapse:collapse;
            margin: 0px;
            padding: 5px;
            margin-top: 0px;
            border-style: solid;
            border-width: 0px;
            width: 100%;
            word-wrap:break-word;
        }

        th, td {
            padding: 1px 10px;
            border-width: 0px;
            border-style: solid;

        }
        tr {
            border-style: solid;
            border-width: 0px;
        }
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 0.5px;
        }
        p {
            margin:0px 0px;
        }
    </style>
</head>

<body>
    {{-- <div style="width:730px; height: 1030px; border-style: dashed ; border-width:2px; border-radius: 15px;">      --}}
    {{-- <img src="{{ asset('images/contract-header.jpg') }}" width="800px"> --}}

    <header>
        <img src="{{ asset('images/contract-header.jpg') }}" width="800px">
    </header>

    {{-- <div style="
        /* border:dashed #999; */
        width:710px;
        min-height:500px;
        padding: 0px 0px 0px 0px;
        margin:20px 50px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;"> --}}
    <main>

        @php

            $html = '<p style="text-align: center; font-weight: bold; font-size: 21px;">CONTRACT DE FURNIZARE SERVICII INFORMATICE</p>';
            $html .= '<p style="text-align: center; font-weight: bold;">Nr. ' . $contracte->contract_nr .
                (isset($contracte->contract_data) ? (' din ' . \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('DD.MM.YYYY')) : '') .
                '</p>';
            $html .= '<br /><br />';
            $html .= '<p style="text-align:justify;">' .
                'Prezentul contract intră în vigoare începând cu data de ' .
                (isset($contracte->data_incepere) ? (\Carbon\Carbon::parse($contracte->data_incepere)->isoFormat('DD.MM.YYYY')) : '..........') .
                ' între <b>' . $contracte->client->nume . '</b>' .
                ', cu sediul în ' . $contracte->client->adresa .
                ', Cod Unic de Înregistrare CUI ' . $contracte->client->cui .
                ', reprezentată de <b>' . $contracte->client->reprezentant . '</b>' .
                ', având funcţia de <b>' . $contracte->client->reprezentant_functie . '</b>' .
                ' și' .
                '</p><p style="text-align:justify;">' .
                '<b>' . ($contracte->firma->nume ?? '') . '</b>' .
                ', Nr. Reg. Comerțului ' . ($contracte->firma->nr_reg_com ?? '') .
                ', CIF ' . ($contracte->firma->cif ?? '') .
                ', cont IBAN ' . ($contracte->firma->cont_iban ?? '') .
                ', deschis la ' . ($contracte->firma->cont_deschis_la ?? '') .
                (isset($contracte->firma->cont_iban_trezorerie) ? (', cont trezorerie IBAN ' . ($contracte->firma->cont_iban_trezorerie ?? '')) : '') .
                (isset($contracte->firma->cont_deschis_la_trezorerie) ? (', deschis la ' . ($contracte->firma->cont_deschis_la_trezorerie ?? '')) : '') .
                ', reprezentată de <b>' . 'Valentin Dima' . '</b>' .
                ', având funcţia de <b>' . 'Administrator' . '</b>' .
                '.</p>';
            $html .= '<br />';
            $html .= '<ol>
                        <li><p style="font-weight: bold;">Termeni generali</p></li>
                            <ol type="a">
                                <li style="text-align:justify;">Contractul se referă la prestarea de servicii informatice de către <b>' . ($contracte->firma->nume ?? '') . '</b> în beneficiul <b>'. $contracte->client->nume . '</b>.</li>
                                <li style="text-align:justify;">Contractul este valabil până la terminarea sa în conformitate cu condiţiile incluse mai jos în prezentul document.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Relaţie contractuală</p></li>
                            <ol type="a">
                                <li style="text-align:justify;"><b>' . ($contracte->firma->nume ?? '') . '</b> va desfăşura activităţile aferente prezentului contract la sediul <b>' . $contracte->client->nume . '</b> sau la sediul propriu.</li>
                                <li style="text-align:justify;"><b>' . ($contracte->firma->nume ?? '') . '</b> nu are autoritatea de a-şi asuma responsabilităţi sau obligaţii în locul <b>' . $contracte->client->nume . '</b>.</li>
                                <li style="text-align:justify;">Serviciile pe care <b>' . ($contracte->firma->nume ?? '') . '</b> se angajează să le efectueze în beneficiul <b>' . $contracte->client->nume . '</b> sunt specificate în “Planul de lucru – Anexa”, dar nu se limitează numai la acestea.</li>
                                <li style="text-align:justify;"><b>' . $contracte->client->nume . '</b> şi <b>' . ($contracte->firma->nume ?? '') . '</b> vor cădea de acord asupra serviciilor suplimentare care trebuie efectuate sau asupra celor care nu mai sunt necesare.</li>
                                <li style="text-align:justify;">Calitatea serviciilor furnizate de <b>' . ($contracte->firma->nume ?? '') . '</b> va fi conformă cu cerinţele  <b>' . $contracte->client->nume . '</b>.</li>
                                <li style="text-align:justify;"><b>' . ($contracte->firma->nume ?? '') . '</b> are obligaţia de a livra produsele şi de a presta serviciile prevăzute în contract cu profesionalismul şi promptitudinea cuvenite angajamentului asumat şi în conformitate cu propunerea sa tehnică.</li>
                                <li style="text-align:justify;"><b>' . ($contracte->firma->nume ?? '') . '</b> este pe deplin responsabil pentru prestarea serviciilor în conformitate cu graficul de prestare convenit şi de siguranţa tuturor operaţiunilor şi metodelor de prestare utilizate pe toată durata contractului. </li>';

                    if (($contracte->abonament_lunar === 1) && ($contracte->pret != null)){
                        $html .= '<li style="text-align:justify;"><b>' . ($contracte->firma->nume ?? '') . '</b> va emite lunar o factură în valoare de ' . $contracte->pret . ' RON (TVA 0), pentru serviciile prestate. </li>';
                    }

                $html .= '</ol>
                            <br/>
                            <div style="page-break-after: always;"></div>';

                if ($contracte->obiectul_contractului){
                    $html .= '<li><p style="font-weight: bold;">Obiectul contractului</p></li> ' .
                                $contracte->obiectul_contractului .
                            '<br/>';
                }
                $html .= '<li><p style="font-weight: bold;">Durata contractului</p></li>
                            <ol type="a">
                                <li style="text-align:justify;">Contractul este valabil în intervalul ' .
                                (isset($contracte->data_incepere) ? (\Carbon\Carbon::parse($contracte->data_incepere)->isoFormat('DD.MM.YYYY')) : '') .
                                ' - ' .
                                (isset($contracte->data_terminare) ? (\Carbon\Carbon::parse($contracte->data_terminare)->isoFormat('DD.MM.YYYY')) : '') .
                                ' și poate fi prelungit prin acte adiționale, încheiate cu acordul ambelor părți contractente.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Responsabilităţile <b>' . $contracte->client->nume . '</b></p></li>
                            <ol type="a">
                                <li style="text-align:justify;"><b>' . $contracte->client->nume . '</b> are obligaţia de a pune la dispoziţia <b>' . ($contracte->firma->nume ?? '') . '</b> toate informaţiile pe care <b>' . ($contracte->firma->nume ?? '') . '</b> le consideră necesare în mod rezonabil pentru îndeplinirea contractului.</li>
                                <li style="text-align:justify;"><b>' . $contracte->client->nume . '</b> are obligaţia de a efectua plata către <b>' . ($contracte->firma->nume ?? '') . '</b> în termen de 30 zile de la emiterea facturii de către acesta.</li>
                                <li style="text-align:justify;">În cazul în care <b>' . $contracte->client->nume . '</b> nu onorează facturile în termen de 30 zile de la expirarea perioadei prevăzute la clauza 4.b, <b>' . ($contracte->firma->nume ?? '') . '</b> are dreptul de a sista prestarea serviciilor sau de a diminua ritmul prestării. Imediat ce <b>' . $contracte->client->nume . '</b> onorează factura, <b>' . ($contracte->firma->nume ?? '') . '</b> va relua prestarea serviciilor în cel mai scurt timp posibil.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Recepţie şi verificări</p></li>
                            <ol type="a">
                                <li style="text-align:justify;"><b>' . $contracte->client->nume . '</b> are dreptul de a verifica modul de prestare şi calitatea serviciilor.</li>';

                    if ($contracte->abonament_lunar === 1){
                        $html .= '<li style="text-align:justify;">La cerere, <b>' . ($contracte->firma->nume ?? '') . '</b> poate genera lunar un raport de activitate, care va fi înaintat beneficiarului. </li>';
                    }

                $html .= '</ol>
                            <br/>
                        <li><p style="font-weight: bold;">Încetarea contractului - prezentul contract poate înceta prin:</p></li>
                            <ol type="a">
                                <li>Ajungerea la termenul prevăzut la pct.4, numai după decontarea contravalorii serviciului.</li>
                                <li>Acordul scris al părţilor, la data convenită de către acestea.</li>
                                <li>Prin reziliere, după acordarea unui termen de înștiințare de 30 zile calendaristice în situația executării sau neexecutării culpabile și/sau necorespunzătoare a obligațiilor contractuale.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Forţa majoră</p></li>
                            <ol type="a">
                                <li style="text-align:justify;">Forţa majoră este constatată de o autoritate competentă.</li>
                                <li style="text-align:justify;">Forţa majoră exonerează părţile contractante de îndeplinirea obligaţiilor asumate prin prezentul contract, pe toată perioada în care aceasta acţionează.</li>
                                <li style="text-align:justify;">Îndeplinirea contractului va fi suspendată în perioada de acţiune a forţei majore, dar fără a prejudicia drepturile ce li se cuveneau părţilor până la apariţia acesteia.</li>
                                <li style="text-align:justify;">Partea contractantă care invocă forţa majoră are obligaţia de a notifica celeilalte părţi, imediat şi în mod complet, producerea acesteia şi de a lua orice măsuri care îi stau la dispoziţie în vederea limitării consecinţelor.</li>
                                <li style="text-align:justify;">Dacă forţa majoră acţionează sau se estimează că va acţiona o perioadă mai mare de 6 luni, fiecare parte va avea dreptul să notifice celeilalte părţi încetarea de plin drept a prezentului contract, fără ca vreuna dintre părţi să poată pretinde celeilalte daune-interese.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Soluţionarea litigiilor</p></li>
                            <ol type="a">
                                <li style="text-align:justify;"><b>' . $contracte->client->nume . '</b> şi <b>' . ($contracte->firma->nume ?? '') . '</b> vor face toate eforturile pentru a rezolva pe cale amiabilă, prin tratative directe, orice neînţelegere sau dispută care se poate ivi între ei în cadrul sau în legătură cu îndeplinirea contractului, conform procedurii concilierii directe reglementată de Codul de Procedură Civilă.</li>
                                <li style="text-align:justify;">Dacă după 15 zile de la începerea acestor tratative <b>' . $contracte->client->nume . '</b> şi <b>' . ($contracte->firma->nume ?? '') . '</b> nu reuşesc să rezolve în mod amiabil o divergenţă contractuală, fiecare parte poate solicita ca disputa să se soluționeze de către instanțele judecătorești.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Modificări</p></li>
                            <ol type="a">
                                <li style="text-align:justify;">Orice modificare a prezentului contract trebuie să fie făcută în scris, sub formă de act adiţional.</li>
                            </ol>
                            <br/>
                        <li><p style="font-weight: bold;">Legea aplicabilă contractului</p></li>
                            <ol type="a">
                                <li style="text-align:justify;">Contractul va fi interpretat conform legilor din România.</li>
                            </ol>
                    </ol>
                ';
            $html .= '<br /><br />';
            $html .= '
                    <table align="center" style="width: 100%">
                        <tr>
                            <td style="width:50%" align="center" valign="top"><b>Achizitor,</b>
                                <br/>' . $contracte->client->nume .
                                '<br /><br />' . $contracte->client->reprezentant_functie .
                                '<br />' . $contracte->client->reprezentant . '</td>
                            <td style="width:50%" align="center" valign="top"><b>Prestator,</b>
                                <br/>' . ($contracte->firma->nume ?? '') . '
                                <br/>' .
                                ((isset($contracte->firma->nume_semnatura) && file_exists('images/' . ($contracte->firma->nume_semnatura ?? ''))) ? ('<img src="images/' . ($contracte->firma->nume_semnatura ?? '') . '" width="100"/>') : '') .
                            '
                            </td>
                        </tr>
                    </table>
                ';

            $html .= '<div style="page-break-after: always;"></div>';

            $html .= '<p style="text-align: center; font-weight: bold; font-size: 21px;">Plan de lucru</p>
                    <br /><br />
                    <p style="font-weight: bold; text-align:justify;">Anexa nr. 01 ' .
                        (isset($contracte->contract_data) ? (' din ' . \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('DD.MM.YYYY')) : '') .
                        ' la CONTRACTUL DE PRESTARE DE SERVICII INFORMATICE Nr. ' .
                        $contracte->contract_nr .
                        (isset($contracte->contract_data) ? (' din ' . \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('DD.MM.YYYY')) : '') .
                    '</p>
                    <br /><br />';

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

            $html .= $anexa;

            $html .= '<br /><br />';
            $html .= '
                    <table align="center" style="width: 100%">
                        <tr>
                            <td style="width:50%" align="center" valign="top"><b>Achizitor,</b>
                                <br/>' . $contracte->client->nume .
                '<br /><br />' . $contracte->client->reprezentant_functie .
                '<br />' . $contracte->client->reprezentant . '</td>
                            <td style="width:50%" align="center" valign="top"><b>Prestator,</b>
                                <br/>' . ($contracte->firma->nume ?? '') . '
                                <br/>' .
                                ((isset($contracte->firma->nume_semnatura) && file_exists('images/' . ($contracte->firma->nume_semnatura ?? ''))) ? ('<img src="images/' . ($contracte->firma->nume_semnatura ?? '') . '" width="100"/>') : '') .
                            '
                            </td>
                        </tr>
                    </table>
                ';

            @endphp

            {!! $html !!}

            {{-- Here's the magic. This MUST be inside body tag. Page count / total, centered at bottom of page --}}
            <script type="text/php">
                if (isset($pdf)) {
                    $text = "Pagina {PAGE_NUM} / {PAGE_COUNT}";
                    $size = 10;
                    $font = $fontMetrics->getFont("helvetica");
                    $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                    $x = ($pdf->get_width() - $width) / 2;
                    $y = $pdf->get_height() - 35;
                    $pdf->page_text($x, $y, $text, $font, $size);
                }
            </script>

    {{-- </div> --}}
        </main>
</body>

</html>
