<!-- Edit Notice Modal -->
<div id="editNoticeModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeEditModal()"></div>

    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg p-6 z-10 w-11/12 sm:w-1/2 relative max-h-screen overflow-y-auto">
        <h2 class="text-2xl font-semibold mb-4 text-blue-700">Edit Notice</h2>

        <form id="editNoticeForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" id="edit_id">

            <div class="flex flex-col sm:flex-row gap-4">
                <div class="w-full sm:w-1/2">
                    <label for="edit_title" class="block text-gray-700 font-medium mb-1">Title</label>
                    <input type="text" name="title" id="edit_title" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="w-full sm:w-1/2">
                    <label for="edit_posted_by" class="block text-gray-700 font-medium mb-1">Posted By</label>
                    <input type="text" name="posted_by" id="edit_posted_by" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 mt-4">
                <div class="w-full sm:w-2/3">
                    <label for="edit_details" class="block text-gray-700 font-medium mb-1">Details</label>
                    <textarea name="details" id="edit_details" rows="3" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="w-full sm:w-1/3">
                    <label for="edit_date" class="block text-gray-700 font-medium mb-1">Date</label>
                    <input type="date" name="date" id="edit_date" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex gap-4 mt-6">
                <button type="submit"
                    class="bg-blue-600 text-white font-semibold px-5 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update
                </button>
                <button type="button" onclick="closeEditModal()"
                    class="ml-auto text-red-600 hover:underline font-semibold">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>




<script>
    function openEditModal(id, title, posted_by, details, date) {
        // Fill form inputs
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_posted_by').value = posted_by;
        document.getElementById('edit_details').value = details;
        document.getElementById('edit_date').value = date;

        // Set dynamic form action
        const form = document.getElementById('editNoticeForm');
        form.action = `/admin/notice/${id}`; // or `/teacher/notice/${id}` if used for teachers

        // Show modal
        document.getElementById('editNoticeModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editNoticeModal').classList.add('hidden');
    }
</script>
