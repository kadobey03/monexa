@extends('layouts.app')
@section('content')
@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-light {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    .page-icon-wrapper {
        position: relative;
    }
    .page-icon {
        width: 70px;
        height: 70px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .import-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .import-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .import-icon {
        flex-shrink: 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .assignment-card {
        transition: transform 0.2s ease;
    }
    .assignment-card:hover {
        transform: translateY(-2px);
    }
    .modal-icon-wrapper {
        background: rgba(255,255,255,0.2);
        padding: 12px;
        border-radius: 50%;
    }
    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
    }
    .bg-light-success {
        background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
        color: white;
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
    }
    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .btn-link {
        text-decoration: none;
    }
    .btn-link:hover {
        text-decoration: underline;
    }
</style>
@endsection
@include('admin.topmenu')
@include('admin.sidebar')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="my-2 mb-5 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="page-icon-wrapper me-3">
                        <div class="page-icon bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="title1 mb-1">Müşteri Adaylarını Yönet</h1>
                        <p class="text-muted mb-0">Müşteri adayları henüz herhangi bir yatırım yapmamış yeni kullanıcılardır.</p>
                    </div>
                </div>
                    <div>
                        <a href="#" data-toggle="modal" data-target="#assignModal" class="btn btn-primary btn-lg px-4 py-2 shadow-sm">
                            <i class="fas fa-user-plus me-2"></i>Atama
                        </a>
                        <!-- Assign Modal -->
                        <div id="assignModal" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-header bg-gradient-primary text-white">
                                        <div class="d-flex align-items-center">
                                            <div class="modal-icon-wrapper me-3">
                                                <i class="fas fa-users-cog fa-2x"></i>
                                            </div>
                                            <div>
                                                <h4 class="modal-title mb-0 text-white">Kullanıcı Atama Paneli</h4>
                                                <small class="text-white-50">Takip için kullanıcıları yöneticiye ata</small>
                                            </div>
                                        </div>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <form role="form" method="post" action="{{ route('assignuser') }}">
                                            @csrf

                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div class="assignment-card bg-light-success text-center p-3 rounded-lg">
                                                        <i class="fas fa-user-plus fa-3x text-success mb-2"></i>
                                                        <h6 class="text-success mb-0">Kullanıcı Seçimi</h6>
                                                        <small class="text-muted">Atanacak kullanıcıyı seçin</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="assignment-card bg-light-primary text-center p-3 rounded-lg">
                                                        <i class="fas fa-user-tie fa-3x text-primary mb-2"></i>
                                                        <h6 class="text-primary mb-0">Yönetici Seçimi</h6>
                                                        <small class="text-muted">Sorumlu yöneticiyi seçin</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-4">
                                                <label class="form-label text-primary font-weight-bold">
                                                    <i class="fas fa-users me-2"></i>Atanacak Kullanıcıyı Seçin
                                                </label>
                                                <select name="user_name" id="" class="form-control form-control-lg select2"
                                                    style="width:100%">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }} {{ $user->l_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-4">
                                                <label class="form-label text-primary font-weight-bold">
                                                    <i class="fas fa-user-cog me-2"></i>Sorumlu Yöneticiyi Seçin
                                                </label>
                                                <select name="admin" id="" class="form-control form-control-lg">
                                                    <option value="">Yönetici Seçin</option>
                                                    @foreach ($admin as $user)
                                                        <option value="{{ $user->id }}">{{ $user->firstName }} {{ $user->lastName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group d-flex gap-2">
                                                <button type="submit" class="btn btn-success btn-lg px-4 flex-fill">
                                                    <i class="fas fa-check me-2"></i>Atamayı Tamamla
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
                    </div>
                </div>
                <x-danger-alert />
                <x-success-alert />

                <div class="mb-5 row">
                    <div class="col-lg-12">
                        <div class="import-card bg-gradient-light p-4 rounded-lg shadow-sm">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <div class="import-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                            <i class="fas fa-file-excel fa-lg"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 text-primary">Excel İçe Aktarma</h5>
                                            <p class="mb-0 text-muted">Excel belgesinden müşteri adayları içe aktarın.
                                                <a href="{{ route('downlddoc') }}" class="btn btn-link p-0 text-primary font-weight-bold">
                                                    <i class="fas fa-download me-1"></i>örnek belgeyi indirin
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <form action="{{ route('fileImport') }}" class="d-flex" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="flex-fill me-2">
                                            <input name="file" class="form-control form-control-lg" type="file" required>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary btn-lg px-4" type="submit">
                                                <i class="fas fa-upload me-1"></i>Kaydet
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-lg border-0 overflow-hidden">
                            <div class="card-header bg-gradient-primary text-white py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-table fa-lg me-2"></i>
                                    <h5 class="mb-0 text-white">Müşteri Adayları Listesi</h5>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" data-example-id="hoverable-table">
                                    <table id="ShipTable" class="table table-hover mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="border-0 py-3">
                                                    <i class="fas fa-user me-2 text-primary"></i>İsim
                                                </th>
                                                <th class="border-0 py-3">
                                                    <i class="fas fa-envelope me-2 text-success"></i>E-posta
                                                </th>
                                                <th class="border-0 py-3">
                                                    <i class="fas fa-phone me-2 text-warning"></i>Telefon
                                                </th>
                                                <th class="border-0 py-3">
                                                    <i class="fas fa-toggle-on me-2 text-info"></i>Durum
                                                </th>
                                                <th class="border-0 py-3">
                                                    <i class="fas fa-calendar me-2 text-secondary"></i>Kayıt Tarihi
                                                </th>
                                                <th class="border-0 py-3">
                                                    <i class="fas fa-user-tie me-2 text-primary"></i>Atanan Kişi
                                                </th>
                                                <th class="border-0 py-3 text-center">
                                                    <i class="fas fa-cogs me-2 text-primary"></i>İşlem
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $list)
                                                <tr>
                                                    <td>{{ $list->name }}</td>
                                                    <td>{{ $list->email }}</td>
                                                    <td>{{ $list->phone }}</td>
                                                    <td>
                                                        @if ($list->status == 'active')
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-danger">Pasif</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $list->created_at->toDayDateTimeString() }}
                                                    </td>
                                                    <td>
                                                        @if ($list->tuser->firstName)
                                                            {{ $list->tuser->firstName }} {{ $list->tuser->lastName }}
                                                        @else
                                                            <span class="text-info">Henüz atanmadı</span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        <a class="m-1 btn btn-info btn-sm text-white" data-toggle="modal"
                                                            data-target="#editModal{{ $list->id }}">Durumu Düzenle</a>
                                                    </td>
                                                </tr>

                                                <div id="editModal{{ $list->id }}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog modal-lg">
                                                        <!-- Modal content-->
                                                        <div class="modal-content border-0 shadow-lg">
                                                            <div class="modal-header bg-gradient-warning text-white">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="modal-icon-wrapper me-3">
                                                                        <i class="fas fa-user-edit fa-2x"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h4 class="modal-title mb-0 text-white">Kullanıcı Durumu Düzenleme</h4>
                                                                        <small class="text-white-50">{{ $list->name }} kullanıcısının durumunu güncelleyin</small>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body p-4">
                                                                <form method="post" action="{{ route('updateuser') }}">
                                                                    <div class="form-group mb-4">
                                                                        <label class="form-label text-primary font-weight-bold">
                                                                            <i class="fas fa-edit me-2"></i>Kullanıcı Durumu
                                                                        </label>
                                                                        <textarea name="userupdate" id="" rows="5"
                                                                            class="form-control form-control-lg"
                                                                            placeholder="Kullanıcı durumu ile ilgili notları buraya girin..."
                                                                            required>{{ $list->userupdate }}</textarea>
                                                                    </div>

                                                                    <input type="hidden" name="id" value="{{ $list->id }}">
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                                    <div class="d-flex gap-2">
                                                                        <button type="submit" class="btn btn-warning btn-lg px-4 flex-fill">
                                                                            <i class="fas fa-save me-2"></i>Değişiklikleri Kaydet
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $('.select2').select2();
            </script>
        </div>
    @endsection