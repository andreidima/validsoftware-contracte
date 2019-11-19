@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-danger p-2 d-flex justify-content-between align-items-end" style="border-radius: 40px 40px 0px 0px;">                     
                    <h3 class="ml-3" style="color:brown"><i class="fas fa-ticket-alt fa-lg mr-1"></i>Verificare bilet</h3>
                    <img src="{{ asset('images/Alsimy Mond Travel Galati - logo.png') }}" height="70" class="mr-3">
                </div>
                
                @include ('errors')                

                <div class="card-body py-2" 
                    style="
                        color:ivory; 
                        background-color:crimson; 
                        border-radius: 0px 0px 40px 40px
                    "
                    id="adauga-rezervare"
                >
                    <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-1">
                        @csrf

                        <div class="form-row mb-0 d-flex justify-content-center border-radius: 0px 0px 40px 40px">
                            <div class="form-group col-lg-12 px-2 mb-0">
                                <div class="form-row mb-3 d-flex justify-content-center">
                                    <div class="col-lg-7">
                                        Traseu: 
                                        @if ($rezervare->traseu == 1)
                                            România -> Italia
                                        @else
                                            Italia -> România
                                        @endif
                                    </div>
                                    <div class="col-lg-7">
                                        Data de plecare:
                                        {{ \Carbon\Carbon::parse($rezervare->data_plecare)->isoFormat('D.MM.YYYY') }}
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
   
@endsection