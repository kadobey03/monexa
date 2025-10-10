// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  modules: ['@nuxtjs/tailwindcss'],
  css: ['~/assets/css/tailwind.css'],
  app: {
    head: {
      title: 'Nexa Finance LLC — Güvenli ve Akıllı Yatırım Platformu',
      htmlAttrs: { class: 'dark', lang: 'tr' },
      meta: [
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
        { name: 'description', content: 'Nexa Finance LLC: Gelişmiş grafikler, hızlı işlem ve uzman desteğiyle güvenli, akıllı yatırım deneyimi. Forex, hisse, kripto ve daha fazlası tek platformda.' },
        { name: 'keywords', content: 'Nexa Finance, yatırım, forex, kripto, borsa, hisse, VİOP, Türkiye, alım satım, platform, güvenli, hızlı, grafik' },
        { name: 'robots', content: 'index, follow' },
        { name: 'theme-color', content: '#0b1b16' },
        { property: 'og:title', content: 'Nexa Finance LLC — Güvenli ve Akıllı Yatırım Platformu' },
        { property: 'og:description', content: 'Gelişmiş grafikler, hızlı işlem ve uzman destekli akıllı yatırım deneyimi.' },
        { property: 'og:type', content: 'website' },
        { property: 'og:locale', content: 'tr_TR' },
        { property: 'og:site_name', content: 'Nexa Finance LLC' },
        { property: 'og:image', content: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1200&auto=format&fit=crop' },
        { name: 'twitter:card', content: 'summary_large_image' },
        { name: 'twitter:title', content: 'Nexa Finance LLC — Güvenli ve Akıllı Yatırım Platformu' },
        { name: 'twitter:description', content: 'Gelişmiş grafikler, hızlı işlem ve uzman destekli akıllı yatırım deneyimi.' },
        { name: 'twitter:image', content: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1200&auto=format&fit=crop' }
      ],
      link: [
        { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
        { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: '' },
        { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap' },
        { rel: 'icon', type: 'image/svg+xml', href: '/logo-nexa.svg' },
        { rel: 'manifest', href: '/manifest.webmanifest' }
      ]
    }
  },
  tailwindcss: {
    viewer: false
  }
})
