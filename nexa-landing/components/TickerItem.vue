<template>
  <div class="flex items-center gap-2">
    <span class="text-xs font-medium text-slate-500">{{ name }}</span>
    <span class="font-semibold">{{ price }}</span>
    <span :class="changeClass" class="text-xs font-semibold">{{ formattedChange }}</span>
  </div>
</template>

<script setup>
const props = defineProps({
  name: String,
  price: String,
  change: Number
})

const formattedChange = computed(() => {
  const s = Math.abs(props.change).toFixed(2) + '%'
  return (props.change >= 0 ? '+' : '-') + s
})

const changeClass = computed(() => props.change >= 0 ? 'text-emerald-600' : 'text-rose-600')
</script>

