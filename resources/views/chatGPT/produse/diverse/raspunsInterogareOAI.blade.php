@extends ('layouts.app')

<script type="application/javascript">
    deCopiat={!! json_encode($promptTrimis) !!}
</script>

@section('content')
<div class="mx-3 px-3 card" style="border-radius: 40px 40px 40px 40px;">
    <div class="row card-header" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
        <h6 class="ml-4 my-0" style="color:white">Răspuns interogare OAI</h6>
    </div>

    @include ('errors')
    <div class="card-body py-2" style="border-radius: 0px 0px 40px 40px; display: block;">
        <h3>Prompt:</h3>
        <pre style="display: block;">{{ print_r($messages, true) }}</pre>
        <br><br><br><br>

        <div id="copyPaste">
            <h3>
                Prompt content:
                    <a class="btn btn-sm p-0 border-0"
                        v-if="canCopy"
                        @click="copy()">
                        <small title="Copy to clipboard" aria-describedby="">
                            <i class="far fa-clone fa-2x"></i>
                        </small>
                    </a>
            </h3>
        </div>
        {!! $promptTrimis !!}
        <br><br><br><br>

    </div>
</div>
@endsection
