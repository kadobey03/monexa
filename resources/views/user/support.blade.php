
@extends('layouts.dasht')
@section('title', $title)
@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6" id="supportContainer">
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-blue-500/10 to-indigo-500/10 flex items-center justify-center backdrop-blur-sm">
                    <x-heroicon name="headphones" class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                </div>
                <div>
                    <h1 class="text-4xl font-light text-gray-800 dark:text-white mb-2">
                        Destek Merkezi
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 font-light text-lg">
                        Herhangi bir soru veya endişeniz için buradayız
                    </p>
                </div>
            </div>
        </div>

        <!-- Alert Components -->
        <div id="successAlert" class="mb-6" style="display: none;">
            <x-success-alert/>
        </div>
        <div id="errorAlert" class="mb-6" style="display: none;">
            <x-danger-alert/>
        </div>

        <!-- Support Options Grid -->
        <div class="grid md:grid-cols-1 gap-6 mb-8">
            <!-- Email Support Card -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/10 to-blue-600/10 flex items-center justify-center">
                        <x-heroicon name="envelope" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">E-posta Desteği</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">E-posta yoluyla yardım alın</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4 text-sm">Ayrıntılı sorular ve destek talepleri için doğrudan e-posta iletişimi.</p>
                <a href="mailto:{{$settings->contact_email}}" 
                   class="inline-flex items-center space-x-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium transition-colors">
                    <span>{{$settings->contact_email}}</span>
                    <x-heroicon name="external-link" class="w-4 h-4" />
                </a>
            </div>

           

         

        <!-- Contact Form Section -->
        <div class="bg-white dark:bg-gray-900 rounded-3xl p-8 border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-light text-gray-800 dark:text-white mb-4">Bize Mesaj Gönderin</h2>
                <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                    Belirli bir sorunuz mu var veya yardıma mı ihtiyacınız var? Aşağıdaki formu doldurun ve destek ekibimiz en kısa sürede size geri dönecek.
                </p>
            </div>

            <div class="max-w-2xl mx-auto">
                <form method="post" action="{{route('enquiry')}}"
                      onsubmit="handleSupportFormSubmit()"
                      id="supportForm">
                    @csrf
                    <input type="hidden" name="name" value="{{Auth::user()->name}}" />
                    <input type="hidden" name="email" value="{{Auth::user()->email}}">

                    <!-- User Info Display -->
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Adınız</label>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{substr(Auth::user()->name, 0, 1)}}</span>
                                </div>
                                <span class="text-gray-800 dark:text-white font-medium">{{Auth::user()->name}}</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">E-posta Adresiniz</label>
                            <div class="flex items-center space-x-3">
                                <x-heroicon name="envelope" class="w-5 h-5 text-gray-500" />
                                <span class="text-gray-800 dark:text-white">{{Auth::user()->email}}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Message Field -->
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Mesaj <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="message"
                            id="message"
                            oninput="updateMessageLength(this.value.length)"
                            class="w-full px-4 py-4 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 resize-none"
                            rows="6"
                            placeholder="Lütfen sorunuzu veya sorununuzu detaylı olarak açıklayın..."
                            required
                            maxlength="1000"></textarea>
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Size daha iyi yardımcı olmak için lütfen mümkün olduğunca fazla detay sağlayın.
                            </p>
                            <span class="text-sm text-gray-400" id="messageCounter">0/1000</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button
                            type="submit"
                            id="submitButton"
                            class="inline-flex items-center space-x-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="submitText">Mesaj Gönder</span>
                            <span id="submittingText" class="flex items-center space-x-2" style="display: none;">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Gönderiliyor...</span>
                            </span>
                            <x-heroicon name="send" class="w-5 h-5" id="sendIcon" />
                        </button>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                            Genellikle iş günlerinde 24 saat içinde yanıt veririz.
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Modal -->
        <div id="contactModal"
             class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 transition ease-out duration-300 opacity-0"
             onclick="closeContactModal(event)" style="display: none;">
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 max-w-md w-full border border-gray-200 dark:border-gray-700 transition ease-out duration-300 transform scale-95" id="contactModalContent">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <x-heroicon name="message-circle" class="w-8 h-8 text-green-600 dark:text-green-400" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Canlı Sohbet Desteği</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        Canlı sohbet özelliğimiz yakında gelecek! Şimdilik lütfen iletişim formunu kullanın veya doğrudan bize e-posta gönderin.
                    </p>
                    <button onclick="closeContactModal()"
                            class="w-full px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        Kapat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Support form state
let supportState = {
    showSuccess: false,
    showError: false,
    isSubmitting: false,
    message: '',
    messageLength: 0,
    showContactModal: false
};

// Initialize support form
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    
    
    // Initialize message input listener
    const messageInput = document.getElementById('message');
    if (messageInput) {
        messageInput.addEventListener('input', function() {
            updateMessageLength(this.value.length);
            supportState.message = this.value;
            updateSubmitButtonState();
        });
        
        // Initialize counter
        updateMessageLength(0);
    }
    
    console.log('Support form initialized');
});

// Update message length counter
function updateMessageLength(length) {
    supportState.messageLength = length;
    const counter = document.getElementById('messageCounter');
    if (counter) {
        counter.textContent = length + '/1000';
    }
}

// Update submit button state based on message length
function updateSubmitButtonState() {
    const submitButton = document.getElementById('submitButton');
    const messageLength = supportState.message.trim().length;
    
    if (submitButton) {
        if (supportState.isSubmitting || messageLength < 10) {
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            submitButton.classList.remove('hover:scale-105');
        } else {
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            submitButton.classList.add('hover:scale-105');
        }
    }
}

// Handle support form submission
function handleSupportFormSubmit() {
    supportState.isSubmitting = true;
    
    // Update UI elements
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');
    const submittingText = document.getElementById('submittingText');
    const sendIcon = document.getElementById('sendIcon');
    
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        submitButton.classList.remove('hover:scale-105');
    }
    
    if (submitText) {
        submitText.style.display = 'none';
    }
    
    if (submittingText) {
        submittingText.style.display = 'flex';
    }
    
    if (sendIcon) {
        sendIcon.style.display = 'none';
    }
    
    return true; // Allow form submission to continue
}

// Show success alert
function showSuccessAlert() {
    supportState.showSuccess = true;
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        successAlert.style.display = 'block';
    }
}

// Show error alert
function showErrorAlert() {
    supportState.showError = true;
    const errorAlert = document.getElementById('errorAlert');
    if (errorAlert) {
        errorAlert.style.display = 'block';
    }
}

// Hide alerts
function hideAlerts() {
    supportState.showSuccess = false;
    supportState.showError = false;
    
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');
    
    if (successAlert) {
        successAlert.style.display = 'none';
    }
    
    if (errorAlert) {
        errorAlert.style.display = 'none';
    }
}

// Show contact modal
function showContactModal() {
    supportState.showContactModal = true;
    const modal = document.getElementById('contactModal');
    const modalContent = document.getElementById('contactModalContent');
    
    if (modal && modalContent) {
        modal.style.display = 'flex';
        // Trigger animation
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }
}

// Close contact modal
function closeContactModal(event) {
    // Check if clicked on backdrop (not modal content)
    if (event && event.target !== document.getElementById('contactModal')) {
        return;
    }
    
    supportState.showContactModal = false;
    const modal = document.getElementById('contactModal');
    const modalContent = document.getElementById('contactModalContent');
    
    if (modal && modalContent) {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        
        // Hide modal after animation
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }
}
</script>

@endsection
