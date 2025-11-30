{{-- blade-formatter-disable --}}
@component('mail::message')
# {{ __('mail.headers.withdrawal_request', ['type' => $foramin ? __('mail.admin.review_required') : __('mail.headers.fund_transfer_update')]) }}

@if ($foramin)
## {{ __('mail.admin.withdrawal_alert') }}

{{ __('mail.admin.dear_admin') }},

{{ __('mail.admin.withdrawal_submitted_urgent') }}

**{{ __('mail.financial.withdrawal_request_details') }}:**
- **{{ __('mail.admin.customer') }}:** {{$user->name}}
- **{{ __('mail.financial.amount') }}:** {{$user->currency}}{{number_format($withdrawal->amount, 2)}}
- **{{ __('mail.admin.request_date') }}:** {{now()->format('F j, Y \a\t g:i A')}}
- **{{ __('mail.financial.status') }}:** {{ __('mail.admin.pending_review') }}
- **{{ __('mail.admin.reference_id') }}:** #{{$withdrawal->id ?? 'WDR'.time()}}

**{{ __('mail.admin.required_action') }}:** {{ __('mail.admin.review_customer_account') }}

@component('mail::button', ['url' => config('app.url').'/admin/withdrawals'])
{{ __('mail.actions.review_withdrawal') }}
@endcomponent

@component('mail::panel')
**{{ __('mail.admin.compliance_check') }}:** {{ __('mail.admin.ensure_kyc_aml_requirements') }}
@endcomponent

@else
## {{ __('mail.salutation.dear_user', ['name' => $user->name]) }},

@if ($withdrawal->status == 'Processed')
**{{ __('mail.financial.withdrawal_completed') }} 🎉**

{{ __('mail.financial.withdrawal_approved_processed') }} {{ __('mail.financial.funds_being_sent') }}

**{{ __('mail.financial.transaction_summary') }}:**
- **{{ __('mail.financial.amount') }}:** {{$user->currency}}{{number_format($withdrawal->amount, 2)}}
- **{{ __('mail.financial.processing_date') }}:** {{now()->format('F j, Y \a\t g:i A')}}
- **{{ __('mail.financial.status') }}:** {{ __('mail.financial.successfully_processed') }}
- **{{ __('mail.admin.reference_id') }}:** #{{$withdrawal->id ?? 'WDR'.time()}}

@component('mail::panel', ['color' => 'success'])
**{{ __('mail.financial.fund_transfer_completed') }}:** {{ __('mail.financial.withdrawal_sent_to_account') }} {{ __('mail.financial.funds_appear_timeframe') }}
@endcomponent

**{{ __('mail.financial.what_to_expect') }}:**
- **{{ __('mail.financial.bank_transfers') }}:** {{ __('mail.financial.bank_transfer_timeframe') }}
- **{{ __('mail.financial.digital_wallets') }}:** {{ __('mail.financial.digital_wallet_timeframe') }}
- **{{ __('mail.financial.crypto_currency') }}:** {{ __('mail.financial.crypto_confirmations') }}

@component('mail::button', ['url' => config('app.url').'/dashboard/transactions'])
{{ __('mail.actions.view_transaction_history') }}
@endcomponent

**{{ __('mail.investment.continue_growing_portfolio') }}:**
- {{ __('mail.investment.reinvest_profits_compound') }}
- {{ __('mail.investment.explore_copy_trading') }}
- {{ __('mail.investment.access_premium_strategies') }}

@else
**{{ __('mail.financial.withdrawal_processing_patience') }}**

{{ __('mail.financial.withdrawal_received_team_processing') }}

**{{ __('mail.financial.processing_status') }}:**
- **{{ __('mail.financial.amount') }}:** {{$user->currency}}{{number_format($withdrawal->amount, 2)}}
- **{{ __('mail.financial.status') }}:** {{ __('mail.financial.under_review_processing') }}
- **{{ __('mail.admin.reference_id') }}:** #{{$withdrawal->id ?? 'WDR'.time()}}
- **{{ __('mail.admin.submitted') }}:** {{now()->format('F j, Y \a\t g:i A')}}

@component('mail::panel')
**{{ __('mail.financial.processing_timeline') }}:** {{ __('mail.financial.withdrawal_processing_timeframe') }} {{ __('mail.financial.comprehensive_security_checks') }}
@endcomponent

**{{ __('mail.security.verification_process') }}:**
✅ {{ __('mail.security.account_verification_compliance') }}<br>
✅ {{ __('mail.security.anti_fraud_security_scan') }}<br>
🔄 **{{ __('mail.financial.currently_processing_withdrawal') }}**<br>
⏳ {{ __('mail.financial.final_approval_transfer') }}

{{ __('mail.financial.instant_notification_after_approval') }}

@component('mail::button', ['url' => config('app.url').'/dashboard/withdrawals'])
{{ __('mail.actions.track_withdrawal') }}
@endcomponent

@endif
@endif

---

**{{ __('mail.security.important_security_information') }}:**

@component('mail::panel', ['color' => 'warning'])
**{{ __('mail.security.security_reminder') }}:** {{ __('mail.security.never_ask_credentials') }} {{ __('mail.security.contact_security_if_not_requested') }}
@endcomponent

**{{ __('mail.support.need_help') }}**
{{ __('mail.support.dedicated_financial_team_ready') }}

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
{{ __('mail.actions.contact_support_team') }}
@endcomponent

**{{ __('mail.support.quick_support_options') }}:**
- {{ __('mail.support.24_7_live_chat') }}
- {{ __('mail.support.direct_email') }}: {{$settings->contact_email}}
- {{ __('mail.support.phone_business_hours') }}

{{ __('mail.footer.regards') }},<br>
**{{ __('mail.footer.financial_team', ['siteName' => config('app.name')]) }}**<br>
*{{ __('mail.footer.secure_reliable_trusted') }}*

@component('mail::subcopy')
{{ __('mail.security.withdrawal_notification_sent') }} {{ __('mail.security.industry_standard_protocols', ['siteName' => config('app.name')]) }} {{ __('mail.security.all_withdrawals_subject_verification') }} {{ __('mail.security.visit_security_center', ['url' => config('app.url').'/terms']) }}
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
