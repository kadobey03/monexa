@props([
    'type' => 'identity', // 'identity', 'address', 'income'
    'required' => true,
    'multiple' => false,
    'maxSize' => '5MB',
    'acceptedTypes' => ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf']
])

@php
    $uploadId = 'kyc-upload-' . $type . '-' . uniqid();

    $typeLabels = [
        'identity' => __('Identity Document'),
        'address' => __('Proof of Address'),
        'income' => __('Proof of Income')
    ];

    $typeDescriptions = [
        'identity' => __('Upload a clear photo of your ID card, passport, or driver\'s license'),
        'address' => __('Upload a recent utility bill, bank statement, or government letter showing your address'),
        'income' => __('Upload payslips, tax returns, or bank statements showing your income')
    ];

    $acceptedExtensions = collect($acceptedTypes)->map(function($type) {
        return match($type) {
            'image/jpeg' => 'JPG',
            'image/png' => 'PNG',
            'image/jpg' => 'JPEG',
            'application/pdf' => 'PDF',
            default => strtoupper(explode('/', $type)[1] ?? $type)
        };
    })->join(', ');
@endphp

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-text-primary">
            {{ $typeLabels[$type] ?? __('Document Upload') }}
            @if($required)
                <span class="text-error-500">*</span>
            @endif
        </label>
        <p class="mt-1 text-sm text-text-secondary">
            {{ $typeDescriptions[$type] ?? __('Please upload the required document') }}
        </p>
    </div>

    <div class="border-2 border-dashed border-border rounded-lg p-6 transition-colors hover:border-primary-400">
        <div class="text-center">
            <x-ui.icon name="document" class="mx-auto h-12 w-12 text-text-muted" />

            <div class="mt-4">
                <label for="{{ $uploadId }}" class="cursor-pointer">
                    <span class="mt-2 block text-sm font-medium text-primary-600 hover:text-primary-500">
                        {{ __('Choose file') }}
                    </span>
                </label>
                <p class="mt-1 text-xs text-text-muted">
                    {{ __('or drag and drop') }}
                </p>
            </div>

            <p class="mt-2 text-xs text-text-muted">
                {{ __('Accepted formats: :formats', ['formats' => $acceptedExtensions]) }}
                ({{ __('Max size: :size', ['size' => $maxSize]) }})
            </p>
        </div>

        <input
            id="{{ $uploadId }}"
            type="file"
            name="{{ $type }}[]"
            {{ $multiple ? 'multiple' : '' }}
            {{ $required ? 'required' : '' }}
            accept="{{ implode(',', $acceptedTypes) }}"
            class="sr-only"
            data-max-size="{{ $maxSize }}"
            onchange="handleKycFileSelect(this, '{{ $type }}')"
        />
    </div>

    <!-- File preview area -->
    <div id="{{ $uploadId }}-preview" class="space-y-2"></div>
</div>

<script>
function handleKycFileSelect(input, type) {
    const previewContainer = document.getElementById(input.id + '-preview');
    previewContainer.innerHTML = '';

    if (input.files && input.files.length > 0) {
        Array.from(input.files).forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between p-3 bg-surface rounded-md border border-border';

            const fileInfo = document.createElement('div');
            fileInfo.className = 'flex items-center space-x-3';

            const fileIcon = document.createElement('div');
            fileIcon.innerHTML = '<svg class="w-5 h-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>';

            const fileDetails = document.createElement('div');
            fileDetails.innerHTML = `
                <p class="text-sm font-medium text-text-primary">${file.name}</p>
                <p class="text-xs text-text-secondary">${formatFileSize(file.size)}</p>
            `;

            fileInfo.appendChild(fileIcon);
            fileInfo.appendChild(fileDetails);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'text-error-500 hover:text-error-700 p-1';
            removeBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            removeBtn.onclick = () => {
                // Remove file from input and preview
                const dt = new DataTransfer();
                const files = Array.from(input.files);
                files.splice(index, 1);
                files.forEach(f => dt.items.add(f));
                input.files = dt.files;
                fileItem.remove();
            };

            fileItem.appendChild(fileInfo);
            fileItem.appendChild(removeBtn);
            previewContainer.appendChild(fileItem);
        });
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>