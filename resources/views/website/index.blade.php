@extends('website.layout')

@section('title', 'AnimeStudio Learning Platform - Your Gateway to Success')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,133.3C672,139,768,181,864,197.3C960,213,1056,203,1152,176C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.8s;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        animation: fadeInUp 1s;
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

    /* Introduction Section */
    .introduction-section {
        background: #ffffff;
        padding: 80px 0;
    }

    .intro-image-wrapper {
        position: relative;
    }

    .intro-image {
        width: 100%;
        height: auto;
        border-radius: 0;
    }

    .intro-content {
        padding-left: 30px;
    }

    .intro-label {
        font-size: 14px;
        font-weight: 600;
        color: #999;
        letter-spacing: 2px;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .intro-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1c1d1f;
        line-height: 1.3;
        margin-bottom: 20px;
    }

    .intro-divider {
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #ffc107 0%, #ff9800 100%);
        margin-bottom: 25px;
    }

    .intro-description {
        font-size: 15px;
        line-height: 1.8;
        color: #6a6f73;
        margin-bottom: 20px;
        text-align: justify;
    }

    .btn-intro {
        background: transparent;
        color: #1c1d1f;
        border: 2px solid #1c1d1f;
        padding: 12px 35px;
        font-weight: 600;
        font-size: 14px;
        letter-spacing: 1px;
        border-radius: 0;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .btn-intro:hover {
        background: #1c1d1f;
        color: #ffffff;
        border-color: #1c1d1f;
    }

    @media (max-width: 768px) {
        .intro-content {
            padding-left: 0;
            margin-top: 30px;
        }

        .intro-title {
            font-size: 2rem;
        }

        .intro-description {
            text-align: left;
        }
    }

    .stats-section {
        background: var(--light-bg);
        padding: 60px 0;
    }

    .stat-card {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: var(--dark-color);
    }

    .courses-section {
        padding: 60px 0;
        background: #fff;
    }

    /* Category Tabs - Text with Pipe Separators */
    .category-tabs-text-wrapper {
        margin-bottom: 30px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .category-tabs-text-wrapper::-webkit-scrollbar {
        display: none;
    }

    .category-tabs-text-scroll {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0;
        padding: 15px 0;
    }

    .category-tab-text {
        color: #6a6f73;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
        padding: 8px 0;
        position: relative;
    }

    .category-tab-text:hover {
        color: #1c1d1f;
    }

    .category-tab-text.active {
        color: #1c1d1f;
        font-weight: 700;
    }

    .tab-separator {
        color: #d1d7dc;
        font-size: 16px;
        margin: 0 15px;
        user-select: none;
    }

    /* Courses Slider/Carousel */
    .courses-slider-wrapper {
        position: relative;
        margin-bottom: 30px;
        padding: 0 50px;
    }

    .courses-slider {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        scroll-behavior: smooth;
        scrollbar-width: none;
        -ms-overflow-style: none;
        padding: 10px 0;
    }

    .courses-slider::-webkit-scrollbar {
        display: none;
    }

    /* Slider Navigation Buttons */
    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: #d3d3d3;
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        color: #fff;
    }

    .slider-btn:hover {
        background: #b0b0b0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .slider-btn-prev {
        left: 0;
    }

    .slider-btn-next {
        right: 0;
    }

    .slider-btn i {
        font-size: 18px;
    }

    /* Modern Course Card */
    .modern-course-card {
        background: #fff;
        border: 1px solid #d1d7dc;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s;
        position: relative;
        min-width: 280px;
        max-width: 280px;
        flex-shrink: 0;
    }

    .modern-course-card:hover {
        box-shadow: 0 2px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    /* Course Image */
    .course-img-wrapper {
        width: 100%;
        height: 160px;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .course-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .modern-course-card:hover .course-img {
        transform: scale(1.05);
    }

    .course-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.8);
        font-size: 3rem;
    }

    /* Course Details */
    .course-details {
        padding: 16px;
        position: relative;
    }

    /* Course Name */
    .course-name {
        font-size: 16px;
        font-weight: 700;
        color: #1c1d1f;
        margin-bottom: 8px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 44px;
    }

    /* Course Description */
    .course-description {
        font-size: 13px;
        color: #6a6f73;
        line-height: 1.4;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 36px;
    }

    /* Course Duration */
    .course-duration {
        font-size: 12px;
        color: #6a6f73;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .course-duration i {
        color: #5624d0;
        font-size: 14px;
    }


    /* Price */
    .course-price-section {
        margin-top: auto;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .price-current {
        font-size: 18px;
        font-weight: 700;
        color: #1c1d1f;
    }

    .price-original {
        font-size: 14px;
        color: #6a6f73;
        text-decoration: line-through;
    }

    /* Buy Now Button */
    .btn-buy-now {
        display: block;
        width: 100%;
        padding: 10px 16px;
        background: #FFA500;
        color: white;
        text-align: center;
        border-radius: 6px;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-buy-now:hover {
        background: #FF8C00;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 165, 0, 0.4);
        color: white;
    }


    /* See More Button */
    .btn-see-more {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #5624d0;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none;
        padding: 12px 24px;
        border: 2px solid #5624d0;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .btn-see-more:hover {
        background: #5624d0;
        color: #fff;
    }

    .no-courses-found {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .no-courses-found i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #ddd;
    }

    .no-courses-found p {
        font-size: 1.1rem;
    }

    /* Old Course Card (keeping for compatibility) */
    .course-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s;
        height: 100%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .course-card img {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }

    .course-price {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--primary-color);
    }

    .course-discount {
        text-decoration: line-through;
        color: #999;
        margin-left: 0.5rem;
    }

    .features-section {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 80px 0;
    }

    .feature-box {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 10px;
        margin-bottom: 2rem;
        transition: all 0.3s;
    }

    .feature-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .feature-box i {
        font-size: 3rem;
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }

    .testimonial-card {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .testimonial-card img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1rem;
    }

    .cta-section {
        background: #f5f7fa;
        padding: 80px 0;
    }

    .cta-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 40px;
        text-align: center;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        max-width: 1368px;
        margin: 0 auto;
    }

    .cta-card h2 {
        color: white;
        margin-bottom: 20px;
    }

    .cta-card p {
        color: rgba(255, 255, 255, 0.95);
    }

    .btn-cta {
        background: white;
        color: #667eea;
        padding: 14px 35px;
        border-radius: 30px;
        font-weight: 700;
        border: none;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        color: #667eea;
    }

    .btn-outline-light {
        background: transparent;
        color: white;
        border: 2px solid white;
        padding: 12px 35px;
        border-radius: 30px;
        font-weight: 700;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-outline-light:hover {
        background: white;
        color: #667eea;
        transform: translateY(-3px);
    }

    /* Student Reviews Section */
    .reviews-section {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }

    .reviews-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.1);
    }

    .reviews-section .container {
        position: relative;
        z-index: 1;
    }

    .reviews-title {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .reviews-divider {
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #ffc107 0%, #ff9800 100%);
        margin: 0 auto 25px;
    }

    .reviews-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 16px;
        line-height: 1.8;
        max-width: 800px;
        margin: 0 auto;
    }

    .reviews-slider-wrapper {
        position: relative;
        margin-top: 50px;
        padding: 0 60px;
        max-width: 1368px;
        margin-left: auto;
        margin-right: auto;
    }

    .reviews-slider {
        display: flex;
        gap: 30px;
        overflow-x: scroll;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .reviews-slider::-webkit-scrollbar {
        display: none;
    }

    .review-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        padding: 25px;
        min-width: calc(50% - 15px);
        max-width: calc(50% - 15px);
        flex-shrink: 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .review-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .review-content {
        position: relative;
    }

    .review-quote-icon {
        color: rgba(30, 60, 114, 0.15);
        font-size: 3rem;
        margin-bottom: 15px;
    }

    .review-text {
        color: #444;
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 25px;
        min-height: 120px;
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-top: 20px;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .reviewer-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        flex-shrink: 0;
    }

    .reviewer-details {
        flex: 1;
    }

    .reviewer-name {
        color: #1c1d1f;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .reviewer-course {
        color: #ffa500;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 1px;
        margin: 0;
        text-transform: uppercase;
    }

    .review-slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        color: #1e3c72;
    }

    .review-slider-btn:hover {
        background: #ffffff;
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        transform: translateY(-50%) scale(1.1);
    }

    .review-slider-btn-prev {
        left: 0;
    }

    .review-slider-btn-next {
        right: 0;
    }

    .review-slider-btn i {
        font-size: 18px;
    }

    @media (max-width: 768px) {
        .reviews-slider-wrapper {
            padding: 0 50px;
        }

        .review-card {
            min-width: 100%;
            max-width: 100%;
            padding: 25px;
        }

        .reviews-title {
            font-size: 2rem;
        }

        .review-text {
            font-size: 14px;
            min-height: auto;
        }

        .reviewer-avatar {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }

        .reviewer-name {
            font-size: 16px;
        }

        .cta-card {
            padding: 40px 25px;
        }

        .cta-card h2 {
            font-size: 1.75rem;
        }
    }

