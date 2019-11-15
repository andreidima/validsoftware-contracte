@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="border-bottom-red p-2 d-flex justify-content-between align-items-end" style="border-radius: 40px 40px 0px 0px;">                     
                    <h3 class="ml-3" style="color:brown"><i class="fas fa-ticket-alt mr-1"></i>Rezervare bilet</h3>
                    <img src="{{ asset('images/Alsimy Mond Travel Galati - logo.png') }}" height="70" class="mr-3">
                </div>

                <div class="card-body text-center" 
                    style="
                        color:ivory; 
                        background-color:crimson; 
                        /* background-image: radial-gradient(yellow 10%, crimson 90%); */
                        border-radius: 0px 0px 40px 40px
                    "
                >
                    <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-1" style="font-size:0.8rem">
                        @csrf
                        
                                <input 
                                    type="text" 
                                    class="formStyle {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                                    name="telefon" 
                                    placeholder="Telefon" 
                                    value="{{ old('telefon') }}"
                                    required>

                </div>
            </div>
        </div>
    </div>
</div>
   
@endsection