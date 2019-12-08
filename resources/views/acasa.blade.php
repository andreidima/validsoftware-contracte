@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="text-center border border-danger p-2" style="border-radius: 40px 40px 0px 0px;"> 
                    <img src="{{ asset('images/Alsimy Mond Travel Galati - logo.png') }}" class="mr-2" style="max-width:60%">
                </div>

                <div class="card-body text-center" 
                    style="
                        color:ivory; 
                        background-color:crimson; 
                        /* background-image: radial-gradient(yellow 10%, crimson 90%); */
                        border-radius: 0px 0px 40px 40px
                    "
                >
                    <div class="row">
                        <a href="/adauga-rezervare-pasul-1" class="text-white">
                            <div class="col-md-4">
                                <i class="fas fa-bus-alt m-4" style="font-size: 12em;"></i>
                                <a class="btn btn-primary btn-lg" href="/adauga-rezervare-pasul-1" role="button" 
                                    style="font-size: 2em;border-radius: 40px; border: 5px solid white;">
                                    Rezervări bilete
                                </a>
                            </div>
                        </a>
                        <div class="col-md-4 border-left">
                            <i class="fas fa-box m-4" style="font-size: 12em;"></i>
                                <a class="btn btn-primary btn-lg" href="/adauga-colet-pasul-1" role="button" 
                                    style="font-size: 2em;border-radius: 40px; border: 5px solid white;">
                                    Rezervări colete
                                </a>
                        </div>
                        <div class="col-md-4 border-left">
                            <i class="fas fa-plane m-4" style="font-size: 12em;"></i>
                                @if (isset(auth()->user()->id) && (auth()->user()->id == 2))
                                    <a class="btn btn-primary btn-lg" href="/adauga-rezervare-aeroport-pasul-1" role="button" 
                                        style="font-size: 2em;border-radius: 40px; border: 5px solid white;">
                                        Rezervări aeroport
                                    </a>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
