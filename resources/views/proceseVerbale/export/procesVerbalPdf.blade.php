<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Proces verbal</title>
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
            font-size: 12px;
            margin-top: 4.3cm;
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
    </style>
</head>

<body>
    <header>
        <img src="{{ asset('images/contract-header.jpg') }}" width="800px">
    </header>

    <main>

        <p style="padding:0rem; margin:0rem; text-align:center; font-size:16px">
            {{ $procesVerbal->titlu_document }}
            <br />
            nr. {{ $procesVerbal->nr_document }} /
                {{ (isset($procesVerbal->data_emitere) ? (\Carbon\Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY')) : '') }}
            <br />
            - {{ $procesVerbal->client->nume ?? '' }} -
        </p>

        <div style="height: 30px;"></div>

        <div>
            {!! $procesVerbal->proces_verbal !!}
        </div>


        <table style="margin:50px 0 0px 0">
            <tr valign="top" style="">
                <td style="border-width:0px; padding:0rem; margin:0rem; width:50%; text-align:center;">
                    Data
                    <br>
                    {{-- {{ \Carbon\Carbon::now()->isoFormat('DD.MM.YYYY') }} --}}
                    {{ (isset($procesVerbal->data_emitere) ? (\Carbon\Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY')) : '') }}
                </td>
                <td style="border-width:0px; padding:0rem; margin:0rem; width:50%; text-align:center;">
                    {{ $procesVerbal->firma->nume ?? '' }}
                    <br>
                    @if(isset($procesVerbal->firma->nume_semnatura) && file_exists('images/' . ($procesVerbal->firma->nume_semnatura ?? '')))
                        <img src="images/{{ $procesVerbal->firma->nume_semnatura ?? ''}}" width="100">
                    @endif
                </td>
            </tr>
        </table>

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


    </main>
</body>

</html>
