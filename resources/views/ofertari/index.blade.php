@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class=" mb-0"><a href="{{ route('ofertari.index') }}"><i class="fas fa-handshake mr-1"></i>Ofertări</a></h4>
            </div> 
            <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ route('ofertari.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Client" autofocus
                                value="{{ $search_nume }}">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('ofertari.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('ofertari.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă ofertare
                </a>
            </div> 
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="small" style="padding:2rem">
                            <th>Nr. Document.</th>
                            <th>Client</th>
                            <th class="text-center">Dată emitere</th>
                            <th class="text-center">Descarcă Ofertare</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($ofertari as $ofertare) 
                            <tr>                  
                                <td align="">
                                    {{ $ofertare->nr_document }}
                                </td>             
                                <td>
                                    {{ $ofertare->client->nume ?? '' }}
                                </td>
                                <td class="text-center">
                                    @isset($ofertare->data_emitere)
                                        {{ \Carbon\Carbon::parse($ofertare->data_emitere)->isoFormat('DD.MM.YYYY') }}
                                    @endisset
                                </td>
                                <td class="text-center">                                    
                                    <a href="{{ $ofertare->path() }}/export/ofertare-word"
                                        class="flex"    
                                    >
                                        <span class="badge badge-success"><i class="fas fa-download mr-1"></i>Word</span>
                                    </a> 
                                </td>
                                
                                <td class="d-flex justify-content-end">
                                    <a href="{{ $ofertare->path() }}/modifica"
                                        class="flex"    
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>                                   
                                    <div style="flex" class="">
                                        <a 
                                            href="#" 
                                            data-toggle="modal" 
                                            data-target="#stergeOfertare{{ $ofertare->id }}"
                                            title="Șterge Ofertare"
                                            >
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeOfertare{{ $ofertare->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Ofertare: <b>{{ $ofertare->nr_document }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Ofertarea?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $ofertare->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Ofertarea
                                                            </button>                    
                                                        </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> 
                                </td>
                            </tr>                             
                            
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{$ofertari->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection