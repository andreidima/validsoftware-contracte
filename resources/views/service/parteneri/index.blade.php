@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class=" mb-0"><a href="{{ route('service.parteneri.index') }}"><i class="fas fa-handshake mr-1"></i>Parteneri</a></h4>
            </div> 
            <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ route('service.parteneri.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('service.parteneri.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('service.parteneri.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă partener
                </a>
            </div> 
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Telefon</th>
                            <th>Email</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($parteneri as $partener) 
                            <tr>                  
                                <td align="">
                                    {{ ($parteneri ->currentpage()-1) * $parteneri ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <a href="{{ $partener->path() }}">  
                                        <b>{{ $partener->nume }}</b>
                                    </a>
                                    {{-- <a class="" data-toggle="collapse" href="#collapse{{ $partener->id }}" role="button" 
                                        aria-expanded="false" aria-controls="collapse{{ $partener->id }}">
                                        <b>{{ $partener->nume }}</b>
                                    </a> --}}
                                </td>
                                <td>
                                    {{ $partener->telefon }}
                                </td>
                                <td>
                                    {{ $partener->email }}
                                </td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ $partener->path() }}"
                                        class="flex mr-1"    
                                    >
                                        <span class="badge badge-success">Vizualizează</span>
                                    </a> 
                                    <a href="{{ $partener->path() }}/modifica"
                                        class="flex mr-1"    
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>                                   
                                    <div style="flex" class="">
                                        <a 
                                            {{-- class="btn btn-danger btn-sm"  --}}
                                            href="#" 
                                            {{-- role="button" --}}
                                            data-toggle="modal" 
                                            data-target="#stergePartener{{ $partener->id }}"
                                            title="Șterge Partener"
                                            >
                                            {{-- <i class="far fa-trash-alt"></i> --}}
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergePartener{{ $partener->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Partener: <b>{{ $partener->nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Partenerul?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $partener->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Partener
                                                            </button>                    
                                                        </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> 
                                </td>
                            </tr>  
                            {{-- <tr class="collapse bg-white" id="collapse{{ $partener->id }}" 
                            >
                                <td colspan="6">
                                    <table class="table table-sm table-striped table-hover col-lg-6 mx-auto border"
                                    > 
                                        <tr>
                                            <td class="py-0">
                                                Nume
                                            </td>
                                            <td class="py-0">
                                                {{ $partener->nume }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Cui
                                            </td>
                                            <td class="py-0">
                                                {{ $partener->cui }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Adresa
                                            </td>
                                            <td class="py-0">
                                                {{ $partener->adresa }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Telefon
                                            </td>
                                            <td class="py-0">
                                                {{ $partener->telefon }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Email
                                            </td>
                                            <td class="py-0">
                                                {{ $partener->email }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Google maps link
                                            </td>
                                            <td class="py-0">
                                                {{ $partener->google_maps_link }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr> 
                            <tr class="collapse">
                                <td colspan="6">

                                </td>                                       
                            </tr> --}}
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{$parteneri->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection