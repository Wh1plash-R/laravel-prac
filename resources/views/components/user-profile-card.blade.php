@props(['user' => null])

@php
    $currentUser = $user ?? Auth::user();
    $name = $currentUser?->name ?? 'User';
    $email = $currentUser?->email ?? '';
    $initial = strtoupper(substr($name, 0, 1));
@endphp

<div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 gradient-bg rounded-full flex items-center justify-center text-white text-2xl font-bold">
            {{ $initial }}
        </div>
        <div class="min-w-0">
            <h4 class="text-lg font-bold text-gray-900 truncate">{{ $name }}</h4>
            @if($email)
                <p class="text-gray-500 text-sm truncate">{{ $email }}</p>
            @endif
        </div>
    </div>
</div>


