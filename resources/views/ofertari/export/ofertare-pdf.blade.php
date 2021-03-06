<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Ofertare</title>
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


            @php

            $html = '<p style="text-align: center;">Ofertarea Nr. <b>' . $ofertari->nr_document . '</b>' . 
                    (isset($ofertari->data_emitere) ? (' din <b>' . \Carbon\Carbon::parse($ofertari->data_emitere)->isoFormat('DD.MM.YYYY')) . '</b>' : '') .
                '</p><br />';

            $html .= '<b>Introducere</b>';

            $html .= '<p style="text-align: justify;">' .
                        '          Documentul curent reprezintă răspunsul <b>Dima P. Valentin PFA</b> la cererea de servicii primită de la <b>' . 
                        $ofertari->client->nume . '</b>, în data de <b>' . 
                        (isset($ofertari->data_cerere) ? (\Carbon\Carbon::parse($ofertari->data_cerere)->isoFormat('DD.MM.YYYY')) : '..........') . '</b>.' .
                    '</p>' .
                '<br />';

            $html .= '<b>Despre noi</b>';

            $html .= '<p style="text-align: justify;">' .
                    '          Suntem o firmă din Focșani, înființată în anul 2012, orientată pe dezvoltarea de servicii informatice și consultanță IT. ' .
                    'Produsele informatice pe care le oferim acoperă atât clienți din sectorul public/ privat din România, cât și cei de pe piața internațională (SUA, Franța, Belgia). ' .
                    'Pentru mai multe detalii legate de activitatea noastră, vă invităm să accesați secțiunea <i>Portofoliu</i> de la adresa https://validsoftware.ro' .
                '</p>' .
                '<br />';

            $html .= '<b>Echipă și scop</b>';

            $html .= '<p style="text-align: justify;">' .
                    '          Echipa noastră este formată din specialiști, absolvenți de studii superioare în domeniul IT, dar și în domenii conexe. Scopul nostru este furnizarea de servicii integrate, pentru a oferi clienților noștri creșterea competitivității și performanței activităților pe care le desfășoară.' .
                    '</p>' .
                '<br />';

            $html .= '<p style="text-align: left;">' .
                        '<b>Tehnologie</b>' .                    
                    '</p>';

            $html .= '<p style="text-align: justify;">' .
                    '          Adoptăm tehnologii de ultimă oră și ne bazăm pe spiritul de inovație al colegilor noștri. Oferim calitate și eficiență, finalizând cu succes proiectele, indiferent dacă acestea implică soluții simple sau complexe.' .
                    '</p>' .
                '<br />';

            $html .= '<p style="text-align: left;">' .
                        '<b>Ce vă oferim</b>' .                    
                    '</p>';

            $html .= '<p style="text-align: justify;">' .
                    '          Venim în întâmpinarea nevoilor dumneavoastră prin servicii de achiziționare și găzduire domenii, realizare site-uri web, dezvoltare software personalizat, promovare online, consultanță IT, precum și servicii multimedia, utilizând tehnologii de actualitate.' .
                    '</p>' .
                '<br />';  
                
            $html .= '
                    <table align="center" style="width: 100%">
                        <tr>
                            <td style="width:70%" align="center">
                            &nbsp;
                            </td>                            
                            <td style="width:30%; text-align: center;" align="center">
                                Dima P. Valentin PFA
                                <br/>
                                <img src="images/semnatura si stampila.png" width="100"/>
                            </td>
                        </tr>
                    </table>
                ';      

            $html .= '<div style="page-break-after: always;"></div>';
            $html .= '<div style="height:20px"></div>';
            // $html .= '<br /><br /><br /><br /><br /><br />';

            $html .= '<br />' .
                    '<p style="text-align: left;">' .
                        '<b>Descriere solicitare</b>' .                    
                    '</p>';

            $descriere_solicitare = str_replace('<br>', '<br/>', $ofertari->descriere_solicitare);
            
            $descriere_solicitare = str_replace('class="ql-align-right ql-direction-rtl"', 'dir="rtl"', $descriere_solicitare);

            $descriere_solicitare = str_replace('class', 'style', $descriere_solicitare);  
            
            $descriere_solicitare = str_replace('ql-size-small', 'font-size:10px;', $descriere_solicitare);  
            $descriere_solicitare = str_replace('ql-size-large', 'font-size:20px;', $descriere_solicitare);  
            $descriere_solicitare = str_replace('ql-size-huge', 'font-size:26px;', $descriere_solicitare);  

            $descriere_solicitare = str_replace('ql-align-justify', 'text-align:justify;', $descriere_solicitare);            
            $descriere_solicitare = str_replace('ql-align-center', 'text-align:center;', $descriere_solicitare);
            $descriere_solicitare = str_replace('ql-align-right', 'text-align:right;', $descriere_solicitare);

            $descriere_solicitare = str_replace('ql-indent-1', 'text-indent: 40px;', $descriere_solicitare);
            $descriere_solicitare = str_replace('ql-indent-2', 'text-indent: 80px;', $descriere_solicitare);
            $descriere_solicitare = str_replace('ql-indent-3', 'text-indent: 120px;', $descriere_solicitare);
            $descriere_solicitare = str_replace('ql-indent-4', 'text-indent: 160px;', $descriere_solicitare);
            $descriere_solicitare = str_replace('ql-indent-5', 'text-indent: 200px;', $descriere_solicitare);

            $descriere_solicitare = str_replace('color: rgb(230, 0, 0);', 'color: #ff0000;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(255, 153, 0);', 'color: #ff9900;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(255, 255, 0);', 'color: #ffff00;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(0, 138, 0);', 'color: #008a00;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(0, 102, 204);', 'color: #0066cc;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(153, 51, 255);', 'color: #9933ff;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(255, 255, 255);', 'color: #ffffff;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(250, 204, 204);', 'color: #facccc;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(255, 235, 204);', 'color: #ffebcc;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(255, 255, 204);', 'color: #ffffcc;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(204, 232, 204);', 'color: #cce8cc;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(204, 224, 245);', 'color: #cce0f5;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(235, 214, 255);', 'color: #ebd6ff;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(187, 187, 187);', 'color: #bbbbbb;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(240, 102, 102);', 'color: #f06666;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(255, 194, 102);', 'color: #ffc266;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(255, 255, 102);', 'color: #ffff66;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(102, 185, 102);', 'color: #66b966;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(102, 163, 224);', 'color: #66a3e0;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(194, 133, 255);', 'color: #c285ff;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(136, 136, 136);', 'color: #888888;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(161, 0, 0);', 'color: #a10000;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(178, 107, 0);', 'color: #b26b00;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(178, 178, 0);', 'color: #b2b200;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(0, 97, 0);', 'color: #006100;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(0, 71, 178);', 'color: #0047b2;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(107, 36, 178);', 'color: #6b24b2;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(68, 68, 68);', 'color: #444444;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(92, 0, 0);', 'color: #5c0000;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(102, 61, 0);', 'color: #663d00;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(102, 102, 0);', 'color: #666600;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(0, 55, 0);', 'color: #003700;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(0, 41, 102);', 'color: #002966;', $descriere_solicitare);
            $descriere_solicitare = str_replace('color: rgb(61, 20, 102);', 'color: #3d1466;', $descriere_solicitare);

            $descriere_solicitare = str_replace('background-color: rgb(230, 0, 0);', 'background-color: #ff0000;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(255, 153, 0);', 'background-color: #ff9900;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(255, 255, 0);', 'background-color: #ffff00;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(0, 138, 0);', 'background-color: #008a00;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(0, 102, 204);', 'background-color: #0066cc;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(153, 51, 255);', 'background-color: #9933ff;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(255, 255, 255);', 'background-color: #ffffff;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(250, 204, 204);', 'background-color: #facccc;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(255, 235, 204);', 'background-color: #ffebcc;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(255, 255, 204);', 'background-color: #ffffcc;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(204, 232, 204);', 'background-color: #cce8cc;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(204, 224, 245);', 'background-color: #cce0f5;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(235, 214, 255);', 'background-color: #ebd6ff;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(187, 187, 187);', 'background-color: #bbbbbb;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(240, 102, 102);', 'background-color: #f06666;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(255, 194, 102);', 'background-color: #ffc266;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(255, 255, 102);', 'background-color: #ffff66;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(102, 185, 102);', 'background-color: #66b966;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(102, 163, 224);', 'background-color: #66a3e0;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(194, 133, 255);', 'background-color: #c285ff;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(136, 136, 136);', 'background-color: #888888;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(161, 0, 0);', 'background-color: #a10000;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(178, 107, 0);', 'background-color: #b26b00;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(178, 178, 0);', 'background-color: #b2b200;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(0, 97, 0);', 'background-color: #006100;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(0, 71, 178);', 'background-color: #0047b2;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(107, 36, 178);', 'background-color: #6b24b2;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(68, 68, 68);', 'background-color: #444444;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(92, 0, 0);', 'background-color: #5c0000;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(102, 61, 0);', 'background-color: #663d00;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(102, 102, 0);', 'background-color: #666600;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(0, 55, 0);', 'background-color: #003700;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(0, 41, 102);', 'background-color: #002966;', $descriere_solicitare);
            $descriere_solicitare = str_replace('background-color: rgb(61, 20, 102);', 'background-color: #3d1466;', $descriere_solicitare);

            $html .= $descriere_solicitare;


            $html .= '<br />' .
                    '<p style="text-align: left;">' .
                        '<b>Propunere tehnică și comercială</b>' .                    
                    '</p>';
            

            $propunere_tehnica_si_comerciala = str_replace('<br>', '<br/>', $ofertari->propunere_tehnica_si_comerciala);
            
            $propunere_tehnica_si_comerciala = str_replace('class="ql-align-right ql-direction-rtl"', 'dir="rtl"', $propunere_tehnica_si_comerciala);

            $propunere_tehnica_si_comerciala = str_replace('class', 'style', $propunere_tehnica_si_comerciala);  
            
            $propunere_tehnica_si_comerciala = str_replace('ql-size-small', 'font-size:10px;', $propunere_tehnica_si_comerciala);  
            $propunere_tehnica_si_comerciala = str_replace('ql-size-large', 'font-size:20px;', $propunere_tehnica_si_comerciala);  
            $propunere_tehnica_si_comerciala = str_replace('ql-size-huge', 'font-size:26px;', $propunere_tehnica_si_comerciala);  

            $propunere_tehnica_si_comerciala = str_replace('ql-align-justify', 'text-align:justify;', $propunere_tehnica_si_comerciala);            
            $propunere_tehnica_si_comerciala = str_replace('ql-align-center', 'text-align:center;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-align-right', 'text-align:right;', $propunere_tehnica_si_comerciala);

            $propunere_tehnica_si_comerciala = str_replace('ql-indent-1', 'text-indent: 40px;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-indent-2', 'text-indent: 80px;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-indent-3', 'text-indent: 120px;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-indent-4', 'text-indent: 160px;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('ql-indent-5', 'text-indent: 200px;', $propunere_tehnica_si_comerciala);

            $propunere_tehnica_si_comerciala = str_replace('color: rgb(230, 0, 0);', 'color: #ff0000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 153, 0);', 'color: #ff9900;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 255, 0);', 'color: #ffff00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 138, 0);', 'color: #008a00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 102, 204);', 'color: #0066cc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(153, 51, 255);', 'color: #9933ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 255, 255);', 'color: #ffffff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(250, 204, 204);', 'color: #facccc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 235, 204);', 'color: #ffebcc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 255, 204);', 'color: #ffffcc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(204, 232, 204);', 'color: #cce8cc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(204, 224, 245);', 'color: #cce0f5;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(235, 214, 255);', 'color: #ebd6ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(187, 187, 187);', 'color: #bbbbbb;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(240, 102, 102);', 'color: #f06666;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 194, 102);', 'color: #ffc266;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(255, 255, 102);', 'color: #ffff66;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(102, 185, 102);', 'color: #66b966;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(102, 163, 224);', 'color: #66a3e0;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(194, 133, 255);', 'color: #c285ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(136, 136, 136);', 'color: #888888;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(161, 0, 0);', 'color: #a10000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(178, 107, 0);', 'color: #b26b00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(178, 178, 0);', 'color: #b2b200;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 97, 0);', 'color: #006100;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 71, 178);', 'color: #0047b2;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(107, 36, 178);', 'color: #6b24b2;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(68, 68, 68);', 'color: #444444;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(92, 0, 0);', 'color: #5c0000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(102, 61, 0);', 'color: #663d00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(102, 102, 0);', 'color: #666600;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 55, 0);', 'color: #003700;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(0, 41, 102);', 'color: #002966;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('color: rgb(61, 20, 102);', 'color: #3d1466;', $propunere_tehnica_si_comerciala);

            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(230, 0, 0);', 'background-color: #ff0000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 153, 0);', 'background-color: #ff9900;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 255, 0);', 'background-color: #ffff00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 138, 0);', 'background-color: #008a00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 102, 204);', 'background-color: #0066cc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(153, 51, 255);', 'background-color: #9933ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 255, 255);', 'background-color: #ffffff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(250, 204, 204);', 'background-color: #facccc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 235, 204);', 'background-color: #ffebcc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 255, 204);', 'background-color: #ffffcc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(204, 232, 204);', 'background-color: #cce8cc;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(204, 224, 245);', 'background-color: #cce0f5;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(235, 214, 255);', 'background-color: #ebd6ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(187, 187, 187);', 'background-color: #bbbbbb;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(240, 102, 102);', 'background-color: #f06666;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 194, 102);', 'background-color: #ffc266;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(255, 255, 102);', 'background-color: #ffff66;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(102, 185, 102);', 'background-color: #66b966;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(102, 163, 224);', 'background-color: #66a3e0;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(194, 133, 255);', 'background-color: #c285ff;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(136, 136, 136);', 'background-color: #888888;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(161, 0, 0);', 'background-color: #a10000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(178, 107, 0);', 'background-color: #b26b00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(178, 178, 0);', 'background-color: #b2b200;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 97, 0);', 'background-color: #006100;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 71, 178);', 'background-color: #0047b2;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(107, 36, 178);', 'background-color: #6b24b2;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(68, 68, 68);', 'background-color: #444444;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(92, 0, 0);', 'background-color: #5c0000;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(102, 61, 0);', 'background-color: #663d00;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(102, 102, 0);', 'background-color: #666600;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 55, 0);', 'background-color: #003700;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(0, 41, 102);', 'background-color: #002966;', $propunere_tehnica_si_comerciala);
            $propunere_tehnica_si_comerciala = str_replace('background-color: rgb(61, 20, 102);', 'background-color: #3d1466;', $propunere_tehnica_si_comerciala);

            $html .= $propunere_tehnica_si_comerciala;


            $html .='<ul>';
            foreach ($ofertari->servicii as $serviciu) {
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

                
            $html .= '
                <br /><br />
                    <table align="center" style="width: 100%">
                        <tr>
                            <td style="width:70%" align="center">
                            &nbsp;
                            </td>                            
                            <td style="width:30%; text-align: center;" align="center">
                                Dima P. Valentin PFA
                                <br/>
                                <img src="images/semnatura si stampila.png" width="100"/>
                            </td>
                        </tr>
                    </table>
                ';      

            @endphp

            {!! $html !!}
                    
    </div>
</body>

</html>
    