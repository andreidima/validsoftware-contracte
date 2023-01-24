@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">Schimbă datele Procesului verbal</h6>
                </div>

                @include ('errors')

                <div class="card-body py-2 border border-secondary" style="border-radius: 0px 0px 40px 40px;">
                    <form  class="needs-validation" novalidate method="POST" action="{{ $procesVerbal->path() }}">
                        @method('PATCH')


                                @include ('proceseVerbale.form', [
                                    'buttonText' => 'Modifică Procesul Verbal'
                                ])

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
