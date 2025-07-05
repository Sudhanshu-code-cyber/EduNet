@extends('page.admin.parent')

@section('content')
<div class="max-w-3xl mx-auto p-8 bg-white rounded-xl shadow-lg mt-10">

    <h2 class="text-3xl font-bold mb-6 text-gray-800">Fee Payment</h2>

    {{-- Validation Messages --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <strong class="font-semibold">Error:</strong>
            <ul class="mt-1 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            {{ session('error') }}
        </div>
    @endif

    {{-- Step 1: Search Student --}}
    <h3 class="text-xl font-semibold mb-4">Step 1: Search student</h3>
    <form method="POST" action="{{ route('fee-payment.search') }}" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                <select name="class_id" id="class_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Select</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="section_id" class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                <select name="section_id" id="section_id" class="w-full border rounded-lg px-3 py-2">
                    <option value="">Select</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="roll_no" class="block text-sm font-medium text-gray-700 mb-1">Roll Number</label>
                <input type="text" name="roll_no" id="roll_no" value="{{ old('roll_no') }}" class="w-full border rounded-lg px-3 py-2" placeholder="Enter Roll No">
            </div>
        </div>

        <button type="submit" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Search</button>
    </form>

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 mt-10">
        {{ session('success') }}
    </div>
@endif


    {{-- Step 2: Show Fee Payment Form --}}
    @if(isset($student))
    <div class="mt-10 p-6 bg-gray-50 rounded-lg border">
        <h3 class="text-lg font-semibold mb-4">Step 2: Show fee payment form</h3>
        <p class="mb-4 text-gray-700 font-medium">Student: {{ $student->full_name }}</p>

        <form method="POST" action="{{ route('fee-payment.store') }}">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student->id }}">
            <input type="hidden" name="class_id" value="{{ $student->class_id }}">

           <table class="w-full border text-sm mb-4">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-2 border">Fee Type</th>
            <th class="p-2 border">Amount</th>
            <th class="p-2 border">Month</th>
            <th class="p-2 border text-center">Select</th>
        </tr>
    </thead>
    <tbody>
    @foreach($fees as $feeIndex => $fee)
        @php
            $feeTypeId = $fee->fee_type_id;
        @endphp
        <tr>
            <td class="p-2 border">{{ $fee->feeType->name }}</td>
            <td class="p-2 border">₹{{ number_format($fee->amount, 2) }}</td>
            <td class="p-2 border">
                @if($fee->frequency === 'monthly')
                    <div class="grid grid-cols-2 gap-1 max-h-32 overflow-y-auto">
                        @foreach (range(1, 12) as $month)
                            @php
                                $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);
                                $alreadyPaid = isset($paidData[$feeTypeId]) && in_array($monthStr, $paidData[$feeTypeId]);
                            @endphp
                            <label class="flex items-center space-x-1">
                                <input 
                                    type="checkbox" 
                                    name="fees[{{ $feeIndex }}][months][]" 
                                    value="{{ $monthStr }}" 
                                    data-amount="{{ $fee->amount }}"
                                    class="month-checkbox"
                                    {{ $alreadyPaid ? 'checked disabled' : '' }}>
                                <span class="text-xs {{ $alreadyPaid ? 'text-green-600 font-semibold' : '' }}">
                                    {{ date('M', mktime(0, 0, 0, $month, 1)) }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                @else
                    <span class="text-sm text-gray-600">One-Time</span>
                    <input type="hidden" name="fees[{{ $feeIndex }}][months][]" value="One-Time">
                @endif
            </td>
            <td class="p-2 border text-center">
                <input type="hidden" name="fees[{{ $feeIndex }}][fee_type_id]" value="{{ $fee->fee_type_id }}">
                <input type="hidden" name="fees[{{ $feeIndex }}][amount]" value="{{ $fee->amount }}">
                <input type="checkbox" 
                       name="fees[{{ $feeIndex }}][selected]" 
                       value="1" 
                       class="select-fee-checkbox" 
                       data-index="{{ $feeIndex }}">
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

            <div class="flex justify-between items-center mt-4">
                <div class="w-1/2">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                    <select name="payment_method" class="w-full border rounded-lg px-3 py-2">
                        <option value="Cash">Cash</option>
                        <option value="UPI">UPI</option>
                        <option value="Bank">Bank</option>
                    </select>
                </div>

                <div class="text-lg font-semibold text-right w-full mt-4">
                    <span id="total-amount">Total: ₹0.00</span>
                </div>
            </div>

          <button type="submit" onclick="return confirm('Confirm fee payment?')" 
    class="mt-6 bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 w-full">
    Submit Payment
</button>
        </form>
    </div>
    @endif
</div>

{{-- JavaScript: Real-time total calculation --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const totalEl = document.getElementById('total-amount');

        function updateTotal() {
            let total = 0;

            document.querySelectorAll('.select-fee-checkbox').forEach(selectCb => {
                if (selectCb.checked) {
                    const index = selectCb.getAttribute('data-index');
                    const feeAmount = parseFloat(document.querySelector(`input[name="fees[${index}][amount]"]`).value);
                    const monthCheckboxes = document.querySelectorAll(`input[name="fees[${index}][months][]"]`);

                    if (monthCheckboxes.length > 1) {
                        const checkedMonths = Array.from(monthCheckboxes).filter(cb => cb.checked && !cb.disabled);
                        total += checkedMonths.length * feeAmount;
                    } else {
                        total += feeAmount;
                    }
                }
            });

            totalEl.innerText = "Total: ₹" + total.toFixed(2);
        }

        document.querySelectorAll('.month-checkbox, .select-fee-checkbox').forEach(cb => {
            cb.addEventListener('change', updateTotal);
        });

        updateTotal();
    });
</script>
@endsection
