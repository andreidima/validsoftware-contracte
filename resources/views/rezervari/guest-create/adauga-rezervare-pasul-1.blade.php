@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-danger p-2 d-flex justify-content-between align-items-end" style="border-radius: 40px 40px 0px 0px;">                     
                    <h3 class="ml-3" style="color:brown"><i class="fas fa-ticket-alt fa-lg mr-1"></i>Rezervare bilet</h3>
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
                                        <script type="application/javascript"> 
                                            traseuVechi={!! json_encode(old('traseu', "0")) !!} 
                                            nrAdultiVechi = 0
                                            nrCopiiVechi = 0
                                            nrAnimaleMiciVechi = 0
                                            nrAnimaleMariVechi = 0
                                            pretTotal = 0
                                        </script>
                                    <div class="col-lg-7">
                                        Selectează traseu:
                                    </div>
                                    <div class="col-lg-7 btn-group btn-group-toggle">
                                        <label class="btn btn-success btn-sm border" v-bind:class="[traseu==1 ? active : '']">
                                            <input type="radio" class="btn-group-toggle" name="traseu" id="traseu1" autocomplete="off"
                                                v-model="traseu" value="1"
                                                v-on:change="getOrasePlecare(); getOraseSosire()"
                                                >România -> Italia
                                        </label>
                                        <label class="btn btn-success btn-sm border" v-bind:class="[traseu==2 ? active : '']">
                                            <input type="radio" class="btn-group-toggle" name="traseu" id="traseu2" autocomplete="off"
                                                v-model="traseu" value="2"
                                                v-on:change="getOrasePlecare(); getOraseSosire()"
                                                >Italia -> România
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row mb-2 d-flex justify-content-between align-items-center">
                                    <div class="form-group col-lg-3">
                                        <script type="application/javascript"> 
                                            orasPlecareVechi={!! json_encode(old('oras_plecare', "0")) !!} 
                                        </script>
                                        <label for="oras_plecare" class="mb-0">Plecare din:<span class="text-white">*</span></label>
                                        <select class="custom-select-sm custom-select {{ $errors->has('oras_plecare') ? 'is-invalid' : '' }}"
                                            name="oras_plecare"
                                            v-model="oras_plecare"
                                            @change='getPreturi();getPretTotal()'
                                            >                                                
                                            <option
                                                v-for='oras_plecare in orase_plecare'
                                                :value='oras_plecare.id'                  
                                                >
                                                    @{{oras_plecare.nume}}
                                            </option>                                                
                                        </select>
                                    </div>                                    
                                    <div class="form-group col-lg-3">
                                        <script type="application/javascript"> 
                                            orasSosireVechi={!! json_encode(old('oras_sosire', "0")) !!}
                                        </script>        
                                        <label for="oras_sosire" class="mb-0">Sosire la:<span class="text-white">*</span></label>
                                            <select class="custom-select-sm custom-select {{ $errors->has('oras_sosire') ? 'is-invalid' : '' }}"
                                                name="oras_sosire"
                                                v-model="oras_sosire"                                                
                                                @change='getPreturi();getPretTotal()'
                                            >
                                                    <option v-for='oras_sosire in orase_sosire'                                
                                                    :value='oras_sosire.id'                                       
                                                    >@{{oras_sosire.nume}}</option>
                                            </select>
                                    </div>
                                    <div class="custom-control custom-switch col-lg-3 text-center">
                                        <script type="application/javascript"> 
                                            turReturVechi={!! json_encode(old('tur_retur') == "true" ? true : false) !!}
                                        </script>
                                        <input type="hidden" name="tur_retur" value="false" />
                                        {{-- <input type="checkbox" class="custom-control-input" id="customSwitch1"> --}}
                                        <input type="checkbox" class="custom-control-input custom-control-lg" id="customSwitch1" 
                                        name="tur_retur" v-model="tur_retur" value="true" required
                                        {{ old('tur_retur') == 'true' ? 'checked' : '' }}
                                        @change='getPreturi();getPretTotal()'
                                        >
                                        <label class="custom-control-label" for="customSwitch1">TUR - RETUR</label>                                        
                                    </div>
                                </div>                               
                                <div class="form-row mb-4 px-2 pt-2 d-flex justify-content-between align-items-center bg-secondary border rounded">                                    
                                    <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                        {{-- <span class="badge badge-pill badge-dark mb-1"> --}}
                                            <h5 class="mb-1">Lista de prețuri:</h5>
                                        {{-- </span> --}}
                                    </div>
                                    <div class="form-group col-lg-6 m-0 d-flex">
                                        <label for="pret_adult" class="col-form-label mb-0 mr-2">Preț adult:</label>
                                        <div class="px-0" style="width:50px">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('pret_adult') ? 'is-invalid' : '' }}" 
                                                name="pret_adult"
                                                v-model="pret_adult" 
                                                value="{{ old('pret_adult') }}"
                                                required
                                                disabled>
                                        </div>
                                        <label id="" class="col-form-label pl-1 align-bottom">
                                            Euro
                                        </label>
                                    </div>
                                    <div class="form-group col-lg-6 m-0 d-flex">
                                        <label for="pret_animal_mic" class="col-form-label mb-0 mr-2"><small>Animal companie talie mică (< 10 kg)</small>:</label>
                                        <div class="px-0" style="width:50px">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('pret_animal_mic') ? 'is-invalid' : '' }}" 
                                                name="pret_animal_mic" 
                                                v-model="pret_animal_mic"
                                                value="{{ old('pret_animal_mic') }}"
                                                required
                                                disabled> 
                                        </div>
                                        <label id="" class="col-form-label pl-1 align-bottom">
                                            Euro
                                        </label>
                                    </div>
                                    <div class="form-group col-lg-6 m-0 d-flex">
                                        <label for="pret_copil" class="col-form-label mb-0 mr-2">Preț copil (vârsta < 10 ani):</label>
                                        <div class="px-0" style="width:50px">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('pret_copil') ? 'is-invalid' : '' }}" 
                                                name="pret_copil" 
                                                v-model="pret_copil"
                                                value="{{ old('pret_copil') }}"
                                                required
                                                disabled> 
                                        </div>
                                        <label id="" class="col-form-label pl-1 align-bottom">
                                            Euro
                                        </label>
                                    </div>
                                    <div class="form-group col-lg-6 m-0 d-flex">
                                        <label for="pret_animal_mare" class="col-form-label mb-0 mr-2"><small>Animal companie talie mare (> 10 kg):</small></label>
                                        <div class="px-0" style="width:50px">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('pret_animal_mare') ? 'is-invalid' : '' }}" 
                                                name="pret_animal_mare" 
                                                v-model="pret_animal_mare"
                                                value="{{ old('pret_animal_mare') }}"
                                                required
                                                disabled> 
                                        </div>
                                        <label id="" class="col-form-label pl-1 align-bottom">
                                            Euro
                                        </label>
                                    </div>
                                </div>                               
                                <div class="form-row mb-3 px-2 pt-2 d-flex justify-content-between align-items-center bg-primary border rounded">                                    
                                    <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                        {{-- <span class="badge badge-pill badge-dark mb-1"> --}}
                                            <h5 class="mb-1">Rezervă locuri:</h5>
                                        {{-- </span> --}}
                                    </div>
                                    <div class="form-group col-lg-6 m-0 d-flex">
                                        <label for="nr_adulti" class="col-form-label mb-0 mr-2">Adulți:*</label></label>
                                        <div class="px-0 d-flex align-self-center" style="width:110px">  
                                            <button type="button" class="btn m-0 p-0"
                                                v-on:click="nr_adulti -= 1;getPretTotal()"
                                                >
                                                <i class="far fa-minus-square bg-danger text-white fa-2x"></i>
                                            </button>  
                                            <script type="application/javascript"> 
                                                nrAdultiVechi={!! json_encode(old('nr_adulti', '0'), JSON_NUMERIC_CHECK) !!}
                                            </script>                                    
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('nr_adulti') ? 'is-invalid' : '' }}" 
                                                name="nr_adulti"
                                                v-model="nr_adulti" 
                                                value="{{ old('nr_adulti') }}"
                                                required
                                                readonly>
                                            <button type="button" class="btn m-0 p-0" 
                                                v-on:click="nr_adulti += 1;getPretTotal()">
                                                <i class="far fa-plus-square bg-success text-white fa-2x">
                                                </i>
                                            </button>  
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 m-0 d-flex">
                                        <label for="pret_animal_mic" class="col-form-label mb-0 mr-2"><small>Animale companie talie mică (< 10 kg)</small>:</label>
                                        <div class="px-0 d-flex align-self-center" style="width:90px">
                                            <button type="button" class="btn m-0 p-0"
                                                v-on:click="nr_animale_mici -= 1;getPretTotal()"
                                                >
                                                <i class="far fa-minus-square bg-danger text-white fa-2x"></i>
                                            </button>  
                                            <script type="application/javascript"> 
                                                nrAnimaleMiciVechi={!! json_encode(old('nr_animale_mici', '0'), JSON_NUMERIC_CHECK) !!}
                                            </script>                                        
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('nr_animale_mici') ? 'is-invalid' : '' }}" 
                                                name="nr_animale_mici"
                                                v-model="nr_animale_mici" 
                                                value="{{ old('nr_animale_mici') }}"
                                                required
                                                readonly>
                                            <button type="button" class="btn m-0 p-0" 
                                                v-on:click="nr_animale_mici += 1;getPretTotal()">
                                                <i class="far fa-plus-square bg-success text-white fa-2x">
                                                </i>
                                            </button>  
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 m-0 d-flex">
                                        <label for="pret_copil" class="col-form-label mb-0 mr-2">Copii (vârsta < 10 ani):</label>
                                        <div class="px-0 d-flex align-self-center" style="width:90px">  
                                            <button type="button" class="btn m-0 p-0"
                                                v-on:click="nr_copii -= 1;getPretTotal()"
                                                >
                                                <i class="far fa-minus-square bg-danger text-white fa-2x"></i>
                                            </button>   
                                            <script type="application/javascript"> 
                                                nrCopiiVechi={!! json_encode(old('nr_copii', '0'), JSON_NUMERIC_CHECK) !!}
                                            </script>                                    
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('nr_copii') ? 'is-invalid' : '' }}" 
                                                name="nr_copii"
                                                v-model="nr_copii" 
                                                value="{{ old('nr_copii') }}"
                                                required
                                                readonly>
                                            <button type="button" class="btn m-0 p-0" 
                                                v-on:click="nr_copii += 1;getPretTotal()">
                                                <i class="far fa-plus-square bg-success text-white fa-2x">
                                                </i>
                                            </button>   
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 m-0 d-flex">
                                        <label for="pret_animal_mare" class="col-form-label mb-0 mr-2"><small>Animale companie talie mare (> 10 kg):</small></label>
                                        <div class="px-0 d-flex align-self-center" style="width:90px">  
                                            <button type="button" class="btn m-0 p-0"
                                                v-on:click="nr_animale_mari -= 1;getPretTotal()"
                                                >
                                                <i class="far fa-minus-square bg-danger text-white fa-2x"></i>
                                            </button>        
                                            <script type="application/javascript"> 
                                                nrAnimaleMariVechi={!! json_encode(old('nr_animale_mari', '0'), JSON_NUMERIC_CHECK) !!}
                                            </script>                                 
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('nr_animale_mari') ? 'is-invalid' : '' }}" 
                                                name="nr_animale_mari"
                                                v-model="nr_animale_mari" 
                                                value="{{ old('nr_animale_mari') }}"
                                                required
                                                readonly>
                                            <button type="button" class="btn m-0 p-0" 
                                                v-on:click="nr_animale_mari += 1;getPretTotal()">
                                                <i class="far fa-plus-square bg-success text-white fa-2x">
                                                </i>
                                            </button> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mb-1 d-flex justify-content-between align-items-center">
                                    <div class="form-group col-lg-3">
                                        <label for="data_plecare" class="mb-0">Dată plecare:*<span class="text-danger">*</span></label>
                                        <vue2-datepicker-miercuri
                                            data-veche="{{ old('data_plecare') == '' ? '' : old('data_plecare') }}"
                                            nume-camp-db="data_plecare"
                                            tip="date"
                                            latime="150"
                                            not-before="{{ \Carbon\Carbon::today() }}"
                                        ></vue2-datepicker-miercuri> 
                                    </div>
                                    <div v-if="tur_retur" class="form-group col-lg-3">
                                        <label for="data_intoarcere" class="mb-0">Dată întoarcere:*<span class="text-danger">*</span></label>
                                        <vue2-datepicker-duminica
                                            data-veche="{{ old('data_intoarcere') == '' ? '' : old('data_intoarcere') }}"
                                            nume-camp-db="data_intoarcere"
                                            tip="date"
                                            latime="150"
                                            not-before="{{ \Carbon\Carbon::today() }}"
                                        ></vue2-datepicker-duminica> 
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="pret_total" class="mb-0">Preț total:
                                        <div class="px-0 d-flex" style="width:100px">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('pret_total') ? 'is-invalid' : '' }}" 
                                                name="pret_total"
                                                v-model="pret_total" 
                                                value="{{ old('pret_total') }}"
                                                required
                                                disabled>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Euro
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row mb-3 px-2 py-2 justify-content-between align-items-center border">                                    
                                    <div class="form-group col-lg-4">  
                                        <label for="nume" class="mb-0">Nume Client:*</label>                                      
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                                            name="nume" 
                                            placeholder="" 
                                            value="{{ old('nume') }}"
                                            required> 
                                    </div>                                   
                                    <div class="form-group col-lg-4">   
                                        <label for="nume" class="mb-0">Telefon:*</label>                                      
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                                            name="telefon" 
                                            placeholder="" 
                                            value="{{ old('telefon') }}"
                                            required> 
                                    </div>                                
                                    <div class="form-group col-lg-4">  
                                        <label for="nume" class="mb-0">Email:*</label>                                        
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                                            name="email" 
                                            placeholder="" 
                                            value="{{ old('email') }}"
                                            required> 
                                    </div>                                
                                    <div class="form-group col-lg-6 mb-1 justify-content-center"> 
                                        <label for="adresa" class="mb-0">Adresa:</label>
                                        <textarea class="form-control {{ $errors->has('adresa') ? 'is-invalid' : '' }}" 
                                            nume="adresa" id="adresa" rows="2"></textarea>
                                    </div>                               
                                    <div class="form-group col-lg-6 mb-1 justify-content-center"> 
                                        <label for="observatii" class="mb-0">Observații:</label>
                                        <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}" 
                                            nume="observatii" id="observatii" rows="2"></textarea>
                                    </div> 
                                </div>
                                <div class="form-row mb-1 px-2 justify-content-center align-items-center">                                    
                                    <div class="col-lg-8 d-flex justify-content-center">  
                                        <button type="submit" class="btn btn-lg btn-warning btn-block mr-4">Verifică Rezervarea</button>  
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