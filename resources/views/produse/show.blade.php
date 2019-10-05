@extends ('layouts.app')

@section('content')   
    <div class="container card">
        <div class="row card-header">
                {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/produse">Produse</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $produse->nume }}</li>
                    </ol>
                </nav> --}}
                <h4 class="mb-0"><a href="{{ route('produse.index') }}"><i class="fas fa-list-ul mr-1"></i>Produse</a> / {{ $produse->nume }}</h4>
        </div>

        <div class="card-body d-flex">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive col-md-5">
                <table class="table table-striped table-hover table-dark table-sm"> 
                    <tbody>   
                        <tr>
                            <td>
                                Nume
                            </td>
                            <td>
                                {{ $produse->nume }}
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
            </div>

            <div class="table-responsive col-md-7">
                <table class="table table-striped table-hover table-sm"> 
                    <thead class="thead-dark">
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
            </div>

        </div>
    </div>
@endsection