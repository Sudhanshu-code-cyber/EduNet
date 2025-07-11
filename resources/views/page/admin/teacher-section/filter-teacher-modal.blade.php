<!-- Filter Modal -->
<div id="filter-teacher-modal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full p-4">
    <div class="relative w-full max-w-md mx-auto mt-20">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-50">
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">Filter Teachers</h3>
                <button type="button"
                    class="text-gray-400 hover:text-gray-900 hover:bg-gray-100 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="filter-teacher-modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('teacher.search') }}" method="GET" class="p-6 space-y-4">
                {{-- Qualification --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Qualification</label>
                    <select name="qualification" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Select Qualification --</option>
                        <option value="B.Ed" {{ request('qualification') == 'B.Ed' ? 'selected' : '' }}>B.Ed</option>
                        <option value="M.Ed" {{ request('qualification') == 'M.Ed' ? 'selected' : '' }}>M.Ed</option>
                        <option value="B.Sc" {{ request('qualification') == 'B.Sc' ? 'selected' : '' }}>B.Sc</option>
                        <option value="M.Sc" {{ request('qualification') == 'M.Sc' ? 'selected' : '' }}>M.Sc</option>
                        <option value="B.A" {{ request('qualification') == 'B.A' ? 'selected' : '' }}>B.A</option>
                        <option value="M.A" {{ request('qualification') == 'M.A' ? 'selected' : '' }}>M.A</option>
                        <option value="Ph.D" {{ request('qualification') == 'Ph.D' ? 'selected' : '' }}>Ph.D</option>
                        <option value="Other" {{ request('qualification') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                {{-- Gender --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Gender</label>
                    <select name="gender" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('teacher.index') }}"
                        class="text-sm text-gray-500 underline hover:text-red-600">Reset Filters</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
