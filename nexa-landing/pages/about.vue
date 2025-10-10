<template>
  <main>
    <SectionHero
      image="https://images.unsplash.com/photo-1497493292307-31c376b6e479?q=80&w=1600&auto=format&fit=crop"
      alt="Biz Kimiz"
      :title="t('nav.about')"
      desc-key=""
    />

    <section class="section">
      <div class="container-max grid lg:grid-cols-3 gap-6 items-start">
        <article class="lg:col-span-2 card-dark p-6 space-y-4 leading-relaxed">
          <h2 class="text-xl font-bold">Vizyonumuz</h2>
          <p>
            Nexa, bireysel ve kurumsal yatırımcılara veriye dayalı, erişilebilir ve güvenli bir işlem deneyimi sunmak için kuruldu.
            Hedefimiz; yatırımcıların bilinçli karar almasını sağlayan şeffaf araçlar, kaliteli veri ve eğitim içeriklerini tek bir
            platformda birleştirmektir.
          </p>
          <h2 class="text-xl font-bold">Yaklaşımımız</h2>
          <p>
            Ürün geliştirme sürecimizde bağımsız uzmanlarla çalışır, kullanıcı geri bildirimlerini döngüsel biçimde ürüne taşırız.
            Güvenlik, performans ve kullanılabilirlik odaklı mimarimiz; çok katmanlı koruma, ayrıştırılmış hesap yapısı ve modern
            veri altyapısı ile desteklenir.
          </p>
          <p>
            Yatırım bir maratondur. Riskleri açıkça anlatır, getiriyi garanti etmeden; disiplinli stratejiler ve risk yönetimi için
            pratik araçlar sunarız.
          </p>
          <h2 class="text-xl font-bold">Toplumsal Katkı</h2>
          <p>
            Yerli şirketlere yönelen sermaye, istihdam ve teknoloji yatırımlarını besler. Finansal okuryazarlığın artması; hem bireylerin
            hem ekonominin dayanıklılığını güçlendirir. Bu doğrultuda eğitim, içerik ve şeffaf ücret politikası ile sürdürülebilir bir
            ekosistem hedefliyoruz.
          </p>
        </article>

        <aside class="grid gap-4">
          <div class="card-dark overflow-hidden">
            <img class="w-full h-40 object-cover" src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1200&auto=format&fit=crop" alt="Ofis"/>
            <div class="p-4 text-sm muted">Kullanıcı odaklı ürün geliştirme kültürü.</div>
          </div>
          <div class="card-dark overflow-hidden">
            <img class="w-full h-40 object-cover" src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1200&auto=format&fit=crop" alt="Grafikler"/>
            <div class="p-4 text-sm muted">Veri güdümlü karar alma ve şeffaf raporlama.</div>
          </div>
        </aside>
      </div>
    </section>
  </main>
</template>

<script setup>
const { t } = useI18n()
</script>

