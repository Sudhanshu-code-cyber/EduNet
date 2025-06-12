@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-blue-800">Marks Entry</h1>

        <form method="GET" action="" class="bg-white shadow-md rounded-lg p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Select Exam -->
                <div>
                    <label for="exam_id" class="block text-gray-700 font-medium mb-1">Select Exam</label>
                    <select name="exam_id" id="exam_id" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Choose Exam --</option>
                        <option value="1">Mid Term</option>
                        <option value="2">Final Term</option>
                        <!-- Add more exams dynamically -->
                    </select>
                </div>

                <!-- Select Class -->
                <div>
                    <label for="class_id" class="block text-gray-700 font-medium mb-1">Select Class</label>
                    <select name="class_id" id="class_id" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Choose Class --</option>
                        <option value="7A">Class 7 - A</option>
                        <option value="8B">Class 8 - B</option>
                        <!-- Add more classes dynamically -->
                    </select>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4 mt-4">
                <button type="submit"
                    class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Search
                </button>

                <button type="reset"
                    class="bg-gray-300 text-gray-700 font-semibold px-6 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
