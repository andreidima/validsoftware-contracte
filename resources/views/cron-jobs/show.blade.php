@extends ('layouts.app')

@section('content')   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-calendar-check mr-1"></i>Cron Jobs / {{ $cron_job->nume }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary" 
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >

            @include ('errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-sm table-striped table-hover"
                                {{-- style="background-color:#008282" --}}
                        > 
                            <tr>
                                <td>
                                    Nume
                                </td>
                                <td>
                                    {{ $cron_job->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Client
                                </td>
                                <td>
                                    {{ $cron_job->client->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Ziua
                                </td>
                                <td>
                                    {{ $cron_job->ziua }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Ora
                                </td>
                                <td>
                                    {{ $cron_job->ora ? \Carbon\Carbon::parse($cron_job->ora)->isoFormat('HH:mm') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Subiect
                                </td>
                                <td>
                                    {{ $cron_job->subiect }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email
                                </td>
                                <td>
                                    {!! $cron_job->email !!}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Stare
                                </td>
                                <td>
                                    @if($cron_job->stare === 1)
                                        <span class="badge badge-success">Activ</span>
                                    @else
                                        <span class="badge badge-secondary">Inactiv</span>
                                    @endisset
                                </td>
                            </tr>
                        </table>
                    </div>
                                       
                    <div class="form-row mb-2 px-2">                                    
                        <div class="col-lg-12 d-flex justify-content-center">  
                            <a class="btn btn-primary btn-sm rounded-pill" href="/cron-jobs">Pagină Cron Jobs</a> 
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection