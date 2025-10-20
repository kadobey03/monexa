@extends('layouts.app')
@section('content')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i>Sistem Güncellemesi
                </h4>
                <p>Lead yönetim sistemi yeni bir sürüme güncellendi. Yeni özellikler ve gelişmiş kullanıcı deneyimi için yeni arayüzü kullanın.</p>
                <hr>
                <div class="mb-0">
                    <a class="btn btn-primary" href="{{ route('admin.leads.index') }}">
                        <i class="fas fa-arrow-right me-2"></i>Yeni Lead Yönetimi Sayfasına Git
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection