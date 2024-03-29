@csrf

<script type="application/javascript">
    solicitata = {!! json_encode(old('solicitata', $ofertari->solicitata )) !!}
    clientVechi={!! json_encode(old('client_id', $ofertari->client_id )) !!}
    clientiExistenti={!! json_encode($clienti) !!}
</script>

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="ofertare">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-2 justify-content-center">
            <div class="form-group col-lg-2 mb-4">
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
            <div class="form-group col-lg-2 mb-0 text-center">
                <label for="data_emitere" class="mb-0 pl-1">Data emitere:</label>
                <vue-datepicker-next
                    data-veche="{{ old('data_emitere') ?? $ofertari->data_emitere ?? \Carbon\Carbon::today() }}"
                    nume-camp-db="data_emitere"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                    not-before="{{ \Carbon\Carbon::today() }}"
                ></vue-datepicker-next>
            </div>
            <div class="form-group col-lg-2 mb-0">
                <label for="limba" class="mb-0 pl-3">Limba:</label>
                <select name="limba" class="custom-select-sm custom-select rounded-pill {{ $errors->has('limba') ? 'is-invalid' : '' }}">
                    <option value='1' selected>Română</option>
                    <option value='2' {{ intval(old('limba', $ofertari->limba)) === 2 ? 'selected' : '' }}>Engleză</option>
                </select>
            </div>
            <div class="form-group col-lg-4 mb-0">
                <label for="firma_id" class="mb-0 pl-3">Firma:</label>
                <select name="firma_id"
                    class="custom-select-sm custom-select rounded-pill {{ $errors->has('firma_id') ? 'is-invalid' : '' }}"
                >
                        <option value='' selected>Selectează</option>
                    @foreach ($firme as $firma)
                        <option
                            value='{{ $firma->id }}'
                            {{ ($firma->id == old('firma_id', $ofertari->firma->id ?? '')) ? 'selected' : '' }}
                        >{{ $firma->nume }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-2 mb-0">
                <label for="solicitata" class="mb-0 pl-3">Solicitată:</label>
                <select name="solicitata"
                        v-model="solicitata"
                        class="custom-select-sm custom-select rounded-pill {{ $errors->has('solicitata') ? 'is-invalid' : '' }}">
                    <option value='' selected>Selectează</option>
                    <option value='0' {{ (intval(old('solicitata', $ofertari->solicitata ?? '')) === 0 ) ? 'selected' : '' }}>NU (Ofertă)</option>
                    <option value='1' {{ (intval(old('solicitata', $ofertari->solicitata ?? '')) === 1 ) ? 'selected' : '' }}>DA (Cerere)</option>
                </select>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-4 justify-content-center">
            <div class="form-group col-lg-4 mb-2">
                <label for="client_id" class="mb-0 pl-2">Selectează clientul:</label>
                <div class="">
                    <select name="client_id"
                        class="custom-select custom-select-sm rounded-pill {{ $errors->has('client_id') ? 'is-invalid' : '' }}"
                        v-model="client_id"
                        @change="getNumeClient();"
                    >
                        <option value='' selected>Selectează</option>
                        @foreach ($clienti as $client)
                            <option
                                value='{{ $client->id }}'
                                {{ ($client->id == old('client_id', $ofertari->client_id)) ? 'selected' : '' }}
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
                        <label for="client_nume" class="mb-0 pl-2">
                            Caută clientul
                            :
                        </label>
                        <input
                            type="text"
                            v-model="client_nume"
                            v-on:keyup="autoComplete()"
                            class="form-control form-control-sm rounded-pill {{ $errors->has('client_nume') ? 'is-invalid' : '' }}"
                            name="client_nume"
                            placeholder=""
                            {{-- value="{{ old('client_nume') }}" --}}
                            autocomplete="off"
                            required>
                        <div v-cloak v-if="clienti_lista.length" class="panel-footer">
                            <div class="list-group">
                                    <button class="list-group-item list-group-item list-group-item-action py-0"
                                        v-for="client in clienti_lista"
                                        v-on:click="
                                            client_id = client.id;

                                            client_nume = client.nume;

                                            clienti_lista = ''
                                        ">
                                            @{{ client.nume }}
                                    </button>
                                </li>
                            </div>
                        </div>
                        <small class="pl-2" style="font-size: 70%">
                            Introdu minim 3 caractere din nume sau telefon
                        </small>
                    </div>
                </div>
            </div>
            <div class="form-group col-lg-3 mb-0 text-center">
                <label for="data_cerere" class="mb-0 pl-1">Data cerere:</label>
                <vue-datepicker-next
                    data-veche="{{ old('data_cerere') ?? $ofertari->data_cerere ?? \Carbon\Carbon::today() }}"
                    nume-camp-db="data_cerere"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                    not-before="{{ \Carbon\Carbon::today() }}"
                ></vue-datepicker-next>
            </div>
        </div>
        <div v-if="solicitata == 1" class="form-row px-2 py-2 mb-0">
            <div class="form-group col-lg-12 mb-0">
                <label for="descriere_solicitare" class="mb-0 pl-1">Descriere Solicitare (Valabil pentru cereri):</label>
                {{-- <vue2-editor
                    text-vechi="{{ old('descriere_solicitare') == '' ? $ofertari->descriere_solicitare : old('descriere_solicitare') }}"
                    nume-camp-db="descriere_solicitare"
                ></vue2-editor> --}}
                <tinymce-vue
                inputvalue="{{ old('descriere_solicitare', $ofertari->descriere_solicitare ?? '') }}"
                height= 300
                inputname="descriere_solicitare"
                ></tinymce-vue>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-4">
            <div class="form-group col-lg-12 mb-0">
                <label for="propunere_tehnica_si_comerciala" class="mb-0 pl-1">Propunere tehnică și comercială:</label>
                {{-- <vue2-editor
                    text-vechi="{{ old('propunere_tehnica_si_comerciala', $ofertari->propunere_tehnica_si_comerciala) ?? "Conform solicitării dvs., vă trimitem următoarea propunere tehnică și comercială:" }}"
                    nume-camp-db="propunere_tehnica_si_comerciala"
                ></vue2-editor> --}}
                <tinymce-vue
                inputvalue="{{ old('propunere_tehnica_si_comerciala', $ofertari->propunere_tehnica_si_comerciala ?? '') }}"
                height= 300
                inputname="propunere_tehnica_si_comerciala"
                ></tinymce-vue>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-4">
            <div class="form-group col-lg-12 mb-0 pl-3">
                {{-- <div class=""> --}}
                    <div class="pl-1 rounded" style="border-left: 3px solid rgb(255, 50, 50);">
                        <div class="form-check form-check-inline">
                            Pdf în email:
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="1" name="pdf_in_email" id="pdf_in_email_da"
                                {{ old('pdf_in_email', $ofertari->pdf_in_email) == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pdf_in_email_da">DA</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="0" name="pdf_in_email" id="pdf_in_email_nu"
                                {{ old('pdf_in_email', $ofertari->pdf_in_email) == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pdf_in_email_nu">NU</label>
                        </div>
                    </div>
                {{-- </div> --}}
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-0">
            <div class="form-group col-lg-12 mb-2">
                <label for="email_subiect" class="mb-0 pl-3">Email - subiect:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('email_subiect') ? 'is-invalid' : '' }}"
                    name="email_subiect"
                    placeholder=""
                    value="{{ old('email_subiect', $ofertari->email_subiect) }}">
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-4">
            <div class="form-group col-lg-12 mb-0">
                <label for="email_text" class="mb-0 pl-3">Email - text:</label>
                <tinymce-vue
                inputvalue="{{ old('email_text', $ofertari->email_text ?? 'Mulțumim,<br>Echipa ValidSoftware<br>0744.761.451') }}"
                height= 300
                inputname="email_text"
                ></tinymce-vue>
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
                <a class="btn btn-secondary btn-sm mr-2 rounded-pill" href="/ofertari">Renunță</a>

                {{-- Doar pentru modificare --}}
                @if (str_contains(url()->current(), '/modifica'))
                    <a class="btn btn-warning btn-sm rounded-pill" href="{{ $ofertari->path() }}/duplica" class="flex">Duplică</a>
                @endif
            </div>
        </div>
    </div>
</div>
