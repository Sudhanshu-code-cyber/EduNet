 <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
            color: #333;
        }

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(160deg, #2c3e50 0%, #1a2530 100%);
            width: ;
            display: flex;
            flex-direction: column;
            box-shadow: 5px 0 25px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 25px 25px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
        }

        .logo-icon {
            font-size: 28px;
            margin-right: 15px;
            color: #3498db;
        }

        .logo-text {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .logo-subtext {
            font-size: 13px;
            color: #7f8c8d;
            margin-top: 5px;
            margin-left: 43px;
            letter-spacing: 1px;
        }

        /* Navigation */
        .nav {
            padding: 20px 0;
            flex: 1;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
            font-size: 16px;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(52, 152, 219, 0.15);
            color: #fff;
            padding-left: 30px;
        }

        .nav-link.active {
            background: linear-gradient(90deg, rgba(52, 152, 219, 0.25) 0%, rgba(52, 152, 219, 0.1) 100%);
            color: #fff;
            border-left: 4px solid #3498db;
        }

        .nav-link.active::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: 3px;
            background: #3498db;
            box-shadow: 0 0 15px #3498db;
        }

        .nav-icon {
            font-size: 18px;
            width: 30px;
            margin-right: 15px;
            text-align: center;
        }

        .nav-text {
            flex: 1;
        }

        .dropdown-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .dropdown-icon {
            transition: transform 0.3s;
        }

        .dropdown-content {
            background: rgba(26, 37, 48, 0.8);
            border-radius: 0 0 8px 8px;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.4s ease-out;
        }

        .dropdown-content.open {
            max-height: 300px;
        }

        .dropdown-link {
            display: block;
            padding: 12px 25px 12px 65px;
            color: #95a5a6;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }

        .dropdown-link:hover {
            background: rgba(41, 128, 185, 0.2);
            color: #ecf0f1;
            padding-left: 70px;
        }

        /* Profile Section */
        .profile-section {
            padding: 25px 20px;
            background: rgba(26, 37, 48, 0.8);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
        }

        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #3498db;
            background: linear-gradient(45deg, #3498db, #2ecc71);
        }

        .profile-info {
            margin-left: 15px;
        }

        .profile-name {
            color: #ecf0f1;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .profile-email {
            color: #7f8c8d;
            font-size: 12px;
        }

        /* Content Area */
        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            color: #2c3e50;
            font-weight: 700;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
            display: flex;
            align-items: center;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 20px;
            color: white;
        }

        .icon-students {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .icon-teachers {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
        }

        .icon-courses {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
        }

        .icon-attendance {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .stat-info {
            flex: 1;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
        }

        /* Responsive */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            width: 45px;
            height: 45px;
            font-size: 20px;
            cursor: pointer;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                height: 100vh;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .menu-toggle {
                display: block;
            }
        }
    </style>
 <div class="sidebar h-screen overflow-y-auto" id="sidebar">
        <div class="sidebar-header">
            <a href="{{route('/admin')}}" class="logo">
                <i class="fas fa-graduation-cap logo-icon"></i>
                <div>
                    <div class="logo-text">EduNet</div>
                </div>
            </a>
        </div>
        
        <nav class="nav">
            <div class="nav-item">
                <a href="{{route('/admin')}}" class="nav-link active">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" id="studentsDropdown">
                    <i class="fas fa-user-graduate nav-icon"></i>
                    <span class="nav-text">Students</span>
                    <i class="fas fa-chevron-down nav-icon dropdown-icon"></i>
                </a>
                <div class="dropdown-content" id="studentsContent">
                    <a href="{{route('admin.allstudent')}}" class="dropdown-link">Total Students</a>
                    <a href="#" class="dropdown-link">Student Details</a>
                    <a href="{{route('student.create')}}" class="dropdown-link">Add New Student</a>
                    <a href="#" class="dropdown-link">Fees</a>
                </div>
            </div>
            
            <div class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" id="teachersDropdown">
                    <i class="fas fa-chalkboard-teacher nav-icon"></i>
                    <span class="nav-text">Teachers</span>
                    <i class="fas fa-chevron-down nav-icon dropdown-icon"></i>
                </a>
                <div class="dropdown-content" id="teachersContent">
                    <a href="{{ route('teacher.index') }}" class="dropdown-link">All Teacher</a>
                    <a href="{{ route('teacher.create') }}" class="dropdown-link">Add New Teacher</a>
                    <a href="{{ route('assign.teacher.index') }}" class="dropdown-link">Assign Subjects</a>
                    <a href="#" class="dropdown-link">Payment</a>

                </div>
            </div>
            
            <div class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" id="classSectionDropdown">
                    <i class="fas fa-layer-group nav-icon"></i>
                    <span class="nav-text">Class & Section Management</span>
                    <i class="fas fa-chevron-down nav-icon dropdown-icon"></i>
                </a>
                <div class="dropdown-content" id="classSectionContent">
                    <a href="{{ route('classes.index') }}" class="dropdown-link">Manage Classes</a>
                    <a href="{{ route('create.section') }}" class="dropdown-link">Assign Sections to Classes</a>
                </div>
            </div>
            
           
 <div class="nav-item">
                <a href="{{route('subjects.index')}}" class="nav-link">
                    <i class="fas fa-book nav-icon"></i>
                    <span class="nav-text">Subject Management</span>
                </a>
            </div>
            

             <div class="nav-item">
                <a href="{{route('admin.transport')}}" class="nav-link">
                    <i class="fas fa-calendar-alt nav-icon"></i>
                    <span class="nav-text">Transport Management</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" id="financeDropdown">
                    <i class="fas fa-money-bill-wave nav-icon"></i>
                    <span class="nav-text">Finance Management</span>
                    <i class="fas fa-chevron-down nav-icon dropdown-icon"></i>
                </a>
                <div class="dropdown-content" id="financeContent">
                    <a href="{{ route('fee-types.index') }}" class="dropdown-link">Fee Types</a>
                    <a href="{{ route('fee-structure.create') }}" class="dropdown-link">Fee Structure</a>
                    <a href="{{ route('fee-payment.create') }}" class="dropdown-link">Student Fee</a>
            
                    <a href="" class="dropdown-link">Staff Salary</a>
                </div>
            </div>
            
            
            
            <div class="nav-item">
                <a href="{{ route('notice.index') }}" class="nav-link">
                    <i class="fas fa-file-alt nav-icon"></i>
                    <span class="nav-text">Notice</span>
                </a>
            </div>

             <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-file-alt nav-icon"></i>
                    <span class="nav-text">Reports</span>
                </a>
            </div>
            
            

             <div class="nav-item">
                <a href="{{route('admin.calendar')}}" class="nav-link">
                    <i class="fas fa-calendar-alt nav-icon"></i>
                    <span class="nav-text">Calender </span>
                </a>
            </div>

            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog nav-icon"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </div>
        </nav>
        
        <div class="profile-section">
            <div class="profile-img"></div>
            <div class="profile-info">
                <div class="profile-name">Admin User</div>
                <div class="profile-email">admin@edumanage.com</div>
            </div>
        </div>
    </div>