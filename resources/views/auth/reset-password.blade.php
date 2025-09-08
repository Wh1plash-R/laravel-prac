<x-layout :title="'Reset Password'" :header="false">
    <h1></h1>
    <div class="h-auto max-w-7xl flex space-x-10">
        <!-- Left Panel - Reset Password Form -->
        <div class="bg-white w-full lg:w-[35%] flex items-center justify-center p-8 shadow-lg border border-gray-200 rounded-2xl">
            <div class="max-w-md w-full">
                <!-- Header -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-24 mx-auto">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Reset Password</h1>
                    <p class="text-gray-600 text-sm">Enter your new password below to complete the reset process.</p>
                </div>

                <!-- Reset Password Form -->
                <form method="POST" action="{{ route('password.store') }}" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Field -->
                    <div class="relative">
                        <input
                            type="email"
                            name="email"
                            placeholder="Email"
                            value="{{ old('email', $request->email) }}"
                            class="w-full px-4 py-4 bg-gray-100 border border-gray-300 rounded-2xl focus:outline-none transition-all duration-200 cursor-not-allowed"
                            required
                            readonly
                            autocomplete="username"
                        >
                        <!-- Lock Icon -->
                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="New Password"
                            class="w-full px-4 py-4 bg-gray-50 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }} rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:border-transparent transition-all duration-200 pr-12"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="relative">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="Confirm New Password"
                            class="w-full px-4 py-4 bg-gray-50 border {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-200' }} rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:border-transparent transition-all duration-200 pr-12"
                            required
                            autocomplete="new-password"
                        >
                        <!-- Password Match Indicator -->
                        <div id="passwordMatchIndicator" class="absolute right-4 top-1/2 transform -translate-y-1/2 hidden">
                            <!-- Check mark for match -->
                            <svg id="passwordMatchCheck" class="w-5 h-5 text-green-500 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5"/>
                            </svg>
                            <!-- X mark for no match -->
                            <svg id="passwordMatchX" class="w-5 h-5 text-red-500 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6L6 18M6 6l12 12"/>
                            </svg>
                        </div>
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-[#faa125] text-white py-4 rounded-2xl font-semibold hover:bg-[#faa125]/80 transition-colors duration-200 shadow-lg disabled:opacity-70 disabled:cursor-not-allowed"
                        x-bind:disabled="loading"
                    >
                        <span x-show="!loading">Reset Password</span>
                        <span x-show="loading" class="inline-flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            Resetting...
                        </span>
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center text-sm mt-6">
                        <p class="text-gray-600">
                            Remember your password?
                            <a href="{{ route('welcome') }}" class="text-[#faa125] hover:text-[#faa125]/80 font-semibold transition-colors">Back to Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Panel - Image -->
        <div class="hidden lg:flex w-[65%] items-center justify-center">
            <img src="{{ asset('images/welcomeImage.png') }}" alt="Reset Password" class="scale-100">
        </div>
    </div>

    <script>
        // Password visibility toggle and match indicator for Reset Password
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const toggleButton = document.getElementById('togglePassword');
            const passwordMatchIndicator = document.getElementById('passwordMatchIndicator');
            const passwordMatchCheck = document.getElementById('passwordMatchCheck');
            const passwordMatchX = document.getElementById('passwordMatchX');

            // Password visibility toggle
            if (toggleButton && passwordInput) {
                toggleButton.addEventListener('click', function() {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        toggleButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off"><path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/></svg>';
                    } else {
                        passwordInput.type = 'password';
                        toggleButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>';
                    }
                });
            }

            // Password match checking
            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (confirmPassword.length === 0) {
                    // Hide indicator if confirm password is empty
                    passwordMatchIndicator.classList.add('hidden');
                    return;
                }

                // Show indicator
                passwordMatchIndicator.classList.remove('hidden');

                if (password === confirmPassword) {
                    // Passwords match - show check mark
                    passwordMatchCheck.classList.remove('hidden');
                    passwordMatchX.classList.add('hidden');
                } else {
                    // Passwords don't match - show X mark
                    passwordMatchCheck.classList.add('hidden');
                    passwordMatchX.classList.remove('hidden');
                }
            }

            // Add event listeners for password match checking
            if (passwordInput && confirmPasswordInput) {
                passwordInput.addEventListener('input', checkPasswordMatch);
                confirmPasswordInput.addEventListener('input', checkPasswordMatch);
            }
        });
    </script>
</x-layout>
