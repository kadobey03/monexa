<template>
  <div class="card-dark">
    <button @click="open = !open" class="w-full flex items-center justify-between p-5 text-left">
      <span class="font-semibold text-white">{{ q }}</span>
      <svg :class="['w-5 h-5 transition-transform', open ? 'rotate-45' : '']" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5v14"/>
      </svg>
    </button>
    <div v-show="open" class="px-5 pb-5 -mt-2 text-sm text-emerald-100/80">{{ a }}</div>
  </div>
</template>

<script setup lang="ts">
defineProps<{ q: string; a: string }>()
const open = ref(false)
</script>
