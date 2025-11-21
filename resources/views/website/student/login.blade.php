@extends('website.layout')

@section('title', 'Student Login - AnimeStudio Learning Platform')

@push('styles')
<style>
    .login-section {
        min-height: 70vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 0;
    }

    .login-card {
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-header i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 15px;
    }

    .login-header h3 {
        color: var(--dark-color);
        font-weight: bold;
    }

    .form-label {
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 8px;
    }

    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
    }

    .input-group-text {
        background: white;
        border: 2px solid #e0e0e0;
        border-right: none;
        border-radius: 8px 0 0 8px;
        color: var(--primary-color);
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 8px 8px 0;
    }

    .btn-login {
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-login:hover {
        background: #357abd;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(74, 144, 226, 0.3);
    }

    .form-check-label {
        color: #666;
    }

    .forgot-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }

    .register-prompt {
        text-align: center;
        margin-top: 25px;
        padding-top: 25px;
        border-top: 1px solid #e0e0e0;
    }

    .register-prompt a {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
    }

    .register-prompt a:hover {
        text-decoration: underline;
    }

    .alert {
        border-radius: 8px;
        border: none;
        padding: 12px 20px;
    }

    .social-login {
        margin-top: 20px;
        text-align: center;
    }

    .social-login p {
        color: #999;
        margin-bottom: 15px;
        position: relative;
    }

    .social-login p::before,
    .social-login p::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 100px;
        height: 1px;
        background: #e0e0e0;
    }

    .social-login p::before {
        left: 0;
    }

    .social-login p::after {
        right: 0;
    }

</style>
@endpush

@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="login-card">
                        <div class="login-header">
                            <i class="fas fa-user-graduate"></i>
                            <h3>Student Login</h3>
                            <p class="text-muted">Access your learning dashboard</p>
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

                        <form method="POST" action="{{ route('student.login.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                    <input type="email"
                                           class="form-control @error('mobile') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           placeholder="Enter email address"
                                           value="{{ old('email') }}"
                                           required>
                                </div>
                                @error('mobile')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="Enter your password"
                                           required>
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                           <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                               {{--<!-- <a href="{{ route('student.forgot-password') }}" class="forgot-link">
                                    Forgot Password?
                                </a> -->--}}
                            </div> 

                            <div class="mb-3">
                                <button type="submit" class="btn btn-login">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>
                            </div>
                        </form>

                        <div class="register-prompt">
                            <p>Don't have an account? <a href="{{ route('student.register') }}">Register Now</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Auto-format mobile number
    /*document.getElementById('mobile').addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '');
    });*/

    // Show/Hide password
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
    }
</script>
@endpush