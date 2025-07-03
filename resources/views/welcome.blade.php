<x-layout>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50">
    <div class="text-center space-y-6 p-8 max-w-2xl bg-white shadow-lg rounded-2xl border border-gray-200">
      <h1 class="text-4xl font-extrabold text-gray-900">
        Welcome to ヨルシカ Page
      </h1>
      <p class="text-lg text-gray-600">
        Explore learners, add new entries, and manage your roster effortlessly.
      </p>
      <div class="flex justify-center space-x-4">
        <a href="{{ route('learners.index') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors border border-blue-700 shadow">
          View All Learners
        </a>
      </div>
    </div>
  </div>
</x-layout>
