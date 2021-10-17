<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Proces verbal</title>
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


            <p style="padding:0rem; margin:0rem; text-align:center; font-size:16px">
                Raport de activitate
                <br />
                nr. {{ $nr_document }} / {{ \Carbon\Carbon::now()->isoFormat('DD.MM.YYYY') }}
                <br />
                - Școala Gimnazială „Ștefan cel Mare” Focșani -
            </p>

            <div style="height: 50px;"></div>

            <p style="text-indent: 50px;">
                În luna {{ \Carbon\Carbon::now()->subMonth()->isoFormat('MMMM YYYY') }}, au fost efectuate următoarele activități, pentru a asigura buna funcționare a site-ului aferent „Școlii Gimnaziale „Ștefan cel Mare” Focșani”:
            </p>

            <ul>
                <li>
                    efectuarea de copii de siguranță a datelor stocate;
                </li>
                <li>
                    suport tehnic și consultanță prin email/ telefon;
                </li>
                <li>
                    monitorizare permanentă a site-ului.
                </li>
            </ul>

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
