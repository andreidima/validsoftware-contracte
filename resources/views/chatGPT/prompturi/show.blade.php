@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">Prompturi / {{ $prompt->nume }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
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
                                    {{ $prompt->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Categorie
                                </td>
                                <td>
                                    {{ $prompt->categorie }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Text
                                </td>
                                <td>
                                    {{ $prompt->text }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Creat
                                </td>
                                <td>
                                    {{ $prompt->created_at ? \Carbon\Carbon::parse($prompt->created_at)->isoFormat('DD.MM.YYYY HH:mm') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Actualizat
                                </td>
                                <td>
                                    {{ $prompt->updated_at ? \Carbon\Carbon::parse($prompt->updated_at)->isoFormat('DD.MM.YYYY HH:mm') : '' }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-secondary text-white rounded-3" href="{{ Session::get('chatGPTPromptReturnUrl') }}">Înapoi</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
