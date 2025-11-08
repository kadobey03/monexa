@props(['lead'])

{{-- Note Editor Modal --}}
<div id="noteEditorModal" class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="modal-dialog relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="modal-content">
            {{-- Modal Header --}}
            <div class="modal-header flex items-center justify-between pb-3 border-b border-gray-200">
                <h3 class="modal-title text-lg font-semibold text-gray-900">
                    <i class="fas fa-sticky-note text-yellow-500 mr-2"></i>
                    Not Ekle/Düzenle
                </h3>
                <button type="button" class="modal-close text-gray-400 hover:text-gray-600" data-modal="noteEditorModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body py-4">
                <form id="noteForm" data-lead-id="{{ $lead->id }}">
                    @csrf
                    <input type="hidden" id="noteId" name="note_id" value="">
                    
                    {{-- Note Category --}}
                    <div class="form-group mb-4">
                        <label for="noteCategory" class="block text-sm font-medium text-gray-700 mb-2">
                            Not Kategorisi
                        </label>
                        <select id="noteCategory" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Kategori Seçin</option>
                            <option value="general">Genel</option>
                            <option value="call">Arama Notu</option>
                            <option value="meeting">Görüşme</option>
                            <option value="email">E-posta</option>
                            <option value="follow_up">Takip</option>
                            <option value="complaint">Şikayet</option>
                            <option value="opportunity">Fırsat</option>
                            <option value="technical">Teknik</option>
                        </select>
                    </div>

                    {{-- Note Priority --}}
                    <div class="form-group mb-4">
                        <label for="notePriority" class="block text-sm font-medium text-gray-700 mb-2">
                            Öncelik
                        </label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="priority" value="low" class="mr-2 text-blue-600">
                                <span class="text-sm text-gray-700">Düşük</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="priority" value="normal" checked class="mr-2 text-blue-600">
                                <span class="text-sm text-gray-700">Normal</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="priority" value="high" class="mr-2 text-blue-600">
                                <span class="text-sm text-gray-700">Yüksek</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="priority" value="urgent" class="mr-2 text-blue-600">
                                <span class="text-sm text-gray-700">Acil</span>
                            </label>
                        </div>
                    </div>

                    {{-- Note Content --}}
                    <div class="form-group mb-4">
                        <label for="noteContent" class="block text-sm font-medium text-gray-700 mb-2">
                            Not İçeriği *
                        </label>
                        <textarea id="noteContent" 
                                  name="content" 
                                  rows="6" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="Lead ile ilgili notunuzu buraya yazın..."
                                  required></textarea>
                        <div class="mt-1 text-sm text-gray-500">
                            <span id="characterCount">0</span> / 1000 karakter
                        </div>
                    </div>

                    {{-- Tags --}}
                    <div class="form-group mb-4">
                        <label for="noteTags" class="block text-sm font-medium text-gray-700 mb-2">
                            Etiketler
                        </label>
                        <input type="text" 
                               id="noteTags" 
                               name="tags" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Etiketleri virgülle ayırın (örn: önemli, takip, fırsat)">
                        <div class="mt-1 text-sm text-gray-500">
                            Etiketler arama ve filtreleme için kullanılır
                        </div>
                    </div>

                    {{-- Reminder --}}
                    <div class="form-group mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="setReminder" name="set_reminder" class="mr-2 text-blue-600">
                            <label for="setReminder" class="text-sm font-medium text-gray-700">
                                Bu not için hatırlatıcı ayarla
                            </label>
                        </div>
                        <div id="reminderDateTime" class="mt-2 hidden">
                            <input type="datetime-local" 
                                   name="reminder_date" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    {{-- Visibility --}}
                    <div class="form-group mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Görünürlük
                        </label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="visibility" value="private" checked class="mr-2 text-blue-600">
                                <span class="text-sm text-gray-700">Sadece ben</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="visibility" value="team" class="mr-2 text-blue-600">
                                <span class="text-sm text-gray-700">Takım</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="visibility" value="public" class="mr-2 text-blue-600">
                                <span class="text-sm text-gray-700">Herkese açık</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer flex items-center justify-between pt-3 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Notlar lead geçmişinde saklanır ve aranabilir
                </div>
                <div class="flex space-x-2">
                    <button type="button" class="btn-secondary px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300" 
                            data-modal="noteEditorModal">
                        İptal
                    </button>
                    <button type="submit" form="noteForm" class="btn-primary px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fas fa-save mr-1"></i>
                        Kaydet
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const noteForm = document.getElementById('noteForm');
    const noteContent = document.getElementById('noteContent');
    const characterCount = document.getElementById('characterCount');
    const setReminder = document.getElementById('setReminder');
    const reminderDateTime = document.getElementById('reminderDateTime');

    // Character count
    if (noteContent && characterCount) {
        noteContent.addEventListener('input', function() {
            const count = this.value.length;
            characterCount.textContent = count;
            
            if (count > 1000) {
                characterCount.parentElement.classList.add('text-red-500');
                this.classList.add('border-red-500');
            } else {
                characterCount.parentElement.classList.remove('text-red-500');
                this.classList.remove('border-red-500');
            }
        });
    }

    // Reminder toggle
    if (setReminder && reminderDateTime) {
        setReminder.addEventListener('change', function() {
            if (this.checked) {
                reminderDateTime.classList.remove('hidden');
                // Set default reminder to 1 hour from now
                const now = new Date();
                now.setHours(now.getHours() + 1);
                reminderDateTime.querySelector('input').value = now.toISOString().slice(0, 16);
            } else {
                reminderDateTime.classList.add('hidden');
            }
        });
    }

    // Form submission
    if (noteForm) {
        noteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const leadId = this.dataset.leadId;
            const noteId = document.getElementById('noteId').value;
            
            const url = noteId ? 
                `/admin/api/leads/${leadId}/notes/${noteId}` : 
                `/admin/api/leads/${leadId}/notes`;
            
            const method = noteId ? 'PUT' : 'POST';
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Kaydediliyor...';
            submitBtn.disabled = true;
            
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification('Not başarıyla kaydedildi', 'success');
                    
                    // Close modal
                    closeModal('noteEditorModal');
                    
                    // Reset form
                    this.reset();
                    document.getElementById('noteId').value = '';
                    characterCount.textContent = '0';
                    reminderDateTime.classList.add('hidden');
                    
                    // Reload notes section if exists
                    if (typeof reloadNotesSection === 'function') {
                        reloadNotesSection();
                    }
                } else {
                    showNotification(data.message || 'Not kaydedilirken hata oluştu', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Bir hata oluştu', 'error');
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});

// Function to edit existing note
function editNote(noteId, noteData) {
    document.getElementById('noteId').value = noteId;
    document.getElementById('noteCategory').value = noteData.category || '';
    document.querySelector(`input[name="priority"][value="${noteData.priority || 'normal'}"]`).checked = true;
    document.getElementById('noteContent').value = noteData.content || '';
    document.getElementById('noteTags').value = noteData.tags || '';
    document.querySelector(`input[name="visibility"][value="${noteData.visibility || 'private'}"]`).checked = true;
    
    // Update character count
    const characterCount = document.getElementById('characterCount');
    if (characterCount) {
        characterCount.textContent = noteData.content ? noteData.content.length : 0;
    }
    
    // Handle reminder
    if (noteData.reminder_date) {
        document.getElementById('setReminder').checked = true;
        document.getElementById('reminderDateTime').classList.remove('hidden');
        document.querySelector('input[name="reminder_date"]').value = noteData.reminder_date;
    }
    
    openModal('noteEditorModal');
}
</script>
@endpush