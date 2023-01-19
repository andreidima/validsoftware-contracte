@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class=" mb-0"><a href="{{ route('contracte.index') }}"><i class="fas fa-handshake mr-1"></i>Contracte</a></h4>
            </div>
            <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ route('contracte.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Client" autofocus
                                value="{{ $search_nume }}">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('contracte.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('contracte.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă contract
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="small" style="padding:2rem">
                            <th>Nr. Contract.</th>
                            <th>Client</th>
                            <th class="text-center">Dată contract</th>
                            <th class="text-center">Dată începere</th>
                            <th class="text-center">Anexa</th>
                            <th class="text-center">Descarcă Contract</th>
                            <th class="text-center">Trimite</th>
                            <th class="text-center">Fișiere atașate</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contracte as $contract)
                            <tr>
                                <td align="">
                                    {{ $contract->contract_nr }}
                                </td>
                                <td>
                                    {{ $contract->client->nume ?? '' }}
                                </td>
                                <td class="text-center">
                                    @isset($contract->contract_data)
                                        {{ \Carbon\Carbon::parse($contract->contract_data)->isoFormat('DD.MM.YYYY') }}
                                    @endisset
                                    {{-- <a class="" data-toggle="collapse" href="#collapse{{ $contract->id }}" role="button"
                                        aria-expanded="false" aria-controls="collapse{{ $contract->id }}">
                                        <b>{{ $contract->nume }}</b>
                                    </a> --}}
                                </td>
                                <td class="text-center">
                                    @isset($contract->data_incepere)
                                        {{ \Carbon\Carbon::parse($contract->data_incepere)->isoFormat('DD.MM.YYYY') }}
                                    @endisset
                                </td>
                                <td class="text-center">
                                    @isset($contract->anexa)
                                        <span class="badge badge-success">DA</span>
                                    @else
                                        <span class="badge badge-secondary">NU</span>
                                    @endisset
                                </td>
                                <td class="text-center">
                                    <a href="{{ $contract->path() }}/export/contract-word"
                                        class="flex"
                                    >
                                        <span class="badge badge-success"><i class="fas fa-download mr-1"></i>Word</span>
                                    </a>
                                    <a href="{{ $contract->path() }}/export/pdf/contract-pdf"
                                        class="flex"
                                    >
                                        <span class="badge badge-light text-danger border border-danger">Pdf</span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <div style="" class="text-center">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#trimiteEmail{{ $contract->id }}"
                                                title="trimite email"
                                                class="mr-1"
                                                >
                                                <span class="badge badge-primary">Email
                                                    <span class="badge badge-light" title="Emailuri trimise până acum">
                                                        {{ $contract->emailuri_trimise()->count() }}
                                                    </span>
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteEmail{{ $contract->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-success">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Oferta pentru: <b>{{ $contract->client->nume ?? '' }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să trimiți emailul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST" action="{{ $contract->path() }}/trimite-email">
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
                                <td class="text-center">
                                    <div style="flex" class="">
                                        @if ($contract->fisiere_count > 0)
                                            <a class="" data-toggle="collapse" href="#collapseFisiere{{ $contract->id }}" role="button"
                                                aria-expanded="false" aria-controls="collapseFisiere{{ $contract->id }}">
                                                <span class="badge badge-primary">{{ $contract->fisiere_count }}</span>
                                            </a>
                                        @else
                                            <span class="badge badge-secondary">0</span>
                                        @endif
                                        <a
                                            {{-- class="btn btn-danger btn-sm"  --}}
                                            href="#"
                                            {{-- role="button" --}}
                                            data-toggle="modal"
                                            data-target="#incarcaFisier{{ $contract->id }}"
                                            title="incarca Fisier"
                                            >
                                            {{-- <i class="far fa-trash-alt"></i> --}}
                                            <span class="badge badge-success"><i class="fas fa-plus-square"></i></span>
                                        </a>
                                            <div class="modal fade text-dark" id="incarcaFisier{{ $contract->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-success">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Adaugă un fișier la Contract: <b>{{ $contract->contract_nr }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Adaugă un fișier la contract

                                                        <form action="{{ route('file.upload.post', $contract->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf

                                                            <div class="row">
                                                                <div class="col-md-12 d-flex">
                                                                    <input type="file" name="fisier" class="form-control py-1">
                                                                    <button type="submit" class="btn btn-success">Upload</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ $contract->path() }}/modifica"
                                        class="flex mr-1"
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>
                                    <div style="flex" class="mr-1">
                                        <a
                                            {{-- class="btn btn-danger btn-sm"  --}}
                                            href="#"
                                            {{-- role="button" --}}
                                            data-toggle="modal"
                                            data-target="#stergeContract{{ $contract->id }}"
                                            title="Șterge Contract"
                                            >
                                            {{-- <i class="far fa-trash-alt"></i> --}}
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeContract{{ $contract->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Contract: <b>{{ $contract->contract_nr }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Contractul?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                        <form method="POST" action="{{ $contract->path() }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger"
                                                                >
                                                                Șterge Contract
                                                            </button>
                                                        </form>

                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <a href="{{ $contract->path() }}/duplica"
                                        class="flex"
                                    >
                                        <span class="badge badge-secondary">Duplică</span>
                                    </a>
                                </td>
                            </tr>
                            <tr class="collapse bg-white" id="collapseFisiere{{ $contract->id }}"
                            >
                                <td colspan="8">
                                    <table class="table table-sm table-striped table-hover col-lg-8 mx-auto border">
                                        <thead class="text-white rounded" style="background-color:#e66800;">
                                            <tr class="" style="padding:2rem">
                                                <td>
                                                    Nr. Crt.
                                                </td>
                                                <td>
                                                    Nume fișier
                                                </td>
                                                <td class="text-center">
                                                    Acțiuni
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($contract->fisiere as $fisier)
                                            <tr>
                                                <td class="py-0">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="py-0">
                                                    {{ $fisier->nume }}
                                                </td>
                                                <td class="py-0 d-flex justify-content-end">
                                                    {{-- <a href="/contracte/file-download/{{ $fisier->id }}" class="mr-4">
                                                        <span class="badge badge-success">Descarcă</span>
                                                    </a> --}}
                                                                    <form method="POST" action="{{ route('file.download', $fisier->id) }}">
                                                                        {{-- @method('DELETE')   --}}
                                                                        @csrf
                                                                        <button
                                                                            type="submit"
                                                                            class="btn btn-link py-0"
                                                                            >
                                                                            <span class="badge badge-success">Descarcă</span>
                                                                        </button>
                                                                    </form>
                                                    <a
                                                        {{-- class="btn btn-danger btn-sm"  --}}
                                                        href="#"
                                                        {{-- role="button" --}}
                                                        data-toggle="modal"
                                                        data-target="#stergeFisier{{ $fisier->id }}"
                                                        title="Șterge Fisier"
                                                        >
                                                        {{-- <i class="far fa-trash-alt"></i> --}}
                                                        <span class="badge badge-danger">Șterge</span>
                                                    </a>
                                                        <div class="modal fade text-dark" id="stergeFisier{{ $fisier->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                <div class="modal-header bg-danger">
                                                                    <h5 class="modal-title text-white" id="exampleModalLabel">Fisier: <b>{{ $fisier->nume }}</b></h5>
                                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" style="text-align:left;">
                                                                    Ești sigur ca vrei să ștergi Fișierul?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                                    <form method="POST" action="{{ $fisier->path() }}">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <button
                                                                            type="submit"
                                                                            class="btn btn-danger"
                                                                            >
                                                                            Șterge Fișier
                                                                        </button>
                                                                    </form>

                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </td>
                                            </tr>
                                        @empty

                                        @endforelse
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr class="collapse">
                                <td colspan="8">

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
                        {{$contracte->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
