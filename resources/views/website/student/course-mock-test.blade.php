@extends('website.layout')

@section('title', 'Mock Test')

@push('styles')
<style>
    /* Card border color */
    .card {
        border-color: #ebebeb !important;
    }

    /* Question papers list hover */
    .test-item:hover {
        background-color: #f8f9fa !important;
    }

    .test-item.active {
        background-color: #e7f3ff !important;
        /*border-left: 3px solid #0d6efd;*/
    }

    .form-select-lg
    {
        font-size: 1rem !important;
    }
</style>
@endpush

@section('content')

<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mock Test</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold" id="page_title">
            <i class="fas fa-clipboard-list text-primary me-2"></i>Mock Tests
        </h4>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-semibold"><i class="fas fa-filter me-2 text-primary"></i>Select Course & Exam</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="course_select" class="form-label fw-semibold">
                        <i class="fas fa-graduation-cap text-primary me-2"></i>Course
                    </label>
                    <select class="form-select form-select-lg" id="course_select">
                        <option value="">Choose a course...</option>
                        @foreach($myCourses as $myCourse)
                            <option value="{{ $myCourse->id }}">{{ $myCourse->course_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="exam_section_select" class="form-label fw-semibold">
                        <i class="fas fa-list-alt text-primary me-2"></i>Exam Section
                    </label>
                    <select class="form-select form-select-lg" id="exam_section_select" disabled>
                        <option value="">First select a course</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Left Column - Test Details -->
        <div class="col-lg-8">
            <!-- No Test Selected Message -->
            <div class="alert alert-info d-flex align-items-center" id="no_test_selected" role="alert">
                <i class="fas fa-info-circle fs-4 me-3"></i>
                <div>Please select a course, exam section, and test to view details.</div>
            </div>

            <!-- Test Section -->
            <div class="card" id="test_section" style="display: none;">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-clipboard-list me-2 text-primary"></i>
                        <span id="current_test_title">Mock Test</span>
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Test Info Section -->
                    <div id="test_info_section">
                        <!-- Test Stats -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-question-circle text-primary fs-3 me-2"></i>
                                            <h6 class="text-muted mb-0">Total Questions</h6>
                                        </div>
                                        <h4 class="mb-0 fw-bold" id="total_questions">0</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="far fa-clock text-warning fs-3 me-2"></i>
                                            <h6 class="text-muted mb-0">Duration</h6>
                                        </div>
                                        <h4 class="mb-0 fw-bold" id="test_duration">60 mins</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-star text-success fs-3 me-2"></i>
                                            <h6 class="text-muted mb-0">Total Marks</h6>
                                        </div>
                                        <h4 class="mb-0 fw-bold" id="total_marks">0</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div class="alert alert-warning border-warning">
                            <h6 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i>Instructions
                            </h6>
                            <ul class="mb-0">
                                <li>Read each question carefully before answering</li>
                                <li>You can navigate between questions using the question palette</li>
                                <li>Click "Submit Test" when you're done</li>
                                <li>Your progress will be saved automatically</li>
                            </ul>
                        </div>

                        <!-- Start Button -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-success btn-lg" onclick="startMockTest()">
                                <i class="fas fa-play me-2"></i>Start Mock Test
                            </button>
                        </div>
                    </div>

                    <!-- Test Content Section (Hidden Initially) -->
                    <div id="test_content_section" style="display: none;">
                        <!-- Test questions will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Latest Result Card -->
            <div class="card mt-4" id="latest_result_card" style="display: none;">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>Your Latest Result
                    </h6>
                </div>
                <div class="card-body" id="latest_result_content">
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Test List -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-list-ol me-2 text-primary"></i>Available Tests
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" id="test_list" style="max-height: 600px; overflow-y: auto;">
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-clipboard-check fs-1 mb-3 d-block"></i>
                            <p>Please select a course and exam section to view mock tests</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Mock Test Page JavaScript
(function() {
    'use strict';

    // Global variables
    let currentCourseId = null;
    let currentExamSectionId = null;
    let currentTests = [];
    let selectedTestId = null;

    // Wait for DOM to load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Mock Test Page Loaded');

        // Get select elements
        const courseSelect = document.getElementById('course_select');
        const examSectionSelect = document.getElementById('exam_section_select');

        // Load question papers for initially selected course
        if (courseSelect && courseSelect.value) {
            currentCourseId = courseSelect.value;
            loadExamSections();
        }

        // Course change event
        if (courseSelect) {
            courseSelect.addEventListener('change', function() {
                const selectedCourseId = this.value;
                console.log('Course selected:', selectedCourseId);

                if (selectedCourseId) {
                    currentCourseId = selectedCourseId;
                    currentExamSectionId = null; // Reset exam section

                    // Load exam sections for this course
                    loadExamSections();
                } else {
                    // Clear everything when no course is selected
                    examSectionSelect.innerHTML = '<option value="">First select a course</option>';
                    examSectionSelect.disabled = true;
                    document.getElementById('test_list').innerHTML = `
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-graduation-cap fs-1 mb-3 d-block"></i>
                            <p>Please select a course to view mock tests</p>
                        </div>
                    `;
                    document.getElementById('test_section').style.display = 'none';
                    document.getElementById('no_test_selected').style.display = 'block';
                    currentTests = [];
                    selectedTestId = null;
                }
            });
        }

        // Exam section change event
        if (examSectionSelect) {
            examSectionSelect.addEventListener('change', function() {
                const selectedExamSectionId = this.value;
                console.log('Exam section selected:', selectedExamSectionId);

                currentExamSectionId = selectedExamSectionId;

                if (currentCourseId && selectedExamSectionId) {
                    // Only load question papers if both course and exam section are selected
                    loadAllQuestionPapers();
                } else {
                    // Clear test list if no exam section selected
                    document.getElementById('test_list').innerHTML = `
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-list-alt fs-1 mb-3 d-block"></i>
                            <p>Please select an exam section to view mock tests</p>
                        </div>
                    `;
                    document.getElementById('test_section').style.display = 'none';
                    currentTests = [];
                    selectedTestId = null;
                }
            });
        }
    });

    // Load exam sections for selected course
    function loadExamSections() {
        console.log('Loading exam sections for course:', currentCourseId);

        const examSectionSelect = document.getElementById('exam_section_select');
        examSectionSelect.innerHTML = '<option value="">Loading...</option>';
        examSectionSelect.disabled = true;

        // Clear test list when loading new exam sections
        document.getElementById('test_list').innerHTML = `
            <div class="text-center py-5 text-muted">
                <i class="fas fa-list-alt fs-1 mb-3 d-block"></i>
                <p>Please select an exam section to view mock tests</p>
            </div>
        `;
        document.getElementById('test_section').style.display = 'none';
        currentTests = [];
        selectedTestId = null;

        // Make AJAX request to get exam sections
        fetch('{{ route("student.get-exam-sections") }}?course_id=' + currentCourseId)
            .then(response => response.json())
            .then(examSections => {
                console.log('Exam sections loaded:', examSections);

                let options = '<option value="">Choose an exam section...</option>';

                if (examSections.length > 0) {
                    examSections.forEach(section => {
                        options += `<option value="${section.id}">${section.tab_heading}</option>`;
                    });
                    examSectionSelect.innerHTML = options;
                    examSectionSelect.disabled = false;
                } else {
                    examSectionSelect.innerHTML = '<option value="">No exam sections available</option>';
                    examSectionSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error loading exam sections:', error);
                examSectionSelect.innerHTML = '<option value="">Error loading sections</option>';
                examSectionSelect.disabled = true;
            });
    }

    // Load all question papers for the course and exam section
    function loadAllQuestionPapers() {
        console.log('Loading question papers - Course:', currentCourseId, 'Exam Section:', currentExamSectionId);

        // Require both course and exam section
        if (!currentCourseId || !currentExamSectionId) {
            console.log('Both course and exam section must be selected');
            return;
        }

        const testList = document.getElementById('test_list');
        testList.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Loading mock tests...</p>
            </div>
        `;

        // Hide the no test selected message initially
        document.getElementById('no_test_selected').style.display = 'none';

        // Build query with both course_id and exam_section_id
        let queryParams = 'course_id=' + currentCourseId + '&exam_section_id=' + currentExamSectionId;

        // Make AJAX request to get question papers
        fetch('{{ route("student.get-question-papers") }}?' + queryParams)
            .then(response => response.json())
            .then(questionPapers => {
                console.log('Question papers loaded:', questionPapers);
                currentTests = questionPapers;

                if (questionPapers && questionPapers.length > 0) {
                    displayTestList(questionPapers);
                    // Automatically select the first test
                    selectTest(0);
                } else {
                    testList.innerHTML = `
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-file-alt fs-1 mb-3 d-block"></i>
                            <p>No mock tests available for this section</p>
                        </div>
                    `;
                    document.getElementById('no_test_selected').style.display = 'block';
                    document.getElementById('test_section').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error loading question papers:', error);
                testList.innerHTML = `
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-exclamation-triangle fs-1 mb-3 d-block text-danger"></i>
                        <p>Error loading mock tests</p>
                    </div>
                `;
                document.getElementById('no_test_selected').style.display = 'block';
                document.getElementById('test_section').style.display = 'none';
            });
    }

    // Display test list
    function displayTestList(tests) {
        console.log('Displaying test list');
        const testList = document.getElementById('test_list');
        let html = '';

        tests.forEach((test, index) => {
            const duration = test.duration ? test.duration + ' mins' : 'No limit';

            html += `
                <a href="javascript:void(0)" class="list-group-item list-group-item-action test-item" data-index="${index}" onclick="selectTest(${index})" style="margin:10px 0px;">
                    <div class="d-flex w-100 justify-content-between align-items-start">
                        <h6 class="mb-1 fw-semibold" style="color:#000 !important;">
                            <i class="fas fa-clipboard-list me-2 text-primary"></i>${test.question_paper_name}
                        </h6>
                    </div>
                    <div class="row mt-2 g-2 small text-muted">
                        <div class="col-6">
                            <i class="fas fa-question-circle me-1"></i>${test.total_questions} Questions
                        </div>
                        <div class="col-6">
                            <i class="far fa-clock me-1"></i>${duration}
                        </div>
                        <div class="col-6">
                            <i class="fas fa-star me-1"></i>${test.total_marks} Marks
                        </div>
                        <div class="col-6 text-end">
                            ${test.attempt_count > 0 ? `<span class="badge bg-info">${test.attempt_count} Attempt${test.attempt_count > 1 ? 's' : ''}</span>` : ''}
                        </div>
                    </div>
                    ${test.description ? `<p class="mb-0 mt-2 small text-muted">${test.description}</p>` : ''}
                </a>
            `;
        });

        testList.innerHTML = html;
    }

    // Select a test
    window.selectTest = function(index) {
        if (!currentTests[index]) {
            console.error('Test not found at index:', index);
            return;
        }

        selectedTestId = currentTests[index].id;
        const test = currentTests[index];
        console.log('Selected test:', test);

        // Remove active class from all items
        document.querySelectorAll('.test-item').forEach(item => {
            item.classList.remove('active');
        });

        // Add active class to current item
        const currentItem = document.querySelector(`.test-item[data-index="${index}"]`);
        if (currentItem) {
            currentItem.classList.add('active');
        }

        // Update test information
        document.getElementById('current_test_title').textContent = test.question_paper_name;
        document.getElementById('total_questions').textContent = test.total_questions || 0;
        document.getElementById('test_duration').textContent = test.duration ? test.duration + ' mins' : 'No limit';
        document.getElementById('total_marks').textContent = test.total_marks || 0;

        // Show test section
        document.getElementById('test_section').style.display = 'block';
        document.getElementById('no_test_selected').style.display = 'none';

        // Load latest result if student has attempted this test
        loadLatestResult(selectedTestId);

        // Scroll to view
        if (currentItem) {
            currentItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    };

    // Load latest result for selected test
    function loadLatestResult(questionPaperId) {
        const resultCard = document.getElementById('latest_result_card');
        const resultContent = document.getElementById('latest_result_content');

        // Show loading
        resultCard.style.display = 'block';
        resultContent.innerHTML = `
            <div class="text-center py-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

        // Fetch latest result ID
        fetch('/get-latest-result-id/' + questionPaperId)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.result) {
                    displayLatestResult(data.result, data.result_id);
                } else {
                    resultCard.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error loading result:', error);
                resultCard.style.display = 'none';
            });
    }

    // Display latest result
    function displayLatestResult(result, resultId) {
        const resultContent = document.getElementById('latest_result_content');
        const percentage = result.total_questions > 0 ? ((result.answer / result.total_questions) * 100).toFixed(2) : 0;

        const html = `
            <div class="row g-3">
                <div class="col-12 col-md-1">
                    &nbsp;
                </div>
                <div class="col-12 col-md-2">
                    <div class="text-center p-3 bg-light rounded">
                        <i class="fas fa-star text-primary fs-3 mb-2"></i>
                        <h5 class="mb-0 fw-bold">${result.score}</h5>
                        <small class="text-muted">Score</small>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="text-center p-3 bg-light rounded">
                        <i class="fas fa-percent text-info fs-3 mb-2"></i>
                        <h5 class="mb-0 fw-bold">${percentage}%</h5>
                        <small class="text-muted">Percentage</small>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="text-center p-3 bg-light rounded">
                        <i class="fas fa-check-circle text-success fs-3 mb-2"></i>
                        <h5 class="mb-0 fw-bold">${result.answer}</h5>
                        <small class="text-muted">Correct</small>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="text-center p-3 bg-light rounded">
                        <i class="fas fa-times-circle text-danger fs-3 mb-2"></i>
                        <h5 class="mb-0 fw-bold">${result.wrong}</h5>
                        <small class="text-muted">Wrong</small>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="text-center p-3 bg-light rounded">
                        <i class="fas fa-minus-circle text-warning fs-3 mb-2"></i>
                        <h5 class="mb-0 fw-bold">${result.skipped}</h5>
                        <small class="text-muted">Skipped</small>
                    </div>
                </div>
                 <div class="col-12 col-md-1">
                    &nbsp;
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="/test-result/${resultId}" class="btn btn-primary">
                    <i class="fas fa-chart-line me-2"></i>View Detailed Result
                </a>
            </div>
        `;

        resultContent.innerHTML = html;
    }

    // Start mock test
    window.startMockTest = function() {
        if (!selectedTestId) {
            alert('Please select a test first');
            return;
        }

        // Redirect to test taking page
        window.location.href = '/take-test/' + selectedTestId;
    };

    // Make functions globally available
    window.loadAllQuestionPapers = loadAllQuestionPapers;
    window.loadExamSections = loadExamSections;
    window.displayTestList = displayTestList;
    window.selectTest = selectTest;
    window.startMockTest = startMockTest;

})();
</script>
@endpush
