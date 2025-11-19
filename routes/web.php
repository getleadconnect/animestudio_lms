<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralFileController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BannerImageController;
use App\Http\Controllers\Admin\SplashSlideController;
use App\Http\Controllers\Admin\CenterController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\RecordedLiveClassController;
use App\Http\Controllers\Admin\EasyTipsController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentActivityController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\QbankSubjectController;
use App\Http\Controllers\Admin\QbankQuestionController;
use App\Http\Controllers\Admin\ModelQpaperController;
use App\Http\Controllers\Admin\PrepareQuestionController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\PdfQuestionController;
use App\Http\Controllers\Admin\ExamTabHeadingController;
use App\Http\Controllers\Admin\LiveClassController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\TestResultController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PrivacyTermsController;
use App\Http\Controllers\Admin\SuccessStoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminUserController;
// use App\Http\Controllers\Admin\TestAnswerKeyController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ContactUsMessageController;
use App\Http\Controllers\Admin\DeleteAccountRequestController;
use App\Http\Controllers\Website\WebsiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Website Routes
Route::controller(WebsiteController::class)->group(function() {
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/courses', 'courses')->name('courses');
    Route::get('/course-details/{id}', 'courseDetails')->name('course-details');
    Route::get('/purchase-course/{id}', 'purchaseCourse')->name('purchase-course');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/get-chapters-by-subject', 'getChaptersBySubject')->name('website.get-chapters-by-subject');
});

// Video Content Routes (Public - No authentication required)
Route::controller(App\Http\Controllers\Website\VideoContentController::class)->group(function() {
    Route::get('/video-course-content/{id}', 'courseContent')->name('video-course-content');
    Route::get('/get-chapters-by-course', 'getChaptersByCourse')->name('website.get-chapters');
    Route::get('/get-videos-by-chapter', 'getVideosByChapter')->name('website.get-videos');
    Route::get('/play-video/{id}', 'playVideo')->name('play-video');
    Route::get('/test-videos', 'testVideos')->name('test-videos');
});

Route::controller(GeneralFileController::class)->group(function() {
    Route::get('/privacy-policy', 'index')->name('privacy-policy');
	Route::get('/terms', 'terms')->name('terms');
	Route::get('/delete-account', 'delete_account')->name('delete-account');
	Route::get('/contact-us', 'contact_us')->name('contact-us');
    Route::post('/save-delete-account-request', 'store')->name('save-delete-account-request');
	Route::post('/save-contact-us-message', 'save_contact_us')->name('save-contact-us-message');
});

Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'index')->name('admin.login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/change-password', 'change_password')->name('change-password');
    Route::post('/logout', 'logout')->name('admin.logout');
});

Route::controller(DashboardController::class)->group(function() {
    Route::get('/dashboard', 'index')->name('dashboard');
	Route::get('/get_activity/{id}', 'get_my_activities');
});

Route::controller(BannerImageController::class)->group(function() {
    Route::get('/banners', 'index')->name('banners');
	Route::post('/save-banner-image', 'store')->name('save-banner-image');
	Route::get('/view-banner-images', 'view_data')->name('view-banner-images');
	Route::get('/edit-banner-image/{id}', 'edit')->name('edit-banner-image');
	Route::post('/update-banner-image', 'update_banner_image')->name('update-banner-images');
	Route::get('/delete-banner-image/{id}', 'destroy')->name('delete-banner-image');
	Route::get('/act-deact-banner-image/{op}/{id}', 'activate_deactivate')->name('act-deact-banner-image');
});

Route::controller(SplashSlideController::class)->group(function() {
    Route::get('/splash-slides', 'index')->name('splash-slide');
	Route::post('/save-splash-slide', 'store')->name('save-splash-slide');
	Route::get('/view-splash-slides', 'view_data')->name('view-splash-slides');
	Route::get('/edit-splash-slide/{id}', 'edit')->name('edit-splash-slide');
	Route::post('/update-splash-slide', 'update_splash_slide')->name('update-splash-slide');
	Route::get('/delete-splash-slide/{id}', 'destroy')->name('delete-splash-slide');
	Route::get('/act-deact-splash-slide/{op}/{id}', 'activate_deactivate')->name('act-deact-splash-slide');
});

