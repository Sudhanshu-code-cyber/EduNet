@extends('page.student.parent')

@section('content')
<div class="p-6 space-y-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Pay Fees</h1>
        <a href="{{ route('student.fees.overview') }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-800">
           Back to Overview
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg shadow">
            <strong class="font-bold">Success:</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Student Info --}}
    <div class="bg-white shadow-md rounded-2xl p-6 flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
        <div class="shrink-0">
            <img src="{{ $student->photo ? asset('uploads/students/' . $student->photo) : 'https://i.pravatar.cc/150?img=1' }}"
                 class="w-28 h-28 rounded-full object-cover border-4 border-indigo-500 shadow-md">
        </div>
        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-800">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $student->full_name }}</h2>
                <p><span class="font-semibold">Class:</span> {{ $student->class->name }}</p>
                <p><span class="font-semibold">Section:</span> {{ $student->section->name }}</p>
            </div>
            <div>
                <p><span class="font-semibold">Email:</span> {{ $student->email }}</p>
                <p><span class="font-semibold">Phone:</span> {{ $student->contact }}</p>
            </div>
        </div>
    </div>


    {{-- Fee Form --}}
    <form method="POST" action="{{ route('student.fees.pay') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="text-lg font-bold mb-4">Select Fee & Month</h3>

            <div class="flex gap-4 mb-4 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-green-600 rounded"></div> Paid
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-red-600 rounded"></div> Due
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-blue-600 rounded"></div> Selected
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-gray-400 rounded"></div> Not Applicable
                </div>
            </div>

            <table class="w-full text-sm text-left border border-collapse">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">Fee Type</th>
                        <th class="p-3 border">Amount (₹)</th>
                        <th class="p-3 border">Select Months</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($feeStructures as $index => $fee)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 border">{{ $loop->iteration }}</td>
                        <td class="p-3 border">{{ $fee->feeType->name }}</td>
                        <td class="p-3 border">
                            ₹{{ number_format($fee->amount, 2) }}
                            <input type="hidden" name="fees[{{ $index }}][fee_type_id]" value="{{ $fee->fee_type_id }}">
                            <input type="hidden" name="fees[{{ $index }}][amount]" value="{{ $fee->amount }}">
                        </td>
                        <td class="p-3 border">
                            <div class="flex flex-wrap gap-2 max-h-32 overflow-y-auto">
                            @if($fee->frequency === 'one_time')
                                @php
                                    $key = $fee->fee_type_id . '_One-Time';
                                    $isPaid = isset($groupedPaid[$key]);
                                @endphp
                                <label class="text-xs font-semibold text-white {{ $isPaid ? 'bg-green-600' : 'bg-red-600' }} px-2 py-1 rounded">
                                    <input 
                                        type="checkbox"
                                        class="month-checkbox hidden"
                                        name="fees[{{ $index }}][months][]"
                                        value="One-Time"
                                        data-amount="{{ $fee->amount }}"
                                        @if($isPaid) checked disabled @endif
                                    >
                                    One-Time
                                </label>
                            @else
                                @for ($m = 1; $m <= 12; $m++)
                                    @php
                                        $monthNum = str_pad($m, 2, '0', STR_PAD_LEFT);
                                        $monthName = DateTime::createFromFormat('!m', $m)->format('M');
                                        $key = $fee->fee_type_id . '-' . $monthNum;
                                        $isPaid = isset($groupedPaid[$key]);
                                        $now = now();
                                        $year = $m >= 4 ? $now->year : $now->year + 1;
                                        $monthDate = \Carbon\Carbon::createFromDate($year, $m, 1);
                                        $isApplicable = $monthDate->isPast() || $monthDate->isCurrentMonth();
                                    @endphp
                                    @if($isPaid)
                                        <label class="text-xs font-semibold text-white bg-green-600 px-2 py-1 rounded">
                                            <input 
                                                type="checkbox"
                                                class="month-checkbox hidden"
                                                name="fees[{{ $index }}][months][]"
                                                value="{{ $monthNum }}"
                                                checked disabled
                                                data-amount="{{ $fee->amount }}"
                                            >
                                            {{ $monthName }}
                                        </label>
                                    @elseif($isApplicable)
                                        <label class="month-label text-xs font-semibold text-white bg-red-600 px-2 py-1 rounded cursor-pointer hover:bg-blue-600">
                                            <input 
                                                type="checkbox"
                                                class="month-checkbox hidden"
                                                name="fees[{{ $index }}][months][]"
                                                value="{{ $monthNum }}"
                                                data-amount="{{ $fee->amount }}"
                                            >
                                            {{ $monthName }}
                                        </label>
                                    @else
                                        <label class="text-xs text-white bg-gray-400 px-2 py-1 rounded">
                                            {{ $monthName }}
                                        </label>
                                    @endif
                                @endfor
                            @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="text-right mt-4 text-lg font-semibold">
                Total Payable: ₹<span id="totalAmount">0.00</span>
            </div>
        </div>

        {{-- Payment --}}
        <div class="bg-white shadow-lg rounded-xl p-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="w-full md:w-1/2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                    <select name="payment_method" class="block w-full border rounded px-3 py-2">
                        <option value="Cash">Cash</option>
                        <option value="UPI">UPI</option>
                        <option value="Card">Credit/Debit Card</option>
                        <option value="Net Banking">Net Banking</option>
                    </select>
                </div>
                <div class="w-full md:w-auto mt-4 md:mt-0">
                    <button type="submit" onclick="return confirm('Are you sure you want to proceed?')" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                        Pay Now
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Script --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const totalEl = document.getElementById("totalAmount");

    function updateTotal() {
        let total = 0;
        document.querySelectorAll("input.month-checkbox").forEach(cb => {
            if (cb.checked && !cb.disabled) {
                const amt = parseFloat(cb.getAttribute('data-amount'));
                if (!isNaN(amt)) total += amt;
            }
        });
        totalEl.innerText = total.toFixed(2);
    }

    document.querySelectorAll(".month-label").forEach(label => {
        const checkbox = label.querySelector("input.month-checkbox");

        label.addEventListener("click", function (e) {
            if (checkbox.disabled) return;

            checkbox.checked = !checkbox.checked;

            if (checkbox.checked) {
                label.classList.remove("bg-red-600");
                label.classList.add("bg-blue-600");
            } else {
                label.classList.remove("bg-blue-600");
                label.classList.add("bg-red-600");
            }

            updateTotal();
        });
    });

    updateTotal();
});
</script>
@endsection
