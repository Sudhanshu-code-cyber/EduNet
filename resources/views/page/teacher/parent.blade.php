<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Teacher Dashboard')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/flowbite@2.3.0/dist/flowbite.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
    [x-cloak] {
        display: none !important;
    }
</style>
<script src="//unpkg.com/alpinejs" defer></script>

 </head>
<body class="bg-gray-100 font-sans">
    @include('page.teacher.header')
    <div class="flex">
        @include('page.teacher.sidebar')
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
    
</body>
</html>
