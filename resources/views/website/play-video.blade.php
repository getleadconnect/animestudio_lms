@extends('website.layout')

@section('title', $video->video_name)

@section('content')

<style>
    .full-video-player {
        background: #000;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .full-video-wrapper {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
    }

    .full-video-wrapper video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .video-meta-info {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .related-videos-section {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .related-video-item {
        display: flex;
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .related-video-item:hover {
        background: #f8f9fa;
        transform: translateX(5px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .related-video-thumb {
        width: 150px;
        height: 85px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 15px;
    }

    .related-video-info {
        flex: 1;
    }

    .related-video-title {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        line-height: 1.4;
    }

    .related-video-duration {
        font-size: 12px;
        color: #666;
    }

    @media (max-width: 768px) {
        .related-video-thumb {
            width: 120px;
            height: 70px;
        }
    }
</style>

<div class="container mt-4 mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses') }}">Courses</a></li>
            <li class="breadcrumb-item active">{{ $video->video_name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <div class="full-video-player">
                <div class="full-video-wrapper">
                    <video id="video_player" controls controlsList="nodownload" autoplay>
                        <source src="{{ $video->video_link }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

            <div class="video-meta-info">
                <h2 class="mb-3">{{ $video->video_name }}</h2>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="badge bg-primary me-2">
                            <i class="fas fa-book"></i> {{ $video->subject->subject_name ?? 'N/A' }}
                        </span>
                        <span class="badge bg-secondary">
                            <i class="fas fa-bookmark"></i> {{ $video->chapter->chapter_name ?? 'N/A' }}
                        </span>
                    </div>
                    <div>
                        @if($video->is_free)
                            <span class="badge bg-success">FREE</span>
                        @else
                            <span class="badge bg-warning">PREMIUM</span>
                        @endif
                    </div>
                </div>
                <p class="text-muted">{{ $video->description }}</p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="related-videos-section">
                <h4 class="mb-3">Related Videos</h4>

                @if($relatedVideos->count() > 0)
                    @foreach($relatedVideos as $relatedVideo)
                        <a href="{{ route('play-video', $relatedVideo->id) }}" class="text-decoration-none">
                            <div class="related-video-item">
                                <img src="{{ $relatedVideo->video_thumbnail }}" alt="{{ $relatedVideo->video_name }}" class="related-video-thumb">
                                <div class="related-video-info">
                                    <div class="related-video-title">{{ $relatedVideo->video_name }}</div>
                                    <div class="related-video-duration">
                                        <i class="far fa-clock"></i> {{ $relatedVideo->video_duration ?? '00:00' }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="text-muted">No related videos available</p>
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        let videoPlayer = document.getElementById('video_player');

        videoPlayer.addEventListener('ended', function() {
            @if($relatedVideos->first())
                window.location.href = "{{ route('play-video', $relatedVideos->first()->id) }}";
            @endif
        });
    });
</script>
@endsection

@endsection