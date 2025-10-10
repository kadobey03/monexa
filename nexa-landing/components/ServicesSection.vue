<template>
  <section class="section">
    <div class="container-max">
      <div class="text-center mb-8">
        <p class="text-emerald-300/80 text-sm">{{ t('services.kicker') }}</p>
        <h2 class="text-2xl md:text-3xl font-extrabold heading-accent">{{ t('services.title') }}</h2>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="card-dark p-5" v-for="(s,i) in services" :key="i">
          <div class="w-16 h-16 rounded-full overflow-hidden mx-auto mb-3 border border-emerald-700/40">
            <img :src="s.img" :alt="s.title" class="w-full h-full object-cover" loading="lazy"/>
          </div>
          <div class="text-white font-semibold text-center">{{ s.title }}</div>
          <div class="text-emerald-100/70 text-sm mt-2 text-center">{{ s.desc }}</div>
          <div class="text-center mt-2">
            <a href="#" class="text-primary hover:underline text-sm">Devamı</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const { t } = useI18n()
const services = [
  { title: 'Algoritmik Trading', img: 'https://images.unsplash.com/photo-1555421689-491a97ff2040?q=80&w=800&auto=format&fit=crop', desc: 'İşlemlerinizin otomatik emir altyapısı ile kural bazlı yürütülmesi.' },
  { title: 'Mobil Servisler', img: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=800&auto=format&fit=crop', desc: 'Piyasaları anlık takip edin, pay senedi/varant/viop işlemlerini hızlı ve güvenli yapın.' },
  { title: 'Yatırım Fonları İşlemleri', img: 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=800&auto=format&fit=crop', desc: 'Birikimlerinizi profesyonel yöneticiler ile çeşitli sermaye araçlarında değerlendirin.' },
  { title: 'Devlet Destekli', img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSDBrBvxvWYQhuhkLCTyic3o4V1aOKjlJHOgQ&s', desc: 'Devlet Desteği İle Kazanın.' },
  { title: 'Forex İşlemleri', img: 'https://albyatirim.com.tr/uploads/blogs/71d8a78831894bd3b9bdbb0da46a563f.jpg', desc: 'Kaldıraçlı alım satım ve döviz çiftlerinde 7/24 erişim.' },
  { title: 'Türev Araçları', img: 'https://images.unsplash.com/photo-1559526324-593bc073d938?q=80&w=800&auto=format&fit=crop', desc: 'Riskten korunma veya getiri artırımı için futures, opsiyon ve yapılandırılmış ürünler.' },
  { title: 'Hazine Borçlanma Araçları', img: 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?q=80&w=800&auto=format&fit=crop', desc: 'Sabit getirili menkul kıymetlerde tercih ve vade uyumlu yatırım.' },
  { title: 'Varlık Yönetimi', img: 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=800&auto=format&fit=crop', desc: 'Uzman ekiple hedeflerinize uygun portföy stratejileri ve raporlama.' }
]
</script>
