@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-2 justify-content-center">
            <div class="form-group col-lg-12 mb-3">
                <label for="nume" class="mb-0 pl-3">Serviciu ofertare:</label>
                {{-- <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume') ?? $ofertari_servicii->nume }}"
                    required> --}}
                <textarea class="form-control {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    rows="4"
                    {{-- placeholder="Descriere defect" --}}
                    >{{ old('nume') == '' ? $ofertari_servicii->nume : old('nume') }}</textarea>
            </div>
            <div class="form-group col-lg-2 mb-0">
                <label for="pret" class="mb-0 pl-3">Preț:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('pret') ? 'is-invalid' : '' }}"
                    name="pret"
                    placeholder=""
                    value="{{ old('pret') ?? $ofertari_servicii->pret }}"
                    required>
            </div>
            <div class="form-group col-lg-2 mb-0">
                <label for="recurenta" class="mb-0 pl-3">Recurență:</label>
                <select name="recurenta"
                    class="custom-select-sm custom-select rounded-pill {{ $errors->has('recurenta') ? 'is-invalid' : '' }}"
                >
                        <option value='' selected>Selectează</option>
                        <option
                            value='o dată'
                            {{ old('recurenta', $ofertari_servicii->recurenta) == 'o dată' ? 'selected' : ''}}
                        >o dată</option>
                        <option
                            value='lunar'
                            {{ (old('recurenta', $ofertari_servicii->recurenta) == 'lunar') ? 'selected' : ''}}
                        >lunar</option>
                        <option
                            value='anual'
                            {{ (old('recurenta', $ofertari_servicii->recurenta) == 'anual') ? 'selected' : ''}}
                        >anual</option>
                </select>
            </div>
        </div>

        <div class="form-row mb-3 px-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/ofertari-servicii">Renunță</a>
            </div>
        </div>
    </div>
</div>
