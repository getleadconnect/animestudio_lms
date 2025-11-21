@extends('website.layout')

@section('title', 'Easy Tips')

@section('content')
<style>
    .easy-tips-container {
        max-width: 1368px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .page-header-content h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .page-header-content p {
        margin: 10px 0 0 0;
        opacity: 0.9;
    }

    .back-to-dashboard-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .back-to-dashboard-btn:hover {
        background: white;
        color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .filter-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .filter-dropdown-wrapper {
        flex: 1;
        min-width: 250px;
    }

    .filter-section label {
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        display: block;
    }

    .filter-section select {
        width: 100%;
        max-width: 400px;
        padding: 12px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .filter-section select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .tips-info-note {
        background: linear-gradient(135deg, #fffbf0 0%, #fff9e6 100%);
        border-left: 4px solid #ffc107;
        padding: 15px 20px;
        border-radius: 8px;
        flex: 0 0 auto;
        max-width: 350px;
        min-width: 250px;
    }

    .tips-info-note .note-icon {
        color: #ffc107;
        font-size: 1.2rem;
        margin-right: 10px;
    }

    .tips-info-note .note-text {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.5;
        margin: 0;
    }

    @media (max-width: 768px) {
        .filter-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .tips-info-note {
            max-width: 100%;
            width: 100%;
        }
    }

    .tips-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        margin-top: 30px;
    }

    .tip-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .tip-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .tip-icon-container {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, #fffbf0 0%, #fff9e6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .tip-icon-container img {
        max-width: 80%;
        max-height: 80%;
        object-fit: contain;
    }

    .tip-icon-container .default-icon {
        font-size: 4rem;
        color: #ffc107;
    }

    .file-type-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .file-type-badge.video {
        color: #dc3545;
    }

    .file-type-badge.pdf {
        color: #28a745;
    }

    .tip-content {
        padding: 20px;
    }

    .tip-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        margin: 0 0 10px 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .tip-description {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .empty-state i {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #666;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #999;
    }

    .loading-spinner {
        text-align: center;
        padding: 40px;
        display: none;
    }

    .loading-spinner.active {
        display: block;
    }

    .loading-spinner i {
        font-size: 3rem;
        color: #667eea;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Video Modal */
    .video-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 10000;
        padding: 20px;
    }

    .video-modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .video-modal-content {
        width: 100%;
        max-width: 1000px;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
    }

    .video-modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .video-modal-header h3 {
        margin: 0;
        font-size: 1.3rem;
    }

    .close-modal {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-size: 1.5rem;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .close-modal:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .video-modal-body {
        padding: 0;
    }

    .video-wrapper {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
    }

    .video-wrapper video,
    .video-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .tip-description-full {
        padding: 20px;
        color: #666;
        line-height: 1.6;
        border-top: 1px solid #eee;
    }

    /* PDF Modal */
    .pdf-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 10000;
        padding: 20px;
    }

    .pdf-modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pdf-modal-content {
        width: 100%;
        max-width: 1000px;
        height: 90vh;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .pdf-modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pdf-modal-header h3 {
        margin: 0;
        font-size: 1.3rem;
    }

    .pdf-modal-body {
        flex: 1;
        overflow: hidden;
    }

    .pdf-modal-body iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    @media (max-width: 768px) {
        .tips-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-header-content h1 {
            font-size: 1.5rem;
        }

        .back-to-dashboard-btn {
            width: 100%;
            justify-content: center;
        }

        .video-modal-content,
        .pdf-modal-content {
            max-width: 100%;
        }
    }
</style>

<div class="easy-tips-container">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-lightbulb me-2"></i> Easy Tips</h1>
            <p>Watch helpful videos and read tips to enhance your learning</p>
        </div>
        <a href="{{ route('student.dashboard') }}" class="back-to-dashboard-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>

    <div class="filter-section">
        <div class="filter-dropdown-wrapper">
            <label for="courseFilter">
                <i class="fas fa-filter me-2"></i> Select Course
            </label>
            <select id="courseFilter" class="form-select">
                <option value="">Select a course to view tips...</option>
                @foreach($courses as $index => $course)
                    <option value="{{ $course->id }}" {{ $index === 0 ? 'selected' : '' }}>{{ $course->course_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="tips-info-note">
            <p class="note-text">
                <i class="fas fa-info-circle note-icon"></i>
                <strong>Easy Tips:</strong> Quick learning resources to help you understand concepts faster and remember them better.
            </p>
        </div>
    </div>

    <div class="loading-spinner" id="loadingSpinner">
        <i class="fas fa-spinner"></i>
        <p>Loading tips...</p>
    </div>

    <div id="tipsContainer">
        <div class="empty-state">
            <i class="fas fa-lightbulb"></i>
            <h3>Select a course to view tips</h3>
            <p>Choose a course from the dropdown above to see available easy tips</p>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div class="video-modal" id="videoModal">
    <div class="video-modal-content">
        <div class="video-modal-header">
            <h3 id="videoModalTitle"></h3>
            <button class="close-modal" onclick="closeVideoModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="video-modal-body">
            <div class="video-wrapper">
                <video id="videoPlayer" controls controlsList="nodownload">
                    <source id="videoSource" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="tip-description-full" id="videoDescription"></div>
        </div>
    </div>
</div>

<!-- PDF Modal -->
<div class="pdf-modal" id="pdfModal">
    <div class="pdf-modal-content">
        <div class="pdf-modal-header">
            <h3 id="pdfModalTitle"></h3>
            <button class="close-modal" onclick="closePdfModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="pdf-modal-body">
            <iframe id="pdfViewer" src=""></iframe>
        </div>
    </div>
</div>

<script>
    const courseFilter = document.getElementById('courseFilter');
    const tipsContainer = document.getElementById('tipsContainer');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const easyTipsBasePath = '{{ config('constants.easy_tips') }}';

    // Course filter change event
    courseFilter.addEventListener('change', function() {
        const courseId = this.value;
        if (courseId) {
            loadTips(courseId);
        } else {
            showEmptyState();
        }
    });

    // Load tips for selected course
    async function loadTips(courseId) {
        loadingSpinner.classList.add('active');
        tipsContainer.innerHTML = '';

        try {
            const response = await fetch(`{{ route('student.easy-tips.filter') }}?course_id=${courseId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (data.success) {
                if (data.tips.length > 0) {
                    displayTips(data.tips);
                } else {
                    showNoTips();
                }
            } else {
                showError(data.message);
            }
        } catch (error) {
            console.error('Error loading tips:', error);
            showError('Failed to load tips. Please try again.');
        } finally {
            loadingSpinner.classList.remove('active');
        }
    }

    // Display tips in grid
    function displayTips(tips) {
        const grid = document.createElement('div');
        grid.className = 'tips-grid';

        tips.forEach(tip => {
            const card = createTipCard(tip);
            grid.appendChild(card);
        });

        tipsContainer.innerHTML = '';
        tipsContainer.appendChild(grid);
    }

    // Create individual tip card
    function createTipCard(tip) {
        const card = document.createElement('div');
        card.className = 'tip-card';
        card.onclick = () => openTip(tip);

        const fileType = tip.file_type == 1 ? 'video' : tip.file_type==2 ?'pdf':'img';
        const fileTypeLabel = tip.file_type == 1 ? 'Video' : tip.file_type==2 ? 'PDF' :'IMG';
        const iconUrl = tip.tips_icon ? easyTipsBasePath + tip.tips_icon : '';

        card.innerHTML = `
            <div class="tip-icon-container">
                ${iconUrl ?
                    `<img src="${iconUrl}" alt="${escapeHtml(tip.title)}">` :
                    `<i class="fas fa-lightbulb default-icon"></i>`
                }
                <span class="file-type-badge ${fileType}">
                    <i class="fas fa-${fileType == 'video' ? 'play-circle' : 'file-pdf'} me-1"></i>
                    ${fileTypeLabel}
                </span>
            </div>
            <div class="tip-content">
                <h3 class="tip-title">${escapeHtml(tip.title)}</h3>
                <p class="tip-description">${escapeHtml(tip.description || 'No description available')}</p>
            </div>
        `;

        return card;
    }

    // Open tip (video or PDF)
    function openTip(tip) {
        if (tip.file_type == 1) {
            openVideo(tip);
        } else {
            openPdf(tip);
        }
    }

    // Open video modal
    function openVideo(tip) {
        const videoModal = document.getElementById('videoModal');
        const videoPlayer = document.getElementById('videoPlayer');
        const videoSource = document.getElementById('videoSource');
        const videoModalTitle = document.getElementById('videoModalTitle');
        const videoDescription = document.getElementById('videoDescription');

        const videoUrl = easyTipsBasePath + tip.tips_file;

        videoModalTitle.textContent = tip.title;
        videoSource.src = videoUrl;
        videoPlayer.load();
        videoDescription.textContent = tip.description || 'No description available';

        videoModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Close video modal
    function closeVideoModal() {
        const videoModal = document.getElementById('videoModal');
        const videoPlayer = document.getElementById('videoPlayer');

        videoPlayer.pause();
        videoModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Open PDF modal
    function openPdf(tip) {
        const pdfModal = document.getElementById('pdfModal');
        const pdfViewer = document.getElementById('pdfViewer');
        const pdfModalTitle = document.getElementById('pdfModalTitle');

        const pdfUrl = easyTipsBasePath + tip.tips_file;

        pdfModalTitle.textContent = tip.title;
        pdfViewer.src = pdfUrl;

        pdfModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Close PDF modal
    function closePdfModal() {
        const pdfModal = document.getElementById('pdfModal');
        const pdfViewer = document.getElementById('pdfViewer');

        pdfViewer.src = '';
        pdfModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Show empty state
    function showEmptyState() {
        tipsContainer.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-lightbulb"></i>
                <h3>Select a course to view tips</h3>
                <p>Choose a course from the dropdown above to see available easy tips</p>
            </div>
        `;
    }

    // Show no tips message
    function showNoTips() {
        tipsContainer.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-info-circle"></i>
                <h3>No tips available</h3>
                <p>There are no easy tips available for this course yet</p>
            </div>
        `;
    }

    // Show error message
    function showError(message) {
        tipsContainer.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>Error</h3>
                <p>${escapeHtml(message)}</p>
            </div>
        `;
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Close modals on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeVideoModal();
            closePdfModal();
        }
    });

    // Close modals on outside click
    document.getElementById('videoModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeVideoModal();
        }
    });

    document.getElementById('pdfModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePdfModal();
        }
    });

    // Load tips for first course on page load
    document.addEventListener('DOMContentLoaded', function() {
        const courseFilter = document.getElementById('courseFilter');
        const firstCourseId = courseFilter.value;

        if (firstCourseId) {
            loadTips(firstCourseId);
        }
    });
</script>
@endsection
