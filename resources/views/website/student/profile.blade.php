@extends('website.layout')

@section('title', 'My Profile - AnimeStudio Learning Platform')

@push('styles')
<style>
    .profile-section {
        background: #f8f9fa;
        min-height: 80vh;
        padding: 40px 0;
    }

    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .profile-header h2 {
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 2rem;
    }

    .profile-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    .profile-card h4 {
        color: var(--dark-color);
        margin-bottom: 25px;
        font-weight: 600;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
        font-size: 1.3rem;
    }

    .profile-card h4 i {
        color: var(--primary-color);
        margin-right: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    .btn-update {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s;
        cursor: pointer;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }

    .info-display {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid var(--primary-color);
        margin-bottom: 15px;
    }

    .info-display label {
        font-weight: 600;
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 5px;
        display: block;
    }

    .info-display p {
        color: #333;
        font-size: 1rem;
        margin: 0;
        font-weight: 500;
    }

    .password-toggle {
        position: relative;
    }

    .password-toggle .toggle-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
    }

    .password-toggle .toggle-icon:hover {
        color: var(--primary-color);
    }

    .alert {
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
        border: none;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .password-requirements {
        font-size: 0.85rem;
        color: #666;
        margin-top: 5px;
        padding-left: 15px;
    }

    .password-requirements li {
        margin-bottom: 3px;
    }

    @media (max-width: 768px) {
        .profile-section {
            padding: 20px 0;
        }

        .profile-header {
            padding: 20px;
        }

        .profile-header h2 {
            font-size: 1.5rem;
        }

        .profile-card {
            padding: 20px;
        }

        .profile-card h4 {
            font-size: 1.1rem;
        }

        .btn-update, .btn-cancel {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>
@endpush

@section('content')
<section class="profile-section">
    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2><i class="fas fa-user-circle"></i> My Profile</h2>
                    <p class="mb-0">Manage your personal information and account settings</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
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
                <i class="fas fa-{{ $type === 'success' ? 'check-circle' : 'exclamation-triangle' }}"></i>
                {{ $text }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Personal Information Form -->
            <div class="col-md-6">
                <div class="profile-card">
                    <h4><i class="fas fa-user-edit"></i> Personal Information</h4>

                    <form action="{{ route('student.profile.update') }}" method="POST" id="profileForm">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $student->student_name ?? '') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $student->email ?? '') }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('mobile') is-invalid @enderror"
                                   id="mobile"
                                   name="mobile"
                                   value="{{ old('mobile', $student->mobile ?? '') }}"
                                   maxlength="10"
                                   pattern="[0-9]{10}"
                                   required>
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date"
                                   class="form-control @error('date_of_birth') is-invalid @enderror"
                                   id="date_of_birth"
                                   name="date_of_birth"
                                   value="{{ old('date_of_birth', $student->date_of_birth ?? '') }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="place" class="form-label">Place</label>
                            <input type="text"
                                   class="form-control @error('place') is-invalid @enderror"
                                   id="place"
                                   name="place"
                                   value="{{ old('place', $student->place ?? '') }}">
                            @error('place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn-update">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                            <a href="{{ route('student.dashboard') }}" class="btn-cancel">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="col-md-6">
                <div class="profile-card">
                    <h4><i class="fas fa-key"></i> Change Password</h4>

                    <form action="{{ route('student.profile.update') }}" method="POST" id="passwordForm">
                        @csrf

                        <!-- Hidden fields to maintain other data -->
                        <input type="hidden" name="name" value="{{ $student->student_name ?? '' }}">
                        <input type="hidden" name="email" value="{{ $student->email ?? '' }}">
                        <input type="hidden" name="mobile" value="{{ $student->mobile ?? '' }}">
                        <input type="hidden" name="date_of_birth" value="{{ $student->date_of_birth ?? '' }}">
                        <input type="hidden" name="place" value="{{ $student->place ?? '' }}">

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Leave password fields empty if you don't want to change your password.
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">New Password</label>
                            <div class="password-toggle">
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password">
                                <i class="fas fa-eye toggle-icon" onclick="togglePassword('password')"></i>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <ul class="password-requirements">
                                <li>Minimum 6 characters</li>
                                <li>Must match confirmation password</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <div class="password-toggle">
                                <input type="password"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       id="password_confirmation"
                                       name="password_confirmation">
                                <i class="fas fa-eye toggle-icon" onclick="togglePassword('password_confirmation')"></i>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn-update">
                                <i class="fas fa-lock"></i> Update Password
                            </button>
                            <button type="reset" class="btn-cancel">
                                <i class="fas fa-undo"></i> Clear
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Information Display -->
                <div class="profile-card">
                    <h4><i class="fas fa-info-circle"></i> Account Information</h4>

                    <div class="info-display">
                        <label>Student ID</label>
                        <p>#{{ $student->id ?? 'N/A' }}</p>
                    </div>

                    <div class="info-display">
                        <label>Account Status</label>
                        <p>
                            @if(($student->status ?? 0) == 1)
                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Inactive</span>
                            @endif
                        </p>
                    </div>

                    <div class="info-display">
                        <label>Member Since</label>
                        <p>{{ \Carbon\Carbon::parse($student->created_at ?? now())->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling;

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Form validation for password form
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;

        if (password || passwordConfirm) {
            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long!');
                return false;
            }
        }
    });

    // Mobile number validation
    document.getElementById('mobile').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 10);
    });

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endpush
