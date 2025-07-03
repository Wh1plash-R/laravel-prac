<x-layout>
  <div class="max-w-xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-200 p-8 mt-10 text-gray-800">
    <h2 class="text-2xl font-extrabold mb-6 text-blue-600">Add a New Learner</h2>
    <form action="{{ route('learners.store') }}"
          method="POST"
          class="space-y-4">
      @csrf
      <div>
        <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
        <input
          type="text"
          id="name"
          name="name"
          value="{{ old('name') }}"
          required
          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
      </div>
      <div>
        <label for="skill" class="block text-gray-700 font-medium mb-1">Skill</label>
        <input
          type="text"
          id="skill"
          name="skill"
          value="{{ old('skill') }}"
          required
          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
      </div>
      <div>
        <label for="bio" class="block text-gray-700 font-medium mb-1">Bio</label>
        <textarea
          id="bio"
          name="bio"
          rows="3"
          required
          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >{{ old('bio') }}</textarea>
      </div>
      <div>
        <label for="course_id" class="block text-gray-700 font-medium mb-1">Course</label>
        <select
          id="course_id"
          name="course_id"
          required
          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          <option value="" disabled selected>Select a course</option>
          @foreach ($courses as $course)
            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
              {{ $course->title }}
            </option>
          @endforeach
        </select>
      </div>
      <button
        type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition-colors border border-blue-700"
      >
        Add Learner
      </button>
    </form>
    {{-- Validation Errors --}}
    @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-6">
        <ul class="list-disc pl-5 space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    {{-- Success Message --}}
    @if (session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-6">
        {{ session('success') }}
      </div>
    @endif
  </div>
</x-layout>
