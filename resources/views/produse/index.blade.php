@extends ('layouts.app')

@section('content')   
    <div class="container card">
        <div class="row card-header">
            <div class="col-lg-4 pl-0">
                <h4 class=" mb-0"><a href="{{ route('produse.index') }}"><i class="fas fa-list-ul mr-1"></i>Produse</a></h4>
            </div> 
            <div class="col-lg-12 my-1">
                <form class="needs-validation" novalidate method="GET" action="/produse">
                    @csrf                    
                    <div class="input-group custom-search-form justify-content-center">
                        <div class="d-flex flex-wrap justify-content-center">
                            <input type="text" class="form-control col-md-2 mx-4 mb-3" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                    value="{{ $search_nume }}">
                            <select class="custom-select col-md-2 mx-4 mb-3" id="search_stare" name="search_stare"> 
                                    <option value="">Stare</option>   
                                @foreach ($lista_stari as $stare)
                                    <option value="{{ $stare->stare }}"
                                        {{ $stare->stare === $search_stare ? 'selected' : '' }}
                                    >
                                    {{ $stare->stare }}</option>
                                @endforeach 
                            </select>   
                            <select class="custom-select col-md-2 mx-4 mb-3" id="search_tipFormulare" name="search_tipFormulare"> 
                                    <option value="">Tip formulare</option>   
                                @foreach ($tipuri_formulare as $tipFormulare)
                                    <option value="{{ $tipFormulare->tipFormulare }}"
                                        {{ $tipFormulare->tipFormulare === $search_tipFormulare ? 'selected' : '' }}
                                    >
                                    {{ $tipFormulare->tipFormulare }}</option>
                                @endforeach 
                            </select>
                            <select class="custom-select col-md-2 mx-4 mb-3" id="search_categorie" name="search_categorie"> 
                                    <option value="">Categorie</option>   
                                @foreach ($categorii as $categorie)
                                    <option value="{{ $categorie->categorie }}"
                                        {{ $categorie->categorie === $search_categorie ? 'selected' : '' }}
                                    >
                                    {{ $categorie->categorie }}</option>
                                @endforeach 
                            </select> 
                            <select class="custom-select col-md-2 mx-4 mb-3" id="search_clasa" name="search_clasa"> 
                                    <option value="">Clasa</option>   
                                @foreach ($clase as $clasa)
                                    <option value="{{ $clasa->clasa }}"
                                        {{ $clasa->clasa === $search_clasa ? 'selected' : '' }}
                                    >
                                    {{ $clasa->clasa }}</option>
                                @endforeach 
                            </select>  
                            <select class="custom-select col-md-2 mx-4 mb-3" id="search_grupaDeToxicitate" name="search_grupaDeToxicitate"> 
                                    <option value="">Grupă toxicitate</option>   
                                @foreach ($grupe_toxicitate as $grupaDeToxicitate)
                                    <option value="{{ $grupaDeToxicitate->grupaDeToxicitate }}"
                                        {{ $grupaDeToxicitate->grupaDeToxicitate == $search_grupaDeToxicitate ? 'selected' : '' }}
                                    >
                                    {{ $grupaDeToxicitate->grupaDeToxicitate }}</option>
                                @endforeach 
                            </select>   
                            <input type="text" class="form-control col-md-2 mx-4 mb-3" id="search_producator" name="search_producator" placeholder="Producător" autofocus
                                    value="{{ $search_producator }}">
                            <input type="text" class="form-control col-md-2 mx-4 mb-3" id="search_substanteActive_nume" name="search_substanteActive_nume" placeholder="Substanțe active" autofocus
                                    value="{{ $search_substanteActive_nume }}">
                            <input type="text" class="form-control col-md-2 mx-4 mb-1" id="search_utilizari_cultura" name="search_utilizari_cultura" placeholder="Cultură utilizare" autofocus
                                    value="{{ $search_utilizari_cultura }}">
                            <select class="custom-select col-md-2 mx-4 mb-1" id="search_utilizari_agent" name="search_utilizari_agent"> 
                                    <option value="">Agent</option>   
                                @foreach ($utilizari_agenti as $utilizari_agent)
                                    <option value="{{ $utilizari_agent->utilizari_agent }}"
                                        {{ $utilizari_agent->utilizari_agent === $search_utilizari_agent ? 'selected' : '' }}
                                    >
                                    {{ $utilizari_agent->utilizari_agent }}</option>
                                @endforeach 
                            </select>
                            <input type="text" class="form-control col-md-2 mx-4 mb-1" id="search_utilizari_nume" name="search_utilizari_nume" placeholder="Organism țintă" autofocus
                                    value="{{ $search_utilizari_nume }}">  
                            <div class="col-md-2 mx-4 px-0">
                                <div class="row mx-0">
                                    <button class="btn btn-primary col-md-6" type="submit">
                                        <i class="fas fa-search text-white mr-1"></i>Caută
                                    </button>
                                    <a class="btn bg-secondary text-white col-md-6" href="{{ route('produse.index') }}" role="button">
                                        <i class="far fa-trash-alt text-white mr-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                            {{-- <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search text-white">Caută</i>
                            </button>                     --}}
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="col-lg-4 text-right my-1">
                <a class="btn btn-primary" href="/produse/adauga" role="button">Adaugă Produs</a>
            </div> --}}
        </div>

        <div class="card-body">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover"> 
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Cultura utilizare</th>
                            <th>Agent</th>
                            <th>Organism tinta</th>
                            <th>Substante active</th>
                            <th>Stare</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($produse as $produs) 
                            <tr>                  
                                <td align="center">
                                    {{ ($produse ->currentpage()-1) * $produse ->perpage() + $loop->index + 1 }}
                                </td>
                                <td class="w-25">
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