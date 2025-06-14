 <!-- Edit Modal -->
    <div class="modal ">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-xl font-bold text-white">Edit Student Information</h3>
                <label for="modal-toggle" class="close-btn">&times;</label>
            </div>

            <form action="{{ route('student.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Use PUT for updating -->

                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Full Name</label>
                            <input type="text" name="full_name" class="w-full px-3 py-2 border rounded-md"
                                value="{{ $student->full_name }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Roll Number</label>
                            <input type="text" name="roll_no" class="w-full px-3 py-2 border rounded-md bg-gray-100"
                                value="{{ $student->roll_no }}" readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Gender</label>
                            <select name="gender" class="w-full px-3 py-2 border rounded-md">
                                <option value="Female" {{ $student->gender === 'Female' ? 'selected' : '' }}>Female
                                </option>
                                <option value="Male" {{ $student->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Other" {{ $student->gender === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Date of Birth</label>
                            <input type="date" name="dob" class="w-full px-3 py-2 border rounded-md"
                                value="{{ $student->dob }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Parent/Guardian</label>
                            <input type="text" name="father_name" class="w-full px-3 py-2 border rounded-md"
                                value="{{ $student->father_name }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Contact Number</label>
                            <input type="tel" name="contact" class="w-full px-3 py-2 border rounded-md"
                                value="{{ $student->contact }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Class</label>
                            <select name="class" class="w-full px-3 py-2 border rounded-md">
                                <option value="1" {{ $student->class == 1 ? 'selected' : '' }}>Class 1</option>
                                <option value="2" {{ $student->class == 2 ? 'selected' : '' }}>Class 2</option>
                                <option value="3" {{ $student->class == 3 ? 'selected' : '' }}>Class 3</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Section</label>
                            <select name="section" class="w-full px-3 py-2 border rounded-md">
                                <option value="A" {{ $student->section == 'A' ? 'selected' : '' }}>Section A</option>
                                <option value="B" {{ $student->section == 'B' ? 'selected' : '' }}>Section B</option>
                                <option value="C" {{ $student->section == 'C' ? 'selected' : '' }}>Section C</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Email Address</label>
                        <input type="email" name="email" class="w-full px-3 py-2 border rounded-md"
                            value="{{ $student->email }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Address</label>
                        <textarea name="present_address" class="w-full px-3 py-2 border rounded-md" rows="2">{{ $student->present_address }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                        <label for="modal-toggle"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 cursor-pointer">
                            Cancel
                        </label>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>