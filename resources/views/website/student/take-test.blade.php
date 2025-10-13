@extends('website.layout')

@section('title', 'Take Test - ' . $questionPaper->question_paper_name)

@push('styles')
<style>
    .question-card {
        border: 1px solid #ebebeb;
        min-height: 400px;
    }

    .option-card {
        border: 2px solid #e0e0e0;
        cursor: pointer;
        transition: all 0.3s;
    }

    .option-card:hover {
        border-color: #667eea;
        background-color: #f8f9fa;
    }

    .option-card.selected {
        border-color: #667eea;
        background-color: #e7f3ff;
    }

    .option-card input[type="radio"] {
        cursor: pointer;
    }

    .question-palette {
        border: 1px solid #ebebeb;
        max-height: 600px;
        overflow-y: auto;
    }

    .question-btn {
        width: 45px;
        height: 45px;
        border: 1px solid #ddd;
        background: white;
        margin: 5px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .question-btn:hover {
        transform: scale(1.1);
    }

    .question-btn.current {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    .question-btn.answered {
        background: #43e97b;
        color: white;
        border-color: #43e97b;
    }

    .question-btn.skipped {
        background: #f5576c;
        color: white;
        border-color: #f5576c;
    }

    .legend-item {
        display: inline-flex;
        align-items: center;
        margin-right: 20px;
    }

    .legend-box {
        width: 20px;
        height: 20px;
        border: 1px solid #ddd;
        margin-right: 8px;
    }
</style>
@endpush

@section('content')

<div class="container my-5">
    <!-- Test Header -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>{{ $questionPaper->question_paper_name }}
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <span class="badge bg-light text-dark fs-6">
                        <i class="far fa-clock me-1"></i>
                        <span id="timer">{{ str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT) }}:00</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column - Question Display -->
        <div class="col-lg-9">
            <div class="card question-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Question <span id="current-question-number">1</span> of {{ count($questions) }}</h6>
                        <span class="badge bg-info">Multiple Choice</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Question Content -->
                    <div id="question-container">
                        @foreach($questions as $index => $question)
                        <div class="question-content" data-question-id="{{ $question->id }}" style="display: {{ $index == 0 ? 'block' : 'none' }};">
                            <div class="mb-4">
                                <h5>{{ $question->question }}</h5>
                            </div>

                            <!-- Options -->
                            <div class="options-container">
                                <div class="option-card p-3 rounded mb-3" data-option="1">
                                    <label class="form-check-label w-100 cursor-pointer">
                                        <input type="radio" name="answer_{{ $question->id }}" value="1" class="form-check-input me-2">
                                        <strong>A.</strong> {{ $question->answer1 }}
                                    </label>
                                </div>

                                <div class="option-card p-3 rounded mb-3" data-option="2">
                                    <label class="form-check-label w-100 cursor-pointer">
                                        <input type="radio" name="answer_{{ $question->id }}" value="2" class="form-check-input me-2">
                                        <strong>B.</strong> {{ $question->answer2 }}
                                    </label>
                                </div>

                                <div class="option-card p-3 rounded mb-3" data-option="3">
                                    <label class="form-check-label w-100 cursor-pointer">
                                        <input type="radio" name="answer_{{ $question->id }}" value="3" class="form-check-input me-2">
                                        <strong>C.</strong> {{ $question->answer3 }}
                                    </label>
                                </div>

                                <div class="option-card p-3 rounded mb-3" data-option="4">
                                    <label class="form-check-label w-100 cursor-pointer">
                                        <input type="radio" name="answer_{{ $question->id }}" value="4" class="form-check-input me-2">
                                        <strong>D.</strong> {{ $question->answer4 }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary" id="prev-btn" disabled>
                            <i class="fas fa-arrow-left me-2"></i>Previous
                        </button>
                        <div>
                            <button type="button" class="btn btn-outline-warning me-2" id="skip-btn">
                                Skip
                            </button>
                            <button type="button" class="btn btn-primary" id="next-btn">
                                Next<i class="fas fa-arrow-right ms-2"></i>
                            </button>
                            <button type="button" class="btn btn-success" id="finish-btn" style="display: none;">
                                <i class="fas fa-check me-2"></i>Finish Test
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Question Palette -->
        <div class="col-lg-3">
            <div class="card question-palette">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Question Palette</h6>
                </div>
                <div class="card-body">
                    <!-- Legend -->
                    <div class="mb-3">
                        <div class="legend-item mb-2">
                            <div class="legend-box" style="background: #43e97b;"></div>
                            <small>Answered</small>
                        </div>
                        <div class="legend-item mb-2">
                            <div class="legend-box" style="background: white;"></div>
                            <small>Not Visited</small>
                        </div>
                        <div class="legend-item mb-2">
                            <div class="legend-box" style="background: #667eea;"></div>
                            <small>Current</small>
                        </div>
                    </div>

                    <hr>

                    <!-- Question Numbers -->
                    <div class="d-flex flex-wrap">
                        @foreach($questions as $index => $question)
                        <button type="button" class="question-btn rounded {{ $index == 0 ? 'current' : '' }}"
                                data-index="{{ $index }}"
                                data-question-id="{{ $question->id }}">
                            {{ $index + 1 }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="card mt-3">
                <div class="card-body text-center">
                    <button type="button" class="btn btn-success w-100" id="submit-test-btn">
                        <i class="fas fa-check-circle me-2"></i>Submit Test
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Data -->
<input type="hidden" id="question-paper-id" value="{{ $questionPaper->id }}">
<input type="hidden" id="total-questions" value="{{ count($questions) }}">
<input type="hidden" id="duration" value="{{ $questionPaper->duration ?? 60 }}">
<input type="hidden" id="remaining-minutes" value="{{ $remainingMinutes }}">

@endsection

@push('scripts')
<script>
(function() {
    'use strict';

    const questionPaperId = document.getElementById('question-paper-id').value;
    const totalQuestions = parseInt(document.getElementById('total-questions').value);
    const duration = parseInt(document.getElementById('duration').value);
    const remainingMinutes = parseInt(document.getElementById('remaining-minutes').value);

    let currentQuestionIndex = 0;
    let answers = {}; // Store answers {questionId: answerValue}
    let timerInterval;
    let testCompleted = false; // Flag to track test completion

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        initializeTimer();
        initializeEventListeners();
        updateNavigationButtons();
    });

    // Timer function
    function initializeTimer() {
        let timeLeft = remainingMinutes * 60; // Use remaining time from server in seconds
        const timerDisplay = document.getElementById('timer');

        timerInterval = setInterval(function() {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                autoSubmitTest();
            }
        }, 1000);
    }

    // Initialize event listeners
    function initializeEventListeners() {
        // Option selection
        document.querySelectorAll('.option-card').forEach(card => {
            card.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;

                // Update UI
                this.closest('.options-container').querySelectorAll('.option-card').forEach(c => {
                    c.classList.remove('selected');
                });
                this.classList.add('selected');

                // Save answer
                saveCurrentAnswer();
            });
        });

        // Previous button
        document.getElementById('prev-btn').addEventListener('click', previousQuestion);

        // Next button
        document.getElementById('next-btn').addEventListener('click', nextQuestion);

        // Skip button
        document.getElementById('skip-btn').addEventListener('click', skipQuestion);

        // Finish button
        document.getElementById('finish-btn').addEventListener('click', confirmFinishTest);

        // Submit test button
        document.getElementById('submit-test-btn').addEventListener('click', confirmFinishTest);

        // Question palette buttons
        document.querySelectorAll('.question-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                goToQuestion(index);
            });
        });
    }

    // Save current answer
    function saveCurrentAnswer() {
        const currentQuestion = document.querySelectorAll('.question-content')[currentQuestionIndex];
        const questionId = currentQuestion.getAttribute('data-question-id');
        const selectedOption = currentQuestion.querySelector('input[type="radio"]:checked');

        if (selectedOption) {
            answers[questionId] = selectedOption.value;

            // Update palette
            const paletteBtn = document.querySelector(`.question-btn[data-question-id="${questionId}"]`);
            paletteBtn.classList.remove('skipped');
            paletteBtn.classList.add('answered');

            // Save to server
            submitAnswerToServer(questionId, selectedOption.value);
        }
    }

    // Submit answer to server
    function submitAnswerToServer(questionId, answer) {
        fetch('{{ route("student.submit-answer") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                question_paper_id: questionPaperId,
                question_id: questionId,
                answer: answer
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Answer saved:', data);
        })
        .catch(error => {
            console.error('Error saving answer:', error);
        });
    }

    // Previous question
    function previousQuestion() {
        if (currentQuestionIndex > 0) {
            saveCurrentAnswer();
            goToQuestion(currentQuestionIndex - 1);
        }
    }

    // Next question
    function nextQuestion() {
        if (currentQuestionIndex < totalQuestions - 1) {
            saveCurrentAnswer();
            goToQuestion(currentQuestionIndex + 1);
        }
    }

    // Skip question
    function skipQuestion() {
        const currentQuestion = document.querySelectorAll('.question-content')[currentQuestionIndex];
        const questionId = currentQuestion.getAttribute('data-question-id');

        // Mark as skipped in palette
        const paletteBtn = document.querySelector(`.question-btn[data-question-id="${questionId}"]`);
        if (!paletteBtn.classList.contains('answered')) {
            paletteBtn.classList.add('skipped');
        }

        // Move to next question
        if (currentQuestionIndex < totalQuestions - 1) {
            goToQuestion(currentQuestionIndex + 1);
        }
    }

    // Go to specific question
    function goToQuestion(index) {
        // Hide all questions
        document.querySelectorAll('.question-content').forEach(q => {
            q.style.display = 'none';
        });

        // Show target question
        const targetQuestion = document.querySelectorAll('.question-content')[index];
        targetQuestion.style.display = 'block';

        // Update current question index
        currentQuestionIndex = index;

        // Update question number display
        document.getElementById('current-question-number').textContent = index + 1;

        // Update palette
        document.querySelectorAll('.question-btn').forEach(btn => {
            btn.classList.remove('current');
        });
        document.querySelectorAll('.question-btn')[index].classList.add('current');

        // Load saved answer if exists
        loadSavedAnswer(index);

        // Update navigation buttons
        updateNavigationButtons();
    }

    // Load saved answer
    function loadSavedAnswer(index) {
        const currentQuestion = document.querySelectorAll('.question-content')[index];
        const questionId = currentQuestion.getAttribute('data-question-id');

        if (answers[questionId]) {
            const radio = currentQuestion.querySelector(`input[value="${answers[questionId]}"]`);
            if (radio) {
                radio.checked = true;
                radio.closest('.option-card').classList.add('selected');
            }
        }
    }

    // Update navigation buttons
    function updateNavigationButtons() {
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const finishBtn = document.getElementById('finish-btn');

        // Previous button
        prevBtn.disabled = currentQuestionIndex === 0;

        // Next/Finish button
        if (currentQuestionIndex === totalQuestions - 1) {
            nextBtn.style.display = 'none';
            finishBtn.style.display = 'inline-block';
        } else {
            nextBtn.style.display = 'inline-block';
            finishBtn.style.display = 'none';
        }
    }

    // Confirm finish test
    function confirmFinishTest() {
        Swal.fire({
            title: 'Submit Test?',
            text: 'Are you sure you want to submit the test? You cannot change your answers after submission.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Submit!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                finishTest();
            }
        });
    }

    // Finish test
    function finishTest() {
        // Save current answer before finishing
        saveCurrentAnswer();

        // Clear timer
        clearInterval(timerInterval);

        // Mark test as completed to prevent beforeunload warning
        testCompleted = true;

        // Show loading
        Swal.fire({
            title: 'Submitting Test...',
            text: 'Please wait while we process your answers.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Submit test
        fetch('{{ route("student.finish-test") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                question_paper_id: questionPaperId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Your test has been submitted successfully.',
                    icon: 'success',
                    confirmButtonColor: '#28a745',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = data.redirect_url;
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'Error submitting test. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
                testCompleted = false; // Reset flag if error
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Error submitting test. Please try again.',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            testCompleted = false; // Reset flag if error
        });
    }

    // Auto submit when time is up
    function autoSubmitTest() {
        Swal.fire({
            title: 'Your time is over',
            text: 'Click OK to save test and view results. Not attempted questions will be marked as skipped.',
            icon: 'warning',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'OK',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            finishTest();
        });
    }

    // Prevent page refresh (only if test not completed)
    window.addEventListener('beforeunload', function(e) {
        if (!testCompleted) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

})();
</script>
@endpush
