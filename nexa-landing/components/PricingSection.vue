<template>
  <section id="pricing" class="section">
    <div class="container-max text-center">
      <h2 class="text-2xl md:text-3xl font-extrabold heading-accent">{{ t('sections.pricing.title') }}</h2>
      <p class="mt-3 text-emerald-100/80">{{ t('sections.pricing.desc') }}</p>

      <div class="mt-10 grid md:grid-cols-3 gap-6">
        <PricingCard name="Silver" price="$250" :features="silver"/>
        <PricingCard name="Gold" price="$1,000" highlighted :features="gold"/>
        <PricingCard name="Platinum" price="$10,000" :features="platinum"/>
    </div>
    </div>
  </section>
</template>

<script setup>
const { t, locale } = useI18n()
const trCommon = ['Düşük spreadler', 'Yüksek hızda işlem', '7/24 destek']
const enCommon = ['Tight spreads', 'High-speed execution', '24/7 support']
const common = computed(() => (locale.value === 'tr' ? trCommon : enCommon))
const silver = computed(() => [...common.value, locale.value === 'tr' ? 'Temel analizler' : 'Basic analytics'])
const gold = computed(() => [...common.value, locale.value === 'tr' ? 'Premium sinyaller' : 'Premium signals', locale.value === 'tr' ? 'Öncelikli destek' : 'Priority support'])
const platinum = computed(() => [...common.value, locale.value === 'tr' ? 'VIP yönetici' : 'VIP manager', locale.value === 'tr' ? 'Özel web seminerleri' : 'Exclusive webinars', locale.value === 'tr' ? 'Özel şartlar' : 'Custom conditions'])
</script>
