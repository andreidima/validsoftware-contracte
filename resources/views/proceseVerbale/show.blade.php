@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">Procese verbale / Nr. {{ $procesVerbal->nr_document }} - {{ $procesVerbal->client->nume ?? '' }}</h6>
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
                                    Număr Proces Verbal
                                </td>
                                <td>
                                    {{ $procesVerbal->nr_document }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Data emitere
                                </td>
                                <td>
                                    @isset($procesVerbal->data_emitere)
                                        {{ \Carbon\Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY') }}
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Firma
                                </td>
                                <td>
                                    {{ $procesVerbal->firma->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Client
                                </td>
                                <td>
                                    {{ $procesVerbal->client->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Proces Verbal:</b>
                                    <br>
                                    {{ $procesVerbal->proces_verbal }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email Subiect
                                </td>
                                <td>
                                    {{ $procesVerbal->email_subiect  }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Email text:</b>
                                    <br>
                                    {{ $procesVerbal->email_text }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary btn-sm rounded-pill" href="/procese-verbale">Pagină Procese Verbale</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
