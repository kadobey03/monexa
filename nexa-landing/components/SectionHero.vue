<template>
  <section class="relative py-16 md:py-24">
    <div class="absolute inset-0">
      <img :src="image" :alt="alt" class="w-full h-full object-cover"/>
      <div class="absolute inset-0 bg-slate-900/70"></div>
    </div>
    <div class="relative container-max text-white">
      <h1 class="text-3xl md:text-5xl font-extrabold leading-tight">
        {{ title || t(titleKey) }}
      </h1>
      <p v-if="desc || descKey" class="mt-3 text-slate-200 max-w-2xl">
        {{ desc || (descKey ? t(descKey) : '') }}
      </p>
    </div>
  </section>
</template>

<script setup lang="ts">
const props = defineProps<{
  image: string
  alt?: string
  titleKey?: string
  descKey?: string
  title?: string
  desc?: string
}>()
const { t } = useI18n()
</script>

