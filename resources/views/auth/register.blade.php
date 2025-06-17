<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - EduNet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5',
                        secondary: '#818cf8',
                        admin: '#10b981',
                        teacher: '#f59e0b',
                        student: '#3b82f6'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .role-option {
            transition: all 0.3s ease;
            border-left-width: 4px;
        }

        .role-option:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .role-option.selected {
            border-color: currentColor;
            background-color: rgba(79, 70, 229, 0.05);
        }

        .role-icon {
            transition: all 0.3s ease;
        }

        .password-toggle {
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-indigo-50 to-blue-100 min-h-screen flex items-center justify-center px-4 py-8">
    <div class="max-w-4xl w-full flex flex-col md:flex-row bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Left Side - Illustration & Info -->
        <div
            class="w-full md:w-2/5 bg-gradient-to-br from-primary to-indigo-700 p-8 flex flex-col justify-between text-white">
            <div>
                <div class="flex items-center mb-6">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg mr-3">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold">EduNet Academy</h1>
                </div>

                <h2 class="text-3xl font-bold mb-4">Join Our Learning Community</h2>
                <p class="opacity-90 mb-6">Create your account to access personalized learning resources and connect
                    with educators.</p>
            </div>

            <div class="mt-8">
                <div class="flex items-center mb-5">
                    <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <p>Access to thousands of learning materials</p>
                </div>
                <div class="flex items-center mb-5">
                    <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <p>Personalized learning pathways</p>
                </div>
                <div class="flex items-center">
                    <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <p>Connect with educators and peers</p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-sm opacity-80">Already have an account? <a href="#"
                        class="font-semibold underline">Sign In</a></p>
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="w-full md:w-3/5 p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Create Your Account</h2>
            <p class="text-gray-600 mb-8">Fill in your details to get started</p>

            <form action="{{route('userRegister')}}" method="POST" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" name="name" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none form-input"
                            placeholder="John Doe">
                    </div>
                    @error('name')
                    <p class="text-red-500 font-semibold text-xs">{{$message}}</p>
                        
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none form-input"
                            placeholder="john@example.com">
                            @error('email')
                    <p class="text-red-500 font-semibold text-xs">{{$message}}</p>
                        
                    @enderror
                    </div>
                </div>
                 <div>
                    <label class="block text-gray-700 font-semibold mb-2">Contact</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="contact" name="contact" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none form-input"
                            placeholder="999999999">
                            @error('contact')
                    <p class="text-red-500 font-semibold text-xs">{{$message}}</p>
                        
                    @enderror
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" id="password" 
                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none form-input"
                            placeholder="••••••••">
                            
                        @error('password')
                    <p class="text-red-500 font-semibold text-xs">{{$message}}</p>
                        
                    @enderror
                    </div>
                </div>



                <!-- Role Selection -->
                <div class="mb-6">
                    <label for="role" class="block text-gray-700 text-sm font-semibold mb-2">Register As</label>
                    <select name="role" id="role" 
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition duration-200">
                        <option value="" disabled selected>Select Role</option>
                        <option value="admin">🛡️ Admin - System Management</option>
                        <option value="teacher">👨‍🏫 Teacher - Course Instructor</option>
                        <option value="student">🎓 Student - Learning Resources</option>
                    </select>
                     @error('role')
                    <p class="text-red-500 font-semibold text-xs">{{$message}}</p>
                        
                    @enderror

                    <!-- Optional: validation error display -->
                    @error('role')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Terms -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox"
                            class="h-4 w-4 text-primary rounded focus:ring-primary border-gray-300">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700">I agree to the <a href="#"
                                class="text-primary hover:underline">Terms of Service</a> and <a href="#"
                                class="text-primary hover:underline">Privacy Policy</a></label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-primary to-indigo-700 text-white font-semibold rounded-lg hover:opacity-90 transition duration-300 shadow-md">
                        Create Account
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="#" class="text-primary font-semibold hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>


</body>

</html>
