@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-4">
                <h4 class=" mb-0"><a href="{{ route('service.licente.index') }}"><i class="fab fa-windows mr-1"></i>Licențe</a></h4>
            </div>
            <div class="col-lg-4">
                <form class="needs-validation" novalidate method="GET" action="{{ route('service.licente.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-12 border rounded-pill" id="search_nume" name="search_nume" placeholder="Licența" autofocus
                                value="{{ $search_nume }}">
                    </div>
                    <div class="row input-group custom-search-form">
                        <button class="btn btn-sm btn-primary col-md-6 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-6 border border-dark rounded-pill" href="{{ route('service.licente.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('service.licente.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă Licență
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="small" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Licență</th>
                            <th>Link</th>
                            <th class="text-center">Cantitate disponibilă</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($licente as $licenta)
                            <tr>
                                <td align="">
                                    {{ ($licente ->currentpage()-1) * $licente ->perpage() + $loop->index + 1 }}
                                </td>
                                <td align="">
                                    {{ $licenta->nume }}
                                </td>
                                <td align="">
                                    @isset ($licenta->link)
                                        <a href="{{ $licenta->link }}" target="_blank">Accesează link licențe</a>
                                    @endisset
                                </td>
                                <td class="text-center">
                                    <form method="POST" action="{{ url('service/licente/schimba-cantitatea', $licenta->id) }}">
                                        @method('PATCH')
                                        @csrf
                                            <button type="submit" class="btn btn-sm p-0" name="action" value="minus">
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-minus"></i>
                                                </span>
                                            </button>
                                            {{ $licenta->cantitate }}
                                            <button type="submit" class="btn btn-sm p-0" name="action" value="plus">
                                                <span class="badge badge-success">
                                                    <i class="fas fa-plus"></i>
                                                </span>
                                            </button>
                                    </form>
                                </td>

                                <td class="d-flex justify-content-end">
                                    <a href="{{ $licenta->path() }}"
                                        class="flex mr-1"
                                    >
                                        <span class="badge badge-success">Vizualizează</span>
                                    </a>
                                    <a href="{{ $licenta->path() }}/modifica"
                                        class="flex mr-1"
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>
                                    <div style="flex" class="">
                                        <a
                                            href="#"
                                            data-toggle="modal"
                                            data-target="#stergeLicenta{{ $licenta->id }}"
                                            title="Șterge Licenta"
                                            >
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeLicenta{{ $licenta->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Licență: <b>{{ $licenta->nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Licența?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                        <form method="POST" action="{{ $licenta->path() }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger"
                                                                >
                                                                Șterge Licența
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
                        {{$licente->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
