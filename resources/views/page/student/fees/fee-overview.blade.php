@extends('page.student.parent')

@section('content')
<div class="p-6 max-w-7xl mx-auto space-y-6">

    <h2 class="text-3xl font-bold text-gray-800">Fee Overview</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Student Info --}}
    <div class="flex items-center bg-white shadow-md rounded-lg p-6 space-x-6">
        <img src="{{ $student->photo ? asset('uploads/students/' . $student->photo) : 'https://i.pravatar.cc/40?img=1' }}"
             class="w-24 h-24 rounded-full object-cover ring-2 ring-indigo-500">
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-2 text-sm text-gray-700">
            <p><strong>Name:</strong> {{ $student->full_name }}</p>
            <p><strong>Roll No:</strong> {{ $student->roll_no }}</p>
            <p><strong>Class:</strong> {{ $student->class->name }}</p>
            <p><strong>Section:</strong> {{ $student->section->name }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Address:</strong> {{ $student->present_address }}</p>
            <p><strong>Parent:</strong> {{ $student->father_name }}</p>
        </div>
    </div>

    {{-- Fee Table --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto text-sm border divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-700 text-left">
                <tr>
                    <th class="px-4 py-3">Fee Type</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Paid</th>
                    <th class="px-4 py-3">Due</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Monthly Status</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($feeStructures as $structure)
                @php
                    $months = ['Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar'];
                    $academicMonths = ['Apr'=>4, 'May'=>5, 'Jun'=>6, 'Jul'=>7, 'Aug'=>8, 'Sep'=>9, 'Oct'=>10, 'Nov'=>11, 'Dec'=>12, 'Jan'=>1, 'Feb'=>2, 'Mar'=>3];

                    $now = \Carbon\Carbon::now();
                    $paid = 0;
                    $unpaidMonths = [];
                    $applicableMonths = [];

                    $monthYearMap = [];
                    foreach ($academicMonths as $mon => $num) {
                        $year = $num >= 4 ? $now->year : $now->year + 1;
                        $monthYearMap[$mon] = \Carbon\Carbon::createFromDate($year, $num, 1);
                    }

                    if ($structure->frequency === 'monthly') {
                        foreach ($months as $m) {
                            if ($monthYearMap[$m]->isPast() || $monthYearMap[$m]->isCurrentMonth()) {
                                $applicableMonths[] = $m;
                            }
                        }
                    } elseif ($structure->frequency === 'one_time') {
                        $applicableMonths = ['One-Time'];
                    }

                    foreach ($applicableMonths as $m) {
                        $key = $structure->fee_type_id . '_' . $m;
                        if (isset($paymentMap[$key])) {
                            $paid += $paymentMap[$key];
                        } else {
                            $unpaidMonths[] = $m;
                        }
                    }

                    $total = $structure->frequency === 'monthly'
                        ? $structure->amount * count($applicableMonths)
                        : $structure->amount;

                    $paid = min($paid, $total);
                    $due = max($total - $paid, 0);
                    $status = $due == 0 ? 'Paid' : ($paid > 0 ? 'Partially Paid' : 'Unpaid');
                @endphp

                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $structure->feeType->name }}</td>
                    <td class="px-4 py-3">₹{{ number_format($total, 2) }}</td>
                    <td class="px-4 py-3">₹{{ number_format($paid, 2) }}</td>
                    <td class="px-4 py-3 text-red-600">₹{{ number_format($due, 2) }}</td>
                    <td class="px-4 py-3 font-semibold text-{{ $status === 'Paid' ? 'green' : ($status === 'Unpaid' ? 'red' : 'yellow') }}-600">{{ $status }}</td>
                    <td class="px-4 py-3">
                        <div class="grid grid-cols-6 gap-1">
                            @if($structure->frequency === 'one_time')
                                @php
                                    $key = $structure->fee_type_id . '_One-Time';
                                    $isPaid = isset($paymentMap[$key]) && $paymentMap[$key] >= $structure->amount;
                                    $color = $isPaid ? 'bg-green-500' : 'bg-red-500';
                                @endphp
                                <div class="px-2 py-1 rounded text-white text-center text-xs font-semibold {{ $color }}">
                                    One-Time
                                </div>
                            @else
                                @foreach($months as $m)
                                    @php
                                        $key = $structure->fee_type_id . '_' . $m;
                                        $isApplicable = in_array($m, $applicableMonths);
                                        $isPaid = isset($paymentMap[$key]) && $paymentMap[$key] >= $structure->amount;

                                        $statusType = $isPaid ? 'paid' : ($isApplicable ? 'due' : 'na');
                                        $color = match($statusType) {
                                            'paid' => 'bg-green-500',
                                            'due' => 'bg-red-500',
                                            default => 'bg-gray-400',
                                        };
                                    @endphp
                                    <div title="{{ $m }}: {{ ucfirst($statusType) }}"
                                         class="px-2 py-1 rounded text-white text-center text-xs font-semibold {{ $color }}">
                                        {{ $m }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        @if($due > 0)
                            <form action="{{ route('student.pay-fees') }}" method="GET">
                                <input type="hidden" name="fee_type_id" value="{{ $structure->fee_type_id }}">
                                @foreach($unpaidMonths as $month)
                                    <input type="hidden" name="months[]" value="{{ $month }}">
                                @endforeach
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
                                    Pay Now
                                </button>
                            </form>
                        @else
                            <span class="text-green-600 font-semibold text-sm">Paid</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
