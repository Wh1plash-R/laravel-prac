<x-layout>
<div class="max-w-xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-200 p-8 mt-10 text-gray-800">
  <h1 class="text-2xl font-extrabold mb-4">Welcome to {{ $mentor }}'s Secret Page</h1>
  <a href="/" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition-colors border border-blue-700 mb-4">Go Back to Home Page</a>
  <p class="text-gray-600">Current Date and Time: {{ now() }}</p>
</div>
</x-layout>
