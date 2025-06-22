<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
   <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
   <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md text-sm font-sans border border-gray-300">
    <!-- Header -->
    <div class="flex justify-between items-center border-b pb-4">
        <img src="/school-logo.png" alt="School Logo" class="w-20 h-20 object-cover rounded">
        <div class="text-center">
            <h1 class="text-xl font-bold uppercase text-gray-800">School Model</h1>
            <h2 class="text-lg font-semibold text-gray-700 uppercase">International School</h2>
        </div>
        <img src="/student-photo.jpg" alt="Student Photo" class="w-20 h-20 object-cover rounded-full">
    </div>

    <!-- Student Info -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4 text-gray-700">
        <p><span class="font-semibold">Name Of Student:</span> Student 1</p>
        <p><span class="font-semibold">Admission No:</span> 194</p>
        <p><span class="font-semibold">Gender:</span> Male</p>
        <p><span class="font-semibold">Class:</span> PART TIME</p>
        <p><span class="font-semibold">Term:</span> FIRST TERM 2022/2023</p>
    </div>

    <!-- Marksheet Table -->
    <div class="mt-6 overflow-x-auto">
        <table class="w-full border border-collapse text-center text-gray-800">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Subject</th>
                    <th class="border p-2">Class Work</th>
                    <th class="border p-2">Test Work</th>
                    <th class="border p-2">Home Work</th>
                    <th class="border p-2">Exam</th>
                    <th class="border p-2">Total Score</th>
                    <th class="border p-2">Passing Marks</th>
                    <th class="border p-2">Full Marks</th>
                    <th class="border p-2">Result</th>
                </tr>
            </thead>
            <tbody>
                <!-- Repeat this row as needed -->
                <tr>
                    <td class="border p-2 text-left">Home Economics</td>
                    <td class="border p-2">20</td>
                    <td class="border p-2">10</td>
                    <td class="border p-2">20</td>
                    <td class="border p-2">12</td>
                    <td class="border p-2">62</td>
                    <td class="border p-2">60</td>
                    <td class="border p-2">100</td>
                    <td class="border p-2 text-green-600 font-semibold">Pass</td>
                </tr>
                <!-- Add more rows here... -->
                <tr>
                    <td class="border p-2 text-left">Mathematics</td>
                    <td class="border p-2">30</td>
                    <td class="border p-2">15</td>
                    <td class="border p-2">20</td>
                    <td class="border p-2">20</td>
                    <td class="border p-2">85</td>
                    <td class="border p-2">60</td>
                    <td class="border p-2">100</td>
                    <td class="border p-2 text-green-600 font-semibold">Pass</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Summary -->
    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-700">
        <p><span class="font-semibold">Grand Total:</span> 441/600</p>
        <p><span class="font-semibold">Percentage:</span> 73.5%</p>
        <p><span class="font-semibold">Grade:</span> C</p>
        <p class="md:col-span-3"><span class="font-semibold">Result:</span> <span class="text-green-600 font-bold">Pass</span></p>
    </div>

    <!-- Remarks -->
    <div class="mt-6 text-sm text-gray-600 border-t pt-4">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining unchanged.</p>
    </div>

    <!-- Signature -->
    <div class="mt-8 flex justify-end">
        <div class="text-right">
            <p class="border-t border-gray-500 w-48 text-center pt-2 text-gray-700">Signature</p>
        </div>
    </div>
</div>
 
</body>
</html>