<template>
  <main>
    <SectionHero
      image="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?q=80&w=1600&auto=format&fit=crop"
      :alt="t('nav.forexCalc')"
      :title="t('nav.forexCalc')"
    />
    <ForexCalculator />
  </main>
</template>

<script setup>
const { t } = useI18n()
</script>
