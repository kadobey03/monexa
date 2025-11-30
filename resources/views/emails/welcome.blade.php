{{-- blade-formatter-disable --}}
@component('mail::message')
# {{ __('mail.headers.welcome', ['siteName' => $settings->site_name, 'userName' => $user->name]) }}!

## {{ __('mail.investment.gateway_to_opportunities') }}

{{ __('mail.salutation.dear_user', ['name' => $user->name]) }},

{{ __('mail.investment.excited_to_join', ['siteName' => $settings->site_name]) }} {{ __('mail.investment.financial_growth_journey_begins') }}

### 🚀 **{{ __('mail.investment.what_makes_us_different') }}**

{{ __('mail.investment.more_than_platform', ['siteName' => $settings->site_name]) }} {{ __('mail.investment.strategic_partner_wealth') }}:

- **{{ __('mail.investment.advanced_algorithmic_trading') }}** - {{ __('mail.investment.leverage_ai_strategies') }}
- **{{ __('mail.investment.copy_trading_excellence') }}** - {{ __('mail.investment.follow_replicate_traders') }}
- **{{ __('mail.investment.diversified_plans') }}** - {{ __('mail.investment.conservative_to_aggressive') }}
- **{{ __('mail.investment.realtime_analytics') }}** - {{ __('mail.investment.professional_market_insights') }}
- **{{ __('mail.investment.risk_management_tools') }}** - {{ __('mail.investment.protect_optimize_investments') }}

### 📈 **{{ __('mail.investment.next_steps_success') }}**

@component('mail::panel')
**{{ __('mail.investment.getting_started_simple') }}:**

1. **{{ __('mail.investment.complete_profile') }}** - {{ __('mail.investment.verify_account_security') }}
2. **{{ __('mail.investment.explore_options') }}** - {{ __('mail.investment.review_curated_plans') }}
3. **{{ __('mail.investment.make_first_deposit') }}** - {{ __('mail.investment.start_comfortable_amount') }}
4. **{{ __('mail.investment.choose_strategy') }}** - {{ __('mail.investment.algorithmic_or_copy_trading') }}
5. **{{ __('mail.investment.monitor_grow') }}** - {{ __('mail.investment.track_portfolio_realtime') }}
@endcomponent

@component('mail::button', ['url' => config('app.url').'/dashboard'])
{{ __('mail.actions.access_dashboard') }}
@endcomponent

### 💡 **{{ __('mail.investment.opportunities_awaiting') }}**

**{{ __('mail.investment.beginner_friendly_options') }}:**
- {{ __('mail.investment.low_risk_fixed_returns') }}
- {{ __('mail.investment.educational_resources') }}
- {{ __('mail.investment.dedicated_beginner_support') }}

**{{ __('mail.investment.advanced_features') }}:**
- {{ __('mail.investment.copy_successful_traders_auto') }}
- {{ __('mail.investment.premium_market_signals') }}
- {{ __('mail.investment.advanced_portfolio_tools') }}

### 🛡️ **{{ __('mail.security.your_security_priority') }}**

{{ __('mail.security.investments_protected_with') }}:
- {{ __('mail.security.bank_level_encryption') }}
- {{ __('mail.security.regulatory_compliance') }}
- {{ __('mail.security.24_7_monitoring') }}
- {{ __('mail.security.segregated_customer_funds') }}

### 📞 **{{ __('mail.support.expert_support_needed') }}**

{{ __('mail.support.professional_team_guidance') }}:

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
{{ __('mail.actions.contact_investment_advisors') }}
@endcomponent

**{{ __('mail.support.available_support') }}:**
- {{ __('mail.support.24_7_customer_service') }}
- {{ __('mail.support.personal_investment_consulting') }}
- {{ __('mail.support.educational_webinars') }}
- {{ __('mail.support.market_analysis_insights') }}

---

### 🎯 **{{ __('mail.investment.ready_to_start') }}**

{{ __('mail.investment.global_markets_never_sleep') }} {{ __('mail.investment.whether_seeking') }}:
- {{ __('mail.investment.build_retirement_wealth') }}
- {{ __('mail.investment.generate_passive_income') }}
- {{ __('mail.investment.diversify_portfolio') }}
- {{ __('mail.investment.learn_advanced_strategies') }}

{{ __('mail.investment.platform_provides_tools', ['siteName' => $settings->site_name]) }}

@component('mail::panel', ['color' => 'success'])
**{{ __('mail.investment.special_welcome_offer') }}:** {{ __('mail.investment.30_day_premium_access') }} {{ __('mail.investment.informed_decisions_day_one') }}!
@endcomponent

{{ __('mail.investment.welcome_aboard_success') }}!

**{{ __('mail.footer.team', ['siteName' => $settings->site_name]) }}**<br>
*{{ __('mail.footer.empowering_smart_investors') }}*

---

@component('mail::subcopy')
**{{ __('mail.legal.disclaimer') }}:** {{ __('mail.legal.investment_risk') }} {{ __('mail.legal.past_performance') }} {{ __('mail.legal.understand_risks') }} {{ __('mail.legal.responsible_practices', ['siteName' => $settings->site_name]) }}

{{ __('mail.legal.visit_risk_disclosure') }} [{{ __('mail.legal.risk_disclosure') }}]() {{ __('mail.legal.for_more_info') }}
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
