@extends('page.student.parent')

@section('content')
<div class="p-6 space-y-8">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold text-gray-800">Payment History</h1>
        <a href="{{ route('student.fees.overview') }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-800 transition">
           Back to Overview
        </a>
    </div>

    {{-- Student Info --}}
    <div class="bg-white shadow-md rounded-2xl p-6 flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
        <img src="{{ $student->photo ? asset('uploads/students/' . $student->photo) : 'https://i.pravatar.cc/150?img=1' }}"
             class="w-28 h-28 rounded-full object-cover border-4 border-indigo-500 shadow-md">
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

    {{-- Payment History Table --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-700 mb-4">Past Fee Payments</h3>

{{-- Filters --}}
<form method="GET" action="{{ route('student.payment-history') }}" class="bg-white shadow rounded-lg p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700">From Date</label>
        <input type="date" name="from" value="{{ request('from') }}" class="w-full mt-1 p-2 border rounded">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700">To Date</label>
        <input type="date" name="to" value="{{ request('to') }}" class="w-full mt-1 p-2 border rounded">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700">Fee Type</label>
        <select name="fee_type_id" class="w-full mt-1 p-2 border rounded">
            <option value="">All</option>
            @foreach($feeTypes as $feeType)
                <option value="{{ $feeType->id }}" {{ request('fee_type_id') == $feeType->id ? 'selected' : '' }}>
                    {{ $feeType->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700">Payment Method</label>
        <select name="payment_method" class="w-full mt-1 p-2 border rounded">
            <option value="">All</option>
            <option value="Cash" {{ request('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
            <option value="Online" {{ request('payment_method') == 'Online' ? 'selected' : '' }}>Online</option>
            <option value="UPI" {{ request('payment_method') == 'UPI' ? 'selected' : '' }}>UPI</option>
        </select>
    </div>

    <div class="md:col-span-4 flex justify-end space-x-2 mt-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-800 transition">
            Filter
        </button>
        <a href="{{ route('student.payment-history') }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition">
            Reset
        </a>
    </div>
</form>


        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-collapse">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">Date</th>
                        <th class="p-3 border">Fee Type</th>
                        <th class="p-3 border">Months</th>
                        <th class="p-3 border">Amount (₹)</th>
                        <th class="p-3 border">Method</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $index => $payment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 border">{{ $loop->iteration }}</td>
                            <td class="p-3 border">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}</td>
                            <td class="p-3 border">{{ $payment->feeType->name ?? '-' }}</td>
                            <td class="p-3 border">
                               @php
    $months = is_array($payment->months)
        ? $payment->months
        : (json_decode($payment->months, true) ?? []);
@endphp
                                <div class="flex flex-wrap gap-1">
                                   @if(!empty($months))
    @foreach($months as $m)
        <span class="bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded">
            {{ $m === 'One-Time' ? 'One-Time' : \Carbon\Carbon::createFromFormat('!m', (int)$m)->format('M') }}
        </span>
    @endforeach
@else
    <span class="text-gray-400 italic text-sm">N/A</span>
@endif
                                </div>
                            </td>
                            <td class="p-3 border">₹{{ number_format($payment->amount, 2) }}</td>
                            <td class="p-3 border">{{ $payment->payment_method }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">No payments made yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
