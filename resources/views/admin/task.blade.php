@extends('layouts.app')
@section('content')
@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .page-icon-wrapper {
        position: relative;
    }
    .page-icon {
        width: 70px;
        height: 70px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .form-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .form-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .date-icon {
        flex-shrink: 0;
    }
    .priority-icon {
        flex-shrink: 0;
    }
    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
    }
    .btn-lg {
        font-size: 1.1rem;
    }
</style>
@endsection
@include('admin.topmenu')
@include('admin.sidebar')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="mt-2 mb-5 d-flex align-items-center">
                <div class="page-icon-wrapper me-3">
                    <div class="page-icon bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                        <i class="fas fa-tasks fa-2x"></i>
                    </div>
                </div>
                <div>
                    <h1 class="title1 mb-1">Yeni Görev Oluştur</h1>
                    <p class="text-muted mb-0">Sistemde yeni görev tanımlayın ve yöneticiye atayın</p>
                </div>
            </div>
                <x-danger-alert />
                <x-success-alert />
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card shadow-lg border-0 overflow-hidden">
                            <div class="card-header bg-gradient-primary text-white py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-plus-circle fa-lg me-2"></i>
                                    <h4 class="mb-0 text-white">Görev Bilgileri</h4>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <form method="post" action="{{ route('addtask') }}" enctype="multipart/form-data">

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="form-card bg-light p-3 rounded-lg h-100">
                                                <i class="fas fa-heading text-primary fa-2x mb-3"></i>
                                                <h6 class="text-primary mb-2">Görev Başlığı</h6>
                                                <input type="text" name="tasktitle" class="form-control form-control-lg"
                                                    placeholder="Görev başlığını buraya yazın..." required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-card bg-light p-3 rounded-lg h-100">
                                                <i class="fas fa-user-tie text-success fa-2x mb-3"></i>
                                                <h6 class="text-success mb-2">Sorumlu Yönetici</h6>
                                                <select class="form-control form-control-lg" name="delegation" required>
                                                    @foreach ($admin as $user)
                                                        <option value="{{ $user->id }}">{{ $user->firstName }} {{ $user->lastName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label text-primary font-weight-bold">
                                            <i class="fas fa-align-left me-2"></i>Görev Açıklaması
                                        </label>
                                        <textarea name="note" id="" rows="5"
                                            class="form-control form-control-lg"
                                            placeholder="Görev ile ilgili detaylı açıklamayı buraya yazın..."
                                            required></textarea>
                                    </div>

                                    <div class="row mb-4">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="form-card bg-light p-3 rounded-lg h-100">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="date-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-play"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="text-success mb-0">Başlangıç Tarihi</h6>
                                                        <small class="text-muted">Görev başlangıç zamanı</small>
                                                    </div>
                                                </div>
                                                <input type="date" name="start_date" class="form-control form-control-lg" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-card bg-light p-3 rounded-lg h-100">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="date-icon bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-stop"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="text-danger mb-0">Bitiş Tarihi</h6>
                                                        <small class="text-muted">Görev bitiş zamanı</small>
                                                    </div>
                                                </div>
                                                <input type="date" name="end_date" class="form-control form-control-lg" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <div class="form-card bg-light p-3 rounded-lg">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="priority-icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-warning mb-0">Öncelik Seviyesi</h6>
                                                    <small class="text-muted">Görevin aciliyet derecesi</small>
                                                </div>
                                            </div>
                                            <select class="form-control form-control-lg" name="priority" required>
                                                <option value="Hemen">🚨 Hemen</option>
                                                <option value="Yüksek">🔥 Yüksek</option>
                                                <option value="Orta">⚡ Orta</option>
                                                <option value="Düşük">⏰ Düşük</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group text-center">
                                        <input type="hidden" name="id" value="{{ Auth('admin')->User()->id }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                            <i class="fas fa-paper-plane me-2"></i>Görev Oluştur
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
