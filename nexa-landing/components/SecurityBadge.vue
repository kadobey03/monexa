<template>
  <div class="card p-6 text-center">
    <div class="mx-auto h-12 w-12 rounded-full bg-primary/10 text-primary grid place-items-center">
      <svg v-if="icon === 'lock'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 10-8 0v4M7 11h10v9H7z"/>
      </svg>
      <svg v-else-if="icon === 'check'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
      </svg>
      <svg v-else-if="icon === 'key'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a4 4 0 100 8 4 4 0 000-8zM3 21l6-6"/>
      </svg>
      <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v6a7 7 0 11-14 0V7l7-4z"/>
      </svg>
    </div>
    <h3 class="mt-3 font-semibold">{{ title }}</h3>
    <p class="text-xs text-slate-500">{{ desc }}</p>
  </div>
</template>

<script setup lang="ts">
defineProps<{ title: string; desc: string; icon?: 'lock'|'shield'|'check'|'key' }>()
</script>
