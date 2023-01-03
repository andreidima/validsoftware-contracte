@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-2 justify-content-center">
            <div class="form-group col-lg-2 mb-4">
                <label for="nr_document" class="mb-0 pl-3">Nr. document:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_document') ? 'is-invalid' : '' }}"
                    name="nr_document"
                    placeholder=""
                    value="{{ old('nr_document' ,$procesVerbal->nr_document) ?? $urmatorul_document_nr }}"
                    required>
            </div>
            <div class="form-group col-lg-3 mb-0 text-center">
                <label for="data_emitere" class="mb-0 pl-1">Data emitere:</label>
                <vue2-datepicker
                    data-veche="{{ old('data_emitere', ($procesVerbal->data_emitere ?? \Carbon\Carbon::today())) }}"
                    nume-camp-db="data_emitere"
                    tip="date"
                    latime="150"
                    not-before="{{ \Carbon\Carbon::today() }}"
                ></vue2-datepicker>
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
                            {{ ($firma->id == old('firma_id', $procesVerbal->firma->id ?? '')) ? 'selected' : '' }}
                        >{{ $firma->nume }} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-4 justify-content-center">
            <script type="application/javascript">
                clientVechi={!! json_encode(old('client_id', $procesVerbal->client_id )) !!}
                clientiExistenti={!! json_encode($clienti) !!}
            </script>
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
                                {{ ($client->id == old('client_id', $procesVerbal->client_id)) ? 'selected' : '' }}
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
                            value="{{ old('client_nume') }}"
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
        </div>
        <div class="form-row px-2 py-2 mb-4">
            <div class="form-group col-lg-12 mb-0">
                <label for="proces_verbal" class="mb-0 pl-3">Proces verbal:</label>
                <tinymce-vue
                inputvalue="{{ old('proces_verbal', $procesVerbal->proces_verbal) }}"
                height= 300
                inputname="proces_verbal"
                ></tinymce-vue>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-0">
            <div class="form-group col-lg-12 mb-0">
                <label for="email_subiect" class="mb-0 pl-3">Email - subiect:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('email_subiect') ? 'is-invalid' : '' }}"
                    name="email_subiect"
                    placeholder=""
                    value="{{ old('email_subiect', $procesVerbal->email_subiect) }}">
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-4">
            <div class="form-group col-lg-12 mb-0">
                <label for="email_text" class="mb-0 pl-3">Email - text:</label>
                <tinymce-vue
                inputvalue="{{ old('email_text', $procesVerbal->email_text) }}"
                height= 300
                inputname="email_text"
                ></tinymce-vue>
            </div>
        </div>

        <div class="form-row mb-3 px-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/procese-verbale">Renunță</a>
            </div>
        </div>
    </div>
</div>
