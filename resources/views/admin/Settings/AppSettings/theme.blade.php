<div class="space-y-8">
    <!-- Theme Upload Section -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-8 border border-indigo-200">
        <div class="flex flex-col items-center text-center space-y-6">
            <!-- Header -->
            <div class="flex items-center space-x-4">
                <div class="p-4 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4zm12 12H4v-5h12v5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="text-left">
                    <h2 class="text-2xl font-bold text-gray-900">Yeni Tema Yükle</h2>
                    <p class="text-gray-600 mt-1">Yeni temanız yükleme başarılı olduğunda kullanıcı paneline uygulanacak</p>
                </div>
            </div>
            
            <!-- Upload Form -->
            <div class="w-full max-w-2xl">
                <form method="post" action="{{route('theme.update')}}" enctype="multipart/form-data" id="themeForm" class="space-y-6">
                    @csrf
                    
                    <!-- File Upload Area -->
                    <div class="relative group">
                        <div class="border-2 border-dashed border-indigo-300 group-hover:border-indigo-400 rounded-xl p-8 transition-all duration-300 bg-white/50 group-hover:bg-white/80">
                            <div class="flex flex-col items-center space-y-4">
                                <div class="p-3 bg-indigo-100 rounded-full group-hover:bg-indigo-200 transition-colors duration-200">
                                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <label for="theme-file" class="cursor-pointer">
                                        <span class="text-lg font-medium text-gray-900">Tema dosyasını seçin</span>
                                        <p class="text-sm text-gray-500 mt-1">ZIP formatında tema dosyası yükleyin</p>
                                    </label>
                                    <input type="file" name='theme' id="theme-file" class="hidden" accept=".zip" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Selected File Display -->
                    <div id="selected-file" class="hidden bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 11-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-green-800">Seçilen dosya:</p>
                                <p class="text-sm text-green-600" id="file-name"></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Error Messages -->
                    @error('theme')
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="ml-2 text-sm text-red-800 font-medium">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                    
                    @if (session()->has('error'))
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="ml-2 text-sm text-red-800 font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Upload Button -->
                    <div class="flex justify-center">
                        <button type="submit" id="themeBtn" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span id="btn-text">Temayı Yükle</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Loading Indicator -->
        <div class="mt-8 hidden" id="loadingTheme">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-center justify-center space-x-4">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <div class="text-center">
                        <p class="text-lg font-semibold text-blue-900">Tema Yükleniyor...</p>
                        <p class="text-sm text-blue-600 mt-1">Lütfen bekleyin, tema yüklenirken sayfayı yenilemeyin</p>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="mt-4">
                    <div class="bg-blue-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-blue-600 h-2 rounded-full animate-pulse" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Theme Display Section -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
        <div class="flex items-center space-x-3 mb-6">
            <div class="p-2 bg-gray-600 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 11-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900">Mevcut Temalar</h2>
        </div>
        
        <!-- Livewire Component for Theme Display -->
        <livewire:admin.theme-display />
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('theme-file');
        const selectedFileDiv = document.getElementById('selected-file');
        const fileNameSpan = document.getElementById('file-name');
        const themeForm = document.getElementById('themeForm');
        const themeBtn = document.getElementById('themeBtn');
        const loadingDiv = document.getElementById('loadingTheme');
        const btnText = document.getElementById('btn-text');
        
        // File selection handler
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                selectedFileDiv.classList.remove('hidden');
                fileNameSpan.textContent = file.name;
            } else {
                selectedFileDiv.classList.add('hidden');
            }
        });
        
        // Form submission handler
        themeForm.addEventListener('submit', function(e) {
            // Disable button and show loading
            themeBtn.disabled = true;
            btnText.textContent = 'Yükleniyor...';
            
            // Show loading indicator
            loadingDiv.classList.remove('hidden');
            
            // Add loading animation to button
            themeBtn.innerHTML = `
                <svg class="w-5 h-5 mr-2 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                </svg>
                Yükleniyor...
            `;
        });
        
        // Drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        dropZone.addEventListener('drop', handleDrop, false);
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        function highlight(e) {
            dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
        }
        
        function unhighlight(e) {
            dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        }
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                const file = files[0];
                
                // Check if file is zip
                if (file.type === 'application/zip' || file.name.endsWith('.zip')) {
                    fileInput.files = files;
                    
                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                } else {
                    alert('Lütfen sadece ZIP dosyalarını yükleyin.');
                }
            }
        }
    });
</script>