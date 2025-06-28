@extends('page.admin.parent')

@section('content')

{{-- ✅ Header and Button --}}
<div class="max-w-6xl mx-auto mt-12">
    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-800">Existing Fee Structures</h3>
        <button onclick="openFeeModal()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            + Add Fee Structure
        </button>
    </div>

    {{-- ✅ Filter/Search Form --}}
    <form method="GET" action="{{ route('fee-structure.index') }}" class="flex flex-wrap gap-4 mb-4" id="searchForm">
        <select name="search_class" class="border border-gray-300 rounded px-3 py-2" id="search_class">
            <option value="">All Classes</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ request('search_class') == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>

        <select name="search_fee_type" class="border border-gray-300 rounded px-3 py-2" id="search_fee_type">
            <option value="">All Fee Types</option>
            @foreach($feeTypes as $type)
                <option value="{{ $type->id }}" {{ request('search_fee_type') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 transition">Search</button>
    </form>

    {{-- ✅ Fee Structure Table --}}
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
            <tbody>
                @forelse($feeStructures as $index => $fs)
                    <tr class="border-t">
                        <td class="p-3">{{ $index + 1 }}</td>
                        <td class="p-3">{{ $fs->class->name }}</td>
                        <td class="p-3">{{ $fs->feeType->name }}</td>
                        <td class="p-3">₹{{ number_format($fs->amount, 2) }}</td>
                        <td class="p-3 capitalize">{{ $fs->frequency }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($fs->start_month)->format('M-y') }}</td>
                        <td class="p-3">{{ $fs->is_recurring ? 'Yes' : 'No' }}</td>
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

    @if(session('success'))
        <p class="mt-4 text-green-600 font-medium">{{ session('success') }}</p>
    @endif
</div>

{{-- ✅ Modal --}}
@include('page.admin.fee.fee-structure-modal')

{{-- ✅ Script --}}
<script>
    function openFeeModal() {
        document.getElementById('feeStructureModal').classList.remove('hidden');
    }

    function closeFeeModal() {
        document.getElementById('feeStructureModal').classList.add('hidden');
    }
</script>

@endsection


<script>
    window.addEventListener('DOMContentLoaded', function () {
        if (window.location.search.includes('search_class') || window.location.search.includes('search_fee_type')) {
            document.getElementById('search_class').value = '';
            document.getElementById('search_fee_type').value = '';
        }
    });
</script>
