<!-- Edit Homework Modal -->
<div id="edit-homework-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Edit Homework</h2>

        <form id="editHomeworkForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="homework_id" id="edit_homework_id">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Class -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Class</label>
                    <select name="class_id" id="edit_class_id"
                        class="w-full border border-gray-300 rounded px-3 py-2">
                        @foreach($assignedSubjects->unique('class_id') as $assignment)
                            <option value="{{ $assignment->class->id }}">{{ $assignment->class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Section -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Section</label>
                    <select name="section_id" id="edit_section_id"
                        class="w-full border border-gray-300 rounded px-3 py-2">
                        @foreach($assignedSubjects->unique('section_id') as $assignment)
                            <option value="{{ $assignment->section->id }}">{{ $assignment->section->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Subject -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Subject</label>
                    <select name="subject_id" id="edit_subject_id"
                        class="w-full border border-gray-300 rounded px-3 py-2">
                        @foreach($assignedSubjects->unique('subject_id') as $assignment)
                            <option value="{{ $assignment->subject->id }}">{{ $assignment->subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Title -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="edit_title"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>

                <!-- Content -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="edit_content" rows="4"
                        class="w-full border border-gray-300 rounded px-3 py-2" required></textarea>
                </div>

                <!-- Document -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Attachment</label>
                    <input type="file" name="document"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    <div id="current_document" class="text-sm text-gray-500 mt-1"></div>
                </div>

                <!-- Dates -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Homework Date</label>
                    <input type="date" name="homework_date" id="edit_homework_date"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Submission Date</label>
                    <input type="date" name="submission_date" id="edit_submission_date"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
            </div>

            <!-- Modal Buttons -->
            <div class="mt-6 flex justify-between">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update Homework
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(homework) {
    // Set dynamic action URL
    const form = document.getElementById('editHomeworkForm');
    form.action = `/teacher/homework/${homework.id}`;

    // Fill fields safely
    document.getElementById('edit_homework_id').value = homework.id ?? '';
    document.getElementById('edit_class_id').value = homework.class_id ?? '';
    document.getElementById('edit_section_id').value = homework.section_id ?? '';
    document.getElementById('edit_subject_id').value = homework.subject_id ?? '';
    document.getElementById('edit_title').value = homework.title ?? '';
    document.getElementById('edit_content').value = homework.content ?? '';

    document.getElementById('edit_homework_date').value = homework.homework_date?.slice(0,10) ?? '';
    document.getElementById('edit_submission_date').value = homework.submission_date?.slice(0,10) ?? '';

    if (homework.document) {
        document.getElementById('current_document').innerHTML =
            `Current: <a href="/storage/${homework.document}" target="_blank" class="text-blue-600 underline">View File</a>`;
    } else {
        document.getElementById('current_document').innerHTML = 'No attachment.';
    }

    document.getElementById('edit-homework-modal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('edit-homework-modal').classList.add('hidden');
}
</script>
