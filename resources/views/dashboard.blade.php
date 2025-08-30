<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #35b5ac 0%, #2dd4aa 100%);
        }
        .card-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }



    </style>

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

    <div class="flex min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-white shadow-lg transition-all duration-300 ease-in-out w-64 flex flex-col border-r border-gray-200">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 id="sidebar-title" class="text-lg font-semibold text-gray-800 transition-all duration-300">Navigation</h3>
                <button id="sidebar-toggle" class="p-2 rounded-lg hover:bg-gray-100 transition-colors flex-shrink-0">
                    <!-- close button -->
                    <svg id="close-icon" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <!-- opnn button -->
                    <svg id="hamburger-icon" class="w-5 h-5 text-gray-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-2">
                <a href="#" id="nav-my-courses" class="nav-item flex items-center justify-start p-3 rounded-lg bg-[#35b5ac] text-white transition-colors group ">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="nav-label ml-3 transition-all duration-300 whitespace-nowrap overflow-hidden">My Courses</span>
                </a>

                <a href="#" id="nav-enroll" class="nav-item flex items-center justify-start p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors group">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="nav-label ml-3 transition-all duration-300 whitespace-nowrap overflow-hidden">Enroll in Courses</span>
                </a>

                <a href="#" id="nav-profile" class="nav-item flex items-center justify-start p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors group ">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="nav-label ml-3 transition-all duration-300 whitespace-nowrap overflow-hidden">Profile</span>
                </a>
            </nav>
        </div>

        <!-- Main content (papalitan pa design) -->
        <div class="flex-1 transition-all duration-300">
            <div id="my-courses-section" class="h-full">
                <div class="gradient-bg p-8 text-white">
                    <h3 class="text-3xl font-bold mb-2">My Courses</h3>
                    <p class="text-white/90">Manage and track your enrolled courses</p>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        <div class="lg:col-span-3">
                            @if ($learner_courses && $learner_courses->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                @foreach ($learner_courses as $course)
                                <div class="card-gradient rounded-xl shadow-lg hover-subtle border border-gray-100 overflow-hidden">
                                    <div class="p-6">
                                        <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>

                                        <h4 class="font-bold text-lg text-gray-900 mb-2">{{$course->title}}</h4>
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-3">{{$course->description}}</p>

                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-4">
                                            tags
                                            {{$course->department}}
                                        </div>

                                        <div class="mb-4">
                                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                                <span>Progress</span>
                                                <span>25%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="gradient-bg h-2 rounded-full" style="width: 25%"></div>
                                            </div>
                                        </div>

                                        <form method="POST"
                                              action="{{ route('dashboard.update',$user->id) }}"
                                              id="unenroll-form-{{ $course->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="unenroll" value="1">
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <x-confirm-dialog
                                                title="Please confirm"
                                                message="Are you sure you want to unenroll from {{ $course->title }}?"
                                                confirmText="Unenroll"
                                                cancelText="Cancel"
                                                loadingMessage="Unenrolling from course..."
                                                :formId="'unenroll-form-' . $course->id">
                                                <x-slot:trigger>
                                                    <button type="button"
                                                            class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors border border-red-700 shadow">
                                                        Unenroll
                                                    </button>
                                                </x-slot:trigger>
                                            </x-confirm-dialog>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="flex items-center justify-center h-96">
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-semibold text-gray-900 mb-2">No courses enrolled</h4>
                                    <p class="text-gray-500 mb-6">Start your learning journey by enrolling in a course</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="lg:col-span-1 space-y-6">
                            <x-user-profile-card :user="$user ?? auth()->user()" />
                            <x-calendar-card />
                            @if ($course)
                                <x-pending-assignments-card />
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div id="enroll-section" class="hidden h-full">
                <div class="gradient-bg p-8 text-white">
                    <h3 class="text-3xl font-bold mb-2">Available Courses</h3>
                    <p class="text-white/90">Discover and enroll in new courses</p>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($courses as $course)
                        @php
                            $isEnrolled = $learner_courses && $learner_courses->contains('id', $course->id);
                        @endphp
                        <div class="card-gradient rounded-xl shadow-lg hover-subtle border border-gray-100 overflow-hidden {{ $isEnrolled ? 'opacity-75' : '' }}">
                            <div class="p-6">
                                <div class="w-12 h-12 {{ $isEnrolled ? 'bg-green-100' : 'bg-blue-100' }} rounded-lg flex items-center justify-center mb-4">
                                    @if($isEnrolled)
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    @endif
                                </div>

                                <h4 class="font-bold text-lg text-gray-900 mb-2">{{$course->title}}</h4>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{$course->description}}</p>

                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                    <span>12 Weeks</span>
                                    <span>⭐ 4.8</span>
                                </div>

                                <!-- Action Button -->
                                @if($isEnrolled)
                                    <button type="button" disabled
                                            class="w-full bg-gray-400 text-white font-semibold py-2 px-4 rounded-lg cursor-not-allowed">
                                        Already Enrolled
                                    </button>
                                @else
                                    <form method="POST"
                                    action="{{ route('dashboard.update',$user->id) }}"
                                    id="enroll-form-{{ $course->id }}" >

                                        @csrf
                                        @method('PATCH')

                                    {{-- Hidden input para ma-include ang course_id --}}
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                                    <x-confirm-dialog
                                        title="Please confirm"
                                        message="Are you sure you want to enroll in {{ $course->title }}?"
                                        confirmText="Enroll"
                                        cancelText="Cancel"
                                        loadingMessage="Enrolling in course..."
                                        :formId="'enroll-form-' . $course->id">
                                        <x-slot:trigger>
                                            <button type="button"
                                                    class="w-full gradient-bg text-white font-semibold py-2 px-4 rounded-lg hover:shadow-lg transition-all border-0">
                                                Enroll Now
                                            </button>
                                        </x-slot:trigger>
                                    </x-confirm-dialog>
                                    </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="profile-section" class="hidden h-full">
                <div class="gradient-bg p-8 text-white">
                    <h3 class="text-3xl font-bold mb-2">My Profile</h3>
                    <p class="text-white/90">Manage your account and preferences</p>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl">
                        <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                            <div class="flex items-center mb-6">
                                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h4>
                                    <p class="text-gray-500">iba pa info</p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h5 class="font-semibold text-gray-900 mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                    Skills
                                </h5>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <span class="text-gray-700" id="profile-skill">
                                    {{isset($learner->skill) ? $learner->skill : 'None';}}</span>
                                </div>
                            </div>

                            <div>
                                <h5 class="font-semibold text-gray-900 mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Bio
                                </h5>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <span class="text-gray-700" id="profile-bio">
                                    {{isset($learner->bio) ? $learner->bio : 'None';}}</span>
                                </div>
                            </div>
                            <div class="flex justify-end mb-4">
                            <button id="edit-profile-btn"
                                    class="px-4 py-2 bg-[#35b5ac] text-white font-semibold rounded-lg shadow hover:opacity-90 transition">
                                Edit Profile
                            </button>
                        </div>
                    </div>

                        <div id="update-profile-card" class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle hidden">
                            <h4 class="text-xl font-bold text-gray-900 mb-6">Update Profile</h4>
                            <form id="profile-form"
                                method="POST"
                                action="{{ route('dashboard.update', $user->id) }}"
                                class="space-y-6">

                                @csrf
                                @method('PATCH')

                                <div>
                                    <label for="skill" class="block text-gray-700 font-semibold mb-2">Update Skill</label>
                                    <input type="text"
                                        id="skill"
                                        name="skill"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all"
                                        placeholder="Enter your skill"
                                        value="{{ old('skill', $learner->skill ?? '') }}">
                                </div>

                                <div>
                                    <label for="bio" class="block text-gray-700 font-semibold mb-2">Update Bio</label>
                                    <textarea id="bio"
                                            name="bio"
                                            rows="4"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none transition-all"
                                            placeholder="Enter your bio">{{ old('bio', $learner->bio ?? '') }}</textarea>
                                </div>
                                <x-confirm-dialog
                                    title="Please confirm"
                                    message="Are you sure you want to update your profile?"
                                    confirmText="Update"
                                    cancelText="Cancel"
                                    loadingMessage="Updating profile..."
                                    :formId="'profile-form'">
                                <x-slot:trigger>
                                    <button type="button"
                                        class="w-full gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all border-0">
                                    Update Profile
                                </button>
                                </x-slot:trigger>
                                </x-confirm-dialog>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 max-w-6xl">
                        <div class="bg-blue-50 rounded-xl p-6 text-center hover-subtle">
                            <div class="text-3xl font-bold text-blue-600 mb-2">{{ isset($learner_courses) ? count($learner_courses) : '0' }}</div>
                            <div class="text-blue-800 font-medium">Courses Enrolled</div>
                        </div>
                        <div class="bg-green-50 rounded-xl p-6 text-center hover-subtle">
                            <div class="text-3xl font-bold text-green-600 mb-2">{{ isset($course) ? '75%' : '0%' }}</div>
                            <div class="text-green-800 font-medium">Average Progress</div>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-6 text-center hover-subtle">
                            <div class="text-3xl font-bold text-purple-600 mb-2">{{ isset($course) ? '24' : '0' }}</div>
                            <div class="text-purple-800 font-medium">Hours Learned</div>
                        </div>
                    </div>
                </div>
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



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar elements
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarTitle = document.getElementById('sidebar-title');
            const sidebarHeader = sidebarTitle.parentElement;
            const navLabels = document.querySelectorAll('.nav-label');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');

            // Navigation elements
            const navMyCourses = document.getElementById('nav-my-courses');
            const navEnroll = document.getElementById('nav-enroll');
            const navProfile = document.getElementById('nav-profile');

            // Section elements
            const myCoursesSection = document.getElementById('my-courses-section');
            const enrollSection = document.getElementById('enroll-section');
            const profileSection = document.getElementById('profile-section');

            let sidebarOpen = true;

            sidebarToggle.addEventListener('click', function() {
                sidebarOpen = !sidebarOpen;

                if (sidebarOpen) {
                    sidebar.classList.remove('w-16');
                    sidebar.classList.add('w-64');
                    sidebarTitle.classList.remove('opacity-0', 'w-0', 'hidden');
                    sidebarHeader.classList.remove('justify-center');
                    sidebarHeader.classList.add('justify-between');

                    navLabels.forEach(label => {
                        label.classList.remove('opacity-0', 'w-0', 'ml-0');
                        label.classList.add('ml-3');
                    });
                    document.querySelectorAll('.nav-item').forEach(item => {
                        item.classList.remove('justify-center');
                    });

                    closeIcon.classList.remove('hidden');
                    hamburgerIcon.classList.add('hidden');
                } else {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-16');
                    sidebarTitle.classList.add('opacity-0', 'w-0', 'hidden');
                    sidebarHeader.classList.remove('justify-between');
                    sidebarHeader.classList.add('justify-center');

                    navLabels.forEach(label => {
                        label.classList.add('opacity-0', 'w-0', 'ml-0');
                        label.classList.remove('ml-3');
                    });
                    document.querySelectorAll('.nav-item').forEach(item => {
                        item.classList.add('justify-center');
                    });

                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                }
            });

            function setActiveNav(activeNav) {
                const navItems = [navMyCourses, navEnroll, navProfile];
                navItems.forEach(nav => {
                    nav.classList.remove('bg-[#35b5ac]', 'text-white');
                    nav.classList.add('text-gray-700', 'hover:bg-gray-100');
                });

                activeNav.classList.remove('text-gray-700', 'hover:bg-gray-100');
                activeNav.classList.add('bg-[#35b5ac]', 'text-white');
            }

            function showSection(targetSection) {
                myCoursesSection.classList.add('hidden');
                enrollSection.classList.add('hidden');
                profileSection.classList.add('hidden');

                targetSection.classList.remove('hidden');
            }

            navMyCourses.addEventListener('click', function(e) {
                e.preventDefault();
                setActiveNav(navMyCourses);
                showSection(myCoursesSection);
            });

            navEnroll.addEventListener('click', function(e) {
                e.preventDefault();
                setActiveNav(navEnroll);
                showSection(enrollSection);
            });

            navProfile.addEventListener('click', function(e) {
                e.preventDefault();
                setActiveNav(navProfile);
                showSection(profileSection);
            });

            // Profile edit toggle
            const editProfileBtn = document.getElementById('edit-profile-btn');
            const updateProfileCard = document.getElementById('update-profile-card');

            editProfileBtn.addEventListener('click', function() {
                updateProfileCard.classList.toggle('hidden');
                // Optional: scroll into view
                if (!updateProfileCard.classList.contains('hidden')) {
                    updateProfileCard.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</x-app-layout>
