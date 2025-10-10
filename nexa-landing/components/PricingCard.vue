<template>
  <div :class="['card-dark p-6 flex flex-col', highlighted ? 'ring-2 ring-primary' : '']">
    <div class="text-sm text-emerald-200/80">{{ name }}</div>
    <div class="mt-2 text-3xl font-extrabold text-white">{{ price }}</div>
    <ul class="mt-4 space-y-2 text-sm text-emerald-100/80 flex-1 text-left">
      <li v-for="(f, i) in features" :key="i" class="flex items-center gap-2">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-4 h-4 text-emerald-400">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <span>{{ f }}</span>
      </li>
    </ul>
    <button class="btn-primary mt-6">{{ t('common.openAccount') }}</button>
  </div>
</template>

<script setup lang="ts">
const { t } = useI18n()
defineProps<{ name: string; price: string; features: string[]; highlighted?: boolean }>()
</script>
