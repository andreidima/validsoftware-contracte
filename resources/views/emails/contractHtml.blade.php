<div style="margin:0 auto;width:100%; background-color:#eff1f0;">
    <div style="margin:0 auto; max-width:800px!important; background-color: white;">
        @include ('emails.headerFooter.header')

        <div style="padding:20px 20px; max-width:760px!important;margin:0 auto; font-size:18px">
            Bun ziua, <b>{{ $contracte->client->nume ?? '' }}</b>,
            <br><br>
            Vă trimitem atașat Contractul nr. {{ $contracte->contract_nr }} din
                {{ (isset($contracte->contract_data) ? (\Carbon\Carbon::parse($contracte->contract_data)->isoFormat('DD.MM.YYYY')) : '') }}.
        </div>

        <br><br>

    @include ('emails.headerFooter.footer')
</div>



