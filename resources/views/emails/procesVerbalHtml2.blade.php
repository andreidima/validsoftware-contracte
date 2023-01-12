<div style="margin:0 auto;width:100%; background-color:#eff1f0;">
    <div style="margin:0 auto; max-width:800px!important; background-color: white;">
        @include ('emails.headerFooter.header')

        <div style="padding:20px 20px; max-width:760px!important;margin:0 auto; font-size:18px">
            Bun găsit, <b>{{ $procesVerbal->client->nume ?? '' }}</b>,
            <br><br>
            Îți trimitem atașat Procesul verbal nr. {{ $procesVerbal->nr_document }} din
                {{ (isset($procesVerbal->data_emitere) ? (\Carbon\Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY')) : '') }}.
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

