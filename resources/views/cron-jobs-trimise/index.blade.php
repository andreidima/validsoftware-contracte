@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class=" mb-0"><a href="{{ route('cron-jobs-trimise.index') }}"><i class="fas fa-calendar-check mr-1"></i>Cron Jobs trimise</a></h4>
            </div> 
            <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ route('cron-jobs-trimise.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('cron-jobs-trimise.index') }}" role="button">
                            <i class="fa fa-undo text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body px-0 py-3 col-10 mx-auto">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="">
                            <th>Nr. Crt.</th>
                            <th>Cron job</th>
                            <th>Client</th>
                            <th class="text-right">Data</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($cron_jobs_trimise as $cron_job_trimis) 
                            <tr>                  
                                <td align="">
                                    {{ ($cron_jobs_trimise ->currentpage()-1) * $cron_jobs_trimise ->perpage() + $loop->index + 1 }}
                                </td>             
                                <td>
                                    <a href="{{ $cron_job_trimis->cronjob->path() }}">
                                        {{ $cron_job_trimis->cronjob->nume ?? '' }}
                                    </a>
                                </td>
                                <td>
                                    {{ $cron_job_trimis->cronjob->client->nume ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{ $cron_job_trimis->cronjob->created_at ? \Carbon\Carbon::parse($cron_job_trimis->created_at)->isoFormat('HH:mm - DD.MM.YY') : '' }}
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
                        {{$cron_jobs_trimise->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection