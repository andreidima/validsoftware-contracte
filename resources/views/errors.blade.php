@if ($errors->any())
    <div class="alert alert-danger mb-0" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{  $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('status') || session()->has('success'))
    <div class="alert alert-success">
        {{ session('status') }}
        {{ session('success') }}
    </div>
@elseif (session()->has('eroare') || session()->has('error'))
    <div class="alert alert-danger">
        {{ session('eroare') }}
        {{ session('error') }}
    </div>
@endif