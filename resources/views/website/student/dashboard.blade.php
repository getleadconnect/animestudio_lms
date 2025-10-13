@extends('website.layout')

@section('title', 'Student Dashboard - AnimeStudio Learning Platform')

@push('styles')
<style>
    .dashboard-section {
        background: #f8f9fa;
        min-height: 80vh;
        padding: 20px 0;
    }

    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .welcome-banner h2 {
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 1.5rem;
    }

    @media (min-width: 768px) {
        .dashboard-section {
            padding: 40px 0;
        }

        .welcome-banner {
            padding: 30px;
        }

        .welcome-banner h2 {
            font-size: 2rem;
        }
    }

    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
        border-left: 4px solid var(--primary-color);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .stat-card i {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 15px;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: var(--dark-color);
    }

    .stat-label {
        color: #999;
        font-size: 0.9rem;
    }

    .dashboard-card {
        background: white;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .dashboard-card h4 {
        color: var(--dark-color);
        margin-bottom: 15px;
        font-weight: 600;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
        font-size: 1.1rem;
    }

    @media (min-width: 768px) {
        .dashboard-card {
            padding: 25px;
            margin-bottom: 25px;
        }

        .dashboard-card h4 {
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
    }

    .course-item {
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        height: 100%;
        background: white;
        margin-top:5px;
    }

    .course-item:hover {
        border-color: var(--primary-color);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.15);
        transform: translateY(-2px);
    }

    .course-item-body {
        display: flex;
        gap: 15px;
        flex: 1;
    }

    .course-item h6 {
        color: var(--primary-color);
        margin-bottom: 8px;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .course-item .badge {
        padding: 6px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        width: fit-content;
    }

    .course-badges-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .btn-get-started {
        padding: 6px 12px;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
    }

    .btn-get-started:hover {
        background: #5568d3;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-get-started i {
        font-size: 0.75rem;
    }

    .result-item {
        padding: 12px;
        border-left: 3px solid var(--primary-color);
        background: #f8f9fa;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .result-item h6 {
        margin-bottom: 5px;
        color: var(--dark-color);
    }

    .result-score {
        font-size: 1.2rem;
        font-weight: bold;
        color: var(--primary-color);
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-top: 20px;
    }

    .quick-action-btn {
        padding: 15px 10px;
        background: white;
        border: 2px solid var(--primary-color);
        border-radius: 10px;
        text-align: center;
        text-decoration: none;
        color: var(--primary-color);
        transition: all 0.3s;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .quick-action-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(74, 144, 226, 0.3);
    }

    .quick-action-btn i {
        display: block;
        font-size: 1.5rem;
        margin-bottom: 8px;
    }

    @media (min-width: 768px) {
        .quick-actions {
            display: flex;
            gap: 15px;
        }

        .quick-action-btn {
            flex: 1;
            padding: 15px;
            font-size: 1rem;
        }

        .quick-action-btn i {
            font-size: 2rem;
            margin-bottom: 10px;
        }
    }

    .progress-bar {
        background: var(--primary-color);
        height: 8px;
        border-radius: 4px;
    }

    .no-data {
        text-align: center;
        padding: 40px;
        color: #999;
    }

    .no-data i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #ddd;
    }

    .logout-btn {
        background: #dc3545;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 0.9rem;
    }

    .logout-btn:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    @media (min-width: 768px) {
        .logout-btn {
            padding: 10px 20px;
            font-size: 1rem;
        }
    }

    /* Classes Sections Styles */
    .classes-list {
        max-height: 500px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .classes-list::-webkit-scrollbar {
        width: 6px;
    }

    .classes-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .classes-list::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }

    .class-item {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        transition: all 0.3s;
        border-left: 4px solid #667eea;
    }

    .class-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .class-icon {
        width: 60px;
        height: 60px;
        flex-shrink: 0;
        border-radius: 10px;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .class-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .class-icon i {
        font-size: 2rem;
        color: white;
    }

    .class-details {
        flex: 1;
    }

    .class-details h6 {
        font-size: 1rem;
        font-weight: 600;
        color: #1c1d1f;
        margin-bottom: 5px;
    }

    .class-course, .class-instructor {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 3px;
    }

    .class-course i, .class-instructor i {
        color: #667eea;
        margin-right: 5px;
    }

    .class-meta {
        display: flex;
        gap: 15px;
        margin-top: 8px;
    }

    .class-meta span {
        font-size: 0.8rem;
        color: #999;
    }

    .class-meta i {
        color: #667eea;
        margin-right: 3px;
    }

    .class-action {
        flex-shrink: 0;
    }

    .btn-join-class, .btn-watch-class {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-block;
        border: none;
    }

    .btn-join-class:hover, .btn-watch-class:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .no-data-small {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .no-data-small i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #ddd;
    }

    .no-data-small p {
        font-size: 1rem;
        margin: 0;
    }

    @media (max-width: 768px) {
        .class-item {
            flex-direction: column;
            text-align: center;
        }

        .class-details {
            width: 100%;
        }

        .class-meta {
            justify-content: center;
            flex-wrap: wrap;
        }
    }

    /* Courses container - no scroll, show all */
    .courses-scroll-container {
        
    }

    /* Course item image styling */
    .course-item-image {
        width: 100px;
        height: 100px;
        flex-shrink: 0;
        border-radius: 8px;
        overflow: hidden;
    }

    .course-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .course-item-image > div {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .course-item-details {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .course-item-details h6 {
        font-size: 1.1rem;
        margin-bottom: 10px;
    }

    .course-item-details small {
        display: block;
        margin-bottom: 5px;
        color: #666;
        font-size: 0.85rem;
    }

    @media (max-width: 576px) {
        .course-item-body {
            flex-direction: column;
        }

        .course-item-image {
            width: 100%;
            height: 150px;
        }
    }

    /* Profile section mobile responsive */
    .profile-info p {
        margin-bottom: 10px;
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .profile-info p {
            font-size: 1rem;
        }
    }

    /* Info Cards Styling */
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }

    .info-card-icon {
        width: 50px;
        height: 50px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.3s;
    }

    .info-card-icon i {
        font-size: 1.8rem;
    }

    .info-card-content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .info-card-text {
        font-size: 1rem;
        font-weight: 600;
        color: #1c1d1f;
        margin: 0;
        transition: color 0.3s;
    }

    .info-card-count {
        font-size: 0.85rem;
        color: #666;
        margin-top: 2px;
    }

    .info-card:hover .info-card-text {
        color: #667eea;
    }

    /* Color variations for each card */
    .info-card.card-tests .info-card-icon {
        background: #f0f0ff;
        color: #667eea;
    }

    .info-card.card-results .info-card-icon {
        background: #fff0f5;
        color: #f5576c;
    }

    .info-card.card-profile .info-card-icon {
        background: #f0faff;
        color: #4facfe;
    }

    .info-card.card-courses .info-card-icon {
        background: #f0fff5;
        color: #43e97b;
    }

    @media (max-width: 767px) {
        .info-card {
            padding: 15px;
            gap: 12px;
        }

        .info-card-icon {
            width: 45px;
            height: 45px;
        }

        .info-card-icon i {
            font-size: 1.5rem;
        }

        .info-card-text {
            font-size: 0.9rem;
        }

        .info-card-count {
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
    <section class="dashboard-section">
        <div class="container">
            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <div class="row align-items-center">
                    <div class="col-12 col-md-8 mb-3 mb-md-0">
                        <h2>Welcome back, {{ $student->student_name ?? 'Student' }}!</h2>
                        <p class="mb-0">Continue your learning journey with AnimeStudio Learning Platform</p>
                    </div>
                    <div class="col-12 col-md-4 text-start text-md-end">
                        <form action="{{ route('student.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if(Session::has('message'))
                @php
                    $message = explode('#', Session::get('message'));
                    $type = $message[0] ?? 'info';
                    $text = $message[1] ?? '';
                @endphp
                <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                    {{ $text }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Info Cards Row -->
            <div class="row mt-4">

            <!-- My Courses Card -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ url('/courses') }}" class="info-card card-courses">
                        <div class="info-card-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="info-card-content">
                            <p class="info-card-text">Courses</p>
                            <span class="info-card-count">{{ $totalCourses ?? 0 }} Available</span>
                        </div>
                    </a>
                </div>
                <!-- Mock Tests Card -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('student.course-mock-test') }}" class="info-card card-tests">
                        <div class="info-card-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="info-card-content">
                            <p class="info-card-text">Mock Tests</p>
                            <span class="info-card-count">{{ $totalMockTests ?? 0 }} Attented</span>
                        </div>
                    </a>
                </div>

                <!-- Success Story Card -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('student.success-stories') }}" class="info-card card-results">
                        <div class="info-card-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="info-card-content">
                            <p class="info-card-text">Success Story</p>
                            <span class="info-card-count">Watch & Get Inspired</span>
                        </div>
                    </a>
                </div>

                <!-- My Profile Card -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('student.profile') }}" class="info-card card-profile">
                        <div class="info-card-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-card-content">
                            <p class="info-card-text">My Profile</p>
                            <span class="info-card-count">View & Edit</span>
                        </div>
                    </a>
                </div>

                
            </div>

            <div class="row mt-3">
                <!-- My Courses -->
                <div class="col-md-12">
                    <div class="dashboard-card">
                        <h4><i class="fas fa-graduation-cap"></i> My Courses</h4>
                        @if(isset($myCourses) && count($myCourses) > 0)
                            <div class="courses-scroll-container">
                                <div class="row g-3">
                                    @foreach($myCourses as $course)
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="course-item">
                                            <!-- Course Body with Image Left and Details Right -->
                                            <div class="course-item-body">
                                                <!-- Course Square Image -->
                                                <div class="course-item-image">
                                                    @if($course->course_square_icon)
                                                        <img src="{{ config('constants.course_icon').$course->course_square_icon }}"
                                                             alt="{{ $course->course_name }}">
                                                    @else
                                                        <div style="background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);">
                                                            <i class="fas fa-book" style="color: white; font-size: 2.5rem;"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Course Details -->
                                                <div class="course-item-details">
                                                    <h6>{{ $course->course_name }}</h6>
                                                    <small style="display: block; margin-bottom: 8px;">
                                                        <i class="fas fa-calendar-check"></i> {{ \Carbon\Carbon::parse($course->start_date)->format('d M Y') }}
                                                        <span style="margin: 0 5px;">|</span>
                                                        <i class="fas fa-calendar-times"></i> {{ $course->valid_till }}
                                                    </small>

                                                    <!-- Badges Container with Status Badge and Get Started Button -->
                                                    <div class="course-badges-container">
                                                        <span class="badge bg-{{ $course->status_color }}">
                                                            @if($course->subscription_status == 'Expired')
                                                                <i class="fas fa-times-circle"></i> {{ $course->subscription_status }}
                                                            @else
                                                                <i class="fas fa-clock"></i> {{ $course->subscription_status }}
                                                            @endif
                                                        </span>

                                                        <button onclick="checkCourseStatus('{{ $course->subscription_status }}', '{{ route('student.course-content', $course->course_id) }}')"
                                                                class="btn-get-started">
                                                            <i class="fas fa-arrow-right"></i> Get Started
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="no-data">
                                <i class="fas fa-graduation-cap"></i>
                                <p>You haven't subscribed to any courses yet</p>
                                <a href="{{ url('/courses') }}" class="btn btn-primary-custom">Browse Courses</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Online Classes and Recorded Classes Row -->
            <div class="row mt-3">
                <!-- Online Classes (Left) -->
                <div class="col-md-6">
                    <div class="dashboard-card">
                        <h4><i class="fas fa-video"></i> Online Classes</h4>
                        @if(isset($liveClasses) && count($liveClasses) > 0)
                            <div class="classes-list">
                                @foreach($liveClasses as $liveClass)
                                <div class="class-item">
                                    <div class="class-icon">
                                        @if($liveClass->class_icon)
                                            <img src="{{ config('constants.live_class_icon').$liveClass->class_icon }}" alt="{{ $liveClass->title }}">
                                        @else
                                            <i class="fas fa-chalkboard-teacher"></i>
                                        @endif
                                    </div>
                                    <div class="class-details">
                                        <h6>{{ $liveClass->title }}</h6>
                                        <p class="class-course"><i class="fas fa-book"></i> {{ $liveClass->course_name }}</p>
                                        <p class="class-instructor"><i class="fas fa-user"></i> {{ $liveClass->conducted_by }}</p>
                                        <div class="class-meta">
                                            <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($liveClass->start_date)->format('d M Y') }}</span>
                                            <span><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($liveClass->start_time)->format('h:i A') }}</span>
                                        </div>
                                    </div>
                                    @if($liveClass->class_link)
                                    <div class="class-action">
                                        <a href="{{ $liveClass->class_link }}" target="_blank" class="btn-join-class">
                                            <i class="fas fa-external-link-alt"></i> Join
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="no-data-small">
                                <i class="fas fa-video"></i>
                                <p>No online classes available</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recorded Online Classes (Right) -->
                <div class="col-md-6">
                    <div class="dashboard-card">
                        <h4><i class="fas fa-play-circle"></i> Recorded Online Classes</h4>
                        @if(isset($recordedClasses) && count($recordedClasses) > 0)
                            <div class="classes-list">
                                @foreach($recordedClasses as $recordedClass)
                                <div class="class-item">
                                    <div class="class-icon">
                                        @if($recordedClass->class_icon)
                                            <img src="{{ config('constants.recorded_class_icon').$recordedClass->class_icon }}" alt="{{ $recordedClass->title }}">
                                        @else
                                            <i class="fas fa-play-circle"></i>
                                        @endif
                                    </div>
                                    <div class="class-details">
                                        <h6>{{ $recordedClass->title }}</h6>
                                        <p class="class-course"><i class="fas fa-book"></i> {{ $recordedClass->course_name }}</p>
                                        <p class="class-instructor"><i class="fas fa-user"></i> {{ $recordedClass->class_by }}</p>
                                        <div class="class-meta">
                                            @if($recordedClass->duration)
                                            <span><i class="fas fa-hourglass-half"></i> {{ $recordedClass->duration }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="class-action">
                                        <a href="{{ route('student.recorded-classes', $recordedClass->course_id) }}" class="btn-watch-class">
                                            <i class="fas fa-play"></i> Watch
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="no-data-small">
                                <i class="fas fa-play-circle"></i>
                                <p>No recorded classes available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Dashboard animations
    document.addEventListener('DOMContentLoaded', function() {
        // Animate stat cards on load
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.animation = 'fadeInUp 0.5s';
            }, index * 100);
        });
    });

    // Check course status before navigation
    function checkCourseStatus(status, url) {
        if (status === 'Expired') {
            Swal.fire({
                title: 'Course Expired!',
                text: 'Sorry! The course is expired. Thank You!',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
        } else {
            // Navigate to course content page
            window.location.href = url;
        }
    }
</script>
@endpush