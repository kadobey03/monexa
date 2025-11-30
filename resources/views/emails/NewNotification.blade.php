{{-- blade-formatter-disable --}}
@component('mail::message')
# {{ $salutaion ? $salutaion : __('mail.headers.important_update') }} {{ $recipient}},

@if ($attachment != null)
    @component('mail::panel')
    **{{ __('mail.attachments.document_attached') }}:** {{ __('mail.attachments.review_details') }}
    @endcomponent
    <div style="text-align: center; margin: 24px 0;">
        <img src="{{ $message->embed(asset('storage/'. $attachment)) }}" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);" alt="Attachment">
    </div>
@endif

## {{ __('mail.headers.account_notification') }}

{!! $body !!}

---

### 📞 **{{ __('mail.support.need_help_title') }}**

{{ __('mail.support.notification_questions') }}

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
{{ __('mail.actions.contact_support_team') }}
@endcomponent

**{{ __('mail.support.quick_options_title') }}:**
- **{{ __('mail.support.live_chat') }}:** {{ __('mail.support.instant_help_dashboard') }}
- **{{ __('mail.support.email_support') }}:** {{$settings->contact_email}}
- **{{ __('mail.support.phone_support') }}:** {{ __('mail.support.business_hours') }}
- **{{ __('mail.support.investment_advisory') }}:** {{ __('mail.support.schedule_consultation') }}

### 🔔 **{{ __('mail.notifications.preferences_title') }}**

{{ __('mail.notifications.manage_preferences_desc') }}

@component('mail::button', ['url' => config('app.url').'/dashboard/settings'])
{{ __('mail.actions.manage_notifications') }}
@endcomponent

### 📊 **{{ __('mail.updates.stay_informed_title') }}**

**{{ __('mail.updates.track_journey') }}:**
- {{ __('mail.updates.portfolio_performance') }}
- {{ __('mail.updates.market_insights') }}
- {{ __('mail.updates.trading_opportunities') }}
- {{ __('mail.updates.security_notifications') }}
- {{ __('mail.updates.platform_updates') }}

---

### 🛡️ **{{ __('mail.security.security_notice_title') }}**

@component('mail::panel', ['color' => 'warning'])
**{{ __('mail.security.important_label') }}:** {{ __('mail.security.never_ask_credentials_detailed', ['appName' => config('app.name')]) }}
@endcomponent

**{{ __('mail.footer.regards') }},**<br>
**{{ __('mail.footer.app_team', ['appName' => config('app.name')]) }}**<br>
*{{ __('mail.footer.trusted_investment_partner') }}*

---

@component('mail::subcopy')
{{ __('mail.legal.notification_sent_disclaimer', ['appName' => config('app.name')]) }}

{{ __('mail.legal.update_preferences_info') }} [{{ __('mail.legal.account_settings_link') }}]({{config('app.url')}}/dashboard/settings) {{ __('mail.legal.security_notifications_recommendation') }}

© {{date('Y')}} {{$settings->site_name}}. {{ __('mail.legal.all_rights_reserved') }} | [{{ __('mail.legal.privacy_policy') }}]({{$settings->site_address}}/privacy) | [{{ __('mail.legal.terms_of_service') }}]({{$settings->site_address}}/terms)
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
