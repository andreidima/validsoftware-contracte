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
            ValidSoftware Servicii Informatice
        @endcomponent
    @endslot

{{-- Body --}}
# Bun găsit, {{ $fisa->partener->nume }},
<br>
Iți trimitem atașat fișa unui echipament, redirecționat pentru evaluare suplimentară în service-ul dvs.
<br><br>
Mulțumim,
<br>
Echipa ValidSoftware



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
            Creare și mentenanță site-uri de prezentare sau magazine online
            <br>
            Dezvoltare aplicații web personalizate
            <br>
            Realizare fotografii de produs și locație
            <br>
            Service software calculatoare
            <br>
            <br>
            © {{ date('Y') }} ValidSoftware
        @endcomponent
    @endslot
@endcomponent
