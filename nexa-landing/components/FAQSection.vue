<template>
  <section id="faqs" class="section">
    <div class="container-max">
      <h2 class="text-center text-2xl md:text-3xl font-extrabold heading-accent">{{ t('sections.faqs.title') }}</h2>
      <p class="text-center mt-3 muted">{{ t('sections.faqs.desc') }}</p>

      <div class="mt-10 grid md:grid-cols-2 gap-6">
        <FaqItem v-for="(f, i) in faqs" :key="i" :q="f.q" :a="f.a"/>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const { t, tm } = useI18n()
const faqs = tm('faqs.items') as Array<{ q: string; a: string }>
</script>
