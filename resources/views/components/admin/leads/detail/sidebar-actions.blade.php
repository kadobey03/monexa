@props([
    'lead',
    'availableActions' => [],
    'admin'
])

<div class="sidebar-actions-container w-80 bg-gray-50 border-l border-gray-200 overflow-y-auto sticky top-0" style="height: calc(100vh - 64px);">
    <div class="sticky top-0 bg-gray-50 border-b border-gray-200 p-4 z-10">
        <h3 class="font-semibold text-gray-900 flex items-center">
            <i class="fas fa-bolt mr-2 text-yellow-500"></i>
            Hızlı İşlemler
        </h3>
        <p class="text-sm text-gray-600 mt-1">Lead yönetimi için hızlı erişim</p>
    </div>

    {{-- 1. Giriş Aktivitesi İzleme --}}
    <div class="action-section border-b border-gray-200">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="login-activity">
            <div class="action-icon bg-blue-100 text-blue-600 rounded-lg p-3 mr-3">
                <i class="fas fa-sign-in-alt"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">Giriş Aktivitesi İzleme</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Son giriş aktivitelerini görüntüle</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- 2. Yasakla/Devre Dışı Bırak --}}
    <div class="action-section border-b border-gray-200">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="block-user">
            <div class="action-icon bg-red-100 text-red-600 rounded-lg p-3 mr-3">
                <i class="fas fa-ban"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">Yasakla/Devre Dışı Bırak</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Hesabı geçici veya kalıcı devre dışı bırak</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- 3. Kredi/Debit İşlemleri --}}
    <div class="action-section border-b border-gray-200">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="credit-debit">
            <div class="action-icon bg-green-100 text-green-600 rounded-lg p-3 mr-3">
                <i class="fas fa-coins"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">Kredi/Debit İşlemleri</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Bakiye işlemleri ve finansal hareketler</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- 4. Lead Bilgilerini Düzenle --}}
    <div class="action-section border-b border-gray-200">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="edit-lead">
            <div class="action-icon bg-yellow-100 text-yellow-600 rounded-lg p-3 mr-3">
                <i class="fas fa-edit"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">Lead Bilgilerini Düzenle</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Kişisel bilgileri ve tercihleri güncelle</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- 5. Manuel İşlem Yapma --}}
    <div class="action-section border-b border-gray-200">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="manual-transaction">
            <div class="action-icon bg-purple-100 text-purple-600 rounded-lg p-3 mr-3">
                <i class="fas fa-hand-paper"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">Manuel İşlem Yapma</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Özel işlemler ve manuel müdahaleler</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- 6. Sinyal/Alert Oluşturma --}}
    <div class="action-section border-b border-gray-200">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="create-alert">
            <div class="action-icon bg-orange-100 text-orange-600 rounded-lg p-3 mr-3">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">Sinyal/Alert Oluşturma</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Otomatik uyarılar ve bildirimler ayarla</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- 7. E-posta Gönderimi --}}
    <div class="action-section border-b border-gray-200">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="send-email">
            <div class="action-icon bg-indigo-100 text-indigo-600 rounded-lg p-3 mr-3">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">E-posta Gönderimi</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Kişiselleştirilmiş e-posta şablonları</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- 8. Push/SMS Bildirimi --}}
    <div class="action-section border-b border-gray-200">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="push-sms">
            <div class="action-icon bg-pink-100 text-pink-600 rounded-lg p-3 mr-3">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">Push/SMS Bildirimi</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Anında bildirimler gönder</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- 9. Vergi Hesaplamaları --}}
    <div class="action-section border-b border-gray-200">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="tax-calculations">
            <div class="action-icon bg-teal-100 text-teal-600 rounded-lg p-3 mr-3">
                <i class="fas fa-calculator"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">Vergi Hesaplamaları</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Vergi oranları ve hesaplamalar</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- 10. Para Çekme Kodu Üretimi --}}
    <div class="action-section border-b border-gray-200">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="withdrawal-code">
            <div class="action-icon bg-cyan-100 text-cyan-600 rounded-lg p-3 mr-3">
                <i class="fas fa-qrcode"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">Para Çekme Kodu Üretimi</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Güvenli çekim kodları oluştur</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- 11. İşlem Limit Belirleme --}}
    <div class="action-section border-b border-gray-200">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="set-limits">
            <div class="action-icon bg-gray-100 text-gray-600 rounded-lg p-3 mr-3">
                <i class="fas fa-sliders-h"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">İşlem Limit Belirleme</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Günlük/haftalık işlem limitleri</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- 12. Lead Hesabına Admin Geçiş --}}
    <div class="action-section">
        <button class="action-button w-full p-4 text-left hover:bg-gray-100 transition-colors flex items-center"
                data-action="admin-switch">
            <div class="action-icon bg-red-100 text-red-600 rounded-lg p-3 mr-3">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="action-content flex-1">
                <div class="action-title font-medium text-gray-900 text-sm">Lead Hesabına Admin Geçiş</div>
                <div class="action-subtitle text-xs text-gray-600 mt-1">Admin yetkisi ile hesaba geçiş yap</div>
            </div>
            <i class="fas fa-chevron-right text-gray-400 ml-2"></i>
        </button>
    </div>

    {{-- Quick Stats Footer --}}
    <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 p-4 mt-4">
        <div class="grid grid-cols-2 gap-3 text-center">
            <div class="stat-item">
                <div class="text-lg font-bold text-blue-600">{{ count($lead->contact_history ?? []) }}</div>
                <div class="text-xs text-gray-600">İletişim</div>
            </div>
            <div class="stat-item">
                <div class="text-lg font-bold text-green-600">{{ $lead->created_at->diffInDays() }}</div>
                <div class="text-xs text-gray-600">Gün</div>
            </div>
        </div>
    </div>
</div>