@extends('page.admin.parent')


@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
        }

        .card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            background: white;
        }

        .card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }



        .student-photo {
            transition: transform 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .student-photo:hover {
            transform: scale(1.1);
            border-color: #3b82f6;
        }

        .action-btn {
            transition: all 0.2s ease;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .view-btn:hover {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .edit-btn:hover {
            background-color: rgba(245, 158, 11, 0.1);
        }

        .delete-btn:hover {
            background-color: rgba(239, 68, 68, 0.1);
        }

        .pagination-btn {
            transition: all 0.2s ease;
            min-width: 32px;
        }

        .pagination-btn:hover:not(.active) {
            background-color: #e5e7eb;
        }

        /* Modal styling with pure CSS */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25);
            transform: scale(0.9);
            opacity: 0;
            transition: all 0.3s ease;
        }

        #modal-toggle:checked~.modal {
            display: flex;
        }

        #modal-toggle:checked~.modal .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        .modal-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            padding: 20px;
            border-radius: 12px 12px 0 0;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 28px;
            color: white;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .close-btn:hover {
            transform: scale(1.2);
        }

        /* Responsive table */
        @media (max-width: 1024px) {
            .responsive-table {
                display: block;
                overflow-x: auto;
            }

            .hide-on-mobile {
                display: none;
            }
        }
    </style>
    <input type="checkbox" id="modal-toggle" class="hidden">

    <div class="max-w-7xl mx-auto">
        <!-- Header -->


        <div class="card  rounded">
            <div class="header-gradient px-6 py-3 ">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-user-graduate mr-3"></i>
                        Student Records
                    </h2>

                    <div class="mt-4 md:mt-0">
                        <button class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 flex items-center">
                            <i class="fas fa-plus mr-2"></i> Add New Student
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-5">
                <!-- Search and Filters -->
                <div class="flex flex-col md:flex-row justify-between gap-4  bg-white p-2 rounded-lg">
                    <!-- Search Input -->
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <div class="relative w-full md:w-80">
                            <input type="text" placeholder="Search by name & Roll No..."
                                class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm placeholder-gray-500">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="flex gap-2 items-center">
                        <button
                            class="flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2.5 rounded-lg shadow transition-all duration-300">
                            <i class="fas fa-search"></i>
                            <span>Search</span>
                        </button>
                    </div>
                </div>


                <!-- Table -->
                <div class="overflow-x-auto responsive-table">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-blue-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Roll</th>
                                <th class="px-4 py-3 font-semibold">Photo</th>
                                <th class="px-4 py-3 font-semibold">Name</th>
                                <th class="px-4 py-3 font-semibold">Gender</th>
                                <th class="px-4 py-3 font-semibold hide-on-mobile">Parent</th>
                                <th class="px-4 py-3 font-semibold">Class</th>
                                <th class="px-4 py-3 font-semibold">Section</th>
                                <th class="px-4 py-3 font-semibold hide-on-mobile">Address</th>
                                <th class="px-4 py-3 font-semibold hide-on-mobile">DOB</th>
                                <th class="px-4 py-3 font-semibold hide-on-mobile">Mobile</th>
                                <th class="px-4 py-3 font-semibold hide-on-mobile">Email</th>
                                <th class="px-4 py-3 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">#2901</td>
                                <td class="px-4 py-2">
                                    <img class="w-10 h-10 rounded-full mx-auto student-photo"
                                        src="https://i.pravatar.cc/40?img=1" alt="Richi Rozario">
                                </td>
                                <td class="px-4 py-3 font-medium">Richi Rozario</td>
                                <td class="px-4 py-3">Female</td>
                                <td class="px-4 py-3 hide-on-mobile">David Smith</td>
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3">A</td>
                                <td class="px-4 py-3 hide-on-mobile">TA-110, North Sydney</td>
                                <td class="px-4 py-3 hide-on-mobile">10/03/2010</td>
                                <td class="px-4 py-3 hide-on-mobile">+8812 00 5098</td>
                                <td class="px-4 py-3 hide-on-mobile">ndisons@gmail.com</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2 justify-center">
                                        <button class="text-blue-500 hover:text-blue-700 action-btn view-btn">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <label for="modal-toggle"
                                            class="text-yellow-500 hover:text-yellow-700 action-btn edit-btn cursor-pointer">
                                            <i class="fas fa-edit"></i>
                                        </label>
                                        <button class="text-red-500 hover:text-red-700 action-btn delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">#2902</td>
                                <td class="px-4 py-2">
                                    <img class="w-10 h-10 rounded-full mx-auto student-photo"
                                        src="https://i.pravatar.cc/40?img=5" alt="Alex Johnson">
                                </td>
                                <td class="px-4 py-3 font-medium">Alex Johnson</td>
                                <td class="px-4 py-3">Male</td>
                                <td class="px-4 py-3 hide-on-mobile">Michael Johnson</td>
                                <td class="px-4 py-3">2</td>
                                <td class="px-4 py-3">B</td>
                                <td class="px-4 py-3 hide-on-mobile">45 Park Avenue, New York</td>
                                <td class="px-4 py-3 hide-on-mobile">15/05/2009</td>
                                <td class="px-4 py-3 hide-on-mobile">+1234 567 890</td>
                                <td class="px-4 py-3 hide-on-mobile">alex.j@example.com</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2 justify-center">
                                        <button class="text-blue-500 hover:text-blue-700 action-btn view-btn">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <label for="modal-toggle"
                                            class="text-yellow-500 hover:text-yellow-700 action-btn edit-btn cursor-pointer">
                                            <i class="fas fa-edit"></i>
                                        </label>
                                        <button class="text-red-500 hover:text-red-700 action-btn delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">#2903</td>
                                <td class="px-4 py-2">
                                    <img class="w-10 h-10 rounded-full mx-auto student-photo"
                                        src="https://i.pravatar.cc/40?img=10" alt="Sophia Williams">
                                </td>
                                <td class="px-4 py-3 font-medium">Sophia Williams</td>
                                <td class="px-4 py-3">Female</td>
                                <td class="px-4 py-3 hide-on-mobile">Robert Williams</td>
                                <td class="px-4 py-3">3</td>
                                <td class="px-4 py-3">A</td>
                                <td class="px-4 py-3 hide-on-mobile">22 Baker Street, London</td>
                                <td class="px-4 py-3 hide-on-mobile">22/11/2010</td>
                                <td class="px-4 py-3 hide-on-mobile">+4416 3290 8745</td>
                                <td class="px-4 py-3 hide-on-mobile">sophia.w@example.com</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2 justify-center">
                                        <button class="text-blue-500 hover:text-blue-700 action-btn view-btn">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <label for="modal-toggle"
                                            class="text-yellow-500 hover:text-yellow-700 action-btn edit-btn cursor-pointer">
                                            <i class="fas fa-edit"></i>
                                        </label>
                                        <button class="text-red-500 hover:text-red-700 action-btn delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">#2904</td>
                                <td class="px-4 py-2">
                                    <img class="w-10 h-10 rounded-full mx-auto student-photo"
                                        src="https://i.pravatar.cc/40?img=7" alt="James Brown">
                                </td>
                                <td class="px-4 py-3 font-medium">James Brown</td>
                                <td class="px-4 py-3">Male</td>
                                <td class="px-4 py-3 hide-on-mobile">Thomas Brown</td>
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3">C</td>
                                <td class="px-4 py-3 hide-on-mobile">78 Sunset Blvd, Los Angeles</td>
                                <td class="px-4 py-3 hide-on-mobile">30/07/2010</td>
                                <td class="px-4 py-3 hide-on-mobile">+1555 123 4567</td>
                                <td class="px-4 py-3 hide-on-mobile">james.b@example.com</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-1 justify-center">
                                        <button class="text-blue-500 hover:text-blue-700 action-btn view-btn">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <label for="modal-toggle"
                                            class="text-yellow-500 hover:text-yellow-700 action-btn edit-btn cursor-pointer">
                                            <i class="fas fa-edit"></i>
                                        </label>
                                        <button class="text-red-500 hover:text-red-700 action-btn delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex flex-col md:flex-row justify-between items-center mt-6 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-4 md:mb-0">Showing 1 to 4 of 50 entries</p>
                    <div class="flex space-x-1">
                        <button class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 pagination-btn">&laquo;</button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded active pagination-btn">1</button>
                        <button class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 pagination-btn">2</button>
                        <button class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 pagination-btn">3</button>
                        <button class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 pagination-btn">&raquo;</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Edit Modal -->
    <div class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-xl font-bold text-white">Edit Student Information</h3>
                <label for="modal-toggle" class="close-btn">&times;</label>
            </div>

            <div class="p-6">
                <form class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Full Name</label>
                            <input type="text" class="w-full px-3 py-2 border rounded-md" value="Richi Rozario">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Roll Number</label>
                            <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100" value="#2901"
                                readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Gender</label>
                            <select class="w-full px-3 py-2 border rounded-md">
                                <option value="Female" selected>Female</option>
                                <option value="Male">Male</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Date of Birth</label>
                            <input type="date" class="w-full px-3 py-2 border rounded-md" value="2010-03-10">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Parent/Guardian</label>
                            <input type="text" class="w-full px-3 py-2 border rounded-md" value="David Smith">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Contact Number</label>
                            <input type="tel" class="w-full px-3 py-2 border rounded-md" value="+8812 00 5098">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Class</label>
                            <select class="w-full px-3 py-2 border rounded-md">
                                <option value="1" selected>Class 1</option>
                                <option value="2">Class 2</option>
                                <option value="3">Class 3</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Section</label>
                            <select class="w-full px-3 py-2 border rounded-md">
                                <option value="A" selected>Section A</option>
                                <option value="B">Section B</option>
                                <option value="C">Section C</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Email Address</label>
                        <input type="email" class="w-full px-3 py-2 border rounded-md" value="ndisons@gmail.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Address</label>
                        <textarea class="w-full px-3 py-2 border rounded-md" rows="2">TA-110, North Sydney</textarea>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                        <label for="modal-toggle"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 cursor-pointer">
                            Cancel
                        </label>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
