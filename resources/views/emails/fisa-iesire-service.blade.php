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
@if ($fisa->consultanta_it === 1)
    Îți trimitem atașat Ticketul de Ieșire nr. {{ $fisa->nr_iesire }}, pentru Consultanță IT.
@else
    Iți trimitem atașat Fișa nr. {{ $fisa->nr_iesire }} de ieșire din service a echipamentului tău.
@endif
<br><br>
Te informăm că oferim și servicii de Asistență IT de la distanță. Mai multe detalii
<a href="https://magic.validsoftware.ro/asistenta-it-la-distanta/">aici</a>.
<br><br>
@if ($fisa->client->review_google !== 1)
    Ne dorim mult să știm ce părere ai despre serviciile noastre! Te invităm să ne oferi o recenzie.
    @component('mail::button', ['url' => 'http://search.google.com/local/writereview?placeid=ChIJoX8PeK8YtEARgtFebuluoUo', 'color' => 'success'])
        Recenzia ta
    @endcomponent
@endif

Mulțumim,
<br>
Echipa ValidSoftware.ro
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
            Consultanță IT
            <br>
            <br>
            © {{ date('Y') }} ValidSoftware.ro
        @endcomponent
    @endslot
@endcomponent