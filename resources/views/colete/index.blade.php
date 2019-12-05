@extends ('layouts.app')

@section('content')   
<div class="container card">
        <div class="row card-header align-items-center">
            <div class="col-lg-4">
                <h4 class=" mb-0"><a href="{{ route('colete.index') }}"><i class="fas fa-list-ul mr-1"></i>Colete</a></h4>
            </div> 
            <div class="col-lg-8">
                <form class="needs-validation" novalidate method="GET" action="{{ route('rezervari.index') }}">
                    @csrf                    
                    <div class=" row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-3 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        <button class="btn btn-sm btn-primary col-md-3 mr-4 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-3 border border-dark rounded-pill" href="{{ route('rezervari.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm"> 
                    <thead class="text-white" style="background-color:brown">
                        <tr class="">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Telefon</th>
                            <th>Nr. colete.</th>
                            <th>Oraș plecare</th>
                            <th>Oraș sosire</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($colete as $colet) 
                            <tr>                  
                                <td align="">
                                    {{ ($colete ->currentpage()-1) * $colete ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <a href="{{ $colet->path() }}">  
                                        <b>{{ $colet->nume }}</b>
                                    </a>
                                </td>
                                <td>
                                    {{ $colet->telefon }}
                                </td>
                                <td>
                                    {{ $colet->numar_colete }}
                                </td>
                                <td>
                                    {{ $colet->oras_plecare_nume->nume }}
                                </td>
                                <td>
                                    {{ $colet->oras_sosire_nume->nume }}
                                </td>
                            </tr>                                          
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$colete->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection