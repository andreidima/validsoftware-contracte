@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-danger p-2 d-flex justify-content-between align-items-end" style="border-radius: 40px 40px 0px 0px;">                     
                    <h3 class="ml-3" style="color:brown"><i class="fas fa-ticket-alt fa-lg mr-1"></i>Verificare rezervare</h3>
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
                                            Detalii transport
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 p-2 mb-4 bg-white border rounded-lg">
                                        <div class="row text-center">
                                            <div class="col-lg-5">
                                                Oraș plecare:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ $colet->oras_plecare_nume->nume }}
                                                </span>
                                            </div>
                                            <div class="col-lg-1 pt-1 text-primary">
                                                {{-- <span class="badge badge-primary" style="font-size:1.1em"> --}}
                                                    <i class="fas fa-long-arrow-alt-right fa-4x"></i>
                                                {{-- </span> --}}
                                            </div>
                                            <div class="col-lg-5">
                                                Oraș sosire:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ $colet->oras_sosire_nume->nume }}
                                                </span>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-warning p-1 m-0 text-center">
                                            Informații colete
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        Număr colete: 
                                        <span class="badge badge-primary" style="font-size:1em">{{ $colet->numar_colete }}</span>
                                        <br>
                                        Detalii colete: {{ $colet->detalii_colete }}
                                    </div>  
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-warning p-1 m-0 text-center">
                                            Informații client
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        Nume: <span class="badge badge-primary" style="font-size:1.1em">{{ $colet->nume }}</span>
                                        <br>
                                        Telefon: <b>{{ $colet->telefon }}</b>
                                        <br>
                                        Email: <b>{{ $colet->email }}</b>
                                        <br>
                                        Adresa: {{ $colet->adresa }}
                                        <br>
                                        Observații: {{ $colet->observatii }}
                                    </div> 

                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-warning p-1 m-0 text-center">
                                            Date pentru facturare
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-2 bg-white border rounded-lg">
                                        Document de călătorie: {{ $colet->document_de_calatorie }}
                                        <br>
                                        Data expirării documentului: {{ \Carbon\Carbon::parse($colet->expirare_document)->isoFormat('D.MM.YYYY') }}
                                        <br>
                                        Seria buletin / pașaport:: {{ $colet->serie_document }}
                                        <br>
                                        Cnp: {{ $colet->cnp }}
                                    </div>
                                </div>  
                                
                                
                                
                                <div class="row">
                                    <div class="col-lg-12 d-flex justify-content-center mb-0">  
                                        <form  class="needs-validation" novalidate method="POST" action="/adauga-colet-pasul-2">
                                            @csrf   

                                            <button type="submit" class="btn btn-primary mr-4 rounded-pill border border-white" 
                                                style="border-width:3px !important;">
                                                    Salvează rezervarea
                                            </button>
                                            
                                            <a class="btn btn-secondary rounded-pill border border-white" 
                                                style="border-width:3px !important;" href="/rezervare-client" role="button">
                                                    Anulează rezervarea
                                            </a>
                                        </form>                                        
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