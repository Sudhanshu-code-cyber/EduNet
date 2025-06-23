<!-- homework-modal.blade.php -->
<div id="homework-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full inset-0 max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add New Homework</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="homework-modal">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="#" method="POST" enctype="multipart/form-data" class="p-4 md:p-6 space-y-5">
                @csrf
                <div>
                    <label class="block font-medium mb-1 text-gray-800 dark:text-white">Homework Title</label>
                    <input type="text" name="title" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" placeholder="Enter title">
                </div>
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="w-full">
                        <label class="block font-medium mb-1 text-gray-800 dark:text-white">Class</label>
                        <select name="class" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                            <option value="">Select Class</option>
                            <option value="Class 1">Class 1</option>
                            <option value="Class 2">Class 2</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="block font-medium mb-1 text-gray-800 dark:text-white">Section</label>
                        <select name="section" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                            <option value="">Select Section</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="block font-medium mb-1 text-gray-800 dark:text-white">Subject</label>
                        <input type="text" name="subject" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" placeholder="e.g., Math, Science">
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="w-full">
                        <label class="block font-medium mb-1 text-gray-800 dark:text-white">Homework Date</label>
                        <input type="date" name="homework_date" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    </div>
                    <div class="w-full">
                        <label class="block font-medium mb-1 text-gray-800 dark:text-white">Submission Date</label>
                        <input type="date" name="submission_date" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block font-medium mb-1 text-gray-800 dark:text-white">Attach Document</label>
                    <input type="file" name="document" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block font-medium mb-1 text-gray-800 dark:text-white">Homework Content</label>
                    <textarea name="content" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" placeholder="Write homework details here..."></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 text-sm rounded hover:bg-blue-700">
                        Submit Homework
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
