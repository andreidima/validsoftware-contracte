@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class=" mb-0"><a href="{{ route('cron-jobs.index') }}"><i class="fas fa-calendar-check mr-1"></i>Cron jobs</a></h4>
            </div> 
            <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ route('cron-jobs.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('cron-jobs.index') }}" role="button">
                            <i class="fa fa-undo text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('cron-jobs.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă Cron job
                </a>
            </div> 
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="small" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Cron job</th>
                            <th>Client</th>
                            <th class="text-center">Fișiere atașate</th>
                            <th class="text-center">Fișiere generate</th>
                            <th class="text-center">Ziua/ora trimitere</th>
                            <th class="text-center">Stare</th>
                            <th class="text-right">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($cron_jobs as $cron_job) 
                            <tr>                  
                                <td align="">
                                    {{ ($cron_jobs ->currentpage()-1) * $cron_jobs ->perpage() + $loop->index + 1 }}
                                </td>             
                                <td>
                                    <a href="{{ $cron_job->path() }}">
                                        {{ $cron_job->nume }}
                                    </a>
                                </td>
                                <td>
                                    {{ $cron_job->client->nume }}
                                </td>
                                <td class="text-center">                              
                                    <div style="flex" class="">
                                        @if ($cron_job->fisiere_count > 0)    
                                            <a class="" data-toggle="collapse" href="#collapseFisiere{{ $cron_job->id }}" role="button" 
                                                aria-expanded="false" aria-controls="collapseFisiere{{ $cron_job->id }}">
                                                <span class="badge badge-primary">{{ $cron_job->fisiere_count }}</span>
                                            </a>
                                        @else
                                            <span class="badge badge-secondary">0</span>
                                        @endif  
                                        <a 
                                            href="#" 
                                            data-toggle="modal" 
                                            data-target="#incarcaFisier{{ $cron_job->id }}"
                                            title="incarca Fisier"
                                            >
                                            <span class="badge badge-success"><i class="fas fa-plus-square"></i></span>
                                        </a>
                                            <div class="modal fade text-dark" id="incarcaFisier{{ $cron_job->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-success">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Adaugă un fișier la Cron job: <b>{{ $cron_job->nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Adaugă un fișier la Cron job

                                                        <form action="{{ route('cronjob.file.upload.post', $cron_job->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf

                                                            <div class="row">                                                
                                                                <div class="col-md-12 d-flex">
                                                                    <input type="file" name="fisier" class="form-control py-1">
                                                                    <button type="submit" class="btn btn-success">Upload</button>
                                                                </div>                                                
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> 
                                </td>
                                <td class="text-center">
                                    @if ($cron_job->fisier_generat === 1)
                                        <span class="badge badge-success">DA</span>
                                    @else
                                        <span class="badge badge-secondary">NU</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    {{ $cron_job->ziua }}
                                    /
                                    <small>
                                    {{ $cron_job->ora ? \Carbon\Carbon::parse($cron_job->ora)->isoFormat('HH:mm') : '' }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    @if ($cron_job->stare === 1)  
                                        <a class="" 
                                            href="#" 
                                            role="button"
                                            data-toggle="modal" 
                                            data-target="#activeazaDezactiveazaCronJob{{ $cron_job->id }}"
                                            title=""
                                            >
                                            <span class="badge badge-success">Activat</span>
                                        </a>
                                    @else
                                        <a class="" 
                                            href="#" 
                                            role="button"
                                            data-toggle="modal" 
                                            data-target="#activeazaDezactiveazaCronJob{{ $cron_job->id }}"
                                            title=""
                                            >
                                            <span class="badge badge-dark">Dezactivat</span>
                                        </a>
                                    @endif 

                                        <div class="modal fade text-dark" id="activeazaDezactiveazaCronJob{{ $cron_job->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title" id="exampleModalLabel">Cron Job: <b>{{ $cron_job->nume }}</b></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="text-align:left;">
                                                    @if ($cron_job->stare === 1) 
                                                        Ești sigur ca vrei să dezactivezi Cron Jobul?
                                                    @else
                                                        Ești sigur ca vrei să activezi Cron Jobul?
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                    
                                                    <form method="POST" action="{{ $cron_job->path() }}/activare-dezactivare">
                                                        @method('PATCH')
                                                        @csrf 
                                                            @if ($cron_job->stare === 1)  
                                                                <button type="submit" class="btn btn-warning">
                                                                    Dezactiveaza Cron Job
                                                                </button> 
                                                            @else
                                                                <button type="submit" class="btn btn-success">
                                                                    Activeaza Cron Job
                                                                </button> 
                                                            @endif                     
                                                    </form>
                                                
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ $cron_job->path() }}/modifica"
                                        class="flex"    
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>                                   
                                    <div style="flex" class="">
                                        <a 
                                            {{-- class="btn btn-danger btn-sm"  --}}
                                            href="#" 
                                            {{-- role="button" --}}
                                            data-toggle="modal" 
                                            data-target="#stergeContract{{ $cron_job->id }}"
                                            title="Șterge Contract"
                                            >
                                            {{-- <i class="far fa-trash-alt"></i> --}}
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeContract{{ $cron_job->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Cron job: <b>{{ $cron_job->nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Cron jobul?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $cron_job->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Cron job
                                                            </button>                    
                                                        </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> 
                                </td>
                            </tr>  
                            <tr class="collapse bg-white" id="collapseFisiere{{ $cron_job->id }}" 
                            >
                                <td colspan="8">
                                    <table class="table table-sm table-striped table-hover col-lg-8 mx-auto border">
                                        <thead class="text-white rounded" style="background-color:#e66800;">
                                            <tr class="" style="padding:2rem">
                                                <td>
                                                    Nr. Crt.
                                                </td>
                                                <td>
                                                    Nume fișier
                                                </td>
                                                <td class="text-center">
                                                    Acțiuni
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($cron_job->fisiere as $fisier)
                                            <tr>
                                                <td class="py-0">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="py-0">
                                                    {{ $fisier->nume }}
                                                </td>
                                                <td class="py-0 d-flex justify-content-end">
                                                    {{-- <a href="/contracte/file-download/{{ $fisier->id }}" class="mr-4">
                                                        <span class="badge badge-success">Descarcă</span>
                                                    </a> --}}
                                                                    <form method="POST" action="{{ route('cronjob.file.download', $fisier->id) }}">
                                                                        {{-- @method('DELETE')   --}}
                                                                        @csrf   
                                                                        <button 
                                                                            type="submit" 
                                                                            class="btn btn-link py-0"  
                                                                            >
                                                                            <span class="badge badge-success">Descarcă</span>
                                                                        </button>                    
                                                                    </form>
                                                    <a 
                                                        {{-- class="btn btn-danger btn-sm"  --}}
                                                        href="#" 
                                                        {{-- role="button" --}}
                                                        data-toggle="modal" 
                                                        data-target="#stergeFisier{{ $fisier->id }}"
                                                        title="Șterge Fisier"
                                                        >
                                                        {{-- <i class="far fa-trash-alt"></i> --}}
                                                        <span class="badge badge-danger">Șterge</span>
                                                    </a>
                                                        <div class="modal fade text-dark" id="stergeFisier{{ $fisier->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                <div class="modal-header bg-danger">
                                                                    <h5 class="modal-title text-white" id="exampleModalLabel">Fisier: <b>{{ $fisier->nume }}</b></h5>
                                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" style="text-align:left;">
                                                                    Ești sigur ca vrei să ștergi Fișierul?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                                    
                                                                    <form method="POST" action="{{ $fisier->path() }}">
                                                                        @method('DELETE')  
                                                                        @csrf   
                                                                        <button 
                                                                            type="submit" 
                                                                            class="btn btn-danger"  
                                                                            >
                                                                            Șterge Fișier
                                                                        </button>                    
                                                                    </form>
                                                                
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </td>
                                            </tr>                                            
                                        @empty
                                            
                                        @endforelse
                                        </tbody>
                                    </table>
                                </td>
                            </tr> 
                            <tr class="collapse">
                                <td colspan="8">

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
                        {{$cron_jobs->links()}}
                    </ul>
                </nav>

            <a href="cron-jobs/trimitere-automata/647itykdghm57lyuk45th" class="btn btn-primary">Simuleaza trimitere automata Cron Jobs</a>
        </div>
    </div>
@endsection