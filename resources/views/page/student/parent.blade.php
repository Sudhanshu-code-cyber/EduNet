<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduNet - Student Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4361ee',
                        secondary: '#3f37c9',
                        accent: '#ff6b6b',
                        light: '#f8f9fa',
                        dark: '#212529'
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
        }

        .header-gradient {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
        }

        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 8px;
            animation: fadeIn 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            z-index: 1000;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #4361ee;
        }

        .nav-link:hover::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: #4361ee;
            border-radius: 3px;
        }

        .profile-img {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
        }

        .active-nav {
            color: #4361ee;
            font-weight: 600;
        }

        .active-nav::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: #4361ee;
            border-radius: 3px;
        }

        .search-box:focus-within {
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex">

@include('page/student/sidebar')
<div class=" w-9/12 mr-10 mt-5">
 @include( 'page.student.header')


@section('content')

@show
</div>

    </div>
    <!-- Header -->




    <script>
        // Simple dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.querySelector('.dropdown');
            const dropdownButton = dropdown.querySelector('button');
            const dropdownContent = dropdown.querySelector('.dropdown-content');

            // Toggle dropdown on button click
            dropdownButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = dropdownContent.style.display === 'block';
                dropdownContent.style.display = isOpen ? 'none' : 'block';
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target)) {
                    dropdownContent.style.display = 'none';
                }
            });

            // Search box animation
            const searchInput = document.querySelector('.search-box input');
            searchInput.addEventListener('focus', function() {
                document.querySelector('.search-box').classList.add('ring-2', 'ring-primary');
            });

            searchInput.addEventListener('blur', function() {
                document.querySelector('.search-box').classList.remove('ring-2', 'ring-primary');
            });
        });
    </script>
</body>

</html>
