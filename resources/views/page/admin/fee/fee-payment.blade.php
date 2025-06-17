@extends('page.admin.parent')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Fee Payment</h2>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Step 1: Search student --}}
    <form method="POST" action="{{ route('fee-payment.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="class_id" class="block font-medium text-gray-700">Class</label>
                <select name="class_id" id="class_id" class="w-full border rounded px-4 py-2" required>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="section_id" class="block font-medium text-gray-700">Section</label>
                <select name="section_id" id="section_id" class="w-full border rounded px-4 py-2">
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="roll" class="block font-medium text-gray-700">Roll Number</label>
                <input type="text" name="roll" id="roll" placeholder="Enter Roll No" class="w-full border rounded px-4 py-2">
            </div>
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Search</button>
    </form>

    {{-- Step 2: Show fee payment form --}}
    @if(isset($student))
        <div class="mt-8 p-6 bg-gray-100 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">Student: {{ $student->name }}</h3>

            <form method="POST" action="{{ route('fee-payment.store') }}">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <input type="hidden" name="class_id" value="{{ $student->class_id }}">

                <table class="w-full text-left border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 border">Fee Type</th>
                            <th class="p-2 border">Amount</th>
                            <th class="p-2 border">Month</th>
                            <th class="p-2 border">Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fees as $fee)
                        <tr>
                            <td class="p-2 border">{{ $fee->feeType->name }}</td>
                            <td class="p-2 border">₹{{ $fee->amount }}</td>
                            <td class="p-2 border">
                                <input type="month" name="fees[{{ $loop->index }}][month]" class="border rounded px-2 py-1">
                            </td>
                            <td class="p-2 border">
                                <input type="hidden" name="fees[{{ $loop->index }}][fee_type_id]" value="{{ $fee->fee_type_id }}">
                                <input type="hidden" name="fees[{{ $loop->index }}][amount]" value="{{ $fee->amount }}">
                                <input type="checkbox" name="fees[{{ $loop->index }}][selected]" value="1" class="fee-checkbox">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <p id="total-amount" class="mt-4 font-bold text-lg text-right">Total: ₹0</p>

                <div class="mt-4">
                    <label for="payment_method" class="block font-medium text-gray-700">Payment Method</label>
                    <select name="payment_method" class="w-full border rounded px-4 py-2">
                        <option value="Cash">Cash</option>
                        <option value="UPI">UPI</option>
                        <option value="Bank">Bank</option>
                    </select>
                </div>

                <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Submit Payment</button>
            </form>
        </div>
    @endif
</div>

{{-- Optional JS: Real-time fee total --}}
<script>
    const checkboxes = document.querySelectorAll('.fee-checkbox');
    const totalEl = document.getElementById('total-amount');

    function updateTotal() {
        let total = 0;
        checkboxes.forEach((cb, i) => {
            if (cb.checked) {
                const amt = parseFloat(cb.previousElementSibling.value);
                total += amt;
            }
        });
        totalEl.innerText = "Total: ₹" + total;
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
</script>
@endsection
