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
# Bună, {{ $fisa->client->nume }},
<br>
Echipamentul dvs. a fost transferat în service-ul partener {{ $fisa->partener->nume }}. 
<br><br>
Datele partenerului:
<ul>
    @isset($fisa->partener->nume)
        <li>
            Nume: {{ $fisa->partener->nume }}
        </li>
    @endisset
    @isset($fisa->partener->telefon)
        <li>
            Nume: {{ $fisa->partener->telefon }}
        </li>
    @endisset
    @isset($fisa->partener->email)
        <li>
            Nume: {{ $fisa->partener->email }}
        </li>
    @endisset
    @isset($fisa->partener->adresa)
        <li>
            Nume: {{ $fisa->partener->adresa }}
        </li>
    @endisset
    @isset($fisa->partener->google_maps_link)
        <li>
            Link Google Maps: {!! $fisa->partener->google_maps_link !!}
        </li>
    @endisset
<br>
Regăsiti atașat fișa de intrare din service-ul nostru.
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
            Creare și mentenanță site-uri de prezentare sau magazine online
            <br>
            Dezvoltare aplicații web personalizate
            <br>
            Realizare fotografii de produs și locație
            <br>
            Service software calculatoare
            <br>
            Consultanță IT
            <br>
            <br>
            © {{ date('Y') }} ValidSoftware.ro
        @endcomponent
    @endslot
@endcomponent