<div style="margin:0 auto;width:100%; background-color:#eff1f0;">
    <div style="margin:0 auto; max-width:800px!important; background-color: white;">

        @switch (intval($ofertari->limba))
            @case (1)
                @include ('emails.headerFooter.header')
                @break
            @case (2)
                @include ('emails.headerFooter.engleza.header')
                @break
            @default
                @include ('emails.headerFooter.header')
        @endswitch

        <div style="padding:20px 20px; max-width:760px!important;margin:0 auto; font-size:18px">
            @if (intval($ofertari->solicitata) === 0)
                {!! $ofertari->email_text !!}
            @else
                Bun găsit, <b>{{ $ofertari->client->nume ?? '' }}</b>,
                <br><br>
                Îți trimitem atașat Oferta nr. {{ $ofertari->nr_document }} din
                    {{ (isset($ofertari->data_emitere) ? (\Carbon\Carbon::parse($ofertari->data_emitere)->isoFormat('DD.MM.YYYY')) : '') }}.
                <br><br>
                {!! $ofertari->email_text !!}
            @endif

            <br>

            {{-- @if($ofertari->servicii)
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
            @endif --}}
    </div>


    @switch (intval($ofertari->limba))
        @case (1)
            @include ('emails.headerFooter.footer')
            @break
        @case (2)
            @include ('emails.headerFooter.engleza.footer')
            @break
        @default
            @include ('emails.headerFooter.footer')
    @endswitch
</div>



