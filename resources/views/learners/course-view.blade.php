<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->title }}
            </h2>
            <a href="{{ route('dashboard') }}"
               class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <style>
        .gradient-bg {
          background: #1d1d1d;
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
        <div class="gradient-bg text-white">
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
                        <h1 class="text-4xl font-bold mb-4">{{ $course->title }}</h1>
                        <p class="text-white/90 text-lg mb-6">{{ $course->description }}</p>

                        <div class="flex items-center space-x-6 text-white/80">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-[#fcd34d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-6m-2-5.5V21m0 0H3"></path>
                                </svg>
                                <span>{{ $course->department }}</span>
                            </div>
                            @if($course->instructor)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-[#fcd34d]"" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Instructor: {{ $course->instructor->name }}</span>
                            </div>
                            @endif
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-[#fcd34d]"" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>12 Weeks</span>
                            </div>
                        </div>
                    </div>

                    <!-- Course Actions -->
                    <div class="ml-8 flex flex-col space-y-3">
                        <!-- Progress Card -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 min-w-[200px]">
                            <div class="flex justify-between text-sm text-white/90 mb-2">
                                <span>Progress</span>
                                <span>25%</span>
                            </div>
                            <div class="w-full bg-white/20 rounded-full h-2">
                                <div class="bg-white h-2 rounded-full" style="width: 25%"></div>
                            </div>
                        </div>

                        <!-- Unenroll Button -->
                        <form method="POST"
                              action="{{ route('dashboard.update', $user->id) }}"
                              id="unenroll-form-{{ $course->id }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="unenroll" value="1">
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <x-confirm-dialog
                                title="Please confirm"
                                message="Are you sure you want to unenroll from {{ $course->title }}? You will lose all progress and access to course materials."
                                confirmText="Unenroll"
                                cancelText="Cancel"
                                loadingMessage="Unenrolling from course..."
                                :formId="'unenroll-form-' . $course->id">
                                <x-slot:trigger>
                                    <button type="button"
                                            class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors border border-red-700 shadow">
                                        Unenroll from Course
                                    </button>
                                </x-slot:trigger>
                            </x-confirm-dialog>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Course Description -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Course Overview</h2>
                        </div>
                        <div class="prose prose-gray max-w-none">
                            <p class="text-gray-700 leading-relaxed">{{ $course->description }}</p>
                            <p class="text-gray-600 mt-4">
                                This comprehensive course will guide you through essential concepts and practical applications.
                                You'll gain hands-on experience through interactive lessons, assignments, and real-world projects.
                            </p>
                        </div>
                    </div>

                    <!-- Announcements Section -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Announcements</h2>
                        </div>
                        <div class="space-y-4">
                            @forelse($course->announcements()->orderBy('created_at', 'desc')->get() as $announcement)
                                <div class="bg-{{ $announcement->type_color }}-50 border-l-4 border-{{ $announcement->type_color }}-400 p-4 rounded-r-lg">
                                    <div class="flex items-start">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-{{ $announcement->type_color }}-900">{{ $announcement->title }}</h4>
                                            <p class="text-{{ $announcement->type_color }}-800 text-sm mt-1">
                                                {{ $announcement->description }}
                                            </p>
                                            <p class="text-{{ $announcement->type_color }}-600 text-xs mt-2">
                                                Posted {{ $announcement->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-gray-500 text-sm">No announcements have been posted yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Assignments Section -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Activities & Assignments</h2>
                        </div>

                        @php
                            // Get all assignments for this course and learner's submissions
                            $allAssignments = $course->assignments;

                            // Get learner's submissions for this course
                            $learnerSubmissions = $learner ? $learner->submissions()
                                ->whereIn('assignment_id', $allAssignments->pluck('id'))
                                ->get() : collect();
                        @endphp
                        <div class="space-y-4">
                            @forelse($course->assignments()->orderBy('due_date', 'asc')->get() as $assignment)
                                @php
                                    // Get learner's submission for this assignment
                                    $submission = $learnerSubmissions->where('assignment_id', $assignment->id)->first();

                                    // Determine learner-specific status
                                    if ($assignment->status === 'locked') {
                                        $learnerStatus = 'locked';
                                        $statusColor = 'gray';
                                        $statusText = 'Locked';
                                    } elseif ($submission) {
                                        switch ($submission->status) {
                                            case 'graded':
                                                $learnerStatus = 'graded';
                                                $statusColor = 'green';
                                                $statusText = 'Graded (' . $submission->grade . '/' . $assignment->points . ')';
                                                break;
                                            case 'submitted':
                                                $learnerStatus = 'submitted';
                                                $statusColor = 'blue';
                                                $statusText = 'Submitted';
                                                break;
                                            case 'draft':
                                                $learnerStatus = 'draft';
                                                $statusColor = 'yellow';
                                                $statusText = 'In Progress';
                                                break;
                                            default:
                                                $learnerStatus = 'not_started';
                                                $statusColor = 'gray';
                                                $statusText = 'Not Started';
                                        }
                                    } else {
                                        $learnerStatus = 'not_started';
                                        $statusColor = 'gray';
                                        $statusText = 'Not Started';
                                    }

                                    $isClickable = $assignment->status === 'active';
                                    $isOverdue = $assignment->due_date < now() && !in_array($learnerStatus, ['submitted', 'graded']);
                                @endphp

                                @if($isClickable)
                                    <a href="{{ route('assignment.view', $assignment) }}" class="block border border-gray-200 rounded-lg p-4 hover:bg-gray-50 hover:border-gray-300 transition-all cursor-pointer">
                                @else
                                    <div class="border border-gray-200 rounded-lg p-4 opacity-60 cursor-not-allowed bg-gray-50">
                                @endif
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <h4 class="font-semibold text-gray-900">{{ $assignment->title }}</h4>
                                                @if($assignment->status === 'locked')
                                                    <svg class="w-4 h-4 ml-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <p class="text-gray-600 text-sm mt-1">{{ $assignment->description }}</p>
                                            <div class="flex items-center mt-2 text-xs text-gray-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                @if($isOverdue)
                                                    <span class="text-red-500 font-medium">Overdue: {{ $assignment->due_date->format('M j, Y \a\t g:i A') }}</span>
                                                @else
                                                    Due: {{ $assignment->due_date->format('M j, Y \a\t g:i A') }}
                                                @endif
                                                <span class="ml-2">• {{ $assignment->points }} points</span>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                                                {{ $statusText }}
                                            </span>
                                            @if($isClickable)
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                @if($isClickable)
                                    </a>
                                @else
                                    </div>
                                @endif
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-gray-500 text-sm">No assignments have been posted yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Course Stats -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Statistics</h3>
                                                <div class="space-y-4">
                            @php
                                // Get all assignments for this course
                                $allAssignments = $course->assignments;
                                $totalAssignments = $allAssignments->count();

                                // Get learner's submissions for this course
                                $statsLearnerSubmissions = $learner ? $learner->submissions()
                                    ->whereIn('assignment_id', $allAssignments->pluck('id'))
                                    ->get() : collect();

                                // Calculate learner's progress
                                $submittedAssignments = $statsLearnerSubmissions->where('status', 'submitted')->count();
                                $gradedAssignments = $statsLearnerSubmissions->where('status', 'graded')->count();
                                $draftAssignments = $statsLearnerSubmissions->where('status', 'draft')->count();
                                $completedAssignments = $submittedAssignments + $gradedAssignments;

                                // Calculate completion percentage based on submitted/graded assignments
                                $completionPercentage = $totalAssignments > 0 ? round(($completedAssignments / $totalAssignments) * 100) : 0;

                                // Find next deadline (earliest active assignment that's not submitted)
                                $submittedAssignmentIds = $statsLearnerSubmissions->whereIn('status', ['submitted', 'graded'])->pluck('assignment_id');
                                $nextDeadline = $allAssignments
                                    ->where('status', 'active')
                                    ->whereNotIn('id', $submittedAssignmentIds)
                                    ->where('due_date', '>', now())
                                    ->sortBy('due_date')
                                    ->first();
                            @endphp

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Completion</span>
                                <span class="font-semibold text-gray-900">{{ $completionPercentage }}%</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Assignments</span>
                                <span class="font-semibold text-gray-900">{{ $completedAssignments }}/{{ $totalAssignments }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Submitted</span>
                                <span class="font-semibold text-green-600">{{ $submittedAssignments + $gradedAssignments }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">In Progress</span>
                                <span class="font-semibold text-blue-600">{{ $draftAssignments }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Graded</span>
                                <span class="font-semibold text-purple-600">{{ $gradedAssignments }}</span>
                            </div>
                            @if($nextDeadline)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Next Deadline</span>
                                    @php
                                        $now = now();
                                        $dueDate = $nextDeadline->due_date;
                                        $isOverdue = $dueDate < $now;

                                        if ($isOverdue) {
                                            $diff = $now->diff($dueDate);
                                            $daysOverdue = $diff->days;
                                            $hoursOverdue = $diff->h;
                                        } else {
                                            $diff = $dueDate->diff($now);
                                            $daysUntilDue = $diff->days;
                                            $hoursUntilDue = $diff->h;
                                        }
                                    @endphp
                                    <span class="font-semibold {{ $isOverdue ? 'text-red-600' : ($daysUntilDue <= 3 ? 'text-orange-600' : 'text-green-600') }}">
                                        @if($isOverdue)
                                            @if($daysOverdue > 0)
                                                {{ $daysOverdue }}d {{ $hoursOverdue }}h overdue
                                            @else
                                                {{ $hoursOverdue }}h overdue
                                            @endif
                                        @elseif($daysUntilDue == 0)
                                            @if($hoursUntilDue > 0)
                                                {{ $hoursUntilDue }}h
                                            @else
                                                < 1h
                                            @endif
                                        @elseif($daysUntilDue == 1)
                                            1d {{ $hoursUntilDue }}h
                                        @else
                                            {{ $daysUntilDue }}d {{ $hoursUntilDue }}h
                                        @endif
                                    </span>
                                </div>
                            @else
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Next Deadline</span>
                                    <span class="font-semibold text-gray-500">None</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Announcements -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Announcements</h3>
                        <div class="space-y-3 text-sm">
                            @forelse($course->announcements()->orderBy('created_at', 'desc')->limit(3)->get() as $announcement)
                                <div class="flex items-start">
                                    <div class="w-2 h-2 bg-{{ $announcement->type_color }}-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                    <div class="flex-1">
                                        <p class="text-gray-700 font-medium">{{ Str::limit($announcement->title, 30) }}</p>
                                        <p class="text-gray-500 text-xs">{{ $announcement->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-2">
                                    <p class="text-gray-500 text-xs">No announcements yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Course Progress -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Progress Overview</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Course Progress</span>
                                    <span>{{ $completionPercentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="gradient-bg h-2 rounded-full transition-all duration-300" style="width: {{ $completionPercentage }}%"></div>
                                </div>
                            </div>

                            @if($totalAssignments > 0)
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div class="bg-green-50 rounded-lg p-3">
                                        <div class="text-2xl font-bold text-green-600">{{ $completedAssignments }}</div>
                                        <div class="text-xs text-green-700">Submitted</div>
                                    </div>
                                    <div class="bg-blue-50 rounded-lg p-3">
                                        <div class="text-2xl font-bold text-blue-600">{{ $totalAssignments - $completedAssignments }}</div>
                                        <div class="text-xs text-blue-700">Remaining</div>
                                    </div>
                                </div>
                                @if($draftAssignments > 0)
                                    <div class="mt-2 text-center">
                                        <div class="bg-yellow-50 rounded-lg p-2">
                                            <div class="text-lg font-bold text-yellow-600">{{ $draftAssignments }}</div>
                                            <div class="text-xs text-yellow-700">In Progress (Draft)</div>
                                        </div>
                                    </div>
                                @endif
                            @endif
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
</x-app-layout>
