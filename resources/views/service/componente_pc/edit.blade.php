@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-desktop mr-1"></i>Schimbă numele componentei</h6>
                </div>

                @include ('errors')

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >
                    <form  class="needs-validation" novalidate method="POST" action="{{ $componenta_pc->path() }}" enctype="multipart/form-data">
                        @method('PATCH')


                                @include ('service.componente_pc.form', [
                                    'buttonText' => 'Modifică Componenta'
                                ])

                    </form>


                    <div class="form-row px-2 py-2 mb-0 justify-content-center">
                            @forelse ($componenta_pc->imagini as $imagine)
                                <div class="form-group col-lg-6 mb-0 p-1 border">
                                    <a href="{{ env('APP_URL') .$imagine->imagine_cale . $imagine->imagine_nume }}" target="_blank">
                                        <img src="{{ env('APP_URL') .$imagine->imagine_cale . $imagine->imagine_nume }}" alt="" width="100%">
                                    </a>
                                                {{-- <div style="" class="d-flex m-auto">
                                                    <a
                                                        href="#"
                                                        data-toggle="modal"
                                                        data-target="#stergeImagine{{ $imagine->id }}"
                                                        title="Șterge Imagine"
                                                        >
                                                        <span class="badge badge-danger">Șterge</span>
                                                    </a>
                                                        <div class="modal fade text-dark" id="stergeImagine{{ $imagine->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                <div class="modal-header bg-danger">
                                                                    <h5 class="modal-title text-white" id="exampleModalLabel">Componenta: <b>{{ $componenta_pc->nume }}</b></h5>
                                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" style="text-align:left;">
                                                                    Ești sigur ca vrei să ștergi imaginea? {{ $imagine->id }}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                                    <form method="POST" action="/service/componente-pc/sterge-imagine/{{ $imagine->id }}">
                                                                        @method('PATCH')
                                                                        @csrf
                                                                        <button
                                                                            type="submit"
                                                                            class="btn btn-danger"
                                                                            >
                                                                            Șterge imaginea {{ $imagine->id }}
                                                                        </button>
                                                                    </form>

                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div> --}}
                                </div>
                            @empty
                            @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
