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

            {{-- Legend --}}
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
                @php
                    use Carbon\Carbon;
                    $months = ['Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar'];
                    $academicMonths = ['Apr'=>4,'May'=>5,'Jun'=>6,'Jul'=>7,'Aug'=>8,'Sep'=>9,'Oct'=>10,'Nov'=>11,'Dec'=>12,'Jan'=>1,'Feb'=>2,'Mar'=>3];
                @endphp

                @foreach($feeStructures as $index => $fee)
                    <tr class="border-t">
                        <td class="p-3 border">{{ $index + 1 }}</td>
                        <td class="p-3 border">{{ $fee->feeType->name }}</td>
                        <td class="p-3 border">₹{{ number_format($fee->amount, 2) }}</td>
                        <td class="p-3 border">
                            <div class="flex flex-wrap gap-2 max-h-32 overflow-y-auto">
                            @if($fee->frequency === 'one_time')
                                @php
                                    $key = $fee->fee_type_id . '_One-Time';
                                    $isPaid = isset($groupedPaid[$key]);
                                @endphp
                                <label class="text-xs font-semibold text-white {{ $isPaid ? 'bg-green-600' : 'bg-red-600 month-label' }} px-2 py-1 rounded cursor-pointer">
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
                                @foreach($academicMonths as $mon => $m)
                                    @php
                                        $monthNum = str_pad($m, 2, '0', STR_PAD_LEFT);
                                        $monthName = $mon;
                                        $key = $fee->fee_type_id . '-' . $monthNum;
                                        $isPaid = isset($groupedPaid[$key]);

                                        $year = $m >= 4 ? now()->year : now()->year + 1;
                                        $monthDate = Carbon::createFromDate($year, $m, 1);
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
                                        <label class="month-label text-xs font-semibold text-white bg-red-600 px-2 py-1 rounded cursor-pointer">
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
                                @endforeach
                            @endif
                            </div>
                            <input type="hidden" name="fees[{{ $index }}][fee_type_id]" value="{{ $fee->fee_type_id }}">
                            <input type="hidden" name="fees[{{ $index }}][amount]" value="{{ $fee->amount }}">
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
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-600">
            <p class="font-medium">Proceed to secure online payment via Razorpay.</p>
        </div>

        <button type="button"
                id="razorpay-button"
                onclick="return confirm('Are you sure you want to proceed?')"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2 9 3.343 9 5s1.343 3 3 3zm0 2c-2.21 0-4 1.79-4 4v5h8v-5c0-2.21-1.79-4-4-4z"/>
            </svg>
            Pay with Razorpay
        </button>
    </div>
</div>

    </form>
</div>

{{-- Script --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const totalEl = document.getElementById("totalAmount");

    function updateTotal() {
        let total = 0;
        document.querySelectorAll("input.month-checkbox").forEach(cb => {
            if (cb.checked && !cb.disabled) {
                const amt = parseFloat(cb.dataset.amount);
                if (!isNaN(amt)) total += amt;
            }
        });
        totalEl.innerText = total.toFixed(2);
    }

    document.querySelectorAll(".month-label").forEach(label => {
        const checkbox = label.querySelector("input.month-checkbox");

        label.addEventListener("click", function (e) {
            e.preventDefault();
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
   function getSelectedFeeData() {
        let selectedFees = [];

        document.querySelectorAll("input.month-checkbox:checked:not(:disabled)").forEach(cb => {
            const td = cb.closest("td");
            const feeTypeIdInput = td.querySelector("input[name*='fee_type_id']");
            const feeTypeId = feeTypeIdInput ? feeTypeIdInput.value : null;
            const amount = cb.dataset.amount;
            const month = cb.value;

            if (feeTypeId) {
                selectedFees.push({
                    fee_type_id: feeTypeId,
                    month: month,
                    amount: amount
                });
            }
        });

        return selectedFees;
    }

    document.getElementById('razorpay-button').addEventListener('click', function () {
        const total = parseFloat(totalEl.innerText);
        if (!total || total <= 0) {
            alert("Please select at least one unpaid month to proceed.");
            return;
        }

        const selectedFees = getSelectedFeeData();

        // Step 1: Initiate Razorpay Order
        fetch('{{ route('student.fees.razorpay.initiate') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                student_id: {{ $student->id }},
                total_amount: total
            })
        })
        .then(res => res.json())
        .then(data => {
            // Step 2: Open Razorpay Checkout
            const options = {
                key: data.razorpay_key,
                amount: data.amount,
                currency: "INR",
                name: "School Fee Payment",
                description: "Student Fee Payment",
                image: "{{ asset('storage/homeworks/images.jpeg') }}",
                order_id: data.order_id,
                handler: function (response) {
                    // Step 3: Store Payment and Fee Months
                    fetch('{{ route('student.fees.razorpay.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            student_id: {{ $student->id }},
                            selected_fees: selectedFees
                        })
                    })
                    .then(() => {
                        window.location.href = "{{ route('student.fees.overview') }}";
                    })
                    .catch(() => {
                        alert('Payment completed, but fee data could not be saved.');
                    });
                },
                prefill: {
                    name: data.student.name,
                    email: data.student.email,
                    contact: data.student.contact
                },
                theme: {
                    color: "#3B82F6"
                }
            };

            const rzp = new Razorpay(options);
            rzp.open();
        })
        .catch(error => {
            console.error("Razorpay Init Error:", error);
            alert("Failed to start payment. Please try again.");
        });
    });
});
</script>

@endsection
