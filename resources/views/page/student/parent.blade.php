<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduNet - Student Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
       
        
       
        
        .student-info h1 {
            font-size: 28px;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .student-info p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .overview-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 500;
            color: #555;
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .present .card-icon {
            background: rgba(76, 175, 80, 0.15);
            color: #4CAF50;
        }
        
        .absent .card-icon {
            background: rgba(244, 67, 54, 0.15);
            color: #F44336;
        }
        
        .percentage .card-icon {
            background: rgba(33, 150, 243, 0.15);
            color: #2196F3;
        }
        
        .days .card-icon {
            background: rgba(255, 152, 0, 0.15);
            color: #FF9800;
        }
        
        .card-content {
            font-size: 32px;
            font-weight: 600;
        }
        
        .card-footer {
            font-size: 14px;
            color: #777;
            margin-top: 10px;
        }
        
       
        
        
        
        
    </style>
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
   @include('page.student.sidebar')

   <div class="w-full sm:ml-64"> 
      @include('page.student.header')

      <div class="p-4">
         @yield('content')
      </div>
   </div>
</div>





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
