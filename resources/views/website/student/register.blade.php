@extends('website.layout')

@section('title', 'Student Registration - AnimeStudio Learning Platform')

@push('styles')
<style>
    .register-section {
        min-height: 70vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 0;
    }

    .register-card {
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }

    .register-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .register-header i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 15px;
    }

    .register-header h3 {
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

    .btn-register {
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

    .btn-register:hover {
        background: #357abd;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(74, 144, 226, 0.3);
    }

    .login-prompt {
        text-align: center;
        margin-top: 25px;
        padding-top: 25px;
        border-top: 1px solid #e0e0e0;
    }

    .login-prompt a {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
    }

    .login-prompt a:hover {
        text-decoration: underline;
    }

    .alert {
        border-radius: 8px;
        border: none;
        padding: 12px 20px;
    }

    .password-strength {
        height: 5px;
        border-radius: 3px;
        margin-top: 5px;
        transition: all 0.3s;
    }

    .text-muted {
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')
    <section class="register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7">
                    <div class="register-card">
                        <div class="register-header">
                            <i class="fas fa-user-plus"></i>
                            <h3>Student Registration</h3>
                            <p class="text-muted">Create your account to start learning</p>
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

                        <form method="POST" action="{{ route('student.register.submit') }}" id="registerForm">
                            @csrf

                              <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="student_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text"
                                               class="form-control @error('student_name') is-invalid @enderror"
                                               id="student_name"
                                               name="student_name"
                                               placeholder="Enter your full name"
                                               value="{{ old('student_name') }}"
                                               required>
                                    </div>
                                    @error('student_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="email"
                                               name="email"
                                               placeholder="your.email@example.com"
                                               value="{{ old('email') }}"
                                               required>
                                    </div>
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        <input type="tel"
                                               class="form-control @error('mobile') is-invalid @enderror"
                                               id="mobile"
                                               name="mobile"
                                               placeholder="10 digit mobile number"
                                               value="{{ old('mobile') }}"
                                               maxlength="10"
                                               pattern="[0-9]{10}"
                                               required>
                                    </div>
                                    @error('mobile')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="date"
                                               class="form-control @error('date_of_birth') is-invalid @enderror"
                                               id="date_of_birth"
                                               name="date_of_birth"
                                               value="{{ old('date_of_birth') }}">
                                    </div>
                                    @error('date_of_birth')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="place" class="form-label">Place</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text"
                                               class="form-control @error('place') is-invalid @enderror"
                                               id="place"
                                               name="place"
                                               placeholder="City/Town"
                                               value="{{ old('place') }}">
                                    </div>
                                    @error('place')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               placeholder="Min 6 characters"
                                               required>
                                        <span class="input-group-text" onclick="togglePassword('password')" style="cursor: pointer; border-left: none;">
                                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                        </span>
                                    </div>
                                    <div class="password-strength" id="passwordStrength"></div>
                                    <small class="text-muted">Password must be at least 6 characters</small>
                                    @error('password')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password"
                                               class="form-control"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               placeholder="Re-enter password"
                                               required>
                                        <span class="input-group-text" onclick="togglePassword('password_confirmation')" style="cursor: pointer; border-left: none;">
                                            <i class="fas fa-eye" id="togglePasswordConfirmIcon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    {{--I agree to the <a href="{{ route('terms') }}" target="_blank">Terms & Conditions</a> and <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>--}}
                                    I agree to the Terms & Conditions and Privacy Policy.
                                </label>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-register">
                                    <i class="fas fa-user-plus"></i> Register
                                </button>
                            </div>
                        </form>

                        <div class="login-prompt">
                            <p>Already have an account? <a href="{{ route('student.login') }}">Login Here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
<script>
    // Auto-format mobile number (only digits)
    document.getElementById('mobile').addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '');
    });

    // Toggle password visibility
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const icon = fieldId === 'password' ? document.getElementById('togglePasswordIcon') : document.getElementById('togglePasswordConfirmIcon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Password strength indicator
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const strengthBar = document.getElementById('passwordStrength');

        let strength = 0;
        if (password.length >= 6) strength++;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        strengthBar.style.width = (strength * 20) + '%';

        if (strength <= 1) {
            strengthBar.style.backgroundColor = '#dc3545';
        } else if (strength <= 3) {
            strengthBar.style.backgroundColor = '#ffc107';
        } else {
            strengthBar.style.backgroundColor = '#28a745';
        }
    });

    // Form validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match!');
            return false;
        }

        if (password.length < 6) {
            e.preventDefault();
            alert('Password must be at least 6 characters long!');
            return false;
        }
    });
</script>
@endpush
