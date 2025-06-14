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
        
        input:focus, select:focus, textarea:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
    </style>
 <div class=" mx-auto">
        
        
        <div class="form-container rounded">
            <!-- Student Information Section -->
            <div class="section-header px-6 py-2 bg-gray-200">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-user-graduate mr-3"></i>
                    Student Information
                </h2>
            </div>
            
           <form action="">
             <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Row 1 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            <option>Select Class</option>
                            <option>Class 1</option>
                            <option>Class 2</option>
                            <option>Class 3</option>
                            <option>Class 4</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            <option>Select Section</option>
                            <option>Section A</option>
                            <option>Section B</option>
                            <option>Section C</option>
                        </select>
                    </div>
                    
                    <!-- Row 2 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender*</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                            <option>Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date Of Birth</label>
                        <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none" placeholder="dd/mm/yyyy">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Roll</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Admission No</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>
                    
                    <!-- Row 3 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Religion</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>

                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>

                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                        <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Student Photo (150px X 150px)</label>
                        <div class="flex items-center">
                            <div class="file-upload mr-3">
                                <label class="file-label">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i> Choose File
                                    <input type="file" id="student-photo">
                                </label>
                            </div>
                            <span class="text-sm text-gray-500" id="student-file-name">No File Chosen</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Parents Information Section -->
            <div class="section-header px-6 py-4 mt-8">
                <h2 class="text-xl font-bold text-gray-900 bg-gray-200 p-2 rounded flex items-center">
                    <i class="fas fa-users mr-3"></i>
                    Parents Information
                </h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Row 1 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Father Name</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mother Name</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Father Occupation</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mother Occupation</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>
                    
                    <!-- Row 2 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nationality</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Present Address</label>
                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none" rows="2"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Permanent Address</label>
                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none" rows="2"></textarea>
                    </div>
                    
                    <!-- Row 3 -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Parents Photo (150px X 150px)</label>
                        <div class="flex items-center">
                            <div class="file-upload mr-3">
                                <label class="file-label">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i> Choose File
                                    <input type="file" id="parents-photo">
                                </label>
                            </div>
                            <span class="text-sm text-gray-500" id="parents-file-name">No File Chosen</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Buttons -->
            <div class="p-6 bg-gray-50 flex justify-end space-x-4">
                <button class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Reset
                </button>
                <button class="px-6 py-2 bg-primary bg-gray-900 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Save
                </button>
            </div>
           </form>
        </div>
    </div>

    <script>
        // File name display for student photo
        document.getElementById('student-photo').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No File Chosen';
            document.getElementById('student-file-name').textContent = fileName;
        });
        
        // File name display for parents photo
        document.getElementById('parents-photo').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No File Chosen';
            document.getElementById('parents-file-name').textContent = fileName;
        });
    </script>

@endsection