<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\WebsiteController;
use App\Http\Controllers\Website\StudentAuthController;
use App\Http\Controllers\Website\MockTestController;

/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for the website section.
| These routes are for public website pages and student authentication.
|
*/

// Public Website Pages are defined in web.php to avoid conflicts

// Test route without auth
Route::get('/test-simple', function() {
    return 'Simple test works - no auth!';
});

// Test route with auth
Route::middleware('auth:student')->get('/test-course-content', function() {
    return 'Test page works with auth!';
});

// Student Authentication Routes
Route::controller(StudentAuthController::class)->group(function() {
    // Guest routes (not logged in students)
    Route::middleware('guest:student')->group(function() {
        Route::get('/student-login', 'showLoginForm')->name('student.login');
        Route::post('/student-login', 'login')->name('student.login.submit');
        Route::get('/student-register', 'showRegisterForm')->name('student.register');
        Route::post('/student-register', 'register')->name('student.register.submit');
        Route::get('/student-forgot-password', 'showForgotPasswordForm')->name('student.forgot-password');
        Route::post('/student-forgot-password', 'forgotPassword')->name('student.forgot-password.submit');
    });

    // Authenticated student routes
    Route::middleware('auth:student')->group(function() {
        Route::get('/student-dashboard', 'dashboard')->name('student.dashboard');
        Route::get('/student-profile', 'profile')->name('student.profile');
        Route::post('/student-profile', 'updateProfile')->name('student.profile.update');
        Route::get('/my-courses', 'myCourses')->name('student.my-courses');
        Route::get('/course-content/{id}', 'courseContent')->name('student.course-content');
        Route::get('/recorded-classes/{courseId}', 'recordedClassesPage')->name('student.recorded-classes');
        Route::get('/success-stories', 'successStories')->name('student.success-stories');
        Route::get('/course-mock-test', 'courseMockTest')->name('student.course-mock-test');
        Route::get('/get-chapters-by-subject/{subjectId}', 'getChaptersBySubject')->name('student.get-chapters');
        Route::get('/get-question-papers-by-course', 'getQuestionPapersByCourse')->name('student.get-question-papers');
        Route::get('/get-exam-sections-by-course', 'getExamSectionsByCourse')->name('student.get-exam-sections');
        Route::get('/get-pdf-files-by-chapter', 'getPdfFilesByChapter')->name('student.get-pdf-files');
        Route::get('/my-results', 'myResults')->name('student.my-results');
        Route::post('/student-logout', 'logout')->name('student.logout');

        // Video completion routes
        Route::post('/mark-video-completed', 'markVideoCompleted')->name('student.mark-video-completed');
        Route::get('/check-video-completed', 'checkVideoCompleted')->name('student.check-video-completed');

        // Video comment routes
        Route::post('/add-video-comment', 'addVideoComment')->name('student.add-video-comment');
        Route::get('/get-video-comments', 'getVideoComments')->name('student.get-video-comments');

        // Delete account routes
        Route::get('/delete-account-request', 'showDeleteAccountForm')->name('student.delete-account');
        Route::post('/delete-account-request', 'submitDeleteAccountRequest')->name('student.delete-account.submit');

        // Easy Tips routes
        Route::get('/easytips', 'easyTips')->name('student.easy-tips');
        Route::get('/easytips/filter', 'filterEasyTips')->name('student.easy-tips.filter');
    });
});

// Mock Test Routes
Route::controller(MockTestController::class)->middleware('auth:student')->group(function() {
    Route::get('/take-test/{questionPaperId}', 'takeTest')->name('student.take-test');
    Route::post('/submit-answer', 'submitAnswer')->name('student.submit-answer');
    Route::post('/finish-test', 'finishTest')->name('student.finish-test');
    Route::get('/test-result/{testResultId}', 'testResult')->name('student.test-result');
    Route::get('/get-latest-result-id/{questionPaperId}', 'getLatestResultId')->name('student.get-latest-result-id');
});