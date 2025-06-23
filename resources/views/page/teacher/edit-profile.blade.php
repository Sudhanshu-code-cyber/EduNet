@extends('page.teacher.parent')

@section('content')
    <div class="max-w-xl mx-auto mt-12 bg-white rounded-2xl shadow-lg p-8 transition-all duration-300">
    <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">🛠️ Edit Profile</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('teacher.profile.update') }}" class="space-y-6">
        @csrf

        {{-- Name (read-only) --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">👤 Name</label>
            <input type="text" value="{{ $teacher->name }}" disabled
                   class="w-full p-3 border border-gray-300 bg-gray-100 text-gray-700 rounded-lg focus:outline-none cursor-not-allowed">
        </div>

        {{-- Email (read-only) --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">📧 Email</label>
            <input type="email" value="{{ $teacher->email }}" disabled
                   class="w-full p-3 border border-gray-300 bg-gray-100 text-gray-700 rounded-lg focus:outline-none cursor-not-allowed">
        </div>

        {{-- Contact --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">📞 Contact Number</label>
            <input type="text" name="contact" value="{{ old('contact', $teacher->contact) }}" required
                   placeholder="Enter your contact number"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
        </div>

        {{-- New Password --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">🔑 New Password</label>
            <input type="password" name="password"
                   placeholder="Leave blank if not changing"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
        </div>

        {{-- Confirm Password --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">🔁 Confirm Password</label>
            <input type="password" name="password_confirmation"
                   placeholder="Confirm new password"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
        </div>

        {{-- Submit Button --}}
        <div class="pt-4">
            <button type="submit"
                    class="w-full py-3 bg-blue-600 text-white text-lg font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-all">
                💾 Save Changes
            </button>
        </div>
    </form>
</div>
@endsection


