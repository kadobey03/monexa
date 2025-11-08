
@php
    $isDark = Auth('admin')->User()->dashboard_style !== 'light';
@endphp

@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-admin-50 {{ $isDark ? 'dark:bg-admin-900' : '' }}">
    <!-- Header Section -->
    <div class="bg-admin-100 {{ $isDark ? 'dark:bg-admin-800' : '' }} border-b border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }}">
        <div class="max-w-none mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex-1">
                    <div class="flex items-center space-x-4 mb-2">
                        <a href="{{ route('manageusers') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} hover:text-admin-700 {{ $isDark ? 'dark:hover:text-admin-300' : '' }} transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kullanıcı Yönetimine Dön
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} flex items-center">
                        <i class="fas fa-file-excel text-green-600 mr-4 text-4xl"></i>
                        Kullanıcı İçe Aktarma
                    </h1>
                    <p class="mt-2 text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">
                        Excel/CSV dosyasından toplu kullanıcı verilerini sisteme aktarın
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="bg-admin-200 {{ $isDark ? 'dark:bg-admin-700' : '' }} px-4 py-2 rounded-full">
                        <span class="text-admin-800 {{ $isDark ? 'dark:text-admin-200' : '' }} font-semibold">
                            <i class="fas fa-upload mr-2"></i>
                            Gelişmiş İçe Aktarma
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-none mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Step Indicator -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-8">
                <div id="step-1-indicator" class="flex items-center step-indicator active">
                    <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
                    <span class="ml-3 text-sm font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">Dosya Seçimi</span>
                </div>
                <div class="w-16 h-1 bg-admin-200 {{ $isDark ? 'dark:bg-admin-700' : '' }} rounded"></div>
                <div id="step-2-indicator" class="flex items-center step-indicator">
                    <div class="w-10 h-10 bg-admin-300 {{ $isDark ? 'dark:bg-admin-600' : '' }} text-admin-600 {{ $isDark ? 'dark:text-admin-300' : '' }} rounded-full flex items-center justify-center font-bold">2</div>
                    <span class="ml-3 text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">Sütun Eşleştirme</span>
                </div>
                <div class="w-16 h-1 bg-admin-200 {{ $isDark ? 'dark:bg-admin-700' : '' }} rounded"></div>
                <div id="step-3-indicator" class="flex items-center step-indicator">
                    <div class="w-10 h-10 bg-admin-300 {{ $isDark ? 'dark:bg-admin-600' : '' }} text-admin-600 {{ $isDark ? 'dark:text-admin-300' : '' }} rounded-full flex items-center justify-center font-bold">3</div>
                    <span class="ml-3 text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">İçe Aktarma</span>
                </div>
            </div>
        </div>

        <!-- Step 1: File Upload -->
        <div id="step-1" class="step-content">
            <div class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-lg border border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }} overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
                    <h3 class="text-lg font-medium text-white mb-2">1. Adım: Excel/CSV Dosyası Seçin</h3>
                    <p class="text-blue-100 text-sm">Kullanıcı verilerini içeren Excel (.xlsx, .xls) veya CSV dosyasını yükleyin</p>
                </div>

                <div class="p-8">
                    <!-- File Upload Area -->
                    <div class="border-2 border-dashed border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg p-8 text-center hover:border-blue-500 transition-colors duration-200" 
                         id="file-upload-area" 
                         ondrop="handleFileDrop(event)" 
                         ondragover="handleDragOver(event)" 
                         ondragleave="handleDragLeave(event)">
                        
                        <div id="upload-placeholder">
                            <i class="fas fa-cloud-upload-alt text-6xl text-admin-400 {{ $isDark ? 'dark:text-admin-500' : '' }} mb-4"></i>
                            <h4 class="text-xl font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} mb-2">
                                Dosyayı buraya sürükleyip bırakın
                            </h4>
                            <p class="text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mb-4">
                                veya dosya seçmek için tıklayın
                            </p>
                            <input type="file" id="file-input" class="hidden" accept=".xlsx,.xls,.csv" onchange="handleFileSelect(event)">
                            <button type="button" onclick="document.getElementById('file-input').click()" 
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                                <i class="fas fa-folder-open mr-2"></i>
                                Dosya Seç
                            </button>
                        </div>

                        <div id="file-info" class="hidden">
                            <div class="flex items-center justify-center space-x-4">
                                <div class="w-16 h-16 bg-green-100 {{ $isDark ? 'dark:bg-green-900' : '' }} rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-excel text-2xl text-green-600"></i>
                                </div>
                                <div class="text-left">
                                    <h4 id="file-name" class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}"></h4>
                                    <p id="file-size" class="text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}"></p>
                                </div>
                                <button type="button" onclick="removeFile()" 
                                        class="p-2 text-red-600 hover:bg-red-100 {{ $isDark ? 'dark:hover:bg-red-900' : '' }} rounded-lg transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- File Format Info -->
                    <div class="mt-6 bg-blue-50 {{ $isDark ? 'dark:bg-blue-900/20' : '' }} border border-blue-200 {{ $isDark ? 'dark:border-blue-700' : '' }} rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                            <div>
                                <h5 class="font-semibold text-blue-900 {{ $isDark ? 'dark:text-blue-100' : '' }} mb-2">Desteklenen Dosya Formatları</h5>
                                <ul class="text-sm text-blue-800 {{ $isDark ? 'dark:text-blue-200' : '' }} space-y-1">
                                    <li>• <strong>Excel:</strong> .xlsx, .xls formatları</li>
                                    <li>• <strong>CSV:</strong> .csv formatı (UTF-8 kodlaması önerilir)</li>
                                    <li>• <strong>Maksimum Dosya Boyutu:</strong> 10 MB</li>
                                    <li>• <strong>Maksimum Satır Sayısı:</strong> 5,000 kullanıcı</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Sample Template Download -->
                    <div class="mt-6 bg-green-50 {{ $isDark ? 'dark:bg-green-900/20' : '' }} border border-green-200 {{ $isDark ? 'dark:border-green-700' : '' }} rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-download text-green-600 mt-1"></i>
                                <div>
                                    <h5 class="font-semibold text-green-900 {{ $isDark ? 'dark:text-green-100' : '' }} mb-1">Örnek Şablon İndir</h5>
                                    <p class="text-sm text-green-800 {{ $isDark ? 'dark:text-green-200' : '' }}">
                                        Doğru format için örnek Excel şablonunu indirin
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('downlddoc') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i>
                                Şablon İndir
                            </a>
                        </div>
                    </div>

                    <!-- Next Step Button -->
                    <div class="mt-8 flex justify-end">
                        <button type="button" id="next-to-step-2" onclick="goToStep(2)" disabled
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-admin-300 disabled:cursor-not-allowed text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                            Devam Et: Sütun Eşleştirme
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Column Mapping -->
        <div id="step-2" class="step-content hidden">
            <div class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-lg border border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }} overflow-hidden">
                <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-6 py-5">
                    <h3 class="text-lg font-medium text-white mb-2">2. Adım: Sütun Eşleştirme</h3>
                    <p class="text-orange-100 text-sm">Excel dosyanızdaki sütunları sistem alanlarıyla eşleştirin</p>
                </div>

                <div class="p-8">
                    <!-- File Preview -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} mb-4">
                            <i class="fas fa-table mr-2 text-orange-600"></i>
                            Dosya Önizleme (İlk 5 Satır)
                        </h4>
                        <div class="overflow-x-auto bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }} rounded-lg border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }}">
                            <table id="preview-table" class="min-w-full divide-y divide-admin-200 {{ $isDark ? 'dark:divide-admin-600' : '' }}">
                                <thead class="bg-admin-100 {{ $isDark ? 'dark:bg-admin-750' : '' }}">
                                    <!-- Bu kısım JavaScript ile doldurulacak -->
                                </thead>
                                <tbody class="bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} divide-y divide-admin-200 {{ $isDark ? 'dark:divide-admin-600' : '' }}">
                                    <!-- Bu kısım JavaScript ile doldurulacak -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Column Mapping -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} mb-4">
                            <i class="fas fa-link mr-2 text-orange-600"></i>
                            Sütun Eşleştirme
                        </h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <h5 class="font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} mb-3">Excel Sütunları</h5>
                                <div id="excel-columns" class="space-y-2">
                                    <!-- Bu kısım JavaScript ile doldurulacak -->
                                </div>
                            </div>
                            <div>
                                <h5 class="font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} mb-3">Sistem Alanları</h5>
                                <div id="system-fields" class="space-y-2">
                                    <div class="system-field p-3 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }}" data-field="name">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">Ad Soyad</span>
                                            <span class="text-xs text-red-600 font-semibold">ZORUNLU</span>
                                        </div>
                                        <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mt-1">Kullanıcının tam adı</p>
                                    </div>
                                    <div class="system-field p-3 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }}" data-field="email">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">E-posta</span>
                                            <span class="text-xs text-red-600 font-semibold">ZORUNLU</span>
                                        </div>
                                        <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mt-1">E-posta adresi</p>
                                    </div>
                                    <div class="system-field p-3 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }}" data-field="phone">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">Telefon</span>
                                            <span class="text-xs text-blue-600 font-semibold">İSTEĞE BAĞLI</span>
                                        </div>
                                        <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mt-1">Telefon numarası</p>
                                    </div>
                                    <div class="system-field p-3 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }}" data-field="country">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">Ülke</span>
                                            <span class="text-xs text-blue-600 font-semibold">İSTEĞE BAĞLI</span>
                                        </div>
                                        <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mt-1">Ülke bilgisi</p>
                                    </div>
                                    <div class="system-field p-3 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }}" data-field="username">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">Kullanıcı Adı</span>
                                            <span class="text-xs text-blue-600 font-semibold">İSTEĞE BAĞLI</span>
                                        </div>
                                        <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mt-1">Otomatik oluşturulur</p>
                                    </div>
                                    <div class="system-field p-3 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }}" data-field="estimated_value">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">Tahmini Değer</span>
                                            <span class="text-xs text-blue-600 font-semibold">İSTEĞE BAĞLI</span>
                                        </div>
                                        <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mt-1">Lead değeri (sayısal)</p>
                                    </div>
                                    <div class="system-field p-3 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }}" data-field="utm_source">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">UTM Source</span>
                                            <span class="text-xs text-blue-600 font-semibold">İSTEĞE BAĞLI</span>
                                        </div>
                                        <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mt-1">Trafik kaynağı</p>
                                        <div class="mt-2">
                                            <input type="text" id="manual-utm-source" placeholder="Elle girin (opsiyonel)"
                                                   class="w-full px-2 py-1 text-xs border border-admin-300 {{ $isDark ? 'dark:border-admin-500' : '' }} rounded bg-white {{ $isDark ? 'dark:bg-admin-600' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    <div class="system-field p-3 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }}" data-field="utm_campaign">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">UTM Campaign</span>
                                            <span class="text-xs text-blue-600 font-semibold">İSTEĞE BAĞLI</span>
                                        </div>
                                        <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mt-1">Kampanya adı</p>
                                        <div class="mt-2">
                                            <input type="text" id="manual-utm-campaign" placeholder="Elle girin (opsiyonel)"
                                                   class="w-full px-2 py-1 text-xs border border-admin-300 {{ $isDark ? 'dark:border-admin-500' : '' }} rounded bg-white {{ $isDark ? 'dark:bg-admin-600' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    <div class="system-field p-3 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }}" data-field="first_name">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">Ad (Ayrı)</span>
                                            <span class="text-xs text-purple-600 font-semibold">BİRLEŞTİRİLECEK</span>
                                        </div>
                                        <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mt-1">Sadece isim - soyad ile birleştirilir</p>
                                    </div>
                                    <div class="system-field p-3 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }}" data-field="last_name">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">Soyad (Ayrı)</span>
                                            <span class="text-xs text-purple-600 font-semibold">BİRLEŞTİRİLECEK</span>
                                        </div>
                                        <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mt-1">Sadece soyisim - ad ile birleştirilir</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mapping Summary -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} mb-4">
                            <i class="fas fa-check-circle mr-2 text-green-600"></i>
                            Eşleştirme Özeti
                        </h4>
                        <div id="mapping-summary" class="bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }} rounded-lg p-4 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }}">
                            <p class="text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} text-center">
                                Henüz eşleştirme yapılmadı. Sütunları sürükleyerek eşleştirin.
                            </p>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between">
                        <button type="button" onclick="goToStep(1)" 
                                class="inline-flex items-center px-6 py-3 bg-admin-600 hover:bg-admin-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Geri: Dosya Seçimi
                        </button>
                        <button type="button" id="next-to-step-3" onclick="goToStep(3)" disabled
                                class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 disabled:bg-admin-300 disabled:cursor-not-allowed text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                            Devam Et: İçe Aktarma
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Import Process -->
        <div id="step-3" class="step-content hidden">
            <div class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-lg border border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }} overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-5">
                    <h3 class="text-lg font-medium text-white mb-2">3. Adım: İçe Aktarma İşlemi</h3>
                    <p class="text-green-100 text-sm">Kullanıcı verilerini sisteme aktarın</p>
                </div>

                <div class="p-8">
                    <!-- Import Settings -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} mb-4">
                            <i class="fas fa-cog mr-2 text-green-600"></i>
                            İçe Aktarma Ayarları
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" id="skip-duplicates" checked 
                                               class="w-4 h-4 text-blue-600 border-admin-300 rounded focus:ring-blue-500">
                                        <span class="text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">
                                            Mevcut e-postaları atla
                                        </span>
                                    </label>
                                    <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} ml-7">
                                        Sistemde zaten bulunan e-posta adreslerini atla
                                    </p>
                                </div>
                                <div>
                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" id="send-welcome-email" 
                                               class="w-4 h-4 text-blue-600 border-admin-300 rounded focus:ring-blue-500">
                                        <span class="text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">
                                            Hoş geldiniz e-postası gönder
                                        </span>
                                    </label>
                                    <p class="text-xs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} ml-7">
                                        Yeni kullanıcılara hoş geldiniz e-postası gönder
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} mb-2">
                                        Varsayılan Lead Status
                                    </label>
                                    <select id="default-lead-status"
                                            class="block w-full px-3 py-2 border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        @foreach($leadStatuses as $value => $label)
                                            <option value="{{ $value }}" {{ $value === 'new' ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} mb-2">
                                        Batch Boyutu
                                    </label>
                                    <select id="batch-size" 
                                            class="block w-full px-3 py-2 border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="50">50 kayıt</option>
                                        <option value="100" selected>100 kayıt</option>
                                        <option value="250">250 kayıt</option>
                                        <option value="500">500 kayıt</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Import Summary -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} mb-4">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            İçe Aktarma Özeti
                        </h4>
                        <div id="import-summary" class="bg-blue-50 {{ $isDark ? 'dark:bg-blue-900/20' : '' }} border border-blue-200 {{ $isDark ? 'dark:border-blue-700' : '' }} rounded-lg p-4">
                            <!-- Bu kısım JavaScript ile doldurulacak -->
                        </div>
                    </div>

                    <!-- Progress Section (Hidden initially) -->
                    <div id="import-progress" class="hidden mb-8">
                        <h4 class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} mb-4">
                            <i class="fas fa-spinner fa-spin mr-2 text-green-600"></i>
                            İçe Aktarma İlerlemesi
                        </h4>
                        <div class="bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }} rounded-lg p-4 border border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }}">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">İlerleme</span>
                                <span id="progress-percentage" class="text-sm font-bold text-green-600">0%</span>
                            </div>
                            <div class="w-full bg-admin-200 {{ $isDark ? 'dark:bg-admin-600' : '' }} rounded-full h-2">
                                <div id="progress-bar"
 class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <div class="mt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">İşlenen:</span>
                                    <span id="processed-count" class="font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">0</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">Başarılı:</span>
                                    <span id="success-count" class="font-semibold text-green-600">0</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">Hatalı:</span>
                                    <span id="error-count" class="font-semibold text-red-600">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Results Section (Hidden initially) -->
                    <div id="import-results" class="hidden mb-8">
                        <h4 class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} mb-4">
                            <i class="fas fa-check-circle mr-2 text-green-600"></i>
                            İçe Aktarma Sonuçları
                        </h4>
                        <div id="results-content" class="space-y-4">
                            <!-- Bu kısım JavaScript ile doldurulacak -->
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between">
                        <button type="button" onclick="goToStep(2)" 
                                class="inline-flex items-center px-6 py-3 bg-admin-600 hover:bg-admin-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Geri: Sütun Eşleştirme
                        </button>
                        <div class="space-x-3">
                            <button type="button" id="start-import" onclick="startImport()" 
                                    class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                                <i class="fas fa-play mr-2"></i>
                                İçe Aktarmayı Başlat
                            </button>
                            <button type="button" id="finish-import" onclick="finishImport()" style="display: none;"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                                <i class="fas fa-check mr-2"></i>
                                Tamamla
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Column Mapping JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
// Global variables
let uploadedFile = null;
let excelData = [];
let columnMappings = {};
let isDarkMode = {{ $isDark ? 'true' : 'false' }};

