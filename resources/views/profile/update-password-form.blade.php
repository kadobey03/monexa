<div class="space-y-8 password-form-wrapper">
    <!-- Password Introduction -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <x-heroicon name="lock-closed" class="h-5 w-5 text-blue-500" aria-hidden="true" />
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700 dark:text-blue-400">
                    {{ __('user.profile.password.security_intro') }}
                </p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{route('updateuserpass')}}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Password Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Current Password -->
            <div class="space-y-2">
                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('user.profile.password.current_password') }}
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon name="key" class="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        class="pl-10 pr-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm py-4"
                        required
                        placeholder="{{ __('user.profile.password.current_password_placeholder') }}"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center px-3">
                        <button
                            type="button"
                            onclick="togglePasswordVisibility('current_password')"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none"
                        >
                            <x-heroicon name="eye" class="h-5 w-5 eye-icon" />
                            <x-heroicon name="eye-slash" class="h-5 w-5 eye-off-icon" style="display: none;" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- New Password -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('user.profile.password.new_password') }}
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon name="lock-closed" class="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="pl-10 pr-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm py-4"
                        required
                        placeholder="{{ __('user.profile.password.new_password_placeholder') }}"
                        oninput="checkPasswordStrength(this.value)"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center px-3">
                        <button
                            type="button"
                            onclick="togglePasswordVisibility('password')"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none"
                        >
                            <x-heroicon name="eye" class="h-5 w-5 eye-icon" />
                            <x-heroicon name="eye-slash" class="h-5 w-5 eye-off-icon" style="display: none;" />
                        </button>
                    </div>
                </div>

                <!-- Password Strength Meter -->
                <div class="mt-2">
                    <div class="flex items-center justify-between mb-1">
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400" id="password-feedback"></div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('user.profile.password.strength') }}</div>
                    </div>
                    <div class="h-1.5 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div
                            id="password-strength-bar"
                            class="h-full transition-all duration-300 ease-out rounded-full bg-red-500"
                            style="width: 0%"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Confirm New Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('user.profile.password.confirm_password') }}
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon name="check-circle" class="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="pl-10 pr-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm py-4"
                        required
                        placeholder="{{ __('user.profile.password.confirm_password_placeholder') }}"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center px-3">
                        <button
                            type="button"
                            onclick="togglePasswordVisibility('password_confirmation')"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none"
                        >
                            <x-heroicon name="eye" class="h-5 w-5 eye-icon" />
                            <x-heroicon name="eye-slash" class="h-5 w-5 eye-off-icon" style="display: none;" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Button -->
        <div class="pt-4">
            <button
                type="submit"
                class="inline-flex items-center px-6 py-4 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
            >
                <x-heroicon name="save" class="mr-2 h-5 w-5" />
                {{ __('user.profile.password.update_button') }}
            </button>
        </div>
    </form>
</div>

<!-- Password Requirements Card -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm mt-8">
    <div class="p-5">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                <x-heroicon name="shield-check" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" />
            </div>
            <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('user.profile.password.requirements_title') }}</h3>
        </div>

        <div class="space-y-3 pl-2">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <x-heroicon name="check-circle" class="h-5 w-5 text-green-500" />
                </div>
                <p class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                    {{ __('user.profile.password.requirement_length') }}
                </p>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <x-heroicon name="check-circle" class="h-5 w-5 text-green-500" />
                </div>
                <p class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                    {{ __('user.profile.password.requirement_lowercase') }}
                </p>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <x-heroicon name="check-circle" class="h-5 w-5 text-green-500" />
                </div>
                <p class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                    {{ __('user.profile.password.requirement_uppercase') }}
                </p>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <x-heroicon name="check-circle" class="h-5 w-5 text-green-500" />
                </div>
                <p class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                    {{ __('user.profile.password.requirement_number') }}
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling.querySelector('button');
    const eyeIcon = button.querySelector('.eye-icon');
    const eyeOffIcon = button.querySelector('.eye-off-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.style.display = 'none';
        eyeOffIcon.style.display = 'block';
    } else {
        input.type = 'password';
        eyeIcon.style.display = 'block';
        eyeOffIcon.style.display = 'none';
    }
}

function checkPasswordStrength(password) {
    const feedbackElement = document.getElementById('password-feedback');
    const strengthBar = document.getElementById('password-strength-bar');
    
    if (!password) {
        strengthBar.style.width = '0%';
        feedbackElement.textContent = '';
        return;
    }

    let strength = 0;

    // Length check
    if (password.length >= 8) strength += 25;

    // Character variety checks
    if (password.match(/[a-z]+/)) strength += 25; // lowercase
    if (password.match(/[A-Z]+/)) strength += 25; // uppercase
    if (password.match(/[0-9]+/) || password.match(/[^a-zA-Z0-9]+/)) strength += 25; // numbers or symbols

    strengthBar.style.width = strength + '%';

    // Update colors and feedback
    if (strength < 25) {
        strengthBar.className = 'h-full transition-all duration-300 ease-out rounded-full bg-red-500';
        feedbackElement.textContent = "{{ __('user.profile.password.strength_very_weak') }}";
    } else if (strength < 50) {
        strengthBar.className = 'h-full transition-all duration-300 ease-out rounded-full bg-red-500';
        feedbackElement.textContent = "{{ __('user.profile.password.strength_weak') }}";
    } else if (strength < 75) {
        strengthBar.className = 'h-full transition-all duration-300 ease-out rounded-full bg-yellow-500';
        feedbackElement.textContent = "{{ __('user.profile.password.strength_medium') }}";
    } else {
        strengthBar.className = 'h-full transition-all duration-300 ease-out rounded-full bg-green-500';
        feedbackElement.textContent = "{{ __('user.profile.password.strength_strong') }}";
    }
}

document.addEventListener('DOMContentLoaded', function() {

});
</script>