@extends('website.layout')

@section('title', $course->course_name . ' - Course Content')

@push('styles')

<style>
    /* Container and responsive layout */
    .content-container {
        padding: 15px 0;
        overflow-x: hidden;
    }

    @media (min-width: 768px) {
        .content-container {
            padding: 30px 0;
        }
    }


    /* Breadcrumb mobile responsive */
    .breadcrumb {
        font-size: 0.85rem;
        padding: 10px 15px;
        margin-bottom: 15px;
        background: white;
        border-radius: 8px;
    }

    @media (min-width: 768px) {
        .breadcrumb {
            font-size: 1rem;
            padding: 12px 20px;
            margin-bottom: 20px;
        }
    }

    .video-player-section {
        background: #000;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 15px;
    }

    @media (min-width: 768px) {
        .video-player-section {
            margin-bottom: 20px;
        }
    }

    .video-player-wrapper {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
    }

    .video-player-wrapper video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .video-info-section {
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    @media (min-width: 768px) {
        .video-info-section {
            padding: 20px;
            margin-bottom: 20px;
        }
    }

    .video-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    @media (min-width: 768px) {
        .video-title {
            font-size: 1.5rem;
        }
    }

    .video-list-container {
        background: #fff;
        border-radius: 10px;
        padding: 10px;
        max-height: 500px;
        overflow-y: auto;
        margin-bottom: 20px;
    }

    @media (min-width: 768px) {
        .video-list-container {
            padding: 15px;
            max-height: 600px;
            margin-bottom: 0;
        }
    }

    .video-list-header {
        background: #a7dfec;
        color: #0c4a57;
        padding: 12px;
        border-radius: 10px 10px 0 0;
        margin: -10px -10px 10px -10px;
        font-size: 0.95rem;
    }

    @media (min-width: 768px) {
        .video-list-header {
            padding: 15px;
            margin: -15px -15px 15px -15px;
            font-size: 1rem;
        }
    }

    .video-list-header h5 {
        font-size: 1rem;
        margin: 0;
    }

    @media (min-width: 768px) {
        .video-list-header h5 {
            font-size: 1.25rem;
        }
    }

    .video-item {
        display: flex;
        flex-direction: column;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fff;
    }

    @media (min-width: 576px) {
        .video-item {
            flex-direction: row;
            padding: 12px;
        }
    }

    .video-item:hover {
        background: #f8f9fa;
        transform: translateX(5px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .video-item.active {
        background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
        border-color: #667eea;
    }

    .video-thumbnail {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    @media (min-width: 576px) {
        .video-thumbnail {
            width: 90px;
            height: 70px;
            margin-right: 15px;
            margin-bottom: 0;
        }
    }

    .video-details {
        flex: 1;
    }

    .video-item-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        line-height: 1.4;
    }

    @media (min-width: 576px) {
        .video-item-title {
            font-size: 0.95rem;
        }
    }

    /* PDF Tab Card Styles */
    .pdf-item {
        padding: 15px;
        margin-bottom: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .pdf-item:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-color: #2196F3;
        cursor: pointer;
    }

    .pdf-item.active {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-color: #2196F3;
        box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
    }

    .pdf-item-title {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
    }

    .pdf-item-title i {
        font-size: 18px;
    }

    .pdf-description {
        font-size: 13px;
        color: #666;
        line-height: 1.4;
        margin-left: 26px;
    }

    .no-pdfs {
        text-align: center;
        padding: 40px;
        color: #999;
    }

    .no-pdfs i {
        font-size: 48px;
        color: #dc3545;
        margin-bottom: 15px;
        display: block;
    }

    .no-pdfs p {
        font-size: 16px;
        margin: 0;
    }

    .video-duration {
        font-size: 12px;
        color: #666;
        display: flex;
        align-items: center;
    }

    .video-status {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 11px;
        margin-left: 10px;
    }

    .video-free {
        background: #4caf50;
        color: white;
    }

    .video-premium {
        background: #ff9800;
        color: white;
    }

    .dropdown-section {
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        overflow: hidden;
        width: 100%;
    }

    @media (min-width: 768px) {
        .dropdown-section {
            padding: 20px;
            margin-bottom: 20px;
        }
    }

    .dropdown-section h4 {
        font-size: 1.1rem;
    }

    @media (min-width: 768px) {
        .dropdown-section h4 {
            font-size: 1.5rem;
        }
    }

    .form-label {
        margin-bottom: 0.5rem;
    }

    /*.form-select {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }

    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }*/

    /* Nav tabs responsive */
    .nav-tabs {
        border-bottom: 2px solid #e0e0e0;
        margin-bottom: 20px;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .nav-tabs .nav-item {
        flex-shrink: 0;
    }

    .nav-tabs .nav-link {
        font-size: 0.9rem;
        padding: 10px 15px;
        white-space: nowrap;
    }

    @media (min-width: 768px) {
        .nav-tabs .nav-link {
            font-size: 1rem;
            padding: 12px 20px;
        }
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
    }

    .no-videos {
        text-align: center;
        padding: 30px 15px;
        color: #666;
    }

    @media (min-width: 768px) {
        .no-videos {
            padding: 40px;
        }
    }

    .no-videos i {
        font-size: 2.5rem;
        color: #ddd;
        margin-bottom: 15px;
    }

    @media (min-width: 768px) {
        .no-videos i {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }
    }

    .loading-spinner {
        text-align: center;
        padding: 30px 15px;
    }

    @media (min-width: 768px) {
        .loading-spinner {
            padding: 40px;
        }
    }

    .spinner-border {
        width: 2.5rem;
        height: 2.5rem;
        border-width: 0.3em;
    }

    @media (min-width: 768px) {
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    }

    /* Alert responsive */
    .alert {
        font-size: 0.9rem;
        padding: 12px 15px;
    }

    @media (min-width: 768px) {
        .alert {
            font-size: 1rem;
            padding: 15px 20px;
        }
    }

    /* Card responsive */
    .card {
        margin-bottom: 15px;
    }

    .card-header {
        font-size: 0.95rem;
        padding: 12px 15px;
    }

    @media (min-width: 768px) {
        .card-header {
            font-size: 1rem;
            padding: 15px 20px;
        }
    }

    .card-body {
        padding: 15px;
    }

    @media (min-width: 768px) {
        .card-body {
            padding: 20px;
        }
    }

    /* Video duration badge */
    .video-duration {
        font-size: 0.75rem;
    }

    @media (min-width: 576px) {
        .video-duration {
            font-size: 0.8rem;
        }
    }

    /* Locked video styling */
    .video-item.locked {
        opacity: 0.6;
        cursor: not-allowed !important;
        background: #f5f5f5 !important;
    }

    .video-item.locked:hover {
        transform: none !important;
        box-shadow: none !important;
    }

    .video-item.locked .video-thumbnail {
        filter: grayscale(50%);
    }

    .video-locked-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 11px;
        background: #dc3545;
        color: white;
        margin-left: 5px;
    }

    /* Mobile video/PDF list ordering */
    @media (max-width: 991px) {
        .content-row-mobile {
            display: flex;
            flex-direction: column;
        }

        .player-column {
            order: 1;
        }

        .list-column {
            order: 2;
        }
    }

    /* Mark as Completed Button Styles */
    .btn-mark-completed {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-mark-completed:hover {
        background: linear-gradient(135deg, #218838 0%, #1ea87a 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    }

    .btn-mark-completed:active {
        transform: translateY(0);
    }

    .btn-mark-completed i {
        font-size: 1rem;
    }

    .completed-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #d4edda;
        color: #155724;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        border: 2px solid #28a745;
    }

    .completed-badge i {
        font-size: 1rem;
        color: #28a745;
    }

    @media (max-width: 576px) {
        .btn-mark-completed,
        .completed-badge {
            font-size: 0.85rem;
            padding: 8px 15px;
        }
    }

    /* Comments Section Styles */
    .comments-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #e0e0e0;
    }

    .comments-heading {
        color: #333;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .comments-heading i {
        color: var(--primary-color);
    }

    .comment-form-wrapper {
        margin-bottom: 20px;
    }

    .comment-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        resize: vertical;
        transition: all 0.3s;
        font-family: inherit;
    }

    .comment-textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    .btn-submit-comment {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }

    .btn-submit-comment:hover {
        background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-submit-comment:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .comments-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .comments-list::-webkit-scrollbar {
        width: 6px;
    }

    .comments-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .comments-list::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }

    .comment-item {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 12px;
        border-left: 3px solid var(--primary-color);
        transition: all 0.3s;
    }

    .comment-item:hover {
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transform: translateX(3px);
    }

    .comment-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .comment-author {
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .comment-author i {
        color: var(--primary-color);
    }

    .comment-date {
        font-size: 0.85rem;
        color: #999;
    }

    .comment-text {
        color: #555;
        line-height: 1.6;
        font-size: 0.95rem;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .no-comments {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .no-comments i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #ddd;
    }

    .no-comments p {
        margin: 0;
        font-size: 1rem;
    }

    @media (max-width: 576px) {
        .comments-section {
            padding: 15px;
        }

        .comments-heading {
            font-size: 1.1rem;
        }

        .comment-textarea {
            font-size: 0.9rem;
        }

        .btn-submit-comment {
            font-size: 0.9rem;
            padding: 8px 15px;
        }

        .comment-item {
            padding: 12px;
        }

        .comment-text {
            font-size: 0.9rem;
        }
    }

    /* Course Details Section Styling */
    .course-details-section {
        background: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 25px;
    }

    .course-details-section h4 {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 1.5rem;
        padding-bottom: 10px;
        border-bottom: 3px solid #667eea;
    }

    .course-icon-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .course-icon-wrapper img {
        max-width: 150px;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    }

    .course-description {
        color: #555;
        line-height: 1.8;
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .btn-toggle-details {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-toggle-details:hover {
        background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-toggle-details i {
        transition: transform 0.3s ease;
    }

    .btn-toggle-details.expanded i {
        transform: rotate(180deg);
    }

    .course-details-content {
        margin-top: 20px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid #667eea;
        display: none;
        animation: slideDown 0.3s ease-out;
    }

    .course-details-content.show {
        display: block;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .course-details-content p,
    .course-details-content ul,
    .course-details-content ol {
        color: #555;
        line-height: 1.8;
    }

    @media (max-width: 768px) {
        .course-details-section {
            padding: 15px;
        }

        .course-details-section h4 {
            font-size: 1.2rem;
        }

        .course-icon-wrapper img {
            max-width: 120px;
        }

        .course-description {
            font-size: 0.95rem;
        }

        .btn-toggle-details {
            font-size: 0.9rem;
            padding: 8px 20px;
            width: 100%;
            justify-content: center;
        }
    }
    .fixed-top-image {
      top: 0;
      left: 0; 
      width: 200px; 
    }
    .course-details-content img
    {
        width:100% !important;
    }
</style>
@endpush

@section('content')

<div class="container content-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $course->course_name }}</li>
        </ol>
    </nav>

    <!-- course details section -------------->

    <div class="course-details-section">
        <h4>{{ $course->course_name }} - Details</h4>

        <div class="row ">
            <div class="col-12 col-md-2" >
                    <img src="{{ config('constants.course_icon').$course->course_square_icon }}"
                         alt="{{ $course->course_name }}"
                         class="fixed-top-image">
            </div>

            <div class="col-12 col-md-10">
                <div class="course-description">
                    {!! $course->description !!}
                </div>

                <button class="btn-toggle-details" id="toggleDetailsBtn" onclick="toggleCourseDetails()">
                    <i class="fas fa-chevron-down"></i> Course Details
                </button>

                <div class="course-details-content" id="courseDetailsContent">
                    {!! $course->course_details !!}
                </div>
            </div>
        </div>
    </div>

    <!-- end------------->

    <div class="dropdown-section">
        <div class="mb-3 mb-md-4">
            <h4 class="mb-0">{{ $course->course_name }} - Lessons</h4>
        </div>


 <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4" id="courseContentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="video-classes-tab" data-bs-toggle="tab" data-bs-target="#video-classes" type="button" role="tab" aria-controls="video-classes" aria-selected="true">
                    <i class="fas fa-video me-2"></i>Video Classes
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pdf-notes-tab" data-bs-toggle="tab" data-bs-target="#pdf-notes" type="button" role="tab" aria-controls="pdf-notes" aria-selected="false">
                    <i class="fas fa-file-pdf me-2"></i>PDF Notes
                </button>
            </li>
        </ul>


    <!-- Tab Content -->
<div class="tab-content" id="courseContentTabContent">
    
<!-- Video Classes Tab -->
    <div class="tab-pane fade show active" id="video-classes" role="tabpanel" aria-labelledby="video-classes-tab">
            

            <div class="row mb-4">
                <div class="col-12 col-md-6 mb-3">
                    <label for="subject_select" class="form-label fw-bold">Select Subject</label>

                    <select class="form-select" id="subject_select">
                        <option value="">Choose a subject...</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="chapter_select" class="form-label fw-bold">Select Chapter</label>
                    <select class="form-select" id="chapter_select" disabled>
                        <option value="">First select a subject</option>
                    </select>
                </div>
            </div>


        <div class="row content-row-mobile">
            <div class="col-lg-8 player-column">
                <div class="video-player-section" id="video_player_section" style="display: none;">
                    <div class="video-player-wrapper">
                        <video id="main_video_player" controls controlsList="nodownload">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>

                <div class="video-info-section" id="video_info_section" style="display: none;">
                    <h2 class="video-title" id="current_video_title"></h2>
                    <p class="text-muted" id="current_video_description"></p>

                    <!-- Mark as Completed Button -->
                    <div class="mt-3">
                        <button type="button"
                                id="mark_completed_btn"
                                class="btn-mark-completed"
                                onclick="markVideoAsCompleted()"
                                style="display: none;">
                            <i class="fas fa-check-circle"></i> Mark as Completed
                        </button>
                        <span id="completed_status" class="completed-badge" style="display: none;">
                            <i class="fas fa-check-circle"></i> Completed
                        </span>
                    </div>

                    <!-- Comments Section -->
                    <div class="comments-section mt-4" id="comments_section" style="display: none;">
                        <h5 class="comments-heading">
                            <i class="fas fa-comments"></i> Comments
                        </h5>

                        <!-- Comment Form -->
                        <div class="comment-form-wrapper">
                            <textarea id="comment_input"
                                      class="comment-textarea"
                                      placeholder="Add your comment here..."
                                      rows="3"></textarea>
                            <button type="button"
                                    id="submit_comment_btn"
                                    class="btn-submit-comment"
                                    onclick="submitComment()">
                                <i class="fas fa-paper-plane"></i> Post Comment
                            </button>
                        </div>

                        <!-- Comments List -->
                        <div class="comments-list" id="comments_list">
                            <div class="no-comments">
                                <i class="fas fa-comment-slash"></i>
                                <p>No comments yet. Be the first to comment!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info" id="select_chapter_message">
                    <i class="fas fa-info-circle"></i> Please select a subject and chapter to view video lessons.
                </div>
            </div>

            <div class="col-lg-4 list-column">
                <div class="video-list-container">
                    <div class="video-list-header">
                        <h5 class="mb-0">
                            <i class="fas fa-play-circle"></i> Video Playlist
                        </h5>
                    </div>

                    <div id="video_list">
                        <div class="no-videos">
                            <i class="fas fa-video-slash"></i>
                            <p>Select a chapter to load videos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<!--- end Video classes tab --->

<!-- PDF tab -------------------->

    <div class="tab-pane fade" id="pdf-notes" role="tabpanel" aria-labelledby="pdf-notes-tab">
                <div class="row mb-4">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="pdf_subject_select" class="form-label fw-bold">Select Subject</label>
                        <select class="form-select" id="pdf_subject_select">
                            <option value="">Choose a subject...</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="pdf_chapter_select" class="form-label fw-bold">Select Chapter</label>
                        <select class="form-select" id="pdf_chapter_select" disabled>
                            <option value="">First select a subject</option>
                        </select>
                    </div>
                </div>

                <div class="row content-row-mobile">
                    <div class="col-lg-8 player-column">
                        <div class="card" id="pdf_viewer_section" style="display: none;">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-file-pdf me-2"></i>
                                    <span id="current_pdf_title">PDF Document</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="pdf_viewer_content" style="height: 500px; overflow-y: auto;">
                                    <!-- PDF will be loaded here -->
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info" id="select_pdf_chapter_message">
                            <i class="fas fa-info-circle"></i> Please select a subject and chapter to view PDF notes.
                        </div>
                    </div>

                    <div class="col-lg-4 list-column">
                        <div class="card shadow-sm">
                            <div class="card-header bg-gradient bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-file-pdf"></i> Available PDF Notes
                                </h5>
                            </div>
                            <div class="card-body p-3" style="max-height: 500px; overflow-y: auto; background: #f8f9fa;">
                                <div id="pdf_list">
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-file-pdf fa-3x mb-3" style="color: #dc3545;"></i>
                                        <p>Select a chapter to load PDF notes</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End PDF Notes Tab -->

    </div>

    </div>
</div>

@endsection



@push('scripts')
<script>
// Pure JavaScript implementation - no jQuery required
(function() {
    'use strict';

    // Global variables
    let currentCourseId = {{ $course->id }};
    let currentVideos = [];
    let currentVideoIndex = 0;
    let currentPdfs = [];
    let selectedPdfIndex = null;
    let currentSubjectId = null;
    let currentChapterId = null;

    // Wait for DOM to load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - Pure JavaScript version');

        // Get elements
        const subjectSelect = document.getElementById('subject_select');
        const chapterSelect = document.getElementById('chapter_select');

        // Subject change event
        if (subjectSelect) {
            subjectSelect.addEventListener('change', function() {
                const subjectId = this.value;
                console.log('Subject selected:', subjectId);

                if (subjectId) {
                    loadChapters(subjectId);
                } else {
                    chapterSelect.innerHTML = '<option value="">First select a subject</option>';
                    chapterSelect.disabled = true;
                    resetVideoSection();
                }
            });
        }

        // Chapter change event
        if (chapterSelect) {
            chapterSelect.addEventListener('change', function() {
                const chapterId = this.value;
                const subjectId = subjectSelect.value;

                console.log('Chapter selected:', chapterId, 'Subject:', subjectId);

                if (chapterId && subjectId) {
                    currentSubjectId = subjectId;
                    currentChapterId = chapterId;
                    loadVideos(subjectId, chapterId);
                } else {
                    resetVideoSection();
                }
            });
        }
    });

    // Load chapters function
    function loadChapters(subjectId) {
        console.log('Loading chapters for subject:', subjectId);
        const chapterSelect = document.getElementById('chapter_select');

        chapterSelect.innerHTML = '<option value="">Loading...</option>';
        chapterSelect.disabled = true;

        // Make AJAX request
        fetch('{{ route("website.get-chapters") }}?course_id=' + currentCourseId + '&subject_id=' + subjectId)
            .then(response => response.json())
            .then(chapters => {
                console.log('Chapters loaded:', chapters);

                let options = '<option value="">Choose a chapter...</option>';

                if (chapters.length > 0) {
                    chapters.forEach(chapter => {
                        options += `<option value="${chapter.id}">${chapter.chapter_name}</option>`;
                    });
                    chapterSelect.innerHTML = options;
                    chapterSelect.disabled = false;
                } else {
                    chapterSelect.innerHTML = '<option value="">No chapters available</option>';
                    chapterSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error loading chapters:', error);
                chapterSelect.innerHTML = '<option value="">Error loading chapters</option>';
                chapterSelect.disabled = true;
            });
    }

    // Load videos function
    function loadVideos(subjectId, chapterId) {
        console.log('Loading videos for subject:', subjectId, 'chapter:', chapterId);

        const videoList = document.getElementById('video_list');
        videoList.innerHTML = `
            <div class="loading-spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">Loading videos...</p>
            </div>
        `;

        // Make AJAX request
        fetch('{{ route("website.get-videos") }}?course_id=' + currentCourseId + '&subject_id=' + subjectId + '&chapter_id=' + chapterId)
            .then(response => response.json())
            .then(videos => {
                console.log('Videos loaded:', videos);
                currentVideos = videos;

                if (videos && videos.length > 0) {
                    displayVideoList(videos);
                    // Display videos but don't autoplay first video
                    document.getElementById('select_chapter_message').style.display = 'none';
                    document.getElementById('video_player_section').style.display = 'block';
                    document.getElementById('video_info_section').style.display = 'block';
                    // Optionally load first video without playing
                    if (videos[0]) {
                        loadVideoWithoutPlaying(0);
                    }
                } else {
                    videoList.innerHTML = `
                        <div class="no-videos">
                            <i class="fas fa-video-slash"></i>
                            <p>No videos available for this chapter</p>
                        </div>
                    `;
                    resetVideoSection();
                }
            })
            .catch(error => {
                console.error('Error loading videos:', error);
                videoList.innerHTML = `
                    <div class="no-videos">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Error loading videos</p>
                    </div>
                `;
                resetVideoSection();
            });
    }

    // Display video list
    function displayVideoList(videos) {
        console.log('Displaying video list');
        const videoList = document.getElementById('video_list');
        let html = '';

        videos.forEach((video, index) => {
            const statusBadge = video.is_free ?
                '<span class="video-status video-free">FREE</span>' :
                '<span class="video-status video-premium">PREMIUM</span>';

            // Add completion badge if video is completed
            const completedBadge = video.is_completed ?
                '<span class="video-status" style="background: #28a745; color: white; margin-left: 5px;"><i class="fas fa-check-circle"></i> Completed</span>' : '';

            // Check if video is locked (previous videos not completed)
            let isLocked = false;
            let lockedBadge = '';
            if (index > 0) {
                // Check if all previous videos are completed
                for (let i = 0; i < index; i++) {
                    if (!videos[i].is_completed) {
                        isLocked = true;
                        break;
                    }
                }
            }

            if (isLocked) {
                lockedBadge = '<span class="video-locked-badge"><i class="fas fa-lock"></i> Locked</span>';
            }

            const duration = video.video_duration || '00:00';
            const thumbnail = video.video_thumbnail || "{{config('constants.video_file')}}"+video.video_icon;
            const lockedClass = isLocked ? 'locked' : '';

            html += `
                <div class="video-item ${lockedClass}" data-index="${index}" onclick="playVideo(${index})">
                    <img src="${thumbnail}" alt="${video.video_name}" class="video-thumbnail" onerror="this.src='https://via.placeholder.com/120x70/333/fff?text=No+Image'">
                    <div class="video-details">
                        <div class="video-item-title">${video.video_name}</div>
                        <div class="video-duration">
                            <i class="far fa-clock"></i> ${duration}
                            ${statusBadge}
                            ${completedBadge}
                            ${lockedBadge}
                        </div>
                    </div>
                </div>
            `;
        });

        videoList.innerHTML = html;
    }

    // Load video without playing (for initial load)
    window.loadVideoWithoutPlaying = function(index) {
        if (!currentVideos[index]) {
            console.error('Video not found at index:', index);
            return;
        }

        currentVideoIndex = index;
        const video = currentVideos[index];
        console.log('Loading video without playing:', video);

        // Remove active class from all items
        document.querySelectorAll('.video-item').forEach(item => {
            item.classList.remove('active');
        });

        // Add active class to current item
        const currentItem = document.querySelector(`.video-item[data-index="${index}"]`);
        if (currentItem) {
            currentItem.classList.add('active');
        }

        // Update video player
        const videoPlayer = document.getElementById('main_video_player');
        const videoSrc = video.video_link || '';

        if (videoSrc) {
            videoPlayer.src = videoSrc;
            document.getElementById('current_video_title').textContent = video.video_name;
            //document.getElementById('current_video_description').textContent = video.description || 'No description available';
            document.getElementById('current_video_description').innerHTML = video.explanation || 'No description available';

            document.getElementById('video_player_section').style.display = 'block';
            document.getElementById('video_info_section').style.display = 'block';

            // Check and update completion UI
            updateCompletionUI(video.id);

            // Do not autoplay - user needs to click play button

            // Remove auto-play next video to prevent unwanted autoplay
            videoPlayer.onended = null;
        } else {
            alert('Video file not available');
            console.error('No video link for:', video);
        }
    };

    // Play video function (when user clicks on a video)
    window.playVideo = function(index) {
        if (!currentVideos[index]) {
            console.error('Video not found at index:', index);
            return;
        }

        // Check if user is trying to skip videos (sequential validation)
        if (index > 0) {
            // Check if all previous videos are completed
            let uncompletedIndex = -1;
            for (let i = 0; i < index; i++) {
                if (!currentVideos[i].is_completed) {
                    uncompletedIndex = i;
                    break;
                }
            }

            if (uncompletedIndex !== -1) {
                const uncompletedVideo = currentVideos[uncompletedIndex];
                alert(`Please complete the previous video "${uncompletedVideo.video_name}" before watching this video.`);
                return; // Stop execution - don't play the video
            }
        }

        currentVideoIndex = index;
        const video = currentVideos[index];
        console.log('Playing video:', video);

        // Remove active class from all items
        document.querySelectorAll('.video-item').forEach(item => {
            item.classList.remove('active');
        });

        // Add active class to current item
        const currentItem = document.querySelector(`.video-item[data-index="${index}"]`);
        if (currentItem) {
            currentItem.classList.add('active');
        }

        // Update video player
        const videoPlayer = document.getElementById('main_video_player');
        const videoSrc = video.video_link || '';

        if (videoSrc) {
            videoPlayer.src = videoSrc;
            document.getElementById('current_video_title').textContent = video.video_name;
            //document.getElementById('current_video_description').textContent = video.description || 'No description available';
            document.getElementById('current_video_description').innerHTML = video.explanation || 'No description available';

            document.getElementById('video_player_section').style.display = 'block';
            document.getElementById('video_info_section').style.display = 'block';

            // Check and update completion UI
            updateCompletionUI(video.id);

            // Play the video when user clicks on it
            videoPlayer.play().catch(error => {
                // If autoplay is blocked, user can manually click play button
                console.log('Autoplay prevented, user can click play button:', error);
            });

            // Remove auto-play next video to prevent unwanted autoplay
            videoPlayer.onended = null;

            // Scroll to view
            if (currentItem) {
                currentItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        } else {
            alert('Video file not available');
            console.error('No video link for:', video);
        }
    };

    // Reset video section
    function resetVideoSection() {
        document.getElementById('video_player_section').style.display = 'none';
        document.getElementById('video_info_section').style.display = 'none';
        document.getElementById('select_chapter_message').style.display = 'block';
        document.getElementById('video_list').innerHTML = `
            <div class="no-videos">
                <i class="fas fa-video-slash"></i>
                <p>Select a chapter to load videos</p>
            </div>
        `;
        currentVideos = [];
        currentVideoIndex = 0;
    }

    // PDF Notes Tab Functions
    const pdfSubjectSelect = document.getElementById('pdf_subject_select');
    const pdfChapterSelect = document.getElementById('pdf_chapter_select');

    // PDF Subject change event
    if (pdfSubjectSelect) {
        pdfSubjectSelect.addEventListener('change', function() {
            const subjectId = this.value;
            console.log('PDF Subject selected:', subjectId);

            if (subjectId) {
                loadPdfChapters(subjectId);
            } else {
                pdfChapterSelect.innerHTML = '<option value="">First select a subject</option>';
                pdfChapterSelect.disabled = true;
                resetPdfSection();
            }
        });
    }

    // PDF Chapter change event
    if (pdfChapterSelect) {
        pdfChapterSelect.addEventListener('change', function() {
            const chapterId = this.value;
            const subjectId = pdfSubjectSelect.value;

            console.log('PDF Chapter selected:', chapterId, 'Subject:', subjectId);

            if (chapterId && subjectId) {
                loadPdfFiles(subjectId, chapterId);
            } else {
                resetPdfSection();
            }
        });
    }

    // Load PDF chapters
    function loadPdfChapters(subjectId) {
        console.log('Loading chapters for PDF subject:', subjectId);
        pdfChapterSelect.innerHTML = '<option value="">Loading...</option>';
        pdfChapterSelect.disabled = true;

        fetch('/get-chapters-by-subject/' + subjectId)
            .then(response => response.json())
            .then(data => {
                console.log('PDF Chapters loaded:', data);
                const chapters = data.chapters || [];

                let options = '<option value="">Choose a chapter...</option>';

                if (chapters.length > 0) {
                    chapters.forEach(chapter => {
                        options += `<option value="${chapter.id}">${chapter.chapter_name}</option>`;
                    });
                    pdfChapterSelect.innerHTML = options;
                    pdfChapterSelect.disabled = false;
                } else {
                    pdfChapterSelect.innerHTML = '<option value="">No chapters available</option>';
                    pdfChapterSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error loading PDF chapters:', error);
                pdfChapterSelect.innerHTML = '<option value="">Error loading chapters</option>';
                pdfChapterSelect.disabled = true;
            });
    }

    // Load PDF files
    function loadPdfFiles(subjectId, chapterId) {
        console.log('Loading PDF files for chapter:', chapterId);

        const pdfList = document.getElementById('pdf_list');
        pdfList.innerHTML = `
            <div class="loading-spinner text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">Loading PDFs...</p>
            </div>
        `;

        fetch('{{ route("student.get-pdf-files") }}?course_id=' + currentCourseId + '&subject_id=' + subjectId + '&chapter_id=' + chapterId)
            .then(response => response.json())
            .then(pdfFiles => {
                console.log('PDF files loaded:', pdfFiles);
                currentPdfs = pdfFiles;

                if (pdfFiles && pdfFiles.length > 0) {
                    displayPdfList(pdfFiles);
                    document.getElementById('select_pdf_chapter_message').style.display = 'none';
                } else {
                    pdfList.innerHTML = `
                        <div class="no-pdfs">
                            <i class="fas fa-file-pdf"></i>
                            <p>No PDF notes available for this chapter</p>
                        </div>
                    `;
                    resetPdfSection();
                }
            })
            .catch(error => {
                //console.error('Error loading PDF files:', error);
                pdfList.innerHTML = `
                    <div class="no-pdfs">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Error loading PDFs</p>
                    </div>
                `;
                resetPdfSection();
            });
    }

    // Display PDF list
    function displayPdfList(pdfs) {
        const pdfList = document.getElementById('pdf_list');
        let html = '';

        pdfs.forEach((pdf, index) => {
            const pdfTitle = pdf.title || pdf.pdf_name || `PDF Document ${index + 1}`;
            html += `
                <div class="pdf-item" data-index="${index}" onclick="loadPdf(${index})"
                     style="cursor: pointer;"
                     onmouseover="this.style.cursor='pointer'"
                     title="Click to view ${pdfTitle}">
                    <div class="pdf-item-title">
                        <i class="fas fa-file-pdf text-danger me-2"></i>
                        <span>${pdfTitle}</span>
                    </div>
                    ${pdf.description ? `<div class="pdf-description">${pdf.description}</div>` : ''}
                </div>
            `;
        });

        pdfList.innerHTML = html;
    }

    // Load PDF
    window.loadPdf = function(index) {
        if (!currentPdfs[index]) {
            console.error('PDF not found at index:', index);
            return;
        }

        selectedPdfIndex = index;
        const pdf = currentPdfs[index];
        console.log('Loading PDF:', pdf);

        // Remove active class from all items
        document.querySelectorAll('#pdf_list .pdf-item').forEach(item => {
            item.classList.remove('active');
        });

        // Add active class to current item
        const currentItem = document.querySelector(`#pdf_list .pdf-item[data-index="${index}"]`);
        if (currentItem) {
            currentItem.classList.add('active');
        }

        // Update PDF viewer
        const pdfTitle = pdf.title || `PDF Document ${selectedPdfIndex + 1}`;
        document.getElementById('current_pdf_title').textContent = pdfTitle;

        const pdfViewerContent = document.getElementById('pdf_viewer_content');

        if (pdf.pdf_url) {
            // Display PDF in iframe
            pdfViewerContent.innerHTML = `
                <iframe src="${pdf.pdf_url}"
                        width="100%"
                        height="600"
                        frameborder="0"
                        style="border: none;">
                    <p>Your browser does not support PDFs.
                       <a href="${pdf.pdf_url}" target="_blank">Download the PDF</a>
                    </p>
                </iframe>
            `;

            document.getElementById('pdf_viewer_section').style.display = 'block';
            document.getElementById('select_pdf_chapter_message').style.display = 'none';
        } else {
            alert('PDF file not available');
            console.error('No PDF URL for:', pdf);
        }
    };

    // Reset PDF section
    function resetPdfSection() {
        document.getElementById('pdf_viewer_section').style.display = 'none';
        document.getElementById('select_pdf_chapter_message').style.display = 'block';
        document.getElementById('pdf_list').innerHTML = `
            <div class="no-pdfs">
                <i class="fas fa-file-pdf"></i>
                <p>Select a chapter to load PDF notes</p>
            </div>
        `;
        currentPdfs = [];
        selectedPdfIndex = null;
    }

    // Check if video is completed
    async function checkVideoCompleted(videoId) {
        try {
            const response = await fetch('{{ route("student.check-video-completed") }}?video_id=' + videoId);
            const data = await response.json();
            return data.completed || false;
        } catch (error) {
            console.error('Error checking video completion:', error);
            return false;
        }
    }

    // Mark video as completed function
    window.markVideoAsCompleted = async function() {
        if (!currentVideos[currentVideoIndex]) {
            alert('No video selected');
            return;
        }

        const video = currentVideos[currentVideoIndex];
        const markBtn = document.getElementById('mark_completed_btn');
        const completedBadge = document.getElementById('completed_status');

        // Disable button while processing
        markBtn.disabled = true;
        markBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Marking...';

        try {
            const response = await fetch('{{ route("student.mark-video-completed") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    video_id: video.id,
                    course_id: currentCourseId,
                    subject_id: currentSubjectId
                })
            });

            const data = await response.json();

            if (data.success) {
                // Hide button, show completed badge
                markBtn.style.display = 'none';
                completedBadge.style.display = 'inline-flex';

                // Update video list to show completion badge
                currentVideos[currentVideoIndex].is_completed = true;
                displayVideoList(currentVideos);

                // Re-apply active class to current video
                const currentItem = document.querySelector(`.video-item[data-index="${currentVideoIndex}"]`);
                if (currentItem) {
                    currentItem.classList.add('active');
                }

                // Show success message
                alert(data.message);
            } else {
                alert(data.message || 'Failed to mark video as completed');
                markBtn.disabled = false;
                markBtn.innerHTML = '<i class="fas fa-check-circle"></i> Mark as Completed';
            }
        } catch (error) {
            console.error('Error marking video as completed:', error);
            alert('Failed to mark video as completed. Please try again.');
            markBtn.disabled = false;
            markBtn.innerHTML = '<i class="fas fa-check-circle"></i> Mark as Completed';
        }
    };

    // Update the playVideo and loadVideoWithoutPlaying functions to check completion status
    async function updateCompletionUI(videoId) {
        const markBtn = document.getElementById('mark_completed_btn');
        const completedBadge = document.getElementById('completed_status');

        if (!markBtn || !completedBadge) return;

        // Check if video is completed
        const isCompleted = await checkVideoCompleted(videoId);

        if (isCompleted) {
            markBtn.style.display = 'none';
            completedBadge.style.display = 'inline-flex';
        } else {
            markBtn.style.display = 'inline-block';
            markBtn.disabled = false;
            markBtn.innerHTML = '<i class="fas fa-check-circle"></i> Mark as Completed';
            completedBadge.style.display = 'none';
        }

        // Also show comments section and load comments
        const commentsSection = document.getElementById('comments_section');
        if (commentsSection) {
            commentsSection.style.display = 'block';
            loadComments(videoId);
        }
    }

    // Load comments for a video
    async function loadComments(videoId) {
        try {
            const response = await fetch('{{ route("student.get-video-comments") }}?video_id=' + videoId);
            const data = await response.json();

            const commentsList = document.getElementById('comments_list');
            if (!commentsList) return;

            if (data.success && data.comments && data.comments.length > 0) {
                let html = '';
                data.comments.forEach(comment => {
                    html += `
                        <div class="comment-item">
                            <div class="comment-header">
                                <div class="comment-author">
                                    <i class="fas fa-user-circle"></i>
                                    ${comment.student_name}
                                </div>
                                <div class="comment-date">
                                    <i class="far fa-clock"></i> ${comment.created_at}
                                </div>
                            </div>
                            <div class="comment-text">${escapeHtml(comment.comments)}</div>
                        </div>
                    `;
                });
                commentsList.innerHTML = html;
            } else {
                commentsList.innerHTML = `
                    <div class="no-comments">
                        <i class="fas fa-comment-slash"></i>
                        <p>No comments yet. Be the first to comment!</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading comments:', error);
        }
    }

    // Submit comment function
    window.submitComment = async function() {
        if (!currentVideos[currentVideoIndex]) {
            alert('No video selected');
            return;
        }

        const commentInput = document.getElementById('comment_input');
        const submitBtn = document.getElementById('submit_comment_btn');
        const comment = commentInput.value.trim();

        if (!comment) {
            alert('Please enter a comment');
            return;
        }

        const video = currentVideos[currentVideoIndex];

        // Disable button while processing
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Posting...';

        try {
            const response = await fetch('{{ route("student.add-video-comment") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    video_id: video.id,
                    course_id: currentCourseId,
                    subject_id: currentSubjectId,
                    comment: comment
                })
            });

            const data = await response.json();

            if (data.success) {
                // Clear input
                commentInput.value = '';

                // Reload comments
                await loadComments(video.id);

                // Show success message
                alert(data.message);
            } else {
                alert(data.message || 'Failed to add comment');
            }
        } catch (error) {
            console.error('Error submitting comment:', error);
            alert('Failed to add comment. Please try again.');
        } finally {
            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Post Comment';
        }
    };

    // Helper function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Make functions globally available
    window.loadChapters = loadChapters;
    window.loadVideos = loadVideos;
    window.displayVideoList = displayVideoList;
    window.resetVideoSection = resetVideoSection;
    window.loadVideoWithoutPlaying = loadVideoWithoutPlaying;
    window.loadPdfChapters = loadPdfChapters;
    window.loadPdfFiles = loadPdfFiles;
    window.displayPdfList = displayPdfList;
    window.loadPdf = loadPdf;
    window.resetPdfSection = resetPdfSection;
    window.checkVideoCompleted = checkVideoCompleted;
    window.updateCompletionUI = updateCompletionUI;

})();

// Toggle Course Details Function (Outside IIFE for global access)
function toggleCourseDetails() {
    const detailsContent = document.getElementById('courseDetailsContent');
    const toggleBtn = document.getElementById('toggleDetailsBtn');

    if (detailsContent.classList.contains('show')) {
        // Hide details
        detailsContent.classList.remove('show');
        toggleBtn.classList.remove('expanded');
        toggleBtn.innerHTML = '<i class="fas fa-chevron-down"></i> Course Details';
    } else {
        // Show details
        detailsContent.classList.add('show');
        toggleBtn.classList.add('expanded');
        toggleBtn.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Details';
    }
}
</script>
@endpush

