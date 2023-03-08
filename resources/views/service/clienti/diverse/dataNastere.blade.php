@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">
                        <i class="fas fa-building mr-1"></i>
                        Clienți = {{ $clienti->count() }}
                        |
                        Date de naștere
                        | Sortare după lună și zi
                    </h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >

                    @include ('errors')

                    <div class="row">
                        <div class="col-lg-5 py-3 mx-auto">

                            <div class="table-responsive rounded">
                                <table class="table table-striped table-hover table-sm rounded">
                                    <thead class="text-white rounded" style="background-color:#e66800;">
                                        <tr class="" style="padding:2rem">
                                            <th>#</th>
                                            <th>Nume</th>
                                            <th class="text-center">Zi</th>
                                            <th class="text-center">Lună</th>
                                            <th class="text-center">An</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($clienti as $client)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $client->nume }}
                                            </td>
                                            <td class="text-center">
                                                {{ $client->dataNastereZiua }}
                                            </td>
                                            <td class="text-center">
                                                {{ $client->dataNastereLuna }}
                                            </td>
                                            <td class="text-center">
                                                {{ $client->dataNastereAn }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
