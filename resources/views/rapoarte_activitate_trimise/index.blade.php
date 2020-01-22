@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('rapoarte_activitate_trimise.index') }}"><i class="fas fa-file-import mr-1"></i>Rapoarte trimise</a>
                </h4>
            </div> 
            <div class="col-lg-8 justify-content-end" id="app1">
                <form class="needs-validation" novalidate method="GET" action="{{ route('rapoarte_activitate_trimise.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center align-self-end">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_contract_nr" name="search_contract_nr" placeholder="Număr contract" autofocus
                                    value="{{ $search_contract_nr }}">
                        </div>
                        {{-- <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_detalii" name="search_detalii" placeholder="Detalii" autofocus
                                    value="{{ $search_detalii }}">
                        </div> --}}
                        <div class="col-md-6 d-flex mb-1">
                            <label for="search_date" class="mb-0 align-self-center mr-1">Interval:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data_inceput }}"
                                nume-camp-db="search_data_inceput"
                                tip="date"
                                latime="100"
                            ></vue2-datepicker>
                            <vue2-datepicker
                                data-veche="{{ $search_data_sfarsit }}"
                                nume-camp-db="search_data_sfarsit"
                                tip="date"
                                latime="150"
                            ></vue2-datepicker>
                        </div>
                        <div class="col-md-12 text-right">
                            <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                            <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('rapoarte_activitate_trimise.index') }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="col-lg-3 text-right"> --}}
                {{-- <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('clienti.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă client
                </a> --}}
            {{-- </div>  --}}
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th class="text-center">Contract</th>
                            <th class="text-center">Nume</th>
                            <th class="text-right">Data trimiterii</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($rapoarte_activitate_trimise as $raport) 
                            <tr>                  
                                <td align="">
                                    {{ ($rapoarte_activitate_trimise ->currentpage()-1) * $rapoarte_activitate_trimise ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{ $raport->contract->contract_nr ?? '' }}
                                </td>
                                <td class="text-center">
                                    {{ $raport->nume }}
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($raport->created_at)->isoFormat('HH:MM D.MM.YYYY') ?? ''}}
                                </td>
                            </tr>  
                        @empty
                            <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div>
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{-- {{$produse_vandute->links()}} --}}
                        {{$rapoarte_activitate_trimise->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection