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
                 <div class="d-flex justify-content-between align-items-center mb-4">
                     <div>
                         <h1 class="fw-bold text-primary mb-1">
                             <i class="fas fa-users me-2"></i>{{ $settings->site_name }} Kullanıcıları
                         </h1>
                         <p class="text-muted mb-0">Kullanıcı hesaplarını yönetin ve düzenleyin</p>
                     </div>
                     <div class="d-flex gap-2">
                         <span class="badge bg-primary fs-6 px-3 py-2">
                             <i class="fas fa-user-check me-1"></i>{{ $users->total() }} Kullanıcı
                         </span>
                     </div>
                 </div>
                 <x-danger-alert />
                 <x-success-alert />

                 <div class="row">
                     <div class="col-12">
                         <div class="card border-0 shadow-lg">
                             <div class="card-header bg-gradient-primary text-white border-0 p-4">
                                 <div class="row align-items-center">
                                     <div class="col-lg-6 col-md-12 mb-3 mb-md-0">
                                         <div class="search-box">
                                             <div class="input-group input-group-lg">
                                                 <span class="input-group-text bg-white border-0">
                                                     <i class="fas fa-search text-muted"></i>
                                                 </span>
                                                 <input wire:model.debounce.500ms='searchvalue'
                                                     class="form-control border-0 shadow-none"
                                                     type="search"
                                                     placeholder="İsim, kullanıcı adı veya e-posta ara..."
                                                     aria-label="search" />
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
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0 fw-bold text-center" style="width: 50px;">
                                                    <input type="checkbox" wire:model='selectPage' class="form-check-input" />
                                                </th>
                                                <th class="border-0 fw-bold">
                                                    <i class="fas fa-user me-2 text-primary"></i>Müşteri Adı
                                                </th>
                                                <th class="border-0 fw-bold">
                                                    <i class="fas fa-at me-2 text-primary"></i>Kullanıcı Adı
                                                </th>
                                                <th class="border-0 fw-bold">
                                                    <i class="fas fa-envelope me-2 text-primary"></i>E-posta
                                                </th>
                                                <th class="border-0 fw-bold">
                                                    <i class="fas fa-phone me-2 text-primary"></i>Telefon
                                                </th>
                                                <th class="border-0 fw-bold text-center">
                                                    <i class="fas fa-toggle-on me-2 text-primary"></i>Durum
                                                </th>
                                                <th class="border-0 fw-bold">
                                                    <i class="fas fa-calendar me-2 text-primary"></i>Kayıt Tarihi
                                                </th>
                                                <th class="border-0 fw-bold text-center">
                                                    <i class="fas fa-cogs me-2 text-primary"></i>İşlem
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="userslisttbl">

                                            @forelse ($users as $user)
                                                <tr class="align-middle">
                                                    <td class="text-center">
                                                        <input type="checkbox" wire:model='checkrecord'
                                                            value="{{ $user->id }}" class="form-check-input" />
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-wrapper me-3">
                                                                <div class="avatar avatar-sm">
                                                                    <span class="avatar-initial bg-label-primary rounded-circle">
                                                                        {{ substr($user->name, 0, 1) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <span class="fw-bold">{{ $user->name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-secondary">@{{ $user->username }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">{{ $user->email }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-medium">{{ $user->phone ?? '-' }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($user->status == 'active')
                                                            <span class="badge bg-success rounded-pill px-3">
                                                                <i class="fas fa-check-circle me-1"></i>Aktif
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger rounded-pill px-3">
                                                                <i class="fas fa-times-circle me-1"></i>Pasif
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                                        <br>
                                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <a class='btn btn-outline-primary btn-sm'
                                                            href="{{ route('viewuser', $user->id) }}">
                                                            <i class="fas fa-edit me-1"></i>Yönet
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-5">
                                                        <div class="empty-state">
                                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                            <h5 class="text-muted">Kullanıcı Bulunamadı</h5>
                                                            <p class="text-muted">Henüz hiç kullanıcı eklenmemiş veya arama kriterlerinize uygun kullanıcı bulunamadı.</p>
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
                                        class="form-control form-control-lg border-0 shadow-sm"
                                        name="username" wire:model.defer='username'
                                        placeholder="benzersiz kullanıcı adı" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-2 text-primary"></i>Ad Soyad
                                </label>
                                <input type="text" class="form-control form-control-lg border-0 shadow-sm"
                                    name="name" wire:model.defer='fullname'
                                    placeholder="Kullanıcının tam adı" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-envelope me-2 text-primary"></i>E-posta Adresi
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email" class="form-control form-control-lg border-0 shadow-sm"
                                        name="email" wire:model.defer='email'
                                        placeholder="kullanici@ornek.com" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-lock me-2 text-primary"></i>Şifre
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-key text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg border-0 shadow-sm"
                                        name="password" wire:model.defer='password'
                                        placeholder="Güçlü bir şifre belirleyin" required>
                                </div>
                                <div class="form-text">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Şifre en az 8 karakter içermelidir.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Kullanıcı Ekle
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
