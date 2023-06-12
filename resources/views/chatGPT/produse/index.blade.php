@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2">
                <h6>
                    Chat GPT<br>Produse<br>
                    (<span class="text-info" title="Nr. total de produse în căutarea curentă">{{ $produseNrTotal }}</span>)
                </h6>
            </div>
            <div class="col-lg-8">
                <form class="needs-validation" novalidate method="GET" action="{{ url()->current()  }}">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form d-flex justify-content-center">
                        <div class="col-md-5 mb-1 px-1">
                            {{-- <label for="search_site" class="mb-0 pl-3">Site:<span class="text-danger">*</span></label> --}}
                            <select name="search_site" class="custom-select-sm custom-select rounded-pill {{ $errors->has('search_site') ? 'is-invalid' : '' }}">
                                <option value="" selected>Selectează site</option>
                                @foreach ($siteuri as $site)
                                    <option value="{{ $site->id }}" {{ ($site->id === intval($search_site)) ? 'selected' : '' }}>{{ $site->nume }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-7 mb-1 px-1">
                            <input type="text" class="form-control form-control-sm border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                    value="{{ $search_nume }}">
                        </div>
                        <div class="col-md-5 mb-1 px-1 d-flex align-items-center">
                            <label class="mb-0" for="searchStoc">Stoc (interval):</label>
                            <input type="text" class="form-control form-control-sm border rounded-pill text-right" id="searchStocMinim" name="searchStocMinim" placeholder="" style="width:40px"
                                    value="{{ $searchStocMinim }}">
                            -
                            <input type="text" class="form-control form-control-sm border rounded-pill text-right" id="searchStocMaxim" name="searchStocMaxim" placeholder="" style="width:40px"
                                    value="{{ $searchStocMaxim }}">
                        </div>
                        <div class="col-md-5 mb-1 px-1 d-flex align-items-center">
                            <label class="mb-0" for="searchVanzari">Vânzări (interval):</label>
                            <input type="text" class="form-control form-control-sm border rounded-pill text-right" id="searchVanzariMinim" name="searchVanzariMinim" placeholder="" style="width:40px"
                                    value="{{ $searchVanzariMinim }}">
                            -
                            <input type="text" class="form-control form-control-sm border rounded-pill text-right" id="searchVanzariMaxim" name="searchVanzariMaxim" placeholder="" style="width:40px"
                                    value="{{ $searchVanzariMaxim }}">
                        </div>
                        <div class="col-md-2 mb-1 px-1">
                            <input type="text" class="form-control form-control-sm border rounded-pill" id="searchNrRaspunsuriOAI" name="searchNrRaspunsuriOAI" placeholder="Nr. răspunsuri"
                                    value="{{ $searchNrRaspunsuriOAI }}">
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ url()->current()  }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                {{-- </form> --}}
            </div>
            <div class="col-lg-2 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ url()->current() }}/adauga" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă produs
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        {{-- <tr>
                            <th colspan="6">
                                Total rezultate = {{ $produseNrTotal }}
                            </th>
                        </tr> --}}
                        <tr class="small" style="padding:2rem">
                            <th>#</th>
                            <th>Site</th>
                            <th>Nume</th>
                            <th>Url</th>
                            <th class="text-center">Stoc
                                    <input type="hidden" id="sortareStoc" name="sortareStoc" placeholder="sortareStoc"
                                        value="{{ $sortareStoc }}">
                                    <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-2 border-0 rounded-3" type="submit" name="butonSortareStoc">
                                        {!! ($sortareStoc === "crescator") ? "<i class='fas fa-sort'></i>" : "<i class='fas fa-sort'></i>" !!}
                                    </button>
                            </th>
                            <th class="text-center">Vânzări
                                    <input type="hidden" id="sortareVanzari" name="sortareVanzari" placeholder="sortareVanzari"
                                        value="{{ $sortareVanzari }}">
                                    <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-2 border-0 rounded-3" type="submit" name="butonSortareVanzari">
                                        {!! ($sortareVanzari === "crescator") ? "<i class='fas fa-sort'></i>" : "<i class='fas fa-sort'></i>" !!}
                                    </button>
                            </th>
                            <th class="text-center">Răspunsuri OAI</th>
                            <th class="text-center">Interogare OAI</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                </form>
                    <tbody>
                        @forelse ($produse as $produs)
                            <tr>
                                <td align="">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $produs->site->nume ?? '' }}
                                </td>
                                <td>
                                    {{ $produs->nume }}
                                </td>
                                <td>
                                    <a href="{{ $produs->url }}" target="_blank">{{ $produs->url }}
                                </td>
                                <td class="text-center">
                                    {{ $produs->stoc }}
                                </td>
                                <td class="text-center">
                                    {{ $produs->quantity }}
                                </td>
                                <td class="text-center">
                                    <form class="needs-validation" novalidate method="GET" action="/chat-gpt/raspunsuri-oai">
                                        @csrf
                                        <input type="hidden" id="searchProdusId" name="searchProdusId" value="{{ $produs->id }}">
                                        <button type="submit" class="btn btn-link p-0">
                                            {{ $produs->raspunsuri_o_a_i_count }}
                                        </button>
                                    </form>

                                    {{-- {{ $produs->raspunsuriOAI->count() }} --}}
                                </td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ $produs->path() }}/interogare-oai">
                                        <span class="badge badge-primary">Interogare OAI</span>
                                    </a>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ $produs->path() }}"
                                            class="flex mr-1"
                                        >
                                            <span class="badge badge-success">Vizualizează</span>
                                        </a>
                                        <a href="{{ $produs->path() }}/modifica"
                                            class="flex mr-1"
                                        >
                                            <span class="badge badge-primary">Modifică</span>
                                        </a>
                                        <div style="flex">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#stergeProdus{{ $produs->id }}"
                                                title="Șterge Produs"
                                                >
                                                <span class="badge badge-danger">Șterge</span>
                                            </a>
                                                <div class="modal fade text-dark" id="stergeProdus{{ $produs->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Produs: <b>{{ $produs->nume }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să ștergi Produsul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST" action="{{ $produs->path() }}">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-danger"
                                                                    >
                                                                    Șterge Produsul
                                                                </button>
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    </div></div>
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
                        {{$produse->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
