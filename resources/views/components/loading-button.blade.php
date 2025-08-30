@props([
    'type' => 'submit',
    'loadingText' => 'Processing...',
    'class' => '',
    'disabled' => false
])

<button
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    x-data="{ loading: false }"
    @click="loading = true"
    :disabled="loading"
    :class="loading ? 'cursor-not-allowed opacity-75' : ''"
    class="{{ $class }}"
    {{ $attributes }}>

    <!-- Loading State -->
    <span x-show="loading" class="flex items-center justify-center">
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        {{ $loadingText }}
    </span>

    <!-- Default State -->
    <span x-show="!loading">
        {{ $slot }}
    </span>
</button>

<style>
    [x-cloak] { display: none !important; }
</style>
