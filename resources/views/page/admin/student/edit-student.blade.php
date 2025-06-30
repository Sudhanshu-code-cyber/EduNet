<!-- Edit Modal -->
<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-3xl relative shadow-xl overflow-y-auto max-h-[90vh]">
        <button @click="open = false" class="absolute top-3 right-4 text-gray-500 text-2xl">&times;</button>
        <h3 class="text-lg font-semibold mb-4">Edit Student</h3>
        <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            @csrf
            @method('PUT')

            <div>
                <label class="font-medium">Full Name *</label>
                <input type="text" name="full_name" value="{{ old('full_name', $student->full_name) }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="font-medium">Roll Number *</label>
                <input type="text" name="roll_no" value="{{ old('roll_no', $student->roll_no) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Admission No *</label>
                <input type="text" name="admission_no" value="{{ old('admission_no', $student->admission_no) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Class *</label>
                <input type="text" name="class_id" value="{{ old('class_id', $student->class_id) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Section</label>
                <input type="text" name="section_id" value="{{ old('section_id', $student->section_id) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Gender *</label>
                <select name="gender" class="w-full border rounded p-2">
                    <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div>
                <label class="font-medium">Date of Birth *</label>
                <input type="date" name="dob" value="{{ old('dob', $student->dob) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Age</label>
                <input type="text" name="age" value="{{ old('age', $student->age) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Blood Group</label>
                <input type="text" name="blood_group" value="{{ old('blood_group', $student->blood_group) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Religion</label>
                <input type="text" name="religion" value="{{ old('religion', $student->religion) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Father Name *</label>
                <input type="text" name="father_name" value="{{ old('father_name', $student->father_name) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Mother Name *</label>
                <input type="text" name="mother_name" value="{{ old('mother_name', $student->mother_name) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Father Occupation</label>
                <input type="text" name="father_occupation" value="{{ old('father_occupation', $student->father_occupation) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Contact *</label>
                <input type="text" name="contact" value="{{ old('contact', $student->contact) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Nationality *</label>
                <input type="text" name="nationality" value="{{ old('nationality', $student->nationality) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Present Address</label>
                <textarea name="present_address" class="w-full border rounded p-2">{{ old('present_address', $student->present_address) }}</textarea>
            </div>
            <div>
                <label class="font-medium">Permanent Address</label>
                <textarea name="permanent_address" class="w-full border rounded p-2">{{ old('permanent_address', $student->permanent_address) }}</textarea>
            </div>
            <div>
                <label class="font-medium">Email *</label>
                <input type="email" name="email" value="{{ old('email', $student->email) }}" class="w-full border rounded p-2">
            </div>

            <div class="flex items-center col-span-1 md:col-span-2">
                <input type="checkbox" name="uses_transport" class="form-checkbox" {{ old('uses_transport', $student->uses_transport) ? 'checked' : '' }}>
                <span class="ml-2">Uses Transport</span>
            </div>

            <div>
                <label class="font-medium">Photo</label>
                <input type="file" name="photo" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="font-medium">Parents Photo</label>
                <input type="file" name="parents_photo" class="w-full border rounded p-2">
            </div>
            
            <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
