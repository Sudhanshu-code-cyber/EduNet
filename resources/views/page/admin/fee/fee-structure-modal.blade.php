
<div id="feeStructureModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Add Fee Structure</h2>
            <button onclick="closeFeeModal()" class="text-gray-600 hover:text-red-600 text-xl">&times;</button>
        </div>

        <form method="POST" action="{{ route('fee-structure.store') }}">
            @csrf

            <div class="mb-4">
                <label for="class_id" class="block font-medium">Class</label>
                <select name="class_id" required class="w-full border rounded px-3 py-2">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="fee_type_id" class="block font-medium">Fee Type</label>
                <select name="fee_type_id" required class="w-full border rounded px-3 py-2">
                    <option value="">Select Fee Type</option>
                    @foreach($feeTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="amount" class="block font-medium">Amount</label>
                <input type="number" step="0.01" name="amount" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="frequency" class="block font-medium">Frequency</label>
                <select name="frequency" required class="w-full border rounded px-3 py-2">
                    <option value="monthly">Monthly</option>
                    <option value="one_time">One Time</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="start_month" class="block font-medium">Start Month</label>
                <input type="month" name="start_month" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_recurring" class="mr-2"> Recurring
                </label>
            </div>

            <div class="mb-4">
                <label for="notes" class="block font-medium">Notes (Optional)</label>
                <textarea name="notes" class="w-full border rounded px-3 py-2" rows="2"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeFeeModal()" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
            </div>
        </form>
    </div>
</div>


