@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    
    <!-- Main Content -->
    <div class="flex-1 ml-0 md:ml-64 transition-all duration-300">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
            <!-- Header Section -->
            <div class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ __('admin.deposits.investment_screenshot') }}</h1>
                                <p class="text-gray-600 mt-1">{{ __('admin.deposits.view_edit_investment_proof') }}</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('mdeposits') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('admin.deposits.back') }}
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                <x-danger-alert />
                <x-success-alert />
            </div>
            
            <!-- Main Content -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <!-- Edit Section -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
                        <!-- Edit Header -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-xl font-bold text-gray-900">{{ __('admin.deposits.edit_investment_details') }}</h2>
                                </div>
                                <button type="button" id="toggleEditForm" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('admin.deposits.toggle_edit_form') }}
                                </button>
                            </div>
                        </div>
                        
                        <!-- Current Values Display -->
                        <div id="currentValues" class="px-6 py-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-green-600">{{ __('admin.deposits.current_amount') }}</p>
                                                <p class="text-lg font-bold text-green-800">${{ number_format($deposit->amount, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-blue-600">{{ __('admin.deposits.current_status') }}</p>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-medium {{ $deposit->status == 'Processed' ? 'bg-green-100 text-green-800' : ($deposit->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $deposit->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="p-4 bg-purple-50 rounded-lg border-l-4 border-purple-500">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-purple-600">{{ __('admin.deposits.current_payment_method') }}</p>
                                                <p class="text-lg font-semibold text-purple-800">{{ $deposit->payment_mode }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-gray-500">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-600">{{ __('admin.deposits.creation_date') }}</p>
                                                <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($deposit->created_at)->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Edit Form Container -->
                        <div id="editFormContainer" class="px-6 py-6 bg-gray-50 border-t border-gray-200" style="display: none;">
                            <form action="{{ route('edit.deposit') }}" method="POST" id="editDepositForm" class="space-y-6">
                                @csrf
                                <input type="hidden" name="deposit_id" value="{{ $deposit->id }}">
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Amount -->
                                    <div>
                                        <label for="edit_amount" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.deposits.amount') }}</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" step="0.01" name="amount" id="edit_amount" value="{{ $deposit->amount }}" required
                                                   class="pl-8 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                    </div>
                                    
                                    <!-- Status -->
                                    <div>
                                        <label for="edit_status" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.deposits.status') }}</label>
                                        <select name="status" id="edit_status" required
                                                class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="Pending" {{ $deposit->status == 'Pending' ? 'selected' : '' }}>{{ __('admin.deposits.pending') }}</option>
                                            <option value="Processed" {{ $deposit->status == 'Processed' ? 'selected' : '' }}>{{ __('admin.deposits.processed') }}</option>
                                            <option value="Rejected" {{ $deposit->status == 'Rejected' ? 'selected' : '' }}>{{ __('admin.deposits.rejected') }}</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Payment Mode -->
                                    <div>
                                        <label for="edit_payment_mode" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.deposits.payment_method') }}</label>
                                        <input type="text" name="payment_mode" id="edit_payment_mode" value="{{ $deposit->payment_mode }}" required
                                               class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    
                                    <!-- Created Date -->
                                    <div>
                                        <label for="edit_created_at" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.deposits.creation_date') }}</label>
                                        <input type="datetime-local" name="created_at" id="edit_created_at" 
                                               value="{{ \Carbon\Carbon::parse($deposit->created_at)->format('Y-m-d\TH:i') }}" required
                                               class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                                
                                <!-- Form Actions -->
                                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                                    <button type="button" id="cancelEdit" 
                                            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('admin.deposits.cancel') }}
                                    </button>
                                    <button type="submit" 
                                            class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"></path>
                                        </svg>
                                        {{ __('admin.deposits.update_investment_details') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Image Display Section -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                        <!-- Image Header -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">{{ __('admin.deposits.investment_proof_screenshot') }}</h2>
                            </div>
                        </div>
                        
                        <!-- Image Content -->
                        <div class="p-6">
                            <div class="max-w-full mx-auto">
                                <div class="bg-gray-50 rounded-lg p-4 border-2 border-dashed border-gray-300">
                                    <img src="{{ asset('storage/' . $deposit->proof) }}" 
                                         alt="{{ __('admin.deposits.payment_proof') }}"
                                         class="w-full h-auto rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 cursor-zoom-in"
                                         onclick="openImageModal(this.src)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-75">
        <div class="max-w-4xl max-h-full p-4">
            <div class="relative">
                <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 transition-all duration-200">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <img id="modalImage" src="" alt="{{ __('admin.deposits.enlarged_image') }}" class="max-w-full max-h-screen rounded-lg">
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script>
        // Toggle edit form visibility
        document.getElementById('toggleEditForm').addEventListener('click', function() {
            const editContainer = document.getElementById('editFormContainer');
            const currentValues = document.getElementById('currentValues');
            const button = this;
            
            if (editContainer.style.display === 'none') {
                editContainer.style.display = 'block';
                currentValues.style.display = 'none';
                button.innerHTML = '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l6 6a1 1 0 001.414 0l6-6a1 1 0 00-1.414-1.414L10 6.586 4.293 2.293z" clip-rule="evenodd"></path></svg>{{ __('admin.deposits.hide_form') }}';
            } else {
                editContainer.style.display = 'none';
                currentValues.style.display = 'block';
                button.innerHTML = '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>{{ __('admin.deposits.toggle_edit_form') }}';
            }
        });
        
        // Cancel edit functionality
        document.getElementById('cancelEdit').addEventListener('click', function() {
            document.getElementById('editFormContainer').style.display = 'none';
            document.getElementById('currentValues').style.display = 'block';
            document.getElementById('toggleEditForm').innerHTML = '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>{{ __('admin.deposits.toggle_edit_form') }}';
        });
        
        // Form validation
        document.getElementById('editDepositForm').addEventListener('submit', function(e) {
            const amount = parseFloat(document.getElementById('edit_amount').value);
            if (amount < 0) {
                e.preventDefault();
                alert('{{ __('admin.deposits.amount_cannot_be_negative') }}');
                return false;
            }
            
            if (confirm('{{ __('admin.deposits.update_investment_confirmation') }}')) {
                return true;
            } else {
                e.preventDefault();
                return false;
            }
        });
        
        // Image modal functions
        function openImageModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        
        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
@endsection