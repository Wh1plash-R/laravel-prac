@props([
    'show' => false,
    'message' => 'Processing...',
    'size' => 'default' // 'small', 'default', 'large'
])

@php
$sizeClasses = [
    'small' => 'w-6 h-6',
    'default' => 'w-8 h-8',
    'large' => 'w-12 h-12'
];
$spinnerSize = $sizeClasses[$size] ?? $sizeClasses['default'];
@endphp

<div x-cloak
     x-show="{{ is_string($show) ? $show : ($show ? 'true' : 'false') }}"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center px-4"
     style="display: none;">

    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

    <!-- Loading Card -->
    <div class="relative bg-white rounded-2xl shadow-xl border border-gray-200 p-8 animate-fade-in max-w-sm w-full">
        <div class="flex flex-col items-center text-center space-y-4">
            <!-- Loading Spinner -->
            <div class="relative">
                <div class="{{ $spinnerSize }} border-4 border-gray-200 rounded-full animate-spin border-t-transparent bg-gradient-to-r from-[#35b5ac] to-[#2dd4aa] bg-clip-border"></div>
                <div class="{{ $spinnerSize }} border-4 border-transparent rounded-full animate-spin border-t-[#35b5ac] absolute top-0"></div>
            </div>

            <!-- Loading Message -->
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-900 font-[Inter,sans-serif]">
                    {{ $message }}
                </h3>
                <p class="text-sm text-gray-600">
                    Please wait while we process your request...
                </p>
            </div>

            <!-- Progress Dots -->
            <div class="flex space-x-1">
                <div class="w-2 h-2 bg-[#35b5ac] rounded-full animate-pulse" style="animation-delay: 0s;"></div>
                <div class="w-2 h-2 bg-[#35b5ac] rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                <div class="w-2 h-2 bg-[#35b5ac] rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(4px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }

    /* Custom spinner animation */
    @keyframes spin-gradient {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Pulsing dots animation */
    .animate-pulse {
        animation: pulse-dot 1.4s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 80%, 100% {
            opacity: 0.3;
            transform: scale(0.8);
        }
        40% {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
