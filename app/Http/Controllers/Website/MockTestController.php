<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TestResult;
use Session;
use DB;

class MockTestController extends Controller
{
    public function takeTest($questionPaperId)
    {
        try {
            $user = Auth::guard('student')->user();

            // Get question paper details
            $questionPaper = DB::table('question_papers')
                            ->where('id', $questionPaperId)
                            ->where('status', 1)
                            ->first();

            if (!$questionPaper) {
                Session::flash('message', 'danger#Question paper not found.');
                return redirect()->route('student.course-mock-test');
            }

            // Get all questions for this question paper
            $questions = DB::table('questions')
                        ->where('question_paper_id', $questionPaperId)
                        ->orderBy('id', 'ASC')
                        ->get();

            if ($questions->isEmpty()) {
                Session::flash('message', 'danger#No questions found for this test.');
                return redirect()->route('student.course-mock-test');
            }

            // Check if student has already attempted this test
            $existingAttempt = DB::table('test_results')
                              ->where('student_id', $user->student_id)
                              ->where('question_paper_id', $questionPaperId)
                              ->first();

            // Initialize or retrieve answers from session
            if (!session()->has('test_answers_' . $questionPaperId)) {
                session(['test_answers_' . $questionPaperId => []]);
                session(['test_start_time_' . $questionPaperId => now()]);
            }

            // Calculate remaining time
            $startTime = session('test_start_time_' . $questionPaperId);
            $elapsedMinutes = $startTime ? $startTime->diffInMinutes(now()) : 0;
            $remainingMinutes = max(0, $questionPaper->duration - $elapsedMinutes);

            return view('website.student.take-test', compact('questionPaper', 'questions', 'existingAttempt', 'remainingMinutes'));

        } catch (\Exception $e) {
            \Log::error('Take test error: ' . $e->getMessage());
            Session::flash('message', 'danger#Error loading test. Please try again.');
            return redirect()->route('student.course-mock-test');
        }
    }

