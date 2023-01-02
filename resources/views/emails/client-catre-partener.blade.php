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
# Bun găsit, {{ $client->nume }},
<br>
Conform solicitării dvs. și a acordului telefonic, vă trimitem mai jos datele service-ului nostru partener:
<ul>
    @isset($partener->nume)
        <li>
            Nume: {{ $partener->nume }}
        </li>
    @endisset
    @isset($partener->telefon)
        <li>
            Telefon: {{ $partener->telefon }}
        </li>
    @endisset
    @isset($partener->email)
        <li>
            Email: {{ $partener->email }}
        </li>
    @endisset
    @isset($partener->adresa)
        <li>
            Adresa: {{ $partener->adresa }}
        </li>
    @endisset
    @isset($partener->google_maps_link)
        <li>
            Link Google Maps: <a href="{{ $partener->google_maps_link }}" target="_blank">{{ $partener->google_maps_link }}</a>
        </li>
    @endisset
</ul>
<b>Regăsiti atașat și oferta noastră de servicii.</b>
<br><br>
Mulțumim,
<br>
Echipa ValidSoftware
<br>
0744.761.451



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
