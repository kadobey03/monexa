<div class="notes-system-section bg-white rounded-lg shadow-md p-6 mt-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-sticky-note text-blue-500 mr-2"></i>
            Notes System
        </h3>
        <button type="button"
                class="add-note-btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
            <i class="fas fa-plus mr-1"></i>
            Add Note
        </button>
    </div>

    {{-- Notes Filter and Search --}}
    <div class="notes-controls mb-4 flex flex-wrap gap-2">
        <div class="flex-1 min-w-0">
            <input type="text"
                   placeholder="Search notes..."
                   class="notes-search w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <select class="notes-filter-category px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">All Categories</option>
            @if(isset($categories))
                @foreach($categories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            @endif
        </select>
    </div>

    {{-- Notes List --}}
    <div class="notes-list space-y-3 max-h-96 overflow-y-auto">
        @if(isset($notes) && $notes->count() > 0)
            @foreach($notes as $note)
                <div class="note-item bg-gray-50 rounded-lg p-4 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-900">{{ $note->title ?? 'Untitled Note' }}</span>
                            @if(isset($note->category))
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    {{ $note->category->name ?? 'General' }}
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500">{{ $note->created_at->diffForHumans() }}</span>
                            <button class="edit-note-btn text-gray-400 hover:text-blue-500 transition duration-150 ease-in-out"
                                    data-note-id="{{ $note->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-note-btn text-gray-400 hover:text-red-500 transition duration-150 ease-in-out"
                                    data-note-id="{{ $note->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="note-content text-sm text-gray-700">
                        {!! nl2br(e($note->content ?? '')) !!}
                    </div>
                    @if($note->attachments && $note->attachments->count() > 0)
                        <div class="note-attachments mt-2 flex flex-wrap gap-1">
                            @foreach($note->attachments as $attachment)
                                <a href="{{ Storage::url($attachment->path) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-2 py-1 bg-gray-200 text-gray-700 text-xs rounded hover:bg-gray-300 transition duration-150 ease-in-out">
                                    <i class="fas fa-paperclip mr-1"></i>
                                    {{ $attachment->original_name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-sticky-note text-4xl mb-2"></i>
                <p>No notes found for this lead.</p>
                <p class="text-sm">Click "Add Note" to create your first note.</p>
            </div>
        @endif
    </div>
</div>

{{-- Note Editor Modal --}}
<div id="note-editor-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="note-modal-title">Add New Note</h3>
                <button type="button" class="close-note-modal text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="note-form" class="space-y-4">
                @csrf
                <input type="hidden" name="note_id" id="note-id">

                <div>
                    <label for="note-title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text"
                           name="title"
                           id="note-title"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Note title">
                </div>

                <div>
                    <label for="note-category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id"
                            id="note-category"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Category</option>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <label for="note-content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content"
                              id="note-content"
                              rows="6"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Write your note here..."></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button"
                            class="cancel-note-btn px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit"
                            class="save-note-btn px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save Note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notesSystem = {
        init() {
            this.bindEvents();
        },

        bindEvents() {
            // Add note button
            const addNoteBtn = document.querySelector('.add-note-btn');
            if (addNoteBtn) {
                addNoteBtn.addEventListener('click', () => this.showNoteModal());
            }

            // Close modal buttons
            const closeButtons = document.querySelectorAll('.close-note-modal, .cancel-note-btn');
            closeButtons.forEach(btn => {
                btn.addEventListener('click', () => this.hideNoteModal());
            });

            // Save note
            const saveBtn = document.querySelector('.save-note-btn');
            if (saveBtn) {
                saveBtn.addEventListener('click', (e) => this.saveNote(e));
            }

            // Edit note buttons
            const editButtons = document.querySelectorAll('.edit-note-btn');
            editButtons.forEach(btn => {
                btn.addEventListener('click', (e) => this.editNote(e));
            });

            // Delete note buttons
            const deleteButtons = document.querySelectorAll('.delete-note-btn');
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', (e) => this.deleteNote(e));
            });

            // Search functionality
            const searchInput = document.querySelector('.notes-search');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => this.filterNotes(e.target.value));
            }

            // Category filter
            const categoryFilter = document.querySelector('.notes-filter-category');
            if (categoryFilter) {
                categoryFilter.addEventListener('change', (e) => this.filterByCategory(e.target.value));
            }
        },

        showNoteModal(noteId = null) {
            const modal = document.getElementById('note-editor-modal');
            const form = document.getElementById('note-form');
            const title = document.getElementById('note-modal-title');

            if (noteId) {
                // Edit mode
                title.textContent = 'Edit Note';
                this.loadNoteData(noteId);
            } else {
                // Add mode
                title.textContent = 'Add New Note';
                form.reset();
                document.getElementById('note-id').value = '';
            }

            modal.classList.remove('hidden');
        },

        hideNoteModal() {
            const modal = document.getElementById('note-editor-modal');
            modal.classList.add('hidden');
        },

        async saveNote(e) {
            e.preventDefault();

            const form = document.getElementById('note-form');
            const formData = new FormData(form);
            const noteId = formData.get('note_id');

            const url = noteId
                ? `/admin/api/leads/${{{ $lead->id }}}/notes/${noteId}`
                : `/admin/api/leads/${{{ $lead->id }}}/notes`;

            const method = noteId ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    this.hideNoteModal();
                    this.refreshNotes();
                    // Show success message
                    this.showMessage('Note saved successfully', 'success');
                } else {
                    this.showMessage(result.message || 'Error saving note', 'error');
                }
            } catch (error) {
                console.error('Error saving note:', error);
                this.showMessage('Error saving note', 'error');
            }
        },

        async loadNoteData(noteId) {
            try {
                const response = await fetch(`/admin/api/leads/${{{ $lead->id }}}/notes/${noteId}`, {
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                if (response.ok) {
                    const note = await response.json();
                    document.getElementById('note-id').value = note.id;
                    document.getElementById('note-title').value = note.title || '';
                    document.getElementById('note-content').value = note.content || '';
                    document.getElementById('note-category').value = note.category_id || '';
                }
            } catch (error) {
                console.error('Error loading note:', error);
            }
        },

        async deleteNote(e) {
            const noteId = e.currentTarget.dataset.noteId;

            if (!confirm('Are you sure you want to delete this note?')) {
                return;
            }

            try {
                const response = await fetch(`/admin/api/leads/${{{ $lead->id }}}/notes/${noteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                });

                if (response.ok) {
                    this.refreshNotes();
                    this.showMessage('Note deleted successfully', 'success');
                } else {
                    this.showMessage('Error deleting note', 'error');
                }
            } catch (error) {
                console.error('Error deleting note:', error);
                this.showMessage('Error deleting note', 'error');
            }
        },

        async refreshNotes() {
            // Refresh the page or update the notes list
            window.location.reload();
        },

        filterNotes(searchTerm) {
            const notes = document.querySelectorAll('.note-item');
            const term = searchTerm.toLowerCase();

            notes.forEach(note => {
                const title = note.querySelector('.text-sm.font-medium').textContent.toLowerCase();
                const content = note.querySelector('.note-content').textContent.toLowerCase();

                if (title.includes(term) || content.includes(term)) {
                    note.style.display = '';
                } else {
                    note.style.display = 'none';
                }
            });
        },

        filterByCategory(categoryId) {
            const notes = document.querySelectorAll('.note-item');

            notes.forEach(note => {
                if (!categoryId) {
                    note.style.display = '';
                    return;
                }

                const noteCategory = note.querySelector('.bg-blue-100');
                if (noteCategory && noteCategory.textContent.trim() === categoryId) {
                    note.style.display = '';
                } else {
                    note.style.display = 'none';
                }
            });
        },

        showMessage(message, type) {
            // Simple message display - you can enhance this with a proper notification system
            alert(message);
        }
    };

    // Initialize notes system
    notesSystem.init();
});
</script>
@endpush