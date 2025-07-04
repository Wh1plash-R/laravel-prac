<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

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
                setTimeout(() => flash.remove(), 500); // match transition duration
            }
        }, 2000); // show for 2 seconds
    </script>
    @endif
    <div class="py-12 min-h-screen bg-gray-50 flex flex-col items-center justify-center">
        <div class="w-full max-w-3xl bg-white shadow-lg rounded-2xl border border-gray-200 p-8">
            <div class="flex justify-center mb-6">
                <button id="tab-my-courses" class="tab-btn px-6 py-2 rounded-l-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">My Course</button>
                <button id="tab-enroll" class="tab-btn px-6 py-2 font-semibold text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none {{ isset($course) ? 'pointer-events-none opacity-50 cursor-not-allowed' : '' }}">Enroll in Courses</button>
                <button id="tab-profile" class="tab-btn px-6 py-2 rounded-r-lg font-semibold text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none">Profile</button>
            </div>
            <div id="my-courses-section">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">My Course</h3>
                                <div class="space-y-4">
                    @if ($course)
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg shadow flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <span class="font-semibold text-lg text-blue-700">{{$course->title}}</span>
                            <span class="block text-gray-600">{{$course->description}}</span>
                            <span class="text-gray-600">Department: {{$course->department}}</span>
                        </div>
                        <form method="POST"
                              action="{{ route('dashboard.update',$user->id) }}"
                              class="mt-4 sm:mt-0"
                              onsubmit="return confirm('Are you sure you want to unenroll from this course?')">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="unenroll" value="1">
                            <button type="submit"
                                    class="mt-2 sm:mt-0 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors border border-red-700 shadow">
                                Unenroll
                            </button>
                        </form>
                    </div>

                    </div>
                    @else
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg shadow flex flex-col">
                        <span class="font-semibold text-lg text-blue-700">You are not yet enrolled</span>
                    </div>
                    @endif

                </div>
            </div>
            <div id="enroll-section" class="hidden">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Enroll in Courses</h3>
                <div class="space-y-4">
                    @foreach ($courses as $course )
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg shadow flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <span class="font-semibold text-lg text-blue-700">{{$course->title}}</span>
                            <span class="block text-gray-600">{{$course->description}}</span>
                        </div>
                        <form method="POST"
                        action="{{ route('dashboard.update',$user->id) }}"
                        class="mt-4 sm:mt-0"
                        onsubmit="return confirm('Are you sure you want to enroll in this course?')" >

                            @csrf
                            @method('PATCH')

                        {{-- Hidden input para ma-include ang course_id --}}
                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                        <button type="submit"
                        class="mt-2 sm:mt-0 bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors border border-green-700 shadow"
                        >Enroll</button>
                        </form>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="profile-section" class="hidden">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Profile</h3>
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg shadow mb-6">
                    <div class="mb-2">
                        <span class="font-semibold text-lg text-blue-700">Skill:</span>
                        <span class="text-gray-600"
                        id="profile-skill">
                        {{isset($learner->skill) ? $learner->skill : 'None';}}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-lg text-blue-700">Bio:</span>
                        <span class="text-gray-600"
                        id="profile-bio">
                        {{isset($learner->bio) ? $learner->bio : 'None';}}</span>
                    </div>
                </div>
                <form id="profile-form"
                method="POST"
                action="{{ route('dashboard.update', $user->id) }}"
                class="space-y-4">

                @csrf
                @method('PATCH')
                    <div>
                        <label for="skill"
                        class="block text-gray-700 font-semibold mb-1">Update Skill</label>
                        <input type="text"
                        id="skill"
                        name="skill"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="Enter your skill"
                        value="{{ old('skill', $user->skill ?? '') }}">
                    </div>
                    <div>
                        <label for="bio"
                        class="block text-gray-700 font-semibold mb-1">Update Bio</label>
                        <textarea
                        id="bio"
                        name="bio"
                        rows="3"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="Enter your bio">{{old('bio')}}</textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition-colors border border-blue-700 shadow">Update</button>
                </form>
            </div>
        </div>
    </div>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabMyCourses = document.getElementById('tab-my-courses');
            const tabEnroll = document.getElementById('tab-enroll');
            const tabProfile = document.getElementById('tab-profile');
            const myCoursesSection = document.getElementById('my-courses-section');
            const enrollSection = document.getElementById('enroll-section');
            const profileSection = document.getElementById('profile-section');

            tabMyCourses.addEventListener('click', function() {
                tabMyCourses.classList.add('bg-blue-600', 'text-white');
                tabMyCourses.classList.remove('bg-blue-100', 'text-blue-700');
                tabEnroll.classList.remove('bg-blue-600', 'text-white');
                tabEnroll.classList.add('bg-blue-100', 'text-blue-700');
                tabProfile.classList.remove('bg-blue-600', 'text-white');
                tabProfile.classList.add('bg-blue-100', 'text-blue-700');
                myCoursesSection.classList.remove('hidden');
                enrollSection.classList.add('hidden');
                profileSection.classList.add('hidden');
            });
            tabEnroll.addEventListener('click', function() {
                if (tabEnroll.classList.contains('pointer-events-none')) return;
                tabEnroll.classList.add('bg-blue-600', 'text-white');
                tabEnroll.classList.remove('bg-blue-100', 'text-blue-700');
                tabMyCourses.classList.remove('bg-blue-600', 'text-white');
                tabMyCourses.classList.add('bg-blue-100', 'text-blue-700');
                tabProfile.classList.remove('bg-blue-600', 'text-white');
                tabProfile.classList.add('bg-blue-100', 'text-blue-700');
                enrollSection.classList.remove('hidden');
                myCoursesSection.classList.add('hidden');
                profileSection.classList.add('hidden');
            });
            tabProfile.addEventListener('click', function() {
                tabProfile.classList.add('bg-blue-600', 'text-white');
                tabProfile.classList.remove('bg-blue-100', 'text-blue-700');
                tabMyCourses.classList.remove('bg-blue-600', 'text-white');
                tabMyCourses.classList.add('bg-blue-100', 'text-blue-700');
                tabEnroll.classList.remove('bg-blue-600', 'text-white');
                tabEnroll.classList.add('bg-blue-100', 'text-blue-700');
                profileSection.classList.remove('hidden');
                myCoursesSection.classList.add('hidden');
                enrollSection.classList.add('hidden');
            });
            //delete this part later
        });
    </script>
</x-app-layout>
