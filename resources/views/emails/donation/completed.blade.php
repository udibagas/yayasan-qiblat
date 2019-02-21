@component('mail::message')
# Terimakasih

Terimakasih atas donasi yang akan Anda berikan. Silakan

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Terimakasih,<br>
{{ config('app.name') }}
@endcomponent
