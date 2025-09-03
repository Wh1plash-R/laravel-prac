<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $assignment->title }} - Grading
            </h2>
            <a href="{{ route('instructor.course.view', $assignment->course) }}"
               class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                ← Back to Course
            </a>
        </div>
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
        }, 3000);
    </script>
    @endif

    @if (session('error'))
    <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
        <div id="error-flash"
             class="p-4 bg-red-100 text-red-900 border border-red-300 rounded-lg shadow-lg w-full max-w-sm text-center animate-fade-in transition-opacity duration-500">
            {{ session('error') }}
        </div>
    </div>

    <script>
        setTimeout(function () {
            const flash = document.getElementById('error-flash');
            if (flash) {
                flash.classList.add('opacity-0');
                setTimeout(() => flash.remove(), 500);
            }
        }, 3000);
    </script>
    @endif

    <div class="min-h-screen bg-gray-50">
        <!-- Assignment Header -->
        <div class="instructor-gradient text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('instructor.course.view', $assignment->course) }}"
                       class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold rounded-lg transition-all border border-white/30 hover:border-white/50 group">
                        <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to {{ $assignment->course->title }}
                    </a>
                </div>

                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 mr-3 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="text-white/80 text-sm font-medium">INSTRUCTOR GRADING</span>
                        </div>
                        <h1 class="text-4xl font-bold mb-4">{{ $assignment->title }}</h1>
                        <p class="text-white/90 text-lg mb-6">{{ $assignment->description }}</p>

                        <div class="flex items-center space-x-6 text-white/80">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @if($assignment->due_date->isFuture())
                                    <span>Due: {{ $assignment->due_date->format('M j, Y \a\t g:i A') }}</span>
                                @else
                                    <span class="text-red-300">Due: {{ $assignment->due_date->format('M j, Y \a\t g:i A') }} (Past due)</span>
                                @endif
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                <span>{{ $assignment->points }} points</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>{{ $totalLearners }} Enrolled Learners</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submission Stats -->
                    <div class="ml-8 grid grid-cols-3 gap-4">
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center min-w-[100px]">
                            <div class="text-2xl font-bold text-white mb-1">{{ $submittedCount }}</div>
                            <div class="text-white/80 text-sm">Submitted</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center min-w-[100px]">
                            <div class="text-2xl font-bold text-white mb-1">{{ $gradedCount }}</div>
                            <div class="text-white/80 text-sm">Graded</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center min-w-[100px]">
                            <div class="text-2xl font-bold text-white mb-1">{{ $totalLearners - $submittedCount }}</div>
                            <div class="text-white/80 text-sm">Pending</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignment Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-3 space-y-8">
                    <!-- Assignment Details -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 instructor-gradient rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Assignment Details</h2>
                        </div>
                        <div class="prose prose-gray max-w-none">
                            <p class="text-gray-700 leading-relaxed">{{ $assignment->description }}</p>
                        </div>
                    </div>

                    <!-- Submissions List -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Student Submissions</h2>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span>{{ $submittedCount }}/{{ $totalLearners }} submitted</span>
                                <div class="w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $totalLearners > 0 ? ($submittedCount / $totalLearners) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @forelse($learnersWithSubmissions as $learnerData)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center flex-1">
                                            <!-- Profile Picture -->
                                            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-200 mr-4">
                                                <img src="{{ $learnerData->learner->user->profile_picture_url ?? '/images/default-avatar.png' }}"
                                                     alt="Profile picture"
                                                     class="w-full h-full object-cover">
                                            </div>

                                            <!-- Student Info -->
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">{{ $learnerData->learner->user->name ?? $learnerData->learner->name }}</h4>
                                                <p class="text-gray-600 text-sm">{{ $learnerData->learner->user->email ?? 'No email available' }}</p>
                                                @if($learnerData->submission && $learnerData->submitted_at)
                                                    <p class="text-gray-500 text-xs">
                                                        Submitted {{ $learnerData->submitted_at->format('M j, Y \a\t g:i A') }}
                                                        @if($learnerData->submitted_at > $assignment->due_date)
                                                            <span class="text-red-500 font-medium">(Late)</span>
                                                        @endif
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Submission Status -->
                                            <div class="mx-4">
                                                @if($learnerData->has_submitted)
                                                                                                        @if($learnerData->submission->file_path)
                                                        <div class="flex items-center text-sm text-gray-600">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                            <a href="{{ route('instructor.assignment.download', [$assignment, $learnerData->learner]) }}" target="_blank"
                                                               class="text-blue-600 hover:text-blue-800 font-medium">
                                                                {{ $learnerData->submission->file_name }}
                                                            </a>
                                                        </div>
                                                        <p class="text-xs text-gray-500 mt-1">{{ $learnerData->submission->file_size_formatted }} • Click to download</p>
                                                    @endif

                                                    @if($learnerData->submission->comments)
                                                        <div class="mt-2 p-2 bg-gray-50 rounded text-sm text-gray-700">
                                                            <strong>Student comments:</strong> {{ Str::limit($learnerData->submission->comments, 100) }}
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>

                                            <!-- Status Badge -->
                                            <div class="mx-4">
                                                @if($learnerData->is_graded)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                        Graded: {{ $learnerData->grade }}/{{ $assignment->points }}
                                                    </span>
                                                @elseif($learnerData->has_submitted)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                        Submitted
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                        Not Submitted
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Grading Section -->
                                        @if($learnerData->has_submitted)
                                            <div class="ml-4">
                                                @if($learnerData->is_graded)
                                                    <!-- Already Graded - Show Edit Option -->
                                                    <button onclick="openGradingModal({{ $learnerData->learner->id }}, '{{ $learnerData->learner->user->name ?? $learnerData->learner->name }}', {{ $learnerData->grade }}, '{{ addslashes($learnerData->submission->feedback ?? '') }}')"
                                                            class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                                                        Edit Grade
                                                    </button>
                                                @else
                                                    <!-- Not Graded - Show Grade Option -->
                                                    <button onclick="openGradingModal({{ $learnerData->learner->id }}, '{{ $learnerData->learner->user->name ?? $learnerData->learner->name }}', null, '')"
                                                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded text-sm transition-colors">
                                                        Grade
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Students Enrolled</h3>
                                    <p class="text-gray-500">Students will appear here once they enroll in your course.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Assignment Stats -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Grading Progress</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Students</span>
                                <span class="font-semibold text-gray-900">{{ $totalLearners }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Submitted</span>
                                <span class="font-semibold text-blue-600">{{ $submittedCount }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Graded</span>
                                <span class="font-semibold text-green-600">{{ $gradedCount }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Pending</span>
                                <span class="font-semibold text-orange-600">{{ $submittedCount - $gradedCount }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Not Submitted</span>
                                <span class="font-semibold text-red-600">{{ $totalLearners - $submittedCount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Assignment Info -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Assignment Info</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Course</span>
                                <span class="font-semibold text-gray-900">{{ $assignment->course->title }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Max Points</span>
                                <span class="font-semibold text-gray-900">{{ $assignment->points }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Status</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $assignment->status_color }}-100 text-{{ $assignment->status_color }}-800">
                                    {{ $assignment->status_text }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Due Date</span>
                                <span class="font-semibold {{ $assignment->due_date->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $assignment->due_date->format('M j, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Assignment Status & Actions -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Assignment Status</h3>

                        <div class="mb-4 p-3 rounded-lg {{ $assignment->status === 'active' ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-200' }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($assignment->status === 'active')
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-green-800 font-medium">Active</span>
                                    @else
                                        <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        <span class="text-gray-800 font-medium">Locked</span>
                                    @endif
                                </div>

                                <div class="flex space-x-2">
                                    @if($assignment->status === 'active')
                                        <form action="{{ route('instructor.assignment.lock', $assignment) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" onclick="return confirm('Are you sure you want to lock this assignment? Students will no longer be able to submit work.')"
                                                    class="px-3 py-1 bg-orange-600 hover:bg-orange-700 text-white text-xs font-medium rounded transition-colors">
                                                Lock
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('instructor.assignment.unlock', $assignment) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" onclick="return confirm('Are you sure you want to unlock this assignment? Students will be able to submit work again.')"
                                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded transition-colors">
                                                Unlock
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <p class="text-sm {{ $assignment->status === 'active' ? 'text-green-700' : 'text-gray-700' }} mt-1">
                                @if($assignment->status === 'active')
                                    Students can submit their work for this assignment.
                                @else
                                    Students cannot submit work. Assignment is locked.
                                @endif
                            </p>
                        </div>

                        <h4 class="text-md font-semibold text-gray-900 mb-3">Quick Actions</h4>
                        <div class="space-y-3">
                            <button onclick="openEditModal()"
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-sm">
                                Edit Assignment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grading Modal -->
    <div id="gradingModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="gradingModalTitle">
                        Grade Submission
                    </h3>
                    <button onclick="closeGradingModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="gradingForm" action="{{ route('instructor.assignment.grade', $assignment) }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="learner_id" id="grading_learner_id">

                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <p class="text-sm text-gray-600">Student:</p>
                        <p class="font-semibold text-gray-900" id="grading_student_name"></p>
                    </div>

                    <div>
                        <label for="grade" class="block text-sm font-medium text-gray-700 mb-2">
                            Grade (0 - {{ $assignment->points }} points)
                        </label>
                        <input type="number" name="grade" id="grade" min="0" max="{{ $assignment->points }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">
                            Feedback (Optional)
                        </label>
                        <textarea name="feedback" id="feedback" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                placeholder="Provide feedback to the student..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeGradingModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                            Submit Grade
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Edit Assignment Modal -->
    <div id="editAssignmentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="editAssignmentModalTitle">
                        Edit Assignment
                    </h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="editAssignmentForm" action="{{ route('instructor.assignment.update', $assignment) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" id="edit_title" value="{{ $assignment->title }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <div>
                        <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="edit_description" rows="4" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">{{ $assignment->description }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_points" class="block text-sm font-medium text-gray-700 mb-2">Points</label>
                            <input type="number" name="points" id="edit_points" min="10" max="100" value="{{ $assignment->points }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="edit_due_date" class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
                            <input type="datetime-local" name="due_date" id="edit_due_date"
                                   value="{{ $assignment->due_date->format('Y-m-d\TH:i') }}" required
                                   min="{{ now()->format('Y-m-d\TH:i') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeEditModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                            Update Assignment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        // Existing grading modal functions
        function openGradingModal(learnerId, studentName, currentGrade = null, currentFeedback = '') {
            const modal = document.getElementById('gradingModal');
            const title = document.getElementById('gradingModalTitle');
            const studentNameEl = document.getElementById('grading_student_name');
            const learnerIdInput = document.getElementById('grading_learner_id');
            const gradeInput = document.getElementById('grade');
            const feedbackInput = document.getElementById('feedback');

            // Set values
            title.textContent = currentGrade !== null ? 'Edit Grade' : 'Grade Submission';
            studentNameEl.textContent = studentName;
            learnerIdInput.value = learnerId;
            gradeInput.value = currentGrade || '';
            feedbackInput.value = currentFeedback;

            // Show modal
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeGradingModal() {
            const modal = document.getElementById('gradingModal');
            const form = document.getElementById('gradingForm');

            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            form.reset();
        }

        // New edit assignment modal functions
        function openEditModal() {
            const modal = document.getElementById('editAssignmentModal');
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeEditModal() {
            const modal = document.getElementById('editAssignmentModal');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const gradingModal = document.getElementById('gradingModal');
            const editModal = document.getElementById('editAssignmentModal');

            if (event.target === gradingModal) {
                closeGradingModal();
            }
            if (event.target === editModal) {
                closeEditModal();
            }
        }
    </script>

    {{-- Validation Errors --}}
    @if ($errors->any())
      <div class="fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded max-w-md z-50">
        <ul class="list-disc pl-5 space-y-1">
          @foreach ($errors->all() as $error)
            <li class="text-sm">{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
</x-app-layout>
