<template>
  <section class="section">
    <div class="container-max">
      <div class="grid md:grid-cols-2 gap-10 items-center">
        <div class="card-dark p-6">
          <div class="text-sm text-emerald-300/80">{{ t('benefits.kicker') }}</div>
          <h2 class="mt-2 text-2xl md:text-3xl font-extrabold heading-accent">{{ t('benefits.title') }}</h2>
          <p class="mt-3 text-emerald-100/80">{{ t('benefits.desc') }}</p>
          <button class="btn-primary mt-6">{{ t('common.signup') }}</button>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
          <div class="card-dark p-5" v-for="(f,i) in features" :key="i">
            <div class="h-10 w-10 rounded-full bg-emerald-500/15 text-emerald-300 grid place-items-center mb-3">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="text-white font-semibold">{{ f.title }}</div>
            <div class="text-emerald-100/70 text-sm mt-1">{{ f.desc }}</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const { t, tm } = useI18n()
const features = tm('benefits.items') as Array<{ title: string; desc: string }>
</script>
