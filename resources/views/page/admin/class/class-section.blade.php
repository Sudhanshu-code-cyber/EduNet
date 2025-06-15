@extends('page.admin.parent')

@section('content')
    <div class="min-h-screen flex flex-col">


        <!-- Main Content -->
        <div class="flex flex-1">


            <main class="flex-1 p-4 md:p-8">
                <!-- Page Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Class Management</h2>
                    <p class="text-gray-600">Add and manage class sections</p>
                </div>

                <!-- Content Container -->
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Form Section -->
                    <div class="w-full lg:w-5/12 xl:w-4/12">
                        <div class="bg-white text-gray-800 p-6 rounded-xl shadow-xl">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold">Add Class Section</h3>
                            </div>

                            <form action="{{ route('admin.storeSection') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="class" class="block text-sm font-medium mb-1">Class</label>
                                    <input type="text" id="class" name="class_name" placeholder="e.g., Grade 10"
                                        class="w-full px-4 py-3 bg-gray-200 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-500">
                                </div>

                                <!-- Section -->
                                <div>
                                    <label for="section" class="block text-sm font-medium mb-1">Section</label>
                                    <select id="section" name="section_name"
                                        class="w-full px-4 py-3 bg-gray-200 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <option value="">Select Section</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                    </select>
                                </div>
 
                                <!-- Class Code -->
                                <div>
                                    <label for="class_code" class="block text-sm font-medium mb-1">Class Code</label>
                                    <input type="text" id="class_code" name="class_code" placeholder="e.g., 10A"
                                        class="w-full px-4 py-3 bg-gray-200 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-500">
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-4">
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-lg hover:shadow-xl">
                                        Add Class Section
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="w-full lg:w-7/12 xl:w-8/12">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <!-- Table Header -->
                            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg font-bold text-gray-800">Current Class Sections</h3>
                                <div class="flex space-x-2">
                                    <button
                                        class="bg-blue-100 hover:bg-blue-200 text-blue-700 py-2 px-4 rounded-lg transition">
                                        <i class="fas fa-filter mr-2"></i>Filter
                                    </button>
                                    <button
                                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition">
                                        <i class="fas fa-download mr-2"></i>Export
                                    </button>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Class</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Section</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Class Code</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <!-- Row 1 -->
                                        @foreach ($class_section as $class)
                                            <tr class="hover:bg-gray-50 transition">
                                                <!-- Class -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $class->class_name }}
                                                    </div>
                                                </td>

                                                <!-- Section -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $class->section_name }}</div>
                                                </td>

                                                <!-- Code -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $class->class_code }}</div>
                                                </td>

                                                <!-- Actions -->
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="flex space-x-3">
                                                        <a href=""
                                                            class="text-blue-600 hover:text-blue-900">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('class.destroy', $class->id) }}"
                                                            method="POST" onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach




                                    </tbody>
                                </table>
                            </div>

                            <!-- Table Footer -->
                            <div
                                class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center">
                                <div class="text-sm text-gray-700 mb-4 md:mb-0">
                                    Showing <span class="font-semibold">1</span> to <span class="font-semibold">5</span> of
                                    <span class="font-semibold">12</span> entries
                                </div>
                                <div class="flex space-x-2">
                                    <button
                                        class="bg-white border border-gray-300 rounded-md px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Previous
                                    </button>
                                    <button
                                        class="bg-blue-600 text-white rounded-md px-3 py-1 text-sm font-medium hover:bg-blue-700">
                                        1
                                    </button>
                                    <button
                                        class="bg-white border border-gray-300 rounded-md px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        2
                                    </button>
                                    <button
                                        class="bg-white border border-gray-300 rounded-md px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Next
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>


    </div>
@endsection
