<!-- Edit Modal Trigger -->
<input type="checkbox" id="edit-modal-{{ $student->id }}" class="modal-toggle hidden peer">
<!-- Edit Modal -->
<div class="modal fixed top-0 left-0 w-full h-full flex items-center justify-center z-50 peer-checked:flex">
    <div class="modal-content relative bg-white p-6 rounded-lg shadow-md max-w-3xl w-full overflow-y-auto max-h-[90vh]">
        <!-- Close Button -->
        <label for="edit-modal-{{ $student->id }}" class="absolute top-3 right-3 text-gray-500 cursor-pointer text-xl">&times;</label>

        <h2 class="text-lg font-semibold mb-4">Edit Student Information</h2>

        <!-- Update Form -->
        <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
        
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <!-- Full Name -->
                <div>
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" value="{{ $student->full_name }}" class="w-full border rounded p-2" required>
                </div>

                <!-- Roll Number -->
                <div>
                    <label for="roll_no">Roll Number</label>
                    <input type="text" id="roll_no" name="roll_no" value="{{ $student->roll_no }}" class="w-full border rounded p-2" required>
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" class="w-full border rounded p-2" required>
                        <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" value="{{ $student->dob }}" class="w-full border rounded p-2" required>
                </div>

                <!-- Parent/Guardian -->
                <div>
                    <label for="father_name">Parent/Guardian Name</label>
                    <input type="text" id="father_name" name="father_name" value="{{ $student->father_name }}" class="w-full border rounded p-2" required>
                </div>

                <!-- Contact -->
                <div>
                    <label for="contact">Contact Number</label>
                    <input type="text" id="contact" name="contact" value="{{ $student->contact }}" class="w-full border rounded p-2" required>
                </div>

                <!-- Class -->
                <div>
                    <label for="class">Class</label>
                    <input type="text" id="class" name="class" value="{{ $student->class }}" class="w-full border rounded p-2" required>
                </div>

                <!-- Section -->
                <div>
                    <label for="section">Section</label>
                    <input type="text" id="section" name="section" value="{{ $student->section }}" class="w-full border rounded p-2">
                </div>

                <!-- Email -->
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ $student->email }}" class="w-full border rounded p-2" required>
                </div>

                <!-- Present Address -->
                <div class="md:col-span-2">
                    <label for="present_address">Address</label>
                    <textarea id="present_address" name="present_address" class="w-full border rounded p-2" rows="2">{{ $student->present_address }}</textarea>
                </div>

                <!-- Current Photo -->
                @if($student->photo)
                <div>
                    <label>Current Photo</label>
                    <div class="mt-2">
                        <img src="{{ asset('uploads/students/' . $student->photo) }}" alt="Student Photo" class="w-20 h-20 object-cover rounded">
                    </div>
                </div>
                @endif

                <!-- Upload New Photo -->
                <div>
                    <label for="photo">Change Photo</label>
                    <input type="file" id="photo" name="photo" accept="image/*" class="w-full border rounded p-2">
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-sm" onclick="document.getElementById('edit-modal-{{ $student->id }}').checked = false;">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 text-sm">Save</button>
            </div>
        </form>
    </div>
</div>