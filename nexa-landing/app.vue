<template>
  <div class="min-h-screen font-sans bg-slate-900 text-slate-100">
    <NavBar />
    <NuxtPage />
    <FooterSection />
  </div>
  <ClientOnly>
    <Teleport to="body">
      <div id="portals" />
    </Teleport>
  </ClientOnly>
  <ClientOnly>
    <PWAInstall />
  </ClientOnly>
</template>

<script setup lang="ts">
if (process.client && 'serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js').catch(() => {});
  });
}
</script>

