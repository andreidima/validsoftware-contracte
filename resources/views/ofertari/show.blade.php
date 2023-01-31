@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-handshake mr-1"></i>Ofertări / Nr. {{ $ofertari->nr_document }} - {{ $ofertari->client->nume ?? '' }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-sm table-striped table-hover"
                                {{-- style="background-color:#008282" --}}
                        >
                            <tr>
                                <td>
                                    Număr ofertare
                                </td>
                                <td>
                                    {{ $ofertari->nr_document }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Data emitere
                                </td>
                                <td>
                                    @isset($ofertari->data_emitere)
                                        {{ \Carbon\Carbon::parse($ofertari->data_emitere)->isoFormat('DD.MM.YYYY') }}
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Limba
                                </td>
                                <td>
                                    @switch (intval($ofertari->limba))
                                        @case (1)
                                            Română
                                            @break
                                        @case (2)
                                            Engleză
                                            @break
                                        @default
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Firma
                                </td>
                                <td>
                                    {{ $ofertari->firma->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Client
                                </td>
                                <td>
                                    {{ $ofertari->client->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Data cerere
                                </td>
                                <td>
                                    @isset($ofertari->data_cerere)
                                        {{ \Carbon\Carbon::parse($ofertari->data_cerere)->isoFormat('DD.MM.YYYY') }}
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Descriere solicitare:</b>
                                    <br>
                                    {!! $ofertari->descriere_solicitare !!}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Propunere tehnică și comercială:</b>
                                    <br>
                                    {!! $ofertari->propunere_tehnica_si_comerciala !!}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Servicii
                                </td>
                                <td>
                                    @foreach ($ofertari->servicii as $serviciu)
                                        {{ $serviciu->nume }}
                                        {{ $serviciu->pret ? ' - ' . $serviciu->pret . ' RON' : ''}}{{ $serviciu->recurenta ? '/ ' . $serviciu->recurenta : '' }}
                                        <br />
                                    @endforeach
                                </td>
                            </tr>

                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary btn-sm rounded-pill" href="/ofertari">Pagină Ofertări</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
