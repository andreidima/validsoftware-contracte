@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-2 justify-content-left">
            <div class="form-group col-lg-12 mb-2">
                <label for="nume" class="mb-0 pl-3">Componenta Pc:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume') ?? $componenta_pc->nume }}"
                    required>
            </div>
            <div class="form-group col-lg-6 ">
                    <label for="categorie_id" class="mb-0 pl-3">Categorie:</label>
                    <div class="">
                        <select name="categorie_id"
                            class="custom-select custom-select-sm rounded-pill {{ $errors->has('categorie_id') ? 'is-invalid' : '' }}"
                        >
                                <option value='' selected>Selectează categorie</option>
                            @foreach ($categorii as $categorie)
                                <option
                                    value='{{ $categorie->id }}'
                                    {{ ($categorie->id == old('categorie_id', ($piesa->categorie->id ?? ''))) ? 'selected' : '' }}
                                >{{ $categorie->nume }} </option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="form-group col-lg-6 mb-2">
                <label for="cantitate" class="mb-0 pl-3">Cantitate:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cantitate') ? 'is-invalid' : '' }}"
                    name="cantitate"
                    placeholder=""
                    value="{{ old('cantitate') ?? $componenta_pc->cantitate }}"
                    required>
            </div>
            <div class="form-group col-lg-12 mb-2">
                <label for="descriere" class="mb-0 pl-3">Descriere:</label>
                <textarea class="form-control form-control-sm {{ $errors->has('descriere') ? 'is-invalid' : '' }}"
                    name="descriere" rows="2">{{ old('descriere') ?? $componenta_pc->descriere }}</textarea>
            </div>
            <div class="form-group col-lg-12 mb-3">
                <label for="file" class="mb-0 pl-3">Adaugă imagini</label>
                <input type="file" name="imagini[]" class="form-control rounded-pill py-1 pl-2"
                    multiple=""
                    >
                @if($errors->has('imagini'))
                <span class="help-block text-danger">{{ $errors->first('imagini') }}</span>
                @endif
            </div>
        </div>

        <div class="form-row mb-3 px-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/service/componente-pc">Renunță</a>
            </div>
        </div>
    </div>
</div>
