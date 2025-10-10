<template>
  <div class="card-dark p-4 w-64 shrink-0">
    <div class="flex items-center justify-between">
      <div>
        <div class="font-semibold text-slate-900 dark:text-white">{{ symbol }}</div>
        <div class="text-xs text-slate-500 dark:text-emerald-200/80">{{ name }}</div>
      </div>
      <span :class="changeClass" class="text-xs font-semibold">{{ formattedChange }}</span>
    </div>
    <div class="mt-3 text-2xl font-extrabold text-slate-900 dark:text-white">{{ price }}</div>
    <div class="mt-3 h-12 w-full bg-gradient-to-r from-emerald-600/40 to-emerald-400/30 rounded" :class="{ 'from-rose-600/40 to-rose-400/30': change < 0 }"></div>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{ symbol: string; name: string; price: string; change: number }>()
const formattedChange = computed(() => (props.change >= 0 ? '+' : '-') + Math.abs(props.change).toFixed(2) + '%')
const changeClass = computed(() => props.change >= 0 ? 'text-emerald-600' : 'text-rose-600')
</script>
