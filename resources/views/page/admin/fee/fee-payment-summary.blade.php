@extends('page.admin.parent')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    <div class="flex flex-1 justify-between items-center mb-6">
        <h2 class="text-2xl font-bold mb-6">Student Fee Payment Summary</h2>
        <div class="flex items-center space-x-4 text-xs text-gray-700 mt-4">
            <div class="flex items-center space-x-1">
                <div class="w-3 h-3 bg-green-500 rounded-full"></div><span>Paid</span>
            </div>
            <div class="flex items-center space-x-1">
                <div class="w-3 h-3 bg-red-500 rounded-full"></div><span>Due</span>
            </div>
            <div class="flex items-center space-x-1">
                <div class="w-3 h-3 bg-gray-400 rounded-full"></div><span>Not Applicable</span>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <form method="GET" class="flex flex-wrap items-end gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
        {{-- Class Dropdown --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
            <select name="class_id" class="border px-3 py-2 rounded w-48">
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Section Dropdown --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
            <select name="section_id" class="border px-3 py-2 rounded w-48">
                <option value="">Select Section</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                        {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Student Name --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Student Name</label>
            <input type="text" name="name" value="{{ request('name') }}" class="border px-3 py-2 rounded w-48" placeholder="Enter name">
        </div>

        {{-- Roll No --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Roll No</label>
            <input type="text" name="roll_no" value="{{ request('roll_no') }}" class="border px-3 py-2 rounded w-48" placeholder="Enter roll number">
        </div>

        {{-- Buttons --}}
        <div class="flex space-x-2 mt-6 ml-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-8 py-2 rounded-md">Filter</button>
            <a href="{{ route('admin.fee.summary') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-8 py-2 rounded-md">Reset</a>
        </div>
    </form>

    <table class="table-auto w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Photo</th>
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Class</th>
                <th class="p-2 border">Section</th>
                <th class="p-2 border">Fee Type</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Total</th>
                <th class="p-2 border">Paid</th>
                <th class="p-2 border">Due</th>
                <th class="p-2 border">Monthly Status</th>
                <th class="p-2 border">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($students as $student)
                @php
                    $summary = $initialSummary[$student->id] ?? [
                        'status' => '—',
                        'total' => '0.00',
                        'paid' => '0.00',
                        'due' => '0.00',
                        'months' => array_fill_keys(range(1, 12), 'none')
                    ];
                    $paidCount = collect($summary['months'])->filter(fn($v) => $v === 'paid')->count();
                @endphp

                <tr>
                    <td class="p-2 border text-center">
                        <img src="{{ $student->photo ? asset('uploads/students/' . $student->photo) : 'https://i.pravatar.cc/40?img=1' }}" class="w-10 h-10 rounded-full object-cover" />
                    </td>
                    <td class="p-2 border">{{ $student->full_name }}</td>
                    <td class="p-2 border">{{ $student->class->name ?? '' }}</td>
                    <td class="p-2 border">{{ $student->section->name ?? '' }}</td>
                    <td class="p-2 border">
                        <select onchange="loadMonths({{ $student->id }}, this.value)" class="border px-2 py-1 rounded">
                            <option value="">Select Fee Type</option>
                            @foreach($feeTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="p-2 border text-center" id="status_{{ $student->id }}">{{ $summary['status'] }}</td>
                    <td class="p-2 border text-center" id="total_{{ $student->id }}">₹{{ $summary['total'] }}</td>
                    <td class="p-2 border text-center" id="paid_{{ $student->id }}">₹{{ $summary['paid'] }}</td>
                    <td class="p-2 border text-center" id="due_{{ $student->id }}">₹{{ $summary['due'] }}</td>
                    <td class="p-2 border" id="month_status_{{ $student->id }}">
                        <div class="grid grid-cols-6 gap-1 text-xs font-semibold text-white">
                            @foreach(range(1, 12) as $m)
                                @php
                                    $code = str_pad($m, 2, '0', STR_PAD_LEFT);
                                    $status = $summary['months'][$code] ?? 'none'; 
                                    $color = match($status) {
                                        'paid' => 'bg-green-500',
                                        'due' => 'bg-red-500',
                                        default => 'bg-gray-400' 
                                    };
                                @endphp
                                <div title="{{ date('F', mktime(0, 0, 0, $m, 1)) }}: {{ ucfirst($status) }}"
                                     class="rounded px-2 py-1 text-center {{ $color }}">
                                    {{ date('M', mktime(0, 0, 0, $m, 1)) }}
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-1">
                            <div class="h-2 rounded bg-gray-200 w-full">
                                <div class="h-2 bg-green-500 rounded" style="width: {{ round(($paidCount / 12) * 100, 1) }}%"></div>
                            </div>
                            <div class="text-[11px] text-right text-gray-600 mt-1">
                                {{ $paidCount }}/12 months paid
                            </div>
                        </div>
                    </td>
                    <td class="p-2 border text-center">
                        <a href="{{ route('admin.fee-payment.view', $student->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded">View / Pay</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- JS --}}
<script>
function loadMonths(studentId, feeTypeId) {
    if (!feeTypeId) return;

    fetch(`/admin/fee-payment-summary/months?student_id=${studentId}&fee_type_id=${feeTypeId}`)
        .then(res => res.json())
        .then(data => {
         console.log("MONTH RESPONSE:", data);
            document.getElementById(`status_${studentId}`).innerText = data.status;
            document.getElementById(`total_${studentId}`).innerText = `₹${data.totalAmount}`;
            document.getElementById(`paid_${studentId}`).innerText = `₹${data.paidAmount}`;
            document.getElementById(`due_${studentId}`).innerText = `₹${data.dueAmount}`;

            const paidSet = new Set(data.paidMonths.map(m => m.padStart(2, '0')));
            const dueSet = new Set(data.dueMonths.map(m => m.padStart(2, '0')));
            const allMonths = ['01','02','03','04','05','06','07','08','09','10','11','12'];
            const monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

            let html = '<div class="grid grid-cols-6 gap-1 text-xs font-semibold text-white">';
            allMonths.forEach((m, idx) => {
                let statusClass = 'bg-gray-400';
                let tooltip = `${monthNames[idx]}: Not Applicable`;

                if (paidSet.has(m)) {
                    statusClass = 'bg-green-500';
                    tooltip = `${monthNames[idx]}: Paid`;
                } else if (dueSet.has(m)) {
                    statusClass = 'bg-red-500';
                    tooltip = `${monthNames[idx]}: Due`;
                }

                html += `<div title="${tooltip}" class="rounded px-2 py-1 text-center ${statusClass}">${monthNames[idx]}</div>`;
            });
            html += '</div>';

            const paidCount = paidSet.size;
            html += `
                <div class="mt-1">
                    <div class="h-2 rounded bg-gray-200 w-full">
                        <div class="h-2 bg-green-500 rounded" style="width: ${(paidCount / 12 * 100).toFixed(1)}%"></div>
                    </div>
                    <div class="text-[11px] text-right text-gray-600 mt-1">${paidCount}/12 months paid</div>
                </div>`;

            document.getElementById(`month_status_${studentId}`).innerHTML = html;
        });
}
</script>
@endsection
