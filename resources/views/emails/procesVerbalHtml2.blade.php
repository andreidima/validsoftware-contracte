<div style="margin:0 auto;width:100%; background-color:#eff1f0;">
    <div style="margin:0 auto; max-width:800px!important; background-color: white;">

        @switch (intval($procesVerbal->limba))
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
            Bună ziua, <b>{{ $procesVerbal->client->nume ?? '' }}</b>,
            <br><br>
            @if ($procesVerbal->fisiere->count() === 0)
                Îți trimitem atașat documentul
                <i>
                    {{ $procesVerbal->titlu_document }} nr. {{ $procesVerbal->nr_document }} din
                    {{ (isset($procesVerbal->data_emitere) ? (\Carbon\Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY')) : '') }}.
                </i>
            @else
                Îți trimitem atașat documentele:
                    <ul>
                        <li>
                            <i>
                            {{ $procesVerbal->titlu_document }} nr. {{ $procesVerbal->nr_document }} din
                            {{ (isset($procesVerbal->data_emitere) ? (\Carbon\Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY')) : '') }}.
                            </i>
                        </li>
                        @foreach ($procesVerbal->fisiere as $fisier)
                            <li>
                                <i>
                                {{ substr(($fisier->nume ?? ''), 0, -4) }}
                                </i>
                            </li>
                        @endforeach
                    </ul>
            @endif
            <br>
            {!! $procesVerbal->email_text !!}
            {{-- Mulțumim,
            <br>
            Echipa ValidSoftware
            <br>
            0744.761.451 --}}
        </div>
    </div>


    @switch (intval($procesVerbal->limba))
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

