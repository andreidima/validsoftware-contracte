@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-danger p-2 d-flex justify-content-between align-items-end" style="border-radius: 40px 40px 0px 0px;">                     
                    <h3 class="ml-3" style="color:brown"><i class="fas fa-ticket-alt fa-lg mr-1"></i>Rezervări colete</h3>
                    <img src="{{ asset('images/Alsimy Mond Travel Galati - logo.png') }}" height="70" class="mr-3">
                </div>
                
                @include ('errors')                

                <div class="card-body py-2" 
                    style="
                        color:ivory; 
                        background-color:crimson; 
                        border-radius: 0px 0px 40px 40px
                    "
                    id="transport-colete"
                >
                    <form  class="needs-validation" novalidate method="POST" action="/adauga-colet-pasul-1">
                        @csrf

                        <div class="form-row mb-0 d-flex justify-content-center border-radius: 0px 0px 40px 40px">
                            <div class="form-group col-lg-12 px-2 mb-0">
                                <div class="form-row mb-3 d-flex justify-content-center">
                                        <script type="application/javascript"> 
                                            traseuVechi={!! json_encode(old('traseu', "0")) !!} 
                                            numarColeteVechi = 0
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
                                <div class="form-row mb-2 d-flex justify-content-center align-items-center">
                                    <div class="form-group col-lg-3">
                                        <script type="application/javascript"> 
                                            orasPlecareVechi={!! json_encode(old('oras_plecare', "0")) !!} 
                                        </script>
                                        <label for="oras_plecare" class="mb-0">Plecare din:<span class="text-white">*</span></label>
                                        <select class="custom-select-sm custom-select {{ $errors->has('oras_plecare') ? 'is-invalid' : '' }}"
                                            name="oras_plecare"
                                            v-model="oras_plecare"
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
                                            >
                                                    <option v-for='oras_sosire in orase_sosire'                                
                                                    :value='oras_sosire.id'                                       
                                                    >@{{oras_sosire.nume}}</option>
                                            </select>
                                    </div>
                                </div>    

                                <div class="form-row mb-3 px-2 pt-2 d-flex justify-content-center bg-secondary border rounded">                                    
                                    <div class="col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                        {{-- <span class="badge badge-pill badge-dark mb-1"> --}}
                                            <h5 class="mb-0">Plecările sunt săptămânale:</h5>
                                        {{-- </span> --}}
                                    </div>
                                    <div class="form-group col-lg-6 m-0 d-flex justify-content-center">
                                        <h5><span class="badge badge-warning">România -> Italia: Joia</span></h5>
                                        
                                    </div>
                                    <div class="form-group col-lg-6 m-0 d-flex justify-content-center">
                                        <h5><span class="badge badge-warning">Italia -> România: Duminica</span></h5>
                                        
                                    </div>
                                </div>
                                                          
                                <div class="form-row mb-3 px-2 pt-2 d-flex justify-content-between align-items-top bg-primary border rounded">                                    
                                    <div class="form-group col-lg-4 mb-2 justify-content-center">
                                        {{-- <span class="badge badge-pill badge-dark mb-1"> --}}
                                            <h5 class="mb-3 border-bottom align-center">Transport colete:</h5>
                                        {{-- </span> --}}
                                        <div class="form-group m-0 d-flex">
                                                
                                            <label for="numar_colete" class="col-form-label mb-0 mr-2">Nr. colete:*</label></label>
                                            
                                            <div class="col-lg-6 px-0 d-flex align-self-center">  
                                                <button type="button" class="btn m-0 p-0"
                                                    v-on:click="numar_colete -= 1"
                                                    >
                                                    <i class="far fa-minus-square bg-danger text-white fa-2x"></i>
                                                </button>  
                                                <script type="application/javascript"> 
                                                    numarColeteVechi={!! json_encode(old('numar_colete', '0'), JSON_NUMERIC_CHECK) !!}
                                                </script>                                    
                                                <input 
                                                    type="text" 
                                                    class="form-control form-control-sm {{ $errors->has('numar_colete') ? 'is-invalid' : '' }}" 
                                                    name="numar_colete"
                                                    v-model="numar_colete" 
                                                    value="{{ old('numar_colete') }}"
                                                    required
                                                    readonly>
                                                <button type="button" class="btn m-0 p-0" 
                                                    v-on:click="numar_colete += 1">
                                                    <i class="far fa-plus-square bg-success text-white fa-2x">
                                                    </i>
                                                </button>  
                                            </div>
                                        </div> 
                                    </div>                                                                 
                                    <div class="form-group col-lg-8 mb-2 justify-content-center"> 
                                        <label for="detalii_colete" class="mb-0">Detalii colete:</label>
                                        <textarea class="form-control {{ $errors->has('detalii_colete') ? 'is-invalid' : '' }}" 
                                            name="detalii_colete" id="detalii_colete" rows="2">{{ old('detalii_colete') }}</textarea>
                                    </div> 
                                </div>                                
                                <div class="form-row mb-3 px-2 py-2 justify-content-between align-items-center border rounded">                                    
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
                                            name="adresa" id="adresa" rows="2">{{ old('adresa') }}</textarea>
                                    </div>                               
                                    <div class="form-group col-lg-6 mb-1 justify-content-center"> 
                                        <label for="observatii" class="mb-0">Observații:</label>
                                        <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}" 
                                            name="observatii" id="observatii" rows="2">{{ old('observatii') }}</textarea>
                                    </div> 
                                </div>                              
                                {{-- <div class="form-row mb-4 px-2 pt-2 d-flex justify-content-between align-items-center border rounded" style="background-color:darkcyan">
                                    <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                            <h5 class="mb-1">Date pentru facturare:</h5>
                                    </div>
                                    <div class="form-group col-lg-3 mb-2">
                                        <label for="document_de_calatorie" class="mb-0">Document de călătorie:</label>                                        
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('document_de_calatorie') ? 'is-invalid' : '' }}" 
                                            name="document_de_calatorie" 
                                            placeholder="" 
                                            value="{{ old('document_de_calatorie') }}"
                                            required> 
                                    </div>
                                    <div class="form-group col-lg-3 mb-2">
                                        <label for="expirare_document" class="mb-0"><small> Data expirării documentului:</small></label>
                                            <vue2-datepicker-buletin
                                                data-veche="{{ old('expirare_document') == '' ? '' : old('expirare_document') }}"
                                                nume-camp-db="expirare_document"
                                                tip="date"
                                                latime="150"
                                                not-before="{{ \Carbon\Carbon::today() }}"
                                            ></vue2-datepicker-buletin>
                                    </div>
                                    <div class="form-group col-lg-3 mb-2">
                                        <label for="serie_document" class="mb-0">Seria buletin / pașaport:</label>                                        
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('serie_document') ? 'is-invalid' : '' }}" 
                                            name="serie_document" 
                                            placeholder="" 
                                            value="{{ old('serie_document') }}"
                                            required> 
                                    </div>
                                    <div class="form-group col-lg-3 mb-2">
                                        <label for="cnp" class="mb-0">Cnp:</label>                                        
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('cnp') ? 'is-invalid' : '' }}" 
                                            name="cnp" 
                                            placeholder="" 
                                            value="{{ old('cnp') }}"
                                            required> 
                                    </div>
                                </div>   --}}
                                <div class="form-row px-2 py-2 justify-content-between">                                
                                    <div class="form-group col-lg-12 border-left border-warning" style="border-width:5px !important">
                                        <label for="" class="mr-4">Acord de confidențialitate:</label>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="acord_de_confidentialitate" value="1" required
                                            {{ old('acord_de_confidentialitate') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="acord_de_confidentialitate">prin utilizarea acestui formular sunteți de acord cu stocarea și procesarea datelor dvs. pe acest site web</label> 
                                        </div>
                                    </div>  
                                </div>
                                <div class="form-row mb-2 px-2 py-2 justify-content-between">                                  
                                    <div class="form-group col-lg-12 border-left border-warning" style="border-width:5px !important">
                                        <label for="" class="mr-4">Termeni și condiții:</label>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="termeni_si_conditii" value="1" required
                                            {{ old('termeni_si_conditii') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="termeni_si_conditii">prin utilizarea acestui formular sunteți de acord cu termenii și condițiile acestui site web</label> 
                                        </div>
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