@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-0"
            {{-- style="background-color:#ddffff; border-left:6px solid; border-color:#2196F3" --}}
        >   
            <div class="form-group col-lg-9 mb-4">
            </div>
            <div class="d-flex col-lg-3 mb-4 justify-content-end align-items-center">
                <label for="fisa_nr" class="mb-0 mr-2">Nr. fișă service:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm col-4 rounded-pill {{ $errors->has('fisa_nr') ? 'is-invalid' : '' }}" 
                    name="fisa_nr" 
                    placeholder="" 
                    {{-- value="{{ old('fisa_nr') == '' ? ($contracte->fisa_nr == '' ? $urmatorul_fisa_nr : '') : old('fisa_nr') }}" --}}
                    value="{{ old('fisa_nr') == '' ? ($fisa_service->fisa_nr ?? $urmatorul_document_nr) : old('fisa_nr') }}"
                    required> 
            </div>
            {{-- <div class="form-group col-lg-10 mb-4">
            </div>
            <div class="form-group col-lg-2 mb-4">
                <label for="data_terminare" class="mb-0 pl-1">Data:</label>  
                <vue2-datepicker
                    data-veche="{{ old('data_terminare') == '' ? $contracte->data_terminare : old('data_terminare') }}"
                    nume-camp-db="data_terminare"
                    tip="date"
                    latime="150"
                    not-before="{{ \Carbon\Carbon::today() }}"
                ></vue2-datepicker> 
            </div> --}}

        </div>
        <div class="form-row px-2 py-2 mb-0"
            style="background-color:#ddffff; border-left:6px solid; border-color:#2196F3; border-radius: 40px 40px 0px 0px"
        >    
            <div class="form-group col-lg-4 mb-2"> 
                    <label for="client_deja_inregistrat" class="mb-0 pl-3">Selectează clientul dacă este deja înregistrat:</label>
                    <div class="">    
                        <script type="application/javascript"> 
                            clientVechi={!! json_encode(old('client_deja_inregistrat', ($fisa_service->client_id ?? ""))) !!}
                            clientiExistenti={!! json_encode($clienti) !!}
                        </script>                                     
                        <select name="client_deja_inregistrat" 
                            class="custom-select custom-select-sm rounded-pill {{ $errors->has('client_deja_inregistrat') ? 'is-invalid' : '' }}" 
                            v-model="client_deja_inregistrat"  
                            @change="getDateClient()"
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
        <div class="form-row px-2 py-2 mb-4"
            style="background-color:#ddffff; border-left:6px solid; border-color:#2196F3; border-radius: 0px 0px 40px 40px"
        >  
            <div class="form-group col-lg-4 mb-4"> 
                <script type="application/javascript"> 
                    clientVechi_nume={!! json_encode(old('nume', $fisa_service->nume)) !!}
                </script>   
                <label for="nume" class="mb-0 pl-3">Nume:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                    name="nume" 
                    placeholder="" 
                    v-model="client_nume"
                    value="{{ old('nume') == '' ? $fisa_service->nume : old('nume') }}"
                    required> 
            </div>
            <div class="form-group col-lg-4 mb-4"> 
                <script type="application/javascript"> 
                    clientVechi_nume_scurt={!! json_encode(old('nume_scurt', $fisa_service->nume_scurt)) !!}
                </script>   
                <label for="nume_scurt" class="mb-0 pl-3">Nume scurt:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume_scurt') ? 'is-invalid' : '' }}" 
                    name="nume_scurt" 
                    placeholder="" 
                    v-model="client_nume_scurt"
                    value="{{ old('nume_scurt') == '' ? $fisa_service->nume_scurt : old('nume_scurt') }}"
                    required> 
            </div>                            
            <div class="form-group col-lg-2 mb-4">  
                <script type="application/javascript"> 
                    clientVechi_nr_ord_reg_com={!! json_encode(old('nr_ord_reg_com', $fisa_service->nr_ord_reg_com)) !!}
                </script>  
                <label for="nr_ord_reg_com" class="mb-0 pl-3">Nr. Reg. com.:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_ord_reg_com') ? 'is-invalid' : '' }}" 
                    name="nr_ord_reg_com" 
                    placeholder="" 
                    v-model="client_nr_ord_reg_com"
                    value="{{ old('nr_ord_reg_com') == '' ? $fisa_service->nr_ord_reg_com : old('nr_ord_reg_com') }}"
                    required> 
            </div>                             
            <div class="form-group col-lg-2 mb-4">  
                <script type="application/javascript"> 
                    clientVechi_cui={!! json_encode(old('cui', $fisa_service->cui)) !!}
                </script>  
                <label for="cui" class="mb-0 pl-3">CUI/CNP:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cui') ? 'is-invalid' : '' }}" 
                    name="cui" 
                    placeholder=""
                    v-model="client_cui" 
                    value="{{ old('cui') == '' ? $fisa_service->cui : old('cui') }}"
                    required> 
            </div>                           
            <div class="form-group col-lg-6 mb-4">  
                <script type="application/javascript"> 
                    clientVechi_adresa={!! json_encode(old('adresa', $fisa_service->adresa)) !!}
                </script>  
                <label for="adresa" class="mb-0 pl-3">Adresa:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('adresa') ? 'is-invalid' : '' }}" 
                    name="adresa" 
                    placeholder=""
                    v-model="client_adresa" 
                    value="{{ old('adresa') == '' ? $fisa_service->adresa : old('adresa') }}"
                    required> 
            </div>                                                      
            <div class="form-group col-lg-3 mb-4">  
                <script type="application/javascript"> 
                    clientVechi_iban={!! json_encode(old('iban', $fisa_service->iban)) !!}
                </script>  
                <label for="iban" class="mb-0 pl-3">Iban:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('iban') ? 'is-invalid' : '' }}" 
                    name="iban" 
                    placeholder=""
                    v-model="client_iban" 
                    value="{{ old('iban') == '' ? $fisa_service->iban : old('iban') }}"
                    required> 
            </div>                                                          
            <div class="form-group col-lg-3 mb-4">  
                <script type="application/javascript"> 
                    clientVechi_banca={!! json_encode(old('banca', $fisa_service->banca)) !!}
                </script>  
                <label for="banca" class="mb-0 pl-3">Banca:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('banca') ? 'is-invalid' : '' }}" 
                    name="banca" 
                    placeholder=""
                    v-model="client_banca" 
                    value="{{ old('banca') == '' ? $fisa_service->banca : old('banca') }}"
                    required> 
            </div>                                               
            <div class="form-group col-lg-2 mb-0">  
                <script type="application/javascript"> 
                    clientVechi_reprezentant={!! json_encode(old('reprezentant', $fisa_service->reprezentant)) !!}
                </script>  
                <label for="reprezentant" class="mb-0 pl-3">Reprezentant:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('reprezentant') ? 'is-invalid' : '' }}" 
                    name="reprezentant" 
                    placeholder=""
                    v-model="client_reprezentant" 
                    value="{{ old('reprezentant') == '' ? $fisa_service->reprezentant : old('reprezentant') }}"
                    required> 
            </div>                                              
            <div class="form-group col-lg-2 mb-0">  
                <script type="application/javascript"> 
                    clientVechi_reprezentant_functie={!! json_encode(old('reprezentant_functie', $fisa_service->reprezentant_functie)) !!}
                </script>  
                <label for="reprezentant_functie" class="mb-0 pl-3"><small>Reprezentant funcție:</small></label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('reprezentant_functie') ? 'is-invalid' : '' }}" 
                    name="reprezentant_functie" 
                    placeholder=""
                    v-model="client_reprezentant_functie" 
                    value="{{ old('reprezentant_functie') == '' ? $fisa_service->reprezentant_functie : old('reprezentant_functie') }}"
                    required> 
            </div>  
            <div class="form-group col-lg-2 mb-0">  
                <script type="application/javascript"> 
                    clientVechi_telefon={!! json_encode(old('telefon', $fisa_service->telefon)) !!}
                </script>  
                <label for="telefon" class="mb-0 pl-3">Telefon:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                    name="telefon" 
                    placeholder=""
                    v-model="client_telefon" 
                    value="{{ old('telefon') == '' ? $fisa_service->telefon : old('telefon') }}"
                    required> 
            </div>
            <div class="form-group col-lg-2 mb-0">  
                <script type="application/javascript"> 
                    clientVechi_email={!! json_encode(old('email', $fisa_service->email)) !!}
                </script>  
                <label for="email" class="mb-0 pl-3">Email:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                    name="email" 
                    placeholder=""
                    v-model="client_email" 
                    value="{{ old('email') == '' ? $fisa_service->email : old('email') }}"
                    required> 
            </div>
            <div class="form-group col-lg-2 mb-0">  
                <script type="application/javascript"> 
                    clientVechi_email_dpo={!! json_encode(old('email_dpo', $fisa_service->email_dpo)) !!}
                </script>  
                <label for="email_dpo" class="mb-0 pl-3">Email dpo:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('email_dpo') ? 'is-invalid' : '' }}" 
                    name="email_dpo" 
                    placeholder=""
                    v-model="client_email_dpo" 
                    value="{{ old('email_dpo') == '' ? $fisa_service->email_dpo : old('email_dpo') }}"
                    required> 
            </div>
            <div class="form-group col-lg-2 mb-0">  
                <script type="application/javascript"> 
                    clientVechi_site_web={!! json_encode(old('site_web', $fisa_service->site_web)) !!}
                </script>  
                <label for="site_web" class="mb-0 pl-3">Site web:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('site_web') ? 'is-invalid' : '' }}" 
                    name="site_web" 
                    placeholder=""
                    v-model="client_site_web" 
                    value="{{ old('site_web') == '' ? $fisa_service->site_web : old('site_web') }}"
                    required> 
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-0"
            style="background-color:honeydew; border-left:6px solid; border-color:mediumseagreen; border-radius: 40px 40px 40px 40px"
            >  
            <div class="form-group col-lg-6">
                <label for="descriere_echipament" class="mb-0 pl-3">Descriere echipament:</label>                                  
                <textarea class="form-control {{ $errors->has('descriere_echipament') ? 'is-invalid' : '' }}" 
                    name="descriere_echipament"
                    placeholder="Descriere echipament"
                    >{{ old('descriere_echipament') == '' ? $fisa_service->descriere_echipament : old('descriere_echipament') }}</textarea>
            </div>
            <div class="form-group col-lg-6">
                <label for="descriere_defect" class="mb-0 pl-3">Descriere defect:</label>                                  
                <textarea class="form-control {{ $errors->has('descriere_defect') ? 'is-invalid' : '' }}" 
                    name="descriere_defect"
                    placeholder="Descriere defect"
                    >{{ old('descriere_defect') == '' ? $fisa_service->descriere_defect : old('descriere_defect') }}</textarea>
            </div>
            <div class="form-group col-lg-6">
                <label for="rezultat_service" class="mb-0 pl-3">Rezultat service:</label>                                  
                <textarea class="form-control {{ $errors->has('rezultat_service') ? 'is-invalid' : '' }}" 
                    name="rezultat_service"
                    placeholder="Rezultat service"
                    >{{ old('rezultat_service') == '' ? $fisa_service->rezultat_service : old('rezultat_service') }}</textarea>
            </div>
            <div class="form-group col-lg-6">
                <label for="observatii" class="mb-0 pl-3">Observații:</label>                                  
                <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}" 
                    name="observatii"
                    placeholder="Observații"
                    >{{ old('observatii') == '' ? $fisa_service->observatii : old('observatii') }}</textarea>
            </div>
        </div>
        
                                
        <div class="form-row mb-3 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/fise_service">Renunță</a> 
            </div>
        </div>
    </div>
</div>