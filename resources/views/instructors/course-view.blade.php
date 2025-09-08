<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->title }} - Instructor View
            </h2>
            <a href="{{ route('dashboard') }}"
               class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                ← Back to Dashboard
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
        }, 2000);
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
        }, 2000);
    </script>
    @endif

    <div class="min-h-screen bg-gray-50">
        <!-- Course Header -->
        <div class="instructor-gradient text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <!-- Back to Dashboard Button -->
                <div class="mb-6">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold rounded-lg transition-all border border-white/30 hover:border-white/50 group">
                        <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>

                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 mr-3 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-6m-2-5.5V21m0 0H3"></path>
                            </svg>
                            <span class="text-white/80 text-sm font-medium">INSTRUCTOR VIEW</span>
                        </div>
                        <h1 class="text-4xl font-bold mb-4">{{ $course->title }}</h1>
                        <p class="text-white/90 text-lg mb-6">{{ $course->description }}</p>

                        <div class="flex items-center space-x-6 text-white/80">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-6m-2-5.5V21m0 0H3"></path>
                                </svg>
                                <span>{{ $course->department }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>{{ $enrolledLearners->count() }} Enrolled Learners</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>12 Weeks</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="ml-8 flex flex-col space-y-3">
                        <!-- Course Stats Card -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 min-w-[220px]">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white mb-1">{{ $enrolledLearners->count() }}</div>
                                <div class="text-white/80 text-sm">Total Learners</div>
                            </div>
                        </div>

                        <!-- Quick Add Buttons -->
                        <div class="space-y-2">
                            <button onclick="openAnnouncementModal()"
                                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors border border-emerald-700 shadow">
                                + New Announcement
                            </button>
                            <button onclick="openActivityModal()"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors border border-blue-700 shadow">
                                + Add Activity
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Enrolled Learners Section -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Enrolled Learners</h2>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-500">{{ $enrolledLearners->count() }} total</span>
                                @if($enrolledLearners->count() > 0)
                                    <button onclick="openPromoteModal()"
                                            class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 text-sm flex items-center gap-2 shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                        Promote Students
                                    </button>
                                @endif
                            </div>
                        </div>

                        @if($enrolledLearners->count() > 0)
                            <div class="space-y-3">
                                @foreach($enrolledLearners as $learner)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3">
                                                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-200">
                                                    <img src="{{$learner->user->profile_picture_url }}"
                                                        alt="Profile picture"
                                                        class="w-full h-full object-cover">
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ $learner->user->name ?? $learner->name }}</h4>
                                                <p class="text-gray-600 text-sm">{{ $learner->user->email ?? 'No email available' }}</p>
                                                @if($learner->skill)
                                                    <p class="text-gray-500 text-xs">Skill: {{ $learner->skill }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                            
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No Learners Enrolled</h3>
                                <p class="text-gray-500">Learners will appear here once they enroll in your course.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Course Announcements Management -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Course Announcements</h2>
                            </div>
                            <button onclick="openAnnouncementModal()"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-sm">
                                + Add Announcement
                            </button>
                        </div>

                        <!-- Announcements -->
                        <div class="space-y-4">
                            @forelse($announcements as $announcement)
                                <div class="bg-{{ $announcement->type_color }}-50 border-l-4 border-{{ $announcement->type_color }}-400 p-4 rounded-r-lg">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-1">
                                                <h4 class="font-semibold text-{{ $announcement->type_color }}-900">{{ $announcement->title }}</h4>
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $announcement->type_color }}-100 text-{{ $announcement->type_color }}-800">
                                                    {{ ucfirst($announcement->type) }}
                                                </span>
                                            </div>
                                            <p class="text-{{ $announcement->type_color }}-800 text-sm mt-1">
                                                {{ $announcement->description }}
                                            </p>
                                            <p class="text-{{ $announcement->type_color }}-600 text-xs mt-2">
                                                Posted {{ $announcement->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="ml-4 flex items-center space-x-2">
                                            <button onclick="openAnnouncementModal({{ $announcement->id }})" class="text-{{ $announcement->type_color }}-600 hover:text-{{ $announcement->type_color }}-800 text-sm font-medium">Edit</button>

                                            <form id="delete-announcement-{{ $announcement->id }}" action="{{ route('instructor.announcement.destroy', $announcement) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <x-confirm-dialog
                                                title="Delete Announcement"
                                                :message="'Are you sure you want to delete ' . $announcement->title . '? This action cannot be undone.'"
                                                confirmText="Delete"
                                                cancelText="Cancel"
                                                loadingMessage="Deleting announcement..."
                                                :formId="'delete-announcement-' . $announcement->id">
                                                <x-slot:trigger>
                                                    <button type="button" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                                </x-slot:trigger>
                                            </x-confirm-dialog>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Announcements</h3>
                                    <p class="text-gray-500 mb-4">You haven't posted any announcements yet.</p>
                                    <button onclick="openAnnouncementModal()"
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-sm">
                                        + Post Your First Announcement
                                    </button>
                                </div>
                            @endforelse

                            @if($announcements->count() > 0)
                                <div class="text-center py-4">
                                    <button onclick="openAnnouncementModal()"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                        + Add New Announcement
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Activities & Assignments Management -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Activities & Assignments</h2>
                            </div>
                            <button onclick="openActivityModal()"
                                    class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-sm">
                                + Add Activity
                            </button>
                        </div>

                        <!-- Assignments -->
                        <div class="space-y-4">
                            @forelse($assignments as $assignment)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <h4 class="font-semibold text-gray-900">{{ $assignment->title }}</h4>
                                                <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $assignment->status_color }}-100 text-{{ $assignment->status_color }}-800">
                                                    {{ $assignment->status_text }}
                                                </span>
                                            </div>
                                            <p class="text-gray-600 text-sm mt-1">{{ $assignment->description }}</p>
                                            <div class="flex items-center mt-2 text-xs text-gray-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                @if($assignment->due_date->isFuture())
                                                    Due: {{ $assignment->due_date->format('M j, Y \a\t g:i A') }}
                                                @else
                                                    <span class="text-red-500">Due: {{ $assignment->due_date->format('M j, Y \a\t g:i A') }} (Past due)</span>
                                                @endif
                                                @if($assignment->points)
                                                    • {{ $assignment->points }} points
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-400 mt-1">Created {{ $assignment->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="ml-4 flex items-center space-x-2">
                                            <span class="text-sm text-gray-600">{{ $assignment->submissions->count() }}/{{ $enrolledLearners->count() }} submitted</span>
                                            <div class="flex items-center space-x-2">
                                                <button onclick="openActivityModal({{ $assignment->id }})" class="text-purple-600 hover:text-purple-800 text-sm font-medium">Edit</button>

                                                <a href="{{ route('instructor.assignment.view', $assignment) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>

                                                <form id="delete-assignment-{{ $assignment->id }}" action="{{ route('instructor.assignment.destroy', $assignment) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <x-confirm-dialog
                                                    title="Delete Assignment"
                                                    :message="'Are you sure you want to delete ' . $assignment->title . '? This action cannot be undone.'"
                                                    confirmText="Delete"
                                                    cancelText="Cancel"
                                                    loadingMessage="Deleting assignment..."
                                                    :formId="'delete-assignment-' . $assignment->id">
                                                    <x-slot:trigger>
                                                        <button type="button" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                                    </x-slot:trigger>
                                                </x-confirm-dialog>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Activities or Assignments</h3>
                                    <p class="text-gray-500 mb-4">You haven't created any activities or assignments yet.</p>
                                    <button onclick="openActivityModal()"
                                            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-sm">
                                        + Create Your First Assignment
                                    </button>
                                </div>
                            @endforelse

                            @if($assignments->count() > 0)
                                <div class="text-center py-4">
                                    <button onclick="openActivityModal()"
                                            class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                                        + Add New Activity or Assignment
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Course Management Stats -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Statistics</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Learners</span>
                                <span class="font-semibold text-gray-900">{{ $enrolledLearners->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Active Assignments</span>
                                <span class="font-semibold text-gray-900">{{ $assignments->where('status', 'active')->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Assignments</span>
                                <span class="font-semibold text-gray-900">{{ $assignments->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Announcements</span>
                                <span class="font-semibold text-gray-900">{{ $announcements->count() }}</span>
                            </div>
                        </div>
                    </div>

                 
                    <!-- Quick Actions -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <button onclick="openAnnouncementModal()"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-sm">
                                Post Announcement
                            </button>
                            <button onclick="openActivityModal()"
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-sm">
                                Create Assignment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Announcement Modal -->
    <div id="announcementModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="announcementModalTitle">
                        Add New Announcement
                    </h3>
                    <button onclick="closeAnnouncementModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="announcementForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4"
                        x-data="{ hasChanges: false, selectedFile: null, currentFile: null }"
                        x-init="
                            $watch('hasChanges', value => {
                                if (value) window.announcementFormChanged = true;
                            });
                        ">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="_method" value="POST" id="announcementMethod">

                    <div>
                        <label for="announcement_title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" id="announcement_title" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                @input="hasChanges = true">
                    </div>

                    <div>
                        <label for="announcement_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="announcement_description" rows="4" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                @input="hasChanges = true"></textarea>
                    </div>

                    <div>
                        <label for="announcement_type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <select name="type" id="announcement_type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                @change="hasChanges = true">
                            <option value="" disabled selected>Select Type</option>
                            <option value="info">Info</option>
                            <option value="warning">Warning</option>
                            <option value="success">Success</option>
                            <option value="important">Important</option>
                        </select>
                    </div>

                    <!-- File Upload Section -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Attach File (Optional)
                            <span class="text-gray-500 text-xs">- Course resources, documents, etc.</span>
                        </label>

                        <!-- Current File Display (Edit Mode) -->
                        <div x-show="currentFile" class="mb-3 p-3 bg-gray-50 border border-gray-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700" x-text="currentFile?.name"></span>
                                    <span class="text-xs text-gray-500 ml-2" x-text="currentFile?.size"></span>
                                </div>
                                <button type="button" @click="currentFile = null; hasChanges = true"
                                        class="text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <input type="hidden" name="remove_file" x-model="currentFile === null ? '1' : '0'">
                        </div>

                        <!-- File Upload Area -->
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="announcement_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a file</span>
                                        <input id="announcement_file" name="file" type="file" class="sr-only"
                                               @change="selectedFile = $event.target.files[0]; hasChanges = true"
                                               accept=".pdf,.doc,.docx,.txt,.zip,.rar,.jpg,.jpeg,.png,.gif,.mp4,.mp3,.ppt,.pptx,.xls,.xlsx">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PDF, DOC, TXT, ZIP, Images, Videos up to 10MB
                                </p>
                            </div>
                        </div>

                        <!-- Selected File Preview -->
                        <div x-show="selectedFile" class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-700" x-text="selectedFile?.name"></span>
                                <span class="text-xs text-gray-500 ml-2" x-text="selectedFile ? Math.round(selectedFile.size / 1024) + ' KB' : ''"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeAnnouncementModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Post Announcement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add/Edit Activity Modal -->
    <div id="activityModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="activityModalTitle">
                        Add New Activity/Assignment
                    </h3>
                    <button onclick="closeActivityModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="activityForm" action="" method="POST" class="space-y-4"
                        x-data="{ hasChanges: false }"
                        x-init="
                            $watch('hasChanges', value => {
                                if (value) window.activityFormChanged = true;
                            });
                        ">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="_method" value="POST" id="activityMethod">

                    <div>
                        <label for="activity_title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" id="activity_title" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                @input="hasChanges = true">
                    </div>

                    <div>
                        <label for="activity_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="activity_description" rows="4" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                @input="hasChanges = true"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label for="activity_points" class="block text-sm font-medium text-gray-700 mb-2">Points</label>
                            <input type="number" name="points" id="activity_points" min="10" placeholder="100" max="100" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                    @input="hasChanges = true">
                        </div>
                    </div>

                    <div>
                        <label for="activity_due_date" class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
                        <input type="datetime-local" name="due_date" id="activity_due_date" required min="{{ date('Y-m-d\TH:i') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                @change="hasChanges = true">
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeActivityModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                            Create Activity
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Unsaved Changes Confirmation Dialog -->
    <x-confirm-dialog
        title="Unsaved Changes"
        message="You have unsaved changes. Are you sure you want to close without saving? Your changes will be lost."
        confirmText="Discard Changes"
        cancelText="Keep Editing"
        loadingMessage="Closing..."
        formId="unsaved-changes-form"
        event="show-unsaved-changes-dialog">
        <x-slot:trigger>
            <!-- This will be triggered by JavaScript event -->
        </x-slot:trigger>
    </x-confirm-dialog>

    <!-- Hidden form for the confirm dialog -->
    <form id="unsaved-changes-form" style="display: none;">
        @csrf
    </form>

    <!-- Modal JavaScript -->
    <script>
        let currentEditingAnnouncement = null;
        let currentEditingAssignment = null;

        function openAnnouncementModal(announcementId = null) {
            const modal = document.getElementById('announcementModal');
            const form = document.getElementById('announcementForm');
            const title = document.getElementById('announcementModalTitle');
            const submitBtn = form.querySelector('button[type="submit"]');
            const methodInput = document.getElementById('announcementMethod');

            // Reset form and Alpine data
            form.reset();
            Alpine.store('announcementForm', {
                selectedFile: null,
                currentFile: null
            });

            if (announcementId) {
                // Edit mode
                const announcement = @json($announcements);
                const announcementData = announcement.find(a => a.id == announcementId);

                if (announcementData) {
                    currentEditingAnnouncement = announcementData;
                    title.textContent = 'Edit Announcement';
                    submitBtn.textContent = 'Update Announcement';
                    methodInput.value = 'PATCH';
                    form.action = `/instructor/announcement/${announcementId}`;

                    // Populate form fields
                    document.getElementById('announcement_title').value = announcementData.title;
                    document.getElementById('announcement_description').value = announcementData.description;
                    document.getElementById('announcement_type').value = announcementData.type;

                    // Handle file data for edit mode
                    if (announcementData.file_name) {
                        // Set current file data via Alpine.js
                        setTimeout(() => {
                            const formComponent = form._x_dataStack && form._x_dataStack[0];
                            if (formComponent) {
                                formComponent.currentFile = {
                                    name: announcementData.file_name,
                                    size: announcementData.file_size_formatted || 'Unknown size'
                                };
                            }
                        }, 10);
                    }
                }
            } else {
                // Add mode
                currentEditingAnnouncement = null;
                title.textContent = 'Add New Announcement';
                submitBtn.textContent = 'Post Announcement';
                methodInput.value = 'POST';
                form.action = '{{ route("instructor.announcement.store", $course) }}';
            }

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function openActivityModal(assignmentId = null) {
            const modal = document.getElementById('activityModal');
            const form = document.getElementById('activityForm');
            const title = document.getElementById('activityModalTitle');
            const submitBtn = form.querySelector('button[type="submit"]');
            const methodInput = document.getElementById('activityMethod');

            // Reset form
            form.reset();

            if (assignmentId) {
                // Edit mode
                const assignments = @json($assignments);
                const assignmentData = assignments.find(a => a.id == assignmentId);

                if (assignmentData) {
                    currentEditingAssignment = assignmentData;
                    // Format due date for datetime-local input
                    const dueDate = new Date(assignmentData.due_date);
                    const formattedDate = dueDate.toISOString().slice(0, 16);

                    title.textContent = 'Edit Activity/Assignment';
                    submitBtn.textContent = 'Update Activity';
                    methodInput.value = 'PATCH';
                    form.action = `/instructor/assignment/${assignmentId}`;

                    // Populate form fields
                    document.getElementById('activity_title').value = assignmentData.title;
                    document.getElementById('activity_description').value = assignmentData.description;
                    document.getElementById('activity_points').value = assignmentData.points;
                    document.getElementById('activity_due_date').value = formattedDate;
                }
            } else {
                // Add mode
                currentEditingAssignment = null;
                title.textContent = 'Add New Activity/Assignment';
                submitBtn.textContent = 'Create Activity';
                methodInput.value = 'POST';
                form.action = '{{ route("instructor.activity.store", $course) }}';
            }

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeAnnouncementModal(force = false) {
            if (!force && hasAnnouncementChanges()) {
                // Show confirmation dialog
                window.dispatchEvent(new CustomEvent('show-unsaved-changes-dialog', {
                    detail: { type: 'announcement' }
                }));
                return;
            }

            const modal = document.getElementById('announcementModal');
            const form = document.getElementById('announcementForm');

            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            // Reset form and state
            form.reset();
            currentEditingAnnouncement = null;
        }

        function closeActivityModal(force = false) {
            if (!force && hasActivityChanges()) {
                // Show confirmation dialog
                window.dispatchEvent(new CustomEvent('show-unsaved-changes-dialog', {
                    detail: { type: 'activity' }
                }));
                return;
            }

            const modal = document.getElementById('activityModal');
            const form = document.getElementById('activityForm');

            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            // Reset form and state
            form.reset();
            currentEditingAssignment = null;
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const announcementModal = document.getElementById('announcementModal');
            const activityModal = document.getElementById('activityModal');

            if (event.target === announcementModal) {
                closeAnnouncementModal();
            }
            if (event.target === activityModal) {
                closeActivityModal();
            }
        }

        // Helper functions for change detection
        function hasAnnouncementChanges() {
            return window.announcementFormChanged || false;
        }

        function hasActivityChanges() {
            return window.activityFormChanged || false;
        }

        // Set minimum date for due date input to today
        document.addEventListener('DOMContentLoaded', function() {
            const dueDateInput = document.getElementById('activity_due_date');
            if (dueDateInput) {
                const now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                dueDateInput.min = now.toISOString().slice(0, 16);
            }
        });

        // Handle unsaved changes confirmation
        window.addEventListener('show-unsaved-changes-dialog', function(event) {
            const modalType = event.detail.type;

            // Store the modal type for the confirm dialog
            window.pendingModalClose = modalType;
        });

        // Handle the confirm dialog form submission
        document.addEventListener('DOMContentLoaded', function() {
            const unsavedChangesForm = document.getElementById('unsaved-changes-form');
            if (unsavedChangesForm) {
                unsavedChangesForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Close the appropriate modal
                    if (window.pendingModalClose === 'announcement') {
                        closeAnnouncementModal(true);
                    } else if (window.pendingModalClose === 'activity') {
                        closeActivityModal(true);
                    }

                    // Clear the pending close
                    window.pendingModalClose = null;
                });
            }
        });
    </script>

    <!-- Promote Students Modal -->
    <div id="promoteModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Promote Students</h3>
                        </div>
                        <button onclick="closePromoteModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Warning Message -->
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-amber-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.764 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <div class="text-sm">
                                <p class="font-medium text-amber-800 mb-1">Important Notice</p>
                                <p class="text-amber-700">
                                    Promoting students will finalize their grades and complete the course for the current batch.
                                    This action cannot be undone and will:
                                </p>
                                <ul class="list-disc list-inside text-amber-700 mt-2 space-y-1">
                                    <li>Calculate final grades for all enrolled students</li>
                                    <li>Remove students from current enrollment</li>
                                    <li>Reset all course announcements and assignments</li>
                                    <li>Prevent re-enrollment in this course</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-gray-900 mb-2">{{ $course->title }}</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Department:</strong> {{ $course->department }}</p>
                            <p><strong>Enrolled Students:</strong> {{ $enrolledLearners->count() }}</p>
                            <p><strong>Total Assignments:</strong> {{ $assignments->count() }}</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('instructor.course.promote', $course) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" id="confirmPromotion" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">
                                    I understand that this action is permanent and will complete the course for all enrolled students.
                                </span>
                            </label>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <button type="button" onclick="closePromoteModal()"
                                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="submit" id="promoteButton" disabled
                                    class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed text-white font-semibold py-3 px-4 rounded-lg transition-all">
                                Promote Students
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Promote modal functions
        function openPromoteModal() {
            document.getElementById('promoteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePromoteModal() {
            document.getElementById('promoteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Reset form
            document.getElementById('confirmPromotion').checked = false;
            document.getElementById('promoteButton').disabled = true;
        }

        // Enable/disable promote button based on confirmation checkbox
        document.getElementById('confirmPromotion').addEventListener('change', function() {
            document.getElementById('promoteButton').disabled = !this.checked;
        });

        // Close modal when clicking outside
        document.getElementById('promoteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePromoteModal();
            }
        });
    </script>

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
</x-app-layout>
