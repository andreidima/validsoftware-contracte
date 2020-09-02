@component('mail::message')
# Bună {{ $fisa->client->nume }},
<br>
Iți trimitem atasat Fișa de intrare în service a echipamentului tău.

Multumim,<br>
{{ config('app.name') }}
@endcomponent