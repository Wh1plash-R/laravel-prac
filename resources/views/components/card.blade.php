@props(['highlight' => false]) {{-- default value is false --}}

<div @class([
    'card',
    'bg-white border border-gray-200 rounded-xl p-6 shadow-sm transition-all',
    'ring-2 ring-blue-400/40' => $highlight,
    'hover:shadow-lg hover:border-blue-500' => $highlight,
    'hover:border-indigo-400' => !$highlight,
    'text-gray-800',
    'mb-4'
])>
    {{-- the @class directive allows us to conditionally apply classes based on the props passed in --}}
    {{-- if highlight is true, it will add the class 'highlight' to the div --}}
    {{-- this is a shorthand for: class="{{ $highlight ? 'highlight' : '' }}" --}}
    {{ $slot }}
    {{-- since we there is only one attribute passed in the blade file that uses this
    we can use <a {{ $attributes }} to get all the attributes from the file --}}
    <a href="{{ $attributes->get('href') }}" class="mt-4 inline-block px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white hover:bg-blue-700 transition border border-blue-700">View Details</a>
</div>
