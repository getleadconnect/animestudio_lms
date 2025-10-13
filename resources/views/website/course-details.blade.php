@extends('website.layout')

@section('title', $course->course_name . ' - Details')

@section('content')
<style>
    .content-full img
    {
        width:100% !important;
    }
    </style>

<!-- Page Loader -->
<div id="pageLoader" class="page-loader">
    <div class="loader-spinner"></div>
</div>

<div class="container mt-4 mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses') }}">Courses</a></li>
            <li class="breadcrumb-item active">{{ $course->course_name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($course->course_square_icon)
                            <img src="{{ config('constants.course_icon').$course->course_square_icon }}"
                                 alt="{{ $course->course_name }}"
                                 style="width:100px;height:100px;object-fit:cover;border-radius:8px;margin-right:20px;">
                        @endif
                        <h2 class="card-title mb-0">{{ $course->course_name }}</h2>
                    </div>

                    @if(!empty($course->course_details))
                        <div class="course-details-wrapper">
                            <div class="course-details" id="courseDetails">
                                <div class="content-preview" id="contentPreview">
                                    <p class="text-muted mb-0">{{ $course->description ?? '' }}</p>
                                </div>
                                <div class="content-full" style="display: none;" id="contentFull">
                                    {!! $course->course_details ?? '' !!}
                                </div>
                            </div>
                            <div class="text-end mt-2">
                                <button class="btn btn-link p-0 text-decoration-none" id="toggleButton" onclick="toggleContent()">
                                    <i class="fas fa-chevron-down me-1"></i>
                                    <span id="toggleText">Show More</span>
                                </button>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">{{ $course->description ?? 'No description available.' }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Course Information</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>Duration:</strong> {{ \Carbon\Carbon::parse($course->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($course->end_date)->format('M d, Y') }}
                        </li>
                        <li class="mb-2">
                            <strong>Price:</strong>
                            @if($course->discount_rate)
                                <span class="text-decoration-line-through text-muted">₹{{ $course->rate }}</span>
                                <span class="text-success fw-bold">₹{{ $course->discount_rate }}</span>
                            @else
                                ₹{{ $course->rate }}
                            @endif
                        </li>
                        <li class="mb-2">
                            <strong>Type:</strong> {{ $course->premium == 1 ? 'Premium' : 'Free' }}
                        </li>
                    </ul>

                    <a href="{{ route('purchase-course', $course->id) }}" class="btn btn-success w-100">
                        <i class="fas fa-shopping-cart"></i> Complete Purchase
                    </a>
                </div>
            </div>
        </div>
    </div>


<!-- to list Topics and sections ---------------------------------------->

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-book"></i> Course Topics</h5>
            </div>
            <div class="card-body">
                @if($subjects->count() > 0)
                    <div class="row">
                        @foreach($subjects as $subject)
                            <div class="col-md-12 mb-3">
                                <div class="card h-100 shadow-sm border-0 subject-card"
                                     data-subject-id="{{ $subject->id }}"
                                     data-subject-name="{{ $subject->subject_name }}"
                                     onclick="loadChaptersBySubject({{ $subject->id }}, '{{ $subject->subject_name }}', {{ $course->id }})"
                                     style="cursor: pointer;">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            @if($subject->subject_icon)
                                                <img src="{{ config('constants.subject_icon').$subject->subject_icon }}"
                                                     alt="{{ $subject->subject_name }}"
                                                     class="me-3"
                                                     style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                                            @else
                                                <div class="me-3 d-flex align-items-center justify-content-center"
                                                     style="width:60px;height:60px;background:#e9ecef;border-radius:8px;">
                                                    <i class="fas fa-book-open fa-2x text-primary"></i>
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h6 class="card-title mb-2">{{ $subject->subject_name }}</h6>
                                                @if($subject->description)
                                                    <p class="card-text text-muted small mb-0">{{ Str::limit($subject->description, 80) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No subjects available for this course yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-list"></i> Topic Sessions</h5>
                <small id="subjectName">@if($firstSubject){{ $firstSubject->subject_name }}@endif</small>
            </div>
            <div class="card-body" id="chaptersContainer">
                @if($chapters->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($chapters as $index => $chapter)
                            <div class="list-group-item px-0 border-0 mb-2">
                                <div class="card shadow-sm border-0 chapter-card">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-center">
                                            @if($chapter->chapter_icon)
                                                <img src="{{ config('constants.chapter_icon').$chapter->chapter_icon }}"
                                                     alt="{{ $chapter->chapter_name }}"
                                                     class="me-2"
                                                     style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                                            @else
                                                <div class="me-2 d-flex align-items-center justify-content-center"
                                                     style="width:40px;height:40px;background:#e9ecef;border-radius:6px;">
                                                    <span class="badge bg-success">{{ $index + 1 }}</span>
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 small">{{ $chapter->chapter_name }}</h6>
                                                @if($chapter->description)
                                                    <small class="text-muted d-block">{{ Str::limit($chapter->description, 40) }}</small>
                                                @endif
                                                <div class="d-flex gap-2 mt-1">
                                                    <span class="badge bg-primary" style="font-size:10px;">
                                                        <i class="fas fa-video"></i> {{ $chapter->video_count ?? 0 }} Videos
                                                    </span>
                                                    <span class="badge bg-danger" style="font-size:10px;">
                                                        <i class="fas fa-file-pdf"></i> {{ $chapter->pdf_count ?? 0 }} PDFs
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                        <p class="text-muted small mb-0">No chapters available yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

</div> <!-- end container --->

<style>
    /* Page Loader Styles */
    .page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.95);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.3s ease;
    }

    .loader-spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .page-loader.hidden {
        opacity: 0;
        pointer-events: none;
    }

    .subject-card {
        transition: all 0.3s ease;
        border: 1px solid #e3e6f0;
    }

    .subject-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        border-color: #4e73df;
    }

    .subject-card.subject-active {
        border: 2px solid #667eea !important;
        background: linear-gradient(135deg, #f8f9ff 0%, #fff 100%);
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(102, 126, 234, 0.3) !important;
    }

    .chapter-card {
        transition: all 0.2s ease;
        border: 1px solid #e3e6f0;
    }

    .chapter-card:hover {
        background-color: #f8f9fc;
        border-color: #1cc88a;
    }

    .card-header.bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .card-header.bg-success {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
    }

    /* Course Details Toggle Styles */
    .course-details-wrapper {
        position: relative;
    }

    #contentPreview {
        max-height: 100px;
        overflow: hidden;
        line-height: 1.6;
        position: relative;
    }

    #contentPreview::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 30px;
        background: linear-gradient(to bottom, transparent, white);
    }

    #toggleButton {
        color: #667eea;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    #toggleButton:hover {
        color: #764ba2;
    }

    #toggleButton i {
        transition: transform 0.3s ease;
    }

    #toggleButton.expanded i {
        transform: rotate(180deg);
    }

    .content-full {
        line-height: 1.6;
    }
