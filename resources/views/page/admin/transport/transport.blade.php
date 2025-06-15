@extends('page.admin.parent')
@section('content')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1d4ed8',
                        secondary: '#f59e0b',
                        accent: '#0ea5e9',
                        dark: '#0f172a'
                    }
                }
            }
        }
    </script>
    </head>

    <body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen p-4 md:p-6">
        <div class="max-w-7xl flex flex-col mx-auto">




            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Add Transport Form -->
                <div class="bg-white rounded shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-600 to-gray-300 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-plus-circle"></i> Add New Transport
                        </h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Route Name</label>
                                <input type="text" name="route_name" required
                                    placeholder="e.g., City Center to North Campus"
                                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Number</label>
                                    <input type="text" name="vehicle_number" required placeholder="e.g., MT988800"
                                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Capacity (km)</label>
                                    <input type="text" name="vehicle_capacity" required placeholder="e.g., 50"
                                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Driver Name</label>
                                <input type="text" name="driver_name" required placeholder="e.g., Johnathan John"
                                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">License Number</label>
                                    <input type="text" name="license_number" required placeholder="e.g., DLNC025936"
                                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="text" name="phone_number" required placeholder="e.g., +889562365846"
                                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Time</label>
                                    <input type="time" name="pickup_time" required
                                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Drop Time</label>
                                    <input type="time" name="drop_time" required
                                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>

                            <div class="flex justify-between pt-4">
                                <button type="submit"
                                    class="bg-gradient-to-r from-secondary to-amber-600 hover:from-amber-500 hover:to-amber-700 text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2 shadow-md hover:shadow-lg transition duration-300">
                                    <i class="fas fa-save"></i> Save Transport
                                </button>
                                <button type="reset"
                                    class="bg-gradient-to-r from-gray-600 to-dark hover:from-gray-700 hover:to-gray-900 text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2 shadow-md hover:shadow-lg transition duration-300">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Transport List -->
                <div class="lg:col-span-2 bg-white rounded shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-accent to-cyan-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center gap-2">
                            <i class="fas fa-list"></i> Transport List
                        </h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('transport.search') }}" method="GET">
                            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-6">
                                <div class="relative flex-1">
                                    <input type="text" name="search" placeholder="Search by Route..."
                                        value="{{ request('search') }}"
                                        class="w-full border border-gray-300 p-3 pl-10 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent">
                                    <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                                </div>

                                <button type="submit"
                                    class="bg-gradient-to-r from-primary to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2 shadow-md hover:shadow-lg transition duration-300">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>


                        <div class="overflow-auto max-h-[500px] rounded-xl border border-gray-200">
                            <table class="w-full">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr class="text-gray-700">
                                        <th class="p-3 text-left font-semibold">#</th>
                                        <th class="p-3 text-left font-semibold">Route Name</th>
                                        <th class="p-3 text-left font-semibold">Vehicle No</th>
                                        <th class="p-3 text-left font-semibold">Driver Name</th>
                                        <th class="p-3 text-left font-semibold">Driver License</th>
                                        <th class="p-3 text-left font-semibold">Contact</th>
                                        <th class="p-3 text-center font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($transport as $tran)
                                        <tr class="hover:bg-gray-50 transition duration-150">
                                            <td class="p-3 font-medium">{{ $tran->id }}</td>
                                            <td class="p-3">
                                                <div class="font-medium">{{ $tran->route_name }}</div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    <i class="fas fa-clock text-amber-500 mr-1"></i>{{ $tran->pickup_time }}
                                                    AM - {{ $tran->drop_time }} PM
                                                </div>
                                            </td>
                                            <td class="p-3">
                                                <div class="font-medium">{{ $tran->vehicle_number }}</div>
                                                <div class="text-xs text-gray-500 mt-1">Capacity:
                                                    {{ $tran->vehicle_capacity }} km</div>
                                            </td>
                                            <td class="p-3 font-medium">{{ $tran->driver_name }}</td>
                                            <td class="p-3 font-mono text-sm">{{ $tran->license_number }}</td>
                                            <td class="p-3">
                                                <div>{{ $tran->phone_number }}</div>
                                            </td>
                                            <td class="p-3">
                                                <div class="flex justify-center gap-3">
                                                    <label
                                                     for="edit-modal"
                                                        class="bg-amber-100 hover:bg-amber-200 p-2 rounded-lg text-amber-600"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </label>

                                                    <form action="{{ route('transport.delete', $tran->id) }}"
                                                        method="POST" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="bg-red-100 hover:bg-red-200 p-2 rounded-lg text-red-600"
                                                            title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-6 text-gray-500">
                                                <i class="fas fa-bus-slash text-xl text-gray-400 mr-2"></i>
                                                No transport records found.
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                        </div>

                        <div class="flex justify-between items-center mt-6">
                            <p class="text-gray-500 text-sm">
                                Showing {{ $transport->firstItem() }} to {{ $transport->lastItem() }} of
                                {{ $transport->total() }} transports
                            </p>

                            <div class="flex items-center space-x-1">
                                {{-- Previous Page --}}
                                @if ($transport->onFirstPage())
                                    <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-md cursor-not-allowed">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $transport->previousPageUrl() }}"
                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-300 text-gray-700 rounded-md transition">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($transport->links()->elements[0] as $page => $url)
                                    @if ($page == $transport->currentPage())
                                        <span
                                            class="px-4 py-2 bg-primary text-white rounded-md font-semibold shadow">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="px-4 py-2 bg-gray-100 hover:bg-gray-300 text-gray-700 rounded-md transition">{{ $page }}</a>
                                    @endif
                                @endforeach

                                {{-- Next Page --}}
                                @if ($transport->hasMorePages())
                                    <a href="{{ $transport->nextPageUrl() }}"
                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-300 text-gray-700 rounded-md transition">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-md cursor-not-allowed">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    @endsection
