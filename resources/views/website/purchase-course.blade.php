@extends('website.layout')

@section('title', 'Purchase ' . $course->course_name)

@section('content')

 <style>
    .fa-icon-w   {   font-size:16px;    }
    .i-list h6, span   {   font-size:14px !important;    }
    .fs-6   {  font-size:14px !important;    }
    .pd-3   {  padding:0.65rem;  }
    .pr-3  {   padding-right:.65rem;  }
    .course-details img
    {
        width:100% !important;
    }
    </style>


<div class="container mt-4 mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses') }}">Courses</a></li>
            <li class="breadcrumb-item"><a href="{{ route('course-details', $course->id) }}">{{ $course->course_name }}</a></li>
            <li class="breadcrumb-item active">Purchase</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Order Summary -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag"></i> Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($course->course_square_icon)
                                <img src="{{ config('constants.course_icon').$course->course_square_icon }}"
                                     class="img-fluid rounded"
                                     alt="{{ $course->course_name }}">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $course->course_name }}</h4>
                            <p class="text-muted">{{ $course->description }}</p>
                        </div>
                    </div>
                    <hr style="margin:10px 0px;">
                   
                        <div class="row i-list" >
                            <div class="col-12 col-md-4 mt-4">
                                <div class="d-flex align-items-center justify-content-between mb-3 pd-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-book fa-icon-w text-primary me-3" ></i>
                                        <h6 class="mb-0">Total Subjects</h6>
                                    </div>
                                    <span class="badge bg-primary fs-6">{{ $subjectsCount }}</span>
                                </div>
                            </div>

                            <div class="col-12 col-md-4 mt-4">
                                <div class="d-flex align-items-center justify-content-between mb-3 pd-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-video text-danger me-3"></i>
                                        <h6 class="mb-0">Total Videos</h6>
                                    </div>
                                    <span class="badge bg-danger fs-6">{{ $videosCount }}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mt-4">

                                <div class="d-flex align-items-center justify-content-between mb-3 pd-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-warning me-3"></i>
                                        <h6 class="mb-0">Total PDF Notes</h6>
                                    </div>
                                    <span class="badge bg-warning fs-6">{{ $pdfCount }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row i-list">
                            <div class="col-12 col-md-6 ">

                                <div class="d-flex align-items-center mb-3 pd-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar fa-icon-w text-success me-3"></i>
                                        <h6 class="mb-0 pr-3">Start Date : </h6>
                                    </div>
                                    <span class="text-muted">{{ \Carbon\Carbon::parse($course->start_date)->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-center mb-3 pd-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock fa-icon-w text-warning me-3"></i>
                                        <h6 class="mb-0 pr-3">End Date : </h6>
                                    </div>
                                    <span class="text-muted">{{ \Carbon\Carbon::parse($course->end_date)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <hr style= "margin:10px 0px;">
                        <div class="course-details">
                            <h4 class="mt-3 mb-3">COURSE DETAILS </h4>

                            <div class="row mt-3">
                                <div class="col-12 col-md-12">
                                {!! $course->course_details  !!}
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>

        <!-- Price Summary -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-receipt"></i> Price Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Course Price:</span>
                        <span class="text-decoration-line-through text-muted">AED {{ number_format($course->rate, 2) }}</span>
                    </div>
                    @if($course->discount_rate && $course->discount_rate < $course->rate)
                        <div class="d-flex justify-content-between mb-2">
                            <span>Discounted Price:</span>
                            <span class="text-success fw-bold">AED {{ number_format($course->discount_rate, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-success">You Save:</span>
                            <span class="text-success fw-bold">AED {{ number_format($course->rate - $course->discount_rate, 2) }}</span>
                        </div>
                    @endif

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="mb-0">Total Amount:</h5>
                        <h5 class="mb-0 text-success">AED {{ number_format($course->discount_rate ?: $course->rate, 2) }}</h5>
                    </div>

                    <button type="button" id="payment-button" class="btn btn-success w-100 btn-lg" onclick="handlePurchase()">
                        <i class="fas fa-lock"></i> Proceed to Payment
                    </button>

                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt"></i> Secure payment powered by SSL
                        </small>
                    </div>

                    <div class="mt-3 text-center">
                        <a href="{{ route('course-details', $course->id) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Course Details
                        </a>
                    </div>
                </div>
            </div>

            <!-- Course Features -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-check-circle text-success"></i> What's Included:</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> {{ $subjectsCount }} Subjects</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> {{ $videosCount }} Video Lessons</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Downloadable Resources</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Lifetime Access</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Certificate of Completion</li>
                        <li class="mb-0"><i class="fas fa-check text-success me-2"></i> Mobile & Desktop Access</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Handle Purchase Button Click with Authentication Check
async function handlePurchase() {
    const button = document.getElementById('payment-button');
    const originalHtml = button.innerHTML;

    // Disable button and show loading
    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';

    try {
        // Check if student is authenticated
        const response = await fetch('{{ route("course.check-auth") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                course_id: {{ $course->id }}
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            console.error('Received non-JSON response:', text);
            throw new Error('Server returned non-JSON response');
        }

        const data = await response.json();

        if (!data.authenticated) {
            // Student not logged in - redirect to login with return URL
            const returnUrl = encodeURIComponent(window.location.href);
            window.location.href = `{{ route('student.login') }}?return_url=${returnUrl}&course_id={{ $course->id }}`;
            return;
        }

        if (data.already_subscribed) {
            alert('You have already purchased this course!');
            button.disabled = false;
            button.innerHTML = originalHtml;
            window.location.href = '{{ route("student.dashboard") }}';
            return;
        }

        // Proceed to Stripe Checkout
        initiateStripeCheckout();

    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
        button.disabled = false;
        button.innerHTML = originalHtml;
    }
}

// Initialize Stripe Checkout
async function initiateStripeCheckout() {
    const button = document.getElementById('payment-button');

    try {
        const response = await fetch('{{ route("stripe.create-checkout-session") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                course_id: {{ $course->id }}
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            console.error('Received non-JSON response:', text);
            throw new Error('Server returned non-JSON response');
        }

        const data = await response.json();

        if (data.success && data.checkout_url) {
            // Redirect to Stripe Checkout
            window.location.href = data.checkout_url;
        } else {
            alert(data.message || 'Failed to initiate checkout. Please try again.');
            button.disabled = false;
            button.innerHTML = '<i class="fas fa-lock"></i> Proceed to Payment';
        }

    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
        button.disabled = false;
        button.innerHTML = '<i class="fas fa-lock"></i> Proceed to Payment';
    }
}
</script>

<style>
.sticky-top {
    position: sticky;
}
</style>

@endsection
