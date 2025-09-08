<section class="space-y-8">
    <header class="border-b border-gray-200 pb-6">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#35b5ac] to-[#2dd4aa] flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __('Update Password') }}
            </h2>
        </div>
        <p class="text-gray-600 leading-relaxed">
            {{ __('Ensure your account is using a long, random password to stay secure. We recommend using a password manager to generate and store strong passwords.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password Field -->
        <div class="space-y-2">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-gray-700 font-semibold" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <x-text-input id="update_password_current_password" name="current_password" type="password"
                    class="pl-10 w-full border-gray-300 focus:border-[#35b5ac] focus:ring-[#35b5ac] rounded-lg shadow-sm transition-colors"
                    autocomplete="current-password"
                    placeholder="Enter your current password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
        </div>

        <!-- New Password Field -->
        <div class="space-y-2">
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-gray-700 font-semibold" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <x-text-input id="update_password_password" name="password" type="password"
                    class="pl-10 w-full border-gray-300 focus:border-[#35b5ac] focus:ring-[#35b5ac] rounded-lg shadow-sm transition-colors"
                    autocomplete="new-password"
                    placeholder="Enter your new password" />
            </div>
            <x-input-error id="update-password-server-error" :messages="$errors->updatePassword->get('password')" class="mt-1" />

            <!-- Password Requirements -->
            <div class="mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h4 class="text-sm font-semibold text-blue-800 mb-2">Password Requirements:</h4>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        At least 8 characters long
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Mix of uppercase and lowercase letters
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Include numbers and special characters
                    </li>
                </ul>
            </div>
        </div>

        <!-- Confirm Password Field -->
        <div class="space-y-2">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')" class="text-gray-700 font-semibold" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg id="update-password-confirm-icon" class="h-5 w-5 text-gray-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="pl-10 w-full border-gray-300 focus:border-[#35b5ac] focus:ring-[#35b5ac] rounded-lg shadow-sm transition-colors"
                    autocomplete="new-password"
                    placeholder="Confirm your new password" />
            </div>
            <x-input-error id="update-password-confirmation-server-error" :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
            <button type="submit"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#35b5ac] to-[#2dd4aa] border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider hover:from-[#2dd4aa] hover:to-[#35b5ac] focus:outline-none focus:ring-2 focus:ring-[#35b5ac] focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-200 rounded-lg text-green-800">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ __('Password updated successfully!') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.getElementById('update_password_password');
    const confirmPasswordInput = document.getElementById('update_password_password_confirmation');
    const confirmIcon = document.getElementById('update-password-confirm-icon');

    // Clear server validation errors
    function clearServerErrors() {
        const passwordServerError = document.getElementById('update-password-server-error');
        const confirmPasswordServerError = document.getElementById('update-password-confirmation-server-error');

        if (passwordServerError && passwordServerError.children.length > 0) {
            passwordServerError.style.display = 'none';
            // Reset new password field border to default
            newPasswordInput.className = 'pl-10 w-full border-gray-300 focus:border-[#35b5ac] focus:ring-[#35b5ac] rounded-lg shadow-sm transition-colors';
        }
        if (confirmPasswordServerError && confirmPasswordServerError.children.length > 0) {
            confirmPasswordServerError.style.display = 'none';
            // Reset confirm password field border to default (only if no client-side validation is showing)
            if (confirmIcon.classList.contains('text-gray-400')) {
                confirmPasswordInput.className = 'pl-10 w-full border-gray-300 focus:border-[#35b5ac] focus:ring-[#35b5ac] rounded-lg shadow-sm transition-colors';
            }
        }
    }

    // Password confirmation validation
    function validatePasswordMatch() {
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        // Only show validation if confirm password field has content
        if (confirmPassword.length === 0) {
            resetPasswordMatchIndicator();
            return;
        }

        if (newPassword === confirmPassword && newPassword.length > 0) {
            showPasswordMatch(true);
        } else {
            showPasswordMatch(false);
        }
    }

    function showPasswordMatch(isMatch) {
        if (isMatch) {
            // Show success state - green icon and border
            confirmIcon.classList.remove('text-gray-400', 'text-red-500');
            confirmIcon.classList.add('text-green-500');
            confirmPasswordInput.className = 'pl-10 w-full border-green-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm transition-colors';
        } else {
            // Show error state - red icon and border
            confirmIcon.classList.remove('text-gray-400', 'text-green-500');
            confirmIcon.classList.add('text-red-500');
            confirmPasswordInput.className = 'pl-10 w-full border-red-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm transition-colors';
        }
    }

    function resetPasswordMatchIndicator() {
        // Reset to default styling - gray icon and border
        confirmIcon.classList.remove('text-green-500', 'text-red-500');
        confirmIcon.classList.add('text-gray-400');
        confirmPasswordInput.className = 'pl-10 w-full border-gray-300 focus:border-[#35b5ac] focus:ring-[#35b5ac] rounded-lg shadow-sm transition-colors';
    }

    // Add event listeners for real-time validation
    if (newPasswordInput && confirmPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            clearServerErrors();
            validatePasswordMatch();
        });

        confirmPasswordInput.addEventListener('input', function() {
            clearServerErrors();
            validatePasswordMatch();
        });

        // Also validate on blur for better UX
        confirmPasswordInput.addEventListener('blur', validatePasswordMatch);
    }
});
</script>