</style>

<script>
// Hide page loader when page is fully loaded
window.addEventListener('load', function() {
    const loader = document.getElementById('pageLoader');
    setTimeout(function() {
        loader.classList.add('hidden');
        setTimeout(function() {
            loader.style.display = 'none';
        }, 300);
    }, 500);
});

function toggleContent() {
    const preview = document.getElementById('contentPreview');
    const full = document.getElementById('contentFull');
    const toggleButton = document.getElementById('toggleButton');
    const toggleText = document.getElementById('toggleText');
    const icon = toggleButton.querySelector('i');

    if (full.style.display === 'none') {
        // Show full content (expand)
        preview.style.display = 'none';
        full.style.display = 'block';
        toggleText.textContent = 'Show Less';
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
        toggleButton.classList.add('expanded');
    } else {
        // Show preview (collapse)
        preview.style.display = 'block';
        full.style.display = 'none';
        toggleText.textContent = 'Show More';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
        toggleButton.classList.remove('expanded');
    }
}

function loadChaptersBySubject(subjectId, subjectName, courseId) {
    // Remove active class from all subjects
    document.querySelectorAll('.subject-card').forEach(card => {
        card.classList.remove('subject-active');
    });

    // Add active class to clicked subject
    event.currentTarget.classList.add('subject-active');

    // Update subject name in header
    document.getElementById('subjectName').textContent = subjectName;

    // Show loading in chapters container
    const container = document.getElementById('chaptersContainer');
    container.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

    // Fetch chapters
    fetch(`{{ route('website.get-chapters-by-subject') }}?subject_id=${subjectId}&course_id=${courseId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.chapters.length > 0) {
                let html = '<div class="list-group list-group-flush">';
                data.chapters.forEach((chapter, index) => {
                    const chapterIcon = chapter.chapter_icon
                        ? `<img src="{{ config('constants.chapter_icon') }}${chapter.chapter_icon}" alt="${chapter.chapter_name}" class="me-2" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">`
                        : `<div class="me-2 d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#e9ecef;border-radius:6px;"><span class="badge bg-success">${index + 1}</span></div>`;

                    const description = chapter.description
                        ? `<small class="text-muted d-block">${chapter.description.substring(0, 40)}${chapter.description.length > 40 ? '...' : ''}</small>`
                        : '';

                    html += `
                        <div class="list-group-item px-0 border-0 mb-2">
                            <div class="card shadow-sm border-0 chapter-card">
                                <div class="card-body py-2 px-3">
                                    <div class="d-flex align-items-center">
                                        ${chapterIcon}
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 small">${chapter.chapter_name}</h6>
                                            ${description}
                                            <div class="d-flex gap-2 mt-1">
                                                <span class="badge bg-primary" style="font-size:10px;">
                                                    <i class="fas fa-video"></i> ${chapter.video_count || 0} Videos
                                                </span>
                                                <span class="badge bg-danger" style="font-size:10px;">
                                                    <i class="fas fa-file-pdf"></i> ${chapter.pdf_count || 0} PDFs
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = `
                    <div class="text-center py-3">
                        <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                        <p class="text-muted small mb-0">No chapters available yet.</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            container.innerHTML = `
                <div class="text-center py-3">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                    <p class="text-danger small mb-0">Error loading chapters.</p>
                </div>
            `;
        });
}
</script>

@endsection