@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h6>Chat GPT - prompturi</h6>
            </div>
            <div class="col-lg-6">
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
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă prompt
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="small" style="padding:2rem">
                            <th>#</th>
                            <th>Nume</th>
                            <th>Categorie</th>
                            {{-- <th>Descriere</th> --}}
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($prompturi as $prompt)
                            <tr>
                                <td align="">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $prompt->nume }}
                                </td>
                                <td>
                                    {{ $prompt->categorie }}
                                </td>
                                {{-- <td>
                                    {{ $prompt->descriere }}
                                </td> --}}

                                <td class="d-flex justify-content-end">
                                    <a href="{{ $prompt->path() }}"
                                        class="flex mr-1"
                                    >
                                        <span class="badge badge-success">Vizualizează</span>
                                    </a>
                                    <a href="{{ $prompt->path() }}/modifica"
                                        class="flex mr-1"
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>
                                    <div style="flex" class="mr-1">
                                        <a
                                            href="#"
                                            data-toggle="modal"
                                            data-target="#stergePrompt{{ $prompt->id }}"
                                            title="Șterge Prompt"
                                            >
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergePrompt{{ $prompt->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Prompt: <b>{{ $prompt->nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Promptul?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                        <form method="POST" action="{{ $prompt->path() }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger"
                                                                >
                                                                Șterge Promptul
                                                            </button>
                                                        </form>

                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
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
                        {{$prompturi->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
