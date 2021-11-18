<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Fișă service</title>
    <style>
        html {
            margin: 0px 0px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 14px;
            margin: 0px;
        }

        * {
            /* padding: 0; */
            text-indent: 0;
            margin: 0px;
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
    </style>
</head>

<body>
    {{-- <div style="width:730px; height: 1030px; border-style: dashed ; border-width:2px; border-radius: 15px;">      --}}
    <img src="{{ asset('images/contract-header.jpg') }}" width="800px">

    <div style="
        /* border:dashed #999; */
        width:710px;
        min-height:500px;
        padding: 0px 0px 0px 0px;
        margin:20px 50px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;">


            @if ($fisa->consultanta_it === 1)
                <p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE IEȘIRE CONSULTANȚĂ IT</p>
            @else
                <p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE IEȘIRE DIN SERVICE</p>
            @endif

            <p style="text-align: center; font-weight: bold;">
                Nr. {{ $fisa->nr_iesire . (isset($fisa->data_receptie) ? (' din ' . \Carbon\Carbon::parse($fisa->data_receptie)->isoFormat('DD.MM.YYYY')) : '') }}
            </p>
            <br />
            <br />

            <p style="text-align:justify; margin:0px;">
                {{
                    'Beneficiar ' . ($fisa->client->nume ?? '') .
                    (isset($fisa->client->adresa) ? ', din ' . ($fisa->client->adresa) : '') .
                    (isset($fisa->client->nr_ord_reg_com) ? ', Nr. Reg. Comerțului: ' . ($fisa->client->nr_ord_reg_com) : '') .
                    (isset($fisa->client->cui) ? ', CUI: ' . ($fisa->client->cui) : '') .
                    (isset($fisa->client->iban) ? ', IBAN: ' . ($fisa->client->iban) : '') .
                    (isset($fisa->client->banca) ? ', Banca ' . ($fisa->client->banca) : '') .
                    (isset($fisa->client->reprezentant) ? ', Reprezentant ' . ($fisa->client->reprezentant) : '') .
                    (isset($fisa->client->reprezentant_functie) ? ', în funcția de ' . ($fisa->client->reprezentant_functie) : '') .
                    (isset($fisa->client->telefon) ? ', telefon: ' . ($fisa->client->telefon) : '') .
                    (isset($fisa->client->email) ? ', email: ' . ($fisa->client->email) : '') .
                    (isset($fisa->client->site_web) ? ', site web: ' . ($fisa->client->site_web) : '')
                }}.
            </p>
            <br />

            @if ($fisa->descriere_echipament)
                <p style="text-align:left; font-weight: bold; margin:0px;">Descriere echipament</p>
                <p style="text-align:justify; margin:0px;">
                    {{ $fisa->descriere_echipament }}
                </p>
                <br />
            @endif

            @if ($fisa->defect_reclamat)
                <p style="text-align:left; font-weight: bold; margin:0px;">Serviciu solicitat sau defect reclamat</p>
                <p style="text-align:justify; margin:0px;">
                    {{ $fisa->defect_reclamat }}
                </p>
                <br />
            @endif

            @if ($fisa->defect_constatat)
                <p style="text-align:left; font-weight: bold; margin:0px;">Defect constatat</p>
                <p style="text-align:justify; margin:0px;">
                    {{ $fisa->defect_constatat }}
                </p>
                <br />
            @endif

            @if ($fisa->rezultat_service)
                <p style="text-align:left; font-weight: bold; margin:0px;">Rezultat service</p>
                <p style="text-align:justify; margin:0px;">
                    {{-- {{ $fisa->rezultat_service }} --}}
                    @php
                        $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                        $fisa->rezultat_service_cu_linkuri = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $fisa->rezultat_service);

                        // $reg_exUrl = "/<a\s+.*?href=[\"\']?([^\"\' >]*)[\"\']?[^>]*>(.*?)<\/a>/i";
                        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $fisa->rezultat_service, $urlurile_extrase);
                        // dd($urlurile_extrase[0]);
                    @endphp
                    {!! $fisa->rezultat_service_cu_linkuri !!}
                </p>
                <br />
            @endif

            @if (!empty($urlurile_extrase[0]))
                @if (count($urlurile_extrase[0]) == 1)
                    <b>Accesează linkul de mai sus, prin scanarea codului QR</b>
                @else
                    <b>Accesează linkurile de mai sus, prin scanarea codurilor QR</b>
                @endif
                <table style="width: 100%; margin:0px;">
                    @foreach ($urlurile_extrase[0] as $url)
                        <tr>
                            <td style="width: 1%; padding-bottom:15px">
                                <img src="data:image/png;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($url)) }}">
                            </td>
                            <td style="vertical-align:middle; padding-bottom:15px">
                                {{ $url }}
                            </td>
                        </tr>
                    @endforeach
                </table>
                <br />
            @endif

            @if (count($fisa->servicii))
                <div style="page-break-inside: avoid">
                @php
                    $html ='<b>Servicii efectuate:</b>';
                    $html .='<ul style="margin:0px;">';
                    foreach ($fisa->servicii->sortBy('nr_de_ordine') as $serviciu) {
                        $html .= '<li>' . $serviciu->nume;
                            // if ($serviciu->pret){
                            //     $html .= ' - ' . $serviciu->pret . ' RON';
                            // }
                            // if ($serviciu->recurenta){
                            //     $html .= '/ ' . $serviciu->recurenta;
                            // }
                        $html .= '</li>';
                    }
                    $html .='</ul>';

                    $html .= '<br />';

                @endphp

                {!! $html !!}
                </div>
            @endif

            @if ($fisa->instalare_anydesk === 1)
                <div style="page-break-inside: avoid">
                    <p style="text-align:left; font-weight: bold; margin:0px;">Important</p>
                    <p style="text-align:justify; margin:0px;">
                        Pentru suport tehnic de la distanță am instalat și aplicația AnyDesk. În cazul în care întâmpinați probleme în utilizarea calculatorului, vă rugăm să ne contactați la <a href="service@validsoftware.ro">service@validsoftware.ro</a> sau 0785 709 027.
                    </p>
                    <br />
                </div>
            @endif

            @if ($fisa->observatii)
                <div style="page-break-inside: avoid">
                    <p style="text-align:left; font-weight: bold; margin:0px;">Observații</p>
                    <p style="text-align:justify; margin:0px;">
                        {{ $fisa->observatii }}
                    </p>
                    <br />
                </div>
            @endif



            {{-- Page break --}}
            <span style="page-break-after: always;"></span>

            {{-- Pagină publicitara --}}

            <br><br><br>

            <p style="text-align:left; font-weight: bold; margin:0px;">Despre noi</p>
            <p style="text-align:justify; margin:0px;">
                Suntem o firmă din Focșani, înființată în anul 2012, orientată pe dezvoltarea de servicii informatice și consultanță IT. Produsele informatice pe care le oferim acoperă atât clienți din sectorul public/ privat din România, cât și cei de pe piața internațională. Pentru mai multe detalii legate de activitatea noastră din zona de servicii web, vă invităm să accesați secțiunea Portofoliu de la adresa <a href="https://validsoftware.ro/" target="_blank">https://validsoftware.ro</a>.
            </p>

            <br />

            <p style="text-align:left; font-weight: bold; margin:0px;">Echipă și scop</p>
            <p style="text-align:justify; margin:0px;">
                Echipa noastră este formată din specialiști, absolvenți de studii superioare în domeniul IT, dar și în domenii conexe. Scopul nostru este furnizarea de servicii integrate, pentru a oferi clienților noștri creșterea competitivității și performanței activităților pe care le desfășoară.
            </p>

            <br />

            <p style="text-align:left; font-weight: bold; margin:0px;">Tehnologie</p>
            <p style="text-align:justify; margin:0px;">
                Adoptăm tehnologii de ultimă oră și ne bazăm pe spiritul de inovație al colegilor noștri. Oferim calitate și eficiență, finalizând cu succes proiectele, indiferent dacă acestea implică soluții simple sau complexe.
            </p>
            <br />

            <b>Ce vă oferim</b>
            <br />
            Venim în întâmpinarea nevoilor dumneavoastră prin:
                <ul style="margin:0px;">
                    <li>
                        <b>Servicii web și multumedia</b>: achiziționare domenii, găzduire site-uri și aplicații web, dezvoltare aplicații web personalizate, realizare site-uri de prezentare și magazine online, promovare online servicii și produse, fotografii de produs/ locație și clipuri de prezentare, consultanță IT.
                    </li>
                    <li>
                        <b>Service IT</b>: Instalare și actualizare sisteme de operare și aplicații adiacente, migrare sisteme de operare pe ssd, remedierea problemelor software ale calculatoarelor, salvare și transfer date, configurare echipamente IT, upgrade configurații hardware, mentenanță preventivă calculatoare.
                    </li>
                    <li>
                        <b>Consultanță IT remote (de la distanță)</b>: Servicii de optimizare calculatoare, remediere probleme software de la distanță, consultanță IT generală, cu posibilitate de plată online cu cardul.
                    </li>
                </ul>
            <br />

            <p style="text-align:left; font-weight: bold; margin:0px;">Contact:</p>
            <ul style="margin:0px;">
                <li>
                    <a href="https://validsoftware.ro/" target="_blank">https://validsoftware.ro/</a>
                </li>
                <li>
                    <a href="mailto:contact@validsoftware.ro">contact@validsoftware.ro</a>
                </li>
                <li>
                    <a href="tel:+40 0744 761 451">0744 761 451</a>
                </li>
            </ul>
            <br />

    </div>
</body>

</html>
