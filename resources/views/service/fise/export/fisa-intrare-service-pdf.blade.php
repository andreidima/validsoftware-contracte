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
                <p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE INTRARE CONSULTANȚĂ IT</p>
            @else
                <p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE INTRARE ÎN SERVICE</p>
            @endif

            <p style="text-align: center; font-weight: bold;">
                {{
                    'Nr. ' . $fisa->nr_intrare . (isset($fisa->data_receptie) ? (' din ' . \Carbon\Carbon::parse($fisa->data_receptie)->isoFormat('DD.MM.YYYY')) : '')
                }}
            </p>
            <br />
            <br />

            <p style="text-align:justify;">
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
                <p style="text-align:left; font-weight: bold;">Descriere echipament</p>
                <p style="text-align:justify;">
                    {{ $fisa->descriere_echipament }}
                </p>
            @endif
            <br />

            @if ($fisa->defect_reclamat)
                <p style="text-align:left; font-weight: bold;">Serviciu solicitat sau defect reclamat</p>
                <p style="text-align:justify;">
                    {{ $fisa->defect_reclamat }}
                </p>
            @endif
            <br />

            <br /><br />
            <table align="center" style="width: 100%">
                <tr>
                    <td style="width:50%" align="center"><b>Beneficiar,</b>
                        <br/> {{ $fisa->client->nume }}
                        <br /><br /> {{ $fisa->client->reprezentant_functie }}
                        <br /> {{ $fisa->client->reprezentant }}
                    </td>
                    <td style="width:50%" align="center"><b>Prestator,</b>
                        {{-- <br/>Dima P. Valentin PFA
                        <br/>
                        <br/>
                        <b>Tehnician service</b>
                        <br/>
                            {{ $fisa->tehnician_service }}
                        <br/>
                        <img src="images/semnatura_stampila.jpg" width="100"/> --}}
                        SC VALIDSOFTWARE SRL
                        <br>
                        <img src="images/semnatura_stampila_srl.jpeg" width="100">
                    </td>
                </tr>
            </table>

            {{-- Page break --}}
            <p style="page-break-before: always;"></p>

            {{-- Pagină publicitara --}}

            <br><br><br>

            <p style="text-align:left; font-weight: bold;">Despre noi</p>
            <p style="text-align:justify;">
                Suntem o firmă din Focșani, înființată în anul 2012, orientată pe dezvoltarea de servicii informatice și consultanță IT. Produsele informatice pe care le oferim acoperă atât clienți din sectorul public/ privat din România, cât și cei de pe piața internațională. Pentru mai multe detalii legate de activitatea noastră din zona de servicii web, vă invităm să accesați secțiunea Portofoliu de la adresa <a href="https://validsoftware.ro/" target="_blank">https://validsoftware.ro</a>.
            </p>

            <br />

            <p style="text-align:left; font-weight: bold;">Echipă și scop</p>
            <p style="text-align:justify;">
                Echipa noastră este formată din specialiști, absolvenți de studii superioare în domeniul IT, dar și în domenii conexe. Scopul nostru este furnizarea de servicii integrate, pentru a oferi clienților noștri creșterea competitivității și performanței activităților pe care le desfășoară.
            </p>

            <br />

            <p style="text-align:left; font-weight: bold;">Tehnologie</p>
            <p style="text-align:justify;">
                Adoptăm tehnologii de ultimă oră și ne bazăm pe spiritul de inovație al colegilor noștri. Oferim calitate și eficiență, finalizând cu succes proiectele, indiferent dacă acestea implică soluții simple sau complexe.
            </p>
            <br />

            <b>Ce vă oferim</b>
            <br />
            Venim în întâmpinarea nevoilor dumneavoastră prin:
                <ul>
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

            <p style="text-align:left; font-weight: bold;">Contact:</p>
            <ul>
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
