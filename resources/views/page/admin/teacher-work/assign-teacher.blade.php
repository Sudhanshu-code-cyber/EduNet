@extends('page.admin.parent')

@section('content')
<div class="max-w-6xl mx-auto p-8 bg-white rounded-2xl shadow-lg mt-10 border border-gray-200">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">Assign Teachers to Subjects</h2>

    {{-- Flash Success Message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 mb-6 rounded-lg border border-green-300 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Class & Section Selection --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <div>
            <label for="class_id" class="block font-semibold text-gray-700 mb-1">Select Class</label>
            <select id="class_id" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Choose Class --</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="section_id" class="block font-semibold text-gray-700 mb-1">Select Section</label>
            <select id="section_id" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Choose Section --</option>
                @foreach ($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Assignment Form --}}
    <form method="POST" action="{{ route('assign.teacher.store') }}">
        @csrf
        <input type="hidden" name="class_id" id="hidden_class_id">
        <input type="hidden" name="section_id" id="hidden_section_id">

        <div class="space-y-4">
            @foreach ($subjects as $subject)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="subjects_selected[]" value="{{ $subject->id }}" id="subject_{{ $subject->id }}" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="subject_{{ $subject->id }}" class="text-gray-700 font-medium">{{ $subject->name }}</label>
                    </div>

                    <select name="subjects[{{ $subject->id }}]" class="w-full sm:w-1/2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Select Teacher --</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>

        <button type="submit" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg shadow transition duration-150 ease-in-out">
            Assign Teachers
        </button>
    </form>

    {{-- Assignment Table --}}
    <h3 class="text-2xl font-bold text-gray-800 mt-12 mb-4 border-b pb-2">Assigned Teachers</h3>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm rounded-lg overflow-hidden shadow-sm">
            <thead class="bg-blue-50 text-gray-700 uppercase tracking-wide text-xs font-semibold">
                <tr>
                    <th class="border px-3 py-2 text-left">Class</th>
                    <th class="border px-3 py-2 text-left">Section</th>
                    <th class="border px-3 py-2 text-left">Subject</th>
                    <th class="border px-3 py-2 text-left">Teacher</th>
                    <th class="border px-3 py-2 text-left">Photo</th>
                    <th class="border px-3 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignments as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-3 py-2">{{ $item->class->name }}</td>
                        <td class="border px-3 py-2">{{ $item->section->name }}</td>
                        <td class="border px-3 py-2">{{ $item->subject->name }}</td>
                        <td class="border px-3 py-2">{{ $item->teacher->name }}</td>
                        <td class="border px-3 py-2">
                            <img src="{{ $item->teacher->photo_url ? asset('storage/' . $item->teacher->photo_url) : asset('default.png') }}" class="w-10 h-10 object-cover rounded-full border">
                        </td>
                        <td class="border px-3 py-2">
                            <form method="POST" action="{{ route('assign.teacher.delete', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#class_id').change(function () {
        const classId = $(this).val();
        $('#hidden_class_id').val(classId);

        $('#section_id').html('<option value="">Loading...</option>');

        $.ajax({
            url: '/get-sections-by-class/' + classId,
            type: 'GET',
            success: function (data) {
                $('#section_id').html('<option value="">-- Choose Section --</option>');
                $.each(data, function (index, section) {
                    $('#section_id').append('<option value="' + section.id + '">' + section.name + '</option>');
                });
            }
        });
    });

    $('#section_id').change(function () {
        const sectionId = $(this).val();
        $('#hidden_section_id').val(sectionId);
    });
</script>
@endsection