Route::controller(CenterController::class)->group(function() {
    Route::get('/centers', 'index')->name('center');
	Route::get('/view-centers', 'view_data')->name('view-centers');
	Route::get('/edit-center/{id}', 'edit')->name('edit-center');
	Route::post('/update-center', 'update_center')->name('update-center');
	Route::get('/act-deact-center/{op}/{id}', 'activate_deactivate')->name('act-deact-center');
	
});

Route::controller(CourseCategoryController::class)->group(function() {
    Route::get('/course_category', 'index')->name('course_category');
	Route::get('/view-course-category', 'view_data')->name('view-course-category');
	Route::post('/save-course-category', 'store')->name('save-course-category');
	Route::get('/edit-course-category/{id}', 'edit')->name('edit-course-category');
	Route::post('/update-course-category', 'update_course_category')->name('update-course-category');
	Route::get('/delete-course-category/{id}', 'destroy')->name('delete-course-category');
	Route::get('/act-deact-course-category/{op}/{id}', 'activate_deactivate')->name('act-deact-course-category');
	
});

Route::controller(CourseController::class)->group(function() {
    Route::get('/admin/courses', 'index')->name('admin.courses');
	Route::get('/add-course', 'add_course')->name('add-course');
	Route::post('/save-course', 'store')->name('save-course');
	Route::get('/view-courses', 'view_data')->name('view-courses');
	Route::get('/edit-course/{id}', 'edit')->name('edit-course');
	Route::post('/update-course', 'update_course')->name('update-course');
	Route::get('/delete-course/{id}', 'destroy')->name('delete-course');
	Route::get('/act-deact-course/{op}/{id}', 'activate_deactivate')->name('act-deact-course');

	//Route::get('/latest-batches', 'latest_batches')->name('latest-batches');
});


Route::controller(RecordedLiveClassController::class)->group(function() {
    Route::get('/recorded-live-classes', 'index')->name('recorded-live-classes');
	Route::get('/add-recorded-live-class', 'add_recorded_live_class')->name('add-recorded-live-class');
	Route::post('/save-recorded-live-class', 'store')->name('save-recorded-live-class');
	Route::get('/view-recorded-live-classes', 'view_data')->name('view-recorded-live-classes');
	Route::get('/edit-recorded-live-class/{id}', 'edit')->name('edit-recorded-live-class');
	Route::post('/update-recorded-live-class', 'update_recorded_live_class')->name('update-recorded-live-class');
	Route::get('/delete-recorded-live-class/{id}', 'destroy')->name('delete-recorded-live-class');
	Route::get('/act-deact-recorded-live-class/{op}/{id}', 'activate_deactivate')->name('act-deact-recorded-live-class');
	
	Route::get('/recorded-video-comments', 'recorded_video_comments')->name('recorded-video-comments');
	Route::get('/recorded-video-comment-data', 'recorded_video_comment_data')->name('recorded-video-comment-data');
	Route::get('/delete-recorded-video-comment/{id}', 'destroy_comment')->name('delete-recorded-video-comment');
});


Route::controller(EasyTipsController::class)->group(function() {
    Route::get('/easy-tips', 'index')->name('easy-tips');
	Route::post('/save-easy-tips', 'store')->name('save-easy-tips');
	Route::get('/view-easy-tips', 'view_data')->name('view-easy-tips');
	Route::get('/edit-easy-tips/{id}', 'edit')->name('edit-edit-easy-tips');
	Route::post('/update-easy-tips', 'update_easy_tips')->name('update-easy-tips');
	Route::get('/delete-easy-tips/{id}', 'destroy')->name('delete-easy-tips');
	Route::get('/act-deact-easy-tips/{op}/{id}', 'activate_deactivate')->name('act-deact-easy-tips');
	
	//Route::get('/add-course', 'add_course')->name('add-course');
	//Route::get('/edit-course', 'edit')->name('edit-course');
	//Route::get('/latest-batches', 'latest_batches')->name('latest-batches');
});

Route::controller(SubjectController::class)->group(function() {
    Route::get('/subjects', 'index')->name('subjects');
	Route::post('/save-subject', 'store')->name('save-subject');
	Route::get('/view-subjects', 'view_data')->name('view-subjects');
	Route::get('/edit-subject/{id}', 'edit')->name('edit-subject');
	Route::post('/update-subject', 'update_subject')->name('update-subject');
	Route::get('/delete-subject/{id}', 'destroy')->name('delete-subject');
	Route::get('/act-deact-subject/{op}/{id}', 'activate_deactivate')->name('act-deact-subject');
	

});

