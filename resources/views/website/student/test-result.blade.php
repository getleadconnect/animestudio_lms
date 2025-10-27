@extends('website.layout')

@section('title', 'Test Result - ' . $questionPaper->question_paper_name)

@push('styles')
<style>
    .result-card {
        border: 1px solid #ebebeb;
    }

    .info-stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid #ebebeb;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .info-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }

    .info-stat-icon {
        width: 50px;
        height: 50px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.3s;
    }

    .info-stat-icon i {
        font-size: 1.8rem;
    }

    .info-stat-content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .info-stat-value {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0;
        transition: color 0.3s;
    }

    .info-stat-label {
        font-size: 0.85rem;
        color: #666;
        margin-top: 2px;
    }

    /* Color variations */
    .info-stat-card.card-score .info-stat-icon {
        background: #f0f0ff;
        color: #667eea;
    }

    .info-stat-card.card-percentage .info-stat-icon {
        background: #f0faff;
        color: #4facfe;
    }

    .info-stat-card.card-correct .info-stat-icon {
        background: #f0fff5;
        color: #43e97b;
    }

    .info-stat-card.card-wrong .info-stat-icon {
        background: #fff0f5;
        color: #f5576c;
    }

    .info-stat-card.card-skipped .info-stat-icon {
        background: #fff8e1;
        color: #ffc107;
    }

    .info-stat-card.card-total .info-stat-icon {
        background: #f5f5f5;
        color: #6c757d;
    }

    .info-stat-card.card-time .info-stat-icon {
        background: #f0f0f0;
        color: #495057;
    }

    .info-stat-card.card-date .info-stat-icon {
        background: #fafafa;
        color: #6c757d;
    }

    .correct-answer {
        background-color: #d4edda;
        border-left: 4px solid #28a745;
    }

    .wrong-answer {
        background-color: #f8d7da;
        border-left: 4px solid #dc3545;
    }

    .skipped-answer {
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
    }

    .progress-circle {
        width: 150px;
        height: 150px;
        margin: 0 auto;
    }

    .answer-option {
        padding: 10px;
        margin: 5px 0;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .answer-option.correct {
        background-color: #d4edda;
        border-color: #28a745;
    }

    .answer-option.wrong {
        background-color: #f8d7da;
        border-color: #dc3545;
    }

    .answer-option.user-selected {
        font-weight: bold;
    }

    .question-image-container {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border: 2px solid #e0e0e0;
    }

    .question-image-container img {
        border: 1px solid #dee2e6;
        transition: transform 0.3s ease;
    }

    .question-image-container img:hover {
        transform: scale(1.02);
        cursor: zoom-in;
    }
</style>
@endpush

@section('content')

<div class="container my-5">
    <!-- Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('student.course-mock-test') }}">Mock Tests</a></li>
                <li class="breadcrumb-item active">Test Result</li>
            </ol>
        </nav>
        <h4 class="fw-bold">
            <i class="fas fa-chart-bar text-primary me-2"></i>Test Result: {{ $questionPaper->question_paper_name }}
        </h4>
    </div>

    <!-- Result Summary -->
    <div class="card result-card mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-trophy me-2 text-primary"></i>Test Summary
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <!-- Score -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-stat-card card-score">
                        <div class="info-stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="info-stat-content">
                            <div class="info-stat-value">{{ $testResult->score }}</div>
                            <div class="info-stat-label">Score</div>
                        </div>
                    </div>
                </div>

                <!-- Percentage -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-stat-card card-percentage">
                        <div class="info-stat-icon">
                            <i class="fas fa-percent"></i>
                        </div>
                        <div class="info-stat-content">
                            <div class="info-stat-value">{{ $percentage }}%</div>
                            <div class="info-stat-label">Percentage</div>
                        </div>
                    </div>
                </div>

                <!-- Correct Answers -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-stat-card card-correct">
                        <div class="info-stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-stat-content">
                            <div class="info-stat-value">{{ $testResult->answer }}</div>
                            <div class="info-stat-label">Correct</div>
                        </div>
                    </div>
                </div>

                <!-- Wrong Answers -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-stat-card card-wrong">
                        <div class="info-stat-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="info-stat-content">
                            <div class="info-stat-value">{{ $testResult->wrong }}</div>
                            <div class="info-stat-label">Wrong</div>
                        </div>
                    </div>
                </div>

                <!-- Skipped -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-stat-card card-skipped">
                        <div class="info-stat-icon">
                            <i class="fas fa-minus-circle"></i>
                        </div>
                        <div class="info-stat-content">
                            <div class="info-stat-value">{{ $testResult->skipped }}</div>
                            <div class="info-stat-label">Skipped</div>
                        </div>
                    </div>
                </div>

                <!-- Total Questions -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-stat-card card-total">
                        <div class="info-stat-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="info-stat-content">
                            <div class="info-stat-value">{{ $testResult->total_questions }}</div>
                            <div class="info-stat-label">Total Questions</div>
                        </div>
                    </div>
                </div>

                <!-- Time Taken -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-stat-card card-time">
                        <div class="info-stat-icon">
                            <i class="far fa-clock"></i>
                        </div>
                        <div class="info-stat-content">
                            <div class="info-stat-value">{{ $testResult->total_time }}</div>
                            <div class="info-stat-label">Minutes</div>
                        </div>
                    </div>
                </div>

                <!-- Test Date -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-stat-card card-date">
                        <div class="info-stat-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="info-stat-content">
                            <div class="info-stat-value" style="font-size: 1rem;">{{ \Carbon\Carbon::parse($testResult->test_date)->format('d M Y') }}</div>
                            <div class="info-stat-label">Test Date</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Chart -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="text-center mb-3">Performance Breakdown</h6>
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ ($testResult->answer / $testResult->total_questions) * 100 }}%">
                                    {{ $testResult->answer }} Correct
                                </div>
                                <div class="progress-bar bg-danger" role="progressbar"
                                     style="width: {{ ($testResult->wrong / $testResult->total_questions) * 100 }}%">
                                    {{ $testResult->wrong }} Wrong
                                </div>
                                <div class="progress-bar bg-warning" role="progressbar"
                                     style="width: {{ ($testResult->skipped / $testResult->total_questions) * 100 }}%">
                                    {{ $testResult->skipped }} Skipped
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Results -->
    <div class="card result-card">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-list-alt me-2"></i>Detailed Question-wise Result
            </h5>
        </div>
        <div class="card-body">
            @foreach($detailedResults as $index => $result)
            <div class="mb-4 p-3 rounded
                @if($result->skipped_status == 1)
                    skipped-answer
                @elseif($result->answer == $result->correct_answer)
                    correct-answer
                @else
                    wrong-answer
                @endif">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h6 class="fw-bold">Question {{ $index + 1 }}</h6>
                    @if($result->skipped_status == 1)
                        <span class="badge bg-warning">Skipped</span>
                    @elseif($result->answer == $result->correct_answer)
                        <span class="badge bg-success">Correct</span>
                    @else
                        <span class="badge bg-danger">Wrong</span>
                    @endif
                </div>

                @if($result->question_type == 1)
                    <!-- Image Question -->
                    <div class="question-image-container text-center mb-3">
                        <img src="{{ config('constants.image_question') . $result->question }}"
                             alt="Question {{ $index + 1 }}"
                             class="img-fluid rounded shadow-sm"
                             style="max-width: 100%; max-height: 400px; object-fit: contain;">
                    </div>
                @else
                    <!-- Text Question -->
                    <p class="mb-3"><strong>{{ $result->question }}</strong></p>
                @endif

                <div class="options">
                    @for($i = 1; $i <= 4; $i++)
                        @php
                            $answerKey = 'answer' . $i;
                            $isCorrect = ($result->correct_answer == $i);
                            $isUserAnswer = ($result->answer == $i);
                        @endphp
                        <div class="answer-option {{ $isCorrect ? 'correct' : '' }} {{ $isUserAnswer ? 'user-selected wrong' : '' }}">
                            <strong>{{ chr(64 + $i) }}.</strong> {{ $result->$answerKey }}
                            @if($isCorrect)
                                <i class="fas fa-check-circle text-success float-end"></i>
                            @endif
                            @if($isUserAnswer && !$isCorrect)
                                <i class="fas fa-times-circle text-danger float-end"></i>
                                <small class="text-danger float-end me-2">(Your Answer)</small>
                            @endif
                            @if($isUserAnswer && $isCorrect)
                                <small class="text-success float-end me-2">(Your Answer)</small>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <a href="{{ route('student.course-mock-test') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Mock Tests
            </a>
            <a href="{{ route('student.my-results') }}" class="btn btn-info">
                <i class="fas fa-chart-line me-2"></i>View All Results
            </a>
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="fas fa-print me-2"></i>Print Result
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Add any additional JavaScript if needed
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Test result page loaded');
    });
</script>
@endpush