// Step management
function goToStep(step) {
    // Hide all steps
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
    
    // Show target step
    document.getElementById(`step-${step}`).classList.remove('hidden');
    
    // Update step indicators
    updateStepIndicators(step);
    
    // Handle step-specific logic
    switch(step) {
        case 2:
            if (uploadedFile) {
                parseExcelFile();
            }
            break;
        case 3:
            updateImportSummary();
            break;
    }
}

function updateStepIndicators(activeStep) {
    for (let i = 1; i <= 3; i++) {
        const indicator = document.getElementById(`step-${i}-indicator`);
        const circle = indicator.querySelector('div');
        const text = indicator.querySelector('span');
        
        if (i < activeStep) {
            // Completed step
            circle.className = 'w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold';
            text.className = 'ml-3 text-sm font-medium text-green-600';
            circle.innerHTML = '<i class="fas fa-check"></i>';
        } else if (i === activeStep) {
            // Active step
            circle.className = 'w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold';
            text.className = `ml-3 text-sm font-medium text-admin-900 ${isDarkMode ? 'dark:text-admin-100' : ''}`;
            circle.textContent = i;
        } else {
            // Future step
            circle.className = `w-10 h-10 bg-admin-300 ${isDarkMode ? 'dark:bg-admin-600' : ''} text-admin-600 ${isDarkMode ? 'dark:text-admin-300' : ''} rounded-full flex items-center justify-center font-bold`;
            text.className = `ml-3 text-sm font-medium text-admin-600 ${isDarkMode ? 'dark:text-admin-400' : ''}`;
            circle.textContent = i;
        }
    }
}

