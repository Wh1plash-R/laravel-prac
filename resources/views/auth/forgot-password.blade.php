<x-layout :title="'Forgot Password'" :header="false">
    <h1></h1>
    <div class="h-auto max-w-7xl flex space-x-10">
        <!-- Left Panel - Forgot Password Form -->
        <div class="bg-white w-full lg:w-[35%] flex items-center justify-center p-8 shadow-lg border border-gray-200 rounded-2xl">
            <div class="max-w-md w-full">
                <!-- Header -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-24 mx-auto">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Forgot Password?</h1>
                    <p class="text-gray-600 text-sm">No problem! Just let us know your email address and we will email you a password reset link.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-green-700 text-sm font-medium">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Forgot Password Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
                    @csrf

                    <!-- Email Field -->
                    <div class="relative">
                        <input
                            type="email"
                            name="email"
                            placeholder="Email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-4 bg-gray-50 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:border-transparent transition-all duration-200"
                            required
                            autofocus
                            autocomplete="email"
                        >
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-[#faa125] text-white py-4 rounded-2xl font-semibold hover:bg-[#faa125]/80 transition-colors duration-200 shadow-lg disabled:opacity-70 disabled:cursor-not-allowed"
                        x-bind:disabled="loading"
                    >
                        <span x-show="!loading">Send Reset Link</span>
                        <span x-show="loading" class="inline-flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            Sending...
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
            <img src="{{ asset('images/welcomeImage.png') }}" alt="Forgot Password" class="scale-100">
        </div>
    </div>
</x-layout>
