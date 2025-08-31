<header class="bg-white/90 backdrop-blur shadow-md sticky top-0 z-10 border-b border-gray-200">
    <nav class="mx-auto flex items-center justify-between py-4 px-6" x-data="{ open: false }">
        <div class="flex items-center gap-3">
            <a href="{{ route('welcome') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 mx-auto">
                <a href="{{ route('welcome') }}" class="hover:text-black/90 transition font-extrabold text-lg"><span class="text-[#faa125]">Bee</span>Course</a>
            </a>
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">
                {{ $title ?? '' }}
            </h1>
        </div>
        <div class="flex gap-2 items-center">
            @if(auth()->check())
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('learners.index') }}" class="px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow border border-blue-700">All Learners</a>
                    <a href="{{ route('learners.add') }}" class="px-4 py-2 rounded-lg font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition shadow border border-indigo-700">Add New Learner</a>
                @endif
                <div class="sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center justify-center w-10 h-10 rounded-full text-white font-semibold text-sm transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:ring-offset-2 {{ Auth::user()->profile_picture_url ? '' : 'bg-gradient-to-r from-[#faa125] to-[#fc662f] hover:bg-[#faa125]/90' }}">
                                @if(Auth::user()->profile_picture_url)
                                    <img src="{{ Auth::user()->profile_picture_url }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <!-- User Info Section -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full overflow-hidden flex items-center justify-center text-white font-semibold text-lg {{ Auth::user()->profile_picture_url ? '' : 'bg-gradient-to-r from-[#faa125] to-orange-600' }}">
                                        @if(Auth::user()->profile_picture_url)
                                            <img src="{{ Auth::user()->profile_picture_url }}" alt="Avatar" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                                        <div class="text-sm text-gray-600">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-1">
                                <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ __('Edit profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endif
            {{ $slot ?? '' }}
        </div>
    </nav>
</header>
