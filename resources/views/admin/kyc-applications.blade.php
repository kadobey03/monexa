<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $bg = 'dark';
    $text = 'light';
}
?>
@extends('layouts.app')
@section('content')
@section('styles')
<style>
   .bg-gradient-primary {
       background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
   }
   .bg-gradient-info {
       background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
   }
   .bg-gradient-warning {
       background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
   }
   .bg-light-success {
       background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
       color: white;
   }
   .bg-light-danger {
       background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
       color: white;
   }
   .user-avatar-wrapper {
       position: relative;
   }
   .user-avatar {
       width: 60px;
       height: 60px;
       border-radius: 50%;
       display: flex;
       align-items: center;
       justify-content: center;
       box-shadow: 0 4px 15px rgba(0,0,0,0.2);
   }
   .info-card {
       transition: transform 0.2s ease, box-shadow 0.2s ease;
   }
   .info-card:hover {
       transform: translateY(-2px);
       box-shadow: 0 4px 15px rgba(0,0,0,0.1);
   }
   .info-icon {
       flex-shrink: 0;
   }
   .section-divider {
       margin-bottom: 1.5rem;
   }
   .document-card {
       transition: transform 0.2s ease, box-shadow 0.2s ease;
   }
   .document-card:hover {
       transform: translateY(-2px);
       box-shadow: 0 8px 25px rgba(0,0,0,0.15);
   }
   .document-image {
       max-height: 200px;
       width: auto;
       border: 2px solid #e9ecef;
   }
   .modal-icon-wrapper {
       background: rgba(255,255,255,0.2);
       padding: 10px;
       border-radius: 50%;
   }
   .status-card {
       transition: transform 0.2s ease;
       cursor: pointer;
   }
   .status-card:hover {
       transform: translateY(-2px);
   }
   .form-control-lg {
       padding: 0.75rem 1rem;
       font-size: 1.1rem;
   }
   .border-2 {
       border-width: 2px;
   }
   .text-underline {
       text-decoration: underline;
       color: #007bff;
   }
   .text-underline:hover {
       color: #0056b3;
   }
