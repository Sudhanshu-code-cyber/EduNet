@extends('page.teacher.parent')

@section('content')
<div class="max-w-7xl mx-auto px-8 pt-16 pb-20 bg-white min-h-screen">
  <!-- Page Header -->
  <header class="mb-14 text-center max-w-3xl mx-auto">
    <h1 class="text-[3rem] font-extrabold text-gray-900 leading-tight tracking-tight mb-3">
      Student Attendance
    </h1>
    <p class="text-lg text-gray-500 max-w-xl mx-auto">
      Manage and track attendance effectively by selecting class, section, month, and year.
    </p>
  </header>

  <!-- Filter Form -->
  <section class="bg-gray-50 p-8 rounded-2xl shadow-lg max-w-5xl mx-auto mb-16">
    <form method="GET" action="#" class="grid grid-cols-1 md:grid-cols-5 gap-6">
      <div>
        <label for="class" class="block text-sm font-semibold text-gray-700 mb-2">Class</label>
        <select id="class" name="class" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
          <option value="" selected disabled>Select Class</option>
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <!-- Add more options as needed -->
        </select>
      </div>
      <div>
        <label for="section" class="block text-sm font-semibold text-gray-700 mb-2">Section</label>
        <select id="section" name="section" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
          <option value="" selected disabled>Select Section</option>
          <option>A</option>
          <option>B</option>
          <option>C</option>
          <!-- Add more options as needed -->
        </select>
      </div>
      <div>
        <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">Month</label>
        <select id="month" name="month" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
          <option value="" selected disabled>Select Month</option>
          <option value="1">January</option>
          <option value="2">February</option>
          <option value="3">March</option>
          <option value="4">April</option>
          <option value="5">May</option>
          <option value="6">June</option>
          <option value="7">July</option>
          <option value="8">August</option>
          <option value="9">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
      </div>
      <div>
        <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">Year</label>
        <select id="year" name="year" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
          <option value="" selected disabled>Select Year</option>
          <option>2023</option>
          <option>2024</option>
          <option>2025</option>
          <!-- Add more options as needed -->
        </select>
      </div>
      <div class="flex items-end">
        <button type="submit" class="w-full bg-indigo-700 hover:bg-indigo-800 text-white font-semibold py-3 rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          Search
        </button>
      </div>
    </form>
  </section>

  <!-- Attendance Table -->
  <section class="overflow-x-auto max-w-full mx-auto rounded-2xl shadow-lg bg-white p-8">
    <h2 class="text-2xl font-semibold text-gray-500 mb-8 text-center md:text-left">
      Attendance Sheet - Class 1, Section A - March 2024
    </h2>
    <table class="min-w-max w-full border-collapse border border-gray-200 text-gray-700 select-none">
      <thead>
        <tr class="bg-gray-100">
          <th class="sticky left-0 bg-gray-100 z-20 border border-gray-200 text-left text-sm font-semibold px-6 py-4 rounded-l-2xl">
            Student Name
          </th>
          @for ($day = 1; $day <= 31; $day++)
          <th class="border border-gray-200 text-center text-xs font-semibold px-2 py-3 text-gray-600">
            {{ $day }}
          </th>
          @endfor
        </tr>
      </thead>
      <tbody>
        {{-- Example student row --}}
        <tr class="hover:bg-indigo-50 transition-colors">
          <td class="sticky left-0 bg-white z-10 border border-gray-200 font-medium text-gray-900 px-6 py-3 rounded-l-2xl whitespace-nowrap">
            John Doe
          </td>
          @for ($day = 1; $day <= 31; $day++)
          <td class="border border-gray-200 px-2 py-1 text-center align-middle">
            <label class="relative inline-flex cursor-pointer select-none">
              <input type="checkbox" class="sr-only peer" checked />
              <span class="w-8 h-4 bg-gray-300 rounded-full peer-focus:ring-2 peer-focus:ring-indigo-400 peer-checked:bg-indigo-600 transition-colors"></span>
              <span class="absolute left-1 top-1 w-3 h-3 bg-white rounded-full shadow peer-checked:translate-x-4 transition-transform"></span>
            </label>
          </td>
          @endfor
        </tr>
        <tr class="hover:bg-indigo-50 transition-colors bg-white">
          <td class="sticky left-0 bg-white z-10 border border-gray-200 font-medium text-gray-900 px-6 py-3 rounded-l-2xl whitespace-nowrap">
            Jane Smith
          </td>
          @for ($day = 1; $day <= 31; $day++)
          <td class="border border-gray-200 px-2 py-1 text-center align-middle">
            <label class="relative inline-flex cursor-pointer select-none">
              <input type="checkbox" class="sr-only peer" />
              <span class="w-8 h-4 bg-gray-300 rounded-full peer-focus:ring-2 peer-focus:ring-indigo-400 peer-checked:bg-indigo-600 transition-colors"></span>
              <span class="absolute left-1 top-1 w-3 h-3 bg-white rounded-full shadow peer-checked:translate-x-4 transition-transform"></span>
            </label>
          </td>
          @endfor
        </tr>
        {{-- Additional students dynamically loaded here --}}
      </tbody>
    </table>
  </section>
</div>
@endsection

