<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Colet</title>
    <style>
        html { 
            margin: 40px 30px;
        }

        body { 
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 12px;
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
    <div style="border:dashed #999;
        width:710px; 
        min-height:500px;            
        padding: 0px 8px 0px 8px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;">

                <table style="margin:20px 0 20px 0">
                    <tr style="">
                        <td style="border-width:0px; padding:0rem; margin:0rem; width:40%">
                            <img src="{{ asset('images/Alsimy Mond Travel Galati - logo.png') }}" width="300px">
                        </td>
                        <td style="border-width:0px; padding:0rem; margin:0rem; width:60%; text-align:center; font-size:16px">
                            COLET REZERVAT
                            <br>
                            Cod rezervare transport: RO{{ $colet->id }}
                        </td>
                    </tr>
                </table>
            
                            
            <table style="margin-bottom:40px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="3" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:0px 0px 5px 0px; padding:5px 0px;">
                        Informatii Client
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="">
                        Client: 
                        <br>
                        <b>{{ $colet->nume }}</b>
                    </td>
                    <td width="25%" style="text-align:center;">
                        Telefon: 
                        <br>
                        <b>{{ $colet->telefon }}</b>
                    </td>
                    <td width="40%" style="text-align:right;">
                        E-mail: 
                        <br>
                        <b>{{ $colet->email }}</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">                        
                        Adresa: {{ $colet->adresa }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">                    
                        Observatii: {{ $colet->observatii }}
                    </td>
                </tr>
            </table>

            <table style="margin-bottom:40px">    
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="3" style="padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                        Informatii rezervare transport
                        </h3>
                    </td>
                </tr>
                <tr style="">
                    <td style="">
                        Oraș plecare:
                        <br>
                        <b>{{ $colet->oras_plecare_nume->nume }}</b>
                    </td>
                    <td>
                        <img src="{{ asset('images/sageata dreapta.jpg') }}" width="50px">
                    </td>
                    <td style="">
                        Oraș sosire:
                        <br>
                        <b>{{ $colet->oras_sosire_nume->nume }}</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Numar colete: {{ $colet->numar_colete }}
                        <br>
                        Detalii colete: {{ $colet->detalii_colete }}
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
            </table>
                            
            <table style="margin-bottom:20px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="6" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                        Date pentru facturare
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        Document de călătorie:<b> {{ $colet->document_de_calatorie }} </b>
                        <br>
                        Data expirării documentului:<b> {{ \Carbon\Carbon::parse($colet->expirare_document)->isoFormat('D.MM.YYYY') }} </b>
                        <br>
                        Seria buletin / pașaport:<b> {{ $colet->serie_document }} </b>
                        <br>
                        Cnp:<b> {{ $colet->cnp }} </b>
                        <br>
                    </td>
                </tr>                
            </table>

            <br>
            Ptr rezervari făcute cu mai puțin de 24 ore înainte de plecare sunați la nr de telefon: <b>0755106508</b> sau <b>0742296938</b>
            <br>
            E-mail: <a href="mailto:alsimy_mond_travel@yahoo.com">alsimy_mond_travel@yahoo.com</a> 
                / 
                <a href="mailto:alsimy.mond.travel@gmail.com">alsimy.mond.travel@gmail.com</a>
            <br>
            FACTURA FISCALA O VEȚI PRIMI PE E-MAIL
    </div>
</body>

</html>
    