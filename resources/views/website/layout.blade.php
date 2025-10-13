<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'AnimeStudio Learning Platform - Your Gateway to Success')</title>

    <!-- Bootstrap CSS -->
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f39c12;
            --dark-color: #2c3e50;
            --light-bg: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link {
            color: var(--dark-color) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-primary-custom {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            background: #357abd;
            transform: translateY(-2px);
        }

        .footer {
            background: var(--dark-color);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 5rem;
        }

        .footer h5 {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .footer a {
            color: #ecf0f1;
            text-decoration: none;
            transition: color 0.3s;
            display: inline-block;
        }

        .footer a:hover {
            color: var(--secondary-color);
            transform: translateX(5px);
        }

        .footer ul li {
            margin-bottom: 0.8rem;
        }

        .footer ul li i.fa-chevron-right {
            font-size: 0.7rem;
            color: var(--secondary-color);
        }

        .footer .contact-info li {
            display: flex;
            align-items: flex-start;
        }

        .footer .contact-info li i {
            color: var(--secondary-color);
            width: 20px;
            margin-top: 2px;
        }

        .social-links a {
            display: inline-block;
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.1);
            text-align: center;
            line-height: 35px;
            border-radius: 50%;
            margin-right: 0.5rem;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{url('assets/animestudio-logo-white.png')}}" style="width:60px;height:60px;padding:5px;background:#949292;">
                AnimeStudio
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/courses') }}">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/contact') }}">Contact</a>
                    </li>
                    @auth('student')
                        <li class="nav-item dropdown ms-2">
                            <a class="btn btn-primary-custom dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> My Account
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('student.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('student.profile') }}">
                                        <i class="fas fa-user me-2"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('student.delete-account') }}">
                                        <i class="fas fa-user-times me-2"></i> Delete Account
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('student.logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary-custom" href="{{ route('student.login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Student Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="padding-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>About AnimeStudio Learning</h5>
                    <p>Empowering students with quality education and comprehensive learning resources to achieve their career goals.</p>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/about') }}"><i class="fas fa-chevron-right me-2"></i> About Us</a></li>
                        <li><a href="{{ url('/courses') }}"><i class="fas fa-chevron-right me-2"></i> Our Courses</a></li>
                        <li><a href="{{ url('/contact') }}"><i class="fas fa-chevron-right me-2"></i> Contact</a></li>
                        <li><a href="{{ url('/login') }}"><i class="fas fa-chevron-right me-2"></i> Login</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Contact Info</h5>
                    <ul class="list-unstyled contact-info">
                        <li><i class="fas fa-map-marker-alt"></i> <span>Your Address Here</span></li>
                        <li><i class="fas fa-phone"></i> <span>+91 1234567890</span></li>
                        <li><i class="fas fa-envelope"></i> <span>info@aimlearning.com</span></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="background-color: rgba(255,255,255,0.1);">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2025 AnimeStudio Learning Platform. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ url('/privacy-policy') }}" class="me-3">Privacy Policy</a>
                    <a href="{{ url('/terms') }}">Terms & Conditions</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>-->

    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>
</html>