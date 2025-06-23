@extends('page.teacher.parent')

@section('content')

<main class="max-w-[1200px] mx-auto px-6 pt-16 pb-20">
    <h1 class="text-5xl font-extrabold text-gray-900 mb-10 leading-tight">My Classes</h1>
    <section aria-labelledby="classes-heading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Example of a Class Card -->
      @foreach ($classes as $class)
      <article 
        class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between hover:shadow-lg transition-shadow duration-300 focus-within:ring-2 focus-within:ring-indigo-500"
        tabindex="0"
        aria-label="Details for {{ $class['name'] }} Section {{ $class['section'] }}"
      >
        <div>
          <h2 class="text-2xl font-semibold text-gray-900 mb-1">{{ $class['name'] }} - Section {{ $class['section'] }}</h2>
          <p class="text-sm text-gray-500 mb-4">Assigned Subjects:</p>
          <ul class="list-disc list-inside text-gray-600 mb-4" aria-label="Subject list">
            @foreach ($class['subjects'] as $subject)
            <li>{{ $subject }}</li>
            @endforeach
          </ul>
          <p class="text-sm font-semibold text-gray-700">Number of Students: <span class="font-normal">{{ $class['student_count'] }}</span></p>
        </div>
        <div class="mt-6">
          <a href="{{ route('teacher.studentlist') }}" 
             class="inline-block w-full text-center bg-black text-white py-2 rounded-md text-sm font-semibold hover:bg-gray-900 transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            View Class
          </a>
        </div>
    </article>
    @endforeach
  </section>
</main>
@endsection