@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-2 justify-content-left">
            <div class="form-group col-lg-12 mb-2">
                <label for="nume" class="mb-0 pl-3">Licența:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $licenta->nume) }}"
                    required>
            </div>
            <div class="form-group col-lg-9 mb-2">
                <label for="link" class="mb-0 pl-3">Link:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('link') ? 'is-invalid' : '' }}"
                    name="link"
                    placeholder=""
                    value="{{ old('link', $licenta->link) }}"
                    >
            </div>
            <div class="form-group col-lg-3 mb-2">
                <label for="cantitate" class="mb-0 pl-3">Cantitate:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cantitate') ? 'is-invalid' : '' }}"
                    name="cantitate"
                    placeholder=""
                    value="{{ old('cantitate', $licenta->cantitate) }}"
                    >
            </div>
            <div class="form-group col-lg-12 mb-2">
                <label for="observatii" class="mb-0 pl-3">Observații:</label>
                <textarea class="form-control form-control-sm {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii" rows="2">{{ old('observatii', $licenta->observatii) }}</textarea>
            </div>
        </div>

        <div class="form-row mb-3 px-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/service/licente">Renunță</a>
            </div>
        </div>
    </div>
</div>
