<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rouin</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen font-[Inter,sans-serif] text-gray-800">

    @if (session('success'))
    <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
        <div id="flash"
             class="p-4 bg-green-100 text-green-900 border border-green-300 rounded-lg shadow-lg w-full max-w-sm text-center animate-fade-in transition-opacity duration-500">
            {{ session('success') }}
        </div>
    </div>

    <script>
        setTimeout(function () {
            const flash = document.getElementById('flash');
            if (flash) {
                flash.classList.add('opacity-0');
                setTimeout(() => flash.remove(), 500);
            }
        }, 2000); // To make the flash message disappear
    </script>
    @endif

    <x-header :title="$title ?? ''" />

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
