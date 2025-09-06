@props(['course'])

<div id="promotionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    Promote Students - {{ $course->title }}
                </h3>
                <button onclick="closePromotionModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Warning Icon and Message -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>This action cannot be undone!</strong> Please read the consequences carefully before proceeding.
                        </p>
                    </div>
                </div>
            </div>

            <!-- What will happen section -->
            <div class="mb-6">
                <h4 class="text-md font-semibold text-gray-900 mb-3">What will happen when you promote students:</h4>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>All currently enrolled students will be marked as <strong>completed</strong></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Final grades will be calculated and revealed (average percentage of all assignment scores)</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span><strong>All announcements will be deleted</strong></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span><strong>All assignments and activities will be deleted</strong></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span><strong>All student submissions will be deleted</strong></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Course will be reset and ready for new student enrollments</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-orange-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span>Completed students cannot re-enroll in this course</span>
                    </li>
                </ul>
            </div>

            <!-- Current course stats -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h4 class="text-md font-semibold text-gray-900 mb-3">Current Course Statistics:</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Enrolled Students:</span>
                        <span class="font-semibold text-gray-900 ml-2" id="enrolledCount">{{ $course->learners->count() }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Total Assignments:</span>
                        <span class="font-semibold text-gray-900 ml-2" id="assignmentCount">{{ $course->assignments->count() }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Total Announcements:</span>
                        <span class="font-semibold text-gray-900 ml-2" id="announcementCount">{{ $course->announcements->count() }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Total Submissions:</span>
                        <span class="font-semibold text-gray-900 ml-2" id="submissionCount">{{ $course->assignments->sum(function($assignment) { return $assignment->submissions->count(); }) }}</span>
                    </div>
                </div>
            </div>

            <!-- Confirmation checkbox -->
            <div class="mb-6">
                <label class="flex items-start">
                    <input type="checkbox" id="promotionConfirmation" class="mt-1 mr-3 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">
                        I understand that this action will permanently delete all course content and cannot be undone.
                        I confirm that I want to promote all students and reset this course.
                    </span>
                </label>
            </div>

            <!-- Action buttons -->
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closePromotionModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                    Cancel
                </button>
                <button type="button" id="promoteButton" onclick="confirmPromotion()"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                        disabled>
                    Promote Students & Reset Course
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openPromotionModal() {
        const modal = document.getElementById('promotionModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // Reset checkbox
        document.getElementById('promotionConfirmation').checked = false;
        document.getElementById('promoteButton').disabled = true;
    }

    function closePromotionModal() {
        const modal = document.getElementById('promotionModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function confirmPromotion() {
        const checkbox = document.getElementById('promotionConfirmation');
        if (!checkbox.checked) {
            alert('Please confirm that you understand the consequences before proceeding.');
            return;
        }

        // Show loading state
        const button = document.getElementById('promoteButton');
        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = 'Promoting Students...';

        // Submit the form
        document.getElementById('promotionForm').submit();
    }

    // Enable/disable promote button based on checkbox
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('promotionConfirmation');
        const button = document.getElementById('promoteButton');

        if (checkbox && button) {
            checkbox.addEventListener('change', function() {
                button.disabled = !this.checked;
            });
        }
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('promotionModal');
        if (event.target === modal) {
            closePromotionModal();
        }
    });
</script>

<!-- Hidden form for promotion -->
<form id="promotionForm" action="{{ route('instructor.course.promote', $course) }}" method="POST" style="display: none;">
    @csrf
    @method('POST')
</form>
