@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-0">
            <div class="form-group col-lg-12 mb-4">
                <label for="nume" class="mb-0 pl-3">Nume:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $site->nume) }}">
            </div>
            <div class="form-group col-lg-12 mb-4">
                <label for="url" class="mb-0 pl-3">URL:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('url') ? 'is-invalid' : '' }}"
                    name="url"
                    placeholder=""
                    value="{{ old('url', $site->url) }}">
            </div>
            <div class="form-group col-lg-12 mb-4">
                <label for="descriere" class="mb-0 pl-3">Descriere:</label>
                <tinymce-vue
                inputvalue="{{ old('descriere', $site->descriere) }}"
                height= 300
                inputname="descriere"
                ></tinymce-vue>
                {{-- <textarea class="form-control {{ old('descriere', $site->descriere) }}" rows="5"
                    name="descriere"
                >{{ old('descriere', $site->descriere) }}</textarea> --}}
            </div>
        </div>

        <div class="form-row mb-3 px-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ Session::get('chatGPTSiteReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
