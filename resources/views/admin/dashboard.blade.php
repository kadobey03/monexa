<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $bg = 'light';
    $text = 'dark';
    $gradient = 'primary';
} else {
    $bg = 'dark';
    $text = 'light';
    $gradient = 'dark';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <!-- Modern Header Section -->
            <div class="panel-header hero-gradient">
                <div class="py-5 page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                        <div class="flex-grow-1">
                            <div class="welcome-badge mb-3">
                                <span class="badge bg-white bg-opacity-20 text-white px-3 py-2">
                                    <i class="fas fa-user-shield me-2"></i>Admin Dashboard
                                </span>
                            </div>
                            <h1 class="display-4 text-white fw-bold mb-2">
                                <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                            </h1>
                            <h4 class="text-white op-8 mb-3">
                                Welcome back, {{ Auth('admin')->User()->firstName }} {{ Auth('admin')->User()->lastName }}!
                            </h4>
                            <div class="d-flex align-items-center text-white op-7">
                                <div class="date-time-display">
                                    <i class="far fa-calendar-alt me-2"></i>{{ date('l, F j, Y') }}
                                    <span class="mx-2">•</span>
                                    <i class="far fa-clock me-2"></i><span id="current-time"></span>
                                </div>
                            </div>
                        </div>
                        @if (Auth('admin')->User()->type == 'Super Admin' || Auth('admin')->User()->type == 'Admin')
                            <div class="py-2 ml-md-auto py-md-0">
                                <div class="btn-group-vertical btn-group-lg" role="group">
                                    <a href="{{ route('mdeposits') }}" class="btn btn-success mb-2 modern-btn shadow-sm">
                                        <i class="fas fa-arrow-down me-2"></i>Deposits
                                    </a>
                                    <a href="{{ route('mwithdrawals') }}" class="btn btn-danger mb-2 modern-btn shadow-sm">
                                        <i class="fas fa-arrow-up me-2"></i>Withdrawals
                                    </a>
                                    <a href="{{ route('manageusers') }}" class="btn btn-info modern-btn shadow-sm">
                                        <i class="fas fa-users me-2"></i>Users
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <x-danger-alert />
            <x-success-alert />

            <div class="page-inner mt--5">
                <!-- Enhanced Statistics Cards -->
                <div class="row g-4 mb-5">
                    <!-- Total Deposit Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card premium-card deposit-card border-0 h-100">
                            <div class="card-body p-4">
                                <div class="stat-wrapper">
                                    <div class="stat-icon-wrapper">
                                        <div class="stat-icon bg-gradient-success">
                                            <i class="fas fa-wallet fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-header">
                                            <span class="stat-label">Total Deposits</span>
                                            <div class="stat-badge">
                                                <i class="fas fa-arrow-up text-success"></i>
                                            </div>
                                        </div>
                                        <div class="stat-value">
                                            @foreach ($total_deposited as $deposited)
                                                @if (!empty($deposited->count))
                                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                                @else
                                                    {{ $settings->currency }}0.00
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="stat-footer">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>All time total
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Deposits Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card premium-card pending-card border-0 h-100">
                            <div class="card-body p-4">
                                <div class="stat-wrapper">
                                    <div class="stat-icon-wrapper">
                                        <div class="stat-icon bg-gradient-warning">
                                            <i class="fas fa-hourglass-half fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-header">
                                            <span class="stat-label">Pending Deposits</span>
                                            <div class="stat-badge">
                                                <i class="fas fa-clock text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="stat-value">
                                            @foreach ($pending_deposited as $deposited)
                                                @if (!empty($deposited->count))
                                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                                @else
                                                    {{ $settings->currency }}0.00
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="stat-footer">
                                            <small class="text-muted">
                                                <i class="fas fa-exclamation-circle me-1"></i>Awaiting approval
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Withdrawals Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card premium-card withdrawal-card border-0 h-100">
                            <div class="card-body p-4">
                                <div class="stat-wrapper">
                                    <div class="stat-icon-wrapper">
                                        <div class="stat-icon bg-gradient-danger">
                                            <i class="fas fa-credit-card fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-header">
                                            <span class="stat-label">Total Withdrawals</span>
                                            <div class="stat-badge">
                                                <i class="fas fa-arrow-down text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="stat-value">
                                            @foreach ($total_withdrawn as $deposited)
                                                @if (!empty($deposited->count))
                                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                                @else
                                                    {{ $settings->currency }}0.00
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="stat-footer">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>All time total
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Withdrawals Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card premium-card processing-card border-0 h-100">
                            <div class="card-body p-4">
                                <div class="stat-wrapper">
                                    <div class="stat-icon-wrapper">
                                        <div class="stat-icon bg-gradient-info">
                                            <i class="fas fa-pause-circle fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-header">
                                            <span class="stat-label">Pending Withdrawals</span>
                                            <div class="stat-badge">
                                                <i class="fas fa-cog text-info"></i>
                                            </div>
                                        </div>
                                        <div class="stat-value">
                                            @foreach ($pending_withdrawn as $deposited)
                                                @if (!empty($deposited->count))
                                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                                @else
                                                    {{ $settings->currency }}0.00
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="stat-footer">
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>Processing
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Statistics Section -->
                <div class="row g-4 mb-5">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card premium-card users-card border-0 h-100">
                            <div class="card-body p-4">
                                <div class="stat-wrapper">
                                    <div class="stat-icon-wrapper">
                                        <div class="stat-icon bg-gradient-primary">
                                            <i class="fas fa-users fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-header">
                                            <span class="stat-label">Total Users</span>
                                            <div class="stat-badge">
                                                <i class="fas fa-user-plus text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="stat-value">{{ number_format($user_count) }}</div>
                                        <div class="stat-footer">
                                            <small class="text-muted">
                                                <i class="fas fa-chart-line me-1"></i>Total registered
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card premium-card active-card border-0 h-100">
                            <div class="card-body p-4">
                                <div class="stat-wrapper">
                                    <div class="stat-icon-wrapper">
                                        <div class="stat-icon bg-gradient-success">
                                            <i class="fas fa-user-check fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-header">
                                            <span class="stat-label">Active Users</span>
                                            <div class="stat-badge">
                                                <i class="fas fa-circle text-success"></i>
                                            </div>
                                        </div>
                                        <div class="stat-value">{{ $activeusers }}</div>
                                        <div class="stat-footer">
                                            <small class="text-muted">
                                                <i class="fas fa-bolt me-1"></i>Currently online
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card premium-card blocked-card border-0 h-100">
                            <div class="card-body p-4">
                                <div class="stat-wrapper">
                                    <div class="stat-icon-wrapper">
                                        <div class="stat-icon bg-gradient-danger">
                                            <i class="fas fa-user-times fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-header">
                                            <span class="stat-label">Blocked Users</span>
                                            <div class="stat-badge">
                                                <i class="fas fa-ban text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="stat-value">{{ $blockeusers }}</div>
                                        <div class="stat-footer">
                                            <small class="text-muted">
                                                <i class="fas fa-shield-alt me-1"></i>Suspended accounts
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card premium-card plans-card border-0 h-100">
                            <div class="card-body p-4">
                                <div class="stat-wrapper">
                                    <div class="stat-icon-wrapper">
                                        <div class="stat-icon bg-gradient-warning">
                                            <i class="fas fa-layer-group fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-header">
                                            <span class="stat-label">Investment Plans</span>
                                            <div class="stat-badge">
                                                <i class="fas fa-chart-line text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="stat-value">{{ $plans }}</div>
                                        <div class="stat-footer">
                                            <small class="text-muted">
                                                <i class="fas fa-boxes me-1"></i>Available plans
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Chart Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card analytics-card border-0">
                            <div class="card-header premium-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="chart-header-info">
                                        <div class="chart-title">
                                            <h4 class="fw-bold mb-1">
                                                <i class="fas fa-chart-line me-2 gradient-text"></i>System Analytics
                                            </h4>
                                            <p class="text-muted mb-0">Financial overview and transaction analytics</p>
                                        </div>
                                    </div>
                                    <div class="chart-controls">
                                        <div class="btn-group chart-period-selector" role="group">
                                            <input type="radio" class="btn-check" name="chartPeriod" id="today" autocomplete="off">
                                            <label class="btn btn-outline-primary btn-sm" for="today">Today</label>

                                            <input type="radio" class="btn-check" name="chartPeriod" id="week" autocomplete="off">
                                            <label class="btn btn-outline-primary btn-sm" for="week">This Week</label>

                                            <input type="radio" class="btn-check" name="chartPeriod" id="month" autocomplete="off" checked>
                                            <label class="btn btn-primary btn-sm" for="month">This Month</label>

                                            <input type="radio" class="btn-check" name="chartPeriod" id="year" autocomplete="off">
                                            <label class="btn btn-outline-primary btn-sm" for="year">This Year</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="chart-wrapper">
                                    <div class="chart-container position-relative">
                                        <canvas id="myChart" height="120"></canvas>
                                    </div>
                                    <div class="chart-overlay-info">
                                        <div class="row text-center">
                                            <div class="col-md-3">
                                                <div class="chart-info-item">
                                                    <span class="chart-info-value">{{ $settings->currency }}{{ number_format($chart_pdepsoit) }}</span>
                                                    <span class="chart-info-label">Total Deposits</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="chart-info-item">
                                                    <span class="chart-info-value">{{ $settings->currency }}{{ number_format($chart_pwithdraw) }}</span>
                                                    <span class="chart-info-label">Total Withdrawals</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="chart-info-item">
                                                    <span class="chart-info-value">{{ $settings->currency }}{{ number_format($chart_pendepsoit) }}</span>
                                                    <span class="chart-info-label">Pending Deposits</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="chart-info-item">
                                                    <span class="chart-info-value">{{ $settings->currency }}{{ number_format($chart_trans) }}</span>
                                                    <span class="chart-info-label">Transactions</span>
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

    <!-- Enhanced Chart Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Real-time clock with enhanced formatting
            function updateTime() {
                const now = new Date();
                const timeOptions = {
                    hour12: true,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                };
                const timeString = now.toLocaleTimeString('en-US', timeOptions);
                const timeElement = document.getElementById('current-time');

                if (timeElement) {
                    timeElement.textContent = timeString;
                    timeElement.style.color = `hsl(${now.getSeconds() * 6}, 70%, 60%)`;
                }
            }

            updateTime();
            setInterval(updateTime, 1000);

            // Chart period selector functionality
            const periodButtons = document.querySelectorAll('input[name="chartPeriod"]');
            periodButtons.forEach(button => {
                button.addEventListener('change', function() {
                    // Add loading animation
                    const chartContainer = document.getElementById('myChart');
                    chartContainer.style.opacity = '0.5';

                    // Simulate API call delay
                    setTimeout(() => {
                        chartContainer.style.opacity = '1';
                        // Here you would typically fetch new data based on selected period
                    }, 300);
                });
            });

            // Enhanced Chart with modern styling
            const ctx = document.getElementById('myChart')?.getContext('2d');
            if (ctx) {
                // Chart data with enhanced styling
                const chartData = [
                    "{{ $chart_pdepsoit }}",
                    "{{ $chart_pendepsoit }}",
                    "{{ $chart_pwithdraw }}",
                    "{{ $chart_pendwithdraw }}",
                    "{{ $chart_trans }}"
                ];

                // Create gradient backgrounds
                const createGradient = (ctx, color1, color2) => {
                    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, color1);
                    gradient.addColorStop(1, color2);
                    return gradient;
                };

                const gradients = [
                    createGradient(ctx, 'rgba(40, 167, 69, 0.9)', 'rgba(40, 167, 69, 0.7)'),
                    createGradient(ctx, 'rgba(255, 193, 7, 0.9)', 'rgba(255, 193, 7, 0.7)'),
                    createGradient(ctx, 'rgba(220, 53, 69, 0.9)', 'rgba(220, 53, 69, 0.7)'),
                    createGradient(ctx, 'rgba(23, 162, 184, 0.9)', 'rgba(23, 162, 184, 0.7)'),
                    createGradient(ctx, 'rgba(108, 117, 125, 0.9)', 'rgba(108, 117, 125, 0.7)')
                ];

                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Total Deposits', 'Pending Deposits', 'Total Withdrawals', 'Pending Withdrawals', 'Total Transactions'],
                        datasets: [{
                            label: `Amount in {{ $settings->currency }}`,
                            data: chartData,
                            backgroundColor: gradients,
                            borderColor: [
                                'rgba(40, 167, 69, 1)',
                                'rgba(255, 193, 7, 1)',
                                'rgba(220, 53, 69, 1)',
                                'rgba(23, 162, 184, 1)',
                                'rgba(108, 117, 125, 1)'
                            ],
                            borderWidth: 0,
                            borderRadius: 12,
                            borderSkipped: false,
                            hoverBorderRadius: 8,
                            hoverBorderWidth: 3,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(255, 255, 255, 0.2)',
                                borderWidth: 1,
                                cornerRadius: 12,
                                displayColors: true,
                                padding: 12,
                                titleFont: {
                                    size: 14,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: function(context) {
                                        const value = new Intl.NumberFormat().format(context.parsed.y);
                                        return `Amount: {{ $settings->currency }}${value}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.03)',
                                    drawBorder: false,
                                    lineWidth: 1
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        family: "'Inter', sans-serif"
                                    },
                                    color: '#6c757d',
                                    padding: 10,
                                    callback: function(value) {
                                        if (value >= 1000000) {
                                            return '{{ $settings->currency }}' + (value / 1000000).toFixed(1) + 'M';
                                        } else if (value >= 1000) {
                                            return '{{ $settings->currency }}' + (value / 1000).toFixed(1) + 'K';
                                        }
                                        return '{{ $settings->currency }}' + new Intl.NumberFormat().format(value);
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        weight: '600',
                                        family: "'Inter', sans-serif"
                                    },
                                    color: '#495057',
                                    padding: 15
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart',
                            onComplete: function() {
                                // Add pulse animation to high-value bars
                                chartData.forEach((value, index) => {
                                    if (parseFloat(value) > 10000) {
                                        const bar = document.querySelector(`[data-index="${index}"]`);
                                        if (bar) {
                                            bar.style.animation = 'pulse 2s infinite';
                                        }
                                    }
                                });
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        elements: {
                            bar: {
                                hoverBorderRadius: 8
                            }
                        }
                    }
                });

                // Add hover effects to chart container
                const chartContainer = document.querySelector('.chart-container');
                if (chartContainer) {
                    chartContainer.addEventListener('mouseenter', function() {
                        this.style.filter = 'brightness(1.05)';
                        this.style.transition = 'filter 0.3s ease';
                    });

                    chartContainer.addEventListener('mouseleave', function() {
                        this.style.filter = 'brightness(1)';
                    });
                }
            }

            // Add stagger animation to stat cards
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const cards = entry.target.querySelectorAll('.premium-card');
                        cards.forEach((card, index) => {
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, index * 100);
                        });
                    }
                });
            }, observerOptions);

            const statsSection = document.querySelector('.row.g-4.mb-5');
            if (statsSection) {
                // Initially hide cards
                statsSection.querySelectorAll('.premium-card').forEach(card => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                });

                observer.observe(statsSection);
            }
        });

        // Add pulse animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
        `;
        document.head.appendChild(style);
    </script>

    <style>
        /* Modern Dashboard Styles */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #fcb045 0%, #fd1d1d 100%);
            --danger-gradient: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
            --info-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            --shadow-xl: 0 1.5rem 4rem rgba(0, 0, 0, 0.2);
        }

        /* Hero Section */
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.02"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .welcome-badge {
            animation: fadeInUp 0.8s ease-out;
        }

        .display-4 {
            font-weight: 700;
            letter-spacing: -0.02em;
            animation: fadeInLeft 0.8s ease-out 0.2s both;
        }

        .date-time-display {
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Premium Cards */
        .premium-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .premium-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .premium-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-xl);
        }

        .premium-card.deposit-card::before {
            background: var(--success-gradient);
        }

        .premium-card.pending-card::before {
            background: var(--warning-gradient);
        }

        .premium-card.withdrawal-card::before {
            background: var(--danger-gradient);
        }

        .premium-card.processing-card::before {
            background: var(--info-gradient);
        }

        .premium-card.users-card::before {
            background: var(--primary-gradient);
        }

        .premium-card.active-card::before {
            background: var(--success-gradient);
        }

        .premium-card.blocked-card::before {
            background: var(--danger-gradient);
        }

        .premium-card.plans-card::before {
            background: var(--warning-gradient);
        }

        /* Stat Wrapper */
        .stat-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon-wrapper {
            flex-shrink: 0;
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            font-size: 1.8rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .bg-gradient-success { background: var(--success-gradient); }
        .bg-gradient-warning { background: var(--warning-gradient); }
        .bg-gradient-danger { background: var(--danger-gradient); }
        .bg-gradient-info { background: var(--info-gradient); }
        .bg-gradient-primary { background: var(--primary-gradient); }

        .stat-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .premium-card:hover .stat-icon::before {
            opacity: 1;
        }

        .premium-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        /* Stat Content */
        .stat-content {
            flex-grow: 1;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #6c757d;
            letter-spacing: 0.025em;
        }

        .stat-badge {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: #2d3748;
            line-height: 1.2;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .stat-footer {
            margin-top: auto;
        }

        .stat-footer small {
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Modern Buttons */
        .modern-btn {
            border-radius: 12px !important;
            font-weight: 600;
            letter-spacing: 0.025em;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .modern-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .modern-btn:hover::before {
            left: 100%;
        }

        /* Analytics Card */
        .analytics-card {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 25px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .premium-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Chart Controls */
        .chart-period-selector {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .chart-period-selector .btn {
            border-radius: 0;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .chart-period-selector .btn:hover {
            transform: translateY(-1px);
        }

        .btn-check:checked + .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
        }

        /* Chart Wrapper */
        .chart-wrapper {
            position: relative;
        }

        .chart-container {
            height: 450px;
            position: relative;
            z-index: 2;
        }

        .chart-overlay-info {
            position: absolute;
            bottom: 2rem;
            left: 2rem;
            right: 2rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .chart-info-item {
            text-align: center;
        }

        .chart-info-value {
            display: block;
            font-size: 1.2rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }

        .chart-info-label {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-gradient .display-4 {
                font-size: 2rem;
            }

            .stat-wrapper {
                flex-direction: column;
                text-align: center;
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .chart-overlay-info {
                position: static;
                margin-top: 2rem;
            }
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            .premium-card {
                background: rgba(45, 55, 72, 0.95);
                color: #e2e8f0;
            }

            .stat-value {
                color: #e2e8f0;
            }

            .stat-label {
                color: #a0aec0;
            }
        }
    </style>
@endsection
