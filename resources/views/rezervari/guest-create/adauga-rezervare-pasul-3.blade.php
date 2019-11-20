@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-danger p-2 d-flex justify-content-between align-items-end" style="border-radius: 40px 40px 0px 0px;">                     
                    <h3 class="ml-3" style="color:brown"><i class="fas fa-ticket-alt fa-lg mr-1"></i>Verificare bilet</h3>
                    <img src="{{ asset('images/Alsimy Mond Travel Galati - logo.png') }}" height="70" class="mr-3">
                </div>
                
                @include ('errors')                

                <div class="card-body py-2" 
                    style="
                        /* color:ivory;  */
                        background-color:crimson; 
                        border-radius: 0px 0px 40px 40px
                    "
                >   
                
                        <div class="row mb-0 d-flex justify-content-center border-radius: 0px 0px 40px 40px">
                            <div class="col-lg-12 p-4 mb-0">
                                <div class="row mb-3 d-flex justify-content-center">
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-warning p-1 m-0 text-center">
                                            Rezervarea a fost înregistrată cu codul RO{{ $rezervare->id }}
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 p-4 bg-white border rounded-lg">
                                        <div class="row">
                                            <div class="col-sm-12 text-center"> 
                                                <a href="/bilet-rezervat/rezervare-pdf"
                                                    class="btn btn-success border border-white rounded-lg mb-3"
                                                    role="button"
                                                    target="_blank"
                                                    title="Descarcă bilet"
                                                    >
                                                    <h5 class="p-0 m-0">Descărcați și tipăriți biletul de rezervare</h5>
                                                </a>
                                                <br>
                                                <a href="/"
                                                    class="btn btn-primary border border-white rounded-lg"
                                                    role="button"
                                                    title="Înapoi la pagina principală">
                                                    <h5 class="p-0 m-0">Înapoi la pagina principală</h5>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection