<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
} else {
    $text = 'light';
}
?>
@extends('layouts.app')

@section('styles')
    @parent
    <style>
        .modern-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .admin-card {
            transition: all 0.3s ease;
            border-radius: 1rem;
            overflow: hidden;
        }
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
        }
        .action-btn {
            border-radius: 0.5rem;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }
        .action-btn:hover {
            transform: translateY(-1px);
        }
        .modal-modern {
            border-radius: 1.5rem;
            border: none;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        .modal-header-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 1.5rem 1.5rem 0 0;
            border: none;
        }
        .btn-modern {
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .form-control-modern {
            border-radius: 0.75rem;
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control-modern:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        /* Custom badge colors */
        .badge-purple {
            background-color: #8b5cf6;
            color: white;
        }
        .text-purple {
            color: #8b5cf6;
        }
        
        /* Ensure proper spacing and layout */
        .main-panel {
            margin-left: 250px;
            width: calc(100% - 250px);
            min-height: 100vh;
        }
        
        /* Responsive adjustments */
        @media (max-width: 991px) {
            .main-panel {
                margin-left: 0;
                width: 100%;
            }
        }
        
        /* Fix any layout issues */
        .wrapper {
            display: flex;
            width: 100%;
        }
        
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 250px;
            z-index: 1000;
        }
        
        /* Card improvements */
        .card-header.modern-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }
        
        /* Improved button styles */
        .btn-block {
            width: 100%;
        }
        
        /* Modal backdrop fix */
        .modal-backdrop {
            background-color: rgba(0,0,0,0.5);
        }
    </style>
@endsection

