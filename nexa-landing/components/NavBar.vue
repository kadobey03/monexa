<template>
  <header class="sticky top-0 z-40 bg-slate-900/80 backdrop-blur border-b border-slate-800">
    <div class="container-max h-16 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <img src="/logo-nexa.svg" alt="Nexa Finance" class="h-8 w-8"/>
        <span class="font-extrabold text-lg tracking-tight">Nexa Finance LLC</span>
      </div>

      <nav class="hidden md:flex items-center gap-6 text-sm text-slate-300">
        <NuxtLink class="hover:text-white" to="/">{{ t('nav.home') }}</NuxtLink>
        <NuxtLink class="hover:text-white" to="/assets">{{ t('nav.assets') }}</NuxtLink>
        <NuxtLink class="hover:text-white" to="/forex-calculator">{{ t('nav.forexCalc') }}</NuxtLink>
        <NuxtLink class="hover:text-white" to="/trade">{{ t('nav.trade') }}</NuxtLink>
        <NuxtLink class="hover:text-white" to="/about">{{ t('nav.about') }}</NuxtLink>
      </nav>

      <div class="flex items-center gap-2">
        <select class="h-9 rounded-full border border-slate-700 bg-slate-900 px-3 text-sm text-slate-200"
                :value="locale" @change="onLocaleChange">
          <option value="tr">TR</option>
          <option value="en">EN</option>
        </select>

        <button class="btn-secondary hidden sm:inline-flex">{{ t('auth.login') }}</button>
        <button class="btn-primary hidden sm:inline-flex">{{ t('auth.signup') }}</button>

        <!-- Mobile menu toggle -->
        <button class="md:hidden inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800"
                @click="open = !open" :aria-label="t('nav.openMenu')">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
      </div>
    </div>

    <!-- Mobile menu -->
    <div v-show="open" class="md:hidden border-t border-slate-800">
      <div class="container-max py-3 grid gap-2 text-sm">
        <NuxtLink class="py-2" to="/" @click="open=false">{{ t('nav.home') }}</NuxtLink>
        <NuxtLink class="py-2" to="/assets" @click="open=false">{{ t('nav.assets') }}</NuxtLink>
        <NuxtLink class="py-2" to="/forex-calculator" @click="open=false">{{ t('nav.forexCalc') }}</NuxtLink>
        <NuxtLink class="py-2" to="/trade" @click="open=false">{{ t('nav.trade') }}</NuxtLink>
        <NuxtLink class="py-2" to="/about" @click="open=false">{{ t('nav.about') }}</NuxtLink>
        <div class="pt-3 flex gap-2">
          <button class="btn-secondary flex-1" @click="open=false">{{ t('auth.login') }}</button>
          <button class="btn-primary flex-1" @click="open=false">{{ t('auth.signup') }}</button>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
const open = ref(false)

// i18n
const { t, locale, setLocale } = useI18n()
const onLocaleChange = (e: Event) => {
  const v = (e.target as HTMLSelectElement).value
  setLocale(v)
}

onMounted(() => {
  document.documentElement.classList.add('dark')
})
</script>
