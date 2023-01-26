<div style="margin:0 auto;width:100%; background-color:#eff1f0;">
    <div style="margin:0 auto; max-width:800px!important; background-color: white;">
        @include ('emails.headerFooter.header')

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

    @include ('emails.headerFooter.footer')
</div>

