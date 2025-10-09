@extends('layouts.base')

@section('title', $settings->site_title)

@section('styles')
@parent

@endsection
@inject('content', 'App\Http\Controllers\FrontController')
@section('content')

<section class="hero-section">
	<div class="container">
		<h1>Kullanım Koşulları</h1>
		<p class="wow slideInLeft">Tüm kullanıcıların kullanım koşullarımızı yöneten kılavuzları bilmek için dikkatlice okumaları tavsiye edilir.</p>
	</div>
</section>
<div class="container my-5">
  <p>Bu {{$settings->site_name}} Kullanım Koşulları, sizin (bundan sonra "siz" veya "sizin" olarak anılacaktır) ve {{$settings->site_name}} operatörleri (aşağıda tanımlandığı gibi) arasında yapılır. {{$settings->site_name}} tarafından sağlanan herhangi bir {{$settings->site_name}} Hizmetine (aşağıda tanımlandığı gibi) erişerek, indirerek, kullanarak veya kabul etmek için "Kabul ediyorum"a tıklayarak, bu Kullanım Koşullarındaki (bundan sonra "bu Koşullar" olarak anılacaktır) tüm şart ve koşulları ve ayrıca Gizlilik Politikamızı okuduğunuzu, anladığınızı ve kabul ettiğinizi kabul edersiniz. Ayrıca, Hizmetlerin bazı özelliklerini kullanırken, o özelliklere uygulanan belirli ek şart ve koşullara tabi olabilirsiniz.</p>
  <p>Lütfen {{$settings->site_name}} Hizmetlerinin kullanımınızı yönettiği için şartları dikkatlice okuyunuz. BU KOŞULLAR, TÜM İDDİALARIN HUKUKİ OLARAK BAĞLAYICI TAHKİM YOLUYLA ÇÖZÜLMESİNİ GEREKTİREN TAHKİM HÜKMÜ DAHİL ÖNEMLİ HÜKÜMLER İÇERİR. Tahkim hükmünün şartları aşağıda Madde 10 "Uyuşmazlıkların Çözümü: Forum, Tahkim, Sınıf Eylemi Feragatı"nda belirtilmiştir. Herhangi bir varlık gibi, Dijital Para Birimleri'nin (aşağıda tanımlandığı gibi) değerleri önemli ölçüde dalgalanabilir ve Dijital Para Birimleri ve türevlerinde satın alma, satma, tutma veya yatırım yaparken önemli ekonomik kayıp riski vardır.{{$settings->site_name}} HİZMETLERİNİ KULLANARAK, ŞUNLARI KABUL VE ANLAŞIRSINIZ: (1) DİJİTAL PARA BİRİMLERİ VE TÜREVLERİNİN İŞLEMLERİ İLE İLİŞKİLİ RİSKLERDEN HABERDAR OLDUĞUNUZ; (2) {{$settings->site_name}} HİZMETLERİNİN KULLANIMI VE DİJİTAL PARA BİRİMLERİ VE TÜREVLERİNİN İŞLEMLERİ İLE İLİŞKİLİ TÜM RİSKLERİ ÜSTLENECEKSİNİZ; VE (3) {{$settings->site_name}} BU GİBİ RİSKLER VEYA OLUMSUZ SONUÇLAR İÇİN SORUMLU OLMAYACAKTIR.</p>
  <p>{{$settings->site_name}} Hizmetlerine herhangi bir kapasitede erişerek, kullanarak veya kullanmaya çalışarak, bu Koşullar tarafından bağlanmayı kabul ettiğinizi kabul edersiniz. Kabul etmiyorsanız, {{$settings->site_name}}'e erişmeyin veya {{$settings->site_name}} hizmetlerini kullanmayın.</p>
</div>







@endsection