Route::controller(ChapterController::class)->group(function() {
    Route::get('/chapters', 'index')->name('chapters');
	Route::get('/get-subjects/{id}', 'getSubjectsByCourseId')->name('get-subjects');
	Route::post('/save-chapter', 'store')->name('save-chapter');
	Route::get('/view-chapters', 'view_data')->name('view-chapters');
	Route::get('/edit-chapter/{id}', 'edit')->name('edit-chapter');
	Route::post('/update-chapter', 'update_chapter')->name('update-chapter');
	Route::get('/delete-chapter/{id}', 'destroy')->name('delete-chapter');
	Route::get('/act-deact-chapter/{op}/{id}', 'activate_deactivate')->name('act-deact-chapter');
});

Route::controller(StudentController::class)->group(function() {
    Route::get('/students', 'index')->name('students');
	Route::post('/save-student', 'store')->name('save-student');
	Route::get('/view-students', 'view_data')->name('view-students');
	Route::get('/edit-student/{id}', 'edit')->name('edit-student');
	Route::post('/update-student', 'update_student')->name('update-student');
	Route::get('/delete-student/{id}', 'destroy')->name('delete-student');
	Route::get('/act-deact-student/{op}/{id}', 'activate_deactivate')->name('act-deact-student');
	Route::get('/get-course-fee/{id}', 'getCourseFee')->name('get-course-fee');
	
	Route::get('/activity', 'activity')->name('activity');
	
});

Route::controller(StudentActivityController::class)->group(function() {
    Route::get('/activity', 'index')->name('activity');
	Route::get('/view-activity', 'view_data')->name('view-activity');
});

Route::controller(StaffController::class)->group(function() {
    Route::get('/staffs', 'index')->name('staffs');
	Route::post('/save-staff', 'store')->name('save-staff');
	Route::get('/view-staffs', 'view_data')->name('view-staffs');
	Route::get('/edit-staff/{id}', 'edit')->name('edit-staff');
	Route::post('/update-staff', 'update_staff')->name('update-staff');
	Route::get('/delete-staff/{id}', 'destroy')->name('delete-staff');
	Route::get('/act-deact-staff/{op}/{id}', 'activate_deactivate')->name('act-deact-staff');
	
});

Route::controller(SubscriptionController::class)->group(function() {
    Route::get('/subscriptions', 'index')->name('subscriptions');
	Route::get('/view-subscriptions', 'view_data')->name('view-subscriptions');
	Route::get('/delete-subscription/{id}', 'destroy')->name('delete-subscription');
	
	Route::get('/edit-subscription-period/{id}', 'edit_subscription_period')->name('edit-subscription-period');
	Route::post('/update-subscription-period', 'update_subscription_period')->name('update-subscription-period');
	
});

Route::controller(QbankSubjectController::class)->group(function() {
	Route::get('/question-bank-subjects', 'index')->name('question-bank-subjects');
	
	Route::post('/save-qbank-subject', 'store')->name('save-qbank-subject');
	Route::get('/view-qbank-subjects', 'view_data')->name('view-qbank-subjects');
	Route::get('/edit-qbank-subject/{id}', 'edit')->name('edit-qbank-subject');
	Route::post('/update-qbank-subject', 'update_qbank_subject')->name('update-qbank-subject');
	Route::get('/delete-qbank-subject/{id}', 'destroy')->name('delete-qbank-subject');
	Route::get('/act-deact-qbank-subject/{op}/{id}', 'activate_deactivate')->name('act-deact-qbank-subject');
});

Route::controller(QbankQuestionController::class)->group(function() {
    Route::get('/questions', 'index')->name('questions');
	Route::get('/add-qbank-question', 'add_qbank_question')->name('add-qbank-question');
	Route::post('/save-qbank-question', 'store')->name('save-qbank-question');
	Route::get('/view-qbank-questions', 'view_data')->name('view-qbank-questions');
	Route::get('/edit-qbank-question/{id}', 'edit')->name('edit-qbank-question');
	Route::post('/update-qbank-question', 'update_qbank_question')->name('update-qbank-question');
	Route::get('/delete-qbank-question/{id}', 'destroy')->name('delete-qbank-question');
	
	Route::get('/import-qbank-questions', 'import_qbank_questions')->name('import-qbank-questions');
	Route::post('qbank-question-import', 'import')->name('qbank-question-import');
	
	
	
});

