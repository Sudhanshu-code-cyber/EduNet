
<div class="flex justify-end items-center gap-4 mb-3">
    <!-- Filter Button -->
    <button data-modal-target="filter-modal" data-modal-toggle="filter-modal"
        class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-2 shadow-md hover:shadow-lg text-sm flex items-center gap-2">
        <i class="fa-solid fa-filter"></i> Filter
    </button>

<!-- Filter Modal -->
<div id="filter-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed top-0 left-0 right-0 z-50 justify-center items-center w-full inset-0 h-screen bg-black bg-opacity-50 overflow-y-auto">
    <div class="relative p-4 w-full max-w-md">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Filter Exam Schedule</h3>
                <button type="button" class="text-gray-400 hover:text-gray-900 rounded-lg w-8 h-8 flex items-center justify-center" data-modal-toggle="filter-modal">
                    ✕
                </button>
            </div>
            <form action="#" method="GET" class="p-4 space-y-4">
                <div>
                    <label class="block mb-1">Class</label>
                    <select class="w-full border rounded px-3 py-2">
                        <option>Select Class</option>
                        <option>I</option>
                        <option>II</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1">Section</label>
                    <select class="w-full border rounded px-3 py-2">
                        <option>Select Section</option>
                        <option>A</option>
                        <option>B</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1">Date</label>
                    <input type="date" class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex justify-between">
                    <button type="reset" class="bg-gray-200 px-4 py-2 rounded">Reset</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>
