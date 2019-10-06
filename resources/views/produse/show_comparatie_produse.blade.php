@extends ('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="row card-header mx-0">
                <h4 class="mb-0"><a href="{{ route('produse.index') }}"><i class="fas fa-list-ul mr-1"></i>Produse</a></h4>
        </div>

        <div class="card-body row px-0 mx-0">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            @if (count($produse_pentru_comparatie) === 2)
                <div class="table-responsive col-md-12">
                    <table class="table table-striped table-hover table-dark table-sm" style="background-color:chocolate"> 
                        <tbody>   
                            <tr>
                                <td>
                                    Nume
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['nume'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['nume'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Stare
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['stare'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['stare'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Grupa de Toxicitate
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['grupaDeToxicitate'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['grupaDeToxicitate'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Tip formulare
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['tipFormulare'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['tipFormulare'] }}
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    Categorie
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['categorie'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['categorie'] }}
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    Clasa
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['clasa'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['clasa'] }}
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    Numar cerere
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['numarCerere'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['numarCerere'] }}
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    Numar certificat
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['numarCertificat'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['numarCertificat'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Data expirare
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['dataExpirare'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['dataExpirare'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Producator
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['producator'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['producator'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Substante active
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['substanteActive_nume'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['substanteActive_nume'] }}
                                </td>
                            </tr>                                  
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive col-md-6">
                    <table class="table table-striped table-hover table-sm"> 
                        <thead class="text-white" style="background-color:chocolate">
                            <tr>
                                <th colspan="6" class="text-center">
                                    {{ $produse_pentru_comparatie[0]['nume'] }}
                                </th>
                            </tr>
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
                        @foreach ($produse_pentru_comparatie[0]['tratamente_tinta'] as $produs)                      
                            <tr>
                                <td>
                                    {{ $produs->utilizari_cultura }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_agent }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_nume }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_doza }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_pauza }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_nrTrat }}
                                </td>
                            </tr>                        
                        @endforeach                              
                        </tbody>
                    </table>
                </div>                

                <div class="table-responsive col-md-6">
                    <table class="table table-striped table-hover table-sm"> 
                        <thead class="text-white" style="background-color:chocolate">
                            <tr>
                                <th colspan="6" class="text-center">
                                    {{ $produse_pentru_comparatie[1]['nume'] }}
                                </th>
                            </tr>
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
                        @foreach ($produse_pentru_comparatie[1]['tratamente_tinta'] as $produs)                      
                            <tr>
                                <td>
                                    {{ $produs->utilizari_cultura }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_agent }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_nume }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_doza }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_pauza }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_nrTrat }}
                                </td>
                            </tr>                        
                        @endforeach                              
                        </tbody>
                    </table>
                </div>

            @endif

            @if (count($produse_pentru_comparatie) === 3)
                <div class="table-responsive col-md-12">
                    <table class="table table-striped table-hover table-dark table-sm" style="background-color:chocolate"> 
                        <tbody>   
                            <tr>
                                <td>
                                    Nume
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['nume'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['nume'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[2]['nume'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Stare
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['stare'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['stare'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[2]['stare'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Grupa de Toxicitate
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['grupaDeToxicitate'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['grupaDeToxicitate'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[2]['grupaDeToxicitate'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Tip formulare
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['tipFormulare'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['tipFormulare'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[2]['tipFormulare'] }}
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    Categorie
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['categorie'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['categorie'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[2]['categorie'] }}
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    Clasa
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['clasa'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['clasa'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[2]['clasa'] }}
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    Numar cerere
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['numarCerere'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['numarCerere'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[2]['numarCerere'] }}
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    Numar certificat
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['numarCertificat'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['numarCertificat'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[2]['numarCertificat'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Data expirare
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['dataExpirare'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['dataExpirare'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[2]['dataExpirare'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Producator
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['producator'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['producator'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[2]['producator'] }}
                                </td>
                            </tr>  
                            <tr>
                                <td>
                                    Substante active
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[0]['substanteActive_nume'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[1]['substanteActive_nume'] }}
                                </td>
                                <td>
                                    {{ $produse_pentru_comparatie[2]['substanteActive_nume'] }}
                                </td>
                            </tr>                                  
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive col-md-4 pl-0" style="font-size: 0.7rem;">
                    <table class="table table-striped table-hover table-sm"> 
                        <thead class="text-white" style="background-color:chocolate">
                            <tr>
                                <th colspan="6" class="text-center">
                                    {{ $produse_pentru_comparatie[0]['nume'] }}
                                </th>
                            </tr>
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
                        @foreach ($produse_pentru_comparatie[0]['tratamente_tinta'] as $produs)                      
                            <tr>
                                <td>
                                    {{ $produs->utilizari_cultura }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_agent }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_nume }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_doza }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_pauza }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_nrTrat }}
                                </td>
                            </tr>                        
                        @endforeach                              
                        </tbody>
                    </table>
                </div>                

                <div class="table-responsive col-md-4 pl-0" style="font-size: 0.7rem;">
                    <table class="table table-striped table-hover table-sm"> 
                        <thead class="text-white" style="background-color:chocolate">
                            <tr>
                                <th colspan="6" class="text-center">
                                    {{ $produse_pentru_comparatie[1]['nume'] }}
                                </th>
                            </tr>
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
                        @foreach ($produse_pentru_comparatie[1]['tratamente_tinta'] as $produs)                      
                            <tr>
                                <td>
                                    {{ $produs->utilizari_cultura }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_agent }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_nume }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_doza }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_pauza }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_nrTrat }}
                                </td>
                            </tr>                        
                        @endforeach                              
                        </tbody>
                    </table>
                </div>               

                <div class="table-responsive col-md-4 pl-0" style="font-size: 0.7rem;">
                    <table class="table table-striped table-hover table-sm"> 
                        <thead class="text-white" style="background-color:chocolate">
                            <tr>
                                <th colspan="6" class="text-center">
                                    {{ $produse_pentru_comparatie[2]['nume'] }}
                                </th>
                            </tr>
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
                        @foreach ($produse_pentru_comparatie[2]['tratamente_tinta'] as $produs)                      
                            <tr>
                                <td>
                                    {{ $produs->utilizari_cultura }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_agent }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_nume }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_doza }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_pauza }}
                                </td>
                                <td>
                                    {{ $produs->utilizari_nrTrat }}
                                </td>
                            </tr>                        
                        @endforeach                              
                        </tbody>
                    </table>
                </div>

            @endif

        </div>
    </div>
@endsection