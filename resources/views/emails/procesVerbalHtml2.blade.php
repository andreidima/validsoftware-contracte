<div style="margin:0 auto;width:100%; background-color:#eff1f0;">
    <div style="margin:0 auto; max-width:800px!important; background-color: white;">
        @include ('emails.headerFooter.header')

        <div style="padding:20px 20px; max-width:760px!important;margin:0 auto; font-size:18px">
            Bună ziua, <b>{{ $procesVerbal->client->nume ?? '' }}</b>,
            <br><br>
            @if ($procesVerbal->fisiere->count() === 0)
                Îți trimitem atașat documentul {{ $procesVerbal->titlu_document }} nr. {{ $procesVerbal->nr_document }} din
                    {{ (isset($procesVerbal->data_emitere) ? (\Carbon\Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY')) : '') }}.
            @else
                Îți trimitem atașat documentele:
                    <ul>
                        <li>
                            {{ $procesVerbal->titlu_document }} nr. {{ $procesVerbal->nr_document }} din
                            {{ (isset($procesVerbal->data_emitere) ? (\Carbon\Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY')) : '') }}.
                        </li>
                        @foreach ($procesVerbal->fisiere as $fisier)
                            <li>
                                {{ substr(($fisier->nume ?? ''), 0, -4) }}
                            </li>
                        @endforeach
                    </ul>
            @endif
            <br><br>
            {!! $procesVerbal->email_text !!}
            {{-- Mulțumim,
            <br>
            Echipa ValidSoftware
            <br>
            0744.761.451 --}}
        </div>
    </div>

    @include ('emails.headerFooter.footer')
</div>

