@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-4">
                <h4 class=" mb-0"><a href="{{ route('service.componente_pc.index') }}"><i class="fas fa-desktop mr-1"></i>Componente Pc</a></h4>
            </div>
            <div class="col-lg-4">
                <form class="needs-validation" novalidate method="GET" action="{{ route('service.componente_pc.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-6 border rounded-pill" id="search_nume" name="search_nume" placeholder="Componenta Pc" autofocus
                                value="{{ $search_nume }}">
                        <select class="custom-select custom-select-sm col-md-6 border rounded-pill" id="search_categorie_id" name="search_categorie_id">
                                <option value="">Categorie</option>
                            @foreach ($categorii as $categorie)
                                <option value="{{ $categorie->id }}"
                                    {{ $categorie->id == $search_categorie_id ? 'selected' : '' }}
                                >
                                {{ $categorie->nume }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row input-group custom-search-form">
                        <button class="btn btn-sm btn-primary col-md-6 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-6 border border-dark rounded-pill" href="{{ route('service.componente_pc.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('service.componente_pc.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă Componentă
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
                            <th>Componentă Pc</th>
                            <th>Categorie</th>
                            <th class="text-center">Cantitate</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($componente_pc as $componenta_pc)
                            <tr>
                                <td align="">
                                    {{ ($componente_pc ->currentpage()-1) * $componente_pc ->perpage() + $loop->index + 1 }}
                                </td>
                                <td align="">
                                    {{ $componenta_pc->nume }}
                                </td>
                                <td align="">
                                    {{ $componenta_pc->categorie->nume ?? '' }}
                                </td>
                                <td class="text-center">
                                    <form method="POST" action="{{ url('service/componente-pc/schimba-cantitatea', $componenta_pc->id) }}">
                                        @method('PATCH')
                                        @csrf
                                            <button type="submit" class="btn btn-sm p-0" name="action" value="minus">
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-minus"></i>
                                                </span>
                                            </button>
                                            {{ $componenta_pc->cantitate }}
                                            <button type="submit" class="btn btn-sm p-0" name="action" value="plus">
                                                <span class="badge badge-success">
                                                    <i class="fas fa-plus"></i>
                                                </span>
                                            </button>
                                    </form>
                                </td>

                                <td class="d-flex justify-content-end">
                                    <a href="{{ $componenta_pc->path() }}"
                                        class="flex mr-1"
                                    >
                                        <span class="badge badge-success">Vizualizează</span>
                                    </a>
                                    <a href="{{ $componenta_pc->path() }}/modifica"
                                        class="flex mr-1"
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>
                                    <div style="flex" class="">
                                        <a
                                            href="#"
                                            data-toggle="modal"
                                            data-target="#stergeComponentaPc{{ $componenta_pc->id }}"
                                            title="Șterge Componenta"
                                            >
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeComponentaPc{{ $componenta_pc->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Componentă: <b>{{ $componenta_pc->nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Componenta?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                        <form method="POST" action="{{ $componenta_pc->path() }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger"
                                                                >
                                                                Șterge Componenta
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
                        {{$componente_pc->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
