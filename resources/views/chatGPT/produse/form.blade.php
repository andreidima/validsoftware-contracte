@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-0">
            <div class="form-group col-lg-6 mb-4">
                <label for="nume" class="mb-0 pl-3">Nume:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $produs->nume) }}">
            </div>
            <div class="form-group col-lg-6 mb-4">
                <label for="site_id" class="mb-0 pl-3">Site:<span class="text-danger">*</span></label>
                <select name="site_id" class="custom-select-sm custom-select rounded-pill {{ $errors->has('site_id') ? 'is-invalid' : '' }}">
                    <option selected></option>
                    @foreach ($siteuri as $site)
                        <option value="{{ $site->id }}" {{ ($site->id === intval(old('site_id', $produs->site_id ?? ''))) ? 'selected' : '' }}>{{ $site->nume }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-8 mb-4">
                <label for="url" class="mb-0 pl-3">URL:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('url') ? 'is-invalid' : '' }}"
                    name="url"
                    placeholder=""
                    value="{{ old('url', $produs->url) }}">
            </div>
            <div class="form-group col-lg-12 mb-4">
                <label for="descriere" class="mb-0 pl-3">Descriere:</label>
                {{-- <tinymce-vue
                inputvalue="{{ old('descriere', $produs->descriere) }}"
                height= 300
                inputname="descriere"
                ></tinymce-vue> --}}
                <textarea class="form-control {{ old('descriere', $produs->descriere) }}" rows="5"
                    name="descriere"
                >{{ old('descriere', $produs->descriere) }}</textarea>
            </div>
            <div class="form-group col-lg-6 mb-4">
                <label for="link_imagine_fata" class="mb-0 pl-3">Link imagine față:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('link_imagine_fata') ? 'is-invalid' : '' }}"
                    name="link_imagine_fata"
                    placeholder=""
                    value="{{ old('link_imagine_fata', $produs->link_imagine_fata) }}">
            </div>
            <div class="form-group col-lg-6 mb-4">
                <label for="link_imagine_spate" class="mb-0 pl-3">Link imagine spate:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('link_imagine_spate') ? 'is-invalid' : '' }}"
                    name="link_imagine_spate"
                    placeholder=""
                    value="{{ old('link_imagine_spate', $produs->link_imagine_spate) }}">
            </div>
            <div class="form-group col-lg-6 mb-4">
                <label for="categorie" class="mb-0 pl-3">Categorie:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('categorie') ? 'is-invalid' : '' }}"
                    name="categorie"
                    placeholder=""
                    value="{{ old('categorie', $produs->categorie) }}">
            </div>
            <div class="form-group col-lg-6 mb-4">
                <label for="url_categorie" class="mb-0 pl-3">Categorie URL:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('url_categorie') ? 'is-invalid' : '' }}"
                    name="url_categorie"
                    placeholder=""
                    value="{{ old('url_categorie', $produs->url_categorie) }}">
            </div>
            <div class="form-group col-lg-6 mb-4">
                <label for="branduri" class="mb-0 pl-3">Brand:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('branduri') ? 'is-invalid' : '' }}"
                    name="branduri"
                    placeholder=""
                    value="{{ old('branduri', $produs->branduri) }}">
            </div>
            <div class="form-group col-lg-6 mb-4">
                <label for="url_brand" class="mb-0 pl-3">Brand URL:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('url_brand') ? 'is-invalid' : '' }}"
                    name="url_brand"
                    placeholder=""
                    value="{{ old('url_brand', $produs->url_brand) }}">
            </div>
        </div>

        <div class="form-row mb-3 px-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ Session::get('chatGPTProdusReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
