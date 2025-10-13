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
    .kyc-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        border-radius: 12px;
    }
    .kyc-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .status-verified {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    .status-pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    .status-rejected {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.1rem;
    }
    .search-box {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        transition: border-color 0.2s ease;
    }
    .search-box:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .filter-btn {
        border: 2px solid #e5e7eb;
        background: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .filter-btn:hover, .filter-btn.active {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }
</style>
@endsection
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="mb-2" style="color: var(--text-color); font-size: 1.8rem; font-weight: 600;">
                            KYC Applications
                        </h1>
                        <p class="text-muted mb-0">Manage and review user identity verification applications</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn filter-btn active" data-status="all">
                            <i class="fas fa-list me-2"></i>All
                        </button>
                        <button class="btn filter-btn" data-status="Verified">
                            <i class="fas fa-check-circle me-2"></i>Verified
                        </button>
                        <button class="btn filter-btn" data-status="Pending">
                            <i class="fas fa-clock me-2"></i>Pending
                        </button>
                        <button class="btn filter-btn" data-status="Rejected">
                            <i class="fas fa-times-circle me-2"></i>Rejected
                        </button>
                    </div>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <!-- Search and Filter Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-search text-muted me-3"></i>
                                <input type="text" id="searchInput" class="form-control search-box"
                                       placeholder="Search by user name, email, or phone...">
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                Total Applications: <span id="totalCount">{{ $kycs->count() }}</span>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Applications Grid -->
                <div class="row" id="kycContainer">
                    @foreach ($kycs as $kyc)
                        <div class="col-xl-4 col-lg-6 col-md-6 kyc-item" data-status="{{ $kyc->status }}">
                            <div class="card kyc-card shadow-sm">
                                <div class="card-body p-4">
                                    <!-- Header with User Info -->
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                {{ strtoupper(substr($kyc->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-dark dark:text-white font-weight-bold">
                                                    {{ $kyc->user->name }}
                                                </h6>
                                                <small class="text-muted">{{ $kyc->user->email }}</small>
                                            </div>
                                        </div>
                                        <span class="status-badge
                                            @if($kyc->status == 'Verified') status-verified
                                            @elseif($kyc->status == 'Pending') status-pending
                                            @else status-rejected
                                            @endif">
                                            <i class="fas
                                                @if($kyc->status == 'Verified') fa-check-circle
                                                @elseif($kyc->status == 'Pending') fa-clock
                                                @else fa-times-circle
                                                @endif me-1"></i>
                                            {{ $kyc->status }}
                                        </span>
                                    </div>

                                    <!-- Application Details -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">Phone Number</small>
                                            <span class="text-dark dark:text-white">{{ $kyc->phone_number }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">Document Type</small>
                                            <span class="text-dark dark:text-white">{{ $kyc->document_type }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Submitted</small>
                                            <span class="text-dark dark:text-white">{{ $kyc->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('viewkyc', $kyc->id) }}"
                                       class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-eye me-2"></i>Review Application
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="text-center py-5" style="display: none;">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No applications found</h4>
                    <p class="text-muted">No KYC applications match your current filters.</p>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const kycItems = document.querySelectorAll('.kyc-item');
    const totalCount = document.getElementById('totalCount');
    const emptyState = document.getElementById('emptyState');

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;

        kycItems.forEach(item => {
            const userName = item.querySelector('h6').textContent.toLowerCase();
            const userEmail = item.querySelector('small').textContent.toLowerCase();
            const phoneNumber = item.querySelector('.text-dark').textContent.toLowerCase();

            if (userName.includes(searchTerm) || userEmail.includes(searchTerm) || phoneNumber.includes(searchTerm)) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        updateDisplay(visibleCount);
    });

    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.getAttribute('data-status');

            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            let visibleCount = 0;

            kycItems.forEach(item => {
                const itemStatus = item.getAttribute('data-status');

                if (status === 'all' || itemStatus === status) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            updateDisplay(visibleCount);
        });
    });

    function updateDisplay(count) {
        totalCount.textContent = count;
        emptyState.style.display = count === 0 ? 'block' : 'none';
    }
});
</script>
@endsection
@endsection
