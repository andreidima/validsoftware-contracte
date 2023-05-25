@extends ('layouts.app')

<script type="application/javascript">
    siteuri={!! json_encode($siteuri) !!}
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
                        {{-- action="/chat-gpt/produse/interogare-oai" --}}
                    >
                    @csrf

                        <div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="chatGPTInterogareOAISeparata">
                            <div class="form-group col-lg-12 px-2 mb-0">
                                <div class="form-row px-2 py-2 mb-0">
                                    <div class="form-group col-lg-4 mb-4">
                                        <label for="site_id" class="mb-0 pl-3">Siteuri:</label>
                                        <div class="d-flex">
                                            <select class="custom-select rounded-3"
                                                {{-- name="site_id" --}}
                                                v-model="siteAles"
                                                {{-- @change="setpromptText($event)" --}}
                                            >
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
                                    </div>
                                </div>
                                <div class="form-row px-2 py-2 mb-0">
                                    <div class="form-group col-lg-12 mb-4">
                                        <h3>Context</h3>
                                    </div>
                                    <div class="form-group col-lg-4 mb-4">
                                        <div v-if="siteuriAlese.length" class="card">
                                            <h5 class="card-header">Siteuri</h5>
                                            <div class="card-body p-0">
                                                <li v-for="site in siteuriAlese" class="list-group-item d-flex justify-content-between align-items-center">
                                                    @{{site.nume}}
                                                    <span type="button" class="badge badge-white badge-3" @click="stergeSiteAles()" title="Șterge site"><i class="fas fa-minus-square text-danger fa-2x"></i></span>
                                                </li>
                                            </div>
                                        </div>
                                        {{-- <h5 v-if="siteuriAlese.length" class="mb-0 text-center">Siteuri:</h5> --}}
                                        {{-- <ul class="list-group">
                                            <li v-for="site in siteuriAlese" class="list-group-item d-flex justify-content-between align-items-center">
                                                @{{site.nume}}
                                                <span type="button" class="badge badge-white badge-3" @click="stergeSiteAles()" title="Șterge site"><i class="fas fa-minus-square text-danger fa-2x"></i></span>
                                            </li>
                                        </ul> --}}
                                        {{-- <div class="d-flex">
                                            Siteuri: &nbsp;
                                            <span v-for="site in siteuriAlese" :value='site.id'>
                                                    @{{site.nume}}
                                                    <button type="button" class="btn btn-danger rounded-3" title="Adaugă site ca și context"
                                                        @click="stergeSiteAles()"
                                                    >
                                                        <i class="fas fa-minus-square text-white"></i>
                                                    </button>
                                                </span>
                                        </div> --}}
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
