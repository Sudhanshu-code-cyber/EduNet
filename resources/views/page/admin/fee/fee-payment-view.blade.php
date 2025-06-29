@extends('page.admin.parent')

@section('content')
<div class="p-6 space-y-8">

    <h1 class="text-3xl font-bold text-gray-800">Fee Payment</h1>
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative">
        <strong class="font-bold">Success:</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <a href="" target="_blank" class="ml-4 text-blue-600 underline hover:text-blue-800">Print Receipt</a>
    </div>
@endif

    {{-- Student Info --}}
    <div class="flex bg-white shadow-md rounded-lg p-5">
        <img src="{{ asset('storage/students/'.$student->photo) }}" class="w-24 h-24 rounded-lg object-cover mr-6">
        <div class="space-y-1">
            <h2 class="text-2xl font-semibold">{{ $student->full_name }}</h2>
            <p><span class="font-medium">vAddress:</span> {{ $student->present_address }}</p>
            <p><span class="font-medium">Email:</span> {{ $student->email }}</p>
            <p><span class="font-medium">Phone:</span> {{ $student->contact }}</p>
        </div>
    </div>

    {{-- Fee Form --}}
    <form method="POST" action="{{ route('admin.fee-payment.store') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="text-lg font-bold mb-4">Invoice Entries</h3>

            <div class="overflow-x-auto">
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
                        @foreach($feeStructures as $fee)
                        @php $loopIndex = $loop->index; @endphp
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 border">{{ $loop->iteration }}</td>
                            <td class="p-3 border">{{ $fee->feeType->name }}</td>
                            <td class="p-3 border">
                                ₹{{ number_format($fee->amount, 2) }}
                                <input type="hidden" name="fees[{{ $loopIndex }}][fee_type_id]" value="{{ $fee->fee_type_id }}">
                                <input type="hidden" name="fees[{{ $loopIndex }}][amount]" value="{{ $fee->amount }}">
                            </td>
                            <td class="p-3 border">
                                <div class="flex flex-wrap gap-2 max-h-32 overflow-y-auto">
                             @for ($m = 1; $m <= 12; $m++)
    @php
        $monthNum = str_pad($m, 2, '0', STR_PAD_LEFT);  // '01' to '12'
        $monthName = DateTime::createFromFormat('!m', $m)->format('F');
        $key = $fee->fee_type_id . '-' . $monthNum;
        $isPaid = isset($groupedPaid[$key]);
    @endphp
    <label title="₹{{ $fee->amount }} for {{ $monthName }}"
           class="flex items-center space-x-1 {{ $isPaid ? 'text-gray-400 line-through' : 'text-gray-700' }}">
        <input 
            type="checkbox"
            class="month-checkbox"
            name="fees[{{ $loop->index }}][months][]"
            value="{{ $monthNum }}"
            data-amount="{{ $fee->amount }}"
            @if($isPaid) checked disabled @endif
        >
        <span class="text-xs">{{ $monthName }}</span>
    </label>
@endfor
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total --}}
            <div class="text-right mt-4 text-lg font-semibold">
                Total Payable: <span class="text-indigo-600">₹<span id="totalAmount">0.00</span></span>
            </div>
        </div>

        {{-- Payment Method --}}
        <div class="bg-white shadow rounded-lg p-5">
            <label class="block font-medium mb-2">Payment Method:</label>
            <select name="payment_method" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="Cash">Cash</option>
                <option value="UPI">UPI</option>
                <option value="Card">Card</option>
            </select>

            <button type="submit" class="mt-6 w-full bg-blue-600 text-white text-lg font-semibold py-2 rounded hover:bg-blue-700 transition">
                Submit Payment
            </button>
        </div>
    </form>


    <form method="GET" class="flex flex-wrap gap-4 mb-4 items-center">
    <select name="year" class="border px-2 py-1 rounded">
        <option value="">All Years</option>
        @foreach(range(date('Y'), date('Y') - 5) as $yr)
            <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
        @endforeach
    </select>

    <select name="month" class="border px-2 py-1 rounded">
        <option value="">All Months</option>
        @foreach(range(1, 12) as $m)
            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Filter</button>
</form>

    {{-- Payment History --}}
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="text-xl font-semibold mb-4">Payment History</h3>

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-sm border border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Date</th>
                        <th class="p-2 border">Fee Type</th>
                        <th class="p-2 border">Month</th>
                        <th class="p-2 border">Amount</th>
                        <th class="p-2 border">Method</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paidFees as $pay)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-2 border">{{ $pay->payment_date }}</td>
                            <td class="p-2 border">{{ $pay->feeType->name }}</td>
                            <td class="p-2 border">{{ $pay->month ?? '-' }}</td>
                            <td class="p-2 border">₹{{ $pay->amount }}</td>
                            <td class="p-2 border">{{ $pay->payment_method }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No payment history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Total calculation script --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const totalEl = document.getElementById("totalAmount");

    function updateTotal() {
        let total = 0;
        document.querySelectorAll(".month-checkbox").forEach(cb => {
            if (cb.checked && !cb.disabled) {
                const amt = parseFloat(cb.dataset.amount);
                if (!isNaN(amt)) total += amt;
            }
        });
        totalEl.innerText = total.toFixed(2);
    }

    document.querySelectorAll(".month-checkbox").forEach(cb => {
        cb.addEventListener("change", updateTotal);
    });

    updateTotal(); // On load
});
</script>
@endsection
