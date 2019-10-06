@extends ('layouts.app')

@section('content')   
<div class="container card">
        <div class="row card-header">
            <div class="col-lg-4 pl-0">
                <h4 class=" mb-0"><a href="{{ route('produse.index') }}"><i class="fas fa-list-ul mr-1"></i>Produse</a></h4>
            </div> 
            <div class="col-lg-12 p-1 mb-1">
                <form class="needs-validation" novalidate method="GET" action="{{ route('produse.index') }}">
                    @csrf                    
                    <div class="input-group custom-search-form justify-content-center">
                        <div class="d-flex flex-wrap justify-content-center">
                            <input type="text" class="form-control form-control-sm col-md-2 mx-3 mb-1" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                    value="{{ $search_nume }}">
                            <select class="custom-select custom-select-sm col-md-2 mx-3 mb-1" id="search_stare" name="search_stare"> 
                                    <option value="">Stare</option>   
                                @foreach ($lista_stari as $stare)
                                    <option value="{{ $stare->stare }}"
                                        {{ $stare->stare === $search_stare ? 'selected' : '' }}
                                    >
                                    {{ $stare->stare }}</option>
                                @endforeach 
                            </select>   
                            <select class="custom-select custom-select-sm col-md-2 mx-3 mb-1" id="search_tipFormulare" name="search_tipFormulare"> 
                                    <option value="">Tip formulare</option>   
                                @foreach ($tipuri_formulare as $tipFormulare)
                                    <option value="{{ $tipFormulare->tipFormulare }}"
                                        {{ $tipFormulare->tipFormulare === $search_tipFormulare ? 'selected' : '' }}
                                    >
                                    {{ $tipFormulare->tipFormulare }}</option>
                                @endforeach 
                            </select>
                            <select class="custom-select custom-select-sm col-md-2 mx-3 mb-1" id="search_categorie" name="search_categorie"> 
                                    <option value="">Categorie</option>   
                                @foreach ($categorii as $categorie)
                                    <option value="{{ $categorie->categorie }}"
                                        {{ $categorie->categorie === $search_categorie ? 'selected' : '' }}
                                    >
                                    {{ $categorie->categorie }}</option>
                                @endforeach 
                            </select> 
                            <select class="custom-select custom-select-sm col-md-2 mx-3 mb-1" id="search_clasa" name="search_clasa"> 
                                    <option value="">Clasa</option>   
                                @foreach ($clase as $clasa)
                                    <option value="{{ $clasa->clasa }}"
                                        {{ $clasa->clasa === $search_clasa ? 'selected' : '' }}
                                    >
                                    {{ $clasa->clasa }}</option>
                                @endforeach 
                            </select>  
                            <select class="custom-select custom-select-sm col-md-2 mx-3 mb-1" id="search_grupaDeToxicitate" name="search_grupaDeToxicitate"> 
                                    <option value="">Grupă toxicitate</option>   
                                @foreach ($grupe_toxicitate as $grupaDeToxicitate)
                                    <option value="{{ $grupaDeToxicitate->grupaDeToxicitate }}"
                                        {{ $grupaDeToxicitate->grupaDeToxicitate == $search_grupaDeToxicitate ? 'selected' : '' }}
                                    >
                                    {{ $grupaDeToxicitate->grupaDeToxicitate }}</option>
                                @endforeach 
                            </select>   
                            <input type="text" class="form-control form-control-sm col-md-2 mx-3 mb-1" id="search_producator" name="search_producator" placeholder="Producător" autofocus
                                    value="{{ $search_producator }}">
                            <input type="text" class="form-control form-control-sm col-md-2 mx-3 mb-1" id="search_substanteActive_nume" name="search_substanteActive_nume" placeholder="Substanțe active" autofocus
                                    value="{{ $search_substanteActive_nume }}">
                            <input type="text" class="form-control form-control-sm col-md-2 mx-3 mb-1" id="search_utilizari_cultura" name="search_utilizari_cultura" placeholder="Cultură utilizare" autofocus
                                    value="{{ $search_utilizari_cultura }}">
                            <select class="custom-select custom-select-sm col-md-2 mx-3 mb-1" id="search_utilizari_agent" name="search_utilizari_agent"> 
                                    <option value="">Agent</option>   
                                @foreach ($utilizari_agenti as $utilizari_agent)
                                    <option value="{{ $utilizari_agent->utilizari_agent }}"
                                        {{ $utilizari_agent->utilizari_agent === $search_utilizari_agent ? 'selected' : '' }}
                                    >
                                    {{ $utilizari_agent->utilizari_agent }}</option>
                                @endforeach 
                            </select>
                            <input type="text" class="form-control form-control-sm col-md-2 mx-3 mb-1" id="search_utilizari_nume" name="search_utilizari_nume" placeholder="Organism țintă" autofocus
                                    value="{{ $search_utilizari_nume }}">  
                            {{-- <div class="col-md-2 mx-3 px-2">
                                <div class="row mx-0"> --}}                                    
                                    {{-- <div class="col-md-2 mx-3 mb-1"></div> --}}
                                    <button class="btn btn-sm btn-primary col-md-2 mx-3 mb-1" type="submit">
                                        <i class="fas fa-search text-white mr-1"></i>Caută
                                    </button>
                                    {{-- <div class="col-md-2 mx-3 mb-1"></div> --}}
                                    <a class="btn btn-sm bg-secondary text-white col-md-2 mx-3 mb-1" href="{{ route('produse.index') }}" role="button">
                                        <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                                    </a>
                                {{-- </div>
                            </div> --}}
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12 p-1 border">
                Adaugă 2 sau 3 produse în listă pentru a le compara:
                @if (Session::get('produse_pentru_comparatie') !== null)
                    @foreach (Session::get('produse_pentru_comparatie') as $key => $produs)
                        @if ($key > 0)
                            ,
                        @endif
                        {{ $produs['nume'] }}
                    @endforeach
                @endif
                    <a class="btn btn-sm btn-primary
                            {{ ((Session::get('produse_pentru_comparatie') !== null) && (count(Session::get('produse_pentru_comparatie')) > 1)) ? 
                            '' : 'disabled' }}
                        " href="{{ route('comparatieComparaProduse') }}" role="button"             
                    >Compară produsele</a> 
                
                    <a class="btn btn-sm btn-secondary
                            {{ ((Session::get('produse_pentru_comparatie') !== null) && (count(Session::get('produse_pentru_comparatie')) > 0)) ? 
                            '' : 'disabled' }}                    
                        " href="{{ route('comparatieStergeProduse') }}" role="button"              
                    >Resetează lista</a>
            </div>
            {{-- <div class="col-lg-4 text-right my-1">
                <a class="btn btn-primary" href="/produse/adauga" role="button">Adaugă Produs</a>
            </div> --}}
        </div>

        <div class="card-body px-0">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm"> 
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Cultura utilizare</th>
                            <th>Agent</th>
                            <th>Organism țintă</th>
                            <th>Substanțe active</th>
                            <th>Stare</th>
                            <th>Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($produse as $produs) 
                            <tr>                  
                                <td align="center">
                                    {{ ($produse ->currentpage()-1) * $produse ->perpage() + $loop->index + 1 }}
                                </td>
                                <td class="" style="min-width:100px">
                                    <a href="{{ $produs->path() }}">  
                                        <b>{{ $produs->nume }}</b>
                                    </a>
                                </td>
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
                                    {{ $produs->substanteActive_nume }}
                                </td>
                                <td>
                                    {{ $produs->stare }}
                                </td>
                                <td class="d-flex">   
                                    <a  class="btn btn-sm btn-primary mr-1"
                                        href="{{ $produs->path() }}"
                                        role="button"
                                        title="Vezi fișa produsului"
                                        >
                                        Vizualizează
                                    </a>  
                                    <a  class="btn btn-sm btn-success mr-1"
                                        href="{{ $produs->path() }}/export/produs-pdf"
                                        role="button"
                                        title="Descarcă fișă produs"
                                        >
                                        <i class="fas fa-download text-white">Descarcă</i>
                                    </a>   

                                    <form class="needs-validation" novalidate method="GET" action="{{ route('comparatieAdaugaProdus') }}">
                                        @csrf                                             
                                        <input type="hidden" name="produs_id" value="{{ $produs->id }}">
                                        @if ((Session::get('produse_pentru_comparatie') !== null) && (count(Session::get('produse_pentru_comparatie')) > 2))
                                            <a class="btn btn-sm btn-primary" 
                                                href="#" 
                                                role="button"
                                                data-toggle="modal" 
                                                data-target="#compara{{ $produs->id }}"
                                                title="Compara"
                                                >Compară
                                            </a>  
                                        @else
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                Compară
                                            </button>
                                        @endif

                                            <div class="modal fade text-dark" id="compara{{ $produs->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title" id="exampleModalLabel">Comparare produse</b></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ai adăugat deja numărul maxim de produse (3), în lista de comparare.
                                                        <br>
                                                        Dacă vrei să compari alte produse,

                                                        <a class="btn btn-sm btn-secondary
                                                                {{ ((Session::get('produse_pentru_comparatie') !== null) && (count(Session::get('produse_pentru_comparatie')) > 0)) ? 
                                                                '' : 'disabled' }}                    
                                                            " href="{{ route('comparatieStergeProduse') }}" role="button"              
                                                        >Resetează lista</a>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>                
                                    </form>
                                </td>
                                {{-- <td class="text-center">
                                    {{ $produs-> }}
                                </td> --}}
                                {{-- <td class="my-0 py-1 text-center">
                                    <img src="{{ asset('images/tourist-information-symbol-iso-sign-is-1293.png') }}" 
                                        title="{{ $produs->descriere }}"
                                        height="30" class="my-1">
                                    <button type="button" class="btn btn-info btn-sm text-white" title="{{ $produs->descriere }}">
                                        <i class="fas fa-info-circle"></i>  
                                    </button>                              
                                </td> --}}
                                {{-- <td class="my-0 py-1" align="center">   
                                    <div style="width:90px;">
                                        <div style="float:right;" class="">
                                            <a class="btn btn-danger" 
                                                href="#" 
                                                role="button"
                                                data-toggle="modal" 
                                                data-target="#stergeProdus{{ $produs->id }}"
                                                title="Șterge Produsul"
                                                >
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                                <div class="modal fade text-dark" id="stergeProdus{{ $produs->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Produs: <b>{{ $produs->nume }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să ștergi produsul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                            
                                                            <form method="POST" action="{{ $produs->path() }}">
                                                                @method('DELETE')  
                                                                @csrf   
                                                                <button 
                                                                    type="submit" 
                                                                    class="btn btn-danger"  
                                                                    >
                                                                    Șterge Produsul
                                                                </button>                    
                                                            </form>
                                                        
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div> 

                                        <div style="float:right;" class="mx-1">
                                            <a class="btn btn-primary" 
                                                role="button"
                                                href="{{ $produs->path() }}/modifica"
                                                title="Editează Produsul"
                                                >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td> --}}
                            </tr>                                          
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>
                {{-- <p class="text-center">
                Pagina nr. {{$rezervari->currentPage()}}
                </p>

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$rezervari->links()}}
                    </ul>
                </nav>  --}}

                {{-- <div class="container">
                    @foreach ($produse as $produs)
                        {{ $produs->name }}
                    @endforeach
                </div> --}}

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$produse->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection