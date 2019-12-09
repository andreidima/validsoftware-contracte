@extends ('layouts.app')

@section('content')   
    <div class="container card">
        <div class="row card-header">
                <h4 class="mb-0"><a href="{{ route('colete.index') }}"><i class="fas fa-list-ul mr-1"></i>Colete</a> / {{ $colete->nume }}</h4>
        </div>

        <div class="card-body d-flex">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive col-md-5 mx-auto">
                <table class="table table-striped table-hover table-dark table-sm" style="background-color:#008282"> 
                    <tr>
                        <td>
                            Nume
                        </td>
                        <td>
                            {{ $colete->nume }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Telefon
                        </td>
                        <td>
                            {{ $colete->telefon }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Email
                        </td>
                        <td>
                            {{ $colete->email }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Adresa
                        </td>
                        <td>
                            {{ $colete->adresa }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Observatii
                        </td>
                        <td>
                            {{ $colete->observatii }}
                        </td>
                    </tr>
                    {{-- </tr>
                        <td>
                            Document de călătorie
                        </td>
                        <td>
                            {{ $colete->document_de_calatorie }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            <small> Data expirării documentului</small>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($colete->expirare_document)->isoFormat('D.MM.YYYY') }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Seria buletin / pașaport
                        </td>
                        <td>
                            {{ $colete->serie_document }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Cnp
                        </td>
                        <td>
                            {{ $colete->cnp }}
                        </td>
                    </tr> --}}
                    </tr>
                        <td>
                            Data rezervarii
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($colete->created_at)->isoFormat('D.MM.YYYY') }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="table-responsive col-md-3 mx-auto">
                <table class="table table-striped table-hover table-dark table-sm" style="background-color:#008282"> 
                    <tr>
                        <td>
                            Oras plecare
                        </td>
                        <td>
                            {{ $colete->oras_plecare_nume->nume }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Oras sosire
                        </td>
                        <td>
                            {{ $colete->oras_sosire_nume->nume }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Nr. colete
                        </td>
                        <td>
                            {{ $colete->numar_colete }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Detalii colete
                        </td>
                        <td>
                            {{ $colete->detalii_colete }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection