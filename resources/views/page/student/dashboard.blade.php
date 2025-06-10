@extends('page.student.parent')

@section('content')
<div class="py-10">
    <div class="w-full bg-white p-6 rounded-lg shadow-sm mb-6">
   <h1 class="text-2xl font-semibold text-gray-800">Welcome back, <span class="text-indigo-600">Student</span>! 🎓</h1>
   <p class="text-sm text-gray-500 mt-1">Hope you're having a great learning experience today.</p>
</div>

   <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4">
   <!-- Upcoming Exam -->
   <div class="border rounded-lg p-4 bg-white shadow-sm text-center">
      <h2 class="text-sm font-semibold text-gray-500 mb-1">Upcoming Exams</h2>
      <p class="text-2xl font-bold text-indigo-600">05</p>
   </div>

   <!-- Events -->
   <div class="border rounded-lg p-4 bg-white shadow-sm text-center">
      <h2 class="text-sm font-semibold text-gray-500 mb-1">Events</h2>
      <p class="text-2xl font-bold text-green-600">05</p>
   </div>

   <!-- Attendance -->
   <div class="border rounded-lg p-4 bg-white shadow-sm text-center">
      <h2 class="text-sm font-semibold text-gray-500 mb-1">Attendance</h2>
      <p class="text-2xl font-bold text-emerald-600">94%</p>
   </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-4">

  <!-- Student Information Card -->
  <div class="bg-white shadow-md rounded-lg p-4 col-span-1">
    <h2 class="text-lg font-semibold border-b pb-2 mb-4">My Information</h2>
    <div class="flex flex-col md:flex-row items-start gap-4">
      <img src="https://via.placeholder.com/100" class="w-24 h-24 rounded-full border" alt="Student">
      <div class="text-sm space-y-1">
        <p><strong>Name:</strong> Richi Hassan</p>
        <p><strong>Gender:</strong> Female</p>
        <p><strong>Father Name:</strong> Kazi Fahimur Rahman</p>
        <p><strong>Mother Name:</strong> Richi Akon</p>
        <p><strong>Date Of Birth:</strong> 03/04/2010</p>
        <p><strong>Religion:</strong> Islam</p>
        <p><strong>Father Occupation:</strong> Businessman</p>
        <p><strong>Email:</strong> richihasan@gmail.com</p>
        <p><strong>Admission Date:</strong> 05/04/2016</p>
        <p><strong>Class:</strong> 2</p>
        <p><strong>Section:</strong> A</p>
        <p><strong>Roll:</strong> 2901</p>
        <p><strong>Address:</strong> Ta-107, Sydney, Australia</p>
        <p><strong>Phone:</strong> +88 255600</p>
      </div>
    </div>
  </div>

  <!-- Right Section: Notice Board + Exam Result -->
  <div class="col-span-1 lg:col-span-2 flex flex-col gap-4">

   

    <!-- All Exam Result -->
    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
      <h2 class="text-lg font-semibold border-b pb-2 mb-4">All Exam Result</h2>
      <div class="flex flex-1 gap-2 mb-4">
        <input type="text" placeholder="Search by Exam" class="border px-2 py-1 rounded w-full sm:w-auto">
        <input type="date" class="border px-2 py-1 rounded w-full sm:w-auto">
        <button class="bg-yellow-600 text-white px-4 py-1 rounded hover:bg-yellow-700">Search</button>
      </div>
      <table class="table-auto w-full text-sm border">
        <thead class="bg-gray-100">
          <tr>
            <th class="border px-2 py-1">Exam Name</th>
            <th class="border px-2 py-1">Subject</th>
            <th class="border px-2 py-1">Grade Point</th>
            <th class="border px-2 py-1">Percent From</th>
            <th class="border px-2 py-1">Percent Upto</th>
            <th class="border px-2 py-1">Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-2 py-1">Class Test</td>
            <td class="border px-2 py-1">Mathematics</td>
            <td class="border px-2 py-1">4.00</td>
            <td class="border px-2 py-1">98.00</td>
            <td class="border px-2 py-1">100.00</td>
            <td class="border px-2 py-1">20/06/2017</td>
          </tr>
          <tr>
            <td class="border px-2 py-1">Pre Test</td>
            <td class="border px-2 py-1">English</td>
            <td class="border px-2 py-1">3.50</td>
            <td class="border px-2 py-1">70.00</td>
            <td class="border px-2 py-1">100.00</td>
            <td class="border px-2 py-1">20/06/2017</td>
          </tr>
          <!-- More rows as needed -->
        </tbody>
      </table>
    </div>

  </div>
</div>


</div>
@endsection