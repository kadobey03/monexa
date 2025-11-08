@props(['lead'])

{{-- Communication Modal --}}
<div id="communicationModal" class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="modal-dialog relative top-20 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white">
        <div class="modal-content">
            {{-- Modal Header --}}
            <div class="modal-header flex items-center justify-between pb-3 border-b border-gray-200">
                <h3 class="modal-title text-lg font-semibold text-gray-900">
                    <i class="fas fa-comments text-blue-500 mr-2"></i>
                    İletişim Merkezi
                </h3>
                <button type="button" class="modal-close text-gray-400 hover:text-gray-600" data-modal="communicationModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body py-4">
                {{-- Communication Tabs --}}
                <div class="communication-tabs border-b border-gray-200 mb-4">
                    <div class="flex space-x-1">
                        <button class="comm-tab-btn px-4 py-2 text-sm font-medium border-b-2 border-blue-500 text-blue-600 bg-blue-50" 
                                data-tab="send">
                            <i class="fas fa-paper-plane mr-1"></i>
                            Mesaj Gönder
                        </button>
                        <button class="comm-tab-btn px-4 py-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700" 
                                data-tab="history">
                            <i class="fas fa-history mr-1"></i>
                            İletişim Geçmişi
                        </button>
                        <button class="comm-tab-btn px-4 py-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700" 
                                data-tab="templates">
                            <i class="fas fa-file-alt mr-1"></i>
                            Şablonlar
                        </button>
                    </div>
                </div>

                {{-- Send Message Tab --}}
                <div class="comm-tab-pane active" data-tab-content="send">
                    <form id="communicationForm" data-lead-id="{{ $lead->id }}">
                        @csrf
                        
                        {{-- Communication Method --}}
                        <div class="form-group mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                İletişim Yöntemi
                            </label>
                            <div class="grid grid-cols-4 gap-3">
                                <label class="comm-method-option flex items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors">
                                    <input type="radio" name="method" value="email" class="sr-only">
                                    <div class="text-center">
                                        <i class="fas fa-envelope text-2xl text-blue-500 mb-1"></i>
                                        <div class="text-sm font-medium">E-posta</div>
                                    </div>
                                </label>
                                <label class="comm-method-option flex items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-300 transition-colors">
                                    <input type="radio" name="method" value="whatsapp" class="sr-only">
                                    <div class="text-center">
                                        <i class="fab fa-whatsapp text-2xl text-green-500 mb-1"></i>
                                        <div class="text-sm font-medium">WhatsApp</div>
                                    </div>
                                </label>
                                <label class="comm-method-option flex items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-300 transition-colors">
                                    <input type="radio" name="method" value="sms" class="sr-only">
                                    <div class="text-center">
                                        <i class="fas fa-sms text-2xl text-purple-500 mb-1"></i>
                                        <div class="text-sm font-medium">SMS</div>
                                    </div>
                                </label>
                                <label class="comm-method-option flex items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-orange-300 transition-colors">
                                    <input type="radio" name="method" value="call" class="sr-only">
                                    <div class="text-center">
                                        <i class="fas fa-phone text-2xl text-orange-500 mb-1"></i>
                                        <div class="text-sm font-medium">Arama</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Recipient Info --}}
                        <div class="recipient-info bg-gray-50 rounded-lg p-3 mb-4">
                            <div class="flex items-center">
                                <div class="recipient-avatar w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                    {{ strtoupper(substr($lead->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $lead->name }}</div>
                                    <div class="text-sm text-gray-600" id="recipientContact">{{ $lead->email }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Subject (for email) --}}
                        <div class="form-group mb-4 hidden" id="subjectGroup">
                            <label for="messageSubject" class="block text-sm font-medium text-gray-700 mb-2">
                                Konu
                            </label>
                            <input type="text" 
                                   id="messageSubject" 
                                   name="subject" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="E-posta konusu">
                        </div>

                        {{-- Message Content --}}
                        <div class="form-group mb-4">
                            <label for="messageContent" class="block text-sm font-medium text-gray-700 mb-2">
                                Mesaj İçeriği *
                            </label>
                            <textarea id="messageContent" 
                                      name="content" 
                                      rows="8" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                      placeholder="Mesajınızı buraya yazın..."
                                      required></textarea>
                            <div class="mt-1 flex justify-between text-sm text-gray-500">
                                <span>Şablon kullanmak için sağ üstteki "Şablonlar" sekmesini kullanın</span>
                                <span id="messageCharCount">0 karakter</span>
                            </div>
                        </div>

                        {{-- Attachments (for email) --}}
                        <div class="form-group mb-4 hidden" id="attachmentsGroup">
                            <label for="messageAttachments" class="block text-sm font-medium text-gray-700 mb-2">
                                Ekler
                            </label>
                            <input type="file" 
                                   id="messageAttachments" 
                                   name="attachments[]" 
                                   multiple
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <div class="mt-1 text-sm text-gray-500">
                                Maksimum 5 dosya, toplamda 10MB
                            </div>
                        </div>

                        {{-- Send Options --}}
                        <div class="send-options bg-blue-50 rounded-lg p-3 mb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="schedule_send" class="mr-2 text-blue-600">
                                        <span class="text-sm text-gray-700">Zamanla gönder</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="save_template" class="mr-2 text-blue-600">
                                        <span class="text-sm text-gray-700">Şablon olarak kaydet</span>
                                    </label>
                                </div>
                                <div class="text-sm text-blue-600">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    İletişim kaydedilecek
                                </div>
                            </div>
                            
                            {{-- Schedule Send Options --}}
                            <div id="scheduleOptions" class="mt-3 hidden">
                                <input type="datetime-local" 
                                       name="scheduled_at" 
                                       class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Communication History Tab --}}
                <div class="comm-tab-pane hidden" data-tab-content="history">
                    <div class="communication-history">
                        <div class="history-filters mb-4 flex items-center space-x-4">
                            <select class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                <option value="">Tüm İletişimler</option>
                                <option value="email">E-posta</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="sms">SMS</option>
                                <option value="call">Arama</option>
                            </select>
                            <input type="date" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                            <button class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300">
                                <i class="fas fa-search mr-1"></i>
                                Filtrele
                            </button>
                        </div>

                        <div class="history-timeline space-y-4 max-h-96 overflow-y-auto">
                            {{-- Sample history items --}}
                            <div class="history-item flex items-start space-x-3 p-3 border border-gray-200 rounded-lg">
                                <div class="history-icon w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-envelope text-blue-600 text-xs"></i>
                                </div>
                                <div class="history-content flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-medium text-gray-900">E-posta Gönderildi</span>
                                        <span class="text-sm text-gray-500">2 saat önce</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">Konu: Yatırım fırsatları hakkında</p>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Gönderildi</span>
                                        <button class="text-blue-600 text-xs hover:underline">Detayları Gör</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="empty-history text-center py-8 text-gray-500">
                                <i class="fas fa-history text-3xl mb-2"></i>
                                <p>İletişim geçmişi yükleniyor...</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Templates Tab --}}
                <div class="comm-tab-pane hidden" data-tab-content="templates">
                    <div class="templates-section">
                        <div class="templates-grid grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Sample templates --}}
                            <div class="template-card border border-gray-200 rounded-lg p-3 hover:border-blue-300 cursor-pointer">
                                <div class="template-header flex items-center justify-between mb-2">
                                    <span class="font-medium text-gray-900">Hoş Geldiniz</span>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">E-posta</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">Yeni lead'ler için karşılama mesajı</p>
                                <button class="text-blue-600 text-sm hover:underline" onclick="useTemplate('welcome')">
                                    Şablonu Kullan
                                </button>
                            </div>

                            <div class="template-card border border-gray-200 rounded-lg p-3 hover:border-blue-300 cursor-pointer">
                                <div class="template-header flex items-center justify-between mb-2">
                                    <span class="font-medium text-gray-900">Takip Mesajı</span>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">WhatsApp</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">İlk görüşme sonrası takip</p>
                                <button class="text-blue-600 text-sm hover:underline" onclick="useTemplate('followup')">
                                    Şablonu Kullan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer flex items-center justify-between pt-3 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Tüm iletişimler şifrelenir ve kaydedilir
                </div>
                <div class="flex space-x-2">
                    <button type="button" class="btn-secondary px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300" 
                            data-modal="communicationModal">
                        İptal
                    </button>
                    <button type="submit" form="communicationForm" class="btn-primary px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fas fa-paper-plane mr-1"></i>
                        Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeCommunicationModal();
});

