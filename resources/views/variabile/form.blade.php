@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-2">                          
            <div class="form-group col-lg-6 mb-0">  
                <label for="nume" class="mb-0 pl-1">Nume:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                    name="nume" 
                    placeholder="" 
                    value="{{ old('nume') == '' ? $variabile->nume : old('nume') }}"
                    disabled> 
            </div>                        
            <div class="form-group col-lg-6 mb-0">  
                <label for="valoare" class="mb-0 pl-1">Valoare:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('valoare') ? 'is-invalid' : '' }}" 
                    name="valoare" 
                    placeholder="" 
                    value="{{ old('valoare') == '' ? $variabile->valoare : old('valoare') }}"
                    required> 
            </div>  
        </div>
        
                                
        <div class="form-row mb-3 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/cron-jobs">Renunță</a> 
            </div>
        </div>
    </div>
</div>