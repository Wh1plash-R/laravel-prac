<x-layout :title="'Register'" :header="false">
    <h1></h1>
    <div class="h-auto max-w-7xl flex space-x-10">
        <!-- Left Panel - Register Form -->
        <div class="bg-white w-full lg:w-[35%] flex items-center justify-center p-8 shadow-lg border border-gray-200 rounded-2xl">
            <div class="max-w-md w-full">
                <!-- Header -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-24 mx-auto">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Create your account</h1>
                    <p class="text-gray-600 text-sm">Join <b>BeeCourse's</b> learning app and get started for free.</p>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
                    @csrf

                    <!-- Name Field -->
                    <div class="relative">
                        <input
                            type="text"
                            name="name"
                            placeholder="Name"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-4 bg-gray-50 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-200' }} rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:border-transparent transition-all duration-200"
                            required
                            autocomplete="name"
                        >
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="relative">
                        <input
                            type="email"
                            name="email"
                            placeholder="Email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-4 bg-gray-50 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:border-transparent transition-all duration-200"
                            required
                            autocomplete="username"
                        >
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="relative">
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Password"
                                class="w-full px-4 py-4 bg-gray-50 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }} rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:border-transparent transition-all duration-200 pr-12"
                                required
                                autocomplete="new-password"
                            >
                            <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <p id="password-server-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="relative">
                        <div class="relative">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                placeholder="Confirm Password"
                                class="w-full px-4 py-4 bg-gray-50 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:border-transparent transition-all duration-200 pr-12"
                                required
                                autocomplete="new-password"
                            >
                            <!-- Password match indicator -->
                            <div id="password-match-indicator" class="absolute right-4 top-1/2 transform -translate-y-1/2 hidden z-10">
                                <!-- Success checkmark -->
                                <svg id="password-match-success" class="w-6 h-6 text-green-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <!-- Error X -->
                                <svg id="password-match-error" class="w-6 h-6 text-red-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Password match status message -->
                        <div id="password-match-message" class="text-xs mt-1 hidden">
                            <p id="password-match-text" class="transition-colors duration-200"></p>
                        </div>
                        @error('password_confirmation')
                            <p id="password-confirmation-server-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="w-full bg-[#faa125] text-white py-4 rounded-2xl font-semibold hover:bg-[#faa125]/80 transition-colors duration-200 shadow-lg disabled:opacity-70 disabled:cursor-not-allowed"
                        x-bind:disabled="loading"
                    >
                        <span x-show="!loading">Register</span>
                        <span x-show="loading" class="inline-flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            Registering...
                        </span>
                    </button>

                    <!-- Already registered -->
                    <div class="text-center text-sm mt-6">
                        <p class="text-gray-600">
                            Already registered?
                            <a href="{{ route('welcome') }}" class="text-[#faa125] hover:text-[#faa125]/80 font-semibold transition-colors">Log in</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Panel - Image -->
        <div class="hidden lg:flex w-[65%] items-center justify-center ">
            <img src="{{ asset('images/welcomeImage.png') }}" alt="Logo" class="scale-100">
        </div>
    </div>

    <script>
        // Password visibility toggle and password confirmation validation
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const toggleButton = document.getElementById('togglePassword');
            const matchIndicator = document.getElementById('password-match-indicator');
            const matchSuccess = document.getElementById('password-match-success');
            const matchError = document.getElementById('password-match-error');
            const matchMessage = document.getElementById('password-match-message');
            const matchText = document.getElementById('password-match-text');

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

            // Clear server validation errors
            function clearServerErrors() {
                const passwordServerError = document.getElementById('password-server-error');
                const confirmPasswordServerError = document.getElementById('password-confirmation-server-error');

                if (passwordServerError) {
                    passwordServerError.style.display = 'none';
                    // Reset password field border to default
                    passwordInput.className = 'w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:border-transparent transition-all duration-200 pr-12';
                }
                if (confirmPasswordServerError) {
                    confirmPasswordServerError.style.display = 'none';
                    // Reset confirm password field border to default (only if no client-side validation is showing)
                    if (matchIndicator.classList.contains('hidden')) {
                        confirmPasswordInput.className = 'w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:border-transparent transition-all duration-200 pr-12';
                    }
                }
            }

            // Password confirmation validation
            function validatePasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                // Only show validation if confirm password field has content
                if (confirmPassword.length === 0) {
                    hidePasswordMatchIndicator();
                    return;
                }

                if (password === confirmPassword && password.length > 0) {
                    showPasswordMatch(true);
                } else {
                    showPasswordMatch(false);
                }
            }

            function showPasswordMatch(isMatch) {
                matchIndicator.classList.remove('hidden');
                matchMessage.classList.remove('hidden');

                if (isMatch) {
                    // Show success state
                    matchSuccess.classList.remove('hidden');
                    matchError.classList.add('hidden');
                    matchText.textContent = 'Passwords match';
                    matchText.className = 'text-green-600 transition-colors duration-200';
                    confirmPasswordInput.className = 'w-full px-4 py-4 bg-gray-50 border border-green-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 pr-12';
                } else {
                    // Show error state
                    matchSuccess.classList.add('hidden');
                    matchError.classList.remove('hidden');
                    matchText.textContent = 'Passwords do not match';
                    matchText.className = 'text-red-600 transition-colors duration-200';
                    confirmPasswordInput.className = 'w-full px-4 py-4 bg-gray-50 border border-red-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 pr-12';
                }
            }

            function hidePasswordMatchIndicator() {
                matchIndicator.classList.add('hidden');
                matchMessage.classList.add('hidden');
                matchSuccess.classList.add('hidden');
                matchError.classList.add('hidden');
                // Reset to default styling
                confirmPasswordInput.className = 'w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:border-transparent transition-all duration-200 pr-12';
            }

            // Add event listeners for real-time validation
            if (passwordInput && confirmPasswordInput) {
                passwordInput.addEventListener('input', function() {
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
</x-layout>
