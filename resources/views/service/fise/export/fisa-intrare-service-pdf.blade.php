<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bilet</title>
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


            <img src="{{ asset('images/contract-header.jpg') }}" width="80px">

            {{-- $html = '<br />';
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
            $html .= '
                    <table align="center" style="width: 100%">
                        <tr>
                            <td style="width:50%" align="center"><b>Beneficiar,</b>
                                <br/>' . $fise->client->nume .
                                '<br /><br />' . $fise->client->reprezentant_functie .
                                '<br />' . $fise->client->reprezentant . '</td>                            
                            <td style="width:30%" align="center"><b>Prestator,</b>
                                <br/>Dima P. Valentin PFA
                                <br/>
                                <br/>
                                <b>Tehnician service</b>
                                <br/>' .
                                $fise->tehnician_service .
                                '
                                <br/>
                                <img src="images/semnatura si stampila.png" width="100"/>
                            </td>
                        </tr>
                    </table>
                '; --}}






                <table style="margin:220px 0 20px 0">
                    <tr valign="top" style="">
                        <td style="border-width:0px; padding:0rem; margin:0rem; width:50%; text-align:center;">
                            Data
                            <br>
                            {{ \Carbon\Carbon::now()->isoFormat('DD.MM.YYYY') }}
                        </td>
                        <td style="border-width:0px; padding:0rem; margin:0rem; width:50%; text-align:center;">
                            Dima P. Valentin PFA
                            <br>
                            <img src="{{ asset('images/semnatura_stampila.jpg') }}" width="80px">
                        </td>
                    </tr>
                </table>
            
                    
    </div>
</body>

</html>
    