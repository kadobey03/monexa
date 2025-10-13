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
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --info-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    /* Dark mode variables */
    :root.dark {
        --text-color: #f8fafc;
        --bg-color: #1e293b;
        --card-bg: #334155;
        --border-color: #475569;
    }

    .kyc-header {
        background: var(--primary-gradient);
        border-radius: 12px;
        color: white;
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-verified {
        background: var(--success-gradient);
        color: white;
    }

    .status-pending {
        background: var(--warning-gradient);
        color: white;
    }

    .status-rejected {
        background: var(--danger-gradient);
        color: white;
    }

    .info-card {
        background: #f8fafc;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
        border-left: 4px solid #e2e8f0;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Dark mode styles */
    :root.dark .info-card {
        background: var(--card-bg);
        border-left-color: var(--border-color);
    }

    :root.dark .info-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .info-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .document-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }

    .document-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .document-image {
        max-height: 200px;
        width: 100%;
        object-fit: contain;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
    }

    .modal-header-custom {
        background: var(--primary-gradient);
        color: white;
    }

    .status-option {
        cursor: pointer;
        transition: all 0.2s ease;
        border-radius: 8px;
    }

    .status-option:hover {
        transform: translateY(-2px);
    }

    .section-title {
        background: var(--info-gradient);
        color: white;
        padding: 1rem 1.5rem;
        margin: 0 -1.5rem 1.5rem -1.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 8px 8px 0 0;
    }

    @media (max-width: 768px) {
        .info-card {
            padding: 1rem;
        }
        .document-image {
            max-height: 150px;
        }
        .user-avatar {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
        .section-title {
            font-size: 1rem;
            padding: 0.75rem 1rem;
        }
    }

    /* Genel görünüm düzeltmeleri */
    .main-panel {
        background: transparent;
    }

    .content {
        background: transparent;
    }

    .page-inner {
        padding: 1.5rem;
    }

    /* Dark mode için genel düzeltmeler */
    :root.dark .main-panel {
        background: var(--bg-color);
    }

    :root.dark .page-inner {
        background: transparent;
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

                <!-- Header Section -->
                <div class="kyc-header p-4 mb-4">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-3">
                                {{ strtoupper(substr($kyc->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h1 class="mb-1 h3">{{ $kyc->user->name }} - KYC Application</h1>
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <span class="status-badge
                                        @if($kyc->status == 'Verified') status-verified
                                        @elseif($kyc->status == 'Pending') status-pending
                                        @else status-rejected
                                        @endif">
                                        <i class="fas
                                            @if($kyc->status == 'Verified') fa-check-circle
                                            @elseif($kyc->status == 'Pending') fa-clock
                                            @else fa-times-circle
                                            @endif"></i>
                                        @if($kyc->status == 'Verified') Verified
                                        @elseif($kyc->status == 'Pending') Under Review
                                        @else Rejected
                                        @endif
                                    </span>
                                    <small class="text-white-50">
                                        <i class="fas fa-calendar me-1"></i>Submitted: {{ $kyc->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-light btn-lg px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#actionModal">
                            <i class="fas fa-cogs me-2"></i>Take Action
                        </button>
                    </div>
                </div>
                <!-- Action Modal -->
                <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header modal-header-custom">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-shield fa-2x me-3"></i>
                                    <div>
                                        <h5 class="modal-title text-white" id="actionModalLabel">KYC Application Review</h5>
                                        <small class="text-white-50">Review and take action on {{ $kyc->user->name }}'s application</small>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form action="{{ route('processkyc') }}" method="post">
                                    @csrf

                                    <!-- Action Selection -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="status-option bg-light-success text-center p-4 rounded-lg border h-100" role="button" onclick="selectAction('Accept')">
                                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                                <h6 class="text-success mb-2">Approve</h6>
                                                <small class="text-muted">Verify and approve the user</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="status-option bg-light-danger text-center p-4 rounded-lg border h-100" role="button" onclick="selectAction('Reject')">
                                                <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                                                <h6 class="text-danger mb-2">Reject</h6>
                                                <small class="text-muted">Reject and keep unverified</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-tasks me-2"></i>Selected Action
                                        </label>
                                        <select name="action" id="kycAction" class="form-select form-select-lg" required>
                                            <option value="">Choose an action...</option>
                                            <option value="Accept">✅ Approve and Verify User</option>
                                            <option value="Reject">❌ Reject Application</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-envelope me-2"></i>Email Message
                                        </label>
                                        <textarea name="message" class="form-control"
                                            rows="4" required placeholder="Enter message to send to user...">Thank you for your KYC application. After reviewing your submitted documents, your account has been successfully verified. You can now access all platform features without restrictions. Congratulations!!</textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-heading me-2"></i>Email Subject
                                        </label>
                                        <input type="text" name="subject" class="form-control form-control-lg"
                                            placeholder="Email subject" value="KYC Application Update" required>
                                    </div>

                                    <input type="hidden" name="kyc_id" value="{{ $kyc->id }}">

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                            <i class="fas fa-paper-plane me-2"></i>Confirm and Send
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-2"></i>Cancel
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
                <!-- Personal Information Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="section-title d-flex align-items-center">
                                <i class="fas fa-user-circle me-3"></i>Personal Information
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="info-card">
                                            <div class="d-flex align-items-center">
                                                <div class="info-icon bg-primary">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">{{ $kyc->first_name }}</h6>
                                                    <small class="text-muted">First Name</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="info-card">
                                            <div class="d-flex align-items-center">
                                                <div class="info-icon bg-info">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">{{ $kyc->last_name }}</h6>
                                                    <small class="text-muted">Last Name</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="info-card">
                                            <div class="d-flex align-items-center">
                                                <div class="info-icon bg-success">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">{{ $kyc->email }}</h6>
                                                    <small class="text-muted">Email Address</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="info-card">
                                            <div class="d-flex align-items-center">
                                                <div class="info-icon bg-warning">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">{{ $kyc->phone_number }}</h6>
                                                    <small class="text-muted">Phone Number</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="info-card">
                                            <div class="d-flex align-items-center">
                                                <div class="info-icon bg-danger">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">{{ $kyc->dob }}</h6>
                                                    <small class="text-muted">Date of Birth</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="info-card">
                                            <div class="d-flex align-items-center">
                                                <div class="info-icon bg-secondary">
                                                    <i class="fab fa-instagram"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">{{ $kyc->social_media }}</h6>
                                                    <small class="text-muted">Social Media Username</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="section-title d-flex align-items-center">
                                <i class="fas fa-map-marker-alt me-3"></i>Address Information
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="info-card">
                                            <div class="d-flex align-items-center">
                                                <div class="info-icon bg-primary">
                                                    <i class="fas fa-home"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">{{ $kyc->address }}</h6>
                                                    <small class="text-muted">Address Line</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="info-card">
                                            <div class="d-flex align-items-center">
                                                <div class="info-icon bg-info">
                                                    <i class="fas fa-city"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">{{ $kyc->city }}</h6>
                                                    <small class="text-muted">City</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="info-card">
                                            <div class="d-flex align-items-center">
                                                <div class="info-icon bg-warning">
                                                    <i class="fas fa-map"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">{{ $kyc->state }}</h6>
                                                    <small class="text-muted">State</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="info-card">
                                            <div class="d-flex align-items-center">
                                                <div class="info-icon bg-success">
                                                    <i class="fas fa-flag"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">{{ $kyc->country }}</h6>
                                                    <small class="text-muted">Country</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Information Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="section-title d-flex align-items-center">
                                <i class="fas fa-id-card me-3"></i>Document Information
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="info-card">
                                            <div class="d-flex align-items-center">
                                                <div class="info-icon bg-warning">
                                                    <i class="fas fa-file-alt"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">{{ $kyc->document_type }}</h6>
                                                    <small class="text-muted">Document Type</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Images Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="section-title d-flex align-items-center">
                                <i class="fas fa-images me-3"></i>Document Images
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="document-card">
                                            <div class="document-header bg-primary text-white p-3">
                                                <i class="fas fa-address-card fa-2x mb-2"></i>
                                                <h6 class="mb-0">Front Side</h6>
                                            </div>
                                            <div class="document-body p-3 text-center">
                                                @if($kyc->frontimg)
                                                    <img src="{{ asset('storage/app/public/' . $kyc->frontimg) }}"
                                                         alt="Document Front Side"
                                                         class="document-image"
                                                         onerror="this.src='/themes/dashly/assets/images/no-image.png'; this.alt='Image not available';">
                                                @else
                                                    <img src="/themes/dashly/assets/images/no-image.png"
                                                         alt="No image available"
                                                         class="document-image">
                                                @endif
                                                <small class="text-muted d-block mt-2">Document Front View</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="document-card">
                                            <div class="document-header bg-info text-white p-3">
                                                <i class="fas fa-address-card fa-2x mb-2"></i>
                                                <h6 class="mb-0">Back Side</h6>
                                            </div>
                                            <div class="document-body p-3 text-center">
                                                @if($kyc->backimg)
                                                    <img src="{{ asset('storage/app/public/' . $kyc->backimg) }}"
                                                         alt="Document Back Side"
                                                         class="document-image"
                                                         onerror="this.src='/themes/dashly/assets/images/no-image.png'; this.alt='Image not available';">
                                                @else
                                                    <img src="/themes/dashly/assets/images/no-image.png"
                                                         alt="No image available"
                                                         class="document-image">
                                                @endif
                                                <small class="text-muted d-block mt-2">Document Back View</small>
                                            </div>
                                        </div>
                                    </div>
            </div>
        </div>
    </div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal action selection - jQuery ile daha uyumlu
    window.selectAction = function(action) {
        $('#kycAction').val(action);
    };

    // Bootstrap modal event listeners - jQuery ile
    $(document).on('show.bs.modal', '#actionModal', function() {
        // Modal açıldığında yapılacak işlemler
    });

    $(document).on('hidden.bs.modal', '#actionModal', function() {
        // Modal kapatıldığında yapılacak işlemler
    });

    // Image error handling - daha güvenli yöntem
    document.querySelectorAll('.document-image').forEach(img => {
        if (img.complete) {
            if (img.naturalWidth === 0) {
                img.src = '/themes/dashly/assets/images/no-image.png';
                img.alt = 'Image not available';
            }
        } else {
            img.addEventListener('load', function() {
                if (this.naturalWidth === 0) {
                    this.src = '/themes/dashly/assets/images/no-image.png';
                    this.alt = 'Image not available';
                }
            });

            img.addEventListener('error', function() {
                this.src = '/themes/dashly/assets/images/no-image.png';
                this.alt = 'Image not available';
            });
        }
    });

    // Smooth scrolling for better UX
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Auto-resize textareas
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
});
</script>
@endsection
@endsection
