@extends ('layouts.app')

<script type="application/javascript">
    siteuri={!! json_encode($siteuri) !!}
    produse={!! json_encode($produse) !!}
    prompturi={!! json_encode($prompturi) !!}
</script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">Interogare OAI</h6>
                </div>

                @include ('errors')

                <div class="card-body py-2 border border-secondary" style="border-radius: 0px 0px 40px 40px;">
                    <form  class="needs-validation" novalidate method="POST"
                        action="/chat-gpt/interogare-oai"
                    >
                    @csrf

                        <div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
                            <div class="form-group col-lg-12 px-2 mb-0">
                                <div class="form-row px-2 py-2 mb-0" id="chatGPTInterogareOAISeparata">
                                    {{-- <div class="form-group col-lg-4 mb-4">
                                        <label for="site_id" class="mb-0 pl-3">Siteuri:</label>
                                        <div class="d-flex">
                                            <select class="custom-select rounded-3" v-model="siteAles" @change="produseSelectate">
                                                <option selected></option>
                                                <option v-for="site in siteuri" :value='site.id'>
                                                    @{{site.nume}}
                                                </option>
                                            </select>
                                            <button type="button" class="btn btn-success rounded-3" title="Adaugă site ca și context"
                                                @click="adaugaSiteAles()"
                                            >
                                                <i class="fas fa-plus-square text-white"></i>
                                            </button>
                                        </div>
                                    </div> --}}
                                    <div class="form-group col-lg-4 mb-4">
                                        <label for="" class="mb-0 pl-3">Siteuri:</label>
                                        <div class="d-flex">
                                            <select class="custom-select rounded-3" v-model="siteAles" @change="siteSelectat">
                                                <option selected></option>
                                                <option v-for="site in siteuri" :value='site.id'>
                                                    @{{site.nume}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 mb-4">
                                        <label for="" class="mb-0 pl-3">Categorii:</label>
                                        <div class="d-flex">
                                            <select class="custom-select rounded-3" v-model="categorieAleasa" @change="categorieSelectata">
                                                <option selected></option>
                                                <option v-for="categorie in categoriiProduse" :value='categorie'>
                                                    @{{categorie}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 mb-4">
                                        <label for="" class="mb-0 pl-3">Produse:</label>
                                        <div class="d-flex">
                                            <select class="custom-select rounded-3" v-model="produsAles" @change="adaugaProdusInContext">
                                                <option selected></option>
                                                <option v-for="produs in produsePerCategorie" :value='produs.id'>
                                                    @{{produs.nume}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group col-lg-12 mb-1">
                                        <h3 class="mb-0">Context</h3>
                                    </div> --}}
                                    <div class="form-group col-lg-12 mb-4">
                                        {{-- <div v-if="siteuriAlese.length" class="card">
                                            <h5 class="card-header">Siteuri</h5>
                                            <div class="card-body p-0">
                                                <li v-for="site in siteuriAlese" class="list-group-item d-flex justify-content-between align-items-center">
                                                    @{{site.nume}}
                                                    <span type="button" class="badge badge-white badge-3" title="Șterge site"
                                                        @click="stergeSiteAles(site.id)"
                                                    ><i class="fas fa-minus-square text-danger fa-2x"></i></span>
                                                </li>
                                            </div>
                                        </div> --}}
                                        <div v-if="produseAdaugateInContext.length" class="card">
                                            <h5 class="card-header">Produse selectate</h5>
                                            <div class="card-body p-0">
                                                <li v-for="produs in produseAdaugateInContext" class="list-group-item d-flex justify-content-between align-items-center">
                                                    @{{produs.nume}}
                                                    <input type="hidden" name="produseAdaugateInContext[]" :value=produs.id>
                                                    <span type="button" class="badge badge-white badge-3" title="Șterge produs"
                                                        @click="stergeProdusDinContext(produs.id)"
                                                    ><i class="fas fa-minus-square text-danger fa-2x"></i></span>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row px-2 py-2 mb-0" id="chatGPTInterogareOAI">
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
