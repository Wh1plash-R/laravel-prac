<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #fdd666 0%, #faa125 100%);
        }
        .card-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }

        .nav-item:hover:not(.active) {
            background-color: #e5e7eb;
        }

        .course-title {
            height: 3.5rem; /* Exactly 2 lines at text-lg */
            line-height: 1.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Hover subtle effect for cards */
        .hover-subtle {
            transition: all 0.3s ease;
        }

        .hover-subtle:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Fade in animation for flash messages */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -60%);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
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

        <!-- Sidebar Section -->
        <div id="sidebar"
            class="bg-[#F5F5F5] shadow-lg transition-all duration-300 ease-in-out flex flex-col border-r border-gray-200 w-64">

            <div class="flex items-center justify-between p-4 border-b border-gray-200" id="sidebar-header">
                <h3 id="sidebar-title" class="text-lg font-semibold text-gray-800 transition-all duration-300">Navigation</h3>
                <button id="sidebar-toggle" class="p-2 rounded-lg hover:bg-gray-100 transition-colors flex-shrink-0">
                    <!-- hamburger button (shows when collapsed) -->
                    <svg id="hamburger-icon" class="w-5 h-5 w-auto text-gray-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <!-- close button (shows when expanded) -->
                    <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-panel-left-icon lucide-panel-left"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-2">
                <a href="#" id="nav-my-courses" class="nav-item flex items-center justify-start p-3 rounded-lg bg-[#fdd666] text-[#333] transition-colors active group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                        <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
                    </svg>
                    <span class="font-semibold nav-label ml-3 transition-all duration-300 whitespace-nowrap overflow-hidden block">Dashboard</span>
                </a>

                <a href="#" id="nav-enroll" class="nav-item flex items-center justify-start p-3 rounded-lg text-gray-700 transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-icon lucide-book-open">
                        <path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>
                    </svg>
                    <span class="font-semibold nav-label ml-3 transition-all duration-300 whitespace-nowrap overflow-hidden block">Enroll in Courses</span>
                </a>

                <a href="#" id="nav-profile" class="nav-item flex items-center justify-start p-3 rounded-lg text-gray-700 transition-colors group">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-semibold nav-label ml-3 transition-all duration-300 whitespace-nowrap overflow-hidden block">My Profile</span>
                </a>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 transition-all duration-300 m-5">
            <!-- My Courses Section with Right Sidebar -->
            <div id="my-courses-section" class="h-full flex flex-col lg:flex-row gap-5">
                <!-- Left Section (Main content & courses) -->
                <div class="flex-1">
                    <div class="relative gradient-bg p-8 text-[#333] rounded-lg flex justify-between w-full">
                        <div>
                            <h3 class="text-3xl font-bold mb-2">Hello, {{ Auth::user()->name }}!</h3>
                            <p class="text-[#333]/90">Keep your studies organized and see your progress grow with each lesson.</p>
                        </div>
                        <div>
                            <img src="{{ asset('images/texture.png') }}" alt="Logo" class="w-24 scale-150">

                        </div>
                    </div>


                    <div class="pt-8">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- profile stats -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 min-w-full">
                                <div class="bg-blue-200 rounded-xl p-6 text-center hover-subtle">
                                    <div class="text-3xl font-bold text-[#333] mb-2">{{ isset($learner_courses) ? count($learner_courses) : '0' }}</div>
                                    <div class="text-[#333]/80 font-medium">Courses Enrolled</div>
                                </div>
                                <div class="bg-green-200 rounded-xl p-6 text-center hover-subtle">
                                    <div class="text-3xl font-bold text-[#333] mb-2">{{ isset($course) ? '75%' : '0%' }}</div>
                                    <div class="text-[#333]/80 font-medium">Average Progress</div>
                                </div>
                                <div class="bg-purple-200 rounded-xl p-6 text-center hover-subtle">
                                    <div class="text-3xl font-bold text-[#333] mb-2">{{ isset($course) ? '24' : '0' }}</div>
                                    <div class="text-[#333]/80 font-medium">Hours Learned</div>
                                </div>
                            </div>  
                            <!-- Main Content Area -->
                            <div>

                                <div class="text-[#333] pl-8">
                                    <h1 class="text-2xl font-bold">My Courses</h1>
                                    <p class="text-[#333]/90">Manage and track your enrolled courses.</p>
                                </div>
                                @if ($learner_courses && $learner_courses->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-8">

                                    @foreach ($learner_courses as $course)
                                    <div class="card-gradient rounded-xl shadow-lg hover-subtle border border-gray-100 overflow-hidden">
                                        <div class="p-8">
                                            <div
                                                class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                    </path>
                                                </svg>
                                            </div>

                                            <h4 class="font-bold text-lg text-gray-900 mb-2 course-title">{{$course->title}}</h4>
                                            <p class="text-gray-600 text-sm mb-3 line-clamp-3">{{$course->description}}</p>

                                            <div
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-4">
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

                                            <a href="{{ route('course.view', $course->id) }}"
                                           class="w-full gradient-bg text-[#333] font-semibold py-2 px-4 rounded-lg hover:shadow-lg transition-all border-0 text-center block">
                                            View Course
                                        </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="flex items-center justify-center h-96">
                                    <div class="text-center">
                                        <div
                                            class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-semibold text-gray-900 mb-2">No courses enrolled</h4>
                                        <p class="text-gray-500 mb-6">Start your learning journey by enrolling in a course</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="lg:w-1/4 space-y-6 flex flex-col sm:flex-col lg:flex-col">
                    <x-calendar-card class="flex-1" />
                    @if ($learner_courses && $learner_courses->count() > 0)
                        <x-pending-assignments-card :learner-courses="$learner_courses" class="flex-1" />
                    @endif
                </div>
            </div>


            <!-- Enroll Section - Full Width -->
            <div id="enroll-section" class="hidden h-full">
                <div class="relative gradient-bg p-8 text-[#333] rounded-lg flex justify-between w-full">
                        <div>
                            <h3 class="text-3xl font-bold mb-2">Available Courses</h3>
                            <p class="text-[#333]/90">Discover and enroll in new courses</p>
                        </div>
                        <div>
                            <img src="{{ asset('images/texture.png') }}" alt="Logo" class="w-24 scale-150">

                        </div>
                    </div>


                <div class="pt-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($courses as $course)
                        @php
                            $isEnrolled = $learner_courses && $learner_courses->contains('id', $course->id);
                        @endphp
                        <div class="card-gradient rounded-xl shadow-lg hover-subtle border border-gray-100 overflow-hidden flex flex-col h-full {{ $isEnrolled ? 'opacity-75' : '' }}">
                            <div class="p-6 flex flex-col h-full">
                                <div class="w-12 h-12 {{ $isEnrolled ? 'bg-green-100' : 'bg-blue-100' }} rounded-lg flex items-center justify-center mb-4 flex-shrink-0">
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

                                <h4 class="font-bold text-lg text-gray-900 mb-2 flex-shrink-0 course-title">{{$course->title}}</h4>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">{{$course->description}}</p>

                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4 flex-shrink-0">
                                    <span>12 Weeks</span>
                                    <span>⭐ 4.8</span>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-auto flex-shrink-0">
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
                                                        class="w-full gradient-bg text-[#010101] font-semibold py-2 px-4 rounded-lg hover:shadow-lg transition-all border-0">
                                                    Enroll Now
                                                </button>
                                            </x-slot:trigger>
                                        </x-confirm-dialog>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Profile Section - Full Width -->
            <div id="profile-section" class="hidden h-full">
                <div class="relative gradient-bg p-8 text-[#333] rounded-lg flex justify-between w-full">
                    <div>
                        <h3 class="text-3xl font-bold mb-2">My Profile</h3>
                        <p class="text-[#333]/90">Manage your account and preferences</p>
                    </div>
                    <div>
                        <img src="{{ asset('images/texture.png') }}" alt="Logo" class="w-24 scale-150">
                    </div>
                </div>
                
                <div class="pt-8">
                    <!-- Single Unified Container -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <!-- Header Section with Gradient Background -->
                        <div class="h-16 relative">
                            <!-- Background Pattern -->
                            <div class="absolute inset-0 opacity-20">
                                <div class="absolute inset-0 bg-gradient-to-br from-white/30 to-transparent"></div>
                                <svg class="absolute bottom-0 right-0 w-32 h-32 transform translate-x-8 translate-y-8" viewBox="0 0 200 200">
                                    <circle cx="100" cy="100" r="60" fill="none" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="currentColor" stroke-width="1" opacity="0.2"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Profile Section -->
                        <div class="p-8 -mt-16 relative">
                            <div class="flex flex-col lg:flex-row items-start gap-8 mb-8">
                                <!-- Profile Picture - Left Side -->
                                <div class="relative flex-shrink-0">
                                    @if($user->hasProfilePicture())
                                        <div class="w-36 h-36 lg:w-56 lg:h-56 rounded-2xl overflow-hidden border-4 border-white shadow-xl ring-4 ring-blue-100">
                                            <img src="data:image/jpeg;base64,{{ $user->getProfilePictureBase64() }}"
                                                alt="Profile picture"
                                                class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-32 h-32 lg:w-40 lg:h-40 gradient-bg rounded-2xl flex items-center justify-center text-white text-4xl lg:text-5xl font-bold shadow-xl ring-4 ring-yellow-100">
                                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                        </div>
                                    @endif
                                    <!-- Online Status Indicator -->
                                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                    </div>
                                </div>
                                
                                <!-- Profile Info - Right Side (LinkedIn Style) -->
                                <div class="flex-1">
                                    <!-- Name & Email -->
                                    <div class="mb-4">
                                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-1">{{ Auth::user()->name }}</h2>
                                        <p class="text-lg text-gray-600">{{ Auth::user()->email }}</p>
                                    </div>
                                    
                                    <!-- Skills -->
                                    <div class="mb-4">
                                        @if(isset($learner->skill) && $learner->skill !== 'None')
                                            <div class="flex flex-wrap gap-2">
                                                @foreach(explode(',', $learner->skill) as $skill)
                                                    <span class="px-3 py-1 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-800 text-sm font-medium rounded-full border border-blue-100">
                                                        {{ trim($skill) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-gray-500 text-sm italic">No skills added</div>
                                        @endif
                                    </div>
                                    
                                    <!-- Bio -->
                                    <div class="mb-6">
                                        @if(isset($learner->bio) && $learner->bio !== 'None')
                                            <p class="text-gray-700 leading-relaxed">{{ $learner->bio }}</p>
                                        @else
                                            <p class="text-gray-500 text-sm italic">No bio added</p>
                                        @endif
                                    </div>
                                    
                                    <!-- Status & Stats -->
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                        <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 rounded-full text-sm font-medium">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                            Active Learner
                                        </div>
                                        
                                        <div class="flex items-center gap-6 text-sm text-gray-600">
                                            <span><strong class="text-gray-900">{{ isset($learner_courses) ? count($learner_courses) : '0' }}</strong> Courses</span>
                                            <span><strong class="text-gray-900">24</strong> Hours</span>
                                            <span><strong class="text-gray-900">75%</strong> Avg Progress</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Divider -->
                            <div class="border-t border-gray-200 my-8"></div>
                            
                            <!-- Achievement Section -->
                            <div>
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">Achievements</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="text-center p-6 bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl border border-yellow-100">
                                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="font-bold text-lg text-gray-900 mb-2">Fast Learner</h4>
                                        <p class="text-sm text-gray-600">Completed 3+ courses this month</p>
                                    </div>
                                    
                                    <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border border-purple-100">
                                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="font-bold text-lg text-gray-900 mb-2">High Achiever</h4>
                                        <p class="text-sm text-gray-600">Maintains 75%+ average progress</p>
                                    </div>
                                    
                                    <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="font-bold text-lg text-gray-900 mb-2">Consistent</h4>
                                        <p class="text-sm text-gray-600">24 hours of learning completed</p>
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
    const navLabels = document.querySelectorAll('.nav-label');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');
    const sidebarHeader = document.getElementById('sidebar-header');

    // Navigation
    const navMyCourses = document.getElementById('nav-my-courses');
    const navEnroll = document.getElementById('nav-enroll');
    const navProfile = document.getElementById('nav-profile');

    // Sections
    const myCoursesSection = document.getElementById('my-courses-section');
    const enrollSection = document.getElementById('enroll-section');
    const profileSection = document.getElementById('profile-section');

    let sidebarOpen = true;

    function expandSidebar() {
        sidebar.classList.remove('w-20');
        sidebar.classList.add('w-64');
        sidebarTitle.classList.remove('hidden');
        sidebarHeader.classList.add('justify-between');
        sidebarHeader.classList.remove('justify-center');
        hamburgerIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
        navLabels.forEach(label => label.classList.remove('hidden'));
        document.querySelectorAll('.nav-item').forEach(item => {
            item.classList.add('justify-start');
            item.classList.remove('justify-center');
        });
    }

    function collapseSidebar() {
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-20');
        sidebarTitle.classList.add('hidden');
        sidebarHeader.classList.remove('justify-between');
        sidebarHeader.classList.add('justify-center');
        hamburgerIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
        navLabels.forEach(label => label.classList.add('hidden'));
        document.querySelectorAll('.nav-item').forEach(item => {
            item.classList.add('justify-center');
            item.classList.remove('justify-start');
        });
    }

    // 🔥 Initialize sidebar depending on screen size
    function initSidebar() {
        if (window.innerWidth < 1024) { // mobile / tablet (Tailwind lg breakpoint)
            collapseSidebar();
            sidebarOpen = false;
        } else {
            expandSidebar();
            sidebarOpen = true;
        }
    }

    initSidebar();

    // 🔄 Recheck on window resize
    window.addEventListener('resize', initSidebar);

    // Toggle button
    sidebarToggle.addEventListener('click', function() {
        sidebarOpen = !sidebarOpen;
        if (sidebarOpen) {
            expandSidebar();
        } else {
            collapseSidebar();
        }
    });

    // Section navigation
    function setActiveNav(activeNav) {
        const navItems = [navMyCourses, navEnroll, navProfile];
        navItems.forEach(nav => {
            nav.classList.remove('bg-[#fdd666]', 'text-[#333]', 'active');
            nav.classList.add('text-gray-700');
        });
        activeNav.classList.remove('text-gray-700');
        activeNav.classList.add('bg-[#fdd666]', 'text-[#333]', 'active');
    }

    function showSection(targetSection) {
        myCoursesSection.classList.add('hidden');
        enrollSection.classList.add('hidden');
        profileSection.classList.add('hidden');
        targetSection.classList.remove('hidden');
    }

    navMyCourses.addEventListener('click', e => { e.preventDefault(); setActiveNav(navMyCourses); showSection(myCoursesSection); });
    navEnroll.addEventListener('click', e => { e.preventDefault(); setActiveNav(navEnroll); showSection(enrollSection); });
    navProfile.addEventListener('click', e => { e.preventDefault(); setActiveNav(navProfile); showSection(profileSection); });
});
</script>

</x-app-layout>
