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
<!-- Admin Layout Container -->
<div class="min-h-screen bg-gray-50">
    <!-- Main Content -->
    <div class="admin-main-content flex-1 lg:ml-64 transition-all duration-300">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
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

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div class="space-y-4">
                                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-100 hover:shadow-md transition-all duration-200">
                                                <div class="flex items-center mb-3">
                                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-heading text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="text-blue-700 font-semibold mb-1">Görev Başlığı</h6>
                                                        <p class="text-blue-600 text-sm">Görev için açıklayıcı başlık</p>
                                                    </div>
                                                </div>
                                                <input type="text" name="tasktitle"
                                                       class="w-full px-4 py-3 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/70 backdrop-blur-sm"
                                                       placeholder="Görev başlığını buraya yazın..." required>
                                            </div>
                                        </div>

                                        <div class="space-y-4">
                                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border border-green-100 hover:shadow-md transition-all duration-200">
                                                <div class="flex items-center mb-3">
                                                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-user-tie text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="text-green-700 font-semibold mb-1">Sorumlu Yönetici</h6>
                                                        <p class="text-green-600 text-sm">Görev atanacak yönetici</p>
                                                    </div>
                                                </div>
                                                <select name="delegation"
                                                        class="w-full px-4 py-3 border border-green-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white/70 backdrop-blur-sm" required>
                                                    <option value="" disabled selected>Yönetici seçin...</option>
                                                    @foreach ($admin as $user)
                                                        <option value="{{ $user->id }}">{{ $user->firstName }} {{ $user->lastName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-4 rounded-xl border border-purple-100">
                                            <label class="flex items-center text-purple-700 font-semibold mb-3">
                                                <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-align-left text-white text-sm"></i>
                                                </div>
                                                Görev Açıklaması
                                            </label>
                                            <textarea name="note" rows="5"
                                                      class="w-full px-4 py-3 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-white/70 backdrop-blur-sm resize-none"
                                                      placeholder="Görev ile ilgili detaylı açıklamayı buraya yazın..." required></textarea>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div class="bg-gradient-to-r from-green-50 to-teal-50 p-4 rounded-xl border border-green-100">
                                            <div class="flex items-center mb-3">
                                                <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-teal-600 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-play text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-green-700 font-semibold">Başlangıç Tarihi</h6>
                                                    <small class="text-green-600">Görev başlangıç zamanı</small>
                                                </div>
                                            </div>
                                            <input type="date" name="start_date"
                                                   class="w-full px-4 py-3 border border-green-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white/70 backdrop-blur-sm" required>
                                        </div>

                                        <div class="bg-gradient-to-r from-red-50 to-pink-50 p-4 rounded-xl border border-red-100">
                                            <div class="flex items-center mb-3">
                                                <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-stop text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-red-700 font-semibold">Bitiş Tarihi</h6>
                                                    <small class="text-red-600">Görev bitiş zamanı</small>
                                                </div>
                                            </div>
                                            <input type="date" name="end_date"
                                                   class="w-full px-4 py-3 border border-red-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 bg-white/70 backdrop-blur-sm" required>
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 p-4 rounded-xl border border-amber-100">
                                            <div class="flex items-center mb-3">
                                                <div class="w-10 h-10 bg-gradient-to-r from-amber-500 to-yellow-600 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-amber-700 font-semibold">Öncelik Seviyesi</h6>
                                                    <small class="text-amber-600">Görevin aciliyet derecesi</small>
                                                </div>
                                            </div>
                                            <select name="priority"
                                                    class="w-full px-4 py-3 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-white/70 backdrop-blur-sm" required>
                                                <option value="" disabled selected>Öncelik seviyesi seçin...</option>
                                                <option value="Hemen" class="bg-red-50 text-red-700">🚨 Hemen - Kritik</option>
                                                <option value="Yüksek" class="bg-orange-50 text-orange-700">🔥 Yüksek - Acil</option>
                                                <option value="Orta" class="bg-yellow-50 text-yellow-700">⚡ Orta - Normal</option>
                                                <option value="Düşük" class="bg-green-50 text-green-700">⏰ Düşük - Ertelenebilir</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <input type="hidden" name="id" value="{{ Auth('admin')->User()->id }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 inline-flex items-center">
                                            <i class="fas fa-paper-plane mr-2"></i>
                                            Görev Oluştur
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection
