<template>
  <main>
    <SectionHero
      image="https://images.unsplash.com/photo-1487058792275-0ad4aaf24ca7?q=80&w=1600&auto=format&fit=crop"
      :alt="t('nav.assets')"
      title-key="sections.assets.title"
      desc-key="sections.assets.desc"
    />
    <section class="section">
      <div class="container-max">
        <MarketTicker />
      </div>
    </section>
    <AssetsSection />
    <AssetsCarousel />
  </main>
</template>

<script setup>
const { t } = useI18n()
</script>