    public function submitAnswer(Request $request)
    {
        try {
            $questionPaperId = $request->question_paper_id;
            $questionId = $request->question_id;
            $answer = $request->answer; // Can be null for skipped

            // Get current answers from session
            $sessionKey = 'test_answers_' . $questionPaperId;
            $answers = session($sessionKey, []);

            // Update answer for this question
            $answers[$questionId] = $answer;

            // Save back to session
            session([$sessionKey => $answers]);

            return response()->json([
                'success' => true,
                'message' => 'Answer saved'
            ]);

        } catch (\Exception $e) {
            \Log::error('Submit answer error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error saving answer'
            ], 500);
        }
    }

    public function finishTest(Request $request)
    {
        try {
            $user = Auth::guard('student')->user();
            $questionPaperId = $request->question_paper_id;

            DB::beginTransaction();

            // Record test attendance
            DB::table('qpaper_attended')->insert([
                'student_id' => $user->student_id,
                'question_paper_id' => $questionPaperId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Delete previous test results for this student and question paper
            DB::table('test_all_results')
                ->where('student_id', $user->student_id)
                ->where('question_paper_id', $questionPaperId)
                ->delete();

            DB::table('test_results')
                ->where('student_id', $user->student_id)
                ->where('question_paper_id', $questionPaperId)
                ->delete();

            // Get answers from session
            $sessionKey = 'test_answers_' . $questionPaperId;
            $answers = session($sessionKey, []);

            // Get start time
            $startTime = session('test_start_time_' . $questionPaperId);
            $endTime = now();
            $totalTime = $startTime ? $startTime->diffInMinutes($endTime) : 0;

            // Get all questions with correct answers
            $questions = DB::table('questions')
                        ->where('question_paper_id', $questionPaperId)
                        ->get();

            $totalQuestions = $questions->count();
            $correctCount = 0;
            $wrongCount = 0;
            $skippedCount = 0;
            $score = 0;

            // Process each question and save to test_all_results
            foreach ($questions as $question) {
                $userAnswer = isset($answers[$question->id]) ? $answers[$question->id] : null;
                $isCorrect = false;
                $isWrong = false;
                $isSkipped = false;

                if ($userAnswer === null || $userAnswer === '') {
                    // Skipped
                    $isSkipped = true;
                    $skippedCount++;
                } else if ($userAnswer == $question->correct_answer) {
                    // Correct
                    $isCorrect = true;
                    $correctCount++;
                    $score += 1; // 1 mark per question
                } else {
                    // Wrong
                    $isWrong = true;
                    $wrongCount++;
                }

                // Save to test_all_results
                DB::table('test_all_results')->insert([
                    'qbank_subject_id' => $question->qbank_subject_id,
                    'question_paper_id' => $questionPaperId,
                    'student_id' => $user->student_id,
                    'question_id' => $question->id,
                    'correct_answer' => $question->correct_answer,
                    'answer' => $userAnswer,
                    'wrong_status' => $isWrong ? 1 : 0,
                    'skipped_status' => $isSkipped ? 1 : 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Save summary to test_results
            $testResultId = DB::table('test_results')->insertGetId([
                'subject_id' => $questions->first()->qbank_subject_id ?? null,
                'question_paper_id' => $questionPaperId,
                'student_id' => $user->student_id,
                'test_date' => now()->toDateString(),
                'total_questions' => $totalQuestions,
                'answer' => $correctCount,
                'wrong' => $wrongCount,
                'skipped' => $skippedCount,
                'marks' => '1', // Marks per question
                'negative' => 0,
                'score' => $score,
                'total_time' => $totalTime,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Clear session data
            session()->forget($sessionKey);
            session()->forget('test_start_time_' . $questionPaperId);

            DB::commit();

            return response()->json([
                'success' => true,
                'test_result_id' => $testResultId,
                'redirect_url' => route('student.test-result', $testResultId)
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Finish test error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error submitting test. Please try again.'
            ], 500);
        }
    }

    public function testResult($testResultId)
    {
        try {
            $user = Auth::guard('student')->user();

            // Get test result
            $testResult = DB::table('test_results')
                        ->where('id', $testResultId)
                        ->where('student_id', $user->student_id)
                        ->first();

            if (!$testResult) {
                Session::flash('message', 'danger#Test result not found.');
                return redirect()->route('student.course-mock-test');
            }

            // Get question paper details
            $questionPaper = DB::table('question_papers')
                            ->where('id', $testResult->question_paper_id)
                            ->first();

            // Get detailed results
            $detailedResults = DB::table('test_all_results')
                              ->join('questions', 'test_all_results.question_id', '=', 'questions.id')
                              ->select('test_all_results.*', 'questions.question', 'questions.answer1',
                                      'questions.answer2', 'questions.answer3', 'questions.answer4')
                              ->where('test_all_results.student_id', $user->student_id)
                              ->where('test_all_results.question_paper_id', $testResult->question_paper_id)
                              ->orderBy('questions.id', 'ASC')
                              ->get();

            // Calculate percentage
            $percentage = $testResult->total_questions > 0
                        ? round(($testResult->answer / $testResult->total_questions) * 100, 2)
                        : 0;

            return view('website.student.test-result', compact('testResult', 'questionPaper', 'detailedResults', 'percentage'));

        } catch (\Exception $e) {
            \Log::error('Test result error: ' . $e->getMessage());
            Session::flash('message', 'danger#Error loading test result. Please try again.');
            return redirect()->route('student.course-mock-test');
        }
    }

    public function getLatestResultId($questionPaperId)
    {
        try {
            $user = Auth::guard('student')->user();

            // Get latest test result for this student and question paper
            $testResult = DB::table('test_results')
                        ->where('student_id', $user->student_id)
                        ->where('question_paper_id', $questionPaperId)
                        ->orderBy('created_at', 'DESC')
                        ->first();

            if ($testResult) {
                return response()->json([
                    'success' => true,
                    'result_id' => $testResult->id,
                    'result' => $testResult
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No result found'
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Get latest result error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading result'
            ], 500);
        }
    }
}
