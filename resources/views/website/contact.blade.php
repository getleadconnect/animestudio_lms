@extends('website.layout')

@section('title', 'Contact Us - AnimeStudio Learning Platform')

@push('styles')
<style>
    /* Hero Section */
    .contact-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        padding: 100px 0 80px;
        overflow: hidden;
    }

    .contact-hero::before {
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

    .contact-hero-content {
        position: relative;
        z-index: 2;
        color: white;
        text-align: center;
    }

    .contact-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .contact-hero p {
        font-size: 1.3rem;
        opacity: 0.95;
        max-width: 700px;
        margin: 0 auto;
    }

    /* Contact Section */
    .contact-section {
        padding: 5rem 0;
        background: #f8f9fa;
        margin-top: -50px;
        position: relative;
        z-index: 10;
    }

    /* Contact Info Cards */
    .contact-info-card {
        background: white;
        border-radius: 15px;
        padding: 2.5rem 2rem;
        text-align: center;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        height: 100%;
        transition: all 0.3s;
    }

    .contact-info-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
    }

    .contact-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
    }

    .contact-info-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .contact-info-text {
        font-size: 1rem;
        color: #666;
        line-height: 1.6;
    }

    .contact-info-text a {
        color: #667eea;
        text-decoration: none;
        word-break: break-all;
    }

    .contact-info-text a:hover {
        text-decoration: underline;
    }

    /* Contact Form */
    .contact-form-section {
        padding: 5rem 0;
        background: white;
    }

    .form-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
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
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 2px;
    }

    .section-subtitle {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 2.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 12px 18px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 15px 40px;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* Map Section */
    .map-section {
        padding: 5rem 0;
        background: #f8f9fa;
    }

    .map-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        height: 450px;
    }

    .map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* Alert Messages */
    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .contact-hero h1 {
            font-size: 2.5rem;
        }

        .contact-hero p {
            font-size: 1.1rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .form-card {
            padding: 2rem 1.5rem;
        }

        .map-container {
            height: 300px;
        }
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<div class="contact-hero">
    <div class="container">
        <div class="contact-hero-content">
            <h1>Contact Us</h1>
            <p>Get in touch with us. We're here to help you with your learning journey</p>
        </div>
    </div>
</div>

<!-- Contact Info Cards -->
<section class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="contact-info-title">Our Location</h3>
                    <p class="contact-info-text">
                        1018, Jln Sultan Ismail, Bandar Wawasan,<br>
                        50250 Kuala Lumpur, Wilayah Persekutuan<br>
                        Kuala Lumpur, Malaysia
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3 class="contact-info-title">Phone Number</h3>
                    <p class="contact-info-text">
                        <a href="tel:+919876543210">(+60) 11 3706 5047</a><br>
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="contact-info-title">Email Address</h3>
                    <p class="contact-info-text">
                        <a href="mailto:info@aimlearning.com">support@animestudio.io</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact-form-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    <h2 class="section-title">Send Us a Message</h2>
                    <p class="section-subtitle">Fill out the form below and we'll get back to you as soon as possible</p>

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('save-contact-us-message') }}" method="POST" id="contactForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter your name" required value="{{ old('name') }}">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="Enter your phone" required value="{{ old('phone') }}">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Subject *</label>
                                    <input type="text" name="subject" class="form-control" placeholder="Message subject" required value="{{ old('subject') }}">
                                    @error('subject')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Message *</label>
                            <textarea name="message" class="form-control" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane me-2"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Find Us on Map</h2>
            <p class="section-subtitle mt-4">Locate our main center</p>
        </div>

        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62424.17074420376!2d75.78639432167969!3d11.344839300000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba65bda9a5c3db9%3A0x5e3f3f3f8d8c8f8f!2sBalussery%2C%20Kerala!5e0!3m2!1sen!2sin!4v1234567890123!5m2!1sen!2sin"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

@endsection

@push('scripts')

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
    // Form submission handling
    document.getElementById('contactForm')?.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('.btn-submit');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sending...';
    });

setTimeout(function(){ $('.alert-success').hide();}, 3000);
setTimeout(function(){ $('.alert-error').hide();}, 3000);

</script>
@endpush
