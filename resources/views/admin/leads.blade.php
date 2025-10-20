@extends('layouts.app')
@section('content')
@section('styles')
@parent
<style>
    .upgrade-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 20px;
        color: white;
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
    }
    .feature-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    .upgrade-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        border-radius: 50px;
        padding: 15px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .upgrade-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection

@include('admin.topmenu')
@include('admin.sidebar')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <!-- Header -->
            <div class="page-header mb-4">
                <div class="d-flex align-items-center">
                    <div class="page-icon-wrapper me-3">
                        <div class="page-icon bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-users-cog fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="title1 mb-1">Lead Yönetimi</h1>
                        <p class="text-muted mb-0">Sistem güncellemesi - Yeni arayüz kullanılabilir</p>
                    </div>
                </div>
            </div>

            <!-- Upgrade Card -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card upgrade-card">
                        <div class="card-body p-5">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <div class="mb-4">
                                        <h2 class="mb-3">🚀 Yeni Lead Yönetim Sistemi</h2>
                                        <p class="lead mb-4">Daha güçlü özellikler, modern tasarım ve gelişmiş kullanıcı deneyimi ile lead'lerinizi yönetin.</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="feature-icon">
                                                <i class="fas fa-tags fa-2x"></i>
                                            </div>
                                            <h5>Dinamik Status Sistemi</h5>
                                            <p class="mb-0 opacity-75">Renk kodlu statuslar, özel durumlar, otomatik takip</p>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="feature-icon">
                                                <i class="fas fa-users-cog fa-2x"></i>
                                            </div>
                                            <h5>Akıllı Atama Sistemi</h5>
                                            <p class="mb-0 opacity-75">Hiyerarşik admin yönetimi, toplu işlemler</p>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="feature-icon">
                                                <i class="fas fa-file-excel fa-2x"></i>
                                            </div>
                                            <h5>Excel Import/Export</h5>
                                            <p class="mb-0 opacity-75">Toplu veri transferi, otomatik üye oluşturma</p>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="feature-icon">
                                                <i class="fas fa-chart-line fa-2x"></i>
                                            </div>
                                            <h5>Lead Scoring & Analytics</h5>
                                            <p class="mb-0 opacity-75">Otomatik puanlama, detaylı raporlama</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="mb-4">
                                        <i class="fas fa-rocket" style="font-size: 120px; opacity: 0.3;"></i>
                                    </div>
                                    <a class="btn upgrade-btn text-white" href="{{ route('admin.leads.index') }}">
                                        <i class="fas fa-arrow-right me-2"></i>
                                        Yeni Sisteme Geç
                                    </a>
                                    <div class="mt-3">
                                        <small class="opacity-75">Modern, hızlı ve güvenli</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-primary mb-3">
                                <i class="fas fa-shield-alt fa-3x"></i>
                            </div>
                            <h5>Güvenli</h5>
                            <p class="text-muted">Tüm verileriniz güvende, modern güvenlik standartları</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-success mb-3">
                                <i class="fas fa-tachometer-alt fa-3x"></i>
                            </div>
                            <h5>Hızlı</h5>
                            <p class="text-muted">Optimize edilmiş performans, anlık yükleme</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-info mb-3">
                                <i class="fas fa-mobile-alt fa-3x"></i>
                            </div>
                            <h5>Responsive</h5>
                            <p class="text-muted">Her cihazda mükemmel görünüm</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-redirect after 10 seconds
setTimeout(function() {
    if (confirm('Yeni Lead Yönetim sistemine otomatik olarak yönlendirilmek ister misiniz?')) {
        window.location.href = "{{ route('admin.leads.index') }}";
    }
}, 10000);
</script>

@endsection