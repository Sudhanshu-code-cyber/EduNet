 <!-- Edit Modal -->
                <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg p-6 w-full max-w-2xl relative shadow-xl overflow-y-auto max-h-[90vh]">
                        <button @click="open = false" class="absolute top-3 right-4 text-gray-500 text-2xl">&times;</button>
                        <h3 class="text-lg font-semibold mb-4">Edit Student</h3>
                        <form action="{{ route('student.update', $student->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="font-medium">Full Name</label>
                                <input type="text" name="full_name" value="{{ $student->full_name }}" class="w-full border rounded p-2" required>
                            </div>
                            <div>
                                <label class="font-medium">Roll Number</label>
                                <input type="text" name="roll_no" value="{{ $student->roll_no }}" class="w-full border rounded p-2">
                            </div>
                            <div>
                                <label class="font-medium">Gender</label>
                                <select name="gender" class="w-full border rounded p-2">
                                    <option {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="font-medium">Date of Birth</label>
                                <input type="date" name="dob" value="{{ $student->dob }}" class="w-full border rounded p-2">
                            </div>
                            <div>
                                <label class="font-medium">Class</label>
                                <input type="text" name="class" value="{{ $student->class }}" class="w-full border rounded p-2">
                            </div>
                            <div>
                                <label class="font-medium">Section</label>
                                <input type="text" name="section" value="{{ $student->section }}" class="w-full border rounded p-2">
                            </div>
                            <div>
                                <label class="font-medium">Contact</label>
                                <input type="text" name="contact" value="{{ $student->contact }}" class="w-full border rounded p-2">
                            </div>
                            <div>
                                <label class="font-medium">Email</label>
                                <input type="email" name="email" value="{{ $student->email }}" class="w-full border rounded p-2">
                            </div>
                            <div class="md:col-span-2">
                                <label class="font-medium">Address</label>
                                <textarea name="address" rows="2" class="w-full border rounded p-2">{{ $student->present_address }}</textarea>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="uses_transport" class="form-checkbox"
                                           {{ $student->uses_transport ? 'checked' : '' }}>
                                    <span class="ml-2">Uses Transport</span>
                                </label>
                            </div>
                            

                            <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                                <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                            </div>
                        </form>
                    </div>
                </div>