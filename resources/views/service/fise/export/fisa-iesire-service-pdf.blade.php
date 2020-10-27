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


            <p style="text-align: center; font-weight: bold; font-size: 21px;">FIȘĂ DE IEȘIRE DIN SERVICE</p>
            <p style="text-align: center; font-weight: bold;">
                Nr. {{ $fisa->nr_iesire . (isset($fisa->data_receptie) ? (' din ' . \Carbon\Carbon::parse($fisa->data_receptie)->isoFormat('DD.MM.YYYY')) : '') }}
            </p>
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
                <br />
            @endif

            @if ($fisa->defect_reclamat)
                <p style="text-align:left; font-weight: bold;">Defect reclamat</p>
                <p style="text-align:justify;">
                    {{ $fisa->defect_reclamat }}
                </p>
                <br />
            @endif

            @if ($fisa->defect_constatat)
                <p style="text-align:left; font-weight: bold;">Defect constatat</p>
                <p style="text-align:justify;">
                    {{ $fisa->defect_constatat }}
                </p>
                <br />
            @endif

            @if ($fisa->rezultat_service)
                <p style="text-align:left; font-weight: bold;">Rezultat service</p>
                <p style="text-align:justify;">
                    {{ $fisa->rezultat_service }}
                </p>
                <br />
            @endif

            @if ($fisa->servicii)
                @php
                    $html ='<b>Servicii efectuate:</b>';
                    $html .='<ul>';
                    foreach ($fisa->servicii as $serviciu) {
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

                @endphp

                {!! $html !!}
            @endif

            @if ($fisa->observatii)
                <p style="text-align:left; font-weight: bold;">Obervații</p>
                <p style="text-align:justify;">
                    {{ $fisa->observatii }}
                </p>
                <br />
            @endif

            <br /><br />
            <table align="center" style="width: 100%">
                <tr>
                    <td style="width:50%" align="center"><b>Beneficiar,</b>
                        <br/> {{ $fisa->client->nume }}
                        <br /><br /> {{ $fisa->client->reprezentant_functie }}
                        <br /> {{ $fisa->client->reprezentant }}
                    </td>                            
                    <td style="width:50%" align="center"><b>Prestator,</b>
                        <br/>Dima P. Valentin PFA
                        <br/>
                        <br/>
                        <b>Tehnician service</b>
                        <br/>
                            {{ $fisa->tehnician_service }}
                        <br/>
                        <img src="images/semnatura si stampila.png" width="100"/>
                    </td>
                </tr>
            </table>

                    
    </div>
</body>

</html>
    