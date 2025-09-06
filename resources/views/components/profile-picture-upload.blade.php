@props(['name' => 'profile_picture', 'currentImage' => null, 'label' => 'Profile Picture'])

<div class="space-y-4">
    <label for="{{ $name }}" class="block text-gray-700 font-semibold mb-2">{{ $label }}</label>

    <!-- Current Profile Picture Display -->
    @if($currentImage)
    <div class="mb-4 flex items-end gap-10">
        <div>
            <p class="text-sm text-gray-600 mb-2">Current Profile Picture:</p>
            <div class="w-40 h-40 rounded-full overflow-hidden border-2 border-gray-200">
                <img src="data:image/jpeg;base64,{{ base64_encode($currentImage) }}"
                    alt="Current profile picture"
                    class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Preview Container -->
        <div class="">
            <div id="preview-container-{{ $name }}" class="hidden">
                <p class="text-sm text-gray-600 mb-2">Preview:</p>
                <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200">
                    <img id="preview-{{ $name }}"
                        alt="Preview"
                        class="w-full h-full object-cover">
                </div>
            </div>


            <!-- File Info -->
            <div id="file-info-{{ $name }}" class="hidden">
                <p class="text-sm text-gray-600">
                    Selected: <span id="file-name-{{ $name }}" class="font-medium"></span>
                </p>
            </div>
        </div>
    </div>
    @else
    <div class="mb-4">
        <p class="text-sm text-gray-600 mb-2">No profile picture set</p>
        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200 bg-gray-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
    </div>
    @endif

    <!-- File Input -->
    <div class="relative">
        <input type="file" name="{{ $name }}" id="{{ $name }}" accept="image/png, image/jpeg, image/gif, image/webp"
               class="hidden"
               {{ $attributes }}>

        <div class="flex items-center gap-2">

            <label for="{{ $name }}"
                class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Choose Image
            </label>

            <!-- Delete Profile Picture Button -->
            @if($currentImage)
            <form id="delete-profile-form-{{ $name }}" method="POST" action="{{ route('dashboard.delete-profile-picture', auth()->user()->id) }}" class="inline">
                @csrf
                @method('DELETE')
                <x-confirm-dialog
                title="Remove Profile Picture"
                message="Are you sure you want to remove your profile picture? This action cannot be undone."
                confirmText="Remove Profile"
                cancelText="Cancel"
                loadingMessage="Removing profile picture..."
                :formId="'delete-profile-form-' . $name">
                <x-slot name="trigger">
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-red-300 rounded-lg shadow-sm text-sm font-medium text-[#f3f3f3] hover:bg-red-600/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-[#f3f3f3]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 11v6"/><path d="M14 11v6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                        Remove Profile
                    </button>
                </x-slot>
            </x-confirm-dialog>
            </form>
            @endif

        </div>

    </div>

    <!-- Hidden Delete Form -->
    @if($currentImage)
    <form id="delete-profile-form-{{ $name }}" method="POST" action="{{ route('dashboard.delete-profile-picture', auth()->user()->id) }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endif

     <!-- Preview Container -->
    <div id="preview-container-{{ $name }}" class="hidden">
        <p class="text-sm text-gray-600 mb-2">Preview:</p>
        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200">
            <img id="preview-{{ $name }}"
                 alt="Preview"
                 class="w-full h-full object-cover">
        </div>
    </div>

    <!-- File Info -->
    <div id="file-info-{{ $name }}" class="hidden">
        <p class="text-sm text-gray-600">
            Selected: <span id="file-name-{{ $name }}" class="font-medium"></span>
        </p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('{{ $name }}');
    const previewContainer = document.getElementById('preview-container-{{ $name }}');
    const preview = document.getElementById('preview-{{ $name }}');
    const fileInfo = document.getElementById('file-info-{{ $name }}');
    const fileName = document.getElementById('file-name-{{ $name }}');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];

        if (file) {
            // Show file info
            fileName.textContent = file.name;
            fileInfo.classList.remove('hidden');

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
            fileInfo.classList.add('hidden');
        }
    });
});
</script>
