{{-- blade-formatter-disable --}}
@component('mail::message')
# {{ __('mail.greetings.hello') }} {{ $demo->receiver_name }},

{{ __('mail.plans.expiry_notification', ['planName' => $demo->receiver_plan]) }} <br>

<strong>{{ __('mail.financial.plan') }}:</strong> {{ $demo->receiver_plan }} <br>

<strong>{{ __('mail.financial.amount') }}:</strong> {{ $demo->received_amount }} <br>

<strong>{{ __('mail.common.date') }}:</strong> {{ $demo->date }} <br>

{{ __('mail.footer.regards') }},<br>
{{ $demo->sender }}.
@endcomponent
{{-- blade-formatter-disable --}}