Route::controller(ModelQpaperController::class)->group(function() {
    Route::get('/question-papers', 'index')->name('question-papers');
	Route::post('/save-question-paper', 'store')->name('save-question-paper');
	Route::get('/view-question-papers', 'view_data')->name('view-question-papers');
	Route::get('/edit-question-paper/{id}', 'edit')->name('edit-question-paper');
	Route::post('/update-question-paper', 'update_question_paper')->name('update-question-paper');
	Route::get('/delete-question-paper/{id}', 'destroy')->name('delete-question-paper');
	Route::get('/act-deact-question-paper/{op}/{id}', 'activate_deactivate')->name('act-deact-question-paper');
	Route::get('get-tab-headings-by-course-id/{id}','get_tab_headings_by_course_id')->name('get-tab-headings-by-course-id');

});
Route::controller(PrepareQuestionController::class)->group(function() {
	Route::get('/prepare-questions', 'index')->name('prepare-questions');
	Route::get('/get-qbank-questions', 'view_question_data')->name('get-qbank-questions');
	Route::get('/get-subjects-by-course_id/{id}', 'get_subjects_by_course_id')->name('get-subjects-by-course_id');
	//Route::get('/get-question-papers-by-subject-id/{id}', 'get_question_papers_by_subject_id')->name('get-question-papers-by-subject-id');
	Route::get('/get-question-papers-by-course-id/{id}', 'get_question_papers_by_course_id')->name('get-question-papers-by-course-id');
	
	Route::get('/get-free-question-papers', 'get_free_question_papers')->name('get-free-question-papers');
	
	Route::get('/get-total-questions/{id}', 'get_total_questions')->name('get-total-questions');
	Route::get('/check-question-already-added/{qpid}/{qid}', 'check_question_already_added')->name('check-question-already-added');
	Route::post('/save-qpaper-questions', 'save_qpaper_questions')->name('save-qpaper-questions');
	
	Route::get('/import-qpaper-questions', 'import_qpaper_questions')->name('import-qpaper-questions');
	Route::post('/qpaper-questions-import', 'import')->name('qpaper-questions-import');
		
	Route::get('/test-results', 'test_results')->name('test-results');
	Route::get('/rank-list', 'rank_list')->name('rank_list');
});


Route::controller(QuestionController::class)->group(function() {
	Route::get('/view-questions', 'index')->name('view-questions');
	Route::get('/view-qpaper-questions', 'view_data')->name('view-qpaper-questions');
	Route::get('/edit-question/{id}', 'edit')->name('edit-question');
	Route::post('/update-question', 'update_question')->name('update-question');
	Route::get('/delete-question/{id}', 'destroy')->name('delete-question');
	Route::get('/get-qpapers-by-course-id/{id}', 'get_qpapers_by_course_id')->name('get-qpapers-by-course-id');
	
	Route::get('/add-question', 'add_question')->name('add-question');
	Route::get('/add-question1', 'add_question1')->name('add-question1');
	Route::post('/save-question', 'save_question')->name('save-question');
});


Route::controller(PdfQuestionController::class)->group(function() {
	Route::get('/pdf-questions', 'index')->name('pdf-questions');
	Route::post('/save-pdf-question', 'store')->name('save-pdf-question');
	Route::get('/view-pdf-questions', 'view_data')->name('view-pdf-questions');
	Route::get('/edit-pdf-question/{id}', 'edit')->name('edit-pdf-question');
	Route::post('/update-pdf-question', 'update_pdf_question')->name('update-pdf-question');
	Route::get('/delete-pdf-question/{id}', 'destroy')->name('delete-pdf-question');
	Route::get('/act-deact-pdf-question/{op}/{id}', 'activate_deactivate')->name('act-deact-pdf-question');
});

