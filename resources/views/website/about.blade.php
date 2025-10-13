@extends('website.layout')

@section('title', 'About Us - AnimeStudio Learning Platform')

@push('styles')
<style>
    /* Hero Section */
    .about-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        padding: 100px 0 80px;
        overflow: hidden;
    }

    .about-hero::before {
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

    .about-hero-content {
        position: relative;
        z-index: 2;
        color: white;
        text-align: center;
    }

    .about-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .about-hero p {
        font-size: 1.3rem;
        opacity: 0.95;
        max-width: 700px;
        margin: 0 auto;
    }

    /* Statistics Section */
    .stats-section {
        background: white;
        padding: 4rem 0;
        margin-top: -50px;
        position: relative;
        z-index: 10;
    }

    .stats-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        padding: 3rem;
    }

    .stat-item {
        text-align: center;
        padding: 2rem 1rem;
    }

    .stat-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #667eea20, #764ba220);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #667eea;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        color: #2c3e50;
        display: block;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1.1rem;
        color: #666;
        font-weight: 500;
    }

    /* About Content Section */
    .about-content-section {
        padding: 5rem 0;
        background: #f8f9fa;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 2px;
    }

    .about-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #666;
        margin-bottom: 1.5rem;
    }

    .about-image {
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        width: 100%;
        height: auto;
    }

    /* Mission Vision Section */
    .mission-vision-section {
        padding: 5rem 0;
        background: white;
    }

    .mission-vision-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        height: 100%;
        transition: all 0.3s;
    }

    .mission-vision-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
    }

    .mission-vision-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin-bottom: 1.5rem;
    }

    .mission-vision-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .mission-vision-text {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #666;
    }

    /* Features Section */
    .features-section {
        padding: 5rem 0;
        background: #f8f9fa;
    }

    .feature-card {
        background: white;
        border-radius: 15px;
        padding: 2.5rem 2rem;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        height: 100%;
        transition: all 0.3s;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.15);
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #667eea15, #764ba215);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #667eea;
    }

    .feature-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .feature-text {
        font-size: 0.95rem;
        line-height: 1.6;
        color: #666;
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 5rem 0;
        text-align: center;
        color: white;
    }

    .cta-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .cta-text {
        font-size: 1.2rem;
        opacity: 0.95;
        margin-bottom: 2rem;
    }

    .btn-cta {
        background: white;
        color: #667eea;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }

    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        color: #667eea;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .about-hero h1 {
            font-size: 2.5rem;
        }

        .about-hero p {
            font-size: 1.1rem;
        }

        .stat-number {
            font-size: 2.5rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .stats-container {
            padding: 2rem 1rem;
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
}


.fa-li {
  color: #2ecc71; /* Green color for check icon */
}

</style>
@endpush

@section('content')

<!-- Hero Section -->
<div class="about-hero">
    <div class="container">
        <div class="about-hero-content">
            <h1>About AnimeStudio Learning</h1>
            <p>Empowering students with quality education and comprehensive learning resources to achieve their goals</p>
        </div>
    </div>
</div>


<!-- About Content Section -->
<section class="about-content-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="section-title">Who We Are</h2>
                <p class="about-text">
                   Our courses encompass a wide range of subjects and immerse students in comprehensive preparation across various competitive exams. Whether you're preparing for PSC exams, banking tests, or government job interviews, AnimeStudio's curriculum offers the perfect balance of theoretical knowledge and practical exam strategies.
                </p>
               
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
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&auto=format&fit=crop"
                     alt="AnimeStudio Learning"
                     class="about-image">
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="mission-vision-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="mission-vision-card">
                    <div class="mission-vision-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="mission-vision-title">Our Mission</h3>
                    <p class="mission-vision-text">
                        To provide accessible, affordable, and high-quality education that empowers students to achieve their
                        academic and professional goals. We are committed to making quality education available to everyone,
                        regardless of their location or background.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mission-vision-card">
                    <div class="mission-vision-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="mission-vision-title">Our Vision</h3>
                    <p class="mission-vision-text">
                        To become the leading learning platform in India, recognized for excellence in education delivery
                        and student success. We envision a future where every student has access to world-class educational
                        resources and personalized learning experiences.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Why Choose AnimeStudio Learning?</h2>
            <p class="about-text mt-4">We offer comprehensive learning solutions designed for your success</p>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h4 class="feature-title">Expert Instructors</h4>
                    <p class="feature-text">
                        Learn from {{ $totalInstructors }}+ experienced educators and industry professionals
                        who are passionate about teaching
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h4 class="feature-title">Online Learning</h4>
                    <p class="feature-text">
                        Access courses anytime, anywhere with our flexible online platform and mobile app
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h4 class="feature-title">Quality Content</h4>
                    <p class="feature-text">
                        Comprehensive study materials, video lessons, and practice tests designed for exam success
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4 class="feature-title">Flexible Schedule</h4>
                    <p class="feature-text">
                        Learn at your own pace with 24/7 access to course materials and recorded sessions
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4 class="feature-title">Student Support</h4>
                    <p class="feature-text">
                        Get assistance when you need it with our dedicated student support team
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <h4 class="feature-title">Affordable Pricing</h4>
                    <p class="feature-text">
                        Quality education at competitive prices with flexible payment options
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2 class="cta-title">Ready to Start Learning?</h2>
        <p class="cta-text">Join thousands of students who are achieving their goals with AnimeStudio Learning</p>
        <a href="{{ route('courses') }}" class="btn-cta">
            Explore Courses <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</section>

@endsection
