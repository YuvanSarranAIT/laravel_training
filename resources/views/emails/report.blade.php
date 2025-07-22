@component('mail::message')
# Hello {{ $name }},

This is a test mail from your Laravel app with a PDF attachment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
