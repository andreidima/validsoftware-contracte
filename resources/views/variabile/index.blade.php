@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class=" mb-0"><a href="{{ route('variabile.index') }}"><i class="fas fa-calendar-check mr-1"></i>Variabile</a></h4>
            </div> 
        </div>

        <div class="card-body px-0 py-3">

            <div class="row">
                <div class="col-lg-12">
                    @include('errors')
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="table-responsive rounded col-lg-8">
                    <table class="table table-striped table-hover table-sm rounded"> 
                        <thead class="text-white rounded" style="background-color:#e66800;">
                            <tr class="small" style="padding:2rem">
                                <th>Nr. Crt.</th>
                                <th>Variabilă</th>
                                <th>Valoare</th>
                                <th class="text-right">Acțiuni</th>
                            </tr>
                        </thead>
                        <tbody>               
                            @forelse ($variabile as $variabila) 
                                <tr>                  
                                    <td align="">
                                        {{ ($variabile ->currentpage()-1) * $variabile ->perpage() + $loop->index + 1 }}
                                    </td>             
                                    <td>
                                        {{ ($variabila->nume == 'nr_document') ? 'Numărul viitorului document' : $variabila->nume }}
                                    </td>
                                    <td>
                                        {{ $variabila->valoare }}
                                    </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="{{ $variabila->path() }}/modifica"
                                            class="flex"    
                                        >
                                            <span class="badge badge-primary">Modifică</span>
                                        </a> 
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
                        {{$variabile->links()}}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection