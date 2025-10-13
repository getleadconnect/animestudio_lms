@extends('website.layout')

@section('title', 'Our Courses - AnimeStudio Learning Platform')

@push('styles')
<style>
    /* Modern Page Header with Gradient */
    .courses-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        padding: 80px 0 100px;
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
        height: 240px;
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
        font-size: 1rem;
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

    /* Top Categories Section */
    .top-categories-section {
        background: white;
        padding: 4rem 0;
        margin-top: -80px;
        position: relative;
        z-index: 10;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #f39c12, #ffd700);
        border-radius: 2px;
    }

    .section-subtitle {
        color: #666;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 1.5rem auto 0;
    }

    .categories-slider-wrapper {
        position: relative;
        padding: 0 20px;
    }

    .categories-slider {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        scroll-behavior: smooth;
        scrollbar-width: none;
        padding: 20px 10px;
        -webkit-overflow-scrolling: touch;
        cursor: grab;
        user-select: none;
    }

    .categories-slider:active {
        cursor: grabbing;
    }

    .categories-slider::-webkit-scrollbar {
        display: none;
    }

    .category-card {
        flex: 0 0 280px;
        background: white;
        border-radius: 15px;
        padding: 2rem 1.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid #f0f0f0;
        text-align: center;
    }

    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.2);
        border-color: #667eea;
    }

    .category-card.active {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea10, #764ba210);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.25);
    }

    .category-card-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea15, #764ba215);
        border-radius: 50%;
        transition: all 0.3s;
    }

    .category-card:hover .category-card-icon {
        background: linear-gradient(135deg, #667eea, #764ba2);
        transform: scale(1.1) rotate(5deg);
    }

    .category-card-icon i {
        font-size: 32px;
        color: #667eea;
        transition: all 0.3s;
    }

    .category-card:hover .category-card-icon i {
        color: white;
    }

    .category-card-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.8rem;
        line-height: 1.3;
    }

    .category-card-count {
        font-size: 0.95rem;
        color: #666;
        font-weight: 500;
    }

    .category-card-count strong {
        color: #667eea;
        font-weight: 700;
    }

    /* Slider Navigation Buttons */
    .slider-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 45px;
        height: 45px;
        background: white;
        border: 2px solid #667eea;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .slider-nav-btn:hover {
        background: linear-gradient(135deg, #667eea, #764ba2);
        transform: translateY(-50%) scale(1.1);
    }

    .slider-nav-btn i {
        color: #667eea;
        font-size: 18px;
        transition: all 0.3s;
    }

    .slider-nav-btn:hover i {
        color: white;
    }

    .slider-nav-btn.prev {
        left: -10px;
    }

    .slider-nav-btn.next {
        right: -10px;
    }

    @media (max-width: 768px) {
        .slider-nav-btn {
            display: none;
        }

        .categories-slider {
            gap: 15px;
        }

        .category-card {
            flex: 0 0 240px;
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

    .select-category-message i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        color: #ddd;
    }

    .select-category-message h3 {
        font-size: 1.8rem;
        color: #666;
        margin-bottom: 0.5rem;
    }

    .select-category-message p {
        font-size: 1.1rem;
        color: #999;
    }

    .category-courses-header {
        margin-bottom: 2.5rem;
        text-align: center;
    }

    .category-courses-header h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        position: relative;
        display: inline-block;
        padding-bottom: 1rem;
    }

    .category-courses-header h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 2px;
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

            <div class="hero-stats">
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
            </div>
        </div>
    </div>
</div>

<!-- Top Categories Section -->
<section class="top-categories-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Top Categories</h2>
            <p class="section-subtitle">
                Discover courses across various fields and find the perfect fit for your learning journey
            </p>
        </div>

        <div class="categories-slider-wrapper">
            <!-- Previous Button -->
            <div class="slider-nav-btn prev" onclick="scrollCategories('prev')">
                <i class="fas fa-chevron-left"></i>
            </div>

            <!-- Categories Slider -->
            <div class="categories-slider" id="categoriesSlider">
                @foreach($categories as $category)
                    @if(isset($coursesByCategory[$category->id]) && count($coursesByCategory[$category->id]) > 0)
                        @php
                            $categoryIcons = [
                                'Software Engineering' => 'fa-code',
                                'Programming' => 'fa-laptop-code',
                                'PSC' => 'fa-university',
                                'Banking' => 'fa-building-columns',
                                'SSC' => 'fa-file-contract',
                                'Railway' => 'fa-train',
                                'LDC' => 'fa-clipboard-list',
                                'Tenth' => 'fa-school',
                                'Plus Two' => 'fa-graduation-cap',
                                'Engineering' => 'fa-cogs',
                                'Medical' => 'fa-briefcase-medical',
                                'default' => 'fa-book-open'
                            ];

                            $iconClass = $categoryIcons[$category->category] ?? $categoryIcons['default'];
                            $courseCount = count($coursesByCategory[$category->id]);
                        @endphp

                        <div class="category-card" onclick="showCategoryTab({{ $category->id }})">
                            <div class="category-card-icon">
                                <i class="fas {{ $iconClass }}"></i>
                            </div>
                            <h3 class="category-card-title">{{ $category->category }}</h3>
                            <p class="category-card-count">
                                (<strong>{{ $courseCount }}</strong>) {{ $courseCount == 1 ? 'Course' : 'Courses' }}
                            </p>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Next Button -->
            <div class="slider-nav-btn next" onclick="scrollCategories('next')">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
    </div>
</section>

<!-- Courses Display Section -->
<section class="courses-display-section">
    <div class="container">
        <div id="coursesContainer">
            <!-- Courses will be displayed here when a category is clicked -->
            <div class="select-category-message">
                <i class="fas fa-mouse-pointer"></i>
                <h3>Select a Category</h3>
                <p>Click on any category above to view available courses</p>
            </div>
        </div>

        <!-- Hidden course templates for each category -->
        @foreach($categories as $category)
            @if(isset($coursesByCategory[$category->id]) && count($coursesByCategory[$category->id]) > 0)
                <div id="category-courses-{{ $category->id }}" class="category-courses-content" style="display: none;">
                    <div class="category-courses-header">
                        <h2>{{ $category->category }} Courses</h2>
                    </div>

                    <div class="row g-4">
                        @foreach($coursesByCategory[$category->id] as $course)
                            <div class="col-lg-4 col-md-6">
                                <div class="course-card">
                                    <!-- Course Image -->
                                    <div class="course-image-container">
                                        @if($course->course_wide_icon)
                                            <img src="{{ config('constants.course_icon') . $course->course_wide_icon }}"
                                                 alt="{{ $course->course_name }}"
                                                 class="course-image"
                                                 onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop'">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop"
                                                 alt="{{ $course->course_name }}"
                                                 class="course-image">
                                        @endif

                                        <!-- Price Badge -->
                                        <div class="course-price-badge" style="font-size:16px;font-weight:600;">
                                            @if($course->discount_rate && $course->discount_rate < $course->rate)
                                                PRICE: ₹{{ number_format($course->discount_rate) }}
                                            @elseif($course->rate > 0)
                                                PRICE: ₹{{ number_format($course->rate) }}
                                            @else
                                                PRICE: FREE
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Course Body -->
                                    <div class="course-body">
                                        <!-- Instructor Section -->
                                        <div class="instructor-section">
                                            <div class="instructor-avatar">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                            <div class="instructor-info">
                                                <h4 class="instructor-name">AnimeStudio Learning</h4>
                                            </div>
                                        </div>

                                        <!-- Course Title -->
                                        <h3 class="course-title">{{ $course->course_name }}</h3>

                                        <!-- Description -->
                                        <p class="course-description">
                                            {{ $course->description ? strip_tags($course->description) : 'Comprehensive course designed to enhance your skills and knowledge with expert guidance and practical learning.' }}
                                        </p>

                                        <!-- Course Stats -->
                                     <div class="d-flex justify-content-between mb-2">
                        <span>Course Price:</span>
                         <span><span class="text-decoration-line-through text-muted">₹{{number_format($course->rate)}}</span>&nbsp;&nbsp;₹{{ number_format($course->discount_rate) }}</span>
                    </div>
                                        <!-- Enroll Button -->
                                        <a href="{{ route('purchase-course', $course->id) }}" class="btn-enroll-now">
                                            ENROLL NOW
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script>
    // Initialize AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });

    // Categories Slider Navigation
    function scrollCategories(direction) {
        const slider = document.getElementById('categoriesSlider');
        const categoryCards = Array.from(document.querySelectorAll('.category-card'));
        const activeCard = document.querySelector('.category-card.active');

        if (!activeCard || categoryCards.length === 0) return;

        const currentIndex = categoryCards.indexOf(activeCard);
        let nextIndex;

        if (direction === 'prev') {
            nextIndex = currentIndex > 0 ? currentIndex - 1 : categoryCards.length - 1;
        } else {
            nextIndex = currentIndex < categoryCards.length - 1 ? currentIndex + 1 : 0;
        }

        const nextCard = categoryCards[nextIndex];

        // Scroll the card into view
        nextCard.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });

        // Extract category ID and trigger the tab switch
        const onclickAttr = nextCard.getAttribute('onclick');
        const categoryIdMatch = onclickAttr.match(/showCategoryTab\((\d+)\)/);

        if (categoryIdMatch) {
            const categoryId = categoryIdMatch[1];

            // Remove active class from all cards
            categoryCards.forEach(card => card.classList.remove('active'));

            // Add active class to next card
            nextCard.classList.add('active');

            // Load the courses for the new category
            const coursesContainer = document.getElementById('coursesContainer');
            const categoryContent = document.getElementById('category-courses-' + categoryId);

            if (categoryContent && coursesContainer) {
                const clonedContent = categoryContent.cloneNode(true);
                clonedContent.style.display = 'block';
                clonedContent.removeAttribute('id');

                coursesContainer.innerHTML = '';
                coursesContainer.appendChild(clonedContent);

                // Smooth scroll to courses section
                const coursesSection = document.querySelector('.courses-display-section');
                if (coursesSection) {
                    const offset = 100;
                    const elementPosition = coursesSection.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - offset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }

                // Reinitialize AOS for new content
                if (typeof AOS !== 'undefined') {
                    AOS.refresh();
                }
            }
        }
    }

    // Show category tab courses
    function showCategoryTab(categoryId) {
        // Remove active class from all category cards
        document.querySelectorAll('.category-card').forEach(card => {
            card.classList.remove('active');
        });

        // Add active class to clicked card
        event.currentTarget.classList.add('active');

        // Hide all course contents
        document.querySelectorAll('.category-courses-content').forEach(content => {
            content.style.display = 'none';
        });

        // Get the courses container
        const coursesContainer = document.getElementById('coursesContainer');
        const categoryContent = document.getElementById('category-courses-' + categoryId);

        if (categoryContent) {
            // Clone and show the category content
            const clonedContent = categoryContent.cloneNode(true);
            clonedContent.style.display = 'block';
            clonedContent.removeAttribute('id');

            coursesContainer.innerHTML = '';
            coursesContainer.appendChild(clonedContent);

            // Smooth scroll to courses section
            const coursesSection = document.querySelector('.courses-display-section');
            if (coursesSection) {
                const offset = 100;
                const elementPosition = coursesSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - offset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }

            // Reinitialize AOS for new content
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        }
    }

    // Auto-hide navigation buttons at scroll edges
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('categoriesSlider');
        const prevBtn = document.querySelector('.slider-nav-btn.prev');
        const nextBtn = document.querySelector('.slider-nav-btn.next');

        if (slider && prevBtn && nextBtn) {
            function updateButtons() {
                const atStart = slider.scrollLeft <= 0;
                const atEnd = slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 5;

                prevBtn.style.opacity = atStart ? '0.3' : '1';
                prevBtn.style.pointerEvents = atStart ? 'none' : 'all';

                nextBtn.style.opacity = atEnd ? '0.3' : '1';
                nextBtn.style.pointerEvents = atEnd ? 'none' : 'all';
            }

            slider.addEventListener('scroll', updateButtons);
            updateButtons(); // Initial check
        }

        // Load first category courses by default
        const firstCategoryCard = document.querySelector('.category-card');
        if (firstCategoryCard) {
            // Get the category ID from onclick attribute
            const onclickAttr = firstCategoryCard.getAttribute('onclick');
            const categoryIdMatch = onclickAttr.match(/showCategoryTab\((\d+)\)/);

            if (categoryIdMatch) {
                const firstCategoryId = categoryIdMatch[1];

                // Mark first category as active
                firstCategoryCard.classList.add('active');

                // Load first category courses
                const coursesContainer = document.getElementById('coursesContainer');
                const categoryContent = document.getElementById('category-courses-' + firstCategoryId);

                if (categoryContent && coursesContainer) {
                    const clonedContent = categoryContent.cloneNode(true);
                    clonedContent.style.display = 'block';
                    clonedContent.removeAttribute('id');

                    coursesContainer.innerHTML = '';
                    coursesContainer.appendChild(clonedContent);
                }
            }
        }
    });

    // Touch/drag scrolling for categories slider
    const slider = document.getElementById('categoriesSlider');
    let isDown = false;
    let startX;
    let scrollLeft;

    if (slider) {
        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.style.cursor = 'grabbing';
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.style.cursor = 'grab';
        });

        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.style.cursor = 'grab';
        });

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });
    }
</script>
@endpush
