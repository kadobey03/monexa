@component('mail::message')
# {{ __('mail.headers.plan_completed') }}

{{ __('mail.salutation.dear_user', ['name' => $name]) }},

{{ __('mail.investment.plan_successfully_completed', ['planName' => $planName]) }}

## {{ __('mail.financial.investment_details') }}
- **{{ __('mail.financial.investment_amount') }}:** {{ $currency }}{{ number_format($amount, 2) }}
- **{{ __('mail.financial.total_profit_earned') }}:** {{ $currency }}{{ number_format($profit, 2) }}
- **{{ __('mail.financial.total_return') }}:** {{ $currency }}{{ number_format($totalReturn, 2) }}
- **{{ __('mail.financial.start_date') }}:** {{ $startDate }}
- **{{ __('mail.financial.end_date') }}:** {{ $endDate }}

@if($profit > 0)
{{ __('mail.investment.congratulations_successful') }} {{ __('mail.financial.profits_credited') }}
@else
{{ __('mail.investment.investment_completed') }} {{ __('mail.financial.check_latest_balance') }}
@endif

{{ __('mail.investment.can_invest_another_plan') }}

@component('mail::button', ['url' => $siteUrl . '/login'])
{{ __('mail.actions.login_account') }}
@endcomponent

{{ __('mail.investment.thank_you_for_choosing', ['siteName' => $siteName]) }}

{{ __('mail.footer.regards') }},<br>
{{ __('mail.footer.team', ['siteName' => $siteName]) }}
@endcomponent
