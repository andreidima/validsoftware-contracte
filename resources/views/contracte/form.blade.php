@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-0">    
            <div class="form-group col-lg-3 mb-0">  
                <label for="contract_nr" class="mb-0 pl-3">Nr. contract:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('contract_nr') ? 'is-invalid' : '' }}" 
                    name="contract_nr" 
                    placeholder="" 
                    value="{{ old('contract_nr') == '' ? ($contracte->contract_nr == '' ? $urmatorul_contract_nr : '') : old('contract_nr') }}"
                    required> 
            </div>                               
            <div class="form-group col-lg-9 mb-0">  
                <label for="client_id" class="mb-0 pl-3">Client:</label>                                      
                <select name="client_id" 
                    class="custom-select-sm custom-select rounded-pill {{ $errors->has('client_id') ? 'is-invalid' : '' }}"
                >
                    @foreach ($clienti as $client)                           
                        <option value='{{ $client->id }}'>{{ $client->nume }} </option>                                                
                    @endforeach
                </select> 
            </div> 
        </div>
        <div class="form-row px-2 py-2 mb-0">                              
            <div class="form-group col-lg-6 mb-0">  
                <label for="adresa" class="mb-0 pl-3">Data contract:</label>
            </div>                           
            <div class="form-group col-lg-6 mb-0">  
                <label for="iban" class="mb-0 pl-3">Data începere:</label>   
            </div>  
        </div>
        
                                
        <div class="form-row mb-3 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/clienti">Renunță</a> 
            </div>
        </div>
    </div>
</div>