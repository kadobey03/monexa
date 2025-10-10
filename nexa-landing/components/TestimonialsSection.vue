<template>
  <section class="section">
    <div class="container-max grid md:grid-cols-2 gap-10 items-center">
      <div>
        <h2 class="text-2xl md:text-3xl font-extrabold heading-accent">{{ t('sections.testimonials.title') }}</h2>
        <p class="mt-3 muted">{{ t('sections.testimonials.desc') }}</p>
        <button class="btn-primary mt-6">{{ t('common.register') }}</button>
      </div>
      <div>
        <div class="card-dark p-6">
          <div class="flex items-center gap-3">
            <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/80?img=12" alt="Profile"/>
            <div>
              <div class="font-semibold text-slate-900 dark:text-white">{{ t('testimonialsData.name') }}</div>
              <div class="text-xs text-slate-600 dark:text-emerald-200/80">{{ t('testimonialsData.role') }}</div>
            </div>
          </div>
          <p class="mt-4 text-sm muted">{{ t('testimonialsData.quote') }}</p>
          <div class="mt-4 flex items-center gap-1 text-amber-400">
            <span v-for="i in 5" :key="i">★</span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const { t } = useI18n()
</script>
