{{-- blade-formatter-disable --}}
@component('mail::message')
# Merhaba {{ $demo->receiver_name }},

Bu, yatırım planınızın ({{ $demo->receiver_plan }} planı) süresi dolduğunu ve bu plan için sermayenizin çekim için hesabınıza eklendiğini bildirmek için. <br>

<strong>Plan:</strong> {{ $demo->receiver_plan }} <br>

<strong>Miktar:</strong> {{ $demo->received_amount }} <br>

<strong>Tarih:</strong> {{ $demo->date }} <br>

Saygılarımla,<br>
{{ $demo->sender }}.
@endcomponent
{{-- blade-formatter-disable --}}
