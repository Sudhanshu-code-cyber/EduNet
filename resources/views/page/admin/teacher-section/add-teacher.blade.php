@extends('page.admin.parent')

@section('content')
    <div class="w-full px-5 py-10 bg-white rounded-lg shadow-lg min-h-screen">
        <h1 class="text-4xl font-bold mb-8 text-blue-800 text-center mt-8">Add New Teacher</h1>

        <form action="{{ route('teacher.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 w-full pl-8">
            @csrf

            <div class="flex flex-wrap gap-6">
                <div class="flex gap-2">
                    <div>
                        <label class="block font-semibold mb-2 text-gray-700">First Name</label>
                        <input type="text" name="first_name"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Enter first name">
                        @error('first_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror


                    </div>

                    <div>
                        <label class="block font-semibold mb-2 text-gray-700">Last Name</label>
                        <input type="text" name="last_name"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Enter last name">
                        @error('last_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2 text-gray-700">Gender</label>
                        <select name="gender"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            <option value="" disabled selected>Select gender</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                        @error('gender')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-2">
                    <div>
                        <label class="block font-semibold mb-2 text-gray-700">Date of Birth</label>
                        <input type="date" name="dob"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('dob')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2 text-gray-700">ID Number</label>
                        <input type="text" name="id_no"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Enter ID number">
                        @error('id_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2 text-gray-700">Blood Group</label>
                        <select name="blood_group"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 focus:ring-2 focus:ring-blue-400 focus:outline-none">
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
                </div>

                <div class="flex gap-2">
                    <div>
                        <label class="block font-semibold mb-2 text-gray-700">Religion</label>
                        <select name="religion"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 focus:ring-2 focus:ring-blue-400 focus:outline-none">
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
                        <label class="block font-semibold mb-2 text-gray-700">Email</label>
                        <input type="email" name="email"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Enter email">
                             @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2 text-gray-700">Class</label>
                        <select name="class"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            <option value="" disabled selected>Select class</option>
                            <option>Nursery</option>
                            <option>LKG</option>
                            <option>UKG</option>
                            <option>1</option>
                            <option>2</option>
                        </select>
                         @error('class')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-2">
                    <div>
                        <label class="block font-semibold mb-2 text-gray-700">Section</label>
                        <select name="section"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            <option value="" disabled selected>Select section</option>
                            <option>A</option>
                            <option>B</option>
                            <option>C</option>
                        </select>
                         @error('section')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2 text-gray-700">Phone</label>
                        <input type="text" name="phone"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Enter phone number">
                             @error('phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2 text-gray-700">Upload Photo</label>
                        <input type="file" name="photo" accept="image/*"
                            class="border border-gray-300 rounded-lg w-96 h-12 text-base px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                             @error('photo')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <label class="block font-semibold mb-2 text-gray-700">Address</label>
                <textarea name="address" rows="3"
                    class="w-[95%] border border-gray-300 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter full address"></textarea>
                     @error('address')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
            </div>

            <div>
                <label class="block font-semibold mb-2 text-gray-700">Short Bio</label>
                <textarea name="short_bio" rows="3"
                    class="w-[95%] border border-gray-300 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Write a short bio about the teacher"></textarea>
                     @error('short_bio')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
            </div>

            <div class="flex justify-end gap-4 mt-16 pr-12">
                <button type="reset"
                    class="bg-red-500 text-white w-24 h-10 rounded-lg hover:bg-red-600 transition">Reset</button>
                <button type="submit"
                    class="bg-blue-600 text-white w-24 h-10 rounded-lg hover:bg-blue-700 transition">Save</button>
            </div>
        </form>
    </div>
@endsection
