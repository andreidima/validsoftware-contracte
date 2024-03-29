@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-2 justify-content-left">
            <div class="form-group col-lg-10 mb-2">
                <label for="nume" class="mb-0 pl-3">Serviciu service:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume') ?? $servicii->nume }}"
                    required>
            </div>
            <div class="form-group col-lg-2 mb-2">
                <label for="pret" class="mb-0 pl-3">Preț:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('pret') ? 'is-invalid' : '' }}"
                    name="pret"
                    placeholder=""
                    value="{{ old('pret') ?? $servicii->pret }}"
                    required>
            </div>
            <div class="form-group col-lg-5 ">
                    <label for="categorie_id" class="mb-0 pl-3">Categorie:</label>
                    <div class="">
                        <select name="categorie_id"
                            class="custom-select custom-select-sm rounded-pill {{ $errors->has('categorie_id') ? 'is-invalid' : '' }}"
                        >
                                <option value='' selected>Selectează categorie</option>
                            @foreach ($categorii as $categorie)
                                <option
                                    value='{{ $categorie->id }}'
                                    {{ ($categorie->id == old('categorie_id', ($servicii->categorie_id))) ? 'selected' : '' }}
                                >{{ $categorie->nume }} </option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="form-group col-lg-5 mb-2">
                <label for="link_review_site" class="mb-0 pl-3">Link review site:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('link_review_site') ? 'is-invalid' : '' }}"
                    name="link_review_site"
                    placeholder=""
                    value="{{ old('link_review_site') ?? $servicii->link_review_site }}"
                    required>
            </div>
            <div class="form-group col-lg-2 mb-2">
                <label for="nr_de_ordine" class="mb-0 pl-3">Nr. de ordine:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_de_ordine') ? 'is-invalid' : '' }}"
                    name="nr_de_ordine"
                    placeholder=""
                    value="{{ old('nr_de_ordine') ?? $servicii->nr_de_ordine }}"
                    required>
            </div>
        </div>

        <div class="form-row mb-3 px-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/service/servicii">Renunță</a>
            </div>
        </div>
    </div>
</div>
