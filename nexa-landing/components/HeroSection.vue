<template>
  <section class="relative gradient-hero wave-bg pt-10 md:pt-16 pb-14 overflow-hidden">
    <!-- Decorative background behind headline -->
    <div class="pointer-events-none absolute inset-0 -z-10">
      <img src="https://images.unsplash.com/photo-1644991287959-0f87cd9a8060?q=80&w=2000&auto=format&fit=crop" alt="background" class="absolute inset-0 w-full h-full object-cover opacity-10" />
      <div class="absolute -top-24 -left-24 h-80 w-80 rounded-full bg-emerald-500/15 blur-3xl"></div>
      <div class="absolute -bottom-24 -right-24 h-80 w-80 rounded-full bg-emerald-400/10 blur-3xl"></div>
    </div>
    <div class="container-max grid md:grid-cols-2 gap-10 items-center">
      <Reveal>
        <p class="text-primary font-semibold uppercase tracking-wide mb-3">{{ t('hero.kicker') }}</p>
        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight heading-accent headline-fix max-w-[22ch]">
          {{ t('hero.title') }}
        </h1>
        <p class="mt-4 muted max-w-xl">
          {{ t('hero.desc') }}
        </p>
        <div class="mt-6 flex gap-3">
          <button class="btn-primary">{{ t('hero.ctaPrimary') }}</button>
          <button class="btn-secondary">{{ t('hero.ctaSecondary') }}</button>
        </div>
        <MarketTicker class="mt-10"/>
      </Reveal>

      <div class="hidden md:block relative md:mt-0">
        <Reveal class="card-dark p-2 sm:p-3 md:p-5 animate-float max-w-xs sm:max-w-sm md:max-w-none mx-auto md:mx-0">
          <img class="w-full h-auto rounded-xl aspect-video sm:aspect-[16/10] object-cover" loading="eager" decoding="async" alt="Trading platform screenshot" src="https://hayatestate.com/wp-content/uploads/2022/07/photo1658916471.jpeg"/>
        </Reveal>

        <div class="absolute -bottom-6 -left-6 md:block">
          <div class="card-dark p-4 w-44">
            <p class="text-xs text-emerald-200/80">{{ t('hero.openPositions') }}</p>
            <p class="text-2xl font-bold text-white">+12.4%</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const { t } = useI18n()
</script>
