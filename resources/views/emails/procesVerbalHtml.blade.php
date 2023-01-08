{{-- @include('emails.headerFooter.header') --}}

{{-- <div style="width: 100%; margin:auto"> --}}
@php

        $procesVerbal->email_text = str_replace('$nr_document', $procesVerbal->nr_document, $procesVerbal->email_text);
        $procesVerbal->email_text = str_replace('$data_emitere', (isset($procesVerbal->data_emitere) ? (\Carbon\Carbon::parse($procesVerbal->data_emitere)->isoFormat('DD.MM.YYYY')) : ''), $procesVerbal->email_text);
        $procesVerbal->email_text = str_replace('$client_nume', ($procesVerbal->client->nume ?? ''), $procesVerbal->email_text);
@endphp
    {!! $procesVerbal->email_text !!}
{{-- </div> --}}

{{-- @include('emails.headerFooter.footer') --}}


