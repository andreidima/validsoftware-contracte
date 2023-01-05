@include('emails.headerFooter.header')

<div style="width: 670px; margin:auto">
    {!! $procesVerbal->email_text !!}
</div>

@include('emails.headerFooter.footer')


