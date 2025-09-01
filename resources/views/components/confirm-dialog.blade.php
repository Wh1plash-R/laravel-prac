@props([
    'title' => 'Are you sure? ',
    'message' => 'This action cannot be undone.',
    'confirmText' => 'OK',
    'cancelText' => 'Cancel',
    'formId' => null,
    'event' => null,
    'loadingMessage' => 'Processing...',
])

<div x-data="{
        open: false,
        loading: false,
        formId: @js($formId),
        confirm() {
            this.loading = true;
            this.open = false;
            const form = this.formId ? document.getElementById(this.formId) : $root.closest('form');
            if (form) form.submit();
        }
    }" x-init="() => { if (@js($event)) { window.addEventListener(@js($event), () => { open = true }) } }" class="inline">
    @isset($trigger)
        <div @click="open = true; $dispatch('close')">
            {{ $trigger }}
        </div>
    @endisset

    <template x-teleport="body">
        <div x-cloak x-show="open" class="fixed inset-0 z-[9999] flex items-center justify-center px-4" style="display: none;">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="open = false"></div>
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-200 p-6 animate-fade-in">
                <h3 class="text-lg font-bold text-gray-900">{{ $title }}</h3>
                <p class="mt-2 text-gray-600">{{ $message }}</p>
                <div class="mt-6 flex items-center justify-end gap-3">
                    <button type="button" @click="open = false"
                        class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition">
                        {{ $cancelText }}
                    </button>

                    {{-- Conditional confirm button --}}
                    @if ($confirmText === 'Enroll')
                        <button type="button" @click="confirm()"
                            class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 border border-green-700 shadow transition">
                            {{ $confirmText }}
                        </button>
                    @elseif ($confirmText === 'Unenroll')
                        <button type="button" @click="confirm()"
                            class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 border border-red-700 shadow transition">
                            {{ $confirmText }}
                        </button>
                    @elseif ($confirmText === 'Delete')
                        <button type="button" @click="confirm()"
                            class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 border border-red-700 shadow transition">
                            {{ $confirmText }}
                        </button>
                    @else
                        <button type="button" @click="confirm()"
                            class="px-4 py-2 rounded-lg bg-gray-600 text-white hover:bg-gray-700 border border-gray-700 shadow transition">
                            {{ $confirmText }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </template>

    <!-- Loading Overlay -->
    <x-loading-overlay show="loading" :message="$loadingMessage" />
</div>

<style>
    [x-cloak] { display: none !important; }
    @keyframes fade-in { from { opacity: 0; transform: translateY(4px) } to { opacity: 1; transform: translateY(0) } }
    .animate-fade-in { animation: fade-in .15s ease-out; }
    .bg-gray-900\/60 { background-color: rgba(17, 24, 39, 0.6); }
</style>

