@extends('page.teacher.parent')

@section('content')
  <div class="p-6 font-sans max-w-7xl mx-auto">
    <h2 class="text-3xl font-extrabold mb-10 text-blue-800 select-none">📅 Weekly Class Timetable</h2>

    <div class="flex flex-col lg:flex-row gap-10">
      <!-- Weekly Overview -->
      <section aria-label="Weekly Overview" class="lg:w-1/2 flex flex-col">
        <h3 class="text-2xl font-semibold mb-6 text-gray-800 border-b border-blue-300 pb-3 select-none">
          Weekly Overview
        </h3>

        <div class="bg-white shadow-lg rounded-xl border border-blue-200 overflow-hidden">
          <table class="w-full text-left text-gray-800 text-sm border-collapse">
            <thead class="bg-blue-100 text-blue-800 sticky top-0 z-10">
              <tr>
                <th class="py-3 px-6 font-semibold border-b border-blue-200">Day</th>
                <th class="py-3 px-6 font-semibold border-b border-blue-200">Schedule Summary</th>
              </tr>
            </thead>
            <tbody>
              @foreach($weeklyTimetable as $day => $classes)
                <tr class="hover:bg-blue-50 border-b border-blue-200 cursor-default select-none">
                  <td class="py-4 px-6 font-medium">{{ $day }}</td>
                  <td class="py-4 px-6">
                    @if(count($classes) > 0)
                      <ul class="list-disc list-inside space-y-1 max-h-60 overflow-y-auto pr-2">
                        @foreach($classes as $class)
                          <li class="flex items-center gap-2">
                            @if($class['type'] == 'break')
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-label="Break icon" role="img">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2v6" />
                              </svg>
                            @elseif($class['type'] == 'free')
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-label="Free period icon" role="img">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                              </svg>
                            @else
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-label="Class icon" role="img">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-6-8h6M3 12a9 9 0 0118 0v1a9 9 0 01-18 0v-1z" />
                              </svg>
                            @endif
                            <div>
                              <strong>{{ $class['subject'] }}</strong>
                              <span class="text-xs text-gray-600">({{ $class['start_time'] }} - {{ $class['end_time'] }})</span>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                    @else
                      <span class="text-gray-400 italic">No classes scheduled.</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>

      <!-- Per-Day Timetable -->
      <section aria-label="Per Day Timetable" class="lg:w-1/2 flex flex-col">
        <h3 class="text-2xl font-semibold mb-6 text-gray-800 border-b border-blue-300 pb-3 select-none">
          Per-Day Details
        </h3>
        <div class="space-y-8 overflow-auto max-h-[720px]">
          @foreach ($weeklyTimetable as $day => $classes)
            <section class="bg-white shadow-lg rounded-xl border border-blue-200 transition-shadow hover:shadow-xl" aria-labelledby="day-{{ Str::slug($day) }}">
              <h4 id="day-{{ Str::slug($day) }}" class="bg-gradient-to-r from-blue-200 via-blue-300 to-blue-200 px-5 py-3 font-semibold text-blue-800 rounded-t-xl border-b border-blue-300 select-none">
                {{ $day }}
              </h4>
              <table class="w-full text-left text-sm text-gray-800 border-collapse">
                <thead class="bg-gray-50 sticky top-0 z-10">
                  <tr>
                    <th scope="col" class="px-5 py-3 font-semibold border-b border-gray-200">Subject</th>
                    <th scope="col" class="px-5 py-3 font-semibold border-b border-gray-200">Teacher</th>
                    <th scope="col" class="px-5 py-3 font-semibold border-b border-gray-200">Time</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($classes as $class)
                    <tr class="cursor-pointer hover:bg-blue-50 transition-colors duration-200 ease-in-out">
                      <td class="px-5 py-3 align-top">
                        <div class="flex items-center gap-3 select-none">
                          @if ($class['type'] == 'break')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2v6" />
                            </svg>
                            {{ $class['subject'] }} <span class="text-xs text-gray-500">(Break)</span>
                          @elseif ($class['type'] == 'free')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                            {{ $class['subject'] }} <span class="text-xs text-gray-500">(Free Period)</span>
                          @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-6-8h6M3 12a9 9 0 0118 0v1a9 9 0 01-18 0v-1z" />
                            </svg>
                            {{ $class['subject'] }}
                          @endif
                        </div>
                      </td>
                      <td class="px-5 py-3 align-top text-gray-700 select-text">
                        @if ($class['type'] == 'class')
                          {{ $class['teacher'] }}
                        @else
                          <span aria-hidden="true">–</span><span class="sr-only">none</span>
                        @endif
                      </td>
                      <td class="px-5 py-3 align-top select-none">{{ $class['start_time'] }} &mdash; {{ $class['end_time'] }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="3" class="px-5 py-6 text-center text-gray-400 italic select-none">No classes scheduled.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </section>
          @endforeach
        </div>
      </section>
    </div>
  </div>
@endsection
