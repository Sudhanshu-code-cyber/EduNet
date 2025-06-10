<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Teacher Dashboard')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
 </head>
<body class="bg-gray-100 font-sans">
    @include('page.teacher.header')
    <div class="flex">
        @include('page.teacher.sidebar')
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