Route::controller(ExamTabHeadingController::class)->group(function() {
    Route::get('/tab-headings', 'index')->name('tab-headings');
	Route::post('/save-tab-heading', 'store')->name('save-tab-heading');
	Route::get('/view-tab-headings', 'view_data')->name('view-tab-headings');
	Route::get('/edit-tab-heading/{id}', 'edit')->name('edit-tab-heading');
	Route::post('/update-tab-heading', 'update_tab_heading')->name('update-tab-heading');
	Route::get('/delete-tab-heading/{id}', 'destroy')->name('delete-tab-heading');
	Route::get('/act-deact-tab-heading/{op}/{id}', 'activate_deactivate')->name('act-deact-tab-heading');
});

Route::controller(LiveClassController::class)->group(function() {
    Route::get('/live-classes', 'index')->name('live-classes');
	Route::post('/save-live-class', 'store')->name('save-live-class');
	Route::get('/view-live-classes', 'view_data')->name('view-live-classes');
	Route::get('/edit-live-class/{id}', 'edit')->name('edit-live-class');
	Route::post('/update-live-class', 'update_live_class')->name('update-live-class');
	Route::get('/delete-live-class/{id}', 'destroy')->name('delete-live-class');
	Route::get('/act-deact-live-class/{op}/{id}', 'activate_deactivate')->name('act-deact-live-class');
	Route::get('/get-live-class-subjects/{id}', 'getLiveClassSubjectsByCourseId')->name('get-live-class-subjects');
});

Route::controller(VideoController::class)->group(function() {
    Route::get('/videos', 'index')->name('video-classes');
	Route::get('/add-videos', 'add_videos')->name('add-videos');
	Route::post('/save-video', 'store')->name('save-video');
	Route::get('/view-videos', 'view_data')->name('view-videos');
	Route::get('/edit-video/{id}', 'edit')->name('edit-video');
	Route::post('/update-video', 'update_video')->name('update-video');
	Route::get('/delete-video/{id}', 'destroy')->name('delete-video');
	Route::get('/act-deact-video/{op}/{id}', 'activate_deactivate')->name('act-deact-videos');
	Route::get('/get-subjects-for-videos/{id}', 'getSubjectsForVideo')->name('get-subjects-for-videos');
	Route::get('/get-chapters-for-videos/{id}', 'getChaptersForVideo')->name('get-chapters-for-videos');

	Route::get('/view-comments', 'view_comments')->name('view-comments');
	Route::get('/view-comment-data', 'view_comment_data')->name('view-comment-data');
	Route::get('/delete-video-comment/{id}', 'destroy_comment')->name('delete-video-comment');

	Route::post('/video-chunk-upload', 'videoChunkUpload')->name('chunk.upload');  //Dropzone Upload
	
});

Route::controller(PdfController::class)->group(function() {
    Route::get('/pdf-files', 'index')->name('pdf-files');
	Route::get('/add-pdf-file', 'add_pdf_file')->name('add-pdf-file');
	Route::post('/save-pdf-file', 'store')->name('save-pdf-file');
	Route::get('/view-pdf-files', 'view_data')->name('view-pdf-files');
	Route::get('/edit-pdf-file/{id}', 'edit')->name('edit-pdf-file');
	Route::post('/update-pdf-file', 'update_pdf_file')->name('update-pdf-file');
	Route::get('/delete-pdf-file/{id}', 'destroy')->name('delete-pdf-file');
	Route::get('/act-deact-pdf-file/{op}/{id}', 'activate_deactivate')->name('act-deact-pdf-file');
	Route::get('/get-subjects-for-pdf-file/{id}', 'getSubjectsForPdfFile')->name('get-subjects-for-pdf-file');
	Route::get('/get-chapters-for-pdf-file/{id}', 'getChaptersForPdfFile')->name('get-chapters-for-pdf-file');
});

Route::controller(TestResultController::class)->group(function() {
    Route::get('/test-results', 'index')->name('test-result');
	Route::get('/rank-list', 'rank_list')->name('rank-list');
	Route::get('/view-test-results', 'view_data')->name('view-test-results');
	Route::get('/get-qpapers-for-test-results/{id}', 'getQuestionPapersForTestResult')->name('get-qpapers-for-test-results'); 
	Route::get('/delete-test-result/{id}', 'destroy')->name('delete-test-result');
	Route::get('/view-rank-list', 'view_rank_list')->name('view-rank-list');
	
	Route::get('/export-rank-list/{id}', 'export_rank_list')->name('export-rank-list');
	 
});

