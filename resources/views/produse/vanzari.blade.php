@extends ('layouts.app')

@section('content')   
    <div class="container card">
            <div class="row card-header">
                <div class="mt-2 mb-0">
                    <h4 class=""><a href="/produse/vanzari"><i class="fas fa-file-alt mr-1"></i>Vânzări produse</a></h4>
                </div> 
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-5" id="vanzari">     
                        
                    @include('/flash-message')


                        <form  class="needs-validation" novalidate method="POST" action="{{ action('ProdusController@vanzariDescarcaProdus') }}">
                            @method('PATCH')
                            @csrf  

                            <div class="form-group row">
                                    <label for="nr_de_bucati" class="col-sm-5 col-form-label">Numar de bucăți:</label>
                                <div class="col-sm-7">
                                    <input type="number" min="1" max="99"
                                        class="form-control {{ $errors->has('nr_de_bucati') ? 'is-invalid' : '' }}" 
                                        id="nr_de_bucati" 
                                        name="nr_de_bucati"
                                        placeholder="1"                                        
                                        value="{{ old('nr_de_bucati') == '' ? '1' : old('nr_de_bucati') }}"
                                        autofocus
                                        >
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="cod_de_bare" class="col-sm-5 col-form-label">Scanați codul de bare:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control {{ $errors->has('cod_de_bare') ? 'is-invalid' : '' }}" 
                                        id="cod_de_bare" 
                                        name="cod_de_bare"
                                        placeholder="Cod de bare"                                        
                                        value="{{ old('cod_de_bare') }}"
                                        autofocus
                                        >
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg py-2">Vinde produsul</button>
                                </div>
                            </div>  
                        </form>


                    </div>
                </div>
            </div>
    </div>
@endsection