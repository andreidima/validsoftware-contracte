@component('mail::message')
# Bună {{ $rezervari->nume }},
<br>
Iti trimitem atasat biletul rezervarii
<br><br>
{{-- @component('mail::button', ['url' => url( $rezervari->path() . '/export/rezervare-pdf')])
Descarcă biletul
@endcomponent --}}
Iti multumim pentru ca ai folosit serviciile noastre.
<br><br><br>
Nu raspunde la acest email. Raspunsul tau nu va fi citit.<br>
Do not respond to this message. Your reply will go nowhere. 
<br><br>
ZUZU Transfer-Aeroport <br>
Contact: <br>
+40 748 836 345 <br>
+40 766 862 890 <br>
+40 767335 558 <br>
+40 786 574 788 <br>
Email: carabus25@yahoo.com

{{-- Multumim,<br>
{{ config('app.name') }} --}}
@endcomponent