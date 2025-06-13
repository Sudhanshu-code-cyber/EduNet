@extends('page.admin.parent')

@section('content')

 <div class="content">
        <div class="header">
            <h1 class="page-title">Dashboard Overview</h1>
            <div class="header-actions">
                <button class="btn"><i class="fas fa-bell"></i></button>
                <button class="btn"><i class="fas fa-cog"></i></button>
            </div>
        </div>
        
        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon icon-students">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">1,248</div>
                    <div class="stat-label">Total Students</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon icon-teachers">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">64</div>
                    <div class="stat-label">Teachers</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon icon-courses">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">42</div>
                    <div class="stat-label">Courses</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon icon-attendance">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">96.7%</div>
                    <div class="stat-label">Attendance Rate</div>
                </div>
            </div>
        </div>
        
        <div class="dashboard-content">
            <!-- Additional dashboard content would go here -->
        </div>
    </div>
@endsection