function initializeCommunicationModal() {
    // Tab switching
    const tabButtons = document.querySelectorAll('.comm-tab-btn');
    const tabPanes = document.querySelectorAll('.comm-tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;

            // Remove active classes
            tabButtons.forEach(btn => {
                btn.classList.remove('border-blue-500', 'text-blue-600', 'bg-blue-50');
                btn.classList.add('border-transparent', 'text-gray-500');
            });
            
            tabPanes.forEach(pane => {
                pane.classList.add('hidden');
                pane.classList.remove('active');
            });

            // Add active classes
            this.classList.add('border-blue-500', 'text-blue-600', 'bg-blue-50');
            this.classList.remove('border-transparent', 'text-gray-500');

            // Show target pane
            const targetPane = document.querySelector(`[data-tab-content="${targetTab}"]`);
            if (targetPane) {
                targetPane.classList.remove('hidden');
                targetPane.classList.add('active');
            }
        });
    });

    // Communication method selection
    const methodOptions = document.querySelectorAll('.comm-method-option');
    const recipientContact = document.getElementById('recipientContact');
    const subjectGroup = document.getElementById('subjectGroup');
    const attachmentsGroup = document.getElementById('attachmentsGroup');

    methodOptions.forEach(option => {
        option.addEventListener('click', function() {
            const input = this.querySelector('input[type="radio"]');
            const method = input.value;

            // Remove active class from all options
            methodOptions.forEach(opt => opt.classList.remove('border-blue-500', 'bg-blue-50'));
            
            // Add active class to selected option
            this.classList.add('border-blue-500', 'bg-blue-50');
            input.checked = true;

            // Update recipient contact and show/hide fields
            switch(method) {
                case 'email':
                    recipientContact.textContent = '{{ $lead->email }}';
                    subjectGroup.classList.remove('hidden');
                    attachmentsGroup.classList.remove('hidden');
                    break;
                case 'whatsapp':
                case 'sms':
                case 'call':
                    recipientContact.textContent = '{{ $lead->phone }}';
                    subjectGroup.classList.add('hidden');
                    attachmentsGroup.classList.add('hidden');
                    break;
            }
        });
    });

    // Character count
    const messageContent = document.getElementById('messageContent');
    const charCount = document.getElementById('messageCharCount');
    
    if (messageContent && charCount) {
        messageContent.addEventListener('input', function() {
            charCount.textContent = `${this.value.length} karakter`;
        });
    }

    // Schedule send toggle
    const scheduleCheckbox = document.querySelector('input[name="schedule_send"]');
    const scheduleOptions = document.getElementById('scheduleOptions');
    
    if (scheduleCheckbox && scheduleOptions) {
        scheduleCheckbox.addEventListener('change', function() {
            if (this.checked) {
                scheduleOptions.classList.remove('hidden');
            } else {
                scheduleOptions.classList.add('hidden');
            }
        });
    }

    // Form submission
    const communicationForm = document.getElementById('communicationForm');
    if (communicationForm) {
        communicationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const leadId = this.dataset.leadId;
            
            // Show loading state
            const submitBtn = document.querySelector('button[type="submit"][form="communicationForm"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Gönderiliyor...';
            submitBtn.disabled = true;
            
            fetch(`/admin/api/leads/${leadId}/communication`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Mesaj başarıyla gönderildi', 'success');
                    closeModal('communicationModal');
                    this.reset();
                    
                    // Reset method selection
                    methodOptions.forEach(opt => opt.classList.remove('border-blue-500', 'bg-blue-50'));
                } else {
                    showNotification(data.message || 'Mesaj gönderilirken hata oluştu', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Bir hata oluştu', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
}

function useTemplate(templateName) {
    const templates = {
        welcome: {
            subject: 'Monexa Finans\'a Hoş Geldiniz',
            content: 'Merhaba {name},\n\nMonexa Finans ailesine hoş geldiniz! Size en uygun yatırım fırsatlarını sunmak için buradayız.\n\nSorularınız için bizimle iletişime geçebilirsiniz.\n\nSaygılarımla,\n{admin_name}'
        },
        followup: {
            content: 'Merhaba {name}, görüşmemizin ardından size önerdiğim yatırım planları hakkında düşüncelerinizi merak ediyorum. Herhangi bir sorunuz varsa çekinmeden sorun!'
        }
    };

    const template = templates[templateName];
    if (template) {
        if (template.subject) {
            document.getElementById('messageSubject').value = template.subject.replace('{name}', '{{ $lead->name }}');
        }
        document.getElementById('messageContent').value = template.content
            .replace('{name}', '{{ $lead->name }}')
            .replace('{admin_name}', '{{ auth()->user()->name }}');
        
        // Switch to send tab
        document.querySelector('.comm-tab-btn[data-tab="send"]').click();
    }
}
</script>
@endpush