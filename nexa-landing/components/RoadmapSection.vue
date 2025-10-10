<template>
  <section class="section">
    <div class="container-max">
      <div class="text-center mb-10">
        <p class="text-emerald-300/80 text-sm">{{ t('roadmap.kicker') }}</p>
        <h2 class="text-2xl md:text-3xl font-extrabold heading-accent">{{ t('roadmap.title') }}</h2>
      </div>
      <div class="relative grid md:grid-cols-2 gap-8">
        <div class="absolute left-1/2 -translate-x-1/2 top-0 bottom-0 w-1 bg-emerald-900/40 hidden md:block"></div>
        <div v-for="(step, i) in steps" :key="i" class="relative">
          <div class="card-dark p-5">
            <div class="text-emerald-300/90 text-sm">{{ step.date }}</div>
            <div class="text-white font-semibold mt-1">{{ step.title }}</div>
            <div class="text-emerald-100/70 text-sm mt-1">{{ step.desc }}</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const { tm, t } = useI18n()
const steps = tm('roadmap.items') as Array<{ date: string; title: string; desc: string }>
</script>
