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
                    value="{{ old('nume', $prompt->nume) }}">
            </div>
            <div class="form-group col-lg-12 mb-4">
                <label for="categorie" class="mb-0 pl-3">Categorie:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('categorie') ? 'is-invalid' : '' }}"
                    name="categorie"
                    placeholder=""
                    value="{{ old('categorie', $prompt->categorie) }}">
            </div>
            <div class="form-group col-lg-12 mb-4">
                <label for="text" class="mb-0 pl-3">Text:</label>
                <tinymce-vue
                inputvalue="{{ old('text', $prompt->text) }}"
                height= 300
                inputname="text"
                ></tinymce-vue>
            </div>
        </div>

        <div class="form-row mb-3 px-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ Session::get('chatGPTPromptReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
