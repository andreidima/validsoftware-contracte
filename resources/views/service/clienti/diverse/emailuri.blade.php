@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 pb-5">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">
                        <i class="fas fa-building mr-1"></i>
                        Clienți = {{ $clienti->count() }}
                        |
                        Se generează grupuri de câte 140 de clienți
                    </h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >

                    @include ('errors')

                    <div class="row">
                        <div class="col-lg-12">
                            @php
                                $total_clienti = 0;
                                $clienti_in_grupul_curent = 0;
                            @endphp
                            @forelse ($clienti as $client)
                                {{ $client->email }},
                                @if($loop->iteration % 140 == 0)
                                    <br><hr>
                                @endif
                            @empty
                                Nu există nici un email
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Emailuri doar pentru femei --}}
        <div class="col-md-12">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">
                        <i class="fas fa-building mr-1"></i>
                        Clienți de tip feminin = {{ $clienti->where('sex', 2)->count() }}
                        |
                        Se generează grupuri de câte 140 de clienți
                    </h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >

                    @include ('errors')

                    <div class="row">
                        <div class="col-lg-12">
                            @php
                                $total_clienti = 0;
                                $clienti_in_grupul_curent = 0;
                            @endphp
                            @forelse ($clienti->where('sex', 2) as $client)
                                {{ $client->email }},
                                @if($loop->iteration % 140 == 0)
                                    <br><hr>
                                @endif
                            @empty
                                Nu există nici un email
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
