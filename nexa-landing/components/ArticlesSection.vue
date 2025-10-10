<template>
  <section class="section">
    <div class="container-max">
      <div class="text-center mb-8">
        <p class="text-emerald-300/80 text-sm">{{ t('articles.kicker') }}</p>
        <h2 class="text-2xl md:text-3xl font-extrabold heading-accent">{{ t('articles.title') }}</h2>
      </div>
      <div class="grid md:grid-cols-3 gap-5">
        <article v-for="(a,i) in articles" :key="i" class="card-dark overflow-hidden">
          <img :src="a.image" :alt="a.title" class="w-full h-40 object-cover"/>
          <div class="p-5">
            <div class="text-white font-semibold">{{ a.title }}</div>
            <p class="text-emerald-100/70 text-sm mt-1">{{ a.desc }}</p>
            <button class="btn-secondary mt-3">{{ t('articles.read') }}</button>
          </div>
        </article>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const { tm, t } = useI18n()
const articles = tm('articles.items') as Array<{ title: string; desc: string; image: string }>
</script>
