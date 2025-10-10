<template>
  <div class="card p-6 text-left">
    <div class="flex items-center gap-3">
      <div class="h-10 w-10 rounded-full bg-primary/10 text-primary grid place-items-center font-bold">{{ number }}</div>
      <h3 class="font-semibold text-lg">{{ title }}</h3>
    </div>
    <p class="mt-3 text-slate-600 text-sm">{{ desc }}</p>
  </div>
</template>

<script setup lang="ts">
defineProps<{ number: string | number, title: string, desc: string }>()
</script>
