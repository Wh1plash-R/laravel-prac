@props(['name' => 'profile_picture', 'currentImage' => null, 'label' => 'Profile Picture'])

<div class="space-y-4">
    <label for="{{ $name }}" class="block text-gray-700 font-semibold mb-2">{{ $label }}</label>

    <!-- Current Profile Picture Display -->
    @if($currentImage)
    <div class="mb-4">
        <p class="text-sm text-gray-600 mb-2">Current Profile Picture:</p>
        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200">
            <img src="data:image/jpeg;base64,{{ base64_encode($currentImage) }}"
                 alt="Current profile picture"
                 class="w-full h-full object-cover">
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
        <input type="file"
               id="{{ $name }}"
               name="{{ $name }}"
               accept="image/*"
               class="hidden"
               {{ $attributes }}>

        <label for="{{ $name }}"
               class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Choose Image
        </label>
    </div>

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
