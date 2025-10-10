<template>
  <section class="section">
    <div class="container-max">
      <div class="text-center mb-10">
        <h2 class="text-2xl md:text-3xl font-extrabold heading-accent">{{ t('sections.mobile.title') }}</h2>
        <p class="mt-3 muted">{{ t('sections.mobile.desc') }}</p>
      </div>
      <div class="grid md:grid-cols-2 gap-10 items-center">
        <Reveal class="card p-4 order-2 md:order-1">
          <img class="w-full h-auto rounded-xl" alt="Mobile app" src="https://images.unsplash.com/photo-1522125670776-3c7abb882bc2?q=80&w=900&auto=format&fit=crop"/>
        </Reveal>
      <div class="order-1 md:order-2 grid gap-4">
          <FeatureCard title="Intuitive controls" desc="Place orders quickly with one-tap trading and smart confirmations."/>
          <FeatureCard title="Real-time insights" desc="Live quotes, depth of market and smart notifications so you don't miss opportunities."/>
          <FeatureCard title="One-click trading" desc="Execute instantly with configurable order size and risk presets."/>
      </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const { t } = useI18n()
</script>
