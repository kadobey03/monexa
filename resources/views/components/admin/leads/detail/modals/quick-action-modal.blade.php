@props(['lead'])

{{-- Quick Action Modal --}}
<div id="quickActionModal" class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="modal-dialog relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="modal-content">
            {{-- Modal Header --}}
            <div class="modal-header flex items-center justify-between pb-3 border-b border-gray-200">
                <h3 class="modal-title text-lg font-semibold text-gray-900">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                    Hızlı Aksiyon
                </h3>
                <button type="button" class="modal-close text-gray-400 hover:text-gray-600" data-modal="quickActionModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body py-4">
                <div class="quick-actions-grid space-y-3">
                    {{-- Call Action --}}
                    @can('call_lead')
                    <button class="quick-action-item w-full flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all"
                            data-action="call" data-phone="{{ $lead->phone }}">
                        <div class="action-icon w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-phone text-green-600"></i>
                        </div>
                        <div class="action-content text-left">
                            <div class="action-title font-medium text-gray-900">Hızlı Arama</div>
                            <div class="action-subtitle text-sm text-gray-500">{{ $lead->phone }}</div>
                        </div>
                    </button>
                    @endcan

                    {{-- Email Action --}}
                    @can('email_lead')
                    <button class="quick-action-item w-full flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all"
                            data-action="email" data-email="{{ $lead->email }}">
                        <div class="action-icon w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-blue-600"></i>
                        </div>
                        <div class="action-content text-left">
                            <div class="action-title font-medium text-gray-900">E-posta Gönder</div>
                            <div class="action-subtitle text-sm text-gray-500">{{ $lead->email }}</div>
                        </div>
                    </button>
                    @endcan

                    {{-- WhatsApp Action --}}
                    @can('message_lead')
                    <button class="quick-action-item w-full flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all"
                            data-action="whatsapp" data-phone="{{ $lead->phone }}">
                        <div class="action-icon w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fab fa-whatsapp text-green-600"></i>
                        </div>
                        <div class="action-content text-left">
                            <div class="action-title font-medium text-gray-900">WhatsApp Mesajı</div>
                            <div class="action-subtitle text-sm text-gray-500">{{ $lead->phone }}</div>
                        </div>
                    </button>
                    @endcan

                    {{-- Schedule Follow-up --}}
                    @can('schedule_followup')
                    <button class="quick-action-item w-full flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all"
                            data-action="schedule" data-lead-id="{{ $lead->id }}">
                        <div class="action-icon w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-plus text-purple-600"></i>
                        </div>
                        <div class="action-content text-left">
                            <div class="action-title font-medium text-gray-900">Takip Planla</div>
                            <div class="action-subtitle text-sm text-gray-500">Sonraki görüşme zamanı belirle</div>
                        </div>
                    </button>
                    @endcan

                    {{-- Add Note --}}
                    @can('add_note')
                    <button class="quick-action-item w-full flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all"
                            data-action="note" data-lead-id="{{ $lead->id }}">
                        <div class="action-icon w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-sticky-note text-yellow-600"></i>
                        </div>
                        <div class="action-content text-left">
                            <div class="action-title font-medium text-gray-900">Hızlı Not</div>
                            <div class="action-subtitle text-sm text-gray-500">Lead hakkında not ekle</div>
                        </div>
                    </button>
                    @endcan

                    {{-- Update Status --}}
                    @can('update_lead_status')
                    <button class="quick-action-item w-full flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all"
                            data-action="status" data-lead-id="{{ $lead->id }}">
                        <div class="action-icon w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-flag text-orange-600"></i>
                        </div>
                        <div class="action-content text-left">
                            <div class="action-title font-medium text-gray-900">Durum Güncelle</div>
                            <div class="action-subtitle text-sm text-gray-500">Lead durumunu değiştir</div>
                        </div>
                    </button>
                    @endcan
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer flex items-center justify-end pt-3 border-t border-gray-200 space-x-2">
                <button type="button" class="btn-secondary px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300" 
                        data-modal="quickActionModal">
                    İptal
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick action handlers
    document.querySelectorAll('.quick-action-item').forEach(item => {
        item.addEventListener('click', function() {
            const action = this.dataset.action;
            const leadId = this.dataset.leadId;
            const phone = this.dataset.phone;
            const email = this.dataset.email;

            switch(action) {
                case 'call':
                    if (phone) {
                        window.open(`tel:${phone}`, '_self');
                    }
                    break;
                case 'email':
                    if (email) {
                        window.open(`mailto:${email}`, '_blank');
                    }
                    break;
                case 'whatsapp':
                    if (phone) {
                        const whatsappUrl = `https://wa.me/${phone.replace(/[^0-9]/g, '')}`;
                        window.open(whatsappUrl, '_blank');
                    }
                    break;
                case 'schedule':
                    // Open schedule modal or redirect to scheduling page
                    console.log('Schedule follow-up for lead:', leadId);
                    break;
                case 'note':
                    // Open note modal
                    openModal('noteEditorModal');
                    break;
                case 'status':
                    // Open status update modal or dropdown
                    console.log('Update status for lead:', leadId);
                    break;
            }
            
            // Close the quick action modal
            closeModal('quickActionModal');
        });
    });
});
</script>
@endpush