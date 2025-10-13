@extends('website.layout')

@section('title', $course->course_name . ' - Recorded Classes')

@push('styles')
<style>
    .content-container {
        padding: 30px 0;
        background: #f8f9fa;
        min-height: 80vh;
    }

    .breadcrumb {
        background: white;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .video-player-section {
        background: #000;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
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
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .video-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .video-meta {
        color: #666;
        font-size: 0.95rem;
    }

    .video-meta i {
        color: #667eea;
        margin-right: 5px;
    }

    .video-description {
        margin-top: 15px;
        color: #444;
        line-height: 1.6;
    }

    .recorded-classes-list {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        max-height: 600px;
        overflow-y: auto;
    }

    .recorded-classes-list::-webkit-scrollbar {
        width: 6px;
    }

    .recorded-classes-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .recorded-classes-list::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }

    .list-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px;
        border-radius: 10px 10px 0 0;
        margin: -15px -15px 15px -15px;
    }

    .list-header h5 {
        margin: 0;
        font-size: 1.25rem;
    }

    .class-item {
        padding: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fff;
    }

    .class-item:hover {
        background: #f8f9fa;
        border-color: #667eea;
        transform: translateX(5px);
    }

    .class-item.active {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-color: #667eea;
        border-left: 4px solid #667eea;
    }

    .class-item-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        font-size: 0.95rem;
    }

    .class-item-meta {
        font-size: 0.85rem;
        color: #666;
    }

    .class-item-meta i {
        color: #667eea;
        margin-right: 3px;
    }

    .no-video-placeholder {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        border-radius: 10px;
    }

    .no-video-placeholder i {
        font-size: 4rem;
        margin-bottom: 20px;
    }

    .no-classes-message {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .no-classes-message i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .content-container {
            padding: 15px 0;
        }

        .video-title {
            font-size: 1.2rem;
        }

        .recorded-classes-list {
            max-height: 400px;
            margin-top: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="content-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $course->course_name }} - Recorded Classes</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Video Player Column (Left) -->
            <div class="col-lg-8 mb-4">
                <!-- Video Player -->
                <div class="video-player-section">
                    <div class="video-player-wrapper">
                        <div id="video_container">
                            @if(isset($recordedClasses) && count($recordedClasses) > 0)
                                <video id="video_player" controls controlsList="nodownload" disablePictureInPicture>
                                    <source src="{{ config('constants.recorded_class_video').$recordedClasses[0]->video_file }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <div class="no-video-placeholder">
                                    <div class="text-center">
                                        <i class="fas fa-video"></i>
                                        <h4>No Recorded Classes Available</h4>
                                        <p>Please check back later</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Video Information -->
                @if(isset($recordedClasses) && count($recordedClasses) > 0)
                <div class="video-info-section">
                    <h3 class="video-title" id="video_title">{{ $recordedClasses[0]->title }}</h3>
                    <div class="video-meta">
                        <span><i class="fas fa-user"></i> <strong>Instructor:</strong> <span id="video_instructor">{{ $recordedClasses[0]->class_by }}</span></span>
                        @if($recordedClasses[0]->duration)
                        <span class="ms-3"><i class="fas fa-clock"></i> <strong>Duration:</strong> <span id="video_duration">{{ $recordedClasses[0]->duration }}</span></span>
                        @endif
                    </div>
                    @if($recordedClasses[0]->description)
                    <div class="video-description">
                        <strong><i class="fas fa-info-circle"></i> Description:</strong>
                        <p id="video_description">{{ $recordedClasses[0]->description }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Recorded Classes List Column (Right) -->
            <div class="col-lg-4">
                <div class="recorded-classes-list">
                    <div class="list-header">
                        <h5><i class="fas fa-play-circle"></i> Recorded Classes ({{ count($recordedClasses) }})</h5>
                    </div>

                    @if(isset($recordedClasses) && count($recordedClasses) > 0)
                        <div id="classes_list">
                            @foreach($recordedClasses as $index => $class)
                            <div class="class-item {{ $index == 0 ? 'active' : '' }}"
                                 onclick="playRecordedClass({{ $index }})"
                                 data-video-url="{{ config('constants.recorded_class_video').$class->video_file }}"
                                 data-title="{{ $class->title }}"
                                 data-instructor="{{ $class->class_by }}"
                                 data-duration="{{ $class->duration ?? 'N/A' }}"
                                 data-description="{{ $class->description ?? '' }}">
                                <div class="class-item-title">
                                    <i class="fas fa-play-circle me-2"></i>{{ $class->title }}
                                </div>
                                <div class="class-item-meta">
                                    <i class="fas fa-user"></i> {{ $class->class_by }}
                                    @if($class->duration)
                                    <span class="ms-2"><i class="fas fa-clock"></i> {{ $class->duration }}</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-classes-message">
                            <i class="fas fa-play-circle"></i>
                            <p>No recorded classes available for this course</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function playRecordedClass(index) {
        const classItems = document.querySelectorAll('.class-item');
        const clickedClass = classItems[index];

        // Remove active class from all items
        classItems.forEach(item => item.classList.remove('active'));

        // Add active class to clicked item
        clickedClass.classList.add('active');

        // Get data from clicked item
        const videoUrl = clickedClass.dataset.videoUrl;
        const title = clickedClass.dataset.title;
        const instructor = clickedClass.dataset.instructor;
        const duration = clickedClass.dataset.duration;
        const description = clickedClass.dataset.description;

        // Update video player
        const videoPlayer = document.getElementById('video_player');
        if (videoPlayer) {
            videoPlayer.src = videoUrl;
            videoPlayer.load();
            videoPlayer.play();
        }

        // Update video information
        document.getElementById('video_title').textContent = title;
        document.getElementById('video_instructor').textContent = instructor;
        document.getElementById('video_duration').textContent = duration;

        if (description && document.getElementById('video_description')) {
            document.getElementById('video_description').textContent = description;
        }

        // Scroll to top on mobile
        if (window.innerWidth < 768) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
</script>
@endpush
