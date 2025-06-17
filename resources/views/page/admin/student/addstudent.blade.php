@extends('page.admin.parent')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }

        .form-container {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            background: white;
        }

        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .file-label {
            display: inline-block;
            padding: 8px 16px;
            background-color: #f3f4f6;
            border: 1px dashed #d1d5db;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-label:hover {
            background-color: #e5e7eb;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
    </style>

    <div class="mx-auto">
        <div class="form-container rounded">
            <!-- Student Information Section -->
            <div class="section-header px-6 py-2 bg-gray-200">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-user-graduate mr-3"></i>
                    Student Information
                </h2>
            </div>

            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Row 1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="full_name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                            <select name="class"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        <option value="" disabled selected>Select class</option>
                        <option>Nursery</option>
                        <option>LKG</option>
                        <option>UKG</option>
                        <option>1</option>
                        <option>2</option>
                    </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                            <select name="section"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                                <option value="">Select Section</option>
                                <option> A</option>
                                <option> B</option>
                                <option> C</option>
                                <option> D</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender*</label>
                            <select name="gender" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                                <option value="">Select Gender</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <!-- Row 2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date Of Birth</label>
                            <input type="date" name="dob" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Roll No</label>
                            <input type="text" name="roll_no" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>

<!--  Transport Checkbox (NEW) -->
<div class="flex items-center mt-8">
    <input type="checkbox" id="uses_transport" name="uses_transport"
        class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
    <label for="uses_transport" class="ml-2 text-sm text-gray-700">Uses Transport Facility?</label>
</div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Admission No</label>
                            <input type="text" name="admission_no" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>

                        <!-- Row 3 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Religion</label>
                            <select name="religion"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        <option value="" disabled selected>Select religion</option>
                        <option>Hindu</option>
                        <option>Muslim</option>
                        <option>Christian</option>
                        <option>Sikh</option>
                        <option>Other</option>
                    </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label>
                            <select name="blood_group"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            <option value="" disabled selected>Select blood group</option>
                            <option>A+</option>
                            <option>A-</option>
                            <option>B+</option>
                            <option>B-</option>
                            <option>O+</option>
                            <option>O-</option>
                            <option>AB+</option>
                            <option>AB-</option>
                        </select>
                            
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                            <input type="text" name="age" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                            <input type="email" name="email" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>


                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Student Photo</label>
                            <input type="file" name="photo" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- Parents Info -->
                <div class="section-header px-6 py-4 mt-8">
                    <h2 class="text-xl font-bold text-gray-900 bg-gray-200 p-2 rounded flex items-center">
                        <i class="fas fa-users mr-3"></i> Parents Information
                    </h2>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Father Name</label>
                            <input type="text" name="father_name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mother Name</label>
                            <input type="text" name="mother_name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Father Occupation</label>
                            <input type="text" name="father_occupation"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="contact" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nationality</label>
                            <input type="text" name="nationality" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Present Address</label>
                            <textarea name="present_address"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none" rows="2"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Permanent Address</label>
                            <textarea name="permanent_address"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none" rows="2"></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Parents Photo</label>
                            <input type="file" name="parents_photo" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="p-6 bg-gray-50 flex justify-end space-x-4">
                    <button type="reset"
                        class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Reset
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // File name display for student photo
        document.querySelector('input[name="photo"]').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No File Chosen';
            document.getElementById('student-file-name').textContent = fileName;
        });

        // File name display for parents photo
        document.querySelector('input[name="parents_photo"]').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No File Chosen';
            document.getElementById('parents-file-name').textContent = fileName;
        });
    </script>
@endsection