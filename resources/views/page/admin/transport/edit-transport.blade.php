<!-- Modal -->
<div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div @click.away="open = false" class="bg-white p-6 rounded-lg shadow-md w-full max-w-xl mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Edit Transport</h2>
            <button @click="open = false" class="text-gray-600 hover:text-gray-800 text-2xl">×</button>
        </div>

        <form action="{{ route('transport.update', $tran->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Route
                        Name</label>
                    <input type="text" name="route_name" value="{{ $tran->route_name }}"
                        class="mt-1 block w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Pickup
                        Time</label>
                    <input type="time" name="pickup_time" value="{{ $tran->pickup_time }}"
                        class="mt-1 block w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Drop
                        Time</label>
                    <input type="time" name="drop_time" value="{{ $tran->drop_time }}"
                        class="mt-1 block w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Vehicle
                        Number</label>
                    <input type="text" name="vehicle_number" value="{{ $tran->vehicle_number }}"
                        class="mt-1 block w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Vehicle
                        Capacity</label>
                    <input type="number" name="vehicle_capacity" value="{{ $tran->vehicle_capacity }}"
                        class="mt-1 block w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Driver
                        Name</label>
                    <input type="text" name="driver_name" value="{{ $tran->driver_name }}"
                        class="mt-1 block w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">License
                        Number</label>
                    <input type="text" name="license_number" value="{{ $tran->license_number }}"
                        class="mt-1 block w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Phone
                        Number</label>
                    <input type="text" name="phone_number" value="{{ $tran->phone_number }}"
                        class="mt-1 block w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-amber-500 text-white px-4 py-2 rounded hover:bg-amber-600">Update</button>
            </div>
        </form>
    </div>
</div>
