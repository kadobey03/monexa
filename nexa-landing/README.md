# Nexa Landing — Nuxt 3 + Tailwind

Bu depo; Nuxt 3 ve Tailwind CSS kullanılarak hazırlanmış, yeniden kullanılabilir bileşenlere bölünmüş bir landing page projesidir.

## Özellikler
- Nuxt 3 mimarisi, SSR/SSG destekli
- Tailwind CSS ile responsive ve hızlı stil
- Bölümler komponentleştirildi (Hero, Güvenlik, Fiyatlandırma, SSS vb.)
- Basit animasyonlu piyasa ticker’ı ve varlık akışı

## Başlangıç

1) Bağımlılıkları yükle:
```
npm install
```

2) Geliştirmeyi başlat (otomatik tarayıcı açılır):
```
npm run dev
```

3) Production build al:
```
npm run build
```

4) Build’i önizle:
```
npm run preview
```

## Önemli Dosyalar
- Nuxt ayarları: `nuxt.config.ts`
- Tailwind: `tailwind.config.ts`, `assets/css/tailwind.css`
- Ana sayfa: `pages/index.vue`
- Ortak layout: `app.vue`

## Komponentler (seçme)
- Navigasyon: `components/NavBar.vue`
- Hero + ticker: `components/HeroSection.vue`, `components/MarketTicker.vue`, `components/TickerItem.vue`
- Adımlar: `components/StepsSection.vue`, `components/StepCard.vue`
- Güvenlik: `components/SecuritySection.vue`, `components/SecurityBadge.vue`
- Mobil: `components/MobileTradingSection.vue`, `components/FeatureCard.vue`
- Fiyatlandırma: `components/PricingSection.vue`, `components/PricingCard.vue`
- Varlık akışı: `components/AssetsCarousel.vue`, `components/MiniAssetCard.vue`
- SSS: `components/FAQSection.vue`, `components/FaqItem.vue`
- Footer: `components/FooterSection.vue`

## Özelleştirme
- Renkler/tema: `tailwind.config.ts` içindeki `theme.extend.colors`
- Global butonlar/kartlar: `assets/css/tailwind.css` altındaki `@layer components`
- Metin/içerik: ilgili bileşenlerdeki props ve diziler üzerinden düzenlenir.

## Dağıtım
- Node server: `npm run build` ardından `node .output/server/index.mjs`
- Static/SSG: `npm run generate` (ihtiyaca göre)

---
Geliştirme sırasında öneriler veya istekler için issue açabilirsiniz.

