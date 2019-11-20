<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bilet</title>
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
            padding: 0px;
            margin-top: 0px;
            border-style: solid;
            border-width: 0px;
            width: 100%;
            word-wrap:break-word;
        }
        
        th, td {
            padding: 1px 1px;
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
        min-height:600px;            
        padding: 0px 8px 0px 8px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;">

                <table style="">
                    <tr style="">
                        <td style="border-width:0px; padding:0rem; margin:0rem; width:40%">
                            <img src="{{ asset('images/logo-zuzu.png') }}" width="300px">
                        </td>
                        <td style="border-width:0px; padding:0rem; margin:0rem; width:60%; text-align:center; font-size:16px">
                            REZERVA BILET
                            <br>
                            Cod bilet: RO{{ $rezervari->id }}
                        </td>
                    </tr>
                </table>
            
                            
            <table>
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="3" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:0px 0px 2px 0px; padding:2px 0px;">
                        Informatii Calator
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="">
                        Calator: <b>{{ $rezervari->nume }}</b>
                    </td>
                    <td width="25%" style="text-align:center;">
                        Telefon: <b>{{ $rezervari->telefon }}</b>
                    </td>
                    <td width="40%" style="text-align:right;">
                        E-mail: <b>{{ $rezervari->email }}</b>
                    </td>
                </tr>
            </table>

            <table>    
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="5" style="padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 2px 0px; padding:2px 0px">
                        Informatii Rezervare bilet
                        </h3>
                    </td>
                </tr>
                <tr valign="top">
                    <td style="">
                        Data de plecare 
                        <br>
                    </td>
                    <td style="">
                        Plecare:
                        <br>
                        <br>
                        {{-- @if (!empty(auth()->user())) --}}
                            <br>
                            {{ \Carbon\Carbon::parse($rezervari->data_plecare)->isoFormat('D MMM YYYY') }}
                        {{-- @else
                            <span style="font-size:1.2rem;">
                                {{ \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervari->data_cursa)->isoFormat('dddd') }}
                            </span>
                            <br>
                            {{ \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervari->data_cursa)->isoFormat('D MMM YYYY') }}
                        @endif --}}
                    </td>
                    <td>
                        <br>
                        <img src="{{ asset('images/sageata.gif') }}" width="50px">
                    </td>
                    <td style="">
                        Debarcare:
                        <br>
                    </td>
                    <td style="">
                        Sosire:
                        <br>
                        <br>
                        
                        {{-- @else
                            <span style="font-size:1.2rem;">
                                {{ \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervari->data_cursa)
                                    ->addHours(\Carbon\Carbon::parse($rezervari->ora->ora)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->ora->ora)->minute) 
                                    ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)                               
                                    ->isoFormat('dddd') }}
                            </span>
                            <br>
                                {{ \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervari->data_cursa)
                                    ->addHours(\Carbon\Carbon::parse($rezervari->ora->ora)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->ora->ora)->minute) 
                                    ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                    ->isoFormat('D MMM YYYY') }}
                        @endif --}}
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                    </td>
                </tr>
            </table>
                            
            <table>
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="6" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 0px 0px; padding:2px 0px">
                        Calatorie | Tarif
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        Pret per adult
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        Pret per copil
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        Adulti
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        Copii
                    </td>
                    <td colspan="2" style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        Valoare
                    </td>
                </tr>
                <tr style="text-align:center">
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        {{-- {{ $rezervari->cursa->pret_adult }} lei --}}
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        {{-- {{ $rezervari->cursa->pret_copil }} lei --}}
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        {{-- {{ $rezervari->nr_adulti }} --}}
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        {{-- {{ $rezervari->nr_copii }} --}}
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        {{ $rezervari->pret_total }} lei
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        
                    </td>
                </tr>
                {{-- <tr>                    
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 5px 0 5px; text-align:right;">
                        Total
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px; text-align:center;">
                        {{ $rezervari->pret_total }} lei
                    </td>
                </tr> --}}
                <tr>                    
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 5px 0 5px; text-align:right;">
                        Achitat:
                    </td>
                </tr>
                <tr>                    
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">
                        
                    </td>
                </tr>
            </table>
                            
            <table>
                <tr style="text-align:center; font-weight:bold;">
                    <td style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 2px 0px; padding:2px 0px">
                        Operator Transport
                        </h3>
                    </td>
                </tr>
                <tr>
                </tr>
            </table>
                            
            



    </div>
</body>

</html>
    