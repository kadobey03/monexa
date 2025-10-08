
<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8"
     x-data="{
        currentStep: 1,
        documentType: 'passport',
        isSubmitting: false,
        progress: 33,
        showPreview: false,
        frontPreview: null,
        backPreview: null,
        documentTypes: {
            passport: 'International Passport',
            national_id: 'National ID Card',
            drivers_license: 'Driver\'s License'
        }
     }">

    <!-- Alert Messages -->
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.danger-alert','data' => []]); ?>
<?php $component->withName('danger-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.success-alert','data' => []]); ?>
<?php $component->withName('success-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.error-alert','data' => []]); ?>
<?php $component->withName('error-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <!-- Header Section -->
    <div class="mb-6 sm:mb-8">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-600/10 text-blue-400 rounded-full text-sm font-medium mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Secure Verification Process
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Account Verification</h1>
            <p class="text-gray-400 text-sm sm:text-base max-w-2xl mx-auto">
                Complete your KYC verification to unlock full trading features and ensure account security
            </p>
        </div>
    </div>

    <!-- Progress Indicator -->
    <div class="bg-gray-900 rounded-xl p-4 sm:p-6 border border-gray-800 mb-6 sm:mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-white">Verification Progress</h2>
            <span class="text-sm text-gray-400" x-text="`Step ${currentStep} of 3`"></span>
        </div>

        <!-- Progress Bar -->
        <div class="w-full bg-gray-800 rounded-full h-2 mb-4">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 h-2 rounded-full transition-all duration-500"
                 :style="`width: ${progress}%`"></div>
        </div>

        <!-- Steps -->
        <div class="flex items-center justify-between">
            <div class="flex items-center" :class="currentStep >= 1 ? 'text-blue-400' : 'text-gray-500'">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-medium border-2"
                     :class="currentStep >= 1 ? 'bg-blue-600 border-blue-600 text-white' : 'border-gray-600 text-gray-400'">
                    <svg x-show="currentStep > 1" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span x-show="currentStep <= 1">1</span>
                </div>
                <span class="ml-2 text-xs sm:text-sm font-medium hidden sm:block">Personal Info</span>
            </div>

            <div class="flex items-center" :class="currentStep >= 2 ? 'text-blue-400' : 'text-gray-500'">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-medium border-2"
                     :class="currentStep >= 2 ? 'bg-blue-600 border-blue-600 text-white' : 'border-gray-600 text-gray-400'">
                    <svg x-show="currentStep > 2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span x-show="currentStep <= 2">2</span>
                </div>
                <span class="ml-2 text-xs sm:text-sm font-medium hidden sm:block">Address</span>
            </div>

            <div class="flex items-center" :class="currentStep >= 3 ? 'text-blue-400' : 'text-gray-500'">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-medium border-2"
                     :class="currentStep >= 3 ? 'bg-blue-600 border-blue-600 text-white' : 'border-gray-600 text-gray-400'">
                    <span>3</span>
                </div>
                <span class="ml-2 text-xs sm:text-sm font-medium hidden sm:block">Documents</span>
            </div>
        </div>
    </div>

    <!-- Main Verification Form -->
    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <!-- Form Header -->
        <div class="p-4 sm:p-6 border-b border-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-white">Identity Verification</h2>
                    <p class="text-gray-400 text-xs sm:text-sm">Secure your account with government-issued ID verification</p>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <form action="<?php echo e(route('kycsubmit')); ?>" method="POST" enctype="multipart/form-data"
              x-on:submit="isSubmitting = true" class="p-4 sm:p-6">
            <?php echo csrf_field(); ?>

            <!-- Step 1: Personal Details -->
            <div x-show="currentStep === 1" x-transition>
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-blue-600/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Personal Information</h3>
                            <p class="text-gray-400 text-sm">Provide your personal details as they appear on your ID</p>
                        </div>
                    </div>

                    <div class="bg-blue-600/10 rounded-lg p-3 sm:p-4 mb-6 border border-blue-600/20">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-blue-400 font-medium text-sm mb-1">Important Notice</p>
                                <p class="text-blue-300 text-xs sm:text-sm">
                                    Please ensure all information matches exactly with your government-issued ID. Details cannot be modified after submission.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            First Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="first_name" required
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            Last Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="last_name" required
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            Email Address <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            Phone Number <span class="text-red-400">*</span>
                        </label>
                        <input type="tel" name="phone_number" required
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            Date of Birth <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="dob" required
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            Social Media Username (Optional)
                        </label>
                        <input type="text" name="social_media"
                               placeholder="@username"
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    <button type="button" @click="currentStep = 2; progress = 66"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                        Continue to Address
                        <svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Step 2: Address Details -->
            <div x-show="currentStep === 2" x-transition>
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-600/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Address Information</h3>
                            <p class="text-gray-400 text-sm">Your current residential address for verification</p>
                        </div>
                    </div>

                    <div class="bg-amber-600/10 rounded-lg p-3 sm:p-4 mb-6 border border-amber-600/20">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div>
                                <p class="text-amber-400 font-medium text-sm mb-1">Address Verification</p>
                                <p class="text-amber-300 text-xs sm:text-sm">
                                    Ensure your address matches your supporting documents exactly.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            Street Address <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="address" required
                               placeholder="Enter your complete street address"
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-300">
                                City <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="city" required
                                   placeholder="Enter your city"
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-300">
                                State/Province <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="state" required
                                   placeholder="Enter your state or province"
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            Country/Nationality <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="country" required
                               placeholder="Enter your country"
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between gap-4 mt-8">
                    <button type="button" @click="currentStep = 1; progress = 33"
                            class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-medium transition-all duration-200 order-2 sm:order-1">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Previous
                    </button>
                    <button type="button" @click="currentStep = 3; progress = 100"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl order-1 sm:order-2">
                        Continue to Documents
                        <svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Step 3: Document Upload -->
            <div x-show="currentStep === 3" x-transition>
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-purple-600/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Document Upload</h3>
                            <p class="text-gray-400 text-sm">Upload clear photos of your government-issued ID</p>
                        </div>
                    </div>
                </div>

                <!-- Document Type Selection -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-300 mb-4">
                        Select Document Type <span class="text-red-400">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="document_type" value="Int'l Passport" x-model="documentType" class="sr-only">
                            <div class="p-4 rounded-xl border-2 transition-all text-center bg-gray-800 hover:bg-gray-700"
                                 :class="documentType === 'passport' ? 'border-blue-500 bg-blue-600/10' : 'border-gray-700 hover:border-gray-600'">
                                <div class="w-12 h-12 bg-blue-600/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div class="font-medium text-white text-sm">International Passport</div>
                                <div class="text-gray-400 text-xs mt-1">Most accepted globally</div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer group">
                            <input type="radio" name="document_type" value="National ID" x-model="documentType" class="sr-only">
                            <div class="p-4 rounded-xl border-2 transition-all text-center bg-gray-800 hover:bg-gray-700"
                                 :class="documentType === 'national_id' ? 'border-blue-500 bg-blue-600/10' : 'border-gray-700 hover:border-gray-600'">
                                <div class="w-12 h-12 bg-green-600/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div class="font-medium text-white text-sm">National ID Card</div>
                                <div class="text-gray-400 text-xs mt-1">Government issued ID</div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer group">
                            <input type="radio" name="document_type" value="Drivers License" x-model="documentType" class="sr-only">
                            <div class="p-4 rounded-xl border-2 transition-all text-center bg-gray-800 hover:bg-gray-700"
                                 :class="documentType === 'drivers_license' ? 'border-blue-500 bg-blue-600/10' : 'border-gray-700 hover:border-gray-600'">
                                <div class="w-12 h-12 bg-amber-600/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <div class="font-medium text-white text-sm">Driver's License</div>
                                <div class="text-gray-400 text-xs mt-1">Valid driving license</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Requirements Notice -->
                <div class="bg-gradient-to-r from-amber-600/10 to-orange-600/10 rounded-xl p-4 sm:p-6 mb-8 border border-amber-600/20">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-amber-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-amber-300 mb-3 text-sm">Document Requirements</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-amber-200 text-xs">Not expired or damaged</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-amber-200 text-xs">All text clearly visible</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-amber-200 text-xs">No glare or shadows</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-amber-200 text-xs">High resolution image</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Upload Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Front Side Upload -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-300">
                            Front Side <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="frontimg" required accept="image/*"
                                   @change="frontPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="border-2 border-dashed border-gray-600 rounded-xl p-6 text-center bg-gray-800 hover:bg-gray-750 hover:border-blue-500 transition-all">
                                <div x-show="!frontPreview">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-gray-400 font-medium mb-2">Upload Front Side</p>
                                    <p class="text-gray-500 text-xs">PNG, JPG up to 10MB</p>
                                </div>
                                <div x-show="frontPreview" class="space-y-3">
                                    <img :src="frontPreview" class="w-full h-32 object-cover rounded-lg mx-auto">
                                    <p class="text-green-400 text-sm font-medium">Front side uploaded</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Side Upload -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-300">
                            Back Side <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="backimg" required accept="image/*"
                                   @change="backPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="border-2 border-dashed border-gray-600 rounded-xl p-6 text-center bg-gray-800 hover:bg-gray-750 hover:border-blue-500 transition-all">
                                <div x-show="!backPreview">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-gray-400 font-medium mb-2">Upload Back Side</p>
                                    <p class="text-gray-500 text-xs">PNG, JPG up to 10MB</p>
                                </div>
                                <div x-show="backPreview" class="space-y-3">
                                    <img :src="backPreview" class="w-full h-32 object-cover rounded-lg mx-auto">
                                    <p class="text-green-400 text-sm font-medium">Back side uploaded</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms Agreement -->
                <div class="bg-gray-800 rounded-xl p-4 sm:p-6 mb-8 border border-gray-700">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input type="checkbox" required
                               class="mt-1 w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                        <div class="flex-1">
                            <span class="text-gray-300 text-sm leading-relaxed">
                                I confirm that all information provided is accurate and the documents are authentic.
                                I understand that providing false information may result in account suspension and
                                agree to the <a href="#" class="text-blue-400 hover:text-blue-300 underline">Terms of Service</a>
                                and <a href="#" class="text-blue-400 hover:text-blue-300 underline">Privacy Policy</a>.
                            </span>
                        </div>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    <button type="button" @click="currentStep = 2; progress = 66"
                            class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-medium transition-all duration-200 order-2 sm:order-1">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Previous
                    </button>

                    <?php if(Auth::user()->account_verify == 'Under review'): ?>
                        <button type="button" disabled
                                class="px-8 py-3 bg-gray-600 text-gray-300 rounded-lg font-medium cursor-not-allowed order-1 sm:order-2 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Under Review
                        </button>
                    <?php else: ?>
                        <button type="submit"
                                :disabled="isSubmitting"
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 disabled:from-gray-600 disabled:to-gray-700 text-white rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl disabled:cursor-not-allowed order-1 sm:order-2 flex items-center justify-center gap-2">
                            <svg x-show="isSubmitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <svg x-show="!isSubmitting" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span x-show="!isSubmitting">Submit Application</span>
                            <span x-show="isSubmitting">Submitting...</span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <!-- Security Notice -->
    <div class="mt-6 sm:mt-8 bg-gray-900/50 rounded-xl p-4 sm:p-6 border border-gray-800">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 bg-green-600/10 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-2">Your Privacy is Protected</h4>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Your documents are encrypted and stored securely. We use bank-level security measures to protect your personal information
                    and comply with international data protection regulations.
                </p>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('verificationForm', () => ({
        init() {
            // Initialize any additional functionality
            console.log('Verification form initialized');
        }
    }));
});
</script>
<style>
    [x-cloak] {
        display: none !important;
    }

    .bg-gray-750 {
        background-color: rgb(55, 65, 81);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/elitemaxpro/up.elitemaxpro.click/resources/views/user/verification.blade.php ENDPATH**/ ?>