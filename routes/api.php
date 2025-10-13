<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\TestAnswerKeyController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  //  return $request->user();
//});

Route::post('login', [UserController::class, 'login']);
Route::post('register_student', [UserController::class, 'register_student']);
Route::post('forgot_password', [UserController::class, 'forgot_password']);	
Route::get('get_districts', [GeneralController::class, 'get_districts']);
Route::get('get_splash_slides', [GeneralController::class, 'get_splash_slides']);
Route::post('send_otp', [OtpController::class, 'send_otp']);
Route::post('verify_otp', [OtpController::class, 'verify_otp']);
Route::post('check_user_device_status', [UserController::class, 'check_user_device_status']);
Route::get('get_centers', [GeneralController::class, 'get_centers']);

Route::get('test_answer_key', [TestAnswerKeyController::class, 'test_answer_key']);
    
Route::middleware('auth:api')->group( function () {
    
	//User controller apis
	
	Route::post('remove_user_account', [UserController::class, 'remove_user_account']);
	Route::post('get_user_profile', [UserController::class, 'get_user_profile']);
	Route::post('update_user_profile', [UserController::class, 'update_user_profile']);
	Route::post('change_user_password', [UserController::class, 'change_user_password']);
	
	
	//General Controller apis
	
	Route::post('get_home_banners', [GeneralController::class, 'get_home_banners']);
	Route::post('get_courses', [GeneralController::class, 'get_courses']);
	Route::post('get_courses_by_category_id', [GeneralController::class, 'get_courses_by_category_id']);
	Route::post('get_course_details', [GeneralController::class, 'get_course_details']);
	Route::post('get_my_courses', [GeneralController::class, 'get_my_courses']);
	Route::post('get_subjects', [GeneralController::class, 'get_subjects']);
	Route::post('get_topics', [GeneralController::class, 'get_topics']);
	Route::post('get_video_pdf_classes', [GeneralController::class, 'get_video_pdf_classes']);
	Route::post('get_video_class', [GeneralController::class, 'get_video_class']);
	Route::post('get_pdf_note', [GeneralController::class, 'get_pdf_note']);
	Route::post('get_referral_code_value', [GeneralController::class, 'get_referral_code_value']);
	Route::post('get_live_classes', [GeneralController::class, 'get_live_classes']);
	Route::post('set_video_completed_status', [GeneralController::class, 'set_video_completed_status']);
	Route::post('share_video_comment', [GeneralController::class, 'share_video_comment']);
	Route::post('share_recorded_video_comment', [GeneralController::class, 'share_recorded_video_comment']);
	Route::post('get_notifications', [GeneralController::class, 'get_notifications']);
	Route::post('purchase_course', [GeneralController::class, 'purchase_course']);
	Route::post('get_recorded_live_classes', [GeneralController::class, 'get_recorded_live_classes']);
	Route::post('get_easy_tips', [GeneralController::class, 'get_easy_tips']);
	Route::post('get_my_activities', [GeneralController::class, 'get_my_activities']);
	Route::post('set_app_usage', [GeneralController::class, 'set_app_usage']);
		
	//Exam Controller apis
	
	Route::post('get_question_papers', [ExamController::class, 'get_question_papers']);
	Route::post('get_questions', [ExamController::class, 'get_questions']);
	Route::post('get_pdf_questions', [ExamController::class, 'get_pdf_questions']);
	Route::post('set_test_results', [ExamController::class, 'set_test_results']);
	Route::post('get_test_results', [ExamController::class, 'get_test_results']);
	Route::post('get_improved_subjects', [ExamController::class, 'get_improved_subjects']);
	Route::post('get_test_wrong_skipped_answer', [ExamController::class, 'get_test_wrong_skipped_answer']);
	Route::post('get_subject_proficiency', [ExamController::class, 'get_subject_proficiency']);
	Route::post('get_rank_list', [ExamController::class, 'get_rank_list']);
	Route::post('get_free_question_papers', [ExamController::class, 'get_free_question_papers']);
	

});




