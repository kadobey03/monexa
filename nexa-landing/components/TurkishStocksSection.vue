<template>
  <section class="section">
    <div class="container-max">
      <div class="text-center mb-6">
        <p class="text-emerald-300/80 text-sm">{{ t('turkishStocks.kicker') }}</p>
        <h2 class="text-2xl md:text-3xl font-extrabold heading-accent">{{ t('turkishStocks.title') }}</h2>
        <p class="muted mt-2">{{ t('turkishStocks.desc') }}</p>
      </div>

      <!-- Key points -->
      <div class="grid md:grid-cols-3 gap-4 mb-8">
        <div class="card-dark p-4 flex items-start gap-3">
          <div class="h-8 w-8 rounded-full bg-primary/15 text-primary grid place-items-center">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
          </div>
          <div>
            <div class="font-semibold heading-accent">{{ t('turkishStocks.points.investState.title') }}</div>
            <p class="text-sm muted">{{ t('turkishStocks.points.investState.desc') }}</p>
          </div>
        </div>
        <div class="card-dark p-4 flex items-start gap-3">
          <div class="h-8 w-8 rounded-full bg-primary/15 text-primary grid place-items-center">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12"/></svg>
          </div>
          <div>
            <div class="font-semibold heading-accent">{{ t('turkishStocks.points.earn.title') }}</div>
            <p class="text-sm muted">{{ t('turkishStocks.points.earn.desc') }}</p>
          </div>
        </div>
        <div class="card-dark p-4 flex items-start gap-3">
          <div class="h-8 w-8 rounded-full bg-primary/15 text-primary grid place-items-center">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 10-8 0v4M7 11h10v9H7z"/></svg>
          </div>
          <div>
            <div class="font-semibold heading-accent">{{ t('turkishStocks.points.experts.title') }}</div>
            <p class="text-sm muted">{{ t('turkishStocks.points.experts.desc') }}</p>
          </div>
        </div>
      </div>

      <!-- Stocks -->
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <div v-for="(s, i) in stocks" :key="i" class="card-dark overflow-hidden group">
          <div class="relative h-40 sm:h-44 md:h-48 w-full overflow-hidden bg-slate-800/40">
            <img :src="s.image" :alt="s.name" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" @error="onImgErr($event)" loading="lazy"/>
            <div class="absolute top-3 left-3 h-10 w-10 rounded-full bg-white/95 shadow grid place-items-center animate-pulse-glow">
              <img :src="s.logo" :alt="s.name + ' logo'" class="max-h-7 max-w-7 object-contain" @error="onLogoErr($event)"/>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
          </div>
          <div class="p-5">
            <div class="flex items-center justify-between">
              <div>
                <div class="text-white font-semibold">{{ s.name }}</div>
                <div class="text-emerald-200/80 text-xs">{{ s.symbol }}</div>
              </div>
              <div class="text-right">
                <div class="text-white font-bold">${{ s.price.toFixed(2) }}</div>
                <div :class="s.change>=0 ? 'text-emerald-400' : 'text-rose-400'" class="text-xs font-semibold">
                  {{ s.change>=0 ? '+' : '-' }}{{ Math.abs(s.change).toFixed(2) }}%
                </div>
              </div>
            </div>
            <button class="btn-primary mt-4 animate-pulse-glow">{{ t('turkishStocks.tradeCta') }}</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const { t } = useI18n()
interface Stock { name: string; symbol: string; image: string; logo: string; price: number; change: number }
const base: Omit<Stock, 'price' | 'change'>[] = [
  { name: 'Baykar', symbol: 'BAYKAR', image: 'https://idsb.tmgrup.com.tr/ly/uploads/images/2025/02/02/366619.jpg', logo: 'https://upload.wikimedia.org/wikipedia/commons/7/7a/BaykarLogo.png' },
  { name: 'Koç Holding', symbol: 'KCHOL', image: 'https://bursaajansi.com/wp-content/uploads/2024/05/koc-holding-o-sektore-giris-yapiyor-milyarlarca-dolar-yatirim-yapacaklar-IRAEw5Sw.jpg', logo: 'https://www.sirketlerligi.com/pic_lib/sirketler/koc-holding-logo__3178712.png' },
  { name: 'Türkiye Petrolleri', symbol: 'TPAO', image: 'https://beypet.com/storage/420/WhatsApp-Image-2024-08-14-at-14.50.54-(2).jpeg.jpeg', logo: 'https://www.tppd.com.tr/Content/piclib/bigsize/icerikler/28/tp-logo-63110-7044571.png' },
  { name: 'Aselsan', symbol: 'ASELS', image: 'https://image.hurimg.com/i/hurriyet/75/0x0/68c11a9f292d8a4321ac6929.jpg', logo: 'https://s3-symbol-logo.tradingview.com/aselsan--600.png' },
  { name: 'Havelsan', symbol: 'HAVELSAN', image: 'https://www.savunmasanayist.com/wp-content/uploads/2022/05/HAVELSAN-780x470.jpg', logo: 'https://upload.wikimedia.org/wikipedia/commons/c/c8/Havelsan_logo.svg' },
  { name: 'Togg', symbol: 'TOGG', image: 'https://nextcar.ua/images/blog/548/265874.jpg', logo: 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5d/TOGG_logo.svg/2560px-TOGG_logo.svg.png' },
]
const stocks = ref<Stock[]>(base.map((b) => ({
  ...b,
  price: 50 + Math.random() * 450,
  change: -2 + Math.random() * 4
})))

const placeholder = 'https://images.unsplash.com/photo-1556761175-4b46a572b786?q=80&w=1200&auto=format&fit=crop'
const onImgErr = (e: Event) => {
  const el = e.target as HTMLImageElement
  if (el && el.src !== placeholder) {
    el.src = placeholder
  }
}
const onLogoErr = (e: Event) => {
  const el = e.target as HTMLImageElement
  if (el) el.style.display = 'none'
}
</script>
