<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.apiBase = "{{ url('api') }}";
    </script>
    <title>Rouin</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen font-[Inter,sans-serif] text-gray-800">
    @if (session('success'))
    <div class="flex justify-center pt-6">
        <div id="flash" class="p-4 mb-4 bg-green-100 text-green-900 border border-green-300 rounded-lg shadow w-full max-w-md text-center animate-fade-in">
            {{ session('success') }}
        </div>
    </div>

    <script>
        // Wait 2 seconds, then hide the flash message
        setTimeout(function () {
            const flash = document.getElementById('flash');
            if (flash) {
                flash.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => flash.remove(), 500);
            }
        }, 2000);
    </script>
    @endif

    <header class="bg-white/90 backdrop-blur shadow-md sticky top-0 z-10 border-b border-gray-200">
        <nav class="container mx-auto flex items-center justify-between py-4 px-6" x-data="{ open: false }">
            <div class="flex items-center gap-3">
                <span class="inline-block bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full px-3 py-1 text-lg font-extrabold shadow-sm tracking-tight">
                <a href="{{ route('welcome') }}" class="hover:text-blue-600 focus:text-blue-700 transition">ヨルシカ</a>
                </span>
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">
                </h1>
            </div>
            <div class="flex gap-2">
                @if(auth()->check())
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('learners.index') }}" class="px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow border border-blue-700">All Learners</a>
                    <a href="{{ route('learners.add') }}" class="px-4 py-2 rounded-lg font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition shadow border border-indigo-700">Add New Learner</a>
                    @endif
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

            </div>
            @endif
        </nav>
    </header>
    <main class="container mx-auto px-4 py-10 max-w-3xl">
        <div class="bg-white rounded-2xl shadow-lg p-8 min-h-[60vh] border border-gray-200">
            {{ $slot }}
        </div>
    </main>
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease;
        }
    </style>
</body>

@vite('resources/js/app.js')
<livewire:scripts />
</html>
