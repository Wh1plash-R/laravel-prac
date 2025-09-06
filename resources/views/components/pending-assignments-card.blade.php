@props(['learnerCourses' => null, 'learner' => null])

<div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
    <div class="flex items-center justify-between mb-4">
        <h4 class="text-lg font-bold text-gray-900">Pending Assignments</h4>
        <span class="text-xs text-gray-500">{{ $learnerCourses ? $learnerCourses->count() : 0 }} courses</span>
    </div>

    <div class="space-y-3">
        @if($learnerCourses && $learnerCourses->count() > 0)
            @php
                // Get all pending assignments from all enrolled courses
                $allPendingAssignments = collect();

                // Get all submitted assignment IDs for this learner (more efficient)
                $submittedAssignmentIds = collect();
                if ($learner) {
                    $submittedAssignmentIds = \App\Models\Submission::where('learner_id', $learner->id)
                        ->whereIn('status', ['submitted', 'graded'])
                        ->pluck('assignment_id');
                }

                foreach($learnerCourses as $course) {
                    $course->load('assignments');
                    $pendingAssignments = $course->assignments()
                        ->where('status', 'active')
                        ->orderBy('due_date', 'asc')
                        ->get();

                    foreach($pendingAssignments as $assignment) {
                        // Check if learner has already submitted this assignment
                        $hasSubmitted = $submittedAssignmentIds->contains($assignment->id);

                        // Only include if not submitted
                        if (!$hasSubmitted) {
                            $allPendingAssignments->push([
                                'course' => $course,
                                'assignment' => $assignment,
                                'daysUntilDue' => now()->diffInDays($assignment->due_date, false),
                                'isOverdue' => $assignment->due_date < now(),
                            ]);
                        }
                    }
                }

                // Sort by due date (earliest first) and limit to 5
                $allPendingAssignments = $allPendingAssignments
                    ->sortBy('assignment.due_date')
                    ->take(5);
            @endphp

            @forelse($allPendingAssignments as $item)
                @php
                    $course = $item['course'];
                    $assignment = $item['assignment'];
                    $daysUntilDue = $item['daysUntilDue'];
                    $isOverdue = $item['isOverdue'];

                    // Calculate urgency color
                    $urgencyColor = $isOverdue ? 'red' : ($daysUntilDue <= 3 ? 'orange' : 'green');
                    $urgencyText = $isOverdue ? 'Overdue' : ($daysUntilDue == 0 ? 'Today' : ($daysUntilDue == 1 ? 'Tomorrow' : $daysUntilDue . ' days'));
                @endphp

                <div class="p-4 rounded-lg border border-gray-200 bg-white flex items-start justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex-1 min-w-0 pr-3">
                        <div class="flex items-start gap-2 mb-1">
                            <p class="font-semibold text-gray-800 text-sm leading-tight break-words" title="{{ $assignment->title }}">
                                {{ Str::limit($assignment->title, 40) }}
                            </p>
                        </div>
                        <p class="text-xs text-gray-500 break-words" title="{{ $course->title }}">{{ Str::limit($course->title, 30) }} • {{ $assignment->points }} points</p>
                        <p class="text-xs text-gray-400">Due: {{ $assignment->due_date->format('M j, Y \a\t g:i A') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('course.view', $course->id) }}"
                            class="p-2 rounded-lg hover:bg-gray-100 text-gray-700 border border-gray-200 transition-colors">
                            &rsaquo;
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-6">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 font-medium">All caught up!</p>
                    <p class="text-gray-500 text-xs mt-1">No pending assignments</p>
                </div>
            @endforelse

            @if($allPendingAssignments->count() >= 5)
                <div class="text-center py-2">
                    <p class="text-gray-500 text-xs">Showing 5 of {{ $allPendingAssignments->count() }} pending assignments</p>
                </div>
            @endif
        @else
            <div class="text-center py-6">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <p class="text-gray-600 font-medium">No courses enrolled</p>
                <p class="text-gray-500 text-xs mt-1">Enroll in courses to see assignments</p>
            </div>
        @endif
    </div>
</div>