.fa-ul {
  list-style: none; /* Remove default bullets */
  font-weight:400 !important;
}

.fa-ul li {
  font-weight:400 !important;
  line-height:35px;
  color:#6c6965 !important;
  font-size:15px;
}


.fa-li {
  color: #2ecc71; /* Green color for check icon */
}


</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="hero-content">
                        <h1 class="hero-title">
                        Transform Your Future with AnimeStudio Learning</h1>
                        <p class="hero-subtitle">At AnimeStudio, excellence comes to life through comprehensive courses, expert guidance, and personalized learning. We transform aspirations into achievements, helping you reach your career goals with confidence.
                            </p>
                        <a href="{{ url('/courses') }}" class="btn btn-light btn-lg me-3">Explore Courses</a>
                    </div>
                </div>
                <div class="col-md-6" style="align-item:center;">
                   <img src="{{ config('constants.banner_image').'banner-1.png'}}" alt="Learning" class="img-fluid rounded" style="float:right;height:450px !important;">
                </div>
            </div>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="introduction-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="intro-image-wrapper">
                        <img src="{{ asset('assets/first.jpg') }}" alt="Students Learning" class="img-fluid intro-image">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="intro-content">
                        <p class="intro-label">INTRODUCTION</p>
                        <h2 class="intro-title">Welcome To The Online Learning Source Of AnimeStudio</h2>
                        <div class="intro-divider"></div>
                        <p class="intro-description">
                            Our courses encompass a wide range of subjects and immerse students in comprehensive preparation across various competitive exams. Whether you're preparing for PSC exams, banking tests, or government job interviews, AnimeStudio's curriculum offers the perfect balance of theoretical knowledge and practical exam strategies.
                        </p>
                        <p class="intro-description">

                        <div class="row" >
                            <div class="col-md-5">
                        <ul class="fa-ul">
                           <li> <span class="fa-li"><i class="fas fa-check"></i></span> Qualification: Certificate</li>
                            <li><span class="fa-li"><i class="fas fa-check"></i></span> Study Duration: 12 weeks</li>
                            <li><span class="fa-li"><i class="fas fa-check"></i></span>Commitment: 12 hrs weekly</li>
                            <li><span class="fa-li"><i class="fas fa-check"></i></span>Skill Level: Beginner</li>
                            </ul>
                            </div>
                            <div class="col-md-7">
                            <ul class="fa-ul">
                            <li><span class="fa-li"><i class="fas fa-check"></i></span>Prerequisites: Basic computer skills</li>
                            <li><span class="fa-li"><i class="fas fa-check"></i></span>Delivery: Weekly online classes,<br>
                            feedback & support</li>
                            <li><span class="fa-li"><i class="fas fa-check"></i></span>Software: Unreal Engine</li>
                            </ul>
                            </div>
                        </div>

                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <i class="fas fa-users"></i>
                        <div class="stat-number">{{ number_format($totalStudents ?? 1000) }}+</div>
                        <p>Active Students</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <i class="fas fa-book"></i>
                        <div class="stat-number">{{ $totalCourses ?? 0 }}+</div>
                        <p>Courses Available</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <i class="fas fa-video"></i>
                        <div class="stat-number">{{ $totalVideos ?? 0 }}+</div>
                        <p>Video Tutorials</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <i class="fas fa-file-pdf"></i>
                        <div class="stat-number">{{ $totalPdfs ?? 0 }}+</div>
                        <p>PDF Notes</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Courses with Tabs -->
    <section class="courses-section">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="display-5 fw-bold">Popular Courses</h2>
                <p class="lead text-muted">Choose from our wide range of courses designed for your success</p>
            </div>

            @if(isset($categories) && count($categories) > 0)
            <!-- Category Tabs - Text with Pipe Separators -->
            <div class="category-tabs-text-wrapper mb-4">
                <div class="category-tabs-text-scroll">
                    <!-- All Courses Tab -->
                    <span class="category-tab-text active"
                          data-category-id="all"
                          onclick="loadCoursesByCategory('all', this)">
                        All Courses
                    </span>
                    <span class="tab-separator">|</span>

                    @foreach($categories as $index => $category)
                        <span class="category-tab-text"
                              data-category-id="{{ $category->id }}"
                              onclick="loadCoursesByCategory({{ $category->id }}, this)">
                            {{ $category->category }}
                        </span>
                        @if(!$loop->last)
                            <span class="tab-separator">|</span>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Courses Slider/Carousel -->
            <div class="courses-slider-wrapper">
                <button class="slider-btn slider-btn-prev" onclick="slideLeft()">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="courses-slider" id="coursesSlider">
                    @if(isset($allCourses) && count($allCourses) > 0)
                        @foreach($allCourses as $course)
                        <div class="modern-course-card" data-course-id="{{ $course->course_id }}">
                            <!-- Course Image -->
                            <div class="course-img-wrapper">
                                @if($course->course_square_icon)
                                    <img src="{{ config('constants.course_icon').$course->course_square_icon }}"
                                         alt="{{ $course->course_name }}"
                                         class="course-img">
                                @else
                                    <div class="course-img-placeholder">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Course Details -->
                            <div class="course-details">
                                <!-- Course Name -->
                                <h3 class="course-name">{{ $course->course_name }}</h3>

                                <!-- Course Description -->
                                <div class="course-description">
                                    {{ $course->description ?? 'Explore comprehensive learning materials and master new skills with our expertly designed course.' }}
                                </div>

                                <!-- Course Duration -->
                                <div class="course-duration">
                                    <i class="fas fa-calendar-alt"></i>
                                    @if(isset($course->start_date) && isset($course->end_date))
                                        {{ \Carbon\Carbon::parse($course->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($course->end_date)->format('d M Y') }}
                                    @else
                                        Duration: 6 Months
                                    @endif
                                </div>


                                <!-- Price -->
                                <div class="course-price-section">
                                    @if($course->discount_rate && $course->discount_rate < $course->rate)
                                        <span class="price-current">AED {{ number_format($course->discount_rate) }}</span>
                                        <span class="price-original">AED {{ number_format($course->rate) }}</span>
                                    @else
                                        <span class="price-current">AED {{ number_format($course->rate) }}</span>
                                    @endif
                                </div>

                                <!-- Buy Now Button -->
                                <a href="{{ route('purchase-course', $course->course_id) }}" class="btn-buy-now">
                                    <i class="fas fa-shopping-cart"></i> BUY NOW
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>

                <button class="slider-btn slider-btn-next" onclick="slideRight()">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No course categories available at the moment.
            </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Why Choose AnimeStudio Learning?</h2>
                <p class="lead">We provide the best learning experience for our students</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-laptop"></i>
                        <h4>Online Learning</h4>
                        <p>Access courses anytime, anywhere with our advanced online platform</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-users-cog"></i>
                        <h4>Expert Faculty</h4>
                        <p>Learn from experienced instructors with proven track records</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-clipboard-check"></i>
                        <h4>Mock Tests</h4>
                        <p>Practice with unlimited mock tests</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-video"></i>
                        <h4>Live Classes</h4>
                        <p>Interactive live sessions for better understanding and doubt clearing</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-mobile-alt"></i>
                        <h4>Mobile App</h4>
                        <p>Learn on the go with our feature-rich mobile application</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-certificate"></i>
                        <h4>Certification</h4>
                        <p>Get certified upon successful completion of courses</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories -->
    @if(isset($successStories) && count($successStories) > 0)
    <section class="courses-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Success Stories</h2>
                <p class="lead">Our students' achievements speak for themselves</p>
            </div>
            <div class="row">
                @foreach($successStories as $story)
                <div class="col-md-3 mb-4">
                    <div class="testimonial-card text-center">
                        @if($story->image)
                            <img src="{{ url('success_stories').'/'. $story->image }}" alt="{{ $story->name }}">
                        @else
                            <img src="" alt="{{ $story->name }}">
                        @endif
                        <h5>{{ $story->name }}</h5>
                        <p class="text-muted">{{ $story->place ?? 'Success Story' }}</p>
                        <p>{{ Str::limit($story->description, 100) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Student Reviews Section -->
    @if(isset($studentReviews) && count($studentReviews) > 0)
    <section class="reviews-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="reviews-title">Students Review</h2>
                <div class="reviews-divider"></div>
                <p class="reviews-subtitle">Able an hope of body. Any nay shyness article matters own removal nothing his forming. Gay own additions education satisfied the perpetual. If he cause manor happy. Without farther she exposed saw man led. Along on happy could cease green oh.</p>
            </div>

            <!-- Reviews Slider -->
            <div class="reviews-slider-wrapper">
                <button class="review-slider-btn review-slider-btn-prev" onclick="slideReviewsLeft()">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="reviews-slider" id="reviewsSlider">
                    @foreach($studentReviews as $review)
                    <div class="review-card">
                        <div class="review-content">
                            <div class="review-quote-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="review-text">{{ $review->review_text }}</p>
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="reviewer-details">
                                    <h5 class="reviewer-name">{{ $review->student_name }}</h5>
                                    <p class="reviewer-course">{{ $review->place ?? 'STUDENT' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button class="review-slider-btn review-slider-btn-next" onclick="slideReviewsRight()">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-card">
                <h2 class="display-5 fw-bold mb-4">Ready to Start Your Learning Journey?</h2>
                <p class="lead mb-4">Join thousands of successful students today</p>
                <a href="{{ url('/student-register') }}" class="btn btn-cta btn-lg me-3">Enroll Now</a>
                <a href="{{ url('/contact') }}" class="btn btn-outline-light btn-lg">Contact Us</a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Counter animation for stats
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.stat-number');
        const speed = 200;

        counters.forEach(counter => {
            const animate = () => {
                const value = +counter.innerText.replace(/[^0-9]/g, '');
                const data = +counter.getAttribute('data-target') || value;
                const time = data / speed;

                if(value < data) {
                    counter.innerText = Math.ceil(value + time) + '+';
                    setTimeout(animate, 1);
                } else {
                    counter.innerText = data + '+';
                }
            }

            // Start animation when element is in view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) {
                        animate();
                        observer.unobserve(entry.target);
                    }
                });
            });

            observer.observe(counter);
        });
    });

    // Load courses by category
    const coursesByCategory = @json($coursesByCategory ?? []);
    const allCourses = @json($allCourses ?? []);

    // Helper function to format date
    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        return date.toLocaleDateString('en-GB', options);
    }

    function loadCoursesByCategory(categoryId, buttonElement) {
        // Update active tab
        document.querySelectorAll('.category-tab-text').forEach(tab => {
            tab.classList.remove('active');
        });
        buttonElement.classList.add('active');

        // Get courses for this category
        let courses = [];
        if (categoryId === 'all') {
            courses = allCourses;
        } else {
            courses = coursesByCategory[categoryId] || [];
        }

        const coursesSlider = document.getElementById('coursesSlider');

        if (courses.length === 0) {
            coursesSlider.innerHTML = `
                <div class="no-courses-found" style="width: 100%; text-align: center;">
                    <i class="fas fa-book-open"></i>
                    <p>No courses available in this category yet.</p>
                </div>
            `;
            return;
        }

        // Build courses HTML
        let html = '';
        courses.forEach((course, index) => {
            const subjects = course.subjects_array || [];
            const displaySubjects = subjects.slice(0, 3);
            const remainingCount = subjects.length - 3;

            html += `
                <div class="modern-course-card" data-course-id="${course.course_id}">
                    <div class="course-img-wrapper">
                        ${course.course_square_icon ?
                            `<img src="{{ config('constants.course_icon') }}${course.course_square_icon}"
                                 alt="${course.course_name}"
                                 class="course-img">` :
                            `<div class="course-img-placeholder">
                                <i class="fas fa-graduation-cap"></i>
                            </div>`
                        }
                    </div>
                    <div class="course-details">
                        <h3 class="course-name">${course.course_name}</h3>
                        <div class="course-description">
                            ${course.description || 'Explore comprehensive learning materials and master new skills with our expertly designed course.'}
                        </div>
                        <div class="course-duration">
                            <i class="fas fa-calendar-alt"></i>
                            ${course.start_date && course.end_date ?
                                `${formatDate(course.start_date)} - ${formatDate(course.end_date)}` :
                                'Duration: 6 Months'
                            }
                        </div>
                        <div class="course-price-section">
                            ${course.discount_rate && course.discount_rate < course.rate ?
                                `<span class="price-current">AED ${Number(course.discount_rate).toLocaleString()}</span>
                                 <span class="price-original">AED ${Number(course.rate).toLocaleString()}</span>` :
                                `<span class="price-current">AED ${Number(course.rate).toLocaleString()}</span>`
                            }
                        </div>
                        <a href="{{ url('/purchase-course') }}/${course.course_id}" class="btn-buy-now">
                            <i class="fas fa-shopping-cart"></i> BUY NOW
                        </a>
                    </div>
                </div>
            `;
        });

        coursesSlider.innerHTML = html;

        // Reset scroll position
        coursesSlider.scrollLeft = 0;
    }

    // Slider navigation functions
    function slideLeft() {
        const slider = document.getElementById('coursesSlider');
        const scrollAmount = 300; // Scroll by 300px (about 1 card width)
        slider.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    }

    function slideRight() {
        const slider = document.getElementById('coursesSlider');
        const scrollAmount = 300; // Scroll by 300px (about 1 card width)
        slider.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }

    // Reviews Slider Navigation Functions with Smooth Scrolling
    function slideReviewsLeft() {
        const slider = document.getElementById('reviewsSlider');
        if (!slider) return;

        const cardWidth = slider.querySelector('.review-card').offsetWidth;
        const gap = 30; // Gap between cards
        const scrollAmount = (cardWidth + gap) * 2; // Scroll by 2 cards width

        slider.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    }

    function slideReviewsRight() {
        const slider = document.getElementById('reviewsSlider');
        if (!slider) return;

        const cardWidth = slider.querySelector('.review-card').offsetWidth;
        const gap = 30; // Gap between cards
        const scrollAmount = (cardWidth + gap) * 2; // Scroll by 2 cards width

        slider.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }
</script>
@endpush