<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form id="delete-profile-form-global" method="POST" action="{{ route('dashboard.delete-profile-picture', auth()->user()->id) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
            <a href="{{ route('dashboard') }}"
                x-data
                @click.prevent="if (window.profileFormDirty) { window.dispatchEvent(new Event('open-back-confirm')) } else { window.location.href = $el.getAttribute('href') }"
                class="inline-flex items-center sm:m-0 m-4 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition-all border border-gray-300 hover:border-gray-400 group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Dashboard
            </a>
            <form id="back-to-dashboard-form" method="GET" action="{{ route('dashboard') }}" class="hidden"></form>
            <x-confirm-dialog
                :title="__('Unsaved changes')"
                :message="__('You have unsaved changes. Do you want to leave this page without saving?')"
                confirmText="Leave Page"
                cancelText="Stay"
                :formId="'back-to-dashboard-form'"
                event="open-back-confirm"
            />
            <div class="p-4 sm:p-12 p-4 bg-white sm:rounded-lg sm:m-0 m-4 ">
                <div class="w-full">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-full">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-full">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
