@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fab fa-windows mr-1"></i>Licențe / {{ $licenta->nume }}</h6>
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
                                    {{ $licenta->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Link
                                </td>
                                <td>
                                    <a href="{{ $licenta->link }}" target="_blank">{{ $licenta->link }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Cantitate
                                </td>
                                <td>
                                    {{ $licenta->cantitate }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Observații
                                </td>
                                <td>
                                    {{ $licenta->observatii }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary btn-sm rounded-pill" href="/service/licente">Pagină Licențe</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
