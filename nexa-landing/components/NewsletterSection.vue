<template>
  <section class="section">
    <div class="container-max">
      <div class="card-dark p-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
          <div class="text-white font-semibold text-lg">{{ t('newsletter.title') }}</div>
          <div class="text-emerald-100/70 text-sm">{{ t('newsletter.desc') }}</div>
        </div>
        <form class="flex w-full md:w-auto gap-2" @submit.prevent>
          <input type="email" :placeholder="t('newsletter.placeholder')" class="flex-1 md:w-80 rounded-full border border-emerald-800 bg-transparent px-4 py-2 text-white placeholder:text-emerald-300/60 outline-none"/>
          <button class="btn-primary">{{ t('newsletter.subscribe') }}</button>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
const { t } = useI18n()
</script>

