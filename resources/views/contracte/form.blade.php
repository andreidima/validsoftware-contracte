@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-4 justify-content-between">
            <div class="form-group col-lg-2 mb-0">
                <label for="contract_nr" class="mb-0 pl-3">Nr. contract:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('contract_nr') ? 'is-invalid' : '' }}"
                    name="contract_nr"
                    placeholder=""
                    {{-- value="{{ old('contract_nr') == '' ? ($contracte->contract_nr == '' ? $urmatorul_contract_nr : '') : old('contract_nr') }}" --}}
                    value="{{ old('contract_nr') == '' ? ($contracte->contract_nr ?? $urmatorul_contract_nr) : old('contract_nr') }}"
                    required>
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
                            {{ ($firma->id == old('firma_id', $contracte->firma->id ?? '')) ? 'selected' : '' }}
                        >{{ $firma->nume }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-4 mb-0">
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
                                    @if ($client->id == $contracte->client_id)
                                        selected
                                    @endif
                                @endif
                        >{{ $client->nume }} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-5 justify-content-around">
            <div class="form-check form-check-inline col-lg-3 justify-content-center align-self-end mr-0">
                <input type="hidden" name="abonament_lunar" value=0>
                <input type="checkbox" class="form-check-input" name="abonament_lunar" value="1"
                    {{
                        old('abonament_lunar') <> '' ?
                            (old('abonament_lunar') == '1' ? 'checked' : '')
                            :
                            ($contracte->abonament_lunar === 1 ? 'checked' : '')
                    }}
                >
                <label class="form-check-label" for="abonament_lunar">Abonament lunar</label>
            </div>
            <div class="form-group col-lg-2 mb-0">
                <label for="pret" class="mb-0 pl-1">Preț:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('pret') ? 'is-invalid' : '' }}"
                    name="pret"
                    placeholder=""
                    value="{{ old('pret') == '' ? $contracte->pret : old('pret') }}"
                    required>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-4 justify-content-between">
            <div class="form-group col-lg-3 mb-0 text-center">
                <label for="contract_data" class="mb-0 pl-1">Data contract:</label>
                <vue2-datepicker
                    data-veche="{{ old('contract_data', $contracte->contract_data) ?? \Carbon\Carbon::today() }}"
                    nume-camp-db="contract_data"
                    tip="date"
                    latime="150"
                    not-before="{{ \Carbon\Carbon::today() }}"
                ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-3 mb-0 text-center">
                <label for="data_incepere" class="mb-0 pl-1">Data începere:</label>
                <vue2-datepicker
                    data-veche="{{ old('data_incepere') == '' ? $contracte->data_incepere : old('data_incepere') }}"
                    nume-camp-db="data_incepere"
                    tip="date"
                    latime="150"
                    not-before="{{ \Carbon\Carbon::today() }}"
                ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-3 mb-0 text-center">
                <label for="data_terminare" class="mb-0 pl-1">Data terminare:</label>
                <vue2-datepicker
                    data-veche="{{ old('data_terminare') == '' ? $contracte->data_terminare : old('data_terminare') }}"
                    nume-camp-db="data_terminare"
                    tip="date"
                    latime="150"
                    not-before="{{ \Carbon\Carbon::today() }}"
                ></vue2-datepicker>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-0">
            <div class="form-group col-lg-12 mb-0">
                <label for="anexa" class="mb-0 pl-1">Anexa:</label>
                <vue2-editor
                    text-vechi="{{ old('anexa') == '' ? $contracte->anexa : old('anexa') }}"
                    nume-camp-db="anexa"
                ></vue2-editor>
            </div>
        </div>
        {{-- <div class="form-row px-2 py-2 mb-0">
            <div class="form-group col-lg-12 mb-0">
                <label for="anexa" class="mb-0 pl-1">Anexa:</label>
                <tiptap-editor
                    anexa-veche="{{ old('anexa') == '' ? $contracte->anexa : old('anexa') }}"
                    nume-camp-db="anexa"
                ></tiptap-editor>
            </div>
        </div> --}}
        {{-- <div class="form-row px-2 py-2 mb-0">
            <div class="form-group col-lg-12 mb-0">
                <label for="anexa" class="mb-0 pl-1">Anexa:</label>
                <ck-editor
                    anexa-veche="{{ old('anexa') == '' ? $contracte->anexa : old('anexa') }}"
                    nume-camp-db="anexa"
                ></ck-editor>
            </div>
        </div> --}}


        <div class="form-row mb-3 px-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/contracte">Renunță</a>
            </div>
        </div>
    </div>
</div>
