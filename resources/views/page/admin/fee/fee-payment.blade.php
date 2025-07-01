@extends('page.admin.parent')

@section('content')
<div class="max-w-3xl mx-auto p-8 bg-white rounded-xl shadow-lg mt-10">

    <h2 class="text-3xl font-bold mb-6 text-gray-800">Fee Payment</h2>

    {{-- Show validation errors --}}
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

    {{-- Step 1: Search student --}}
    <h3 class="text-xl font-semibold mb-4">Step 1: Search student</h3>
    <form method="POST" action="{{ route('fee-payment.search') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                <select name="class_id" id="class_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">Select</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="section_id" class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                <select name="section_id" id="section_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Select</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="roll_no" class="block text-sm font-medium text-gray-700 mb-1">Roll Number</label>
                <input type="text" name="roll_no" id="roll_no" value="{{ old('roll_no') }}" placeholder="Enter Roll No" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <button type="submit" class="mt-4 bg-green-600 text-white font-medium px-6 py-2 rounded-lg hover:bg-green-700">Search</button>
    </form>

    {{-- Step 2: Show fee payment form --}}
    @if(isset($student))
        <div class="mt-10 p-6 bg-gray-50 rounded-lg border border-gray-200">
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
@foreach($fees as $fee)
<tr>
    <td class="p-2 border">{{ $fee->feeType->name }}</td>
    <td class="p-2 border">₹{{ number_format($fee->amount, 2) }}</td>

    <td class="p-2 border">
        @if($fee->frequency === 'monthly')
            <div class="grid grid-cols-2 gap-1 max-h-32 overflow-y-auto">
                @foreach (range(1, 12) as $month)
                    <label class="flex items-center space-x-1">
                        <input 
                            type="checkbox" 
                            name="fees[{{ $loop->parent->index }}][months][]" 
                            value="{{ $month }}" 
                            data-amount="{{ $fee->amount }}"
                            class="month-checkbox">
                        <span class="text-xs">{{ date('M', mktime(0, 0, 0, $month, 1)) }}</span>
                    </label>
                @endforeach
            </div>
        @else
            <span class="text-sm text-gray-600">One-Time</span>
            <input type="hidden" name="fees[{{ $loop->index }}][months][]" value="One-Time">
        @endif
    </td>

    <td class="p-2 border text-center">
        <input type="hidden" name="fees[{{ $loop->index }}][fee_type_id]" value="{{ $fee->fee_type_id }}">
        <input type="hidden" name="fees[{{ $loop->index }}][amount]" value="{{ $fee->amount }}">
        <input type="checkbox" 
               name="fees[{{ $loop->index }}][selected]" 
               value="1" 
               class="select-fee-checkbox" 
               data-index="{{ $loop->index }}">
    </td>
</tr>
@endforeach
</tbody>
                </table>

                <div class="flex justify-between items-center mt-4">
                    <div class="w-1/2">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <select name="payment_method" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="Cash">Cash</option>
                            <option value="UPI">UPI</option>
                            <option value="Bank">Bank</option>
                        </select>
                    </div>

                  <div class="text-lg font-semibold text-right w-full mt-4">
    <span id="total-amount">Total: ₹0.00</span>
</div>
                </div>

                <button type="submit" class="mt-6 bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 w-full">Submit Payment</button>
            </form>
        </div>
    @endif
</div>

{{-- Optional JS: Real-time fee total --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const totalEl = document.getElementById('total-amount');

        function updateTotal() {
            let total = 0;

            // For each fee row's selected checkbox
            document.querySelectorAll('.select-fee-checkbox').forEach(selectCb => {
                if (selectCb.checked) {
                    const index = selectCb.getAttribute('data-index');
                    const feeAmount = parseFloat(document.querySelector(`input[name="fees[${index}][amount]"]`).value);

                    // Check if it's a monthly fee (has visible month checkboxes)
                    const monthCheckboxes = document.querySelectorAll(`input[name="fees[${index}][months][]"]`);

                    if (monthCheckboxes.length > 1) {
                        // Monthly fee: count checked months
                        const checkedMonths = Array.from(monthCheckboxes).filter(cb => cb.checked);
                        total += checkedMonths.length * feeAmount;
                    } else {
                        // One-time fee (no visible checkboxes)
                        total += feeAmount;
                    }
                }
            });

            totalEl.innerText = "Total: ₹" + total.toFixed(2);
        }

        // Attach listeners
        document.querySelectorAll('.month-checkbox, .select-fee-checkbox').forEach(cb => {
            cb.addEventListener('change', updateTotal);
        });

        updateTotal(); // on page load
    });
</script>



@endsection