// File handling functions
function handleFileDrop(e) {
    e.preventDefault();
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        processFile(files[0]);
    }
    resetDropArea();
}

function handleDragOver(e) {
    e.preventDefault();
    document.getElementById('file-upload-area').classList.add('border-blue-500', 'bg-blue-50');
}

function handleDragLeave(e) {
    e.preventDefault();
    resetDropArea();
}

function resetDropArea() {
    const area = document.getElementById('file-upload-area');
    area.classList.remove('border-blue-500', 'bg-blue-50');
}

function handleFileSelect(e) {
    const files = e.target.files;
    if (files.length > 0) {
        processFile(files[0]);
    }
}

function processFile(file) {
    // Validate file
    const allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
                         'application/vnd.ms-excel', 'text/csv'];
    const maxSize = 10 * 1024 * 1024; // 10MB
    
    if (!allowedTypes.includes(file.type) && !file.name.match(/\.(xlsx|xls|csv)$/i)) {
        showNotification('Desteklenmeyen dosya formatı. Lütfen Excel (.xlsx, .xls) veya CSV dosyası seçin.', 'error');
        return;
    }
    
    if (file.size > maxSize) {
        showNotification('Dosya boyutu çok büyük. Maksimum 10MB dosya yükleyebilirsiniz.', 'error');
        return;
    }
    
    uploadedFile = file;
    
    // Update UI
    document.getElementById('upload-placeholder').classList.add('hidden');
    document.getElementById('file-info').classList.remove('hidden');
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-size').textContent = formatFileSize(file.size);
    document.getElementById('next-to-step-2').disabled = false;
    
    showNotification('Dosya başarıyla yüklendi!', 'success');
}

