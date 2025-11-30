{{-- blade-formatter-disable --}}
@component('mail::message')
# {{ __('mail.headers.deposit_success', ['type' => $foramin ? __('mail.admin.notification') : __('mail.headers.welcome_trading')]) }}

@if ($foramin)
## {{ __('mail.admin.deposit_alert') }}

{{ __('mail.admin.dear_admin') }},

{{ __('mail.admin.deposit_received_notification') }}:

**{{ __('mail.financial.deposit_details') }}:**
- **{{ __('mail.admin.customer') }}:** {{$user->name}}
- **{{ __('mail.financial.amount') }}:** {{$user->currency}}{{number_format($deposit->amount, 2)}}
- **{{ __('mail.financial.status') }}:** {{$deposit->status}}
- **{{ __('mail.admin.date') }}:** {{now()->format('F j, Y \a\t g:i A')}}

@if($deposit->status != "Processed")
**{{ __('mail.admin.action_required') }}:** {{ __('mail.admin.review_deposit') }}

@component('mail::button', ['url' => config('app.url').'/admin/dashboard'])
{{ __('mail.actions.process_deposit') }}
@endcomponent
@else
{{ __('mail.admin.deposit_auto_processed') }}
@endif

@else
## {{ __('mail.salutation.dear_user', ['name' => $user->name]) }},

@if ($deposit->status == 'Processed')
**{{ __('mail.financial.deposit_processed') }}**

{{ __('mail.financial.deposit_amount_received', ['currency' => $user->currency, 'amount' => number_format($deposit->amount, 2)]) }} {{ __('mail.financial.full_amount_credited') }}

**{{ __('mail.investment.next_steps') }}**
- {{ __('mail.financial.funds_available_trading') }}
- {{ __('mail.investment.explore_trading_tools') }}
- {{ __('mail.investment.start_portfolio_today') }}

@component('mail::button', ['url' => config('app.url').'/dashboard'])
{{ __('mail.actions.start_trading') }}
@endcomponent

**{{ __('mail.investment.opportunities_awaiting') }}:**
- {{ __('mail.investment.copy_successful_traders') }}
- {{ __('mail.investment.realtime_market_data') }}
- {{ __('mail.investment.algorithmic_trading_tools') }}

@else
**{{ __('mail.financial.deposit_processing') }}**

{{ __('mail.financial.deposit_received_amount', ['currency' => $user->currency, 'amount' => number_format($deposit->amount, 2)]) }} {{ __('mail.financial.team_reviewing') }}

**{{ __('mail.financial.processing_status') }}:** {{ __('mail.financial.under_review') }}
**{{ __('mail.financial.expected_processing_time') }}:** {{ __('mail.financial.processing_timeframe') }}


{{ __('mail.financial.notification_after_verification') }}

@component('mail::panel')
**{{ __('mail.security.security_notice') }}:** {{ __('mail.security.bank_level_protocols') }}
@endcomponent

@endif
@endif

---

**{{ __('mail.support.need_help') }}**
{{ __('mail.support.dedicated_team_available') }}

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
{{ __('mail.actions.contact_support') }}
@endcomponent

{{ __('mail.footer.regards') }},<br>
**{{ __('mail.footer.team', ['siteName' => config('app.name')]) }}**<br>
*{{ __('mail.footer.trusted_trading_partner') }}*

@component('mail::subcopy')
{{ __('mail.footer.auto_generated', ['siteName' => config('app.name')]) }} {{ __('mail.security.do_not_share_email') }} {{ __('mail.security.contact_support_if_not_initiated') }}
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
