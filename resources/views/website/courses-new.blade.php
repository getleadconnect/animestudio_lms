@extends('website.layout')

@section('title', 'Our Courses - AnimeStudio Learning Platform')

@push('styles')
<style>
    /* Modern Page Header with Gradient */
    .courses-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        padding: 80px 0 80px;
        overflow: hidden;
    }

    .courses-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,133.3C672,139,768,181,864,197.3C960,213,1056,203,1152,176C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
        opacity: 0.3;
    }

    .courses-hero-content {
        position: relative;
        z-index: 2;
        color: white;
        text-align: center;
    }

    .courses-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        animation: fadeInUp 0.6s ease-out;
    }

    .courses-hero p {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        opacity: 0.95;
        animation: fadeInUp 0.8s ease-out;
    }

    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin-top: 2rem;
        animation: fadeInUp 1s ease-out;
    }

    .hero-stat-item {
        text-align: center;
    }

    .hero-stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        display: block;
        margin-bottom: 0.5rem;
    }

    .hero-stat-label {
        font-size: 1rem;
        opacity: 0.9;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Category Section Styling */
    .courses-container {
        margin-top: -60px;
        position: relative;
        z-index: 10;
    }

    .category-section {
        margin-bottom: 4rem;
    }

    .simple-category-header {
        margin-bottom: 2rem;
        padding-bottom: 0.8rem;
        border-bottom: 3px solid #667eea;
    }

    .simple-category-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    /* Modern Course Card */
    .course-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .course-image-container {
        position: relative;
        /*height: 240px;*/
        overflow: hidden;
        background: #f0f0f0;
    }

    .course-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .course-card:hover .course-image {
        transform: scale(1.08);
    }

    .course-price-badge {
        position: absolute;
        bottom: 15px;
        left: 0;
        right: 0;
        text-align: center;
        background: white;
        padding: 10px 20px;
        font-size: 0.95rem;
        font-weight: 700;
        color: #2c3e50;
        letter-spacing: 0.5px;
        margin: 0 15px;
        border-radius: 5px;
    }

    .course-price-badge-new {
        position: absolute;
        bottom: 15px;
        left: 0;
        right: 0;
        text-align: center;
        background: white;
        padding: 10px 20px;
        font-size: 0.95rem;
        font-weight: 700;
        color: #22303dff;
        letter-spacing: 0.5px;
        margin: 0 15px;
        border-radius: 5px;
    }

    /* Course Content */
    .course-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* Instructor Section */
    .instructor-section {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1rem;
    }

    .instructor-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea20, #764ba220);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #667eea;
        flex-shrink: 0;
    }

    .instructor-info {
        flex: 1;
    }

    .instructor-name {
        font-size: 1.35rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .course-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.8rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .course-description {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.2rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    /* Course Stats */
    .course-stats {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.2rem;
        padding-top: 1rem;
        border-top: 1px solid #e0e0e0;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
        color: #666;
    }

    .stat-item i {
        color: #999;
        font-size: 1rem;
    }

    /* Enroll Button */
    .btn-enroll-now {
        display: block;
        width: 100%;
        padding: 12px;
        background: #FFA500;
        color: white;
        text-align: center;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-enroll-now:hover {
        background: #FF8C00;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 165, 0, 0.4);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
    }

    .empty-state-icon {
        font-size: 5rem;
        color: #ddd;
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        font-size: 1.8rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: #999;
        font-size: 1.1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .courses-hero h1 {
            font-size: 2.5rem;
        }

        .courses-hero p {
            font-size: 1.1rem;
        }

        .hero-stats {
            flex-direction: column;
            gap: 1.5rem;
        }

        .simple-category-title {
            font-size: 1.5rem;
        }
    }

    /* Loading Animation */
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    .loading-shimmer {
        animation: shimmer 2s infinite;
        background: linear-gradient(to right, #f6f7f8 0%, #edeef1 20%, #f6f7f8 40%, #f6f7f8 100%);
        background-size: 1000px 100%;
    }

 
   
    @media (max-width: 768px) {
        .slider-nav-btn {
            display: none;
        }

    
    }

    /* Courses Display Section */
    .courses-display-section {
        background: #f8f9fa;
        padding: 3rem 0;
        min-height: 400px;
    }

    .select-category-message {
        text-align: center;
        padding: 4rem 2rem;
        color: #999;
    }


    .select-category-message h3 {
        font-size: 1.8rem;
        color: #666;
        margin-bottom: 0.5rem;
    }

</style>
@endpush

@section('content')

<!-- Hero Section -->
<div class="courses-hero">
    <div class="container">
        <div class="courses-hero-content">
            <h1>Explore Our Courses</h1>
            <p>Discover the perfect course to achieve your learning goals</p>

            {{--<div class="hero-stats">
                <div class="hero-stat-item">
                    <span class="hero-stat-number">{{ $totalCategories }}</span>
                    <span class="hero-stat-label">Categories</span>
                </div>
                <div class="hero-stat-item">
                    <span class="hero-stat-number">{{ $totalCourses }}</span>
                    <span class="hero-stat-label">Courses</span>
                </div>
                <div class="hero-stat-item">
                    <span class="hero-stat-number">{{ number_format($totalStudents) }}</span>
                    <span class="hero-stat-label">Students</span>
                </div>
            </div> --}}
        </div>
    </div>
</div>

@php
            $course=$coursesByCategory[2];
        @endphp

<!-- Courses Display Section -->
<section class="courses-display-section">
    <div class="container">
        <div id="coursesContainer">
            <!-- Courses will be displayed here when a category is clicked -->
            <div class="select-category-message">
                <h3>{{ $course[0]->course_name }}</h3>
                <label style="border:1px solid #653eb8;width:150px;"></label>
            </div>
        </div>

                        <div class="row g-4">
                           <div class="col-lg-4 col-md-6">
                                <div class="course-card">
                                    <!-- Course Image -->
                                    <div class="course-image-container">
                                        <img src="assets/images/image1.png" alt="No Image" class="course-image">
                                    </div>

                                    <!-- Course Body -->
                                    <div class="course-body">
                                        <!-- Instructor Section -->
                                        <div class="instructor-section">
                                            <div class="instructor-avatar">
                                                <i class="fas fa-book-open"></i>
                                            </div>
                                            <div class="instructor-info">
                                                <h3 class="instructor-name">Month 1</h3>
                                            </div>
                                        </div>
                                        <ul>
                                            <li>Story concept & script writing</li>
                                            <li>Storyboarding & visual planning</li>
                                            <li>Mood boards & look development</li>
                                            <li>Scene planning & technical prep</li>
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>


                             <div class="col-lg-4 col-md-6">
                                <div class="course-card">
                                    <!-- Course Image -->
                                    <div class="course-image-container">
                                        
                                            <img src="assets/images/image2.png" alt="No Image"  class="course-image">
                                    </div>

                                    <!-- Course Body -->
                                    <div class="course-body">
                                        <!-- Instructor Section -->
                                        <div class="instructor-section">
                                            <div class="instructor-avatar">
                                                <i class="fas fa-book-open"></i>
                                            </div>
                                            <div class="instructor-info">
                                                <h3 class="instructor-name">Month 2</h3>
                                            </div>
                                        </div>
                                        <ul>

                                        <li>Environment building & layout</li>
                                        <li>Lighting & atmosphere setup</li>
                                        <li>Look development & materials</li>
                                        <li>Basic animation & blocking</li>

                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>


                             <div class="col-lg-4 col-md-6">
                                <div class="course-card">
                                    <!-- Course Image -->
                                    <div class="course-image-container">
                                        
                                            <img src="assets/images/image3.png" alt="No Image" class="course-image">
                                    </div>

                                    <!-- Course Body -->
                                    <div class="course-body">
                                        <!-- Instructor Section -->
                                        <div class="instructor-section">
                                            <div class="instructor-avatar">
                                                <i class="fas fa-book-open"></i>
                                            </div>
                                            <div class="instructor-info">
                                                <h3 class="instructor-name">Month 3</h3>
                                            </div>
                                        </div>
                                        <ul>
                                            <li>Camera work & cinematography</li>
                                            <li>Visual effects & particles</li>
                                            <li>Audio design & implementation</li>
                                            <li>Final rendering & post</li>
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-lg-12 col-md-12">
                                <div class="course-card">
                                    <!-- Course Image -->
  
                                       <h3  style="margin:0 auto;font-weight:600; padding-top:25px;">
                                            @if($course[0]->discount_rate && $course[0]->discount_rate < $course[0]->rate)
                                                PRICE: AED {{ number_format($course[0]->discount_rate) }}
                                            @elseif($course[0]->rate > 0)
                                                PRICE: AED {{ number_format($course[0]->rate) }}
                                            @else
                                                PRICE: FREE
                                            @endif
                                        </h3> 

                                        <!-- Enroll Button -->
                                        <a href="{{ route('purchase-course', $course[0]->id) }}" class="btn-enroll-now mt-3" style="margin:0 auto;width:50%;">
                                            BUY NOW
                                        </a>

                                    <!-- Course Body -->
                                    <div class="course-body">
                                        <!-- Instructor Section -->
                                        <div class="instructor-section">
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
        


                    </div> <!-- row end --->

           
    </div>
</section>

@endsection

@push('scripts')
{{--<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> --}}
<script>
</script>
@endpush
