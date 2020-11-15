@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-2 justify-content-center">      
            <div class="form-group col-lg-6">  
                <label for="client_id" class="mb-0 pl-3">Firma:</label>
                <div class="">                                     
                    <select name="client_id" 
                        class="custom-select custom-select-sm rounded-pill {{ $errors->has('client_id') ? 'is-invalid' : '' }}" 
                    >
                            <option value='' selected>Selectează client</option>
                        @foreach ($clienti as $client)                           
                            <option 
                                value='{{ $client->id }}'
                                {{ $client->id === old('client_id', $anydesk->client_id) ? 'selected' : '' }}
                            >{{ $client->nume }}</option>                   
                        @endforeach
                    </select>
                </div>
                {{-- @php
                    dd(old('nume', $anydesk->client_id));
                @endphp --}}
            </div>  
            <div class="form-group col-lg-6">  
                <label for="nume" class="mb-0 pl-3">Persoana:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                    name="nume" 
                    placeholder="" 
                    value="{{ old('nume', $anydesk->nume) }}"
                    required> 
            </div>  
            <div class="form-group col-lg-4">  
                <label for="telefon" class="mb-0 pl-3">Telefon:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                    name="telefon" 
                    placeholder="" 
                    value="{{ old('telefon', $anydesk->telefon) }}"
                    required> 
            </div> 
            <div class="form-group col-lg-4">  
                <label for="email" class="mb-0 pl-3">Email:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                    name="email" 
                    placeholder="" 
                    value="{{ old('email', $anydesk->email) }}"
                    required> 
            </div>
            <div class="form-group col-lg-4">  
                <label for="cod_anydesk" class="mb-0 pl-3">Cod AnyDesk:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cod_anydesk') ? 'is-invalid' : '' }}" 
                    name="cod_anydesk" 
                    placeholder="" 
                    value="{{ old('cod_anydesk', $anydesk->cod_anydesk) }}"
                    required> 
            </div> 
            <div class="form-group col-lg-12">
                <label for="observatii" class="mb-0 pl-3">Observații:</label>                                  
                <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}" 
                    name="observatii"
                    {{-- placeholder="Observații" --}}
                    >{{ old('observatii') == '' ? $anydesk->observatii : old('observatii') }}</textarea>
            </div>
        </div>        
                                
        <div class="form-row mb-3 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/service/anydeskuri">Renunță</a> 
            </div>
        </div>
    </div>
</div>