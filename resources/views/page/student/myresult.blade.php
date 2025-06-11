@extends('page.student.parent')

@section('content')
    <div class="max-w-6xl mx-auto p-4 space-y-6">
    <!-- Header -->
    <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-indigo-600">
        <h2 class="text-2xl font-semibold text-indigo-700">📊 My School Exam Result</h2>
    </div>

    <!-- Term & Print -->
  <div class="bg-white p-4 rounded shadow flex flex-col sm:flex-row justify-between items-center gap-4">
    
    <!-- Logo and Term Info -->
    <div class="flex items-center gap-4">
        <p class="text-lg font-medium text-gray-700">🗓️ First Term 2025/2026</p>
    </div>

    <!-- Buttons -->
    <div class="flex gap-2">
        <button onclick="printAnotherPage()"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow transition-all duration-200">
            🖨️ Print
        </button>
        
    </div>
</div>




    <!-- Table -->
    <div class="overflow-x-auto rounded shadow-lg bg-white">
        <table class="min-w-full text-sm text-center">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="px-4 py-2">Subject</th>
                    <th>Class Work</th>
                    <th>Assignment</th>
                    <th>Test</th>
                    <th>Homework</th>
                    <th>Exam</th>
                    <th>Total</th>
                    <th>Pass Mark</th>
                    <th>Full Mark</th>
                    <th>Result</th>
                </tr>
            </thead>
           <tbody class="text-gray-700 divide-y divide-gray-200 text-center">
    <!-- Example row -->
    <tr class="hover:bg-gray-50">
        <td class="px-4 py-2 font-semibold text-left">Home Science</td>
        <td class="py-2">10</td>
        <td class="py-2">8</td>
        <td class="py-2">8</td>
        <td class="py-2">10</td>
        <td class="py-2">48</td>
        <td class="py-2 font-medium">58</td>
        <td class="py-2 text-yellow-600">60</td>
        <td class="py-2 text-gray-500">100</td>
        <td class="py-2 text-green-600 font-bold">Pass</td>
    </tr>

    <tr class="hover:bg-gray-50">
        <td class="px-4 py-2 font-semibold text-left">Mathematics</td>
        <td class="py-2">9</td>
        <td class="py-2">7</td>
        <td class="py-2">9</td>
        <td class="py-2">10</td>
        <td class="py-2">44</td>
        <td class="py-2 font-medium">54</td>
        <td class="py-2 text-yellow-600">60</td>
        <td class="py-2 text-gray-500">100</td>
        <td class="py-2 text-green-600 font-bold">Pass</td>
    </tr>

    <!-- Add more rows as needed -->

    <!-- Final Summary Row -->
    <tr class="bg-gray-100 font-semibold text-base text-left">
        <td colspan="6" class="px-4 py-3">📊 Overall Percentage: <span class="text-blue-700">74.4%</span></td>
        <td colspan="4" class="py-3 text-right pr-4 text-green-700">🎉 Final Result: <span class="font-bold">Pass</span></td>
    </tr>
</tbody>

        </table>
    </div>

    <!-- Script -->
    <script>
        function printAnotherPage() {
            const printWindow = window.open("{{ route('student.marksheet') }}", '_blank');
            printWindow.onload = function () {
                printWindow.print();
            };
        }
    </script>
</div>

@endsection
