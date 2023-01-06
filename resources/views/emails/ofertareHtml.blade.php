@include('emails.headerFooter.header')

<div style="width: 670px; margin:auto;">
    {!! $ofertari->email_text !!}
</div>

<br>

@if($ofertari->servicii)
    <div style="width: 670px; margin:auto">
        <h3 style="margin-bottom: 0px">Vă oferim următoarele servicii:</h3>
        <ol>
            @foreach ($ofertari->servicii as $serviciu)
                <li style="margin-bottom:10px">
                    {{ $serviciu->nume }}
                    {{ $serviciu->pret ? ' - ' . $serviciu->pret . ' RON' : ''}}{{ $serviciu->recurenta ? '/ ' . $serviciu->recurenta : '' }}
                </li>
            @endforeach
        </ol>
    </div>
@endif

@include('emails.headerFooter.footer')


