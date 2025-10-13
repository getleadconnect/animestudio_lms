@extends('website.layout')

@section('title', 'Delete Account - AnimeStudio Learning Platform')

@push('styles')
<style>
    .delete-account-section {
        background: #f8f9fa;
        min-height: 80vh;
        padding: 40px 0;
    }

    .delete-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .delete-header h2 {
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 2rem;
    }

    .delete-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    .delete-card h4 {
        color: var(--dark-color);
        margin-bottom: 25px;
        font-weight: 600;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
        font-size: 1.3rem;
    }

    .delete-card h4 i {
        color: #dc3545;
        margin-right: 10px;
    }

    .warning-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .warning-box h5 {
        color: #856404;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .warning-box ul {
        margin-bottom: 0;
        padding-left: 20px;
    }

    .warning-box li {
        color: #856404;
        margin-bottom: 8px;
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
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .btn-delete-request {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s;
        cursor: pointer;
    }

    .btn-delete-request:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
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
        border-left: 4px solid #dc3545;
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

    @media (max-width: 768px) {
        .delete-account-section {
            padding: 20px 0;
        }

        .delete-header {
            padding: 20px;
        }

        .delete-header h2 {
            font-size: 1.5rem;
        }

        .delete-card {
            padding: 20px;
        }

        .delete-card h4 {
            font-size: 1.1rem;
        }

        .btn-delete-request, .btn-cancel {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>
@endpush

@section('content')
<section class="delete-account-section">
    <div class="container">
        <!-- Delete Account Header -->
        <div class="delete-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2><i class="fas fa-user-times"></i> Delete Account Request</h2>
                    <p class="mb-0">We're sorry to see you go. Please let us know why you want to delete your account.</p>
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

        <div class="row justify-content-center">
            <!-- Delete Account Form -->
            <div class="col-md-8">
                <div class="delete-card">
                    <h4><i class="fas fa-exclamation-triangle"></i> Account Deletion Request</h4>

                    <!-- Warning Box -->
                    <div class="warning-box">
                        <h5><i class="fas fa-exclamation-circle"></i> Important Notice</h5>
                        <ul>
                            <li>Once your account is deleted, all your data will be permanently removed.</li>
                            <li>You will lose access to all your enrolled courses and course materials.</li>
                            <li>Your test results and progress will be deleted.</li>
                            <li>This action cannot be undone after admin approval.</li>
                            <li>Admin will review your request and process it accordingly.</li>
                        </ul>
                    </div>

                    <form action="{{ route('student.delete-account.submit') }}" method="POST" id="deleteAccountForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-display">
                                    <label>Your Name</label>
                                    <p>{{ $student->student_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-display">
                                    <label>Mobile Number</label>
                                    <p>{{ $student->mobile ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">
                                Reason for Deletion <span class="text-danger">*</span>
                                <small class="text-muted">(Please tell us why you want to delete your account)</small>
                            </label>
                            <textarea
                                class="form-control @error('message') is-invalid @enderror"
                                id="message"
                                name="message"
                                rows="5"
                                placeholder="Please provide a detailed reason for account deletion..."
                                required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimum 20 characters required</small>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                            <label class="form-check-label" for="confirmDelete">
                                <strong>I understand that this action is permanent and I want to proceed with account deletion.</strong>
                            </label>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn-delete-request" id="submitBtn">
                                <i class="fas fa-paper-plane"></i> Submit Deletion Request
                            </button>
                            <a href="{{ route('student.dashboard') }}" class="btn-cancel">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Help Section -->
                <div class="delete-card">
                    <h4><i class="fas fa-question-circle"></i> Need Help?</h4>
                    <p>If you're experiencing issues with our platform or have concerns, please contact our support team before deleting your account. We're here to help!</p>
                    <p>
                        <strong><i class="fas fa-envelope"></i> Email:</strong> support@animestudio.com<br>
                        <strong><i class="fas fa-phone"></i> Phone:</strong> +91 1234567890
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Form validation
    document.getElementById('deleteAccountForm').addEventListener('submit', function(e) {
        const message = document.getElementById('message').value.trim();
        const confirmDelete = document.getElementById('confirmDelete').checked;

        if (message.length < 20) {
            e.preventDefault();
            Swal.fire({
                title: 'Insufficient Details',
                text: 'Please provide at least 20 characters explaining why you want to delete your account.',
                icon: 'warning',
                confirmButtonColor: '#dc3545'
            });
            return false;
        }

        if (!confirmDelete) {
            e.preventDefault();
            Swal.fire({
                title: 'Confirmation Required',
                text: 'Please confirm that you understand this action is permanent.',
                icon: 'warning',
                confirmButtonColor: '#dc3545'
            });
            return false;
        }

        // Double confirmation
        e.preventDefault();
        Swal.fire({
            title: 'Are you absolutely sure?',
            html: '<p>This will submit a request to delete your account permanently.</p><p><strong>This action cannot be undone!</strong></p>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Submit Request',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                document.getElementById('submitBtn').disabled = true;
                document.getElementById('submitBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                e.target.submit();
            }
        });
    });

    // Character counter for textarea
    document.getElementById('message').addEventListener('input', function() {
        const length = this.value.trim().length;
        const minLength = 20;

        if (length < minLength) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '#28a745';
        }
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
