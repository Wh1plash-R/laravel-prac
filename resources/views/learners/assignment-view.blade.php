<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $assignment->title }}
            </h2>
            <a href="{{ route('course.view', $assignment->course) }}"
               class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                ← Back to Course
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
        <div class="gradient-bg text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('course.view', $assignment->course) }}"
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
                            <span class="text-white/80 text-sm font-medium">ASSIGNMENT</span>
                        </div>
                        <h1 class="text-4xl font-bold mb-4">{{ $assignment->title }}</h1>
                        <p class="text-white/90 text-lg mb-6">{{ $assignment->description }}</p>

                        <div class="flex items-center space-x-6 text-white/80">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-[#fcd34d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @if($assignment->due_date->isFuture())
                                    <span>Due: {{ $assignment->due_date->format('M j, Y \a\t g:i A') }}</span>
                                @else
                                    <span class="text-red-300">Due: {{ $assignment->due_date->format('M j, Y \a\t g:i A') }} (Past due)</span>
                                @endif
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-[#fcd34d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                <span>{{ $assignment->points }} points</span>
                            </div>
                        </div>
                    </div>

                    <!-- Assignment Status -->
                    <div class="ml-8 flex flex-col space-y-3">
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 min-w-[220px]">
                            <div class="text-center">
                                @if($submission)
                                    <div class="text-2xl font-bold text-white mb-1">
                                        @if($submission->isGraded())
                                            {{ $submission->grade }}/{{ $assignment->points }}
                                        @elseif($submission->isSubmitted())
                                            Submitted
                                        @else
                                            Draft
                                        @endif
                                    </div>
                                    <div class="text-white/80 text-sm">
                                        @if($submission->isGraded())
                                            Grade Received
                                        @elseif($submission->isSubmitted())
                                            Awaiting Grade
                                        @else
                                            Work in Progress
                                        @endif
                                    </div>
                                @else
                                    <div class="text-2xl font-bold text-white mb-1">Not Started</div>
                                    <div class="text-white/80 text-sm">Upload your work</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignment Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Assignment Details -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Assignment Details</h2>
                        </div>
                        <div class="prose prose-gray max-w-none">
                            <p class="text-gray-700 leading-relaxed">{{ $assignment->description }}</p>

                            <div class="mt-6 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                                <h4 class="font-semibold text-blue-900 mb-2">Submission Requirements:</h4>
                                <ul class="text-blue-800 text-sm space-y-1">
                                    <li>• Upload your work in PDF, DOC, DOCX, TXT, or ZIP format</li>
                                    <li>• Maximum file size: 10MB</li>
                                    <li>• Once submitted, you cannot edit your submission</li>
                                    <li>• Late submissions may receive reduced points</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Submission Section -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Your Submission</h2>
                            </div>
                            @if($submission)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $submission->status_color }}-100 text-{{ $submission->status_color }}-800">
                                    {{ $submission->status_text }}
                                </span>
                            @endif
                        </div>

                        @if($submission && $submission->isSubmitted())
                            <!-- Submitted Work Display -->
                            <div class="space-y-4">
                                @if($submission->file_path)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-8 h-8 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $submission->file_name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $submission->file_size_formatted }}</p>
                                                </div>
                                            </div>
                                                                                        <a href="{{ route('assignment.download', $assignment) }}" target="_blank"
                                               class="text-blue-600 hover:text-blue-800 font-medium">
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                @if($submission->comments)
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Your Comments:</h4>
                                        <p class="text-gray-700 bg-gray-50 rounded-lg p-3">{{ $submission->comments }}</p>
                                    </div>
                                @endif

                                <div class="text-sm text-gray-500">
                                    Submitted on {{ $submission->submitted_at->format('M j, Y \a\t g:i A') }}
                                </div>

                                @if($submission->isGraded())
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-green-900 mb-2">Grade: {{ $submission->grade }}/{{ $assignment->points }}</h4>
                                        @if($submission->feedback)
                                            <h5 class="font-medium text-green-800 mb-1">Instructor Feedback:</h5>
                                            <p class="text-green-700">{{ $submission->feedback }}</p>
                                        @endif
                                        <p class="text-sm text-green-600 mt-2">
                                            Graded on {{ $submission->graded_at->format('M j, Y \a\t g:i A') }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                                                @else
                            <!-- Submission Form -->
                            <form action="{{ route('assignment.submit', $assignment) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf

                                <!-- File Upload -->
                                <div>
                                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                                        Upload Your Work
                                    </label>
                                    <div id="file-upload-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Upload a file</span>
                                                    <input id="file" name="file" type="file" class="sr-only" accept=".pdf,.doc,.docx,.txt,.zip">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, DOC, DOCX, TXT, ZIP up to 10MB</p>
                                        </div>
                                    </div>

                                    <!-- Current File Display -->
                                    @if($submission && $submission->file_path)
                                        <div id="current-file" class="mt-2 p-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center flex-1">
                                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <div class="flex-1">
                                                        <a href="{{ route('assignment.download', $assignment) }}" target="_blank"
                                                           class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                            {{ $submission->file_name }}
                                                        </a>
                                                        <p class="text-xs text-gray-500">{{ $submission->file_size_formatted }} • Click to download</p>
                                                    </div>
                                                </div>
                                                <button type="button" onclick="removeFile()" class="text-red-600 hover:text-red-800 text-sm font-medium ml-3">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Selected File Preview (for newly selected files) -->
                                    <div id="selected-file" class="mt-2 p-3 bg-blue-50 rounded-lg hidden">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <div class="flex-1">
                                                    <p id="selected-file-name" class="text-sm text-gray-900 font-medium"></p>
                                                    <p id="selected-file-size" class="text-xs text-gray-500"></p>
                                                </div>
                                            </div>
                                            <button type="button" onclick="clearFileSelection()" class="text-red-600 hover:text-red-800 text-sm font-medium ml-3">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                                                <!-- Comments -->
                                <div>
                                    <label for="comments" class="block text-sm font-medium text-gray-700 mb-2">
                                        Comments (Optional)
                                    </label>
                                    <textarea name="comments" id="comments" rows="4"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                              placeholder="Add any comments about your submission...">{{ $submission->comments ?? '' }}</textarea>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-between items-center pt-4">
                                    <button type="submit"
                                            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                                        Save Draft
                                    </button>

                                    <button type="button" id="submit-assignment-btn"
                                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors"
                                            onclick="submitAssignment()">
                                        Submit Assignment
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Assignment Info -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Assignment Info</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Course</span>
                                <span class="font-semibold text-gray-900">{{ $assignment->course->title }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Points</span>
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
                            @php
                                $now = now();
                                $dueDate = $assignment->due_date;
                                $isOverdue = $dueDate < $now;

                                if ($isOverdue) {
                                    $diff = $now->diff($dueDate);
                                    $timeText = $diff->days > 0 ? $diff->days . 'd ' . $diff->h . 'h overdue' : $diff->h . 'h overdue';
                                    $timeColor = 'text-red-600';
                                } else {
                                    $diff = $dueDate->diff($now);
                                    if ($diff->days == 0) {
                                        $timeText = $diff->h > 0 ? $diff->h . 'h remaining' : '< 1h remaining';
                                        $timeColor = 'text-orange-600';
                                    } elseif ($diff->days <= 3) {
                                        $timeText = $diff->days . 'd ' . $diff->h . 'h remaining';
                                        $timeColor = 'text-orange-600';
                                    } else {
                                        $timeText = $diff->days . 'd ' . $diff->h . 'h remaining';
                                        $timeColor = 'text-green-600';
                                    }
                                }
                            @endphp
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Time</span>
                                <span class="font-semibold {{ $timeColor }}">{{ $timeText }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submission Status -->
                    @if($submission)
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Submission Status</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                @if($submission->file_path)
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-green-700">File uploaded</span>
                                @else
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-gray-500">No file uploaded</span>
                                @endif
                            </div>
                            <div class="flex items-center">
                                @if($submission->isSubmitted())
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-green-700">Submitted for grading</span>
                                @else
                                    <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-yellow-700">Draft - not submitted</span>
                                @endif
                            </div>
                            <div class="flex items-center">
                                @if($submission->isGraded())
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-green-700">Graded</span>
                                @else
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-500">Awaiting grade</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Help & Tips -->
                    <div class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tips for Success</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <p class="text-gray-700">Save your work frequently as a draft</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <p class="text-gray-700">Submit before the deadline to avoid penalties</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <p class="text-gray-700">Use clear file names for your submissions</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <p class="text-gray-700">Double-check your work before submitting</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden forms for actions -->
    <form id="remove-file-form" action="{{ route('assignment.remove', $assignment) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <form id="finalize-assignment-form" action="{{ route('assignment.finalize', $assignment) }}" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    <!-- Confirmation Dialogs -->
    <x-confirm-dialog
        title="Remove File"
        message="Are you sure you want to remove this file? This action cannot be undone."
        confirmText="Remove File"
        cancelText="Cancel"
        loadingMessage="Removing file..."
        formId="remove-file-form"
        event="show-remove-file-dialog">
        <x-slot:trigger>
            <!-- Triggered by JavaScript -->
        </x-slot:trigger>
    </x-confirm-dialog>

    <x-confirm-dialog
        title="Submit Assignment"
        message="Are you sure you want to submit this assignment? Once submitted, you cannot make any changes."
        confirmText="Submit Assignment"
        cancelText="Cancel"
        loadingMessage="Submitting assignment..."
        formId="finalize-assignment-form"
        event="show-submit-assignment-dialog">
        <x-slot:trigger>
            <!-- Triggered by JavaScript -->
        </x-slot:trigger>
    </x-confirm-dialog>

    <script>
        // File handling functions
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showSelectedFile(file) {
            const selectedFileDiv = document.getElementById('selected-file');
            const fileNameSpan = document.getElementById('selected-file-name');
            const fileSizeSpan = document.getElementById('selected-file-size');
            const currentFileDiv = document.getElementById('current-file');

            fileNameSpan.textContent = file.name;
            fileSizeSpan.textContent = formatFileSize(file.size) + ' • Selected for upload';
            selectedFileDiv.classList.remove('hidden');

            // Hide current file if exists
            if (currentFileDiv) {
                currentFileDiv.style.opacity = '0.5';
            }

            // Enable submit button if file is selected
            updateSubmitButton(true);
        }

        function clearFileSelection() {
            const fileInput = document.getElementById('file');
            const selectedFileDiv = document.getElementById('selected-file');
            const currentFileDiv = document.getElementById('current-file');

            fileInput.value = '';
            selectedFileDiv.classList.add('hidden');

            // Show current file if exists
            if (currentFileDiv) {
                currentFileDiv.style.opacity = '1';
            }

            // Update submit button state
            const hasCurrentFile = {{ ($submission && $submission->file_path) ? 'true' : 'false' }};
            updateSubmitButton(hasCurrentFile);
        }

        function updateSubmitButton(hasFile) {
            const submitBtn = document.getElementById('submit-assignment-btn');
            if (submitBtn) {
                if (hasFile) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        function removeFile() {
            window.dispatchEvent(new CustomEvent('show-remove-file-dialog'));
        }

        function submitAssignment() {
            const submitBtn = document.getElementById('submit-assignment-btn');
            if (submitBtn && submitBtn.disabled) {
                return;
            }

            // Check if there's a file (either uploaded or selected)
            const hasCurrentFile = {{ ($submission && $submission->file_path) ? 'true' : 'false' }};
            const fileInput = document.getElementById('file');
            const hasSelectedFile = fileInput && fileInput.files.length > 0;

            if (!hasCurrentFile && !hasSelectedFile) {
                alert('Please upload a file before submitting the assignment.');
                return;
            }

            // If there's a newly selected file, save it first
            if (hasSelectedFile) {
                alert('Please save your draft first before submitting the assignment.');
                return;
            }

            window.dispatchEvent(new CustomEvent('show-submit-assignment-dialog'));
        }

        // File input change handler
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain', 'application/zip'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid file type (PDF, DOC, DOCX, TXT, ZIP)');
                    e.target.value = '';
                    return;
                }

                // Validate file size (10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('File size must be less than 10MB');
                    e.target.value = '';
                    return;
                }

                showSelectedFile(file);
            } else {
                clearFileSelection();
            }
        });

        // Drag and drop functionality
        const fileUploadArea = document.getElementById('file-upload-area');
        const fileInput = document.getElementById('file');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileUploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileUploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileUploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            fileUploadArea.classList.add('border-indigo-500', 'border-solid');
        }

        function unhighlight(e) {
            fileUploadArea.classList.remove('border-indigo-500', 'border-solid');
        }

        fileUploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                fileInput.files = files;
                const event = new Event('change', { bubbles: true });
                fileInput.dispatchEvent(event);
            }
        }

        // Initialize submit button state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const hasCurrentFile = {{ ($submission && $submission->file_path) ? 'true' : 'false' }};
            updateSubmitButton(hasCurrentFile);
        });
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
