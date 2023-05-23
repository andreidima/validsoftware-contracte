@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h6>Chat GPT - interogari OAI</h6>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="small" style="padding:2rem">
                            <th>#</th>
                            <th>Prompt trimis</th>
                            <th>Răspuns primit</th>
                            <th>Context</th>
                            <th>Data</th>
                            {{-- <th class="text-center">Acțiuni</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($raspunsuri as $raspuns)
                            <tr>
                                <td align="">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $raspuns->prompt_trimis }}
                                </td>
                                <td>
                                    {{ $raspuns->raspuns_primit }}
                                </td>
                                <td>
                                    {{ $raspuns->context }}
                                </td>
                                <td>
                                    {{ $raspuns->created_at ? \Carbon\Carbon::parse($raspuns->created_at)->isoFormat('DD.MM.YYYY HH:mm') : '' }}
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
                        {{$raspunsuri->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
