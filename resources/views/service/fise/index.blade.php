@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('service.fise.index') }}"><i class="fas fa-file-invoice mr-1"></i></i>Fișe service</a>
                </h4>
            </div>
            <div class="col-lg-8 px-4" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('service.fise.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form justify-content-center">
                        <div class="col-md-3 px-1">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0"
                            id="search_numar_intrare" name="search_numar_intrare" placeholder="Nr intrare" autofocus
                                    value="{{ $search_numar_intrare }}">
                        </div>
                        <div class="col-md-5 px-1">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0"
                            id="search_nume" name="search_nume" placeholder="Client"
                                    value="{{ $search_nume }}">
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <div class="col-md-12 px-1 d-flex align-items-center justify-content-center">
                            <div class="px-4">
                                <input type="hidden" name="search_cu_plata" value=0>
                                <input type="checkbox" class="form-check-input" name="search_cu_plata" value="1"
                                    {{ $search_cu_plata == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="search_cu_plata">Cu plată</label>
                            </div>
                            <div class="px-4">
                                <input type="hidden" name="search_gratuit" value=0>
                                <input type="checkbox" class="form-check-input" name="search_gratuit" value="1"
                                    {{ $search_gratuit == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="search_gratuit">Gratuit</label>
                            </div>
                            <div class="px-4">
                                <input type="hidden" name="search_in_lucru" value=0>
                                <input type="checkbox" class="form-check-input" name="search_in_lucru" value="1"
                                    {{ $search_in_lucru == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="search_in_lucru">În lucru</label>
                            </div>
                            <div class="px-4">
                                <input type="hidden" name="search_finalizate" value=0>
                                <input type="checkbox" class="form-check-input" name="search_finalizate" value="1"
                                    {{ $search_finalizate == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="search_finalizate">Finalizate</label>
                            </div>
                            <div class="px-4">
                                <input type="hidden" name="search_service" value=0>
                                <input type="checkbox" class="form-check-input" name="search_service" value="1"
                                    {{ $search_service == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="search_service">Service</label>
                            </div>
                            <div class="px-4">
                                <input type="hidden" name="search_donatie" value=0>
                                <input type="checkbox" class="form-check-input" name="search_donatie" value="1"
                                    {{ $search_donatie == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="search_donatie">Donație</label>
                            </div>
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <div class="col-md-4 px-1">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-4 px-1">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('service.fise.index') }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-2 text-right align-self-center">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-12" href="{{ route('service.fise.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă fișă
                </a>
            </div>

            <div class="col-lg-12 py-1 text-center">
                Fișe în lucru: cu plată = {{ $service_fise_cu_plata }}
                |
                gratuite = {{ $service_fise_gratuite }}
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. / Data</th>
                            <th>Client</th>
                            {{-- <th class="text-center">Data<br>recepție</th> --}}
                            {{-- <th class="text-center">Data<br>ridicare</th> --}}
                            <th class="text-center">Fișă intrare</th>
                            <th class="text-center">Fișă ieșire</th>
                            <th class="text-center">Personalizate</th>
                            <th class="text-center">Fișiere</th>
                            <th class="text-center">Acțiuni</th>
                            {{-- <th class="text-center">Deschidere fișă</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($service_fise as $service_fisa)
                            @if ($service_fisa->inchisa === 0)
                            <tr style="background-color:rgb(0, 82, 82); color:white">
                            @else
                            <tr>
                            @endif
                                {{-- <td align="">
                                    {{ ($service_fise ->currentpage()-1) * $service_fise ->perpage() + $loop->index + 1 }}
                                </td> --}}
                                <td>
                                    <b>{{ $service_fisa->nr_intrare }}</b>/{{ $service_fisa->nr_iesire }}
                                    <br>
                                    <small>
                                        @isset ($service_fisa->created_at)
                                            {{ \Carbon\Carbon::parse($service_fisa->created_at)->isoFormat('DD.MM.YYYY HH:mm') }}
                                        @endisset
                                    </small>
                                </td>
                                <td>
                                    {{ $service_fisa->client->nume ?? '' }}
                                    <br>
                                        <small>
                                            {{ $service_fisa->client->telefon ?? '' }}
                                        </small>
                                </td>
                                {{-- <td class="text-center">
                                    {{ \Carbon\Carbon::parse($service_fisa->data_receptie)->isoFormat('DD.MM.YYYY') ?? '' }}
                                </td> --}}
                                {{-- <td class="text-center">
                                    {{ \Carbon\Carbon::parse($service_fisa->data_ridicare)->isoFormat('DD.MM.YYYY') ?? '' }}
                                </td> --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ $service_fisa->path() }}/export/word/fisa-word-intrare"
                                            class="flex mr-1"
                                        >
                                            <span class="badge badge-success">Word</span>
                                        </a>
                                        <a href="{{ $service_fisa->path() }}/export/fisa-pdf-intrare"
                                            class="flex mr-1"
                                        >
                                            <span class="badge badge-light text-danger border border-danger">Pdf</span>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div style="" class="text-center">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#trimiteEmail{{ $service_fisa->nr_intrare }}"
                                                title="trimite email"
                                                class="mr-1"
                                                >
                                                <span class="badge badge-primary">Email
                                                    <span class="badge badge-light" title="Emailuri trimise până acum">
                                                        {{ $service_fisa->mesaje_trimise_fisa_intrare()->count() }}
                                                    </span>
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteEmail{{ $service_fisa->nr_intrare }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișa de intrare: <b>{{ $service_fisa->nr_intrare }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să trimiți emailul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST" action="{{ $service_fisa->path() }}/fisa-intrare/trimite-email">
                                                                {{-- @method('DELETE')   --}}
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
                                        <div style="" class="text-center">
                                            <a class="" data-toggle="collapse" href="#collapseSMSFisaIntrare{{ $service_fisa->id }}" role="button"
                                                aria-expanded="false" aria-controls="collapseSMSFisaIntrare{{ $service_fisa->id }}">
                                                    <span class="badge badge-primary">SMS
                                                        <span class="badge badge-light" title="SMS-uri trimise până acum">
                                                            {{ $service_fisa->sms_trimise_fisa_intrare_cu_succes()->count() }}
                                                        </span>
                                                    </span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{-- <div class="d-flex justify-content-center align-items-end">    --}}
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ $service_fisa->path() }}/export/word/fisa-word-iesire"
                                            class="mr-1"
                                        >
                                            <span class="badge badge-success">Word</span>
                                        </a>
                                        <a href="{{ $service_fisa->path() }}/export/fisa-pdf-iesire"
                                            class="mr-1"
                                        >
                                            <span class="badge badge-light text-danger border border-danger">Pdf</span>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div style="" class="text-center">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#trimiteEmail{{ $service_fisa->nr_iesire }}"
                                                title="trimite email"
                                                class="mr-1"
                                                >
                                                <span class="badge badge-primary">Email
                                                    <span class="badge badge-light" title="Mesaje trimise până acum">
                                                        {{ $service_fisa->mesaje_trimise_fisa_iesire()->count() }}
                                                    </span>
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteEmail{{ $service_fisa->nr_iesire }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișa de ieșire: <b>{{ $service_fisa->nr_iesire }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să trimiți emailul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST" action="{{ $service_fisa->path() }}/fisa-iesire/trimite-email">
                                                                {{-- @method('DELETE')   --}}
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
                                        <div style="" class="text-center">
                                            <a class="" data-toggle="collapse" href="#collapseSMSFisaIesire{{ $service_fisa->id }}" role="button"
                                                aria-expanded="false" aria-controls="collapseSMSFisaIesire{{ $service_fisa->id }}">
                                                    <span class="badge badge-primary">SMS
                                                        <span class="badge badge-light" title="SMS-uri trimise până acum">
                                                            {{ $service_fisa->sms_trimise_fisa_iesire_cu_succes()->count() }}
                                                        </span>
                                                    </span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                            <a class="mr-1" data-toggle="collapse" href="#collapseEmailFisaPersonalizat{{ $service_fisa->id }}" role="button"
                                                aria-expanded="false" aria-controls="collapseEmailFisaPersonalizat{{ $service_fisa->id }}">
                                                    <span class="badge badge-primary">Email
                                                        <span class="badge badge-light" title="Email-uri trimise până acum">
                                                            {{ $service_fisa->emailuri_trimise_fisa_personalizat()->count() }}
                                                        </span>
                                                    </span>
                                            </a>
                                            <br>
                                            <a class="" data-toggle="collapse" href="#collapseSMSFisaPersonalizat{{ $service_fisa->id }}" role="button"
                                                aria-expanded="false" aria-controls="collapseSMSFisaPersonalizat{{ $service_fisa->id }}">
                                                    <span class="badge badge-primary">SMS
                                                        <span class="badge badge-light" title="SMS-uri trimise până acum">
                                                            {{ $service_fisa->sms_trimise_fisa_personalizat_cu_succes()->count() }}
                                                        </span>
                                                    </span>
                                            </a>
                                </td>
                                <td class="text-center">
                                    <div style="flex" class="">
                                        @if ($service_fisa->fisiere_count > 0)
                                            <a class="" data-toggle="collapse" href="#collapseFisiere{{ $service_fisa->id }}" role="button"
                                                aria-expanded="false" aria-controls="collapseFisiere{{ $service_fisa->id }}">
                                                <span class="badge badge-primary">{{ $service_fisa->fisiere_count }}</span>
                                            </a>
                                        @else
                                            <span class="badge badge-secondary">0</span>
                                        @endif
                                        <a
                                            {{-- class="btn btn-danger btn-sm"  --}}
                                            href="#"
                                            {{-- role="button" --}}
                                            data-toggle="modal"
                                            data-target="#incarcaFisier{{ $service_fisa->id }}"
                                            title="incarca Fisier"
                                            >
                                            {{-- <i class="far fa-trash-alt"></i> --}}
                                            <span class="badge badge-success"><i class="fas fa-plus-square"></i></span>
                                        </a>
                                            <div class="modal fade text-dark" id="incarcaFisier{{ $service_fisa->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-success">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">
                                                            Adaugă un fișier la Fișa de service:
                                                            <b>{{ $service_fisa->nr_intrare }}</b>
                                                            -
                                                            <b>{{ $service_fisa->nr_iesire }}</b>
                                                        </h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Adaugă un fișier la Fișă

                                                        <form action="{{ route('service.file.upload.post', $service_fisa->id) }}" method="POST" enctype="multipart/form-data">
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
                                <td class="text-right">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ $service_fisa->path() }}"
                                            class="flex mr-1"
                                        >
                                            <span class="badge badge-success">Vizualizează</span>
                                        </a>
                                        <a href="{{ $service_fisa->path() }}/modifica"
                                            class="flex"
                                        >
                                            <span class="badge badge-primary">Modifică</span>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {{-- <a href="/produse/generare-factura-client/{{ $factura->id }}/export-pdf"
                                        >
                                            <span class="badge badge-success">
                                                <i class="fas fa-file-pdf mr-1"></i>PDF
                                            </span>
                                        </a>                                     --}}
                                        <div style="" class="mr-1">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#stergeFișa{{ $service_fisa->id }}"
                                                title="Șterge Fișa"
                                                >
                                                <span class="badge badge-danger">Șterge</span>
                                            </a>
                                                <div class="modal fade text-dark" id="stergeFișa{{ $service_fisa->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișa: <b>{{ $service_fisa->client->nume ?? '' }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să ștergi Fișa?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST" action="{{ $service_fisa->path() }}">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-danger"
                                                                    >
                                                                    Șterge Fișa
                                                                </button>
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div>
                                            @if ($service_fisa->inchisa === 1)
                                                <a class=""
                                                    href="#"
                                                    role="button"
                                                    data-toggle="modal"
                                                    data-target="#DeschideInchideFisa{{ $service_fisa->id }}"
                                                    title=""
                                                    >
                                                    <span class="badge badge-dark">Închisă</span>
                                                </a>
                                            @else
                                                <a class=""
                                                    href="#"
                                                    role="button"
                                                    data-toggle="modal"
                                                    data-target="#DeschideInchideFisa{{ $service_fisa->id }}"
                                                    title=""
                                                    >
                                                    <span class="badge badge-warning" style="color:black !important">Deschisă</span>
                                                </a>
                                            @endif

                                                <div class="modal fade text-dark" id="DeschideInchideFisa{{ $service_fisa->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-warning">
                                                            <h5 class="modal-title" id="exampleModalLabel">Fișă client: <b>{{ $service_fisa->client->nume ?? '' }}</b></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            @if ($service_fisa->inchisa === 1)
                                                                Ești sigur că vrei să deschizi Fișa?
                                                            @else
                                                                Ești sigur că vrei să închizi Fișă?
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST" action="{{ url('service/fise/' . $service_fisa->id . '/deschide-inchide') }}">
                                                                @method('PATCH')
                                                                @csrf
                                                                    @if ($service_fisa->inchisa === 1)
                                                                        <button type="submit" class="btn btn-warning">
                                                                            Deschide Fișa
                                                                        </button>
                                                                    @else
                                                                        <button type="submit" class="btn btn-warning">
                                                                            Închide Fișa
                                                                        </button>
                                                                    @endif
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </td>
                                {{-- <td class="text-right align-center">
                                    <small>
                                        @isset ($service_fisa->created_at)
                                            {{ \Carbon\Carbon::parse($service_fisa->created_at)->isoFormat('HH:mm - DD.MM.YYYY') }}
                                        @endisset
                                    </small>
                                </td> --}}
                            </tr>
                            <tr class="collapse bg-white" id="collapseSMSFisaIntrare{{ $service_fisa->id }}"
                                {{-- style="background-color:cornsilk" --}}
                            >
                                <td colspan="10">
                                    <table class="table table-sm table-striped table-hover col-lg-9 mx-auto border"
                                {{-- style="background-color:#008282" --}}
                                    >
                                        <tr>
                                            <th colspan="4" class="text-center">
                                                SMS-uri Fișă Intrare
                                            </th>
                                        </tr>
                                        <tr class="collapse">
                                            <td colspan="4"></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Telefon SMS
                                            </th>
                                            <th class="text-center">
                                                Mesaj
                                            </th>
                                            <th class="text-center">
                                                Trimis
                                            </th>
                                            <th class="text-center">
                                                Data trimitere
                                            </th>
                                        </tr>
                                        @forelse ($service_fisa->sms_trimise_fisa_intrare as $sms)
                                            <tr>
                                                <td class="py-0">
                                                    {{ $sms->telefon }}
                                                </td>
                                                <td class="py-0">
                                                    {{ $sms->mesaj }}
                                                </td>
                                                <td class="py-0 text-center">
                                                    @if ($sms->trimis === 1)
                                                        <span class="text-success">DA</span>
                                                    @else
                                                        <span class="text-danger">NU</span>
                                                    @endif
                                                </td>
                                                <td class="py-0 text-center">
                                                    {{ \Carbon\Carbon::parse($sms->created_at)->isoFormat('HH:mm DD.MM.YYYY') ?? '' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="py-0">
                                                    Nu au fost trimise SMS-uri pentru Fișa Intrare Service / Nr. {{ $service_fisa->nr_intrare }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </table>
                                        <div style="" class="text-center mb-4">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#trimiteSMS{{ $service_fisa->nr_intrare }}"
                                                title="trimite sms"
                                                >
                                                <span class="badge badge-primary">Trimite SMS pentru Fișa Intrare Service / Nr. {{ $service_fisa->nr_intrare }}
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteSMS{{ $service_fisa->nr_intrare }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișa de intrare: <b>{{ $service_fisa->nr_intrare }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să trimiți sms-ul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST"
                                                                action="/trimite-sms/{{
                                                                        'Fise'
                                                                    }}/{{
                                                                        'Intrare'
                                                                    }}/{{
                                                                        $service_fisa->id
                                                                    }}/{{
                                                                        $service_fisa->client->telefon ?? '0'
                                                                    }}/{{
                                                                        (
                                                                            ((\Carbon\Carbon::now()->hour > 5) && (\Carbon\Carbon::now()->hour < 9)) ?
                                                                                'Buna dimineata '
                                                                                :
                                                                                (
                                                                                    ((\Carbon\Carbon::now()->hour >= 9) && (\Carbon\Carbon::now()->hour < 18)) ?
                                                                                        'Buna ziua '
                                                                                        :
                                                                                        'Buna seara '
                                                                                )
                                                                        ) .
                                                                        ($service_fisa->client->nume ?? '') . '. ' .
                                                                        (
                                                                            ($service_fisa->consultanta_it === 1) ?
                                                                                (
                                                                                    'Solicitarea dvs. de Consultanta IT a fost preluata si este in analiza. '
                                                                                )
                                                                                :
                                                                                (
                                                                                    'Echipamentul dumneavoastra a intrat in service si a fost preluat de tehnicianul nostru ' . $service_fisa->tehnician_service . '. '
                                                                                )
                                                                        ) .
                                                                        'O zi placuta!'
                                                                    }}">

                                                                @csrf
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-primary"
                                                                    >
                                                                    Trimite sms
                                                                </button>
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                </td>
                            </tr>
                            <tr class="collapse">
                                <td colspan="10">
                                </td>
                            </tr>
                            <tr class="collapse bg-white" id="collapseSMSFisaIesire{{ $service_fisa->id }}"
                                {{-- style="background-color:cornsilk" --}}
                            >
                                <td colspan="10">
                                    <table class="table table-sm table-striped table-hover col-lg-9 mx-auto border"
                                {{-- style="background-color:#008282" --}}
                                    >
                                        <tr>
                                            <th colspan="4" class="text-center">
                                                SMS-uri Fișă Ieșire
                                            </th>
                                        </tr>
                                        <tr class="collapse">
                                            <td colspan="4"></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Telefon SMS
                                            </th>
                                            <th class="text-center">
                                                Mesaj
                                            </th>
                                            <th class="text-center">
                                                Trimis
                                            </th>
                                            <th class="text-center">
                                                Data trimitere
                                            </th>
                                        </tr>
                                        @forelse ($service_fisa->sms_trimise_fisa_iesire as $sms)
                                            <tr>
                                                <td class="py-0">
                                                    {{ $sms->telefon }}
                                                </td>
                                                <td class="py-0">
                                                    {{ $sms->mesaj }}
                                                </td>
                                                <td class="py-0 text-center">
                                                    @if ($sms->trimis === 1)
                                                        <span class="text-success">DA</span>
                                                    @else
                                                        <span class="text-danger">NU</span>
                                                    @endif
                                                </td>
                                                <td class="py-0 text-center">
                                                    {{ \Carbon\Carbon::parse($sms->created_at)->isoFormat('HH:mm DD.MM.YYYY') ?? '' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="py-0">
                                                    Nu au fost trimise SMS-uri pentru Fișa Ieșire Service / Nr. {{ $service_fisa->nr_iesire }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </table>
                                        <div style="" class="text-center mb-4">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#trimiteSMS{{ $service_fisa->nr_iesire }}"
                                                title="trimite sms"
                                                >
                                                <span class="badge badge-primary">Trimite SMS pentru Fișa Ieșire Service / Nr. {{ $service_fisa->nr_iesire }}
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteSMS{{ $service_fisa->nr_iesire }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișa de iesire: <b>{{ $service_fisa->nr_iesire }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să trimiți sms-ul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST"
                                                                action="/trimite-sms/{{
                                                                        'Fise'
                                                                    }}/{{
                                                                        'Ieșire'
                                                                    }}/{{
                                                                        $service_fisa->id
                                                                    }}/{{
                                                                        $service_fisa->client->telefon ?? '0'
                                                                    }}/{{
                                                                        (
                                                                            ((\Carbon\Carbon::now()->hour > 5) && (\Carbon\Carbon::now()->hour < 9)) ?
                                                                                'Buna dimineata '
                                                                                :
                                                                                (
                                                                                    ((\Carbon\Carbon::now()->hour >= 9) && (\Carbon\Carbon::now()->hour < 18)) ?
                                                                                        'Buna ziua '
                                                                                        :
                                                                                        'Buna seara '
                                                                                )
                                                                        ) .
                                                                        ($service_fisa->client->nume ?? '') . '. ' .
                                                                        (
                                                                            ($service_fisa->consultanta_it === 1) ?
                                                                                'Solicitarea dvs. fost finalizata - aveti detalii suplimentare in email. '
                                                                                :
                                                                                'Service-ul pentru echipamentul dumneavoastra a fost finalizat. ' .
                                                                                'Va asteptam la Validsoftware. '
                                                                        ) .
                                                                        'O zi placuta!'
                                                                    }}">

                                                                @csrf
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-primary"
                                                                    >
                                                                    Trimite sms
                                                                </button>
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                </td>
                            </tr>
                            <tr class="collapse">
                                <td colspan="10">
                                </td>
                            </tr>
                            <tr class="collapse bg-white" id="collapseEmailFisaPersonalizat{{ $service_fisa->id }}"
                                {{-- style="background-color:cornsilk" --}}
                            >
                                <td colspan="10">
                                    <table class="table table-sm table-striped table-hover col-lg-9 mx-auto border"
                                {{-- style="background-color:#008282" --}}
                                    >
                                        <tr>
                                            <th colspan="2" class="text-center">
                                                Email-uri Fișă Personalizate
                                            </th>
                                        </tr>
                                        <tr class="collapse">
                                            <td colspan="4"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">
                                                Mesaj
                                            </th>
                                            <th class="text-center">
                                                Data trimitere
                                            </th>
                                        </tr>
                                        @forelse ($service_fisa->emailuri_trimise_fisa_personalizat as $email)
                                            <tr>
                                                <td class="py-0">
                                                    {!! $email->text !!}
                                                </td>
                                                <td class="py-0 text-center">
                                                    {{ \Carbon\Carbon::parse($email->created_at)->isoFormat('HH:mm DD.MM.YYYY') ?? '' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="py-0">
                                                    Nu au fost trimise Email-uri personalizate pentru această Fișă pentru clientul {{ $service_fisa->client->nume ?? '' }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </table>
                                        <div style="" class="text-center mb-4">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#trimiteEmailPersonalizat{{ $service_fisa->id }}"
                                                title="trimite email"
                                                >
                                                <span class="badge badge-primary">Trimite Email personalizat pentru această Fișă pentru clientul {{ $service_fisa->client->nume ?? '' }}
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteEmailPersonalizat{{ $service_fisa->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișă pentru clientul {{ $service_fisa->client->nume ?? '' }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>


                                                            <form method="POST"
                                                                action="{{ $service_fisa->path()
                                                                    }}/{{
                                                                        'email-personalizat'
                                                                    }}/{{
                                                                        'trimite-email'
                                                                    }}">

                                                                <div class="modal-body" style="text-align:left;">
                                                                    <div class="form-group col-lg-12 mb-4">
                                                                        <label for="sms_personalizat" class="mb-0 pl-3">Text Email:</label>
                                                                        <textarea class="form-control {{ $errors->has('email_personalizat') ? 'is-invalid' : '' }}"
                                                                            name="email_personalizat"
                                                                            rows="8"
                                                                            ></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>


                                                                        @csrf

                                                                        <button
                                                                            type="submit"
                                                                            class="btn btn-primary"
                                                                            >
                                                                            Trimite email
                                                                        </button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                </td>
                            </tr>
                            <tr class="collapse">
                                <td colspan="10">
                                </td>
                            </tr>
                            <tr class="collapse bg-white" id="collapseSMSFisaPersonalizat{{ $service_fisa->id }}"
                                {{-- style="background-color:cornsilk" --}}
                            >
                                <td colspan="10">
                                    <table class="table table-sm table-striped table-hover col-lg-9 mx-auto border"
                                {{-- style="background-color:#008282" --}}
                                    >
                                        <tr>
                                            <th colspan="4" class="text-center">
                                                SMS-uri Fișă Personalizate
                                            </th>
                                        </tr>
                                        <tr class="collapse">
                                            <td colspan="4"></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Telefon SMS
                                            </th>
                                            <th class="text-center">
                                                Mesaj
                                            </th>
                                            <th class="text-center">
                                                Trimis
                                            </th>
                                            <th class="text-center">
                                                Data trimitere
                                            </th>
                                        </tr>
                                        @forelse ($service_fisa->sms_trimise_fisa_personalizat as $sms)
                                            <tr>
                                                <td class="py-0">
                                                    {{ $sms->telefon }}
                                                </td>
                                                <td class="py-0">
                                                    {{ $sms->mesaj }}
                                                </td>
                                                <td class="py-0 text-center">
                                                    @if ($sms->trimis === 1)
                                                        <span class="text-success">DA</span>
                                                    @else
                                                        <span class="text-danger">NU</span>
                                                    @endif
                                                </td>
                                                <td class="py-0 text-center">
                                                    {{ \Carbon\Carbon::parse($sms->created_at)->isoFormat('HH:mm DD.MM.YYYY') ?? '' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="py-0">
                                                    Nu au fost trimise SMS-uri personalizate pentru această Fișă pentru clientul {{ $service_fisa->client->nume ?? '' }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </table>
                                        <div style="" class="text-center mb-4">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#trimiteSMSPersonalizat{{ $service_fisa->id }}"
                                                title="trimite sms"
                                                >
                                                <span class="badge badge-primary">Trimite SMS personalizat pentru această Fișă pentru clientul {{ $service_fisa->client->nume ?? '' }}
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteSMSPersonalizat{{ $service_fisa->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișă pentru clientul {{ $service_fisa->client->nume ?? '' }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>


                                                            <form method="POST"
                                                                action="/trimite-sms/{{
                                                                        'Fise'
                                                                    }}/{{
                                                                        'Personalizat'
                                                                    }}/{{
                                                                        $service_fisa->id
                                                                    }}/{{
                                                                        $service_fisa->client->telefon ?? '0'
                                                                    }}/{{
                                                                        'sms_personalizat'
                                                                    }}">

                                                                <div class="modal-body" style="text-align:left;">
                                                                    <div class="form-group col-lg-12 mb-2" id="sms-personalizat">
                                                                        <label for="sms_personalizat" class="mb-0 pl-3">Text SMS:</label>
                                                                        {{-- <input
                                                                            type="text"
                                                                            class="form-control form-control-sm rounded-pill {{ $errors->has('sms_personalizat') ? 'is-invalid' : '' }}"
                                                                            name="sms_personalizat"
                                                                            placeholder=""
                                                                            value="{{ old('sms_personalizat') }}"
                                                                            required>            --}}
                                                                        <textarea class="form-control mb-1 {{ $errors->has('sms_personalizat') ? 'is-invalid' : '' }}"
                                                                            name="sms_personalizat"
                                                                            rows="4"
                                                                            {{-- placeholder="Observații" --}}
                                                                            v-model="sms_personalizat"
                                                                            ></textarea>
                                                                        <div class="text-right">
                                                                            <label for="nr_caractere" class="mb-0 pl-3">Nr. caractere:</label>
                                                                            <input class="text-right"
                                                                                style="width:40px"
                                                                                v-model="caractere"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>


                                                                        @csrf

                                                                        <button
                                                                            type="submit"
                                                                            class="btn btn-primary"
                                                                            >
                                                                            Trimite sms
                                                                        </button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                </td>
                            </tr>
                            <tr class="collapse">
                                <td colspan="10">
                                </td>
                            </tr>
                            <tr class="collapse bg-white" id="collapseFisiere{{ $service_fisa->id }}"
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
                                        @forelse ($service_fisa->fisiere as $fisier)
                                            <tr>
                                                <td class="py-0">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="py-0">
                                                    {{ $fisier->nume }}
                                                </td>
                                                <td class="py-0 d-flex justify-content-end">
                                                                    <form method="POST" action="{{ route('service.file.download', $fisier->id) }}">
                                                                        @csrf
                                                                        <button
                                                                            type="submit"
                                                                            class="btn btn-link py-0"
                                                                            >
                                                                            <span class="badge badge-success">Descarcă</span>
                                                                        </button>
                                                                    </form>
                                                    <a
                                                        href="#"
                                                        data-toggle="modal"
                                                        data-target="#stergeFisier{{ $fisier->id }}"
                                                        title="Șterge Fisier"
                                                        >
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
                                <td colspan="10">
                                </td>
                            </tr>
                        @empty
                            {{--  --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{$service_fise->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