</style>
@endsection
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel ">
        <div class="content ">
            <div class="page-inner">
                <p>
                    <a href="{{ route('kyc') }}">
                        <i class="p-2 rounded-lg fa fa-arrow-circle-left fa-2x bg-light"></i>
                    </a>
                </p>

                <div class="mt-2 mb-5 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar-wrapper me-3">
                            <div class="user-avatar bg-gradient-primary">
                                <i class="fas fa-user-check fa-2x text-white"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="title1 text-{{ $text }} mb-1">{{ $kyc->user->name }} KYC Başvurusu</h1>
                            <div class="d-flex align-items-center gap-2">
                                @if ($kyc->status == 'Verified')
                                    <span class="badge badge-success px-3 py-2 fs-6">
                                        <i class="fas fa-check-circle me-1"></i>Doğrulandı
                                    </span>
                                @else
                                    <span class="badge badge-danger px-3 py-2 fs-6">
                                        <i class="fas fa-clock me-1"></i>{{ $kyc->status }}
                                    </span>
                                @endif
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>{{ $kyc->created_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <a href="#" data-toggle="modal" data-target="#action" class="btn btn-primary btn-lg px-4 py-2 shadow-sm">
                        <i class="fas fa-cogs me-2"></i>İşlem
                    </a>
                </div>
                <div id="action" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-gradient-primary text-white">
                                <div class="d-flex align-items-center">
                                    <div class="modal-icon-wrapper me-3">
                                        <i class="fas fa-user-shield fa-2x"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0 text-white">KYC İşlem Paneli</h3>
                                        <small class="text-white-50">{{ $kyc->user->name }} kullanıcısı için işlem yapın</small>
                                    </div>
                                </div>
                                <button type="button" class="close text-white" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-4">
                                <form action="{{ route('processkyc') }}" method="post">
                                    @csrf

                                    <!-- Status Cards -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="status-card bg-light-success text-center p-3 rounded-lg border-success">
                                                <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                                                <h6 class="text-success mb-0">Kabul Et</h6>
                                                <small class="text-muted">Kullanıcıyı doğrula</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="status-card bg-light-danger text-center p-3 rounded-lg border-danger">
                                                <i class="fas fa-times-circle fa-3x text-danger mb-2"></i>
                                                <h6 class="text-danger mb-0">Reddet</h6>
                                                <small class="text-muted">Doğrulanmamış kal</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label text-primary font-weight-bold">
                                            <i class="fas fa-tasks me-2"></i>İşlem Seçimi
                                        </label>
                                        <select name="action" id="kycAction" class="form-control form-control-lg border-2"
                                            required>
                                            <option value="Accept">✅ Kabul et ve kullanıcıyı doğrula</option>
                                            <option value="Reject">❌ Reddet ve doğrulanmamış olarak kal</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label text-primary font-weight-bold">
                                            <i class="fas fa-envelope me-2"></i>E-posta Mesajı
                                        </label>
                                        <textarea name="message" placeholder="Kullanıcıya gönderilecek mesajı buraya yazın..."
                                            class="form-control border-2"
                                            rows="4" required>Bu, gönderdiğiniz belgeler doğrultusunda hesabınızın doğrulandığını bildirmek içindir. Artık tüm hizmetlerimizi kısıtlama olmadan kullanabilirsiniz. Tebrikler!!</textarea>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label text-primary font-weight-bold">
                                            <i class="fas fa-heading me-2"></i>E-posta Konusu
                                        </label>
                                        <input type="text" name="subject" id=""
                                            class="form-control form-control-lg border-2"
                                            placeholder="E-posta konusu"
                                            value="Hesap başarıyla doğrulandı" required>
                                    </div>

                                    <input type="hidden" name="kyc_id" value="{{ $kyc->id }}">

                                    <div class="form-group d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 flex-fill">
                                            <i class="fas fa-paper-plane me-2"></i>Onayla ve Gönder
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">
                                            <i class="fas fa-times me-2"></i>İptal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /view KYC ID Modal -->
                <x-danger-alert />
                <x-success-alert />
                <div class="mb-5 row">
                    <div class="col-md-12">
                        <div class="card shadow-lg border-0 overflow-hidden">
                            <div class="card-header bg-gradient-primary text-white py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle fa-2x me-3"></i>
                                    <div>
                                        <h4 class="mb-0 text-white">Kişisel Bilgiler</h4>
                                        <small class="text-white-50">Kullanıcının temel bilgileri</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <div class="info-card bg-light p-3 rounded-lg h-100">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="info-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-primary mb-0">{{ $kyc->first_name }}</h4>
                                                    <small class="text-muted font-weight-bold">İlk Ad</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="info-card bg-light p-3 rounded-lg h-100">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="info-icon bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-info mb-0">{{ $kyc->last_name }}</h4>
                                                    <small class="text-muted font-weight-bold">Soyadı</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="info-card bg-light p-3 rounded-lg h-100">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="info-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-success mb-0">{{ $kyc->email }}</h4>
                                                    <small class="text-muted font-weight-bold">E-posta</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="info-card bg-light p-3 rounded-lg h-100">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="info-icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-warning mb-0">{{ $kyc->phone_number }}</h4>
                                                    <small class="text-muted font-weight-bold">Telefon Numarası</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="info-card bg-light p-3 rounded-lg h-100">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="info-icon bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-danger mb-0">{{ $kyc->dob }}</h4>
                                                    <small class="text-muted font-weight-bold">Doğum Tarihi</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="info-card bg-light p-3 rounded-lg h-100">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="info-icon bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fab fa-instagram"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-secondary mb-0">{{ $kyc->social_media }}</h4>
                                                    <small class="text-muted font-weight-bold">Sosyal Medya Kullanıcı Adı</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <div class="section-divider bg-gradient-info p-3 rounded-lg text-white">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt fa-2x me-3"></i>
                                                <div>
                                                    <h5 class="mb-0 text-white">Adres Bilgileri</h5>
                                                    <small class="text-white-50">Kullanıcının adres detayları</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <div class="info-card bg-light p-3 rounded-lg h-100">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="info-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-home"></i>
                                                </div>
                                                <div>
                                                    <h5 class="text-primary mb-0">{{ $kyc->address }}</h5>
                                                    <small class="text-muted font-weight-bold">Adres Satırı</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="info-card bg-light p-3 rounded-lg h-100">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="info-icon bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-city"></i>
                                                </div>
                                                <div>
                                                    <h5 class="text-info mb-0">{{ $kyc->city }}</h5>
                                                    <small class="text-muted font-weight-bold">Şehir</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="info-card bg-light p-3 rounded-lg h-100">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="info-icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-map"></i>
                                                </div>
                                                <div>
                                                    <h5 class="text-warning mb-0">{{ $kyc->state }}</h5>
                                                    <small class="text-muted font-weight-bold">Eyalet</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="info-card bg-light p-3 rounded-lg h-100">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="info-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-flag"></i>
                                                </div>
                                                <div>
                                                    <h5 class="text-success mb-0">{{ $kyc->country }}</h5>
                                                    <small class="text-muted font-weight-bold">Uyruk</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <div class="section-divider bg-gradient-warning p-3 rounded-lg text-white">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-id-card fa-2x me-3"></i>
                                                <div>
                                                    <h5 class="mb-0 text-white">Belge Bilgileri</h5>
                                                    <small class="text-white-50">Kimlik doğrulama belgeleri</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-5 col-md-12">
                                        <div class="info-card bg-light p-3 rounded-lg">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="info-icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-file-alt"></i>
                                                </div>
                                                <div>
                                                    <h5 class="text-warning mb-0">{{ $kyc->document_type }}</h5>
                                                    <small class="text-muted font-weight-bold">Belge Türü</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <div class="document-card bg-light p-3 rounded-lg text-center h-100">
                                            <div class="document-header bg-primary text-white p-2 rounded-top">
                                                <i class="fas fa-address-card fa-2x mb-2"></i>
                                                <h6 class="mb-0 text-white">Ön Görünüm</h6>
                                            </div>
                                            <div class="document-body p-3">
                                                <img src="{{ asset('storage/app/public/' . $kyc->frontimg) }}" alt="Belge Ön Yüz"
                                                    class="img-fluid rounded shadow-sm document-image">
                                                <small class="text-muted d-block mt-2 font-weight-bold">Belgenin Ön Görünümü</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="document-card bg-light p-3 rounded-lg text-center h-100">
                                            <div class="document-header bg-info text-white p-2 rounded-top">
                                                <i class="fas fa-address-card fa-2x mb-2"></i>
                                                <h6 class="mb-0 text-white">Arka Görünüm</h6>
                                            </div>
                                            <div class="document-body p-3">
                                                <img src="{{ asset('storage/app/public/' . $kyc->backimg) }}" alt="Belge Arka Yüz"
                                                    class="img-fluid rounded shadow-sm document-image">
                                                <small class="text-muted d-block mt-2 font-weight-bold">Belgenin Arka Görünümü</small>
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
    @endsection
