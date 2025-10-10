<template>
  <footer class="mt-20 border-t border-emerald-900/40">
    <!-- PWA install row in footer -->
    <div class="container-max py-6 flex flex-col md:flex-row items-center justify-between gap-4">
      <div class="text-sm text-emerald-100/90">
        Nexa’yı cihazınıza yükleyin — daha hızlı erişim ve tam ekran deneyimi.
      </div>
      <div class="flex items-center gap-3">
        <button @click="install" class="btn-primary inline-flex items-center gap-2">
          <svg viewBox="0 0 24 24" class="w-5 h-5"><path fill="#34A853" d="M1 3l11 9-11 9z"/><path fill="#FBBC05" d="M22 12L12 21l-2.5-2.5L19 12 9.5 3.5 12 1z"/><path fill="#EA4335" d="M9.5 3.5L19 12l-4 3z"/><path fill="#4285F4" d="M1 3l8.5.5L15 9l-5 3-9-9z"/></svg>
          İndir
        </button>
        <div class="text-xs text-emerald-200/70">
          iOS: Paylaş > Ana Ekrana Ekle
        </div>
      </div>
    </div>

    <div class="container-max py-10 text-sm text-emerald-200/70 flex flex-col md:flex-row items-center justify-between gap-4">
      <p>© {{ year }} Nexa. {{ t('footer.rights') }}</p>
      <div class="flex gap-5">
        <a href="#" class="hover:text-white">{{ t('footer.terms') }}</a>
        <a href="#" class="hover:text-white">{{ t('footer.privacy') }}</a>
        <a href="#" class="hover:text-white">{{ t('footer.contact') }}</a>
      </div>
    </div>
  </footer>
</template>

<script setup>
const { t } = useI18n()
const year = new Date().getFullYear()

let deferredPrompt = null
const isIOS = process.client && /iphone|ipad|ipod/i.test(navigator.userAgent)
const isStandalone = process.client && (window.matchMedia && window.matchMedia('(display-mode: standalone)').matches)

const install = async () => {
  if (deferredPrompt) {
    // @ts-ignore
    deferredPrompt.prompt()
    // @ts-ignore
    await deferredPrompt.userChoice.catch(() => {})
    deferredPrompt = null
  } else if (isIOS && !isStandalone) {
    if (navigator.vibrate) navigator.vibrate(50)
  }
}

if (process.client) {
  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault()
    // @ts-ignore
    deferredPrompt = e
  })
}
</script>

