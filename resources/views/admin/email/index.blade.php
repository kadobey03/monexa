@extends('layouts.admin')

@section('content')
@section('styles')
@parent
<style>
    .form-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .form-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .category-icon, .user-icon, .greeting-icon, .subject-icon, .message-icon {
        flex-shrink: 0;
    }
</style>
@endsection

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between bg-gradient-to-r from-blue-600 via-blue-700 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <x-heroicon name="envelope" class="w-8 h-8 text-white" />
            </div>
            <div>
                <h1 class="text-3xl font-bold mb-1">E-posta Servisleri</h1>
                <p class="text-blue-100 text-lg">Kullanıcılara toplu e-posta gönderin ve yönetin</p>
            </div>
        </div>
        <div>
            <a href='https://t.me/+VRumJJSKKGdjM2I0' 
               class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 rounded-xl text-white font-semibold transition-all duration-200 backdrop-blur-sm">
                <x-heroicon name="message-circle" class="w-5 h-5 mr-2" />
                Yardım Al
            </a>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<x-danger-alert />
<x-success-alert />

<!-- Email Form -->
<div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6">
        <div class="flex items-center space-x-3">
            <x-heroicon name="send" class="w-6 h-6 text-white" />
            <h2 class="text-xl font-bold text-white">E-posta Oluşturma Formu</h2>
        </div>
    </div>
    
    <div class="p-8">
        <form method="post" action="{{ route('sendmailtoall') }}" class="space-y-8">
            @csrf

            <!-- Category Selection -->
            <div class="form-card bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 p-6 rounded-xl border border-blue-200 dark:border-blue-700">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="category-icon w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center">
                        <x-heroicon name="users" class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">Alıcı Kategorisi</h3>
                        <p class="text-blue-700 dark:text-blue-300">E-posta gönderilecek kullanıcı grubunu seçin</p>
                    </div>
                </div>
                <select class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-admin-900 dark:text-admin-100" id="category" name="category">
                    <option value="All">🌐 Tüm Kullanıcılar</option>
                    <option value="No active plans">📊 Aktif yatırım planı olmayan kullanıcılar</option>
                    <option value="No deposit">💰 Herhangi bir yatırımı olmayan kullanıcılar</option>
                    <option value="Select Users">👤 Kullanıcıları Manuel Seç</option>
                </select>
            </div>

            <!-- User Selection (Hidden by default) -->
            <div class="form-card hidden bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 p-6 rounded-xl border border-amber-200 dark:border-amber-700" id="select-user-view">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="user-icon w-12 h-12 bg-amber-600 text-white rounded-xl flex items-center justify-center">
                        <x-heroicon name="user-check" class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-amber-900 dark:text-amber-100">Kullanıcı Seçimi</h3>
                        <p class="text-amber-700 dark:text-amber-300">Gönderilecek kullanıcıları seçin (<span class="text-blue-600 dark:text-blue-400 font-semibold" id="numofusers">0</span> kişi seçildi)</p>
                    </div>
                </div>
                <select onChange="SelectPage(this)" name="users[]" multiple class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 text-admin-900 dark:text-admin-100 select2" id="showusers"></select>
            </div>

            <!-- Greeting Fields -->
            <div class="form-card bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 p-6 rounded-xl border border-emerald-200 dark:border-emerald-700">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="greeting-icon w-12 h-12 bg-emerald-600 text-white rounded-xl flex items-center justify-center">
                        <x-heroicon name="hand" class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-emerald-900 dark:text-emerald-100">Selamlama ve Başlık</h3>
                        <p class="text-emerald-700 dark:text-emerald-300">E-postanın başlangıç selamlaması</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" value="Merhaba" name="greet" class="px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-admin-900 dark:text-admin-100" placeholder="Selamlama (örn: Merhaba)">
                    <input type="text" value="Yatırımcı" name="title" class="px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-admin-900 dark:text-admin-100" placeholder="Başlık (örn: Değerli Yatırımcı)">
                </div>
            </div>

            <!-- Subject Field -->
            <div class="form-card bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 p-6 rounded-xl border border-cyan-200 dark:border-cyan-700">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="subject-icon w-12 h-12 bg-cyan-600 text-white rounded-xl flex items-center justify-center">
                        <x-heroicon name="type" class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-cyan-900 dark:text-cyan-100">E-posta Konusu</h3>
                        <p class="text-cyan-700 dark:text-cyan-300">Alıcıların göreceği konu başlığı</p>
                    </div>
                </div>
                <input type="text" name="subject" class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 text-admin-900 dark:text-admin-100" placeholder="E-posta konusu..." required>
            </div>

            <!-- Message Field -->
            <div class="form-card bg-gradient-to-br from-rose-50 to-pink-50 dark:from-rose-900/20 dark:to-pink-900/20 p-6 rounded-xl border border-rose-200 dark:border-rose-700">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="message-icon w-12 h-12 bg-rose-600 text-white rounded-xl flex items-center justify-center">
                        <x-heroicon name="file-text" class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-rose-900 dark:text-rose-100">E-posta Mesajı</h3>
                        <p class="text-rose-700 dark:text-rose-300">Gönderilecek e-posta içeriği</p>
                    </div>
                </div>
                <textarea placeholder="E-posta mesajınızı buraya yazın..." class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 text-admin-900 dark:text-admin-100 ckeditor" name="message" rows="8" required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-center pt-4">
                <button type="submit" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                    <x-heroicon name="send" class="w-5 h-5 mr-2" />
                    E-postayı Gönder
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<!-- CKEditor -->

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize CKEditor
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace('message', {
            height: 300,
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    }

    // Initialize Select2
    $('.select2').select2({
        placeholder: 'Kullanıcıları seçin...',
        allowClear: true,
        width: '100%'
    });

    // Category change handler
    const category = document.querySelector("#category");
    const selectUserView = document.querySelector("#select-user-view");
    
    // Initial state
    if (category.value == "Select Users") {
        selectUserView.classList.remove("hidden");
    } else {
        selectUserView.classList.add("hidden");
    }

    category.addEventListener('change', function() {
        if (this.value == "Select Users") {
            selectUserView.classList.remove("hidden");
            
            // Load users if not already loaded
            const usersSelect = document.querySelector('#showusers');
            if (usersSelect.children.length === 0) {
                fetch("{{ route('fetchusers') }}")
                    .then(response => response.json())
                    .then(data => {
                        data.data.forEach(element => {
                            const option = document.createElement('option');
                            option.value = element.id;
                            option.textContent = element.name;
                            usersSelect.appendChild(option);
                        });
                        // Reinitialize Select2 after adding options
                        $(usersSelect).trigger('change');
                    })
                    .catch(error => {
                        console.error('Error fetching users:', error);
                    });
            }
        } else {
            selectUserView.classList.add("hidden");
        }
    });

    // Update selected users count
    window.SelectPage = function(elem) {
        const options = elem.options;
        let count = 0;
        for (let i = 0; i < options.length; i++) {
            if (options[i].selected) count++;
        }
        document.querySelector("#numofusers").textContent = count;
    };

    // Initialize Lucide icons after content is loaded
    if (typeof lucide !== 'undefined') {
        
    }
});
</script>
@endpush