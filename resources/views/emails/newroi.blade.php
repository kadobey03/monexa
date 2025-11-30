{{-- blade-formatter-disable --}}
@component('mail::message')
# {{ __('mail.headers.roi_update') }} 📈

## {{ __('mail.salutation.dear_user', ['name' => $user->name]) }},

**{{ __('mail.investment.congratulations') }}!** {{ __('mail.financial.roi_generated') }} {{ __('mail.investment.strategic_choices_performing') }}

### 💰 **{{ __('mail.financial.return_details') }}**

@component('mail::panel', ['color' => 'success'])
**{{ __('mail.investment.performance_summary') }}**

**{{ __('mail.financial.plan') }}:** {{$plan}}<br>
**{{ __('mail.financial.return_amount') }}:** {{$user->currency}}{{number_format($amount, 2)}}<br>
**{{ __('mail.financial.generated_date') }}:** {{$plandate}}<br>
**{{ __('mail.financial.status') }}:** {{ __('mail.financial.credited_to_account') }}
@endcomponent

### 📊 **{{ __('mail.investment.performance_insights') }}**

{{ __('mail.investment.plan_continues_returns', ['plan' => $plan]) }} {{ __('mail.investment.this_return_reflects') }}:

- **{{ __('mail.investment.market_analysis') }}**: {{ __('mail.investment.expert_team_positioning') }}
- **{{ __('mail.investment.risk_management') }}**: {{ __('mail.investment.balanced_portfolio_optimization') }}
- **{{ __('mail.investment.technology_advantage') }}**: {{ __('mail.investment.advanced_algorithmic_systems') }}
- **{{ __('mail.investment.diversification') }}**: {{ __('mail.investment.multi_asset_exposure') }}

### 🚀 **{{ __('mail.investment.growth_potential') }}**

**{{ __('mail.investment.consider_opportunities') }}:**
- **{{ __('mail.investment.compound_growth') }}**: {{ __('mail.investment.reinvest_exponential_growth') }}
- **{{ __('mail.investment.portfolio_expansion') }}**: {{ __('mail.investment.explore_additional_plans') }}
- **{{ __('mail.investment.copy_trading') }}**: {{ __('mail.investment.follow_top_traders_automatically') }}
- **{{ __('mail.investment.premium_strategies') }}**: {{ __('mail.investment.upgrade_higher_tier_plans') }}

@component('mail::button', ['url' => config('app.url').'/dashboard'])
{{ __('mail.actions.view_portfolio') }}
@endcomponent

### 📈 **{{ __('mail.investment.investment_journey') }}**

**{{ __('mail.investment.recent_activity') }}:**
✅ {{ __('mail.investment.actively_managed_expert_team') }}<br>
✅ {{ __('mail.investment.returns_generated_credited') }}<br>
✅ {{ __('mail.investment.portfolio_rebalanced_optimal') }}<br>
📊 {{ __('mail.investment.continuous_monitoring_optimization') }}

**{{ __('mail.investment.next_steps') }}:**
- {{ __('mail.investment.monitor_portfolio_realtime') }}
- {{ __('mail.investment.consider_reinvestment_compound') }}
- {{ __('mail.investment.explore_advanced_tools') }}

### 💡 **{{ __('mail.investment.investment_insights') }}**

@component('mail::panel')
**{{ __('mail.investment.market_analysis') }}:** {{ __('mail.investment.current_conditions_favor_diversified', ['plan' => $plan]) }}
@endcomponent

**{{ __('mail.investment.investment_tips') }}:**
- **{{ __('mail.investment.consistency') }}**: {{ __('mail.investment.regular_investments_outperform') }}
- **{{ __('mail.investment.diversification') }}**: {{ __('mail.investment.spread_risk_multiple_instruments') }}
- **{{ __('mail.investment.long_term_vision') }}**: {{ __('mail.investment.focus_sustainable_growth') }}
- **{{ __('mail.investment.professional_management') }}**: {{ __('mail.investment.leverage_expert_team_expertise') }}

### 📞 **{{ __('mail.investment.professional_support') }}**

{{ __('mail.investment.advisory_team_ready_optimize') }}:

@component('mail::button', ['url' => config('app.url').'/login', 'color' => 'success'])
{{ __('mail.actions.schedule_investment_consultation') }}
@endcomponent

**{{ __('mail.investment.available_services') }}:**
- {{ __('mail.investment.personal_portfolio_review') }}
- {{ __('mail.investment.strategy_optimization') }}
- {{ __('mail.investment.market_analysis_insights') }}
- {{ __('mail.investment.risk_assessment_management') }}

### 🎯 **{{ __('mail.investment.ready_for_more_growth') }}**

**{{ __('mail.investment.expansion_opportunities') }}:**
- **{{ __('mail.investment.higher_tier_plans') }}**: {{ __('mail.investment.unlock_premium_strategies') }}
- **{{ __('mail.investment.copy_trading_elite') }}**: {{ __('mail.investment.institutional_level_traders') }}
- **{{ __('mail.investment.auto_rebalancing') }}**: {{ __('mail.investment.ai_powered_optimization') }}
- **{{ __('mail.investment.vip_services') }}**: {{ __('mail.investment.dedicated_advisor_access') }}

@component('mail::button', ['url' => config('app.url').'/login'])
{{ __('mail.actions.explore_investment_options') }}
@endcomponent

---

### 📊 **{{ __('mail.investment.performance_transparency') }}**

{{ __('mail.investment.believe_full_transparency') }} {{ __('mail.investment.access_detailed_analytics') }}

**{{ __('mail.investment.key_metrics_available') }}:**
- {{ __('mail.investment.realtime_portfolio_valuation') }}
- {{ __('mail.investment.historical_performance_charts') }}
- {{ __('mail.investment.risk_adjusted_return_analysis') }}
- {{ __('mail.investment.benchmark_comparisons') }}

{{ __('mail.investment.thank_you_trust', ['siteName' => $settings->site_name]) }} {{ __('mail.investment.continue_delivering_exceptional') }}

**{{ __('mail.footer.regards') }},**<br>
**{{ __('mail.footer.investment_team', ['siteName' => $settings->site_name]) }}**<br>
*{{ __('mail.footer.partners_in_growth') }}*

---

@component('mail::subcopy')
**{{ __('mail.legal.risk_disclaimer') }}:** {{ __('mail.legal.past_performance') }} {{ __('mail.legal.investment_risk') }} {{ __('mail.legal.financial_advice') }} {{ __('mail.legal.review_risk_disclosure', ['url' => config('app.url').'/risk-disclosure']) }}

{{ __('mail.legal.returns_calculated_performance') }} {{ __('mail.legal.professional_strategies', ['siteName' => $settings->site_name]) }}
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
