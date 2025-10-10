@php
     if (Auth('admin')->User()->dashboard_style == 'light') {
         $text = 'dark';
         $bg = 'light';
     } else {
         $bg = 'dark';
         $text = 'light';
     }
 @endphp
 <div>
     <div class="main-panel">
         <div class="content">
             <div class="page-inner">
                 <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-4 gap-3">
                     <div class="flex-grow-1">
                         <h1 class="fw-bold text-primary mb-1" style="font-size: 1.75rem; line-height: 1.2;">
                             <i class="fas fa-users me-2"></i>{{ $settings->site_name }} Kullanıcıları
                         </h1>
                         <p class="text-muted mb-0" style="font-size: 1rem;">Kullanıcı hesaplarını yönetin ve düzenleyin</p>
                     </div>
                     <div class="d-flex gap-2 flex-shrink-0">
                         <span class="badge bg-primary fs-6 px-3 py-2" style="border-radius: 8px; font-weight: 500;">
                             <i class="fas fa-user-check me-1"></i>{{ $users->total() }} Kullanıcı
                         </span>
                     </div>
                 </div>
                 {{-- Genel Error Handling Alert Bölümü --}}
                 <div id="general-error-alert" class="alert alert-danger alert-dismissible fade show border-0 bg-light" role="alert" style="display: none;">
                     <div class="d-flex align-items-center">
                         <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                         <div class="flex-grow-1">
                             <strong>Bir Hata Oluştu!</strong>
                             <span id="error-message-text">Lütfen tekrar deneyin veya sistem yöneticisiyle iletişime geçin.</span>
                         </div>
                         <button type="button" class="btn-close" onclick="hideErrorAlert()" aria-label="Hata mesajını kapat"></button>
                     </div>
                 </div>

                 {{-- Başarı Mesajları --}}
                 <div id="success-alert" class="alert alert-success alert-dismissible fade show border-0 bg-light" role="alert" style="display: none;">
                     <div class="d-flex align-items-center">
                         <i class="fas fa-check-circle me-2 text-success"></i>
                         <div class="flex-grow-1">
                             <strong>Başarılı!</strong>
                             <span id="success-message-text">İşlem başarıyla tamamlandı.</span>
                         </div>
                         <button type="button" class="btn-close" onclick="hideSuccessAlert()" aria-label="Başarı mesajını kapat"></button>
                     </div>
                 </div>

                 {{-- Uyarı Mesajları --}}
                 <div id="warning-alert" class="alert alert-warning alert-dismissible fade show border-0 bg-light" role="alert" style="display: none;">
                     <div class="d-flex align-items-center">
                         <i class="fas fa-exclamation-circle me-2 text-warning"></i>
                         <div class="flex-grow-1">
                             <strong>Dikkat!</strong>
                             <span id="warning-message-text">Lütfen dikkatli olun.</span>
                         </div>
                         <button type="button" class="btn-close" onclick="hideWarningAlert()" aria-label="Uyarı mesajını kapat"></button>
                     </div>
                 </div>

                 {{-- Bilgi Mesajları --}}
                 <div id="info-alert" class="alert alert-info alert-dismissible fade show border-0 bg-light" role="alert" style="display: none;">
                     <div class="d-flex align-items-center">
                         <i class="fas fa-info-circle me-2 text-info"></i>
                         <div class="flex-grow-1">
                             <strong>Bilgi:</strong>
                             <span id="info-message-text">Bilgilendirme mesajı.</span>
                         </div>
                         <button type="button" class="btn-close" onclick="hideInfoAlert()" aria-label="Bilgi mesajını kapat"></button>
                     </div>
                 </div>

                 <x-danger-alert />
                 <x-success-alert />

                 <div class="row">
                     <div class="col-12">
                         <div class="card border-0 shadow-lg"
                              role="region"
                              aria-labelledby="users-management-heading"
                              style="border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.08);">
                             <div class="card-header bg-gradient-primary text-white border-0 p-4"
                                  style="border-radius: 12px 12px 0 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                 <div class="row align-items-center">
                                     <div class="col-lg-6 col-md-12 mb-3 mb-md-0">
                                         <div class="search-box position-relative">
                                             <div class="input-group input-group-lg">
                                                 <span class="input-group-text bg-white border-end-0" style="border-radius: 8px 0 0 8px;">
                                                     <i class="fas fa-search text-primary" style="font-size: 1.1rem;"></i>
                                                 </span>
                                                 <input wire:model.debounce.500ms='searchvalue'
                                                     class="form-control border-start-0 border-end-0"
                                                     type="search"
                                                     placeholder="👤 İsim, kullanıcı adı veya 📧 e-posta adresi ile ara..."
                                                     aria-label="Kullanıcı arama"
                                                     style="border-radius: 0; font-size: 0.95rem; padding: 0.75rem 1rem;"
                                                     autocomplete="off" />
                                                 <span class="input-group-text bg-white border-start-0" style="border-radius: 0 8px 8px 0;">
                                                     <i class="fas fa-filter text-muted" style="font-size: 0.9rem;"></i>
                                                 </span>
                                             </div>
                                             <div class="search-suggestions position-absolute bg-white border shadow-sm rounded mt-1 w-100" style="display: none; z-index: 1000;">
                                                 <div class="p-2 text-muted small">
                                                     <i class="fas fa-lightbulb me-1"></i>
                                                     İpucu: Hızlı arama için isim, kullanıcı adı veya e-posta adresinin baş harflerini yazın
                                                 </div>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-lg-6 col-md-12">
                                         @if ($checkrecord)
                                             <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                                                 <div class="d-flex">
                                                     <select wire:model='action'
                                                         class="form-select form-select-sm me-2"
                                                         style="min-width: 150px;"
                                                         aria-label="Toplu İşlemler">
                                                         <option value="Delete">🗑️ Sil</option>
                                                         <option value="Clear">🧹 Hesabı Temizle</option>
                                                     </select>
                                                     <button class="btn btn-danger btn-sm"
                                                         wire:click='delsystemuser' type="button">
                                                         <i class="fas fa-check me-1"></i>Uygula
                                                     </button>
                                                 </div>
                                                 <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                     data-bs-target="#TradingModal" type="button">
                                                     <i class="fas fa-coins me-1"></i>ROI Ekle
                                                 </button>
                                                 <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                     data-bs-target="#topupModal" type="button">
                                                     <i class="fas fa-plus me-1"></i>Bakiye Yükle
                                                 </button>
                                             </div>
                                         @else
                                             <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                                                 <button class="btn btn-primary" type="button"
                                                     data-bs-toggle="modal" data-bs-target="#adduser">
                                                     <i class="fas fa-user-plus me-2"></i>Yeni Kullanıcı
                                                 </button>
                                                 <a class="btn btn-info" href="{{ route('emailservices') }}">
                                                     <i class="fas fa-envelope me-2"></i>Mesaj Gönder
                                                 </a>
                                             </div>
                                         @endif
                                     </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 user-management-table"
                                           role="table"
                                           aria-label="Kullanıcı listesi tablosu"
                                           style="border-collapse: separate; border-spacing: 0;">
                                        <thead class="table-light" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 3px solid #dee2e6;">
                                            <tr class="table-header-row">
                                                <th class="border-0 fw-bold text-center" style="width: 50px;" scope="col">
                                                    <input type="checkbox" wire:model='selectPage'
                                                           class="form-check-input"
                                                           aria-label="Tüm kullanıcıları seç"
                                                           title="Tüm kullanıcıları seç" />
                                                </th>
                                                <th class="border-0 fw-bold" scope="col">
                                                    <i class="fas fa-user me-2 text-primary" aria-hidden="true"></i>Müşteri Adı
                                                </th>
                                                <th class="border-0 fw-bold" scope="col">
                                                    <i class="fas fa-at me-2 text-primary" aria-hidden="true"></i>Kullanıcı Adı
                                                </th>
                                                <th class="border-0 fw-bold" scope="col">
                                                    <i class="fas fa-envelope me-2 text-primary" aria-hidden="true"></i>E-posta
                                                </th>
                                                <th class="border-0 fw-bold" scope="col">
                                                    <i class="fas fa-phone me-2 text-primary" aria-hidden="true"></i>Telefon
                                                </th>
                                                <th class="border-0 fw-bold text-center" scope="col">
                                                    <i class="fas fa-toggle-on me-2 text-primary" aria-hidden="true"></i>Durum
                                                </th>
                                                <th class="border-0 fw-bold" scope="col">
                                                    <i class="fas fa-calendar me-2 text-primary" aria-hidden="true"></i>Kayıt Tarihi
                                                </th>
                                                <th class="border-0 fw-bold text-center" scope="col">
                                                    <i class="fas fa-cogs me-2 text-primary" aria-hidden="true"></i>İşlem
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="userslisttbl">

                                            @forelse ($users as $user)
                                                <tr class="align-middle user-table-row"
                                                    role="row"
                                                    tabindex="0"
                                                    data-user-id="{{ $user->id }}"
                                                    style="transition: all 0.2s ease-in-out; border-bottom: 1px solid #e9ecef;"
                                                    onmouseover="this.style.backgroundColor='#f8f9ff'; this.style.transform='translateX(2px)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)';"
                                                    onmouseout="this.style.backgroundColor='transparent'; this.style.transform='translateX(0)'; this.style.boxShadow='none';">
                                                    <td class="text-center" style="padding: 1rem 0.75rem; vertical-align: middle;">
                                                        <input type="checkbox" wire:model='checkrecord'
                                                            value="{{ $user->id }}"
                                                            class="form-check-input"
                                                            aria-label="{{ $user->name }} kullanıcısını seç" />
                                                    </td>
                                                    <td style="padding: 1rem 0.75rem; vertical-align: middle;">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-wrapper me-3">
                                                                <div class="avatar avatar-sm">
                                                                    <span class="avatar-initial bg-label-primary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">
                                                                        {{ substr($user->name, 0, 1) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $user->name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="padding: 1rem 0.75rem; vertical-align: middle;">
                                                        <span class="badge bg-light text-secondary border" style="font-size: 0.8rem; padding: 0.5rem 0.75rem;">{{ $user->username }}</span>
                                                    </td>
                                                    <td style="padding: 1rem 0.75rem; vertical-align: middle;">
                                                        <span class="text-muted" style="font-size: 0.9rem;">{{ $user->email }}</span>
                                                    </td>
                                                    <td style="padding: 1rem 0.75rem; vertical-align: middle;">
                                                        <span class="fw-medium text-dark">{{ $user->phone ?? '-' }}</span>
                                                    </td>
                                                    <td class="text-center" style="padding: 1rem 0.75rem; vertical-align: middle;">
                                                        @if ($user->status == 'active')
                                                            <span class="badge bg-success rounded-pill px-3" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                                                <i class="fas fa-check-circle me-1"></i>Aktif
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger rounded-pill px-3" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                                                <i class="fas fa-times-circle me-1"></i>Pasif
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td style="padding: 1rem 0.75rem; vertical-align: middle;">
                                                        <small class="text-muted fw-medium">{{ $user->created_at->format('d M Y') }}</small>
                                                        <br>
                                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                                    </td>
                                                    <td class="text-center" style="padding: 1rem 0.75rem; vertical-align: middle;">
                                                        <a class='btn btn-outline-primary btn-sm'
                                                            href="{{ route('viewuser', $user->id) }}"
                                                            role="button"
                                                            aria-label="{{ $user->name }} kullanıcısını yönet"
                                                            style="border-radius: 6px; padding: 0.5rem 1rem; font-weight: 500; transition: all 0.2s ease;">
                                                            <i class="fas fa-edit me-1"></i>Yönet
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-5" role="status" aria-live="polite">
                                                        <div class="empty-state">
                                                            <i class="fas fa-users fa-3x text-muted mb-3" aria-hidden="true"></i>
                                                            <h5 class="text-muted" id="no-users-heading">Kullanıcı Bulunamadı</h5>
                                                            <p class="text-muted" aria-describedby="no-users-heading">Henüz hiç kullanıcı eklenmemiş veya arama kriterlerinize uygun kullanıcı bulunamadı.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-light border-0">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="d-flex align-items-center">
                                                <label class="form-label mb-0 me-2 text-muted">Sayfa başına:</label>
                                                <select wire:model='pagenum' class="form-select form-select-sm" style="width: auto;">
                                                    <option>10</option>
                                                    <option>20</option>
                                                    <option>50</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                </select>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <label class="form-label mb-0 me-2 text-muted">Sırala:</label>
                                                <select wire:model='orderby' class="form-select form-select-sm me-2" style="width: auto;">
                                                    <option value="id">ID</option>
                                                    <option value="name">İsim</option>
                                                    <option value="email">E-posta</option>
                                                    <option value="created_at">Kayıt Tarihi</option>
                                                </select>
                                                <select wire:model='orderdirection' class="form-select form-select-sm" style="width: auto;">
                                                    <option value="desc">↓ Azalan</option>
                                                    <option value="asc">↑ Artan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                        <div class="pagination-info text-muted">
                                            {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} arası,
                                            toplam {{ $users->total() }} kullanıcı
                                        </div>
                                        <div class="mt-2">
                                            {!! $users->links() !!}
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

    {{-- Modern Modals --}}
    <!-- Kullanıcı Ekle Modal -->
    <div class="modal fade" tabindex="-1" id="adduser" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold" id="addUserModalLabel">
                        <i class="fas fa-user-plus me-2"></i>Yeni Kullanıcı Ekle
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Kapat"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" wire:submit.prevent='saveUser'>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="usernameinput" class="form-label fw-bold">
                                    <i class="fas fa-at me-2 text-primary"></i>Kullanıcı Adı
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">@</span>
                                    <input type="text" id="usernameinput"
                                        class="form-control form-control-lg border-0 shadow-sm @error('username') is-invalid @enderror"
                                        name="username" wire:model.defer='username'
                                        placeholder="Sadece harf, rakam ve alt çizgi kullanın" required>
                                </div>
                                @error('username')
                                    <div class="text-danger mt-1">
                                        <small><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-2 text-primary"></i>Ad Soyad
                                </label>
                                <input type="text" class="form-control form-control-lg border-0 shadow-sm @error('fullname') is-invalid @enderror"
                                    name="name" wire:model.defer='fullname'
                                    placeholder="Ad ve soyad girin (min. 2 karakter)" required>
                                @error('fullname')
                                    <div class="text-danger mt-1">
                                        <small><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-envelope me-2 text-primary"></i>E-posta Adresi
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email" class="form-control form-control-lg border-0 shadow-sm @error('email') is-invalid @enderror"
                                        name="email" wire:model.defer='email'
                                        placeholder="ornek@domain.com" required>
                                </div>
                                @error('email')
                                    <div class="text-danger mt-1">
                                        <small><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-lock me-2 text-primary"></i>Şifre
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-key text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg border-0 shadow-sm @error('password') is-invalid @enderror"
                                        name="password" wire:model.defer='password'
                                        placeholder="En az 8 karakter, büyük/küçük harf ve rakam" required>
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1">
                                        <small><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</small>
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Şifre en az 8 karakter içermelidir.
                                    </small>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-lock me-2 text-primary"></i>Şifre Onayı
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-check text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg border-0 shadow-sm @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" wire:model.defer='password_confirmation'
                                        placeholder="Şifreyi tekrar girin" required>
                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger mt-1">
                                        <small><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" wire:loading.attr="disabled" wire:target="saveUser">
                                <span wire:loading.remove wire:target="saveUser">
                                    <i class="fas fa-user-plus me-2"></i>Kullanıcı Ekle
                                </span>
                                <span wire:loading wire:target="saveUser">
                                    <i class="fas fa-spinner fa-spin me-2"></i>Kayıt Ediliyor...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Yeni kullanıcı ekleme modalı sonu --}}

    <!-- ROI Ekleme Modal -->
    <div id="TradingModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-dark border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-coins me-2"></i>Seçili Kullanıcılara ROI Ekle
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-warning border-0 bg-light">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Toplu ROI Ekleme:</strong> Seçili kullanıcılara aynı plan üzerinden ROI eklenecektir.
                    </div>
                    <form role="form" method="post" wire:submit.prevent='addRoi'>
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-chart-line me-2 text-warning"></i>Yatırım Planı Seçin
                            </label>
                            <select class="form-select form-select-lg border-0 shadow-sm" name="plan"
                                wire:model.defer='plan' required>
                                <option value="">Plan seçin...</option>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}">
                                        {{ $plan->name }} - {{ $plan->percentage }}%
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar me-2 text-warning"></i>Tarih
                            </label>
                            <input type="date" wire:model.defer='datecreated'
                                class="form-control form-control-lg border-0 shadow-sm" required>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-warning btn-lg w-100">
                                    <i class="fas fa-plus-circle me-2"></i>ROI Geçmişi Ekle
                                </button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="alert alert-info border-0 bg-light">
                                <small>
                                    <i class="fas fa-lightbulb me-1"></i>
                                    <strong>İpucu:</strong> Sistem, kullanıcıların yatırım tutarı ve seçili planda belirtilen
                                    yüzde üzerinden ROI'yi otomatik hesaplayacaktır. Planın yüzde türü olarak % kullanması
                                    gerektiğini unutmayın.
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /send a single user email Modal -->

    <!-- Bakiye Yükleme Modal -->
    <div id="topupModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-wallet me-2"></i>Bakiye İşlemleri
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-success border-0 bg-light">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Bakiye Yükleme:</strong> Seçili kullanıcıların hesaplarına para ekleme veya çıkarma işlemi yapın.
                    </div>
                    <form method="post" wire:submit.prevent='topup'>
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-money-bill me-2 text-success"></i>Tutar
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-dollar-sign text-muted"></i>
                                </span>
                                <input class="form-control border-0 shadow-sm" placeholder="0.00"
                                    type="number" step="any" name="amount" wire:model.defer='topamount' required>
                            </div>
                            @if($topamount)
                                <div class="form-text">
                                    <small class="text-muted">Girilen tutar: <strong>{{ $topamount }}</strong></small>
                                </div>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-piggy-bank me-2 text-success"></i>Hesap Türü
                            </label>
                            <select class="form-select form-select-lg border-0 shadow-sm" wire:model.defer='topcolumn'
                                name="type" required>
                                <option value="">Hesap türü seçin...</option>
                                <option value="Bonus">🎁 Bonus Hesabı</option>
                                <option value="balance">💰 Ana Bakiye</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-exchange-alt me-2 text-success"></i>İşlem Türü
                            </label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="credit"
                                            wire:model.defer='toptype' value="Credit">
                                        <label class="form-check-label fw-bold text-success" for="credit">
                                            <i class="fas fa-plus-circle me-1"></i>Ekle (Kredi)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="debit"
                                            wire:model.defer='toptype' value="Debit">
                                        <label class="form-check-label fw-bold text-danger" for="debit">
                                            <i class="fas fa-minus-circle me-1"></i>Çıkar (Borç)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save me-2"></i>İşlemi Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bakiye yükleme modalı sonu -->
</div>
