<div class="communication-hub-section bg-white rounded-lg shadow-md p-6 mt-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-comments text-green-500 mr-2"></i>
            Communication Hub
        </h3>
        <button type="button"
                class="send-communication-btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
            <i class="fas fa-paper-plane mr-1"></i>
            Send Message
        </button>
    </div>

    {{-- Communication Stats --}}
    @if(isset($communicationStats) && count($communicationStats) > 0)
    <div class="communication-stats grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="stat-card bg-blue-50 p-4 rounded-lg">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-full">
                    <i class="fas fa-envelope text-white"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Sent</p>
                    <p class="text-xl font-bold text-gray-900">{{ $communicationStats['total_sent'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card bg-green-50 p-4 rounded-lg">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 rounded-full">
                    <i class="fas fa-reply text-white"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Replies</p>
                    <p class="text-xl font-bold text-gray-900">{{ $communicationStats['replies'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card bg-yellow-50 p-4 rounded-lg">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-500 rounded-full">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-xl font-bold text-gray-900">{{ $communicationStats['pending'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card bg-red-50 p-4 rounded-lg">
            <div class="flex items-center">
                <div class="p-2 bg-red-500 rounded-full">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Failed</p>
                    <p class="text-xl font-bold text-gray-900">{{ $communicationStats['failed'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Communications List --}}
    <div class="communications-list space-y-3 max-h-96 overflow-y-auto">
        @if(isset($communications) && $communications->count() > 0)
            @foreach($communications as $communication)
                <div class="communication-item bg-gray-50 rounded-lg p-4 border-l-4 {{ $communication->status === 'sent' ? 'border-green-500' : ($communication->status === 'failed' ? 'border-red-500' : 'border-yellow-500') }}">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-900">{{ $communication->subject ?? 'No Subject' }}</span>
                            <span class="px-2 py-1 {{ $communication->status === 'sent' ? 'bg-green-100 text-green-800' : ($communication->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }} text-xs rounded-full">
                                {{ ucfirst($communication->status ?? 'pending') }}
                            </span>
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                {{ $communication->type ?? 'email' }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500">{{ $communication->created_at->diffForHumans() }}</span>
                            @if($communication->status === 'sent')
                            <button class="resend-communication-btn text-gray-400 hover:text-blue-500 transition duration-150 ease-in-out"
                                    data-communication-id="{{ $communication->id }}">
                                <i class="fas fa-redo"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="communication-content text-sm text-gray-700">
                        {!! nl2br(e(Str::limit($communication->content ?? '', 200))) !!}
                    </div>
                    @if(isset($communication->attachments) && $communication->attachments->count() > 0)
                        <div class="communication-attachments mt-2 flex flex-wrap gap-1">
                            @foreach($communication->attachments as $attachment)
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
                <i class="fas fa-comments text-4xl mb-2"></i>
                <p>No communications found for this lead.</p>
                <p class="text-sm">Click "Send Message" to start communicating.</p>
            </div>
        @endif
    </div>
</div>

{{-- Communication Modal --}}
<div id="communication-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Send Communication</h3>
                <button type="button" class="close-communication-modal text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="communication-form" class="space-y-4">
                @csrf

                <div>
                    <label for="communication-type" class="block text-sm font-medium text-gray-700">Communication Type</label>
                    <select name="type"
                            id="communication-type"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="email">Email</option>
                        <option value="sms">SMS</option>
                        <option value="call">Phone Call</option>
                        <option value="meeting">Meeting</option>
                    </select>
                </div>

                <div>
                    <label for="communication-subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text"
                           name="subject"
                           id="communication-subject"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Communication subject">
                </div>

                <div>
                    <label for="communication-content" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea name="content"
                              id="communication-content"
                              rows="6"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Write your message here..."></textarea>
                </div>

                <div>
                    <label for="communication-priority" class="block text-sm font-medium text-gray-700">Priority</label>
                    <select name="priority"
                            id="communication-priority"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="low">Low</option>
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>

                <div class="flex items-center">
                    <input type="checkbox"
                           name="schedule_send"
                           id="schedule-send"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="schedule-send" class="ml-2 block text-sm text-gray-900">
                        Schedule for later
                    </label>
                </div>

                <div id="schedule-datetime" class="hidden">
                    <label for="send-datetime" class="block text-sm font-medium text-gray-700">Send Date & Time</label>
                    <input type="datetime-local"
                           name="send_datetime"
                           id="send-datetime"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button"
                            class="cancel-communication-btn px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit"
                            class="send-communication-submit-btn px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Send Communication
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const communicationHub = {
        init() {
            this.bindEvents();
        },

        bindEvents() {
            // Send communication button
            const sendBtn = document.querySelector('.send-communication-btn');
            if (sendBtn) {
                sendBtn.addEventListener('click', () => this.showCommunicationModal());
            }

            // Close modal buttons
            const closeButtons = document.querySelectorAll('.close-communication-modal, .cancel-communication-btn');
            closeButtons.forEach(btn => {
                btn.addEventListener('click', () => this.hideCommunicationModal());
            });

            // Send communication
            const submitBtn = document.querySelector('.send-communication-submit-btn');
            if (submitBtn) {
                submitBtn.addEventListener('click', (e) => this.sendCommunication(e));
            }

            // Resend buttons
            const resendButtons = document.querySelectorAll('.resend-communication-btn');
            resendButtons.forEach(btn => {
                btn.addEventListener('click', (e) => this.resendCommunication(e));
            });

            // Schedule checkbox
            const scheduleCheckbox = document.getElementById('schedule-send');
            if (scheduleCheckbox) {
                scheduleCheckbox.addEventListener('change', (e) => this.toggleScheduleFields(e.target.checked));
            }
        },

        showCommunicationModal() {
            const modal = document.getElementById('communication-modal');
            const form = document.getElementById('communication-form');
            form.reset();
            this.toggleScheduleFields(false);
            modal.classList.remove('hidden');
        },

        hideCommunicationModal() {
            const modal = document.getElementById('communication-modal');
            modal.classList.add('hidden');
        },

        toggleScheduleFields(show) {
            const scheduleDiv = document.getElementById('schedule-datetime');
            if (show) {
                scheduleDiv.classList.remove('hidden');
            } else {
                scheduleDiv.classList.add('hidden');
            }
        },

        async sendCommunication(e) {
            e.preventDefault();

            const form = document.getElementById('communication-form');
            const formData = new FormData(form);

            try {
                const response = await fetch(`/admin/api/leads/${{{ $lead->id }}}/communication/send`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    this.hideCommunicationModal();
                    this.refreshCommunications();
                    this.showMessage('Communication sent successfully', 'success');
                } else {
                    this.showMessage(result.message || 'Error sending communication', 'error');
                }
            } catch (error) {
                console.error('Error sending communication:', error);
                this.showMessage('Error sending communication', 'error');
            }
        },

        async resendCommunication(e) {
            const communicationId = e.currentTarget.dataset.communicationId;

            try {
                const response = await fetch(`/admin/api/leads/${{{ $lead->id }}}/communication/${communicationId}/resend`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                });

                if (response.ok) {
                    this.refreshCommunications();
                    this.showMessage('Communication resent successfully', 'success');
                } else {
                    const result = await response.json();
                    this.showMessage(result.message || 'Error resending communication', 'error');
                }
            } catch (error) {
                console.error('Error resending communication:', error);
                this.showMessage('Error resending communication', 'error');
            }
        },

        async refreshCommunications() {
            // Refresh the page or update the communications list
            window.location.reload();
        },

        showMessage(message, type) {
            // Simple message display - you can enhance this with a proper notification system
            alert(message);
        }
    };

    // Initialize communication hub
    communicationHub.init();
});
</script>
@endpush