Route::controller(NotificationController::class)->group(function() {
    Route::get('/notifications', 'index')->name('notifications');
	Route::post('/save-notification', 'store')->name('save-notification');
	Route::get('/view-notifications', 'view_data')->name('view-notifications');
	Route::get('/edit-notification/{id}', 'edit')->name('edit-notification');
	Route::post('/update-notification', 'update_notification')->name('update-notification');
	Route::get('/delete-notification/{id}', 'destroy')->name('delete-notification');
	Route::get('/act-deact-notification/{op}/{id}', 'activate_deactivate')->name('act-deact-notification');
	Route::get('/send-notification', 'sendNotification');
	Route::get('/send-push-notification/{id}', 'sendPushNotification')->name('send-push-notification');
});

Route::controller(PrivacyTermsController::class)->group(function() {
    Route::get('/policy', 'index')->name('policy');
	
	Route::get('/view-policy', 'view_data')->name('view-policy');
	Route::get('/edit-policy/{id}', 'edit')->name('edit-privacy');
	Route::post('/update-policy', 'update_policy')->name('update-policy');
	Route::get('/act-deact-policy/{op}/{id}', 'activate_deactivate')->name('act-deact-policy');
	Route::get('/get-policy-data/{id}', 'get_policy_data')->name('get-policy-data');

});

Route::controller(SuccessStoryController::class)->group(function() {
    Route::get('/success-story', 'index')->name('success-story');
	Route::post('/save-success-story', 'store')->name('save-success-story');
	Route::get('/view-success-story', 'view_data')->name('view-success-story');
	Route::get('/edit-success-story/{id}', 'edit')->name('edit-success-story');
	Route::post('/update-success-story', 'update_success_story')->name('update-success-story');
	Route::get('/delete-success-story/{id}', 'destroy')->name('delete-success-story');
	Route::get('/act-deact-success-story/{op}/{id}', 'activate_deactivate')->name('act-deact-success-story');
});

Route::controller(UserController::class)->group(function() {
    Route::get('/users', 'index')->name('users');
	Route::get('/view-users', 'view_data')->name('view-users');
	Route::get('/act-deact-user/{op}/{id}', 'activate_deactivate')->name('act-deact-user');
});

Route::controller(AdminUserController::class)->group(function() {
    Route::get('/admin-users', 'index')->name('admin-users');
	Route::get('/view-admin-users', 'view_data')->name('view-admin-users');
	
	Route::post('/save-admin-user', 'store')->name('save-admin-user');
	Route::get('/edit-admin-user/{id}', 'edit')->name('edit-admin-user');
	Route::post('/update-admin-user', 'update_admin_user')->name('update-admin-user');
	Route::get('/delete-admin-user/{id}', 'destroy')->name('delete-admin-user');
	Route::get('/act-deact-admin-user/{op}/{id}', 'activate_deactivate')->name('act-deact-admin-user');
});

// Route::controller(TestAnswerKeyController::class)->group(function() {
//     Route::get('/test_answer_key', 'test_answer_key')->name('test-answer-key');
// });

Route::controller(ReportController::class)->group(function() {
    Route::get('/student-reports', 'index')->name('student-reports');
	Route::get('/view-student-reports', 'view_data')->name('view-student-reports');
	Route::get('/export-student-list/{id}/{did}', 'export_student_list')->name('export-student-list');
	
	Route::get('/subscription-reports', 'subscription_report')->name('subscription-reports');
	Route::get('/view-subscription-reports', 'view_subscription_data')->name('view-subscription-reports');
	Route::get('/export-subscription-list/{id}/{did}', 'export_subscription_list')->name('export-subscription-list');
	Route::get('/get-course-by-center-id/{id}', 'get_course_by_center_id')->name('get-course-by-center-id');
		
});

Route::controller(ContactUsMessageController::class)->group(function() {
    Route::get('/contact-us', 'index')->name('contact-us');
	Route::get('/view-contact-us-messages', 'view_data')->name('view-contact-us-messages');
	Route::get('/delete-contact-us-message/{id}', 'destroy')->name('delete-contact-us-message');
});

Route::controller(DeleteAccountRequestController::class)->group(function() {
    Route::get('/account-delete-requests', 'index')->name('account-delete-requests');
	Route::get('/view-account-delete-requests', 'view_data')->name('view-account-delete-requests');
	Route::get('/delete-account-delete-request/{id}', 'destroy')->name('delete-account-delete-request');
});

