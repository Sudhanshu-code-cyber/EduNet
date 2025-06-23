@extends('page.admin.parent')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-white p-6">
        <div class="max-w-7xl mx-auto">

            <div class="flex items-center justify-between mb-10">
                <h1 class="text-4xl font-extrabold text-blue-800 tracking-tight">📢 Notice Board</h1>
                <button onclick="openModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-lg transition duration-300 ease-in-out">
                    + Add New Notice
                </button>
            </div>

            <!-- Search Section -->
            <section class="bg-white rounded-2xl shadow-xl p-8 mb-10">
                <h2 class="text-2xl font-bold text-blue-700 mb-6">🔍 Search Notices</h2>
                <form method="GET" action="{{ route('notice.search') }}"
                    class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                        <div>
                            <label for="title" class="text-gray-700 font-medium">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                            @error('title')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    
                    <div>
                        <label for="search_date" class="block text-gray-700 font-medium mb-2">Date</label>
                        <input type="date" name="search_date" id="search_date" value="{{ request('search_date') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-300 ease-in-out">
                            Search
                        </button>
                    </div>
                </form>
            </section>

            <!-- Notices List -->
            <section class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-blue-700 mb-6">📄 Notices</h2>

                <ul class="divide-y divide-gray-200">
                    @forelse($notices as $notice)
                        @if (!$notice->expires_at || $notice->expires_at >= now())
                            <li class="py-6 px-4 hover:bg-gray-50 rounded-lg transition flex flex-col md:flex-row justify-between items-start md:items-center">
                                <div class="flex-1 space-y-2">
                                    <h3 class="text-xl font-semibold text-blue-700">{{ $notice->title }}</h3>
                                    <p class="text-gray-800 whitespace-pre-line">{{ $notice->details }}</p>
                                    <div class="text-sm text-gray-500 space-x-4">
                                        <span><strong>Posted By:</strong> {{ $notice->created_by }}</span>
                                        <span><strong>Date:</strong> {{ $notice->date }}</span>
                                    </div>
                                </div>
                                <div class="flex gap-3 mt-4 md:mt-0 md:ml-6">
                                    @if($notice->created_by == auth()->id())
                                        <a href="{{ route('notice.edit', $notice->id) }}"
                                            class="text-blue-600 hover:underline font-semibold">Edit</a>
                                
                                        <form method="POST" action="{{ route('notice.destroy', $notice->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline font-semibold"
                                                onclick="return confirm('Are you sure you want to delete this notice?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                
                            </li>
                        @endif
                    @empty
                        <li class="flex items-center justify-center py-10 bg-blue-50 text-blue-600 font-medium rounded-lg shadow-inner">
                            <i class="fas fa-info-circle mr-2"></i>
                            No notices found.
                        </li>
                    @endforelse
                </ul>

                <div class="text-sm text-gray-600 mt-6">Total Notices: {{ $notices->count() }}</div>

                <div class="mt-4">
                    {{ $notices->links() }}
                </div>
            </section>

            <!-- Modal for Create Notice -->
            <div id="noticeModal" class="fixed inset-0 z-50 hidden items-center justify-center">
                <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal()"></div>
                <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-xl mx-auto z-50 overflow-y-auto max-h-[90vh]">
                    <h2 class="text-2xl font-bold text-blue-700 mb-6">📝 Create Notice</h2>

                    <form method="POST" action="{{ route('notice.store') }}" class="space-y-5">
                        @csrf
                    
                        <!-- Title input -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="text-gray-700 font-medium">Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                @error('title')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="posted_by" class="text-gray-700 font-medium">Posted By</label>
                                <input type="text" name="posted_by" id="posted_by" value="{{ old('posted_by', auth()->user()?->name) }}" readonly
                                class="w-full border border-gray-300 bg-gray-100 cursor-not-allowed rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">                            
                                @error('posted_by')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    
                        <!-- Details and Date -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div class="col-span-2">
                                <label for="details" class="text-gray-700 font-medium">Details</label>
                                <textarea name="details" id="details" rows="4" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('details') }}</textarea>
                                @error('details')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                    
                            <div>
                                <label for="date" class="text-gray-700 font-medium">Date</label>
                                <input type="date" name="date" id="date"
                                    value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                @error('date')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    
                        <!-- Hidden Fields -->
                        <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                        <input type="hidden" name="creator_role" value="admin">
                        <input type="hidden" name="target" value="teacher">
                        <input type="hidden" name="expires_at" value="{{ \Carbon\Carbon::now()->addDays(30) }}">
                    
                        <!-- Form Buttons -->
                        <div class="flex justify-end gap-4 pt-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition">Save</button>
                            <button type="reset"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-lg">Reset</button>
                            <button type="button" onclick="closeModal()"
                                class="text-red-600 hover:underline font-semibold">Cancel</button>
                        </div>
                    </form>
                    
                </div>
            </div>

        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('noticeModal').classList.remove('hidden');
            document.getElementById('noticeModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('noticeModal').classList.add('hidden');
            document.getElementById('noticeModal').classList.remove('flex');
        }
    </script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
