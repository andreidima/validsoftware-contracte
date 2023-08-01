@extends ('layouts.app')

<script type="application/javascript">
    deCopiat={!! json_encode($pentruCopyToClipboard) !!}
</script>

@section('content')
<div class="mx-3 px-3 card" style="border-radius: 40px 40px 40px 40px;">
    <div class="row card-header" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
        <h6 class="ml-4 my-0" style="color:white">Răspuns interogare OAI</h6>
    </div>

    @include ('errors')
    <div class="card-body py-2" style="border-radius: 0px 0px 40px 40px; display: block;">
        {{-- @php
            dd($pentruCopyToClipboard);
        @endphp
        <h3>pentruCopyToClipboard:</h3>
        <pre style="display: block;">{{ print_r($pentruCopyToClipboard, true) }}</pre>
        <br><br><br><br> --}}


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

        <h3>Răspuns:</h3>
        @php
            $response->choices[0]->message->content = str_replace("\n", "<br />", $response->choices[0]->message->content);
        @endphp
        {!! $response->choices[0]->message->content !!}

        <br><br>

        <div style='text-align:center; padding: 20px'>
            <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-right:20px;' href='/chat-gpt/produse'>Produse</a>
            <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-right:20px;' href='/chat-gpt/raspunsuri-oai'>Răspunsuri</a>
             @if (isset($produs->site->link_chatgpt))
                <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-right:20px;'
                    href='{{ $produs->site->link_chatgpt ?? '' }}' target='_blank'>Chat GPT</a>
            @endif
            @if (isset($produs->link_imagine_fata))
                <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-right:20px;'
                    href='{{ $produs->link_imagine_fata ?? '' }}' target='_blank'>Imagine față</a>
            @else
                Fără imagine
            @endif
            @if (isset($produs->url))
                <a style='background-color: #008CBA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;'
                    href='{{ $produs->url ?? '' }}' target='_blank'>Link produs</a>
            @else
                Fără link produs
            @endif
        </div>
    </div>
</div>
@endsection
