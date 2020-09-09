@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('service.fise.index') }}"><i class="fas fa-file-invoice mr-1"></i></i>Fișe service</a>
                </h4>
            </div> 
            <div class="col-lg-5" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('service.fise.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center">
                        <div class="col-md-4 px-1">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_numar" name="search_numar" placeholder="Număr fișă" autofocus
                                    value="{{ $search_numar }}">
                        </div>
                        <div class="col-md-8 px-1">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_nume" name="search_nume" placeholder="Firma"
                                    value="{{ $search_nume }}">
                        </div>
                        <div class="col-md-6 px-1">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-6 px-1">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('service.fise.index') }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right align-self-center">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('service.fise.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă fișă service
                </a>
            </div> 
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Nr. Intrare</th>
                            <th>Nr. Ieșire</th>
                            <th>Client</th>
                            <th class="text-right">Data recepție</th>
                            <th class="text-right">Data ridicare</th>
                            <th class="text-center">Fișă intrare</th>
                            <th class="text-center">Fișă ieșire</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($service_fise as $service_fisa) 
                            <tr>                  
                                <td align="">
                                    {{ ($service_fise ->currentpage()-1) * $service_fise ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{ $service_fisa->nr_intrare }}
                                </td>
                                <td>
                                    {{ $service_fisa->nr_iesire }}
                                </td>
                                <td>
                                    {{ $service_fisa->client->nume ?? '' }}
                                </td>
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($service_fisa->data_receptie)->isoFormat('DD.MM.YYYY') ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($service_fisa->data_ridicare)->isoFormat('DD.MM.YYYY') ?? '' }}
                                </td>
                                <td class="text-center">                                    
                                    <div class="d-flex justify-content-center mr-2">
                                        <a href="{{ $service_fisa->path() }}/export/fisa-word-intrare"
                                            class="flex mr-1"    
                                        >
                                            <span class="badge badge-success">Word</span>
                                        </a> 
                                        <a href="{{ $service_fisa->path() }}/export/fisa-pdf-intrare"
                                            class="flex mr-1"    
                                        >
                                            <span class="badge badge-light text-danger border border-danger">Pdf</span>
                                        </a> 
                                        <div style="" class="text-center">
                                            <a 
                                                href="#" 
                                                data-toggle="modal" 
                                                data-target="#trimiteEmail{{ $service_fisa->nr_intrare }}"
                                                title="trimite email"
                                                class="mr-1"
                                                >
                                                <span class="badge badge-primary">Email
                                                    <span class="badge badge-light" title="Emailuri trimise până acum">
                                                        {{ $service_fisa->mesaje_trimise_fisa_intrare()->count() }}
                                                    </span>
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteEmail{{ $service_fisa->nr_intrare }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișa de intrare: <b>{{ $service_fisa->nr_intrare }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să trimiți emailul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                            
                                                            <form method="POST" action="{{ $service_fisa->path() }}/fisa-intrare/trimite-email">
                                                                {{-- @method('DELETE')   --}}
                                                                @csrf   
                                                                <button 
                                                                    type="submit" 
                                                                    class="btn btn-primary"  
                                                                    >
                                                                    Trimite email
                                                                </button>                    
                                                            </form>
                                                        
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>  
                                        <div style="" class="text-center">
                                            <a class="" data-toggle="collapse" href="#collapseSMSFisaIntrare{{ $service_fisa->id }}" role="button" 
                                                aria-expanded="false" aria-controls="collapseSMSFisaIntrare{{ $service_fisa->id }}">
                                                    <span class="badge badge-primary">SMS
                                                        <span class="badge badge-light" title="SMS-uri trimise până acum">
                                                            {{ $service_fisa->sms_trimise_fisa_intrare_cu_succes()->count() }}
                                                        </span>
                                                    </span>
                                            </a>
                                        </div> 
                                    </div>
                                </td>
                                <td class="text-center">             
                                    {{-- <div class="d-flex justify-content-center align-items-end">    --}}
                                    <div class="d-flex align-self-center align-items-start mr-2">                     
                                        <a href="{{ $service_fisa->path() }}/export/fisa-word-iesire"
                                            class="mr-1"    
                                        >
                                            <span class="badge badge-success">Word</span>
                                        </a>                                        
                                        <a href="{{ $service_fisa->path() }}/export/fisa-pdf-iesire"
                                            class="mr-1"    
                                        >
                                            <span class="badge badge-light text-danger border border-danger">Pdf</span>
                                        </a>
                                        <div style="" class="text-center">
                                            <a 
                                                href="#" 
                                                data-toggle="modal" 
                                                data-target="#trimiteEmail{{ $service_fisa->nr_iesire }}"
                                                title="trimite email"
                                                class="mr-1"
                                                >
                                                <span class="badge badge-primary">Email
                                                    <span class="badge badge-light" title="Mesaje trimise până acum">
                                                        {{ $service_fisa->mesaje_trimise_fisa_iesire()->count() }}
                                                    </span>
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteEmail{{ $service_fisa->nr_iesire }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișa de ieșire: <b>{{ $service_fisa->nr_iesire }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să trimiți emailul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                            
                                                            <form method="POST" action="{{ $service_fisa->path() }}/fisa-iesire/trimite-email">
                                                                {{-- @method('DELETE')   --}}
                                                                @csrf   
                                                                <button 
                                                                    type="submit" 
                                                                    class="btn btn-primary"  
                                                                    >
                                                                    Trimite email
                                                                </button>                    
                                                            </form>
                                                        
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>  
                                        <div style="" class="text-center">
                                            <a class="" data-toggle="collapse" href="#collapseSMSFisaIesire{{ $service_fisa->id }}" role="button" 
                                                aria-expanded="false" aria-controls="collapseSMSFisaIesire{{ $service_fisa->id }}">
                                                    <span class="badge badge-primary">SMS
                                                        <span class="badge badge-light" title="SMS-uri trimise până acum">
                                                            {{ $service_fisa->sms_trimise_fisa_iesire_cu_succes()->count() }}
                                                        </span>
                                                    </span>
                                            </a>
                                        </div> 
                                    </div>
                                </td>
                                <td class="d-flex justify-content-end"> 
                                    <a href="{{ $service_fisa->path() }}"
                                        class="flex mr-1"    
                                    >
                                        <span class="badge badge-success">Vizualizează</span>
                                    </a> 
                                    <a href="{{ $service_fisa->path() }}/modifica"
                                        class="flex mr-1"    
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>                                   
                                    {{-- <a href="/produse/generare-factura-client/{{ $factura->id }}/export-pdf"
                                    >
                                        <span class="badge badge-success">
                                            <i class="fas fa-file-pdf mr-1"></i>PDF
                                        </span>
                                    </a>                                     --}}
                                    <div style="" class="">
                                        <a 
                                            href="#" 
                                            data-toggle="modal" 
                                            data-target="#stergeFișa{{ $service_fisa->id }}"
                                            title="Șterge Fișa"
                                            >
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeFișa{{ $service_fisa->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Fișa: <b>{{ $service_fisa->nr_fisa }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Fișa?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $service_fisa->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Fișa
                                                            </button>                    
                                                        </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> 
                                </td>
                            </tr> 
                            <tr class="collapse bg-white" id="collapseSMSFisaIntrare{{ $service_fisa->id }}" 
                                {{-- style="background-color:cornsilk" --}}
                            >
                                <td colspan="9">
                                    <table class="table table-sm table-striped table-hover col-lg-9 mx-auto border"
                                {{-- style="background-color:#008282" --}}
                                    > 
                                        <tr>
                                            <th colspan="4" class="text-center"> 
                                                SMS-uri Fișă Intrare
                                            </th>
                                        </tr>
                                        <tr class="collapse">
                                            <td colspan="4"></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Telefon SMS
                                            </th>
                                            <th class="text-center">
                                                Mesaj
                                            </th>
                                            <th class="text-center">
                                                Trimis
                                            </th>
                                            <th class="text-center">
                                                Data trimitere
                                            </th>
                                        </tr>
                                        @forelse ($service_fisa->sms_trimise_fisa_intrare as $sms)
                                            <tr>
                                                <td class="py-0">
                                                    {{ $sms->telefon }}
                                                </td>
                                                <td class="py-0">
                                                    {{ $sms->mesaj }}
                                                </td>
                                                <td class="py-0 text-center">                                                    
                                                    @if ($sms->trimis === 1)
                                                        <span class="text-success">DA</span>
                                                    @else
                                                        <span class="text-danger">NU</span>
                                                    @endif
                                                </td>
                                                <td class="py-0 text-center">
                                                    {{ \Carbon\Carbon::parse($sms->created_at)->isoFormat('HH:mm DD.MM.YYYY') ?? '' }}
                                                </td>
                                            </tr>
                                        @empty                                            
                                            <tr>
                                                <td colspan="4" class="py-0">
                                                    Nu au fost trimise SMS-uri pentru Fișa Intrare Service / Nr. {{ $service_fisa->nr_intrare }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </table>
                                        <div style="" class="text-center mb-4">
                                            <a 
                                                href="#" 
                                                data-toggle="modal" 
                                                data-target="#trimiteSMS{{ $service_fisa->nr_intrare }}"
                                                title="trimite sms"
                                                >
                                                <span class="badge badge-primary">Trimite SMS pentru Fișa Intrare Service / Nr. {{ $service_fisa->nr_intrare }}
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteSMS{{ $service_fisa->nr_intrare }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișa de intrare: <b>{{ $service_fisa->nr_intrare }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să trimiți sms-ul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                            
                                                            <form method="POST" 
                                                                action="/trimite-sms/{{
                                                                        'Fise'
                                                                    }}/{{ 
                                                                        'Intrare'
                                                                    }}/{{ 
                                                                        $service_fisa->id
                                                                    }}/{{ 
                                                                        $service_fisa->client->telefon ?? '0'
                                                                    }}/{{
                                                                        'Buna ziua ' . ($service_fisa->client->nume ?? '') . '. ' .
                                                                        'Echipamentul dumneavoastra a intrat in service si a fost preluat de tehnicianul nostru ' . $service_fisa->tehnician_service . '. ' .
                                                                        'O zi placuta!'
                                                                    }}">
                                                                
                                                                @csrf   
                                                                <button 
                                                                    type="submit" 
                                                                    class="btn btn-primary"  
                                                                    >
                                                                    Trimite sms
                                                                </button>                    
                                                            </form>
                                                        
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div> 
                                </td>
                            </tr>
                            <tr class="collapse">
                                <td colspan="9">  
                                </td>
                            </tr>
                            <tr class="collapse bg-white" id="collapseSMSFisaIesire{{ $service_fisa->id }}" 
                                {{-- style="background-color:cornsilk" --}}
                            >
                                <td colspan="9">
                                    <table class="table table-sm table-striped table-hover col-lg-9 mx-auto border"
                                {{-- style="background-color:#008282" --}}
                                    > 
                                        <tr>
                                            <th colspan="4" class="text-center"> 
                                                SMS-uri Fișă Ieșire
                                            </th>
                                        </tr>
                                        <tr class="collapse">
                                            <td colspan="4"></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Telefon SMS
                                            </th>
                                            <th class="text-center">
                                                Mesaj
                                            </th>
                                            <th class="text-center">
                                                Trimis
                                            </th>
                                            <th class="text-center">
                                                Data trimitere
                                            </th>
                                        </tr>
                                        @forelse ($service_fisa->sms_trimise_fisa_iesire as $sms)
                                            <tr>
                                                <td class="py-0">
                                                    {{ $sms->telefon }}
                                                </td>
                                                <td class="py-0">
                                                    {{ $sms->mesaj }}
                                                </td>
                                                <td class="py-0 text-center">                                                    
                                                    @if ($sms->trimis === 1)
                                                        <span class="text-success">DA</span>
                                                    @else
                                                        <span class="text-danger">NU</span>
                                                    @endif
                                                </td>
                                                <td class="py-0 text-center">
                                                    {{ \Carbon\Carbon::parse($sms->created_at)->isoFormat('HH:mm DD.MM.YYYY') ?? '' }}
                                                </td>
                                            </tr>
                                        @empty                                            
                                            <tr>
                                                <td colspan="4" class="py-0">
                                                    Nu au fost trimise SMS-uri pentru Fișa Ieșire Service / Nr. {{ $service_fisa->nr_iesire }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </table>
                                        <div style="" class="text-center mb-4">
                                            <a 
                                                href="#" 
                                                data-toggle="modal" 
                                                data-target="#trimiteSMS{{ $service_fisa->nr_iesire }}"
                                                title="trimite sms"
                                                >
                                                <span class="badge badge-primary">Trimite SMS pentru Fișa Ieșire Service / Nr. {{ $service_fisa->nr_iesire }}
                                                </span>
                                            </a>
                                                <div class="modal fade text-dark" id="trimiteSMS{{ $service_fisa->nr_iesire }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișa de iesire: <b>{{ $service_fisa->nr_iesire }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să trimiți sms-ul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                            
                                                            <form method="POST" 
                                                                action="/trimite-sms/{{
                                                                        'Fise'
                                                                    }}/{{ 
                                                                        'Ieșire'
                                                                    }}/{{ 
                                                                        $service_fisa->id
                                                                    }}/{{ 
                                                                        $service_fisa->client->telefon ?? '0'
                                                                    }}/{{
                                                                        'Buna ziua ' . ($service_fisa->client->nume ?? '') . '. ' .
                                                                        'Serviceul pentru echipamentul dumneavoastra a fost finalizat.' .
                                                                        'Va asteptam la Validsoftware.' .
                                                                        'O zi placuta!'
                                                                    }}">
                                                                
                                                                @csrf   
                                                                <button 
                                                                    type="submit" 
                                                                    class="btn btn-primary"  
                                                                    >
                                                                    Trimite sms
                                                                </button>                    
                                                            </form>
                                                        
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div> 
                                </td>
                            </tr>
                            <tr class="collapse">
                                <td colspan="9">  
                                </td>
                            </tr>
                        @empty
                            {{--  --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{$service_fise->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection