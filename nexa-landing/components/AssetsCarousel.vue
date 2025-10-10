<template>
  <section class="section">
    <div class="container-max">
      <h2 class="text-center text-2xl font-extrabold heading-accent mb-6">{{ t('sections.assets.title') }}</h2>
      <div class="overflow-hidden">
        <div class="flex gap-4 animate-ticker">
          <MiniAssetCard v-for="(a, i) in itemsTwice" :key="i" :symbol="a.symbol" :name="a.name" :price="a.price" :change="a.change"/>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const { t } = useI18n()
const items = [
  { symbol: 'AAPL', name: 'Apple Inc.', price: '$224.11', change: +1.04 },
  { symbol: 'TSLA', name: 'Tesla', price: '$254.66', change: -0.62 },
  { symbol: 'AMZN', name: 'Amazon', price: '$169.54', change: +0.66 },
  { symbol: 'MSFT', name: 'Microsoft', price: '$412.16', change: +0.72 },
  { symbol: 'BTCUSD', name: 'Bitcoin', price: '$63,240', change: -1.14 },
  { symbol: 'ETHUSD', name: 'Ethereum', price: '$3,145', change: +0.53 },
]
const itemsTwice = [...items, ...items]
</script>

<style scoped>
.animate-ticker { animation: ticker 60s linear infinite; }
@keyframes ticker {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
</style>
