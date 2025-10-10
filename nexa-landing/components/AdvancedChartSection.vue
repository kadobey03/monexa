<template>
  <section class="section">
    <div class="container-max grid md:grid-cols-2 gap-10 items-center">
      <Reveal>
        <h2 class="text-2xl md:text-3xl font-extrabold heading-accent">{{ t('sections.advancedChart.title') }}</h2>
        <p class="mt-3 muted">{{ t('sections.advancedChart.desc') }}</p>
        <button class="btn-primary mt-6">{{ t('common.explore') }}</button>
      </Reveal>
      <div>
        <Reveal class="card p-4">
          <img class="w-full h-auto rounded-xl" alt="Advanced charts" src="https://images.unsplash.com/photo-1518186233392-c232efbf2373?q=80&w=1200&auto=format&fit=crop"/>
        </Reveal>
      </div>
    </div>
  </section>
</template>

<script setup>
const { t } = useI18n()
</script>
