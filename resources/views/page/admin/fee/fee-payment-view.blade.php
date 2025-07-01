@extends('page.admin.parent')

@section('content')
<div class="p-6 space-y-8">

  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Fee Payment</h1>
    <div class="text-right">
      <a href="{{ route('admin.fee-payment.history') }}"
         class="inline-block bg-blue-700 hover:bg-blue-900 text-white px-4 py-2 rounded shadow">
        Check Payment History
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative">
      <strong class="font-bold">Success:</strong>
      <span class="block sm:inline">{{ session('success') }}</span>
      @if(session('print_receipt'))
        <a href="{{ session('print_receipt') }}"
           target="_blank" class="ml-4 text-blue-600 underline hover:text-blue-800">
          Print Receipt
        </a>
      @endif
    </div>
  @endif

  {{-- Student Info --}}
  <div class="flex bg-white shadow-md rounded-lg p-5">
    <img src="{{ $student->photo ? asset('uploads/students/' . $student->photo) : 'https://i.pravatar.cc/40?img=1' }}" class="w-24 h-24 rounded-lg object-cover mr-6">
    <div class="space-y-1">
      <h2 class="text-2xl font-semibold">{{ $student->full_name }}</h2>
      <p><span class="font-medium">Address:</span> {{ $student->present_address }}</p>
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
                  @if($fee->frequency === 'one_time')
                    <label class="flex items-center text-sm text-blue-600 font-semibold">
                      <input type="checkbox" name="fees[{{ $loopIndex }}][months][]" value="One-Time" class="mr-2" {{ isset($groupedPaid[$fee->fee_type_id . '-One-Time']) ? 'checked disabled' : '' }}> One-Time
                    </label>
                  @else
                    <div class="flex flex-wrap gap-2 max-h-32 overflow-y-auto">
                      @for ($m = 1; $m <= 12; $m++)
                        @php
                          $monthNum = str_pad($m, 2, '0', STR_PAD_LEFT);
                          $monthName = DateTime::createFromFormat('!m', $m)->format('F');
                          $key = $fee->fee_type_id . '-' . $monthNum;
                          $isPaid = isset($groupedPaid[$key]);
                        @endphp
                        <label title="₹{{ $fee->amount }} for {{ $monthName }}"
                               class="flex items-center space-x-1 {{ $isPaid ? 'text-gray-400 line-through' : 'text-gray-700' }}">
                          <input 
                            type="checkbox"
                            class="month-checkbox"
                            name="fees[{{ $loopIndex }}][months][]"
                            value="{{ $monthNum }}"
                            data-amount="{{ $fee->amount }}"
                            @if($isPaid) checked disabled @endif
                          >
                          <span class="text-xs">{{ $monthName }}</span>
                        </label>
                      @endfor
                    </div>
                  @endif
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
    <div class="bg-white shadow-lg rounded-xl p-6 max-w-4xl mx-auto my-10">
      <div class="flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="w-full md:w-1/2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
          <div class="relative">
            <select 
              name="payment_method" 
              class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
              <option value="Cash">Cash</option>
              <option value="UPI">UPI</option>
              <option value="Card">Credit/Debit Card</option>
              <option value="Net Banking">Net Banking</option>
            </select>
          </div>
        </div>

        <div class="w-full md:w-auto mt-2 md:mt-0 mb-[-6px]">
          <button 
            type="submit"
            onclick="return confirm('Are you sure you want to submit this payment?')"
            class="w-full md:w-auto px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 flex items-center justify-center">
            Submit Payment
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

{{-- JS to handle dynamic total --}}
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

  updateTotal();
});
</script>
@endsection
v