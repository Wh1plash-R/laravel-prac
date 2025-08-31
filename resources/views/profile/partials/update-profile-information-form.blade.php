<section class="space-y-8">
    <header class="border-b border-gray-200 pb-6">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#faa125] to-[#fc662f] flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __('Profile Information') }}
            </h2>
        </div>
        <p class="text-gray-600 leading-relaxed">
            {{ __("Update your account's profile information and email address to keep your profile current and secure.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('dashboard.update', $user->id) }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div class="space-y-2">
            <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 font-semibold" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <x-text-input id="name" name="name" type="text"
                    class="pl-10 w-full border-gray-300 focus:border-[#faa125] focus:ring-[#faa125] rounded-lg shadow-sm transition-colors"
                    :value="old('name', $user->name)" required autofocus autocomplete="name"
                    placeholder="Enter your full name" />
            </div>
            <x-input-error class="mt-1" :messages="$errors->get('name')" />
        </div>

        <!-- Email Field -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <x-text-input id="email" name="email" type="email"
                    class="pl-10 w-full border-gray-300 focus:border-[#faa125] focus:ring-[#faa125] rounded-lg shadow-sm transition-colors"
                    :value="old('email', $user->email)" required autocomplete="username"
                    placeholder="Enter your email address" />
            </div>
            <x-input-error class="mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-amber-800">
                                {{ __('Your email address is unverified.') }}
                            </p>
                            <button form="send-verification"
                                class="mt-2 text-sm text-amber-700 hover:text-amber-900 underline font-medium transition-colors">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </div>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <p class="text-sm font-medium text-green-800">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Profile Picture Upload -->
        <div class="space-y-4">
            <x-profile-picture-upload
                name="profile_picture"
                :currentImage="$user->profile_picture"
                label="Profile Picture" />
        </div>

        <!-- Skill Field -->
        <div class="space-y-2">
            <x-input-label for="skill" :value="__('Primary Skill')" class="text-gray-700 font-semibold" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <x-text-input id="skill" name="skill" type="text"
                    class="pl-10 w-full border-gray-300 focus:border-[#faa125] focus:ring-[#faa125] rounded-lg shadow-sm transition-colors"
                    :value="old('skill', Auth::user()->learner->skill)"
                    placeholder="e.g., Web Development, Data Science, Design" />
            </div>
            <x-input-error class="mt-1" :messages="$errors->get('skill')" />
        </div>

        <!-- Bio Field -->
        <div class="space-y-2">
            <x-input-label for="bio" :value="__('Bio')" class="text-gray-700 font-semibold" />
            <div class="relative">
                <textarea id="bio" name="bio" rows="4"
                    class="w-full border-gray-300 focus:border-[#faa125] focus:ring-[#faa125] rounded-lg shadow-sm transition-colors resize-none"
                    placeholder="Tell us about yourself, your interests, and what you're passionate about...">{{ old('bio', Auth::user()->learner->bio) }}</textarea>
            </div>
            <x-input-error class="mt-1" :messages="$errors->get('bio')" />
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
            <button type="submit"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#faa125] to-[#fc662f] border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider hover:from-[#fc662f] hover:to-[#faa125] focus:outline-none focus:ring-2 focus:ring-[#faa125] focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
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
                    <span class="text-sm font-medium">{{ __('Profile updated successfully!') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
