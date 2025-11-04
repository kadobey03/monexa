{{-- Master Alert System Component --}}
@if (session('success') || session('error') || session('warning') || session('info'))
<div class="mb-6 space-y-3">
    {{-- Success Alert --}}
    @if (session('success'))
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4" role="alert">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <x-heroicon name="check-circle" class="w-5 h-5 text-green-400" />
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800 dark:text-green-300">
                    {{ session('success') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()"
                        class="inline-flex rounded-md bg-green-50 dark:bg-green-900/20 p-1.5 text-green-500 hover:bg-green-100 dark:hover:bg-green-900/40 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 dark:focus:ring-offset-green-900">
                    <x-heroicon name="x-mark" class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Error Alert --}}
    @if (session('error'))
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4" role="alert">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <x-heroicon name="exclamation-circle" class="w-5 h-5 text-red-400" />
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800 dark:text-red-300">
                    {{ session('error') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()"
                        class="inline-flex rounded-md bg-red-50 dark:bg-red-900/20 p-1.5 text-red-500 hover:bg-red-100 dark:hover:bg-red-900/40 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 dark:focus:ring-offset-red-900">
                    <x-heroicon name="x-mark" class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Warning Alert --}}
    @if (session('warning'))
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4" role="alert">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <x-heroicon name="exclamation-triangle" class="w-5 h-5 text-yellow-400" />
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-yellow-800 dark:text-yellow-300">
                    {{ session('warning') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()"
                        class="inline-flex rounded-md bg-yellow-50 dark:bg-yellow-900/20 p-1.5 text-yellow-500 hover:bg-yellow-100 dark:hover:bg-yellow-900/40 focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-offset-2 dark:focus:ring-offset-yellow-900">
                    <x-heroicon name="x-mark" class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Info Alert --}}
    @if (session('info'))
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4" role="alert">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <x-heroicon name="information-circle" class="w-5 h-5 text-blue-400" />
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-blue-800 dark:text-blue-300">
                    {{ session('info') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()"
                        class="inline-flex rounded-md bg-blue-50 dark:bg-blue-900/20 p-1.5 text-blue-500 hover:bg-blue-100 dark:hover:bg-blue-900/40 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 dark:focus:ring-offset-blue-900">
                    <x-heroicon name="x-mark" class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
@endif

{{-- Global Error/Success Alert Components (Legacy Support) --}}
@isset($errors)
    @if ($errors->any())
    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4" role="alert">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <x-heroicon name="exclamation-circle" class="w-5 h-5 text-red-400" />
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-300">
                    Lütfen aşağıdaki hataları düzeltin:
                </h3>
                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
@endisset

{{-- Alert System Script --}}
@push('scripts')
<script>
// Initialize Lucide icons for alerts
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        
    }
});
</script>
@endpush