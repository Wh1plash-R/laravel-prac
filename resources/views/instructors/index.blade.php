<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Courses - Instructor Dashboard
        </h2>
    </x-slot>

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #35b5ac 0%, #2dd4aa 100%);
        }
        .card-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }
        .hover-subtle {
            transition: all 0.2s ease;
        }
        .hover-subtle:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .instructor-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }
    </style>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="instructor-gradient rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">Welcome, {{ $instructor->name }}</h1>
                            <p class="text-white/90">Manage your courses and interact with your learners</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold">{{ $courses->count() }}</div>
                            <div class="text-white/80 text-sm">Active Courses</div>
                        </div>
                    </div>
                </div>
            </div>

         <!-- Quick Stats Section -->
        @if($courses->count() > 0)
        <div class="mt-8 flex justify-center">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                <!-- Active Courses Card -->
                <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 h-full">
                    <div class="flex items-center h-full">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-6m-2-5.5V21m0 0H3"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-2xl font-bold text-gray-900">{{ $courses->count() }}</div>
                            <div class="text-gray-600 text-sm whitespace-nowrap">Active Courses</div>
                        </div>
                    </div>
                </div>

                <!-- Total Learners Card -->
                <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 h-full">
                    <div class="flex items-center h-full">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-2xl font-bold text-gray-900">{{ $courses->sum('learners_count') }}</div>
                            <div class="text-gray-600 text-sm whitespace-nowrap">Total Learners</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif


            <h1 class="mt-8 pl-6 text-2xl font-bold text-[#333]">My Courses</h1>

            <!-- Courses Grid -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($courses as $course)
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 instructor-gradient rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-6m-2-5.5V21m0 0H3"></path>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-500">{{ $course->department }}</span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $course->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($course->description, 100) }}</p>

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                {{ $course->learners_count }} learners
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $course->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <a href="{{ route('instructor.course.view', $course) }}"
                               class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-center block">
                                Manage Course
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-12 text-center">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-6m-2-5.5V21m0 0H3"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Courses Assigned</h3>
                            <p class="text-gray-600 mb-6">You don't have any courses assigned yet. Contact your administrator to get courses assigned to you.</p>
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

          
        </div>
    </div>
</x-app-layout>
