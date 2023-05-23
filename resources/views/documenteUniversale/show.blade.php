@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">Documente universale / Nr. {{ $documentUniversal->nr_document }} - {{ $documentUniversal->client->nume ?? '' }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                >

            @include ('errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-sm table-striped table-hover"
                                {{-- style="background-color:#008282" --}}
                        >
                            <tr>
                                <td>
                                    Număr Document universal
                                </td>
                                <td>
                                    {{ $documentUniversal->nr_document }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Data emitere
                                </td>
                                <td>
                                    @isset($documentUniversal->data_emitere)
                                        {{ \Carbon\Carbon::parse($documentUniversal->data_emitere)->isoFormat('DD.MM.YYYY') }}
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Limba
                                </td>
                                <td>
                                    @switch (intval($documentUniversal->limba))
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
                                    {{ $documentUniversal->firma->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Client
                                </td>
                                <td>
                                    {{ $documentUniversal->client->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Document universal:</b>
                                    <br>
                                    {{ $documentUniversal->document_universal }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email Subiect
                                </td>
                                <td>
                                    {{ $documentUniversal->email_subiect  }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Email text:</b>
                                    <br>
                                    {{ $documentUniversal->email_text }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary btn-sm rounded-pill" href="/documente-universale">Pagină Documente universale</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
