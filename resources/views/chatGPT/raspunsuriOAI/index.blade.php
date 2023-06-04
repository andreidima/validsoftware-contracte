@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h6>Chat GPT - raspunsuri OAI</h6>
            </div>
            {{-- <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ url()->current()  }}">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form d-flex justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-8 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ url()->current()  }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ url()->current() }}/adauga" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă produs
                </a>
            </div> --}}
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="small" style="padding:2rem">
                            <th>#</th>
                            <th>Produse</th>
                            <th>Prompt</th>
                            {{-- <th>Prompt trimis</th> --}}
                            {{-- <th>Răspuns primit</th> --}}
                            {{-- <th>Context</th> --}}
                            <th class="text-center">Data</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($raspunsuri as $raspuns)
                            <tr>
                                <td align="">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    @foreach ($raspuns->produse as $produs)
                                        <a href="{{ $produs->path() ?? '' }}">
                                            {{ $produs->nume }}
                                        </a>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($raspuns->prompt)
                                        <a href="{{ $raspuns->prompt->path() ?? '' }}">
                                            {{ $raspuns->prompt->nume ?? ''}}
                                        </a>
                                    @endif
                                </td>
                                {{-- <td>
                                    {!! $raspuns->prompt_trimis !!}
                                </td> --}}
                                {{-- <td>
                                    {!! $raspuns->raspuns_primit !!}
                                </td> --}}
                                {{-- <td>
                                    {{ $raspuns->context }}
                                </td> --}}
                                <td class="text-center">
                                    {{ $raspuns->created_at ? \Carbon\Carbon::parse($raspuns->created_at)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ $raspuns->path() }}"
                                            class="flex mr-1"
                                        >
                                            <span class="badge badge-success">Vizualizează</span>
                                        </a>
                                    </div>
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
