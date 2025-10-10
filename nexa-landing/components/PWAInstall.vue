<template>
  <div v-show="visible" class="fixed bottom-4 right-4 z-[60]">
    <div class="card-dark p-4 flex items-center gap-3">
      <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 text-primary"><path fill="currentColor" d="M12 3l2.5 2.5L12 8V6H7v12h10V11h2v9H5V4h7V3z"/></svg>
        <span class="text-sm">Uygulamayı yükle</span>
      </div>
      <button @click="install" class="btn-primary">İndir</button>
      <div class="flex items-center gap-2 ml-2 opacity-80">
        <!-- Google Play icon -->
        <svg viewBox="0 0 24 24" class="w-5 h-5"><path fill="#34A853" d="M1 3l11 9-11 9z"/><path fill="#FBBC05" d="M22 12L12 21l-2.5-2.5L19 12 9.5 3.5 12 1z"/><path fill="#EA4335" d="M9.5 3.5L19 12l-4 3z"/><path fill="#4285F4" d="M1 3l8.5.5L15 9l-5 3-9-9z"/></svg>
        <!-- Apple icon -->
        <svg viewBox="0 0 24 24" class="w-5 h-5"><path fill="#fff" d="M16.365 1.43c0 1.14-.47 2.24-1.23 3.04-.79.83-2.09 1.48-3.22 1.43-.14-1.09.51-2.24 1.29-3.04.83-.86 2.25-1.5 3.16-1.43zM20.5 17.14c-.55 1.21-.82 1.74-1.53 2.8-.99 1.44-2.38 3.23-4.1 3.24-1.54.02-1.94-.95-3.62-.95-1.69 0-2.12.92-3.66.97-1.73.06-3.05-1.56-4.04-3-2.76-4.02-3.05-8.73-1.35-11.22 1.21-1.76 3.14-2.82 4.95-2.82 1.84 0 3 .98 4.53.98 1.5 0 2.37-.98 4.54-.98 1.63 0 3.35.89 4.55 2.42-4 2.19-3.36 7.99-.17 8.56z"/></svg>
      </div>
    </div>
    <div v-if="isIOS && !isStandalone" class="mt-2 text-xs text-emerald-200/80">
      iOS: Paylaş > Ana Ekrana Ekle ile yükleyin.
    </div>
  </div>
</template>

<script setup lang="ts">
const visible = ref(false)
let deferredPrompt: any = null

const isIOS = process.client && /iphone|ipad|ipod/i.test(navigator.userAgent)
const isStandalone = process.client && (window.matchMedia('(display-mode: standalone)').matches || (navigator as any).standalone)

const showIfEligible = () => {
  if (isIOS && !isStandalone) {
    visible.value = true
    return
  }
  if (deferredPrompt) visible.value = true
}

const install = async () => {
  if (deferredPrompt) {
    deferredPrompt.prompt()
    const { outcome } = await deferredPrompt.userChoice
    if (outcome === 'accepted') visible.value = false
    deferredPrompt = null
  } else if (isIOS && !isStandalone) {
    // iOS shows instruction text
    visible.value = true
  }
}

if (process.client) {
  window.addEventListener('beforeinstallprompt', (e: Event) => {
    e.preventDefault()
    // @ts-ignore
    deferredPrompt = e
    showIfEligible()
  })
  window.addEventListener('appinstalled', () => {
    visible.value = false
    deferredPrompt = null
  })
  // First paint condition
  setTimeout(showIfEligible, 800)
}
</script>

