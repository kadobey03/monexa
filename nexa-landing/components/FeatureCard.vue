<template>
  <div class="card-dark p-6">
    <div class="flex items-start gap-3">
      <div class="h-10 w-10 rounded-full bg-primary/20 text-primary grid place-items-center">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5v14"/>
        </svg>
      </div>
      <div>
        <h3 class="font-semibold text-slate-900 dark:text-white">{{ title }}</h3>
        <p class="text-sm muted mt-1">{{ desc }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{ title: string; desc: string }>()
</script>
