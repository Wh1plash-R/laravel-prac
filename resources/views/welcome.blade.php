<x-layout>
    <h1></h1>
    <div class="h-auto max-w-5xl flex">
        <!-- Left Panel - Image -->
        <div class="hidden lg:flex w-[60%] items-center justify-center ">
            
            <img src="{{ asset('images/welcomeImage.png') }}" alt="Logo" class="scale-100">
            
        </div>

        <!-- Right Panel - Login Form -->
        <div class="w-full lg:w-[40%] flex items-center justify-center p-8 shadow-lg border border-gray-200 rounded-2xl">
            <div class="max-w-md w-full">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-xl mb-5">Logo Wala pa</h1>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back!</h1>
                    <p class="text-gray-600 text-sm">Simplify your workflow and boost your productivity with <b>ヨルシカ's</b> learning app. Get started for free.</p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    
                    <!-- Username Field -->
                    <div class="relative">
                        <input 
                            type="text" 
                            name="username"
                            placeholder="Username"
                            value="{{ old('username') }}"
                            class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#35b5ac] focus:border-transparent transition-all duration-200 @error('username') border-red-500 @enderror"
                            required
                        >
                        @error('username')
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
                            class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#35b5ac] focus:border-transparent transition-all duration-200 pr-12 @error('password') border-red-500 @enderror"
                            required
                        >
                        <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-[#35b5ac] shadow-sm g focus:ring-blue-200 focus:ring-opacity-0">
                            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#35b5ac] hover:text-[#35b5ac]/80 transition-colors">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit"
                        class="w-full bg-[#35b5ac] text-white py-4 rounded-2xl font-semibold hover:bg-[#35b5ac]/80 transition-colors duration-200 shadow-lg"
                    >
                        Login
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center mt-1">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                    </div>
                    
                </form>

                <!-- Register Link -->
                <div class="text-center text-sm mt-8">
                    <p class="text-gray-600">
                        Not a member? 
                        <a href="{{ route('register') }}" class="text-[#35b5ac] hover:text-[#35b5ac]/80 font-semibold transition-colors">
                            Register now
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add password visibility toggle
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