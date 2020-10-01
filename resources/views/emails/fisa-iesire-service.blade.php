{{-- @component('mail::message')
# Bună {{ $fisa->client->nume }},
<br>
Iți trimitem atasat Fișa nr. {{ $fisa->nr_iesire }} de ieșire din service a echipamentului tău.

Multumim,<br>
{{ config('app.name') }}
@endcomponent --}}


@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            ValidSoftware.ro - Servicii Informatice Focșani
        @endcomponent
    @endslot

{{-- Body --}}
# Bună, {{ $fisa->client->nume }},
<br>
Iți trimitem atașat Fișa nr. {{ $fisa->nr_iesire }} de ieșire din service a echipamentului tău.
<br><br>
Mulțumim,
<br>
Echipa ValidSoftware.ro

{{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} ValidSoftware.ro
        @endcomponent
    @endslot
@endcomponent