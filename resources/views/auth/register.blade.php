<x-layout :title="'Register'" :header="false">
    <h1></h1>
    <div class="h-auto max-w-5xl flex">
        <!-- Left Panel - Register Form -->
        <div class="w-full lg:w-[40%] flex items-center justify-center p-8 shadow-lg border border-gray-200 rounded-2xl">
            <div class="max-w-md w-full">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-xl mb-5">Logo Wala pa</h1>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Create your account</h1>
                    <p class="text-gray-600 text-sm">Join <b>ヨルシカ's</b> learning app and get started for free.</p>
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
                            class="w-full px-4 py-4 bg-gray-50 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-200' }} rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#35b5ac] focus:border-transparent transition-all duration-200"
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
                            class="w-full px-4 py-4 bg-gray-50 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#35b5ac] focus:border-transparent transition-all duration-200"
                            required
                            autocomplete="username"
                        >
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
                            placeholder="Password"
                            class="w-full px-4 py-4 bg-gray-50 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }} rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#35b5ac] focus:border-transparent transition-all duration-200 pr-12"
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
                            placeholder="Confirm Password"
                            class="w-full px-4 py-4 bg-gray-50 border {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-200' }} rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#35b5ac] focus:border-transparent transition-all duration-200 pr-12"
                            required
                            autocomplete="new-password"
                        >
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="w-full bg-[#35b5ac] text-white py-4 rounded-2xl font-semibold hover:bg-[#35b5ac]/80 transition-colors duration-200 shadow-lg disabled:opacity-70 disabled:cursor-not-allowed"
                        x-bind:disabled="loading"
                    >
                        <span x-show="!loading">Register</span>
                        <span x-show="loading" class="inline-flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>

                    <!-- Already registered -->
                    <div class="text-center text-sm mt-6">
                        <p class="text-gray-600">
                            Already registered?
                            <a href="{{ route('welcome') }}" class="text-[#35b5ac] hover:text-[#35b5ac]/80 font-semibold transition-colors">Log in</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Panel - Image -->
        <div class="hidden lg:flex w-[60%] items-center justify-center ">
            <img src="{{ asset('images/welcomeImage.png') }}" alt="Logo" class="scale-100">
        </div>
    </div>

    <script>
        // Password visibility toggle for Register
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('togglePassword');

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
        });
    </script>
</x-layout>
