<template>
  <div class="card py-4 px-5 flex items-center justify-center text-sm font-medium">
    <div class="h-2 w-2 rounded-full bg-primary mr-2"></div>
    <span>{{ title }}</span>
  </div>
</template>

<script setup lang="ts">
defineProps<{ title: string }>()
</script>