function removeFile() {
    uploadedFile = null;
    excelData = [];
    columnMappings = {};
    
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('file-info').classList.add('hidden');
    document.getElementById('file-input').value = '';
    document.getElementById('next-to-step-2').disabled = true;
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Excel parsing functions
function parseExcelFile() {
    if (!uploadedFile) return;
    
    const reader = new FileReader();
    reader.onload = function(e) {
        try {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            const firstSheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[firstSheetName];
            
            // Convert to JSON
            excelData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
            
            if (excelData.length === 0) {
                showNotification('Excel dosyası boş görünüyor.', 'error');
                return;
            }
            
            displayExcelPreview();
            createColumnMapping();
            
        } catch (error) {
            console.error('Excel parsing error:', error);
            showNotification('Excel dosyası okunurken hata oluştu: ' + error.message, 'error');
        }
    };
    
    reader.readAsArrayBuffer(uploadedFile);
}

function displayExcelPreview() {
    const table = document.getElementById('preview-table');
    const thead = table.querySelector('thead');
    const tbody = table.querySelector('tbody');
    
    // Clear existing content
    thead.innerHTML = '';
    tbody.innerHTML = '';
    
    if (excelData.length === 0) return;
    
    // Create header
    const headerRow = document.createElement('tr');
    excelData[0].forEach((header, index) => {
        const th = document.createElement('th');
        th.className = `px-4 py-3 text-left text-xs font-medium text-admin-500 ${isDarkMode ? 'dark:text-admin-400' : ''} uppercase tracking-wider`;
        th.textContent = header || `Sütun ${index + 1}`;
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    
    // Create preview rows (max 5)
    const previewRows = excelData.slice(1, 6);
    previewRows.forEach(row => {
        const tr = document.createElement('tr');
        excelData[0].forEach((_, index) => {
            const td = document.createElement('td');
            td.className = `px-4 py-3 whitespace-nowrap text-sm text-admin-900 ${isDarkMode ? 'dark:text-admin-100' : ''}`;
            td.textContent = row[index] || '-';
            tr.appendChild(td);
        });
        tbody.appendChild(tr);
    });
}

function createColumnMapping() {
    const excelColumnsContainer = document.getElementById('excel-columns');
    excelColumnsContainer.innerHTML = '';
    
    if (excelData.length === 0) return;
    
    // Create draggable excel columns
    excelData[0].forEach((header, index) => {
        const div = document.createElement('div');
        div.className = `excel-column p-3 border border-admin-200 ${isDarkMode ? 'dark:border-admin-600' : ''} rounded-lg bg-white ${isDarkMode ? 'dark:bg-admin-800' : ''} cursor-move hover:shadow-md transition-shadow duration-200`;
        div.draggable = true;
        div.dataset.columnIndex = index;
        div.dataset.columnName = header || `Sütun ${index + 1}`;
        
        div.innerHTML = `
            <div class="flex items-center justify-between">
                <span class="font-medium text-admin-900 ${isDarkMode ? 'dark:text-admin-100' : ''}">${header || `Sütun ${index + 1}`}</span>
                <i class="fas fa-grip-vertical text-admin-400 ${isDarkMode ? 'dark:text-admin-500' : ''}"></i>
            </div>
            <p class="text-xs text-admin-600 ${isDarkMode ? 'dark:text-admin-400' : ''} mt-1">
                Örnek: ${excelData[1] && excelData[1][index] ? String(excelData[1][index]).substring(0, 20) + '...' : 'Veri yok'}
            </p>
        `;
        
        // Add drag event listeners
        div.addEventListener('dragstart', handleDragStart);
        div.addEventListener('dragend', handleDragEnd);
        
        excelColumnsContainer.appendChild(div);
    });
    
    // Add drop event listeners to system fields
    document.querySelectorAll('.system-field').forEach(field => {
        field.addEventListener('dragover', handleDragOver);
        field.addEventListener('drop', handleDrop);
        field.addEventListener('dragleave', handleDragLeave);
    });
}

// Drag and drop handlers
function handleDragStart(e) {
    e.dataTransfer.setData('text/plain', '');
    e.dataTransfer.effectAllowed = 'move';
    this.classList.add('opacity-50');
}

function handleDragEnd(e) {
    this.classList.remove('opacity-50');
}

function handleDrop(e) {
    e.preventDefault();
    const draggedElement = document.querySelector('.excel-column.opacity-50');
    if (!draggedElement) return;
    
    const systemField = e.currentTarget.dataset.field;
    const columnIndex = parseInt(draggedElement.dataset.columnIndex);
    const columnName = draggedElement.dataset.columnName;
    
    // Update mapping
    columnMappings[systemField] = {
        index: columnIndex,
        name: columnName
    };
    
    // Update UI
    updateMappingUI(e.currentTarget, columnName);
    updateMappingSummary();
    
    // Remove drag styling
    e.currentTarget.classList.remove('border-blue-500', 'bg-blue-50');
    
    // Check if required fields are mapped
    checkRequiredMappings();
}

function updateMappingUI(systemField, columnName) {
    // Add mapped indicator
    let mappedIndicator = systemField.querySelector('.mapped-indicator');
    if (!mappedIndicator) {
        mappedIndicator = document.createElement('div');
        mappedIndicator.className = 'mapped-indicator mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded font-semibold';
        systemField.appendChild(mappedIndicator);
    }
    mappedIndicator.innerHTML = `<i class="fas fa-link mr-1"></i>Eşleştirildi: ${columnName}`;
}

function updateMappingSummary() {
    const summaryContainer = document.getElementById('mapping-summary');
    
    if (Object.keys(columnMappings).length === 0) {
        summaryContainer.innerHTML = `
            <p class="text-admin-600 ${isDarkMode ? 'dark:text-admin-400' : ''} text-center">
                Henüz eşleştirme yapılmadı. Sütunları sürükleyerek eşleştirin.
            </p>
        `;
        return;
    }
    
    let summaryHTML = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
    
    Object.entries(columnMappings).forEach(([field, mapping]) => {
        const fieldNames = {
            'name': 'Ad Soyad',
            'email': 'E-posta',
            'phone': 'Telefon',
            'country': 'Ülke',
            'username': 'Kullanıcı Adı',
            'estimated_value': 'Tahmini Değer',
            'utm_source': 'UTM Source',
            'utm_campaign': 'UTM Campaign',
            'first_name': 'Ad (Ayrı)',
            'last_name': 'Soyad (Ayrı)'
        };
        
        summaryHTML += `
            <div class="flex items-center justify-between p-3 border border-green-200 ${isDarkMode ? 'dark:border-green-700' : ''} rounded-lg bg-green-50 ${isDarkMode ? 'dark:bg-green-900/20' : ''}">
                <span class="font-medium text-green-900 ${isDarkMode ? 'dark:text-green-100' : ''}">${fieldNames[field]}</span>
                <span class="text-sm text-green-700 ${isDarkMode ? 'dark:text-green-300' : ''}">${mapping.name}</span>
            </div>
        `;
    });
    
    summaryHTML += '</div>';
    summaryContainer.innerHTML = summaryHTML;
}

function checkRequiredMappings() {
    const requiredFields = ['email']; // Email zorunlu
    const mappedRequired = requiredFields.filter(field => columnMappings[field]);
    
    // Ad/Soyad kontrolü - ya 'name' eşleştirilmeli ya da hem 'first_name' hem de 'last_name'
    const hasName = columnMappings['name'];
    const hasFirstAndLastName = columnMappings['first_name'] && columnMappings['last_name'];
    const nameRequirementMet = hasName || hasFirstAndLastName;
    
    const nextButton = document.getElementById('next-to-step-3');
    if (mappedRequired.length === requiredFields.length && nameRequirementMet) {
        nextButton.disabled = false;
        if (hasFirstAndLastName && !hasName) {
            showNotification('Ad ve Soyad alanları birleştirilerek "Ad Soyad" alanı oluşturulacak.', 'info');
        } else {
            showNotification('Zorunlu alanlar eşleştirildi. Devam edebilirsiniz.', 'success');
        }
    } else {
        nextButton.disabled = true;
        let missingMessage = '';
        if (mappedRequired.length < requiredFields.length) {
            const missingFields = requiredFields.filter(field => !columnMappings[field]);
            missingMessage = `Zorunlu alanlar eksik: ${missingFields.join(', ')}`;
        }
        if (!nameRequirementMet) {
            if (missingMessage) missingMessage += ' ve ';
            missingMessage += 'Ad Soyad alanı veya Ad+Soyad (ayrı) alanları gerekli';
        }
        showNotification(missingMessage, 'warning');
    }
}

// Import functions
function updateImportSummary() {
    const summaryContainer = document.getElementById('import-summary');
    const totalRows = excelData.length - 1; // Exclude header
    const mappedFields = Object.keys(columnMappings).length;
    
    // Check for manual UTM values
    const manualUtmSource = document.getElementById('manual-utm-source').value.trim();
    const manualUtmCampaign = document.getElementById('manual-utm-campaign').value.trim();
    const hasManualUtm = manualUtmSource || manualUtmCampaign;
    
    let summaryHTML = `
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">${totalRows}</div>
                <div class="text-sm text-admin-600 ${isDarkMode ? 'dark:text-admin-400' : ''}">Toplam Kayıt</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">${mappedFields}</div>
                <div class="text-sm text-admin-600 ${isDarkMode ? 'dark:text-admin-400' : ''}">Eşleştirilen Alan</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-orange-600">${Object.keys(columnMappings).includes('email') ? 'Hazır' : 'Eksik'}</div>
                <div class="text-sm text-admin-600 ${isDarkMode ? 'dark:text-admin-400' : ''}">Durum</div>
            </div>
        </div>
    `;
    
    if (hasManualUtm) {
        summaryHTML += `
            <div class="mt-4 p-3 bg-blue-50 ${isDarkMode ? 'dark:bg-blue-900/20' : ''} border border-blue-200 ${isDarkMode ? 'dark:border-blue-700' : ''} rounded-lg">
                <h5 class="font-semibold text-blue-900 ${isDarkMode ? 'dark:text-blue-100' : ''} mb-2">
                    <i class="fas fa-info-circle mr-2"></i>Manuel UTM Değerleri
                </h5>
                <div class="text-sm text-blue-800 ${isDarkMode ? 'dark:text-blue-200' : ''}">
                    ${manualUtmSource ? `<div>UTM Source: <strong>${manualUtmSource}</strong></div>` : ''}
                    ${manualUtmCampaign ? `<div>UTM Campaign: <strong>${manualUtmCampaign}</strong></div>` : ''}
                    <div class="mt-1 text-xs">Bu değerler tüm kayıtlara uygulanacak</div>
                </div>
            </div>
        `;
    }
    
    summaryContainer.innerHTML = summaryHTML;
}

function startImport() {
    if (!uploadedFile || excelData.length === 0) {
        showNotification('Önce bir dosya yükleyin.', 'error');
        return;
    }
    
    if (!columnMappings.email) {
        showNotification('E-posta alanı zorunludur.', 'error');
        return;
    }
    
    // Ad/Soyad kontrolü
    const hasName = columnMappings['name'];
    const hasFirstAndLastName = columnMappings['first_name'] && columnMappings['last_name'];
    if (!hasName && !hasFirstAndLastName) {
        showNotification('Ad Soyad alanı veya Ad+Soyad (ayrı) alanları zorunludur.', 'error');
        return;
    }
    
    // Show progress section
    document.getElementById('import-progress').classList.remove('hidden');
    document.getElementById('start-import').style.display = 'none';
    
    // Get manual UTM values
    const manualUtmSource = document.getElementById('manual-utm-source').value.trim();
    const manualUtmCampaign = document.getElementById('manual-utm-campaign').value.trim();
    
    // Prepare data for import
    const importData = {
        file: uploadedFile,
        mappings: columnMappings,
        settings: {
            skipDuplicates: document.getElementById('skip-duplicates').checked,
            sendWelcomeEmail: document.getElementById('send-welcome-email').checked,
            defaultLeadStatus: document.getElementById('default-lead-status').value,
            batchSize: parseInt(document.getElementById('batch-size').value),
            manualUtmSource: manualUtmSource || null,
            manualUtmCampaign: manualUtmCampaign || null
        }
    };
    
    // Start import process
    processImport(importData);
}

function processImport(importData) {
    const formData = new FormData();
    formData.append('file', importData.file);
    formData.append('mappings', JSON.stringify(importData.mappings));
    formData.append('settings', JSON.stringify(importData.settings));
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch('/admin/dashboard/users/import/process', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateProgress(100);
            showImportResults(data.results);
            document.getElementById('finish-import').style.display = 'inline-flex';
        } else {
            showNotification('İçe aktarma hatası: ' + data.message, 'error');
            document.getElementById('start-import').style.display = 'inline-flex';
        }
    })
    .catch(error => {
        console.error('Import error:', error);
        showNotification('İçe aktarma sırasında hata oluştu.', 'error');
        document.getElementById('start-import').style.display = 'inline-flex';
    });
}

function updateProgress(percentage) {
    document.getElementById('progress-bar').style.width = percentage + '%';
    document.getElementById('progress-percentage').textContent = percentage + '%';
}

function showImportResults(results) {
    document.getElementById('import-results').classList.remove('hidden');
    document.getElementById('processed-count').textContent = results.total || 0;
    document.getElementById('success-count').textContent = results.imported || 0;
    document.getElementById('error-count').textContent = results.errors || 0;
    
    const resultsContent = document.getElementById('results-content');
    let resultsHTML = '';
    
    if (results.imported > 0) {
        resultsHTML += `
            <div class="bg-green-50 ${isDarkMode ? 'dark:bg-green-900/20' : ''} border border-green-200 ${isDarkMode ? 'dark:border-green-700' : ''} rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <div>
                        <h5 class="font-semibold text-green-900 ${isDarkMode ? 'dark:text-green-100' : ''}">${results.imported} kullanıcı başarıyla içe aktarıldı</h5>
                        <p class="text-sm text-green-800 ${isDarkMode ? 'dark:text-green-200' : ''}">Tüm kullanıcılar sisteme kaydedildi ve varsayılan şifreler oluşturuldu.</p>
                    </div>
                </div>
            </div>
        `;
    }
    
    if (results.duplicates > 0) {
        resultsHTML += `
            <div class="bg-orange-50 ${isDarkMode ? 'dark:bg-orange-900/20' : ''} border border-orange-200 ${isDarkMode ? 'dark:border-orange-700' : ''} rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-copy text-orange-600 mr-3"></i>
                        <div>
                            <h5 class="font-semibold text-orange-900 ${isDarkMode ? 'dark:text-orange-100' : ''}">${results.duplicates} duplicate kullanıcı tespit edildi</h5>
                            <p class="text-sm text-orange-800 ${isDarkMode ? 'dark:text-orange-200' : ''}">E-posta veya telefon numarası sistemde zaten mevcut olan kayıtlar atlandı.</p>
                            ${results.duplicateDetails && results.duplicateDetails.length > 0 ? `
                                <div class="mt-2 max-h-24 overflow-y-auto">
                                    ${results.duplicateDetails.slice(0, 3).map(dup => `
                                        <div class="text-xs text-orange-700 ${isDarkMode ? 'dark:text-orange-300' : ''} mb-1">
                                            Satır ${dup.row}: ${dup.email} (${dup.type})
                                        </div>
                                    `).join('')}
                                    ${results.duplicateDetails.length > 3 ? `
                                        <div class="text-xs text-orange-600 ${isDarkMode ? 'dark:text-orange-400' : ''} font-semibold">
                                            ... ve ${results.duplicateDetails.length - 3} kayıt daha
                                        </div>
                                    ` : ''}
                                </div>
                            ` : ''}
                        </div>
                    </div>
                    ${results.duplicateFile ? `
                        <a href="${results.duplicateFile.url}"
                           class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
                            <i class="fas fa-download mr-2"></i>
                            Duplicate Excel İndir
                        </a>
                    ` : ''}
                </div>
            </div>
        `;
    }
    
    if (results.skipped > 0) {
        resultsHTML += `
            <div class="bg-yellow-50 ${isDarkMode ? 'dark:bg-yellow-900/20' : ''} border border-yellow-200 ${isDarkMode ? 'dark:border-yellow-700' : ''} rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                    <div>
                        <h5 class="font-semibold text-yellow-900 ${isDarkMode ? 'dark:text-yellow-100' : ''}">${results.skipped} kayıt atlandı</h5>
                        <p class="text-sm text-yellow-800 ${isDarkMode ? 'dark:text-yellow-200' : ''}">Çeşitli nedenlerle işlenemeyen kayıtlar.</p>
                    </div>
                </div>
            </div>
        `;
    }
    
    if (results.errors > 0 && results.errorDetails) {
        resultsHTML += `
            <div class="bg-red-50 ${isDarkMode ? 'dark:bg-red-900/20' : ''} border border-red-200 ${isDarkMode ? 'dark:border-red-700' : ''} rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-red-600 mr-3 mt-1"></i>
                    <div class="flex-1">
                        <h5 class="font-semibold text-red-900 ${isDarkMode ? 'dark:text-red-100' : ''} mb-2">${results.errors} kayıtta hata oluştu</h5>
                        <div class="max-h-32 overflow-y-auto">
                            ${results.errorDetails.slice(0, 5).map(error => `
                                <div class="text-sm text-red-800 ${isDarkMode ? 'dark:text-red-200' : ''} mb-1">
                                    Satır ${error.row}: ${error.errors.join(', ')}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    resultsContent.innerHTML = resultsHTML;
}

function finishImport() {
    window.location.href = '{{ route("manageusers") }}';
}

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 transition-all duration-300 ${
        type === 'success' ? 'bg-green-600 text-white' :
        type === 'error' ? 'bg-red-600 text-white' :
        type === 'warning' ? 'bg-yellow-600 text-white' : 'bg-blue-600 text-white'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 4000);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateStepIndicators(1);
});
</script>

<style>
.step-indicator.active .w-10 {
    background-color: #2563eb !important;
    color: white !important;
}

.excel-column:hover {
    transform: translateY(-2px);
}

.system-field.drag-over {
    border-color: #3b82f6 !important;
    background-color: #eff6ff !important;
}

.mapped-indicator {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection