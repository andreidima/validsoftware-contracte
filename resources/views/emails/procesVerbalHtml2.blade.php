<div style="margin:0 auto;width:100%; background-color:#eff1f0;">
    {{-- Header --}}
    {{-- <div style="margin:0 auto;
                max-width:800px!important;
                margin-top:0px;
                background-color: white;
                border-bottom:2px solid #eff1f0;
                border-image: linear-gradient(to right, red, blue) 1;
                ">
        <img src="{{ asset('images/email/Logo-VSO-Site-Header.jpg') }}" style="height:73px; padding:10px 20px;">
    </div> --}}

    {{-- Main --}}
    <div style="margin:0 auto;
                max-width:800px!important;
                background-color: white;
                ">

        <img src="{{ asset('images/email/logo-email.jpg') }}" style="padding:20px 0px;">

        <hr style="height: 1px; background-image: linear-gradient(to right, red, blue); margin:0px 20px;">

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

    {{-- Footer --}}
    <div style="margin:0 auto;
                max-width:800px!important;
                background-color:#eff1f0;
                text-align:center;
                color:black;
                ">
        <div style="padding:10px 0px; max-width:760px!important;margin:0 auto; font-size:16px">
            Creare și mentenanță site-uri de prezentare sau magazine online
            <br>
            Dezvoltare aplicații web personalizate
            <br>
            Realizare fotografii de produs și locație
            <br>
            Service software calculatoare
            <br>
            <br>
            © {{ date('Y') }} ValidSoftware
        </div>
    </div>
</div>

