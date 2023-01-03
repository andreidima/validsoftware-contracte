@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h6>Procese verbale</h6>
            </div>
            <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ route('procese-verbale.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Client" autofocus
                                value="{{ $search_nume }}">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('procese-verbale.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('procese-verbale.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă Proces verbal
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
                            <th class="text-center">Trimite</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($proceseVerbale as $procesVerbal)
                            <tr>
                                <td align="">
                                    {{ $procesVerbal->nr_document }}
                                </td>
                                <td>
                                    {{ $procesVerbal->client->nume ?? '' }}
                                </td>
                                <td class="text-center">
                                    @isset($procesVerbal->data_emitere)
                                        {{ \Carbon\Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY') }}
                                    @endisset
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ $procesVerbal->path() }}/export/pdf"
                                            class="flex"
                                        >
                                            <span class="badge badge-light text-danger border border-danger">Pdf</span>
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <div style="" class="text-center">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#trimiteEmail{{ $procesVerbal->id }}"
                                                title="trimite email"
                                                class="mr-1"
                                                >
                                                <span class="badge badge-primary">Email
                                                    <span class="badge badge-light" title="Emailuri trimise până acum">
                                                        {{ $procesVerbal->emailuri_trimise()->count() }}
                                                    </span>
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteEmail{{ $procesVerbal->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Procesul verbal pentru: <b>{{ $procesVerbal->client->nume ?? '' }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să trimiți emailul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST" action="{{ $procesVerbal->path() }}/trimite-email">
                                                                @csrf
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-primary"
                                                                    >
                                                                    Trimite email
                                                                </button>
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="d-flex justify-content-end">
                                    <a href="{{ $procesVerbal->path() }}"
                                        class="flex mr-1"
                                    >
                                        <span class="badge badge-success">Vizualizează</span>
                                    </a>
                                    <a href="{{ $procesVerbal->path() }}/modifica"
                                        class="flex mr-1"
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>
                                    <div style="flex" class="mr-1">
                                        <a
                                            href="#"
                                            data-toggle="modal"
                                            data-target="#stergeProcesVerbal{{ $procesVerbal->id }}"
                                            title="Șterge Proces Verbal"
                                            >
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeProcesVerbal{{ $procesVerbal->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Proces Verbal: <b>{{ $procesVerbal->nr_document }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Procesul Verbal?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                        <form method="POST" action="{{ $procesVerbal->path() }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger"
                                                                >
                                                                Șterge Procesul Verbal
                                                            </button>
                                                        </form>

                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <a href="{{ $procesVerbal->path() }}/duplica"
                                        class="flex"
                                    >
                                        <span class="badge badge-secondary">Duplică</span>
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
                        {{$proceseVerbale->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
