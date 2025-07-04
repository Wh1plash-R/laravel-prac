<x-layout>
  <div class="max-w-xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-200 p-8 mt-10 text-gray-800">
    <a href="{{ route('learners.index') }}" class="inline-block mb-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition-colors border border-blue-700">&larr; Back to All Learners</a>
    <h2 class="text-2xl font-extrabold mb-6 text-blue-600">
      Learner Details
    </h2>
    <ul class="space-y-2 text-gray-700 mb-6">
      <li><span class="font-medium text-gray-600">ID:</span> {{ $learner->id }}</li>
      <li><span class="font-medium text-gray-600">Name:</span> {{ $learner->name ?? 'Unknown' }}</li>
      <li><span class="font-medium text-gray-600">Skill:</span> {{ $learner->skill ?? 'Unknown' }}</li>
      <li><span class="font-medium text-gray-600">Bio:</span> {{ $learner->bio ?? 'No bio available' }}</li>
    </ul>
    <div class="mb-6">
      <h3 class="font-semibold text-lg text-blue-500 mb-2">Course Information</h3>
      <p><span class="font-medium text-gray-600">Course Name:</span> {{ $learner->course->title?? 'None' }} </p>
      <p><span class="font-medium text-gray-600">Course Description:</span> {{ $learner->course->description ?? 'No description available' }}</p>
      <p><span class="font-medium text-gray-600">Department:</span> {{ $learner->course->department ?? 'No department available' }}</p>
    </div>
    <form
      action="{{ route('learners.destroy', $learner->id) }}"
      method="POST"
      class="inline"
      onsubmit="return confirm('Are you sure you want to delete this learner?')"
    >
      @csrf
      @method('DELETE')
      <button
        type="submit"
        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 rounded-lg transition-colors border border-red-700"
      >
        Delete Learner
      </button>
    </form>
  </div>
</x-layout>
