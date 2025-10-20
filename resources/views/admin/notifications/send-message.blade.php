@extends('layouts.app')
@section('title', 'Kullanıcıya Mesaj Gönder')

@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <!-- Header Section -->
                <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-2xl p-8 mb-8">
                    <div class="absolute inset-0 bg-black opacity-20"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/10 to-purple-600/10"></div>
                    <div class="relative">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <h1 class="text-4xl font-bold text-white mb-2">
                                    <i class="fas fa-paper-plane mr-3 text-indigo-200"></i>
                                    Kullanıcıya Mesaj Gönder
                                </h1>
                                <p class="text-indigo-100 text-lg">
                                    Seçtiğiniz kullanıcıya özel bildirim mesajı gönderin
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('admin.notifications') }}"
                                   class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-xl hover:bg-white/30 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Bildirimlere Dön
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -right-16 -bottom-16 w-32 h-32 bg-gradient-to-br from-white/10 to-pink-300/20 rounded-full blur-2xl"></div>
                    <div class="absolute -left-16 -top-16 w-24 h-24 bg-gradient-to-br from-purple-400/20 to-indigo-400/20 rounded-full blur-xl"></div>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Message Form -->
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-envelope mr-3 text-blue-600"></i>
                                Mesaj Oluştur
                            </h3>
                            <p class="text-gray-600 mt-1">Kullanıcıya gönderilecek bildirimi hazırlayın</p>
                        </div>

                        <div class="p-8">
                            <form method="POST" action="{{ route('admin.send.message') }}" id="messageForm">
                                @csrf
                                <div class="space-y-6">
                                    <!-- User Selection -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                                            <i class="fas fa-user mr-2 text-gray-400"></i>
                                            Alıcı Kullanıcı
                                        </label>
                                        <select name="user_id"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white"
                                                required>
                                            <option value="">Kullanıcı seçiniz...</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"
                                                        data-email="{{ $user->email }}"
                                                        data-name="{{ $user->name }}">
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="mt-2 text-sm text-gray-500">Mesaj gönderilecek kullanıcıyı seçin</p>
                                    </div>

                                    <!-- Message Type -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                                            <i class="fas fa-tag mr-2 text-gray-400"></i>
                                            Mesaj Türü
                                        </label>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            <label class="relative cursor-pointer">
                                                <input type="radio" name="type" value="info" class="sr-only peer" checked>
                                                <div class="p-4 bg-blue-50 border-2 border-blue-200 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-100 hover:bg-blue-100 transition-all duration-200">
                                                    <div class="flex items-center justify-center mb-2">
                                                        <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="font-semibold text-blue-900 text-sm">Bilgi</div>
                                                    </div>
                                                </div>
                                            </label>

                                            <label class="relative cursor-pointer">
                                                <input type="radio" name="type" value="success" class="sr-only peer">
                                                <div class="p-4 bg-green-50 border-2 border-green-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-100 hover:bg-green-100 transition-all duration-200">
                                                    <div class="flex items-center justify-center mb-2">
                                                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="font-semibold text-green-900 text-sm">Başarılı</div>
                                                    </div>
                                                </div>
                                            </label>

                                            <label class="relative cursor-pointer">
                                                <input type="radio" name="type" value="warning" class="sr-only peer">
                                                <div class="p-4 bg-yellow-50 border-2 border-yellow-200 rounded-xl peer-checked:border-yellow-500 peer-checked:bg-yellow-100 hover:bg-yellow-100 transition-all duration-200">
                                                    <div class="flex items-center justify-center mb-2">
                                                        <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="font-semibold text-yellow-900 text-sm">Uyarı</div>
                                                    </div>
                                                </div>
                                            </label>

                                            <label class="relative cursor-pointer">
                                                <input type="radio" name="type" value="danger" class="sr-only peer">
                                                <div class="p-4 bg-red-50 border-2 border-red-200 rounded-xl peer-checked:border-red-500 peer-checked:bg-red-100 hover:bg-red-100 transition-all duration-200">
                                                    <div class="flex items-center justify-center mb-2">
                                                        <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="font-semibold text-red-900 text-sm">Önemli</div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Message Title -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                                            <i class="fas fa-heading mr-2 text-gray-400"></i>
                                            Mesaj Başlığı
                                        </label>
                                        <input type="text" name="title"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Mesaj başlığını giriniz..." required>
                                        <p class="mt-2 text-sm text-gray-500">Kısa ve açık bir başlık yazın</p>
                                    </div>

                                    <!-- Message Content -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                                            <i class="fas fa-comment mr-2 text-gray-400"></i>
                                            Mesaj İçeriği
                                        </label>
                                        <textarea name="message" rows="6"
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                                                  placeholder="Kullanıcıya gönderilecek mesajı yazınız..." required></textarea>
                                        <p class="mt-2 text-sm text-gray-500">Detaylı ve anlaşılır bir mesaj yazın</p>
                                    </div>

                                    <!-- Message Preview -->
                                    <div id="messagePreview" class="hidden">
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                                            <i class="fas fa-eye mr-2 text-gray-400"></i>
                                            Mesaj Önizleme
                                        </label>
                                        <div class="border border-gray-200 rounded-xl p-4 bg-gray-50">
                                            <div class="flex items-start space-x-4">
                                                <div id="previewIcon" class="w-8 h-8 rounded-full flex items-center justify-center"></div>
                                                <div class="flex-1">
                                                    <h4 id="previewTitle" class="font-semibold text-gray-900"></h4>
                                                    <p id="previewMessage" class="text-gray-600 mt-1"></p>
                                                    <p id="previewUser" class="text-sm text-gray-500 mt-2"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                                        <button type="button" onclick="togglePreview()"
                                                class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
                                            <i class="fas fa-eye mr-2"></i>
                                            Önizle
                                        </button>
                                        <button type="submit"
                                                class="px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-purple-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-lg hover:shadow-xl">
                                            <i class="fas fa-paper-plane mr-2"></i>
                                            Mesaj Gönder
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <i class="fas fa-magic mr-3 text-purple-600"></i>
                                Hızlı Mesaj Şablonları
                            </h3>
                            <p class="text-gray-600 mt-1">Sık kullanılan mesaj şablonlarını seçin</p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <button onclick="useTemplate('welcome')"
                                        class="p-4 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 transition-colors duration-200 text-left">
                                    <div class="font-semibold text-blue-900">Hoş Geldin Mesajı</div>
                                    <div class="text-sm text-blue-700 mt-1">Yeni kullanıcılar için karşılama mesajı</div>
                                </button>
                                <button onclick="useTemplate('security')"
                                        class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl hover:bg-yellow-100 transition-colors duration-200 text-left">
                                    <div class="font-semibold text-yellow-900">Güvenlik Uyarısı</div>
                                    <div class="text-sm text-yellow-700 mt-1">Güvenlik ile ilgili önemli bildirim</div>
                                </button>
                                <button onclick="useTemplate('maintenance')"
                                        class="p-4 bg-orange-50 border border-orange-200 rounded-xl hover:bg-orange-100 transition-colors duration-200 text-left">
                                    <div class="font-semibold text-orange-900">Bakım Bildirimi</div>
                                    <div class="text-sm text-orange-700 mt-1">Sistem bakımı hakkında bilgilendirme</div>
                                </button>
                                <button onclick="useTemplate('promotion')"
                                        class="p-4 bg-green-50 border border-green-200 rounded-xl hover:bg-green-100 transition-colors duration-200 text-left">
                                    <div class="font-semibold text-green-900">Promosyon Bildirimi</div>
                                    <div class="text-sm text-green-700 mt-1">Özel kampanya ve fırsatlar</div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Message templates
        const templates = {
            welcome: {
                title: 'Hoş Geldiniz!',
                message: 'Platformumuza hoş geldiniz! Hesabınız başarıyla oluşturulmuştur. Herhangi bir sorunuz olursa destek ekibimizle iletişime geçebilirsiniz.',
                type: 'success'
            },
            security: {
                title: 'Güvenlik Uyarısı',
                message: 'Hesabınızın güvenliği için lütfen şifrenizi düzenli olarak değiştirin ve iki faktörlü kimlik doğrulamayı aktif hale getirin.',
                type: 'warning'
            },
            maintenance: {
                title: 'Sistem Bakımı',
                message: 'Sistemimizde planlı bakım çalışması yapılacaktır. Bakım süresince hizmetlerimizde kısa süreli kesintiler yaşanabilir.',
                type: 'info'
            },
            promotion: {
                title: 'Özel Kampanya!',
                message: 'Size özel hazırladığımız kampanyalardan yararlanmak için hesabınıza giriş yapın ve fırsatları kaçırmayın!',
                type: 'success'
            }
        };

        function useTemplate(templateKey) {
            const template = templates[templateKey];
            if (template) {
                document.querySelector('input[name="title"]').value = template.title;
                document.querySelector('textarea[name="message"]').value = template.message;
                document.querySelector(`input[name="type"][value="${template.type}"]`).checked = true;
                updatePreview();
            }
        }

        function togglePreview() {
            const preview = document.getElementById('messagePreview');
            if (preview.classList.contains('hidden')) {
                updatePreview();
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }

        function updatePreview() {
            const title = document.querySelector('input[name="title"]').value;
            const message = document.querySelector('textarea[name="message"]').value;
            const type = document.querySelector('input[name="type"]:checked').value;
            const userId = document.querySelector('select[name="user_id"]').value;
            const userOption = document.querySelector(`option[value="${userId}"]`);
            
            const typeConfig = {
                'info': { icon: 'fas fa-info-circle', color: 'bg-blue-100 text-blue-600' },
                'success': { icon: 'fas fa-check-circle', color: 'bg-green-100 text-green-600' },
                'warning': { icon: 'fas fa-exclamation-triangle', color: 'bg-yellow-100 text-yellow-600' },
                'danger': { icon: 'fas fa-times-circle', color: 'bg-red-100 text-red-600' }
            };

            const config = typeConfig[type];
            
            document.getElementById('previewIcon').className = `w-8 h-8 rounded-full flex items-center justify-center ${config.color}`;
            document.getElementById('previewIcon').innerHTML = `<i class="${config.icon}"></i>`;
            document.getElementById('previewTitle').textContent = title || 'Mesaj Başlığı';
            document.getElementById('previewMessage').textContent = message || 'Mesaj içeriği buraya gelecek...';
            document.getElementById('previewUser').textContent = userOption ? `Alıcı: ${userOption.textContent}` : 'Alıcı seçilmedi';
        }

        // Form submission with loading state
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Gönderiliyor...';
            submitBtn.disabled = true;
            
            // Re-enable button after 10 seconds as fallback
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 10000);
        });

        // Real-time preview updates
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('input[name="title"]').addEventListener('input', updatePreview);
            document.querySelector('textarea[name="message"]').addEventListener('input', updatePreview);
            document.querySelectorAll('input[name="type"]').forEach(radio => {
                radio.addEventListener('change', updatePreview);
            });
            document.querySelector('select[name="user_id"]').addEventListener('change', updatePreview);
        });
    </script>

    <style>
        @media (max-width: 768px) {
            .grid-cols-2.md\\:grid-cols-4 {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .grid-cols-1.md\\:grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
