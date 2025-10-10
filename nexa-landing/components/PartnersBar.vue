<template>
  <div class="bg-emerald-900/20 border-y border-emerald-900/30">
    <div class="container-max overflow-hidden py-3">
      <div class="flex gap-10 animate-ticker opacity-80">
        <span v-for="(p,i) in itemsTwice" :key="i" class="text-emerald-300/80 text-sm">
          {{ p.name }} ${{ p.price.toFixed(2) }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
const base = ['Netlify', 'Webflow', 'Coinbase', 'Spotify', 'Slack', 'Facebook', 'Netlify']
const items = base.map((name) => ({ name, price: 5 + Math.random() * 250 }))
const itemsTwice = [...items, ...items]
</script>
