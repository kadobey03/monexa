@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h3 class="fw-bold mb-3">Hakkında Remedy Technologsy</h3>
                    <p class="text-muted">Profesyonel PHP Script Geliştirme ve Destek Hizmetleri</p>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <!-- Hero Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="card-body text-center text-white py-5">
                                <div class="mb-4">
                                    <i class="fas fa-code fa-4x mb-3 opacity-75"></i>
                                </div>
                                <h1 class="display-4 fw-bold mb-3">Remedy Teknoloji</h1>
                                <p class="lead mb-4">Uzman Laravel PHP Script Geliştirme ve Profesyonel Destek Hizmetleri</p>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <p class="mb-4">Özel Laravel PHP uygulamaları oluşturma, profesyonel kurulum hizmetleri sağlama ve dünya çapındaki işletmeler için sürekli destek sunma konusunda uzmanız.</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <a href="https://t.me/+heFFLpE7w5RjZjQ0" target="_blank" class="btn btn-light btn-lg px-4">
                                        <i class="fab fa-telegram me-2"></i>Destek Al
                                    </a>
                                    <a href="https://codesremedy.com/" target="_blank" class="btn btn-outline-light btn-lg px-4">
                                        <i class="fas fa-globe me-2"></i>Web Sitesini Ziyaret Et
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="row g-4">
                    <!-- Custom Development -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 shadow-sm border-0 hover-shadow-lg transition-all">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle" style="width: 80px; height: 80px;">
                                        <i class="fas fa-code text-primary fa-2x"></i>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold text-dark">Özel Geliştirme</h5>
                                <p class="card-text text-muted small">İşletmenizin ihtiyaçlarına göre uyarlanmış Laravel PHP Script Geliştirme</p>
                                <div class="mt-auto">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">Özel Çözümler</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Installation Service -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 shadow-sm border-0 hover-shadow-lg transition-all">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle" style="width: 80px; height: 80px;">
                                        <i class="fas fa-cogs text-success fa-2x"></i>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold text-dark">Kurulum ve Ayarlar</h5>
                                <p class="card-text text-muted small">Profesyonel script kurulumu ve sunucu yapılandırması</p>
                                <div class="mt-auto">
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Hızlı Kurulum</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Support & Updates -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 shadow-sm border-0 hover-shadow-lg transition-all">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 rounded-circle" style="width: 80px; height: 80px;">
                                        <i class="fas fa-life-ring text-warning fa-2x"></i>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold text-dark">Ömür Boyu Destek</h5>
                                <p class="card-text text-muted small">Devam eden destek, güncellemeler ve güvenlik iyileştirmeleri</p>
                                <div class="mt-auto">
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">7/24 Destek</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customization -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 shadow-sm border-0 hover-shadow-lg transition-all">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 rounded-circle" style="width: 80px; height: 80px;">
                                        <i class="fas fa-palette text-info fa-2x"></i>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold text-dark">Web Sitesi Özelleştirme</h5>
                                <p class="card-text text-muted small">Özel markalama ve UI/UX tasarım iyileştirmeleri</p>
                                <div class="mt-auto">
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">Özel Tasarım</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Services -->
                <div class="row mt-5">
                    <!-- Custom Laravel Development -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-primary text-white border-0">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-laptop-code me-2"></i>Özel Laravel PHP Script Geliştirme
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">Benzersiz bir özellik veya özel yapım bir Laravel PHP script'e mi ihtiyacınız var? Uzman geliştiricilerimiz mevcut script'leri değiştirebilir veya işletmenizin ihtiyaçlarına uygun tamamen yeni çözümler oluşturabilir.</p>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h6 class="fw-bold text-dark">Uzmanlıklar:</h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2"><i class="fas fa-bitcoin text-warning me-2"></i>Bitcoin Yatırım Platformları</li>
                                            <li class="mb-2"><i class="fas fa-university text-primary me-2"></i>Çevrimiçi Bankacılık Sistemleri</li>
                                            <li class="mb-2"><i class="fas fa-exchange-alt text-success me-2"></i>Kripto Borsası Platformları</li>
                                            <li class="mb-2"><i class="fas fa-shipping-fast text-info me-2"></i>Kurye Takip Yazılımı</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge bg-success">✅ Özel Özellik Entegrasyonu</span>
                                    <span class="badge bg-success">✅ Tamamen Duyarlı ve Güvenli</span>
                                    <span class="badge bg-success">✅ Hızlı Teslimat</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Installation Service -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-success text-white border-0">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-server me-2 text-white"></i>Script Kurulum ve Ayarlar Hizmeti
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">Sunucu kurulumları veya script yüklemeleri konusunda deneyimli değil misiniz? Her şeyi ekibimize bırakın! Profesyonel script kurulum hizmetleri sunuyoruz.</p>

                                <div class="mb-3">
                                    <h6 class="fw-bold text-dark">Nelerin Dahil Olduğu:</h6>
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Hızlı ve Güvenli Kurulum</li>
                                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Veritabanı Yapılandırması</li>
                                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Hata Düzeltmeleri ve Optimizasyon</li>
                                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>SSL Sertifikası Kurulumu</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info border-0 mb-0">
                                    <i class="fas fa-info-circle me-2 text white"></i>
                                    <strong>Sorunsuz:</strong> Herhangi bir teknik baş ağrısı olmadan script'inizi kullanmaya başlayın!
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lifetime Support -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-warning text-dark border-0">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-shield-alt me-2 text-white"></i>Ömür Boyu Destek ve Güncellemeler
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">PHP script'lerimiz için ömür boyu destek ve periyodik güncellemeler sağlıyoruz, böylece güvenli, hızlı kalır ve en son teknolojilerle uyumlu kalır.</p>

                                <div class="mb-3">
                                    <h6 class="fw-bold text-dark">Destek Kapsamına Dahil:</h6>
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i class="fas fa-tools text-primary me-2"></i>Küçük Sorunlar için Teknik Destek</li>
                                                <li class="mb-2"><i class="fas fa-bug text-danger me-2"></i>Hata Düzeltmeleri ve Performans İyileştirmeleri</li>
                                                <li class="mb-2"><i class="fas fa-shield-alt text-success me-2"></i>Güvenlik ve Özellik Güncellemeleri</li>
                                                <li class="mb-2"><i class="fas fa-comments text-info me-2"></i>Uzman Rehberlik ve Danışmanlık</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-4 py-2 fs-6">Her Zaman Güncel ve Güvenli</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Website Customization -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-info text-white border-0">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-paint-brush me-2"></i>Web Sitesi Özelleştirme ve Markalama
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">Web sitenize profesyonel ve benzersiz bir görünüm vermek mi istiyorsunuz? İşletmenizin kimliğine uygun özel markalama ve UI/UX iyileştirmeleri sunuyoruz.</p>

                                <div class="mb-3">
                                    <h6 class="fw-bold text-dark">Tasarım Hizmetleri:</h6>
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i class="fas fa-palette text-primary me-2"></i>Özel Logo ve Markalama</li>
                                                <li class="mb-2"><i class="fas fa-mobile-alt text-success me-2"></i>UI/UX İyileştirmeleri</li>
                                                <li class="mb-2"><i class="fas fa-search text-warning me-2"></i>Mobil ve SEO Optimizasyonu</li>
                                                <li class="mb-2"><i class="fas fa-eye text-info me-2"></i>Modern Duyarlı Tasarım</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-success border-0 mb-0">
                                    <i class="fas fa-target me-2"></i>
                                    <strong>Hedef:</strong> Markanızı gerçekten temsil eden bir web sitesi oluşturun!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);">
                            <div class="card-body text-center text-white py-5">
                                <h3 class="fw-bold mb-4">Başlamaya Hazır mısınız?</h3>
                                <p class="lead mb-4">Kişiselleştirilmiş bir teklif ve danışmanlık için bugün bizimle iletişime geçin</p>

                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="p-3 bg-white rounded">
                                                    <i class="fab fa-telegram fa-2x mb-2 text-dark"></i>
                                                    <h6 class="fw-bold text-dark">Telegram Destek</h6>
                                                    <a href="https://t.me/+heFFLpE7w5RjZjQ0" target="_blank" class="btn btn-primary btn-sm">Kanala Katıl</a>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="p-3 bg-white rounded">
                                                    <i class="fas fa-globe fa-2x mb-2 text-dark"></i>
                                                    <h6 class="fw-bold text-dark">Web Sitesini Ziyaret Et</h6>
                                                    <a href="https://codesremedy.com/" target="_blank" class="btn btn-primary btn-sm">codesremedy.com</a>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="p-3 bg-white rounded">
                                                    <i class="fas fa-phone fa-2x mb-2 text-dark"></i>
                                                    <h6 class="fw-bold text-dark">Telefon Desteği</h6>
                                                    <a href="https://t.me/+heFFLpE7w5RjZjQ0" class="btn btn-primary btn-sm"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow-lg:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
        }

        .transition-all {
            transition: all 0.3s ease-in-out;
        }

        .card-header {
            border-bottom: none !important;
        }

        .badge {
            font-size: 0.75rem;
        }

        .alert {
            border-radius: 0.5rem;
        }
    </style>
@endsection
