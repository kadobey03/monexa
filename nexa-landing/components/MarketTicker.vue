<template>
  <div class="overflow-hidden rounded-full border border-emerald-900/40 bg-emerald-900/20">
    <div class="flex whitespace-nowrap animate-ticker" :style="styleVar">
      <div class="flex items-center gap-8 py-3 px-6" v-for="n in 2" :key="n">
        <TickerItem v-for="(a, i) in assets" :key="i" :name="a.name" :price="a.price" :change="a.change"/>
      </div>
    </div>
  </div>
  
</template>

<script setup>
const assets = [
{ name: 'BIST 100 (XU100)', price: '$9.450', change: +0.42 },
  { name: 'ABD Doları / TL', price: '$32,24', change: +0.15 },
  { name: 'Euro / TL', price: '$35,12', change: -0.08 },
  { name: 'Aselsan (ASELS)', price: '$72,40', change: +1.12 },
  { name: 'Türk Hava Yolları (THYAO)', price: '$315,10', change: -0.35 },
  { name: 'Garanti BBVA (GARAN)', price: '$58,20', change: +0.66 },
  { name: 'Bitcoin (BTC/USD)', price: '$63.240', change: -1.14 },
  { name: 'Ethereum (ETH/USD)', price: '$3.145', change: +0.53 },
  { name: 'Altın (XAU/USD)', price: '$2.345', change: +0.17 },
]

const styleVar = {
  '--tw': 'var(--tw)'
}
</script>

<style scoped>
.animate-ticker { animation: ticker 45s linear infinite; }
@keyframes ticker {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
</style>
