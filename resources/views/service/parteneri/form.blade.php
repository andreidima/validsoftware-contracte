@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row mb-0 px-2 py-2">                                    
            <div class="form-group col-lg-12 mb-0">  
                <label for="nume" class="mb-0 pl-3">Nume Partener:*</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                    name="nume" 
                    placeholder="" 
                    value="{{ old('nume', $partener->nume) }}"
                    required> 
            </div>           
        </div>
        <div class="form-row px-2 py-2 mb-0">                                   
            <div class="form-group col-lg-6 mb-0">  
                <label for="cui" class="mb-0 pl-3">Cui:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cui') ? 'is-invalid' : '' }}" 
                    name="cui" 
                    placeholder="" 
                    value="{{ old('cui', $partener->cui) }}"
                    required> 
            </div> 
        </div>
        <div class="form-row px-2 py-2 mb-0">                              
            <div class="form-group col-lg-12 mb-0">  
                <label for="adresa" class="mb-0 pl-3">Adresa:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('adresa') ? 'is-invalid' : '' }}" 
                    name="adresa" 
                    placeholder="" 
                    value="{{ old('adresa', $partener->adresa) }}"
                    required> 
            </div>  
        </div>     
  
        <div class="form-row px-2 pt-2 mb-0">
            <div class="form-group col-lg-6 mb-0">  
                <label for="telefon" class="mb-0 pl-3">Telefon:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                    name="telefon" 
                    placeholder="Ex: 07xyzzzzzz" 
                    value="{{ old('telefon', $partener->telefon) }}"
                    required> 
            </div>
            <div class="form-group col-lg-6 mb-0">  
                <label for="email" class="mb-0 pl-3">Email:</label>
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                    name="email" 
                    placeholder="" 
                    value="{{ old('email', $partener->email) }}"
                    aria-describedby="emailHelp"
                    required> 
                <small id="emailHelp" class="form-text text-muted pl-3">Ex: email1@xxx.com, email2@yyy.ro, etc</small>
            </div>
        </div>
        <div class="form-row px-2 pb-2 mb-0">
            <div class="form-group col-lg-12 mb-0">  
                <label for="google_maps_link" class="mb-0 pl-3">Google maps link:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('google_maps_link') ? 'is-invalid' : '' }}" 
                    name="google_maps_link" 
                    placeholder="" 
                    value="{{ old('google_maps_link', $partener->google_maps_link) }}"
                    required> 
            </div>
        </div>
        
                                
        <div class="form-row px-2 py-3 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/service/parteneri">Renunță</a> 
            </div>
        </div>
    </div>
</div>