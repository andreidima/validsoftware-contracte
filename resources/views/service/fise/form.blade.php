@csrf

<div class="form-row mb-0 py-3 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-0 justify-content-center"
            style="background-color:lightyellow; border-left:6px solid; border-color:goldenrod"
        >   
            {{-- <div class="form-group col-lg-9 mb-0">
            </div> --}}
            <div class="form-group col-lg-1 mb-0">
                <label for="nr_intrare" class="mb-0 pl-0">Nr. intrare:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_intrare') ? 'is-invalid' : '' }}" 
                    name="nr_intrare" 
                    placeholder="" 
                    {{-- value="{{ old('nr_intrare') == '' ? ($contracte->nr_intrare == '' ? $urmatorul_nr_intrare : '') : old('nr_intrare') }}" --}}
                    value="{{ old('nr_intrare') == '' ? ($fise->nr_intrare ?? $urmatorul_document_nr) : old('nr_intrare') }}"
                    required> 
            </div>
            <div class="form-group col-lg-1 mb-0">
                <label for="nr_iesire" class="mb-0 pl-2">Nr. ieșire:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_iesire') ? 'is-invalid' : '' }}" 
                    name="nr_iesire" 
                    placeholder="" 
                    {{-- value="{{ old('nr_iesire') == '' ? ($contracte->nr_iesire == '' ? $urmatorul_nr_iesire : '') : old('nr_iesire') }}" --}}
                    value="{{ old('nr_iesire') == '' ? ($fise->nr_iesire ?? ++$urmatorul_document_nr) : old('nr_iesire') }}"
                    required> 
            </div>
            <div class="form-group col-lg-2 mb-0">  
                <label for="tehnician_service" class="mb-0 pl-3">Tehnician service:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('tehnician_service') ? 'is-invalid' : '' }}" 
                    name="tehnician_service" 
                    placeholder="" 
                    value="{{ old('tehnician_service') ?? $fise->tehnician_service ?? auth()->user()->name ?? '' }}"
                    {{-- value="{{ old('tehnician_service') == '' ? $fise->tehnician_service ?? auth()->user()->name ?? '' : old('tehnician_service') }}" --}}
                    required> 
            </div>
            {{-- {{ auth()->user()->name }}
            @php
                dd (auth()->user()->name);
            @endphp --}}
            <div class="form-group col-lg-2 mb-0">
                <label for="data_receptie" class="mb-0 pl-1">Dată recepție:</label>  
                <vue2-datepicker
                    data-veche="{{ old('data_receptie') == '' ? ($fise->data_receptie ?? \Carbon\Carbon::today() ) : old('data_receptie') }}"
                    nume-camp-db="data_receptie"
                    tip="date"
                    latime="150"
                    {{-- not-before="{{ \Carbon\Carbon::today() }}" --}}
                ></vue2-datepicker> 
            </div>
            <div class="form-group col-lg-2 mb-0 pl-4 d-flex align-items-center">
                <div>
                    <input type="hidden" name="consultanta_it" value=0>
                    <input type="checkbox" class="form-check-input" name="consultanta_it" value="1"
                        {{ old('consultanta_it', $fise->consultanta_it) == '1' ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="consultanta_it">Consultanță IT</label>
                </div>
            </div>

        </div>
        <div class="form-row px-2 py-2 mb-0"
            style="background-color:#ddffff; border-left:6px solid; border-color:#2196F3; border-radius: 0px 0px 0px 0px"
        >    
            <div class="form-group col-lg-4 mb-2"> 
                    <label for="client_deja_inregistrat" class="mb-0 pl-3">Selectează clientul dacă este deja înregistrat:</label>
                    <div class="">    
                        <script type="application/javascript"> 
                            clientVechi={!! json_encode(old('client_deja_inregistrat', ($fise->client_id ?? ""))) !!}
                            clientiExistenti={!! json_encode($clienti) !!}
                        </script>                                     
                        <select name="client_deja_inregistrat" 
                            class="custom-select custom-select-sm rounded-pill {{ $errors->has('client_deja_inregistrat') ? 'is-invalid' : '' }}" 
                            v-model="client_deja_inregistrat"  
                            @change="changeDateClient()"
                        >
                                <option value='' selected>Selectează client</option>
                            @foreach ($clienti as $client)                           
                                <option 
                                    value='{{ $client->id }}'
                                >{{ $client->nume }} </option>                                                
                            @endforeach
                        </select>
                    </div>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-0"
            style="background-color:#ddffff; border-left:6px solid; border-color:#2196F3; border-radius: 0px 0px 0px 0px"
        >  
            <div class="form-group col-lg-5 mb-4"> 
                <script type="application/javascript"> 
                    clientVechi_nume={!! json_encode(old('nume', $fise->nume)) !!}
                </script>   
                <label for="nume" class="mb-0 pl-3">Nume:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                    name="nume" 
                    placeholder="" 
                    v-model="client_nume"
                    value="{{ old('nume') == '' ? $fise->nume : old('nume') }}"
                    required> 
            </div>
            {{-- <div class="form-group col-lg-4 mb-4"> 
                <script type="application/javascript"> 
                    clientVechi_nume_scurt={!! json_encode(old('nume_scurt', $fise->nume_scurt)) !!}
                </script>   
                <label for="nume_scurt" class="mb-0 pl-3">Nume scurt:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume_scurt') ? 'is-invalid' : '' }}" 
                    name="nume_scurt" 
                    placeholder="" 
                    v-model="client_nume_scurt"
                    value="{{ old('nume_scurt') == '' ? $fise->nume_scurt : old('nume_scurt') }}"
                    required> 
            </div>                             --}}                       
            <div class="form-group col-lg-7 mb-4">  
                <script type="application/javascript"> 
                    clientVechi_adresa={!! json_encode(old('adresa', $fise->adresa)) !!}
                </script>  
                <label for="adresa" class="mb-0 pl-3">Adresa:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('adresa') ? 'is-invalid' : '' }}" 
                    name="adresa" 
                    placeholder=""
                    v-model="client_adresa" 
                    value="{{ old('adresa') == '' ? $fise->adresa : old('adresa') }}"
                    required> 
            </div> 
            <div class="form-group col-lg-3 mb-4">  
                <script type="application/javascript"> 
                    clientVechi_nr_ord_reg_com={!! json_encode(old('nr_ord_reg_com', $fise->nr_ord_reg_com)) !!}
                </script>  
                <label for="nr_ord_reg_com" class="mb-0 pl-3">Nr. Reg. com.:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_ord_reg_com') ? 'is-invalid' : '' }}" 
                    name="nr_ord_reg_com" 
                    placeholder="" 
                    v-model="client_nr_ord_reg_com"
                    value="{{ old('nr_ord_reg_com') == '' ? $fise->nr_ord_reg_com : old('nr_ord_reg_com') }}"
                    required> 
            </div>                             
            <div class="form-group col-lg-3 mb-4">  
                <script type="application/javascript"> 
                    clientVechi_cui={!! json_encode(old('cui', $fise->cui)) !!}
                </script>  
                <label for="cui" class="mb-0 pl-3">CUI/CNP:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cui') ? 'is-invalid' : '' }}" 
                    name="cui" 
                    placeholder=""
                    v-model="client_cui" 
                    value="{{ old('cui') == '' ? $fise->cui : old('cui') }}"
                    required> 
            </div>                                                         
            <div class="form-group col-lg-3 mb-4">  
                <script type="application/javascript"> 
                    clientVechi_iban={!! json_encode(old('iban', $fise->iban)) !!}
                </script>  
                <label for="iban" class="mb-0 pl-3">Iban:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('iban') ? 'is-invalid' : '' }}" 
                    name="iban" 
                    placeholder=""
                    v-model="client_iban" 
                    value="{{ old('iban') == '' ? $fise->iban : old('iban') }}"
                    required> 
            </div>                                                          
            <div class="form-group col-lg-3 mb-4">  
                <script type="application/javascript"> 
                    clientVechi_banca={!! json_encode(old('banca', $fise->banca)) !!}
                </script>  
                <label for="banca" class="mb-0 pl-3">Banca:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('banca') ? 'is-invalid' : '' }}" 
                    name="banca" 
                    placeholder=""
                    v-model="client_banca" 
                    value="{{ old('banca') == '' ? $fise->banca : old('banca') }}"
                    required> 
            </div>                                               
            <div class="form-group col-lg-3 mb-0">  
                <script type="application/javascript"> 
                    clientVechi_reprezentant={!! json_encode(old('reprezentant', $fise->reprezentant)) !!}
                </script>  
                <label for="reprezentant" class="mb-0 pl-3">Reprezentant:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('reprezentant') ? 'is-invalid' : '' }}" 
                    name="reprezentant" 
                    placeholder=""
                    v-model="client_reprezentant" 
                    value="{{ old('reprezentant') == '' ? $fise->reprezentant : old('reprezentant') }}"
                    required> 
            </div>                                              
            <div class="form-group col-lg-3 mb-0">  
                <script type="application/javascript"> 
                    clientVechi_reprezentant_functie={!! json_encode(old('reprezentant_functie', $fise->reprezentant_functie)) !!}
                </script>  
                <label for="reprezentant_functie" class="mb-0 pl-3"><small>Reprezentant funcție:</small></label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('reprezentant_functie') ? 'is-invalid' : '' }}" 
                    name="reprezentant_functie" 
                    placeholder=""
                    v-model="client_reprezentant_functie" 
                    value="{{ old('reprezentant_functie') == '' ? $fise->reprezentant_functie : old('reprezentant_functie') }}"
                    required> 
            </div>  
            <div class="form-group col-lg-2 mb-0">  
                <script type="application/javascript"> 
                    clientVechi_telefon={!! json_encode(old('telefon', $fise->telefon)) !!}
                </script>  
                <label for="telefon" class="mb-0 pl-3">Telefon:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                    name="telefon" 
                    placeholder="Ex: 07xyzzzzzz" 
                    v-model="client_telefon" 
                    value="{{ old('telefon') == '' ? $fise->telefon : old('telefon') }}"
                    required> 
                {{ old('telefon') }}
            </div>
            <div class="form-group col-lg-2 mb-0">  
                <script type="application/javascript"> 
                    clientVechi_email={!! json_encode(old('email', $fise->email)) !!}
                </script>  
                <label for="email" class="mb-0 pl-3">Email:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                    name="email" 
                    placeholder=""
                    v-model="client_email" 
                    value="{{ old('email') == '' ? $fise->email : old('email') }}"
                    required> 
            </div>
            {{-- <div class="form-group col-lg-2 mb-0">  
                <script type="application/javascript"> 
                    clientVechi_email_dpo={!! json_encode(old('email_dpo', $fise->email_dpo)) !!}
                </script>  
                <label for="email_dpo" class="mb-0 pl-3">Email dpo:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('email_dpo') ? 'is-invalid' : '' }}" 
                    name="email_dpo" 
                    placeholder=""
                    v-model="client_email_dpo" 
                    value="{{ old('email_dpo') == '' ? $fise->email_dpo : old('email_dpo') }}"
                    required> 
            </div> --}}
            <div class="form-group col-lg-2 mb-1">  
                <script type="application/javascript"> 
                    clientVechi_site_web={!! json_encode(old('site_web', $fise->site_web)) !!}
                </script>  
                <label for="site_web" class="mb-0 pl-3">Site web:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('site_web') ? 'is-invalid' : '' }}" 
                    name="site_web" 
                    placeholder=""
                    v-model="client_site_web" 
                    value="{{ old('site_web') == '' ? $fise->site_web : old('site_web') }}"
                    required> 
            </div>
            <div class="form-group col-lg-12 mb-0"> 
                <small>
                    * Dacă adaugi un client nou, acesta se va salva automat și în tabela de clienți.
                    <br />
                    ** Dacă selectezi un client deja înregistrat, și modifici din datele acestuia, clientul va fi actualizat și în tabela de clienți.
                </small>
            </div>
        </div>
        <div class="form-row px-2 py-2"
            style="background-color:#FFE8E8; border-left:6px solid; border-color:#801515; border-radius: 0px 0px 0px 0px"
            >  
            <div class="form-group col-lg-6">
                <label for="descriere_echipament" class="mb-0 pl-3">Descriere echipament:</label>                                  
                <textarea class="form-control {{ $errors->has('descriere_echipament') ? 'is-invalid' : '' }}" 
                    name="descriere_echipament"
                    {{-- placeholder="Descriere echipament" --}}
                    >{{ old('descriere_echipament') == '' ? $fise->descriere_echipament : old('descriere_echipament') }}</textarea>
            </div>
            <div class="form-group col-lg-6">
                <label for="defect_reclamat" class="mb-0 pl-3">Defect reclamat:</label>                                  
                <textarea class="form-control {{ $errors->has('defect_reclamat') ? 'is-invalid' : '' }}" 
                    name="defect_reclamat"
                    {{-- placeholder="Descriere defect" --}}
                    >{{ old('defect_reclamat') == '' ? $fise->defect_reclamat : old('defect_reclamat') }}</textarea>
            </div>
        </div>
        <div class="form-row px-2 py-2"
            style="background-color:#B8FFB8; border-left:6px solid; border-color:mediumseagreen; border-radius: 0px 0px 0px 0px"
            >  
            <div class="form-group col-lg-6">
                <label for="defect_constatat" class="mb-0 pl-3">Defect constatat:</label>                                  
                <textarea class="form-control {{ $errors->has('defect_constatat') ? 'is-invalid' : '' }}" 
                    name="defect_constatat"
                    {{-- placeholder="Descriere defect" --}}
                    >{{ old('defect_constatat') == '' ? $fise->defect_constatat : old('defect_constatat') }}</textarea>
            </div>
            <div class="form-group col-lg-6">
                <label for="rezultat_service" class="mb-0 pl-3">Rezultat service:</label>                                  
                <textarea class="form-control {{ $errors->has('rezultat_service') ? 'is-invalid' : '' }}" 
                    name="rezultat_service"
                    {{-- placeholder="Rezultat service" --}}
                    >{{ old('rezultat_service') == '' ? $fise->rezultat_service : old('rezultat_service') }}</textarea>
            </div>                              
            <div class="form-group col-lg-12 mb-2">  
                <label for="servicii_efectuate" class="mb-0 pl-1">Servicii efectuate:</label>
                    <div class="form-row">
                            @foreach ($servicii as $serviciu)
                                <div class="col-lg-6 mb-2 rounded-pill">
                                    <div class="custom-control custom-checkbox border border-4" style="padding-left:30px; display: inline-block; border-color:mediumseagreen;">
                                        <input type="checkbox" class="custom-control-input" 
                                            name="servicii_selectate[]" 
                                            value="{{ $serviciu->id }}"
                                            style="padding:20px" id="{{ $serviciu->id }}"
                                            @if (old("servicii_selectate"))
                                                {{ in_array($serviciu->id, old("servicii_selectate")) ? "checked":"" }}
                                            @else
                                                {{ in_array($serviciu->id, $fise->servicii->pluck('id')->toArray()) ? "checked":"" }}
                                            @endif
                                            >
                                        <label class="custom-control-label text-white px-1" for="{{ $serviciu->id }}" style="background-color:mediumseagreen;">
                                            {{ $serviciu->nume }}
                                            {{ $serviciu->pret ? ' - ' . $serviciu->pret . ' RON' : ''}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                    </div>
            </div>  
            <div class="form-group col-lg-6">
                <label for="observatii" class="mb-0 pl-3">Observații:</label>                                  
                <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}" 
                    name="observatii"
                    {{-- placeholder="Observații" --}}
                    >{{ old('observatii') == '' ? $fise->observatii : old('observatii') }}</textarea>
            </div>
            <div class="form-group col-lg-6 mb-0 d-flex justify-content-center align-items-center">
                <div>
                    <label for="data_ridicare" class="mb-0 pl-1">Dată ridicare:</label>  
                    <vue2-datepicker
                        data-veche="{{ old('data_ridicare') == '' ? $fise->data_ridicare : old('data_ridicare') }}"
                        nume-camp-db="data_ridicare"
                        tip="date"
                        latime="150"
                        {{-- not-before="{{ \Carbon\Carbon::today() }}" --}}
                    ></vue2-datepicker> 
                </div>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-4"
            style="background-color:rgb(255, 219, 172); border-left:6px solid; border-color:rgb(143, 81, 20); border-radius: 0px 0px 0px 0px"
            > 
             <div class="col-lg-4 d-flex align-items-center">
                Deschidere fișă: 
                    @isset ($fise->created_at)
                        {{ \Carbon\Carbon::parse($fise->created_at)->isoFormat('HH:mm - DD.MM.YYYY') }}
                    @else
                        nu este salvată încă
                    @endisset
             </div>
             <div class="col-lg-4 justify-content-center d-flex align-items-center">
                <span for="durata_interventie" class="d-flex align-items-center mr-2">
                    Durata intervenție:
                </span>
                <vue2-datepicker-time
                    data-veche="{{ old('durata_interventie') == '' ? ($fise->durata_interventie ?? \Carbon\Carbon::today() ) : old('durata_interventie') }}"
                    nume-camp-db="durata_interventie"
                    tip="time"
                    latime="150"
                    {{-- not-before="{{ \Carbon\Carbon::today() }}" --}}
                ></vue2-datepicker-time> 
             </div>
             {{-- <div class="col-lg-4 d-flex justify-content-center align-items-center">
                <div>
                    <input type="hidden" name="gratuit" value=0>
                    <input type="checkbox" class="form-check-input" name="gratuit" value="1"
                        {{ old('gratuit', $fise->gratuit) == '1' ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="gratuit">Gratuit</label>
                </div>
             </div> --}}
            <div class="form-group col-lg-4 mb-0 d-flex justify-content-end">  
                <div class="d-flex align-items-center" style="width:120px">
                    <label for="cost" class="mb-0 pl-3 mr-1">Cost:</label>                                      
                    <input 
                        type="text" 
                        class="form-control form-control-sm text-right rounded-pill {{ $errors->has('cost') ? 'is-invalid' : '' }}" 
                        name="cost" 
                        placeholder="" 
                        value="{{ old('cost', $fise->cost) }}"
                        required> 
                </div>
            </div>
        </div>
        
                                
        <div class="form-row mb-1 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 border border-dark rounded-pill">{{ $buttonText }}</button> 
                <a class="btn btn-secondary btn-sm border border-dark rounded-pill" href="/service/fise">Renunță</a> 
                {{-- <a class="btn btn-primary btn-sm mr-2 border border-dark rounded-pill" href="#">{{ $buttonText }}</a>  --}}
                {{-- <a class="btn btn-secondary btn-sm mr-4 border border-dark rounded-pill" href="#">Renunță</a>  --}}
            </div>
        </div>
    </div>
</div>