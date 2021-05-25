@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class=" mb-0"><a href="{{ route('generator.index') }}"><i class="fas fa-building mr-1"></i>Generator</a></h4>
            </div>
            <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ route('generator.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('generator.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('clienti.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă client
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th class="text-center" colspan="1">Magazin online</th>
                            <th class="text-center" colspan="1">Site de prezentare</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clienti as $client)
                            <tr>
                                <td align="">
                                    {{ ($clienti ->currentpage()-1) * $clienti ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <a href="{{ $client->path() }}">
                                        <b>{{ $client->nume }}</b>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="generator/{{$client->id}}/magazin-online/protectia-datelor-cu-caracter-personal">
                                        <span class="badge badge-info" title="Protecția datelor cu caracter personal">
                                            PDCP
                                        </span>
                                    </a>
                                    <a href="generator/{{$client->id}}/magazin-online/termeni-si-conditii">
                                        <span class="badge badge-success" title="Termeni și condiții">
                                            TC
                                        </span>
                                    </a>
                                    <a href="generator/{{$client->id}}/magazin-online/politica-de-confidentialitate">
                                        <span class="badge badge-warning" title="Politica de Confidențialitate">
                                            PC
                                        </span>
                                    </a>
                                    <a href="generator/{{$client->id}}/magazin-online/politica-cookies">
                                        <span class="badge badge-danger" title="Politica Cookies">
                                            PC
                                        </span>
                                    </a>
                                    <a href="generator/{{$client->id}}/magazin-online/politica-de-livrare">
                                        <span class="badge text-white" title="Politica de livrare" style="background-color:teal">
                                            PL
                                        </span>
                                    </a>
                                    <a href="generator/{{$client->id}}/magazin-online/politica-de-retur">
                                        <span class="badge text-white" title="Politica de retur" style="background-color:sienna">
                                            PR
                                        </span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="generator/{{$client->id}}/site-de-prezentare/protectia-datelor-cu-caracter-personal">
                                        <span class="badge badge-info" title="Protecția datelor cu caracter personal">
                                            PDCP
                                        </span>
                                    </a>
                                    <a href="generator/{{$client->id}}/site-de-prezentare/termeni-si-conditii">
                                        <span class="badge badge-success" title="Termeni și condiții">
                                            TC
                                        </span>
                                    </a>
                                    {{-- <a href="generator/{{$client->id}}/site-de-prezentare/politica-de-confidentialitate">
                                        <span class="badge badge-warning" title="Politica de Confidențialitate">
                                            PC
                                        </span>
                                    </a> --}}
                                    <a href="generator/{{$client->id}}/site-de-prezentare/politica-cookies">
                                        <span class="badge badge-danger" title="Politica Cookies">
                                            PC
                                        </span>
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
                        {{-- {{$clienti->links()}} --}}
                        {{$clienti->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
