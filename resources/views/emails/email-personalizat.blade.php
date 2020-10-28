{{-- @component('mail::message')
# Bună {{ $fisa->client->nume }},
<br>
Iți trimitem atasat Fișa nr. {{ $fisa->nr_intrare }} de intrare în service a echipamentului tău.

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
{{-- # Bună, {{ $fisa->client->nume }},
<br>
Iți trimitem atașat Fișa nr. {{ $fisa->nr_intrare }} de intrare în service a echipamentului tău.
<br><br>
Mulțumim,
<br>
Echipa ValidSoftware.ro --}}
{{ $email_text }}



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
            <br>
            Creare și mentenanță site-uri de prezentare sau magazine online
            <br>
            Dezvoltare aplicații web personalizate
            <br>
            Realizare fotografii de produs și locație
            <br>
            Service software calculatoare
            <br>
            Consultanță IT
        @endcomponent
    @endslot
@endcomponent