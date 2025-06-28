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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
                            <input type="text" name="full_name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('full_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Class Dropdown -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                            <select id="class_id" name="class_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                                <option value="" disabled selected>Select class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Section Dropdown -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                            <select id="section_id" name="section_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                                <option value="" disabled selected>Select section</option>
                            </select>
                            @error('section_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender*</label>
                            <select name="gender"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                                <option value="">Select Gender</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                            @error('gender')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Row 2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date Of Birth</label>
                            <input type="date" name="dob"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('dob')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Roll No</label>
                            <input type="text" name="roll_no"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('roll_no')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Transport Checkbox -->
                        <div class="flex items-center mt-8">
                            <input type="checkbox" id="uses_transport" name="uses_transport" value="1"
                                class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                {{ old('uses_transport') ? 'checked' : '' }}>
                            <label for="uses_transport" class="ml-2 text-sm text-gray-700">Uses Transport Facility?</label>
                            @error('uses_transport')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Admission No</label>
                            <input type="text" name="admission_no"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('admission_no')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
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
                            @error('religion')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
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
                            @error('blood_group')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                            <input type="text" name="age"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('age')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                            <input type="email" name="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Student Photo</label>
                            <input type="file" name="photo" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('photo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
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
                            <input type="text" name="father_name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('father_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mother Name</label>
                            <input type="text" name="mother_name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('mother_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Father Occupation</label>
                            <input type="text" name="father_occupation"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('father_occupation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="contact"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('contact')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nationality</label>
                            <input type="text" name="nationality"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('nationality')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Present Address</label>
                            <textarea name="present_address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none"
                                rows="2"></textarea>
                            @error('present_address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Permanent Address</label>
                            <textarea name="permanent_address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none"
                                rows="2"></textarea>
                            @error('permanent_address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Parents Photo</label>
                            <input type="file" name="parents_photo" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            @error('parents_photo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Transport Dropdown -->
                <div id="transport_select_container" class="p-6  {{ old('uses_transport') ? '' : 'hidden' }}">
                    <div class="section-headertext-xl font-bold text-gray-900 bg-gray-200 p-2 rounded flex items-center">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-bus mr-3 "></i>
                            Transport Information
                        </h2>
                    </div>

                    <div class="mt-5">
                        <label for="transport_id" class="block  text-sm font-medium text-gray-700 mb-1">Route List</label>
                        <select name="transport_id" id="transport_id" class="w-full">
                            <option value="" class="p-4">Select route...</option>
                            @foreach ($transports as $transport)
                                <option value="{{ $transport->id }}" data-route="{{ $transport->route_name }}"
                                    data-vehicle="{{ $transport->vehicle_number }}"
                                    {{ old('transport_id') == $transport->id ? 'selected' : '' }}>
                                    {{ $transport->route_name }} ({{ $transport->vehicle_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('transport_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
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

    <script>
        $(document).ready(function() {
            // Class-Section AJAX
            $('#class_id').on('change', function() {
                const classId = $(this).val();
                $('#section_id').html('<option value="">Loading...</option>');

                if (classId) {
                    $.ajax({
                        url: `/sections/by-class/${classId}`,
                        type: 'GET',
                        success: function(data) {
                            $('#section_id').empty().append(
                                '<option value="" disabled selected>Select section</option>'
                            );
                            $.each(data, function(i, section) {
                                $('#section_id').append(
                                    `<option value="${section.id}">${section.name}</option>`
                                );
                            });
                        },
                        error: function() {
                            $('#section_id').html(
                                '<option value="" disabled selected>Error loading sections</option>'
                            );
                        }
                    });
                } else {
                    $('#section_id').html('<option value="" disabled selected>Select section</option>');
                }
            });

            // Transport Select2 with search
            $('#transport_id').select2({
                width: '100%',
                placeholder: "Search for a route...",
                allowClear: true,
                minimumResultsForSearch: 3,
                templateResult: formatTransportOption,
                templateSelection: formatTransportOption
            });

            function formatTransportOption(option) {
                if (!option.id) {
                    return option.text;
                }
                const route = $(option.element).data('route');
                const vehicle = $(option.element).data('vehicle');
                return $(`
                    <div class="leading-tight">
                        <div class="font-semibold">${route}</div>
                        <div class="text-sm text-gray-500">${vehicle}</div>
                    </div>
                `);
            }

            // Toggle transport dropdown
            function toggleTransport() {
                const isChecked = $('#uses_transport').is(':checked');
                $('#transport_select_container').toggleClass('hidden', !isChecked);
                if (!isChecked) {
                    $('#transport_id').val(null).trigger('change');
                }
            }

            // Initialize transport visibility
            toggleTransport();

            // Bind change event
            $('#uses_transport').change(toggleTransport);
        });
    </script>
@endsection
