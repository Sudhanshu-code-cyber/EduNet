<!-- Admin Header -->
<header style=" background: linear-gradient(160deg, #2c3e50 0%, #1a2530 100%);" class=" shadow-md px-6 py-2 flex justify-between items-center w-full sticky top-0 z-50">
  <!-- Left: Logo + Page Title -->
  <div class="flex items-center space-x-4">
    <i class="fas fa-cogs text-blue-600 text-2xl"></i>
    <h1 class="text-xl sm:text-2xl font-bold text-white">Admin Panel</h1>
    <span class="hidden sm:inline text-gray-100 text-sm">Welcome back, Admin!</span>
  </div>

  <!-- Right: Search, Notifications, User -->
  <div class="flex items-center space-x-4">
   

    <!-- Notifications -->
    <button class="relative text-gray-600 hover:text-blue-600">
      <i class="fas fa-bell text-lg"></i>
      <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 rounded-full flex items-center justify-center">4</span>
    </button>

    <!-- User Profile Dropdown -->
<div class="relative">
  <img id="userAvatar" src="https://i.pravatar.cc/40" alt="User Avatar"
    class="w-10 h-10 rounded-full cursor-pointer ring-2 ring-blue-500">
  
  <!-- Dropdown -->
  <div id="dropdownMenu"
    class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md py-2 opacity-0 invisible transition duration-300 z-50">
    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
    <a href="{{route('user.logout')}}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
  </div>
</div>

<!-- Script -->
<script>
  const avatar = document.getElementById('userAvatar');
  const dropdown = document.getElementById('dropdownMenu');

  // Toggle dropdown on avatar click
  avatar.addEventListener('click', () => {
    dropdown.classList.toggle('opacity-0');
    dropdown.classList.toggle('invisible');
  });

  // Close dropdown when clicking outside
  window.addEventListener('click', (e) => {
    if (!avatar.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.add('opacity-0');
      dropdown.classList.add('invisible');
    }
  });
</script>

  </div>
</header>
