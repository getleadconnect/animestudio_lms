@extends('website.layout')

@section('title', 'Success Stories - AnimeStudio Learning Platform')

@push('styles')
<style>
    .success-stories-section {
        background: #f8f9fa;
        min-height: 80vh;
        padding: 40px 0;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .page-header h2 {
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 2rem;
    }

    .page-header p {
        margin: 0;
        opacity: 0.9;
    }

    .video-player-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }

    .video-wrapper {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        background: #000;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
        display: none;
    }

    .video-wrapper.show {
        display: block;
    }

    .video-wrapper video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .video-info-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        border-left: 4px solid #667eea;
    }

    .video-info-card h4 {
        color: #1c1d1f;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .video-info-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .video-info-meta span {
        color: #666;
        font-size: 0.9rem;
    }

    .video-info-meta i {
        color: #667eea;
        margin-right: 5px;
    }

    .video-description {
        color: #4a4a4a;
        line-height: 1.6;
        margin: 0;
        white-space: pre-wrap;
    }

    .stories-list-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .stories-list-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stories-list-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .stories-list-header .badge {
        background: rgba(255,255,255,0.2);
        color: white;
        font-size: 0.9rem;
        padding: 5px 12px;
    }

    .stories-scroll-container {
        max-height: 600px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .stories-scroll-container::-webkit-scrollbar {
        width: 8px;
    }

    .stories-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .stories-scroll-container::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }

    .stories-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #5568d3;
    }

    .story-item {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #f8f9fa;
        padding: 5px;
        border-radius: 10px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.3s;
        border: 1px solid transparent;
    }

    .story-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .story-item.active {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-color: #667eea;
    }

    .story-icon {
        width: 70px;
        height: 70px;
        flex-shrink: 0;
        border-radius: 10px;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .story-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .story-icon i {
        font-size: 2.5rem;
        color: white;
    }

    .story-details {
        flex: 1;
        min-width: 0;
    }

    .story-details h6 {
        font-size: 1.05rem;
        font-weight: 600;
        color: #1c1d1f;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .story-details .story-meta {
        font-size: 0.85rem;
        color: #666;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .story-details .story-meta i {
        color: #667eea;
        margin-right: 3px;
    }

    .play-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .btn-toggle-video {
        /*background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);*/
        color: #2e1ba1;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: .85rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-toggle-video:hover {
        color: #5568d3;
    }

    .btn-toggle-video i {
        transition: transform 0.3s ease;
    }

    .btn-toggle-video.active i {
        transform: rotate(90deg);
    }

    .toggle-button-wrapper {
        margin-bottom: 20px;
        text-align: center;
    }

    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .no-data i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #ddd;
    }

    .no-data p {
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .btn-back {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .content-section
    {
        margin-top:10px;
    }

    @media (max-width: 768px) {
        .success-stories-section {
            padding: 20px 0;
        }

        .page-header {
            padding: 20px;
        }

        .page-header h2 {
            font-size: 1.5rem;
        }

        .video-player-container,
        .stories-list-container {
            padding: 15px;
        }

        .story-item {
            flex-direction: column;
            text-align: center;
        }

        .story-icon {
            width: 100px;
            height: 100px;
        }

        .story-details h6 {
            white-space: normal;
        }

        .story-meta {
            justify-content: center;
        }
    }

    @media (min-width: 992px) {
        .stories-scroll-container {
            max-height: 700px;
        }
    }
</style>
@endpush

@section('content')
    <section class="success-stories-section">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2><i class="fas fa-trophy"></i> Success Stories</h2>
                        <p>Watch inspiring stories from our successful students</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('student.dashboard') }}" class="btn-back">
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
                    {{ $text }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(isset($successStories) && count($successStories) > 0)
                <div class="row">
                    <!-- Video Player Section (Left) -->
                    <div class="col-lg-8 mb-4">
                        <!-- Toggle Button - Only show if video exists -->
                        <div class="video-player-container">
                            <!-- Video Info Card - Always Visible -->
                            <div class="video-info-card mt-3">
                                <h4 id="storyName">{{ $successStories[0]->name }}</h4>
                                <div class="video-info-meta">
                                    <span id="storyPlace">
                                        <i class="fas fa-map-marker-alt"></i> {{ $successStories[0]->place ?? 'Not specified' }}
                                    </span>
                                </div>

                                    @if($successStories[0]->story_video)
                                    <a href="#" class="btn-toggle-video" id="toggleVideoBtn" onclick="toggleVideoPlayer()">
                                            <i class="fas fa-play"></i> Play Video
                                    </a>
                                    @endif

                                <div class="video-wrapper" id="videoWrapper">
                                <video id="successVideo" controls controlsList="nodownload">
                                    <source src="{{ config('constants.success_story') . $successStories[0]->story_video }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                </div>
                                <div class="content-section">
                                    <p id="storyDescription" class="video-description">{{ $successStories[0]->description ?? 'No description available' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stories List Section (Right) -->
                    <div class="col-lg-4">
                        <div class="stories-list-container">
                            <div class="stories-list-header">
                                <h5><i class="fas fa-list"></i> All Success Stories</h5>
                                <span class="badge">{{ count($successStories) }} Stories</span>
                            </div>

                            <div class="stories-scroll-container">
                                @foreach($successStories as $index => $story)
                                <div class="story-item {{ $index === 0 ? 'active' : '' }}"
                                     onclick="playStory({{ $index }})"
                                     data-index="{{ $index }}"
                                     data-video="{{ config('constants.success_story') . $story->story_video }}"
                                     data-has-video="{{ $story->story_video ? 'true' : 'false' }}"
                                     data-icon="{{ $story->story_icon ? config('constants.success_story') . $story->story_icon : '' }}"
                                     data-name="{{ $story->name }}"
                                     data-place="{{ $story->place ?? 'Not specified' }}"
                                     data-description="{{ $story->description ?? 'No description available' }}">

                                    <div class="story-icon">
                                        @if($story->story_icon)
                                            <img src="{{ config('constants.success_story') . $story->story_icon }}" alt="{{ $story->name }}">
                                        @else
                                            <i class="fas fa-user-graduate"></i>
                                        @endif
                                    </div>

                                    <div class="story-details">
                                        <h6>{{ $story->name }}</h6>
                                        <div class="story-meta">
                                            @if($story->place)
                                            <span><i class="fas fa-map-marker-alt"></i> {{ $story->place }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="video-player-container">
                    <div class="no-data">
                        <i class="fas fa-trophy"></i>
                        <p>No success stories available at the moment</p>
                        <a href="{{ route('student.dashboard') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Toggle video player visibility
    function toggleVideoPlayer() {
        const videoWrapper = document.getElementById('videoWrapper');
        const toggleBtn = document.getElementById('toggleVideoBtn');
        const videoPlayer = document.getElementById('successVideo');

        if (videoWrapper.classList.contains('show')) {
            // Hide video
            videoWrapper.classList.remove('show');
            toggleBtn.classList.remove('active');
            toggleBtn.innerHTML = '<i class="fas fa-play"></i> Play Video';

            // Pause video when hiding
            videoPlayer.pause();
        } else {
            // Show video and play
            videoWrapper.classList.add('show');
            toggleBtn.classList.add('active');
            toggleBtn.innerHTML = '<i class="fas fa-pause"></i> Hide Video';

            // Play video when showing
            videoPlayer.play().catch(error => {
                console.log('Autoplay prevented:', error);
            });
        }
    }

    // Play selected success story
    function playStory(index) {
        const storyItem = document.querySelector(`.story-item[data-index="${index}"]`);

        if (!storyItem) return;

        // Check if story has video
        const hasVideo = storyItem.getAttribute('data-has-video') === 'true';

        // Get story data
        const name = storyItem.getAttribute('data-name');
        const place = storyItem.getAttribute('data-place');
        const description = storyItem.getAttribute('data-description');

        // Update story info (always visible)
        document.getElementById('storyName').textContent = name;
        document.getElementById('storyPlace').innerHTML = `<i class="fas fa-map-marker-alt"></i> ${place}`;
        document.getElementById('storyDescription').textContent = description;

        // Update active state
        document.querySelectorAll('.story-item').forEach(item => {
            item.classList.remove('active');
        });
        storyItem.classList.add('active');

        // If story has video, just load the video source but keep it hidden
        if (hasVideo) {
            const videoUrl = storyItem.getAttribute('data-video');
            const videoPlayer = document.getElementById('successVideo');

            // Update video source but don't show or play
            videoPlayer.src = videoUrl;
            videoPlayer.load();

            // Make sure video wrapper stays hidden
            const videoWrapper = document.getElementById('videoWrapper');
            const toggleBtn = document.getElementById('toggleVideoBtn');

            // Reset to hidden state
            videoWrapper.classList.remove('show');
            if (toggleBtn) {
                toggleBtn.classList.remove('active');
                toggleBtn.innerHTML = '<i class="fas fa-play"></i> Play Video';
            }
        }

        // Scroll to top on mobile
        if (window.innerWidth < 992) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    }

    // Auto-dismiss alerts
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
@endpush
