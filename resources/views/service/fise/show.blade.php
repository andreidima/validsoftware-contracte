@extends ('layouts.app')

@section('content')   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-money-bill-wave mr-1"></i>Fișe service / {{ $fise->nr_fisa }}</h6>
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
                                    Număr intrare
                                </td>
                                <td>
                                    {{ $fise->nr_intrare }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Număr ieșire
                                </td>
                                <td>
                                    {{ $fise->nr_iesire }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Tehnician Service
                                </td>
                                <td>
                                    {{ $fise->tehnician_service }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Dată recepție
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($fise->data_receptie)->isoFormat('DD.MM.YYYY') }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Client
                                </td>
                                <td>
                                    {{ $fise->client->nume ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Descriere echipament
                                </td>
                                <td>
                                    {{ $fise->descriere_echipament }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Defect reclamat
                                </td>
                                <td>
                                    {{ $fise->defect_reclamat }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Defect constatat
                                </td>
                                <td>
                                    {{ $fise->defect_constatat }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Rezultat service
                                </td>
                                <td>
                                    {{ $fise->rezultat_service }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Observații
                                </td>
                                <td>
                                    {{ $fise->observatii }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Dată ridicare
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($fise->data_ridicare)->isoFormat('DD.MM.YYYY') }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Servicii
                                </td>
                                <td>
                                    @foreach ($fise->servicii as $serviciu)
                                        {{ $serviciu->nume }}
                                        {{ $serviciu->pret ? ' - ' . $serviciu->pret . ' RON' : ''}}
                                        <br />
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Partener
                                </td>
                                <td>
                                    {{ $fise->partener->nume ?? '' }}
                                    
                                    <div class="d-flex">       
                                        <a 
                                            href="#" 
                                            data-toggle="modal" 
                                            data-target="#trimiteEmailPartener"
                                            title="trimite Email Partener"
                                            class="mr-1"
                                            >
                                            <span class="badge badge-primary">Trimite Email
                                                <span class="badge badge-light" title="Emailuri trimise până acum">
                                                    @isset ($fise->created_at)
                                                        {{ $fise->emailuri_trimise_partener()->count() }}
                                                    @else
                                                        0
                                                    @endisset
                                                </span>
                                            </span>
                                        </a>
                                            <div class="modal fade text-dark" id="trimiteEmailPartener" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-secondary">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișă: <b>{{ $fise->client->nume ?? '' }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    @isset ($fise->created_at)
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să trimiți Emailuri către partener și către client?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                            
                                                            <form method="POST" action="{{ $fise->path() }}/email-partener-si-client/trimite-email">
                                                                @csrf   
                                                                <button 
                                                                    type="submit" 
                                                                    class="btn btn-primary"  
                                                                    >
                                                                    Trimite email
                                                                </button>                    
                                                            </form>
                                                        
                                                        </div>
                                                    @else
                                                        <div class="modal-body bg-warning" style="text-align:left;">
                                                            Trebuie să salvezi fișa înainte de a putea trimite emailul!
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        </div>
                                                    @endisset
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>                   
                                        
                    <div class="form-row mb-0 px-2 justify-content-center">                                    
                        <div class="col-lg-8 d-flex justify-content-center">  
                            <a class="btn btn-primary btn-sm mr-4 rounded-pill" href="/service/fise">Înapoi la Fișe Service</a> 
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection