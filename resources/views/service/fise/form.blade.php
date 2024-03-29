@csrf

<script type="application/javascript">
    clientVechi_iban={!! json_encode(old('iban', $fise->iban)) !!}
    clientVechi={!! json_encode(old('client_deja_inregistrat', ($fise->client_id ?? ""))) !!}
    clientiExistenti={!! json_encode($clienti) !!}
    clientVechi_nume={!! json_encode(old('nume', $fise->nume)) !!}
    clientVechi_adresa={!! json_encode(old('adresa', $fise->adresa)) !!}
    clientVechi_nr_ord_reg_com={!! json_encode(old('nr_ord_reg_com', $fise->nr_ord_reg_com)) !!}
    clientVechi_cui={!! json_encode(old('cui', $fise->cui)) !!}
    clientVechi_sex={!! json_encode(old('sex', $fise->sex)) !!}
    clientVechi_banca={!! json_encode(old('banca', $fise->banca)) !!}
    clientVechi_reprezentant={!! json_encode(old('reprezentant', $fise->reprezentant)) !!}
    clientVechi_reprezentant_functie={!! json_encode(old('reprezentant_functie', $fise->reprezentant_functie)) !!}
    clientVechi_telefon={!! json_encode(old('telefon', $fise->telefon)) !!}
    clientVechi_email={!! json_encode(old('email', $fise->email)) !!}
    clientVechi_site_web={!! json_encode(old('site_web', $fise->site_web)) !!}
    servicii={!! json_encode($servicii) !!}
    serviciiSelectate={!! json_encode(old('servicii_selectate', $servicii_curente_selectate ?? [])) !!}
    descriereEchipament = {!! json_encode(old('descriere_echipament', $fise->descriere_echipament) ?? '') !!}
</script>

<div class="form-row mb-0 py-3 d-flex border-radius: 0px 0px 40px 40px" id="fisaService">
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
                <vue-datepicker-next
                    data-veche="{{ old('data_receptie') == '' ? ($fise->data_receptie ?? \Carbon\Carbon::today() ) : old('data_receptie') }}"
                    nume-camp-db="data_receptie"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                    {{-- not-before="{{ \Carbon\Carbon::today() }}" --}}
                ></vue-datepicker-next>
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
            <div class="form-group col-lg-2 mb-0 pl-4 d-flex align-items-center">
                <div>
                    <input type="hidden" name="instalare_anydesk" value=0>
                    <input type="checkbox" class="form-check-input" name="instalare_anydesk" value="1"
                        {{ old('instalare_anydesk', $fise->instalare_anydesk) == '1' ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="instalare_anydesk">Instalare Anydesk</label>
                </div>
            </div>

        </div>
        <div class="form-row px-2 py-2 mb-0"
            style="background-color:#ddffff; border-left:6px solid; border-color:#2196F3; border-radius: 0px 0px 0px 0px"
        >
            <div class="form-group col-lg-4 mb-2">
                <label for="client_deja_inregistrat" class="mb-0 pl-2">Selectează clientul dacă este deja înregistrat:</label>
                <div class="">
                    <select name="client_deja_inregistrat"
                        class="custom-select custom-select-sm rounded-pill {{ $errors->has('client_deja_inregistrat') ? 'is-invalid' : '' }}"
                        v-model="client_deja_inregistrat"
                        @change="changeDateClient();"
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
            <div class="form-group col-lg-1 mb-2 d-flex justify-content-center align-items-center">
                <label for="" class="mb-0 pl-2">sau</label>
            </div>
            <div class="form-group col-lg-4 mb-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <label for="client_nume_autocomplete2" class="mb-0 pl-2">
                            Caută clientul
                            :
                        </label>
                        <input
                            type="text"
                            v-model="client_nume_autocomplete2"
                            v-on:keyup="autoComplete2()"
                            class="form-control form-control-sm rounded-pill {{ $errors->has('client_nume_autocomplete2') ? 'is-invalid' : '' }}"
                            name="client_nume_autocomplete2"
                            placeholder=""
                            {{-- value="{{ old('client_nume_autocomplete2') }}" --}}
                            autocomplete="off"
                            required>
                        <div v-cloak v-if="clienti_lista_autocomplete2.length" class="panel-footer">
                            <div class="list-group">
                                    <button class="list-group-item list-group-item list-group-item-action py-0"
                                        v-for="client in clienti_lista_autocomplete2"
                                        v-on:click="
                                            client_nume_autocomplete2 = client.nume;

                                            client_deja_inregistrat = client.id;
                                            client_nume = client.nume;
                                            client_nr_ord_reg_com = client.nr_ord_reg_com;
                                            client_cui = client.cui;
                                            client_sex = client.sec;
                                            client_adresa = client.adresa;
                                            client_iban = client.iban;
                                            client_banca = client.banca;
                                            client_reprezentant = client.reprezentant;
                                            client_reprezentant_functie = client.reprezentant_functie;
                                            client_telefon = client.telefon;
                                            client_email = client.email;
                                            client_site_web = client.site_web;

                                            clienti_lista_autocomplete2 = '';
                                        ">
                                            @{{ client.nume }}
                                    </button>
                                </li>
                            </div>
                        </div>
                        <small class="pl-2">
                            Introdu minim 3 caractere din nume sau telefon
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-0"
            style="background-color:#ddffff; border-left:6px solid; border-color:#2196F3; border-radius: 0px 0px 0px 0px"
        >
            <div class="form-group col-lg-5 mb-4">
                <label for="nume" class="mb-0 pl-3">Nume:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    v-model="client_nume"
                    {{-- value="{{ old('nume') == '' ? $fise->nume : old('nume') }}" --}}
                    required>
            </div>
            <div class="form-group col-lg-7 mb-4">
                <label for="adresa" class="mb-0 pl-3">Adresa:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('adresa') ? 'is-invalid' : '' }}"
                    name="adresa"
                    placeholder=""
                    v-model="client_adresa"
                    {{-- value="{{ old('adresa') == '' ? $fise->adresa : old('adresa') }}" --}}
                    required>
            </div>
            <div class="form-group col-lg-3 mb-4">
                <label for="nr_ord_reg_com" class="mb-0 pl-3">Nr. Reg. com.:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_ord_reg_com') ? 'is-invalid' : '' }}"
                    name="nr_ord_reg_com"
                    placeholder=""
                    v-model="client_nr_ord_reg_com"
                    {{-- value="{{ old('nr_ord_reg_com') == '' ? $fise->nr_ord_reg_com : old('nr_ord_reg_com') }}" --}}
                    required>
            </div>
            <div class="form-group col-lg-3 mb-4">
                <label for="cui" class="mb-0 pl-3">CUI/CNP:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cui') ? 'is-invalid' : '' }}"
                    name="cui"
                    placeholder=""
                    v-model="client_cui"
                    {{-- value="{{ old('cui') == '' ? $fise->cui : old('cui') }}" --}}
                    required>
            </div>
            <div class="form-group col-lg-2 mb-4">
                <label for="sex" class="mb-0 pl-3">Sex:</label>
                <select name="sex" v-model="client_sex" class="custom-select-sm custom-select rounded-pill {{ $errors->has('sex') ? 'is-invalid' : '' }}">
                    <option></option>
                    {{-- <option value='1' {{ intval(old('sex', $fise->sex)) === 1 ? 'selected' : '' }}>Masculin</option> --}}
                    {{-- <option value='2' {{ intval(old('sex', $fise->sex)) === 2 ? 'selected' : '' }}>Feminin</option> --}}
                    <option value='1'>Masculin</option>
                    <option value='2'>Feminin</option>
                </select>
            </div>
            <div class="form-group col-lg-3 mb-4">
                <label for="iban" class="mb-0 pl-3">Iban:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('iban') ? 'is-invalid' : '' }}"
                    name="iban"
                    placeholder=""
                    v-model="client_iban"
                    {{-- value="{{ old('iban') == '' ? $fise->iban : old('iban') }}" --}}
                    required>
            </div>
            <div class="form-group col-lg-3 mb-4">
                <label for="banca" class="mb-0 pl-3">Banca:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('banca') ? 'is-invalid' : '' }}"
                    name="banca"
                    placeholder=""
                    v-model="client_banca"
                    {{-- value="{{ old('banca') == '' ? $fise->banca : old('banca') }}" --}}
                    required>
            </div>
            <div class="form-group col-lg-3 mb-0">
                <label for="reprezentant" class="mb-0 pl-3">Reprezentant:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('reprezentant') ? 'is-invalid' : '' }}"
                    name="reprezentant"
                    placeholder=""
                    v-model="client_reprezentant"
                    {{-- value="{{ old('reprezentant') == '' ? $fise->reprezentant : old('reprezentant') }}" --}}
                    required>
            </div>
            <div class="form-group col-lg-3 mb-0">
                <label for="reprezentant_functie" class="mb-0 pl-3"><small>Reprezentant funcție:</small></label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('reprezentant_functie') ? 'is-invalid' : '' }}"
                    name="reprezentant_functie"
                    placeholder=""
                    v-model="client_reprezentant_functie"
                    {{-- value="{{ old('reprezentant_functie') == '' ? $fise->reprezentant_functie : old('reprezentant_functie') }}" --}}
                    required>
            </div>
            <div class="form-group col-lg-2 mb-0">
                <label for="telefon" class="mb-0 pl-3">Telefon:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                    name="telefon"
                    placeholder="Ex: 07xyzzzzzz"
                    v-model="client_telefon"
                    {{-- value="{{ old('telefon') == '' ? $fise->telefon : old('telefon') }}" --}}
                    required>
                {{ old('telefon') }}
            </div>
            <div class="form-group col-lg-2 mb-0">
                <label for="email" class="mb-0 pl-3">Email:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    name="email"
                    placeholder=""
                    v-model="client_email"
                    {{-- value="{{ old('email') == '' ? $fise->email : old('email') }}" --}}
                    required>
            </div>
            <div class="form-group col-lg-2 mb-1">
                <label for="site_web" class="mb-0 pl-3">Site web:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('site_web') ? 'is-invalid' : '' }}"
                    name="site_web"
                    placeholder=""
                    v-model="client_site_web"
                    {{-- value="{{ old('site_web') == '' ? $fise->site_web : old('site_web') }}" --}}
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
                    v-model="descriere_echipament"
                    v-on:focus="nume_camp = 'descriere_echipament'; valoare_camp = $event.target.value; autocomplete();"
                    v-on:input="nume_camp = 'descriere_echipament'; valoare_camp = $event.target.value; autocomplete();"
                    {{-- placeholder="Descriere echipament" --}}
                    >{{ old('descriere_echipament') == '' ? $fise->descriere_echipament : old('descriere_echipament') }}</textarea>
                    {{-- <div v-cloak v-if="(nume_camp == 'autor') && (carti_lista_autocomplete.length > 0)" class="panel-footer overflow-auto" style="max-height: 100px;"> --}}
                    <div class="panel-footer overflow-auto" style="max-height: 200px;">
                        <div class="list-group">
                            <button class="list-group-item list-group-item list-group-item-action py-0"
                                type="reset"
                                v-for="element in fise_lista_autocomplete"
                                v-on:click="
                                    descriere_echipament = element;

                                    fise_lista_autocomplete = '';
                                ">
                                    @{{ element }}
                            </button>
                        </div>
                    </div>
            </div>
            <div class="form-group col-lg-6">
                <label for="defect_reclamat" class="mb-0 pl-3">Serviciu solicitat sau defect reclamat:</label>
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
            <div class="form-group col-lg-12">
                <label for="rezultat_service" class="mb-0 pl-3">Rezultat service:</label>
                {{-- <textarea class="form-control {{ $errors->has('rezultat_service') ? 'is-invalid' : '' }}"
                    name="rezultat_service"
                    >{{ old('rezultat_service') == '' ? $fise->rezultat_service : old('rezultat_service') }}</textarea> --}}
                <tinymce-vue
                inputvalue="{{ old('rezultat_service') == '' ? $fise->rezultat_service : old('rezultat_service') }}"
                height= 300
                inputname="rezultat_service"
                ></tinymce-vue>
            </div>
            {{-- <div class="form-group col-lg-6">
                <label for="link_qr" class="mb-0 pl-3">Link QR:</label>
                <textarea class="form-control {{ $errors->has('link_qr') ? 'is-invalid' : '' }}"
                    name="link_qr"
                    >{{ old('link_qr') == '' ? $fise->link_qr : old('link_qr') }}</textarea>
            </div>
            <div class="form-group col-lg-6">
                <label for="link_qr_descriere" class="mb-0 pl-3">Link QR descriere:</label>
                <textarea class="form-control {{ $errors->has('link_qr_descriere') ? 'is-invalid' : '' }}"
                    name="link_qr_descriere"
                    >{{ old('link_qr_descriere') == '' ? $fise->link_qr_descriere : old('link_qr_descriere') }}</textarea>
            </div> --}}
            <div class="form-group col-lg-12 mb-2">
                <label for="servicii_efectuate" class="mb-0 pl-1">Categorii Servicii efectuate:</label>
                    <div class="form-row mb-2">
                        @foreach ($categorii_servicii as $categorie)
                            <div class="col-lg-6 mb-2 rounded-pill">
                                <div class="custom-control custom-checkbox border border-4" style="padding-left:30px; display: inline-block; border-color:mediumseagreen;">
                                    <input type="checkbox"
                                        class="custom-control-input"
                                        id="categorie{{ $categorie->id }}"
                                        style="padding:20px"
                                        {{-- v-on:change="select({{ $categorie->id }})" --}}
                                        v-on:change="select({{ $categorie->id }},$event)"
                                        >
                                    <label class="custom-control-label text-white px-1" for="categorie{{ $categorie->id }}" style="background-color:mediumseagreen;">
                                        {{ $categorie->nume }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                <label for="servicii_efectuate" class="mb-0 pl-1">Servicii efectuate:</label>
                    <div class="form-row">
                                <div v-for="serviciu in servicii" class="col-lg-6 mb-2 rounded-pill">
                                    <div class="custom-control custom-checkbox border border-4" style="padding-left:30px; display: inline-block; border-color:mediumseagreen;">
                                        {{-- <input type="checkbox" class="custom-control-input"
                                            name="servicii_selectate[]"
                                            value="{{ $serviciu->id }}"
                                            style="padding:20px" id="{{ $serviciu->id }}"
                                            @if (old("servicii_selectate"))
                                                {{ in_array($serviciu->id, old("servicii_selectate")) ? "checked":"" }}
                                            @else
                                                {{ in_array($serviciu->id, $fise->servicii->pluck('id')->toArray()) ? "checked":"" }}
                                            @endif
                                            > --}}
                                        <input type="checkbox"
                                            class="custom-control-input"
                                            name="servicii_selectate[]"
                                            v-model="servicii_selectate"
                                            :value="serviciu.id"
                                            style="padding:20px"
                                            :id="serviciu.id"
                                            number>
                                        <label class="custom-control-label text-white px-1" :for="serviciu.id" style="background-color:mediumseagreen;">
                                            @{{ serviciu.nume }}
                                        </label>
                                    </div>
                                </div>
                            {{-- @foreach ($servicii as $serviciu)
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
                            @endforeach --}}
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
                    <vue-datepicker-next
                        data-veche="{{ old('data_ridicare') == '' ? $fise->data_ridicare : old('data_ridicare') }}"
                        nume-camp-db="data_ridicare"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                        :latime="{ width: '125px' }"
                        {{-- not-before="{{ \Carbon\Carbon::today() }}" --}}
                    ></vue-datepicker-next>
                </div>
            </div>
            <div class="form-group col-lg-6">
                <label for="observatii_interne" class="mb-0 pl-3">Observații interne:</label>
                <textarea class="form-control {{ $errors->has('observatii_interne') ? 'is-invalid' : '' }}"
                    name="observatii_interne"
                    {{-- placeholder="Observații" --}}
                    >{{ old('observatii_interne') == '' ? $fise->observatii_interne : old('observatii_interne') }}</textarea>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-0"
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
            <div class="col-lg-3 justify-content-center d-flex align-items-center">
                <span for="durata_interventie" class="d-flex align-items-center mr-2">
                    Durata intervenție:
                </span>
                <vue-datepicker-next
                    data-veche="{{ old('durata_interventie') == '' ? ($fise->durata_interventie ?? \Carbon\Carbon::today() ) : old('durata_interventie') }}"
                    nume-camp-db="durata_interventie"
                    tip="time"
                    value-type="HH:mm"
                    format="HH:mm"
                    :latime="{ width: '80px' }"
                    {{-- not-before="{{ \Carbon\Carbon::today() }}" --}}
                ></vue-datepicker-next>
            </div>
            <div class="form-group col-lg-2 mb-0 d-flex justify-content-center">
                <div class="d-flex align-items-center" style="width:150px">
                    <label for="cost" class="mb-0 pl-3 mr-1">Cost:</label>
                    <input
                        type="text"
                        class="form-control form-control-sm mr-1 text-right rounded-pill {{ $errors->has('cost') ? 'is-invalid' : '' }}"
                        name="cost"
                        placeholder=""
                        value="{{ old('cost', $fise->cost) ?? 0 }}"
                        required>
                    lei
                </div>
            </div>
            <div class="col-lg-2 d-flex justify-content-center align-items-center">
                <div>
                    <input type="hidden" name="donatie" value=0>
                    <input type="checkbox" class="form-check-input" name="donatie" value="1"
                        {{ old('donatie', $fise->donatie) == '1' ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="donatie">Donație</label>
                </div>
            </div>
            <div class="col-lg-1 d-flex justify-content-center align-items-center">
                <div>
                    <input type="hidden" name="casare" value=0>
                    <input type="checkbox" class="form-check-input" name="casare" value="1"
                        {{ old('casare', $fise->casare) == '1' ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="casare">Casare</label>
                </div>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-4"
            style="background-color:rgb(220, 225, 255); border-left:6px solid; border-color:rgb(43, 0, 160); border-radius: 0px 0px 0px 0px"
            >
            <div class="form-group d-flex col-lg-12 mb-0 align-items-center">
                <div class="d-flex mr-2">
                    <label for="partener_id" class="mb-0 pr-1">Trimitere către partener service:</label>
                    <div class="">
                        <select name="partener_id"
                            class="custom-select custom-select-sm rounded-pill {{ $errors->has('client_deja_inregistrat') ? 'is-invalid' : '' }}"
                        >
                                <option value='' selected>Selectează partener</option>
                            @foreach ($parteneri as $partener)
                                <option value='{{ $partener->id }}'
                                    {{ ($partener->id == old('partener_id', $fise->partener_id)) ? 'selected' : '' }}
                                    >
                                    {{ $partener->nume }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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


