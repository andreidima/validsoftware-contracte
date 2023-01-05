@include('emails.headerFooter.header')

{{-- <div style="text-align:center"> --}}
    <div style="width: 670px; margin:auto">
        {!! $ofertari->email_text !!}
    </div>
{{-- </div> --}}

@include('emails.headerFooter.footer')


