@extends ('layouts.app')

@section('content')

<script type="application/javascript">
    prompturi={!! json_encode($prompturi) !!}
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">Interogare OAI</h6>
                </div>

                @include ('errors')

                <div class="card-body py-2 border border-secondary" style="border-radius: 0px 0px 40px 40px;">
                    <form  class="needs-validation" novalidate method="POST" action="/chat-gpt/produse/interogare-oai">
                    @csrf

                        <div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="chatGPTInterogareOAI">
                            <div class="form-group col-lg-12 px-2 mb-0">
                                <div class="form-row px-2 py-2 mb-0">
                                    <div class="form-group col-lg-4 mb-4">
                                        <label for="nume" class="mb-0 pl-3">Produs:</label>
                                        <input type="hidden" name="produs_id" value="{{ $produs->id }}">
                                        <input type="hidden" name="produs_url" value="{{ $produs->url }}">
                                        <input type="hidden" name="produs_descriere" value="{{ $produs->descriere }}">
                                        <input
                                            type="text"
                                            class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                                            name="produs_nume"
                                            placeholder=""
                                            value="{{ old('nume', $produs->nume) }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-lg-4 mb-4">
                                        <label for="categoriePrompt" class="mb-0 pl-3">Categorie prompt:</label>
                                        <select name="categoriePrompt" class="custom-select-sm custom-select rounded-pill {{ $errors->has('categoriePrompt') ? 'is-invalid' : '' }}"
                                            v-model="categoriePrompt"
                                            @change="getPrompturiPerCategorie();">
                                            <option selected></option>
                                            @foreach ($prompturiCategorii as $categorie)
                                                <option value="{{ $categorie->categorie }}" {{ ($categorie->categorie === intval(old('categoriePrompt', $categorie->categorie ?? ''))) ? 'selected' : '' }}>{{ $categorie->categorie }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4 mb-4">
                                        <label for="prompt_id" class="mb-0 pl-3">Prompt:</label>
                                        <select class="custom-select-sm custom-select rounded-pill {{ $errors->has('prompt') ? 'is-invalid' : '' }}"
                                            name="prompt_id"
                                            {{-- v-model="prompt_id" --}}
                                            @change="setpromptText($event)"
                                        >
                                            <option selected></option>
                                            <option v-for="prompt in prompturiPerCategorie" :value='prompt.id'>
                                                @{{prompt.nume}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12 mb-4">
                                        <label for="promptText" class="mb-0 pl-3">Text prompt:</label>
                                            {{-- <tinymce-vue
                                                inputvalue="promptText"
                                                height= 300
                                                inputname="promptText"
                                                name="promptText"
                                            ></tinymce-vue> --}}
                                            <textarea class="form-control {{ $errors->has('promptText') ? 'is-invalid' : '' }}" rows="5"
                                                name="promptText"
                                                v-model="promptText"
                                            >{{ old('promptText') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-row mb-3 px-2 justify-content-center">
                                    <div class="col-lg-8 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">Interoghează</button>
                                        {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                                        <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/chat-gpt/produse">Renunță</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
