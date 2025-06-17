@extends('page.admin.parent')

@section('content')

<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Define Fee Structure</h2>
    <form method="POST" action="{{ route('fee-structure.store') }}" class="space-y-4">
        @csrf
        
        <div>
            <label for="class_id" class="block mb-1 font-medium text-gray-700">Class</label>
            <select 
                name="class_id" 
                id="class_id"
                class="w-full rounded-md border border-gray-300 px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                required
            >
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="fee_type_id" class="block mb-1 font-medium text-gray-700">Fee Type</label>
            <select 
                name="fee_type_id" 
                id="fee_type_id"
                class="w-full rounded-md border border-gray-300 px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                required
            >
                @foreach($feeTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->frequency }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="amount" class="block mb-1 font-medium text-gray-700">Amount</label>
            <input 
                type="number" 
                name="amount" 
                id="amount" 
                placeholder="Amount"
                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                required
            >
        </div>

        <div>
            <label for="start_month" class="block mb-1 font-medium text-gray-700">Start Month</label>
            <input 
                type="month" 
                name="start_month" 
                id="start_month"
                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                required
            >
        </div>

        <div>
            <label for="frequency" class="block mb-1 font-medium text-gray-700">Frequency</label>
            <select 
                name="frequency" 
                id="frequency"
                class="w-full rounded-md border border-gray-300 px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                required
            >
                <option value="monthly">Monthly</option>
                <option value="one_time">One-time</option>
            </select>
        </div>

        <div class="flex items-center mb-4">
            <input 
                type="checkbox" 
                name="is_recurring" 
                id="is_recurring" 
                class="mr-2 leading-tight"
            >
            <label for="is_recurring" class="text-gray-700">Recurring?</label>
        </div>

        <div>
            <label for="notes" class="block mb-1 font-medium text-gray-700">Notes (optional)</label>
            <textarea 
                name="notes" 
                id="notes" 
                placeholder="Notes (optional)"
                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                rows="4"
            ></textarea>
        </div>

        <button 
            type="submit" 
            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-md shadow-md transition focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1"
        >
            Save
        </button>
    </form>

    @if(session('success'))
        <p class="mt-4 text-green-600 font-medium">{{ session('success') }}</p>
    @endif
</div>

{{-- Fee Structure List --}}
<div class="max-w-6xl mx-auto mt-12">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Existing Fee Structures</h3>
    <form method="GET" action="{{ route('fee-structure.index') }}" class="flex flex-wrap gap-4 justify-between items-center mb-4">
        <div class="flex gap-2">
            <select name="search_class" class="border border-gray-300 rounded px-3 py-2">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('search_class') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
    
            <select name="search_fee_type" class="border border-gray-300 rounded px-3 py-2">
                <option value="">All Fee Types</option>
                @foreach($feeTypes as $type)
                    <option value="{{ $type->id }}" {{ request('search_fee_type') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Search</button>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full bg-white shadow-md rounded-md overflow-hidden">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Class</th>
                    <th class="p-3">Fee Type</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Frequency</th>
                    <th class="p-3">Start</th>
                    <th class="p-3">Recurring</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody class="max-h-60 overflow-y-auto">
                @forelse($feeStructures as $index => $fs)
                    <tr class="border-t">
                        <td class="p-3">{{ $index + 1 }}</td>
                        <td class="p-3">{{ $fs->class->name }}</td>
                        <td class="p-3">{{ $fs->feeType->name }}</td>
                        <td class="p-3">₹{{ number_format($fs->amount, 2) }}</td>
                        <td class="p-3 capitalize">{{ $fs->frequency }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($fs->start_month)->format('M-y') }}</td>
                        <td class="p-3">
                            {{ $fs->is_recurring ? 'Yes' : 'No' }}
                        </td>
                        <td class="p-3">
                            <form method="POST" action="{{ route('fee-structure.destroy', $fs->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="p-3 text-center text-gray-500">No fee structures found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
