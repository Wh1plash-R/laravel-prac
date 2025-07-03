<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.apiBase = "{{ url('api') }}";
    </script>
    <title>Rouin</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen font-[Inter,sans-serif] text-gray-800">
    @if (session('success'))
    <div class="flex justify-center pt-6">
        <div id="flash" class="p-4 mb-4 bg-green-100 text-green-900 border border-green-300 rounded-lg shadow w-full max-w-md text-center animate-fade-in">
            {{ session('success') }}
        </div>
    </div>
    @endif
    <header class="bg-white/90 backdrop-blur shadow-md sticky top-0 z-10 border-b border-gray-200">
        <nav class="container mx-auto flex items-center justify-between py-4 px-6">
            <div class="flex items-center gap-3">
                <span class="inline-block bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full px-3 py-1 text-lg font-extrabold shadow-sm tracking-tight">
                <a href="{{ route('welcome') }}" class="hover:text-blue-600 focus:text-blue-700 transition">ヨルシカ</a>
                </span>
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">
                </h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('learners.index') }}" class="px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow border border-blue-700">All Learners</a>
                <a href="{{ route('learners.add') }}" class="px-4 py-2 rounded-lg font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition shadow border border-indigo-700">Add New Learner</a>
            </div>
        </nav>
    </header>
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
</html>
