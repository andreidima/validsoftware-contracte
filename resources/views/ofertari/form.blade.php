@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-2 justify-content-center">    
            <div class="form-group col-lg-2 mb-0">  
                <label for="nr_document" class="mb-0 pl-3">Nr. document:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_document') ? 'is-invalid' : '' }}" 
                    name="nr_document" 
                    placeholder="" 
                    {{-- value="{{ old('nr_document') == '' ? ($ofertari->nr_document == '' ? $urmatorul_document_nr : '') : old('nr_document') }}" --}}
                    value="{{ old('nr_document') == '' ? ($ofertari->nr_document ?? $urmatorul_document_nr) : old('nr_document') }}"
                    required> 
            </div> 
            <div class="form-group col-lg-3 mb-0 text-center">
                <label for="data_emitere" class="mb-0 pl-1">Data emitere:</label>
                <vue2-datepicker
                    data-veche="{{ old('data_emitere') ?? $ofertari->data_emitere ?? \Carbon\Carbon::today() }}"
                    nume-camp-db="data_emitere"
                    tip="date"
                    latime="150"
                    not-before="{{ \Carbon\Carbon::today() }}"
                ></vue2-datepicker>
            </div>     
        </div>
        <div class="form-row px-2 py-2 mb-4 justify-content-center">                         
            <div class="form-group col-lg-5 mb-0">  
                <label for="client_id" class="mb-0 pl-3">Client:</label>                                      
                <select name="client_id" 
                    class="custom-select-sm custom-select rounded-pill {{ $errors->has('client_id') ? 'is-invalid' : '' }}"
                >
                        <option value='' selected>Selectează</option>
                    @foreach ($clienti as $client)                           
                        <option 
                            value='{{ $client->id }}'
                                @if(old('client_id') !== null)
                                    @if ($client->id == old('client_id'))
                                        selected
                                    @endif
                                @else
                                    @if ($client->id == $ofertari->client_id)
                                        selected
                                    @endif
                                @endif
                        >{{ $client->nume }} </option>                                                
                    @endforeach
                </select> 
            </div>    
            <div class="form-group col-lg-3 mb-0 text-center">
                <label for="data_cerere" class="mb-0 pl-1">Data cerere:</label>
                <vue2-datepicker
                    data-veche="{{ old('data_cerere') ?? $ofertari->data_cerere ?? \Carbon\Carbon::today() }}"
                    nume-camp-db="data_cerere"
                    tip="date"
                    latime="150"
                    not-before="{{ \Carbon\Carbon::today() }}"
                ></vue2-datepicker>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-0">                              
            <div class="form-group col-lg-12 mb-0">  
                <label for="descriere_solicitare" class="mb-0 pl-1">Descriere Solicitare:</label>
                <vue2-editor
                    text-vechi="{{ old('descriere_solicitare') == '' ? $ofertari->descriere_solicitare : old('descriere_solicitare') }}"
                    nume-camp-db="descriere_solicitare"
                ></vue2-editor>
            </div>   
        </div>
        <div class="form-row px-2 py-2 mb-0">                              
            <div class="form-group col-lg-12 mb-0">  
                <label for="propunere_tehnica_si_comerciala" class="mb-0 pl-1">Propunere tehnică și comercială:</label>
                <vue2-editor
                    text-vechi="{{ old('propunere_tehnica_si_comerciala') == '' ? $ofertari->propunere_tehnica_si_comerciala : old('propunere_tehnica_si_comerciala') }}"
                    nume-camp-db="propunere_tehnica_si_comerciala"
                ></vue2-editor>
            </div>   
        </div>
        <div class="form-row px-2 py-2 mb-4">                              
            <div class="form-group col-lg-12 mb-0">  
                <label for="propunere_servicii" class="mb-0 pl-1">Propunere servicii:</label>
                    <div class="form-row">
                            @foreach ($servicii as $serviciu)
                                <div class="col-lg-12 mb-2 rounded-pill">
                                    <div class="custom-control custom-checkbox border border-4 border-primary" style="padding-left:30px; display: inline-block;">
                                        <input type="checkbox" class="custom-control-input" 
                                            name="servicii_selectate[]" 
                                            value="{{ $serviciu->id }}"
                                            style="padding:20px" id="{{ $serviciu->id }}"
                                            @if (old("servicii_selectate"))
                                                {{ in_array($serviciu->id, old("servicii_selectate")) ? "checked":"" }}
                                            @else
                                                {{ in_array($serviciu->id, $ofertari->servicii->pluck('id')->toArray()) ? "checked":"" }}
                                            @endif
                                            >
                                        <label class="custom-control-label bg-primary text-white px-1" for="{{ $serviciu->id }}">
                                            {{ $serviciu->nume }}
                                            {{ $serviciu->pret ? ' - ' . $serviciu->pret . ' RON' : ''}}{{ $serviciu->recurenta ? '/ ' . $serviciu->recurenta : '' }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                    </div>
            </div>   
        </div>
        
                                
        <div class="form-row mb-3 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/ofertari">Renunță</a> 
            </div>
        </div>
    </div>
</div>