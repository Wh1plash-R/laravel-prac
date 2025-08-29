<header class="bg-white/90 backdrop-blur shadow-md sticky top-0 z-10 border-b border-gray-200">
    <nav class="container mx-auto flex items-center justify-between py-4 px-6" x-data="{ open: false }">
        <div class="flex items-center gap-3">
            <span class="inline-block bg-gradient-to-r from-[#35b5ac] to-[#35b5ac]/70 text-white rounded-full px-3 py-1 text-lg font-extrabold shadow-sm tracking-tight">
                <a href="{{ route('welcome') }}" class="hover:text-[#f3f3f3] transition">アグアド大好</a>
            </span>
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">
                {{ $title ?? '' }}
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
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endif
            {{ $slot ?? '' }}
        </div>
    </nav>
</header>
