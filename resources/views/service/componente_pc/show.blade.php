@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-desktop mr-1"></i>Componente Pc / {{ $componenta_pc->nume }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >

            @include ('errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-sm table-striped table-hover"
                                {{-- style="background-color:#008282" --}}
                        >
                            <tr>
                                <td>
                                    Nume
                                </td>
                                <td>
                                    {{ $componenta_pc->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Categorie
                                </td>
                                <td>
                                    {{ $componenta_pc->categorie->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Categorie
                                </td>
                                <td>
                                    {{ $componenta_pc->cantitate }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary btn-sm rounded-pill" href="/ofertari">Pagină Ofertări</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
