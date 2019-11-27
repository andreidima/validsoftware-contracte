@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="text-center border border-danger p-2" style="border-radius: 40px 40px 0px 0px;"> 
                    <img src="{{ asset('images/Alsimy Mond Travel Galati - logo.png') }}" height="120" class="mr-2">
                </div>

                <div class="card-body text-center" 
                    style="
                        color:ivory; 
                        background-color:crimson; 
                        /* background-image: radial-gradient(yellow 10%, crimson 90%); */
                        border-radius: 0px 0px 40px 40px
                    "
                >
                    <i class="fas fa-bus-alt m-4" style="font-size: 12em;"></i>
                    {{-- <a class="btn btn-lg text-white" href="/adauga-rezervare-pasul-1" role="button" style="font-size: 2em; background-color:brown">Rezervă un bilet!</a> --}}
                    <a class="btn btn-primary btn-lg" href="/adauga-rezervare-pasul-1" role="button" 
                        style="font-size: 2em;border-radius: 40px; border: 5px solid white;">
                        <i class="fas fa-ticket-alt mr-2"></i>
                        Rezervă un bilet!
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
