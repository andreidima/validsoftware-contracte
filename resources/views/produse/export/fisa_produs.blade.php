<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Fisa produs</title>
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
            border-width: 1px;
            width: 100%;
            word-wrap:break-word;
        }
        
        th, td {
            padding: 2px 5px;
            border-width: 1px;
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
                
            <h1 style="text-align:center; margin:10px 0px 0px 0px;"> Codexul Fitosanitar </h1>
            <h2 style="text-align:center; margin:10px 0px;"> Fișă de produs </h2>
            
            
                <table style="width:500px; margin-left:auto; margin-right:auto;"> 
                    <tbody>   
                        <tr>
                            <td>
                                Nume
                            </td>
                            <td style="background-color:#e7d790; color:black;">
                                <h3 style="padding:0px; margin:0px;">{{ $produse->nume }}</h3>
                            </td>
                        </tr>  
                        <tr>
                            <td>
                                Stare
                            </td>
                            <td>
                                {{ $produse->stare }}
                            </td>
                        </tr>  
                        <tr>
                            <td>
                                Grupa de Toxicitate
                            </td>
                            <td>
                                {{ $produse->grupaDeToxicitate }}
                            </td>
                        </tr>  
                        <tr>
                            <td>
                                Tip formulare
                            </td>
                            <td>
                                {{ $produse->tipFormulare }}
                            </td>
                        </tr> 
                        <tr>
                            <td>
                                Categorie
                            </td>
                            <td>
                                {{ $produse->categorie }}
                            </td>
                        </tr> 
                        <tr>
                            <td>
                                Clasa
                            </td>
                            <td>
                                {{ $produse->clasa }}
                            </td>
                        </tr> 
                        <tr>
                            <td>
                                Numar cerere
                            </td>
                            <td>
                                {{ $produse->numarCerere }}
                            </td>
                        </tr> 
                        <tr>
                            <td>
                                Numar certificat
                            </td>
                            <td>
                                {{ $produse->numarCertificat }}
                            </td>
                        </tr>  
                        <tr>
                            <td>
                                Data expirare
                            </td>
                            <td>
                                {{ $produse->dataExpirare }}
                            </td>
                        </tr>  
                        <tr>
                            <td>
                                Producator
                            </td>
                            <td>
                                {{ $produse->producator }}
                            </td>
                        </tr>  
                        <tr>
                            <td>
                                Substante active
                            </td>
                            <td>
                                {{ $produse->substanteActive_nume }}
                            </td>
                        </tr>                                  
                    </tbody>
                </table>

                <br><br>
                
                <table style="width:600px; margin-left:auto; margin-right:auto;"> 
                    <thead>
                        <tr>
                            <th>
                                Cultura
                            </th>
                            <th>
                                Agent
                            </th>
                            <th>
                                Nume
                            </th>
                            <th>
                                Doza
                            </th>
                            <th>
                                Pauza
                            </th>
                            <th>
                                Nr. tratamente
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($tratamente_tinta as $tratament_tinta)                        
                        <tr>
                            <td>
                                {{ $tratament_tinta->utilizari_cultura }}
                            </td>
                            <td>
                                {{ $tratament_tinta->utilizari_agent }}
                            </td>
                            <td>
                                {{ $tratament_tinta->utilizari_nume }}
                            </td>
                            <td>
                                {{ $tratament_tinta->utilizari_doza }}
                            </td>
                            <td>
                                {{ $tratament_tinta->utilizari_pauza }}
                            </td>
                            <td>
                                {{ $tratament_tinta->utilizari_nrTrat }}
                            </td>
                        </tr>
                    @endforeach                                 
                    </tbody>
                </table>

                <br>

    </div>
</body>

</html>
    