<!-- Edit Teacher Modal -->
<div id="edit-teacher-modal-{{ $teacher->id }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full p-6">
    
    <div class="relative w-full max-w-2xl max-h-full mx-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-50 p-6">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">Edit Teacher</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="edit-teacher-modal-{{ $teacher->id }}">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data" class="pt-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- First Name -->
                    <div>
                        <label class="block mb-1 font-medium">First Name</label>
                        <input type="text" name="first_name" value="{{ $teacher->first_name }}"
                            class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block mb-1 font-medium">Last Name</label>
                        <input type="text" name="last_name" value="{{ $teacher->last_name }}"
                            class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block mb-1 font-medium">Email</label>
                        <input type="email" name="email" value="{{ $teacher->email }}"
                            class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block mb-1 font-medium">Phone</label>
                        <input type="text" name="phone" value="{{ $teacher->phone }}"
                            class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    <!-- Class -->
                    <div>
                        <label class="block mb-1 font-medium">Class</label>
                        <input type="text" name="class" value="{{ $teacher->class }}"
                            class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    <!-- Section -->
                    <div>
                        <label class="block mb-1 font-medium">Section</label>
                        <input type="text" name="section" value="{{ $teacher->section }}"
                            class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block mb-1 font-medium">Address</label>
                        <textarea name="address" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">{{ $teacher->address }}</textarea>
                    </div>

                    <!-- Short Bio -->
                    <div>
                        <label class="block mb-1 font-medium">Short Bio</label>
                        <textarea name="short_bio" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">{{ $teacher->short_bio }}</textarea>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block mb-1 font-medium">Gender</label>
                        <select name="gender" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                            <option value="Male" {{ $teacher->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $teacher->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $teacher->gender == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Photo -->
                    <div>
                        <label class="block mb-1 font-medium">Photo</label>
                        <input type="file" name="photo"
                            class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                        @if($teacher->photo)
                            <img src="{{ asset('storage/' . $teacher->photo) }}" class="h-16 w-16 mt-2 rounded-full object-cover" alt="Current Photo">
                        @endif
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
