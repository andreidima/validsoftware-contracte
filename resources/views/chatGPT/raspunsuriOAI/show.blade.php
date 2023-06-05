@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">Răspuns OAI</h6>
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
                                    Produse
                                </td>
                                <td>
                                    @foreach ($raspuns->produse as $produs)
                                        <a href="{{ $produs->path() ?? '' }}">
                                            {{ $produs->nume }}
                                        </a>
                                        @if (!$loop->last)
                                            <br>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Prompt
                                </td>
                                <td>
                                    @if ($raspuns->prompt)
                                        <a href="{{ $raspuns->prompt->path() ?? '' }}">
                                            {{ $raspuns->prompt->nume ?? ''}}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Prompt trimis
                                </td>
                                <td>
                                    {!! $raspuns->prompt_trimis !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Răspuns primit
                                </td>
                                <td>
                                    {!! $raspuns->raspuns_primit !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Data
                                </td>
                                <td>
                                    {{ $raspuns->created_at ? \Carbon\Carbon::parse($raspuns->created_at)->isoFormat('DD.MM.YYYY HH:mm') : '' }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-secondary text-white rounded-3" href="{{ Session::get('chatGPTRaspunsOAIReturnUrl') }}">Înapoi</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
