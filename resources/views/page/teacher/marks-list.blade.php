@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-blue-800">Marks Entry</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('marks.entry.index') }}" class="bg-white shadow rounded-lg p-6 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Select Exam</label>
                    <select required name="exam_master_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Choose Exam --</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->exam_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Select Class</label>
                    <select required name="class_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Choose Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Select Section</label>
                    <select required name="section_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Choose Section --</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-4 mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Search</button>
                <button type="reset" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">Reset</button>
            </div>
        </form>

        <!-- Static Table (Demo Purpose Only) -->
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-4">Student Name</th>
                        <th class="p-4">Mathematics<br><span class="text-xs">(60/100)</span></th>
                        <th class="p-4">Science<br><span class="text-xs">(60/100)</span></th>
                        <th class="p-4">English<br><span class="text-xs">(60/100)</span></th>
                        <th class="p-4">Hindi<br><span class="text-xs">(60/100)</span></th>
                        <th class="p-4">SST<br><span class="text-xs">(60/100)</span></th>
                        <th class="p-4">Sanskrit<br><span class="text-xs">(60/100)</span></th>
                        <th class="p-4">Total</th>
                        <th class="p-4">Obtained</th>
                        <th class="p-4">Result</th>
                        <th class="p-4">%</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 font-medium">Riya Sharma</td>
                        <td class="p-4">55</td>
                        <td class="p-4">48</td>
                        <td class="p-4">50</td>
                        <td class="p-4">52</td>
                        <td class="p-4">49</td>
                        <td class="p-4">51</td>
                        <td class="p-4">600</td>
                        <td class="p-4">305</td>
                        <td class="p-4 text-green-600">Pass</td>
                        <td class="p-4">50.8%</td>
                        <td class="p-4 space-x-2">
                            <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">Save</button>
                            <button onclick="printAnotherPage()" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-xs">Print</button>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 font-medium">Aman Verma</td>
                        <td class="p-4">32</td>
                        <td class="p-4">25</td>
                        <td class="p-4">30</td>
                        <td class="p-4">29</td>
                        <td class="p-4">35</td>
                        <td class="p-4">27</td>
                        <td class="p-4">600</td>
                        <td class="p-4">178</td>
                        <td class="p-4 text-red-600">Fail</td>
                        <td class="p-4">29.6%</td>
                        <td class="p-4 space-x-2">
                            <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">Save</button>
                            <button onclick="printAnotherPage()" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-xs">Print</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function printAnotherPage() {
        const printWindow = window.open("{{ route('marks.entry.index') }}", '_blank');
        printWindow.onload = function () {
            printWindow.print();
        };
    }
</script>
@endsection