@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                
                <!-- Modern Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body modern-gradient text-white p-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white bg-opacity-20 rounded-circle p-3 mr-3">
                                        <i class="fas fa-users-cog fa-2x"></i>
                                    </div>
                                    <div>
                                        <h2 class="font-weight-bold mb-1 text-white">Yöneticiler Paneli</h2>
                                        <p class="mb-0 text-white-50">Sistem yöneticilerini yönetin ve kontrol edin</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <!-- Admin Cards Grid -->
                <div class="row">
                    @foreach ($admins as $admin)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card admin-card border-0 shadow h-100">
                            <!-- Card Header -->
                            <div class="card-header modern-gradient text-white border-0 p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white bg-opacity-20 rounded-circle p-2 mr-3">
                                            <i class="fas fa-user-shield"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0 text-white font-weight-bold">{{ $admin->firstName }} {{ $admin->lastName }}</h5>
                                            <small class="text-white-50">ID: #{{ $admin->id }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        @if ($admin->acnt_type_active == null || $admin->acnt_type_active == 'blocked')
                                            <span class="badge badge-danger status-badge">Engelli</span>
                                        @else
                                            <span class="badge badge-success status-badge">Aktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-envelope text-primary mr-2" style="width: 20px;"></i>
                                        <span class="text-dark">{{ $admin->email }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-phone text-success mr-2" style="width: 20px;"></i>
                                        <span class="text-dark">{{ $admin->phone ?: 'Telefon yok' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-tag text-purple mr-2" style="width: 20px;"></i>
                                        <span class="badge badge-purple">{{ $admin->type }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer - Action Buttons -->
                            <div class="card-footer bg-light border-0 p-3">
                                <div class="row mb-2">
                                    @if ($admin->acnt_type_active == null || $admin->acnt_type_active == 'blocked')
                                        <div class="col-6">
                                            <a href="{{ url('admin/dashboard/unblock') }}/{{ $admin->id }}"
                                               class="btn btn-success btn-sm action-btn btn-block">
                                                <i class="fas fa-unlock mr-1"></i>Engeli Kaldır
                                            </a>
                                        </div>
                                    @else
                                        <div class="col-6">
                                            <a href="{{ url('admin/dashboard/ublock') }}/{{ $admin->id }}"
                                               class="btn btn-danger btn-sm action-btn btn-block">
                                                <i class="fas fa-lock mr-1"></i>Engelle
                                            </a>
                                        </div>
                                    @endif
                                    <div class="col-6">
                                        <button onclick="openModal('editModal{{ $admin->id }}')"
                                                class="btn btn-primary btn-sm action-btn btn-block">
                                            <i class="fas fa-edit mr-1"></i>Düzenle
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <button onclick="openModal('resetModal{{ $admin->id }}')"
                                                class="btn btn-warning btn-sm action-btn btn-block" title="Şifre Sıfırla">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button onclick="openModal('deleteModal{{ $admin->id }}')"
                                                class="btn btn-danger btn-sm action-btn btn-block" title="Sil">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button onclick="openModal('emailModal{{ $admin->id }}')"
                                                class="btn btn-info btn-sm action-btn btn-block" title="E-posta Gönder">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Bootstrap Modals -->
        @foreach ($admins as $admin)
            <!-- Reset Password Modal -->
            <div class="modal fade" id="resetModal{{ $admin->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-modern">
                        <div class="modal-header modal-header-modern text-white">
                            <div class="d-flex align-items-center">
                                <div class="bg-white bg-opacity-20 rounded-circle p-2 mr-3">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div>
                                    <h5 class="modal-title mb-0 font-weight-bold">Şifre Sıfırlama</h5>
                                    <small class="text-white-50">{{ $admin->firstName }} {{ $admin->lastName }}</small>
                                </div>
                            </div>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Dikkat!</strong> Şifre varsayılan değere sıfırlanacak.
                            </div>
                            <div class="bg-light rounded p-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning rounded-circle p-2 mr-3">
                                        <i class="fas fa-lock text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 font-weight-bold">Yeni Şifre</h6>
                                        <p class="mb-0 text-muted">admin01236</p>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-4">{{ $admin->firstName }} için şifreyi sıfırlamak istediğinizden emin misiniz?</p>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ url('admin/dashboard/resetadpwd') }}/{{ $admin->id }}"
                               class="btn btn-warning btn-modern">
                                <i class="fas fa-key mr-2"></i>Evet, Sıfırla
                            </a>
                            <button type="button" class="btn btn-secondary btn-modern" data-dismiss="modal">
                                İptal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal{{ $admin->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-modern">
                        <div class="modal-header bg-danger text-white">
                            <div class="d-flex align-items-center">
                                <div class="bg-white bg-opacity-20 rounded-circle p-2 mr-3">
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                                <h5 class="modal-title mb-0 font-weight-bold">Yöneticiyi Sil</h5>
                            </div>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <p class="mb-4">{{ $admin->firstName }} {{ $admin->lastName }} kullanıcısını silmek istediğinizden emin misiniz?</p>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ url('admin/dashboard/deleletadmin') }}/{{ $admin->id }}"
                               class="btn btn-danger btn-modern">
                                <i class="fas fa-trash mr-2"></i>Evet, Sil
                            </a>
                            <button type="button" class="btn btn-secondary btn-modern" data-dismiss="modal">
                                İptal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $admin->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content modal-modern">
                        <div class="modal-header bg-primary text-white">
                            <div class="d-flex align-items-center">
                                <div class="bg-white bg-opacity-20 rounded-circle p-2 mr-3">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <h5 class="modal-title mb-0 font-weight-bold">Kullanıcı Düzenle</h5>
                            </div>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <form method="post" action="{{ route('editadmin') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $admin->id }}">
                                
                                <div class="form-group">
                                    <label class="font-weight-bold">Ad</label>
                                    <input type="text" name="fname" value="{{ $admin->firstName }}" required
                                           class="form-control form-control-modern">
                                </div>
                                
                                <div class="form-group">
                                    <label class="font-weight-bold">Soyad</label>
                                    <input type="text" name="l_name" value="{{ $admin->lastName }}" required
                                           class="form-control form-control-modern">
                                </div>
                                
                                <div class="form-group">
                                    <label class="font-weight-bold">E-posta</label>
                                    <input type="email" name="email" value="{{ $admin->email }}" required
                                           class="form-control form-control-modern">
                                </div>
                                
                                <div class="form-group">
                                    <label class="font-weight-bold">Telefon</label>
                                    <input type="text" name="phone" value="{{ $admin->phone }}" required
                                           class="form-control form-control-modern">
                                </div>
                                
                                <div class="form-group">
                                    <label class="font-weight-bold">Tür</label>
                                    <select name="type" class="form-control form-control-modern">
                                        <option value="{{ $admin->type }}">{{ $admin->type }}</option>
                                        <option value="Süper Yönetici">Süper Yönetici</option>
                                        <option value="Yönetici">Yönetici</option>
                                        <option value="Dönüşüm Aracısı">Dönüşüm Aracısı</option>
                                    </select>
                                </div>
                                
                                <div class="modal-footer px-0 pb-0">
                                    <button type="submit" class="btn btn-primary btn-modern">
                                        <i class="fas fa-save mr-2"></i>Güncelle
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-modern" data-dismiss="modal">
                                        İptal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Modal -->
            <div class="modal fade" id="emailModal{{ $admin->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content modal-modern">
                        <div class="modal-header bg-info text-white">
                            <div class="d-flex align-items-center">
                                <div class="bg-white bg-opacity-20 rounded-circle p-2 mr-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h5 class="modal-title mb-0 font-weight-bold">E-posta Gönder</h5>
                            </div>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <p class="mb-4">{{ $admin->firstName }} {{ $admin->lastName }} kullanıcısına mesaj gönderilecek.</p>
                            <form method="post" action="{{ route('sendmailtoadmin') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $admin->id }}">
                                
                                <div class="form-group">
                                    <label class="font-weight-bold">Konu</label>
                                    <input type="text" name="subject" placeholder="E-posta konusu girin"
                                           class="form-control form-control-modern">
                                </div>
                                
                                <div class="form-group">
                                    <label class="font-weight-bold">Mesaj</label>
                                    <textarea name="message" rows="4" placeholder="Mesajınızı buraya yazın" required
                                              class="form-control form-control-modern"></textarea>
                                </div>
                                
                                <div class="modal-footer px-0 pb-0">
                                    <button type="submit" class="btn btn-info btn-modern">
                                        <i class="fas fa-paper-plane mr-2"></i>Gönder
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-modern" data-dismiss="modal">
                                        İptal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <script>
            // Bootstrap Modal functions
            function openModal(modalId) {
                try {
                    $('#' + modalId).modal('show');
                } catch (e) {
                    // Fallback for when jQuery is not available
                    console.warn('jQuery not available, using fallback modal system');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.add('show');
                        modal.style.display = 'block';
                        document.body.classList.add('modal-open');
                    }
                }
            }

            function closeModal(modalId) {
                try {
                    $('#' + modalId).modal('hide');
                } catch (e) {
                    // Fallback for when jQuery is not available
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('show');
                        modal.style.display = 'none';
                        document.body.classList.remove('modal-open');
                    }
                }
            }

            // Wait for DOM to be ready
            $(document).ready(function() {
                // Add loading states to action buttons
                $('a[href*="/admin/dashboard/"]').click(function() {
                    const $icon = $(this).find('i');
                    if ($icon.length && !$icon.hasClass('fa-spinner')) {
                        const originalClass = $icon.attr('class');
                        $icon.attr('class', 'fas fa-spinner fa-spin');
                        
                        // Restore original icon after 3 seconds if page hasn't changed
                        setTimeout(() => {
                            if ($icon.length) {
                                $icon.attr('class', originalClass);
                            }
                        }, 3000);
                    }
                });

                // Add hover effects to cards
                $('.admin-card').hover(
                    function() {
                        $(this).addClass('shadow-lg').css('transform', 'translateY(-5px)');
                    },
                    function() {
                        $(this).removeClass('shadow-lg').css('transform', 'translateY(0)');
                    }
                );

                console.log('Admin panel loaded successfully');
            });

            // Fallback for when jQuery is not available
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof jQuery === 'undefined') {
                    console.warn('jQuery not available, using vanilla JavaScript fallbacks');
                    
                    // Add loading states to action buttons
                    const actionButtons = document.querySelectorAll('a[href*="/admin/dashboard/"]');
                    actionButtons.forEach(button => {
                        if (button) {
                            button.addEventListener('click', function() {
                                const icon = this.querySelector('i');
                                if (icon && !icon.classList.contains('fa-spinner')) {
                                    const originalClass = icon.className;
                                    icon.className = 'fas fa-spinner fa-spin';
                                    
                                    setTimeout(() => {
                                        if (icon) {
                                            icon.className = originalClass;
                                        }
                                    }, 3000);
                                }
                            });
                        }
                    });

                    // Add hover effects to cards
                    const cards = document.querySelectorAll('.admin-card');
                    cards.forEach(card => {
                        card.addEventListener('mouseenter', function() {
                            this.classList.add('shadow-lg');
                            this.style.transform = 'translateY(-5px)';
                        });
                        card.addEventListener('mouseleave', function() {
                            this.classList.remove('shadow-lg');
                            this.style.transform = 'translateY(0)';
                        });
                    });
                }
            });

            // Error handling for missing dependencies
            window.addEventListener('error', function(e) {
                if (e.message.includes('$ is not defined') ||
                    e.message.includes('jQuery') ||
                    e.message.includes('livewire')) {
                    console.warn('Some external dependencies are missing, but core functionality should work');
                }
            });
        </script>
    @endsection
