@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class=" mb-0">Emailuri Clienți</h4>
            </div>
            <div class="col-lg-6">
                {{-- <form class="needs-validation" novalidate method="GET" action="{{ route('clienti.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('clienti.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form> --}}
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th class="text-center w-50">Clienți firmă</th>
                            <th class="text-center w-50">Clienți service</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @foreach ($clienti as $client)
                                @php
                                    $client->email = str_replace(",", "<br>", $client->email);
                                @endphp
                                    @if (strpos($client->email, '@') && strpos($client->email, '.'))
                                        {!! $client->email !!}
                                        <br>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($serviceClienti as $client)
                                @php
                                    $client->email = str_replace(",", "<br>", $client->email);
                                @endphp
                                    @if (strpos($client->email, '@') && strpos($client->email, '.'))
                                        {!! $client->email !!}
                                        <br>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
