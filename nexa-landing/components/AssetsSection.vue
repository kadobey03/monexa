<template>
  <section class="section">
    <div class="container-max grid md:grid-cols-2 gap-10 items-center">
      <Reveal class="order-2 md:order-1">
        <h2 class="text-2xl md:text-3xl font-extrabold heading-accent">{{ t('sections.assets.title') }}</h2>
        <p class="mt-3 muted">{{ t('sections.assets.desc') }}</p>
        <div class="mt-6">
          <button class="btn-primary">{{ t('common.openAccount') }}</button>
        </div>
      </Reveal>
      <div class="order-1 md:order-2">
        <Reveal class="card p-4">
          <img class="w-full h-auto rounded-xl" alt="Assets" src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1200&auto=format&fit=crop"/>
        </Reveal>
      </div>
    </div>
  </section>
</template>

<script setup>
const { t } = useI18n()
</script>
