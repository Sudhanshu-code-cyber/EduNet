@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-blue-800">Notice Board</h1>
            <button onclick="openModal()" class="bg-blue-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Add New Notice
            </button>
        </div>

        <!-- Search Section -->
        <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-6 text-blue-700">Search Notices</h2>
            <form method="GET" action="{{ route('teacher.notice.search') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label for="search_title" class="block text-gray-700 font-medium mb-1">Title</label>
                    <input type="text" name="search_title" id="search_title" value="" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by title">
                </div>
                <div>
                    <label for="search_date" class="block text-gray-700 font-medium mb-1">Date</label>
                    <input type="date" name="search_date" id="search_date" value="" class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mt-6 sm:mt-auto">
                    <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-blue-700 transition">
                        Search
                    </button>
                </div>
            </form>
        </section>

        <!-- Notices List -->
        <section class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold mb-6 text-blue-700">Notices</h2>
            <ul>
                @foreach($notices as $notice)
                <li class="py-4 border-b hover:bg-gray-100 transition flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-blue-600 mb-1">{{ $notice->title }}</h3>
                        <p class="text-gray-800 mb-2 whitespace-pre-line">{{ $notice->details }}</p>
                        <div class="text-sm text-gray-500 flex flex-wrap gap-4">
                          {{ $notice->creator->name ?? 'Unknown' }}
                            <span><strong>Date:</strong> {{ \Carbon\Carbon::parse($notice->date)->format('M d, Y') }}</span>
                        </div>
                        @if($notice->attachment)
    <div class="mt-2">
        <a href="{{ Storage::url($notice->attachment) }}" target="_blank"
           class="text-sm text-indigo-600 hover:underline">
            📎 Download Attachment
        </a>
    </div>
@endif

                    </div>
                    <div class="flex gap-2">
                        @if ($notice->created_by == auth()->id())
                        <a href="javascript:void(0);" 
                           onclick='openEditModal(@json($notice))' 
                           class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('teacher.notice.destroy', $notice->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this notice?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white hover:bg-red-700 px-3 py-1 rounded-md transition">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="mt-6">
                {{ $notices->links() }}
                <p class="text-sm text-gray-500 mt-2">Total Notices: {{ $notices->total() }}</p>
            </div>
        </section>

        <!-- Modal: Create/Edit Notice -->
        <div id="noticeModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal()"></div>
            <div class="bg-white rounded-lg shadow-lg p-6 z-10 w-11/12 sm:w-1/2 relative max-h-screen overflow-y-auto">
                <h2 class="text-2xl font-semibold mb-4 text-blue-700" id="modalTitle">Create Notice</h2>

              <form method="POST" enctype="multipart/form-data" id="noticeForm" class="space-y-4">
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="edit_notice_id" name="edit_notice_id">

                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="w-full sm:w-1/2">
                            <label for="title" class="block text-gray-700 font-medium mb-1">Title</label>
                            <input type="text" name="title" id="title" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="w-full sm:w-1/2">
                            <label for="posted_by" class="block text-gray-700 font-medium mb-1">Posted By</label>
                            <input type="text" id="posted_by" name="posted_by" readonly value="{{ auth()->user()->name }}" class="w-full border border-gray-200 bg-gray-100 rounded-md px-3 py-2">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="w-full sm:w-2/3">
                            <label for="details" class="block text-gray-700 font-medium mb-1">Details</label>
                            <textarea name="details" id="details" rows="3" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="w-full sm:w-1/3">
                            <label for="date" class="block text-gray-700 font-medium mb-1">Date</label>
                            <input type="date" name="date" id="date" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ now()->format('Y-m-d') }}">
                        </div>
                    </div>

<div class="w-full">
    <label for="attachment" class="block text-gray-700 font-medium mb-1">Attach Document</label>
    <input type="file" name="attachment" id="attachment"
           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>

                    <div class="flex gap-4 mt-4">
                        <button type="submit" class="bg-blue-600 text-white font-semibold px-5 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Save
                        </button>
                        <button type="reset" class="bg-gray-300 text-gray-700 font-semibold px-5 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">
                            Reset
                        </button>
                        <button type="button" onclick="closeModal()" class="ml-auto text-red-600 hover:underline font-semibold">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalTitle').textContent = 'Create Notice';
        document.getElementById('noticeModal').classList.remove('hidden');

        const form = document.getElementById('noticeForm');
        form.action = "{{ route('teacher.notice.store') }}";
        document.getElementById('formMethod').value = 'POST';

        form.reset();
        document.getElementById('posted_by').value = "{{ auth()->user()->name }}";
    }

    function closeModal() {
        document.getElementById('noticeModal').classList.add('hidden');
    }

    function openEditModal(notice) {
        document.getElementById('modalTitle').textContent = 'Edit Notice';
        const form = document.getElementById('noticeForm');

        document.getElementById('title').value = notice.title;
        document.getElementById('details').value = notice.details;
        document.getElementById('date').value = notice.date;
        document.getElementById('posted_by').value = "{{ auth()->user()->name }}";

        form.action = `/teacher/notice/${notice.id}`;
        document.getElementById('formMethod').value = 'PUT';

        // Clear previous file input (can't set file input for security reasons)
        document.getElementById('attachment').value = '';

        // Clear any previous existing file link (optional cleanup)
        const oldLink = document.getElementById('existingAttachmentLink');
        if (oldLink) oldLink.remove();

        // Show existing file link if exists
        if (notice.attachment) {
            const attachEl = document.createElement('div');
            attachEl.className = 'mt-2 text-sm text-gray-600';
            attachEl.id = 'existingAttachmentLink';
            attachEl.innerHTML = `Existing File: <a href="/storage/${notice.attachment}" target="_blank" class="text-blue-600 underline">Download</a>`;
            document.getElementById('attachment').parentNode.appendChild(attachEl);
        }

        document.getElementById('noticeModal').classList.remove('hidden');
    }

</script>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
