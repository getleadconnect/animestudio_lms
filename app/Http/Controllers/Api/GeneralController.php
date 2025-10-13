<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use App\Models\Center;
use App\Models\District;
use App\Models\BannerImage;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseType;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\SuccessStory;
use App\Models\Payment;
use App\Models\EasyTips;


use App\Models\SplashSlide;
use App\Models\Staff;

use App\Models\Question;
use App\Models\QuestionPaper;
use App\Models\TestResult;
use App\Models\TestAllResult;
use App\Models\QpaperAttended;

use App\Models\Chapter;
use App\Models\Video;
use App\Models\PdfFile;
use App\Models\LiveClass;

use App\Models\VideoCompletedStatus;
use App\Models\VideoComment;
use App\Models\RecordedLiveClass;
use App\Models\RecordedVideoComment;

use App\Models\Notification;
use App\Models\User;

use App\Models\AppUsage;

use Carbon\Carbon;
use Log;

class GeneralController extends Controller
{
	
	/**
	 * Function get_home_banners
	 * Function to list of home page banners
	 * Method:GET
	 * @param: mone
	 * return [ districts]
	 */

   public function get_home_banners(Request $request) 
	{
		$stid=$request->student_id;
		$pcid=Student::whereId($stid)->pluck('learn_category_id')->first();
				
		$bnrs1 = BannerImage::where('course_category_id',$pcid)->where('status',1)->orderBy('id','ASC')->get()
		->map(function($q)
		{
			$q['banner_image']=config('constants.banner_image').$q->banner_image;
			return $q;
		});
		
		$bnrs2 = BannerImage::where('banner_type',2)->where('status',1)->orderBy('id','ASC')->get()
		->map(function($q)
		{
			$q['banner_image']=config('constants.banner_image').$q->banner_image;
			return $q;
		});
		
		$bnrs1=$bnrs1->merge($bnrs2);
		
	    if(!$bnrs1->isEmpty()) 
		{
			$response = [
				'status'=>TRUE,
				'banner'=>$bnrs1,
				'type'=>'1-courses, 2-others',
				'message'=>'banners found',
			];
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
		}
		
		return response($response, 200);
    }	
	
	
	 /**
	 * Function get_splash_slides
	 * Function to list of splash slides
	 * Method:GET
	 * @param: mone
	 * return [ districts]
	 */

   public function get_splash_slides() 
	{
		$sslide = SplashSlide::where('status',1)->orderBy('id','ASC')->get()
		->map(function($q)
		{
			$q['slide_image']=config('constants.splash_slides').$q->slide_image;
			return $q;
		});
		 
		 
	    if(!$sslide->isEmpty()) 
		{
			$response = [
				'status'=>TRUE,
				'slides'=>$sslide,
				'message'=>'Slides found',
			];
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
		}
		
		return response($response, 200);
    }	
	
   /**
	 * Function get_centers
	 * Function to list centers
	 * Method:GET
	 * @param: mone
	 * return [ centers]
	 */

   public function get_centers() 
	{
		$center = Center::orderBy('id','ASC')->get();
		 
	    if(!$center->isEmpty()) 
		{
			$response = [
				'status'=>TRUE,
				'center'=>$center,
			];
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
		}
		
		return response($response, 200);
    }	


   /**
	 * Function get_districts
	 * Function to list distrcts and prefer to learn category
	 * Method:GET
	 * @param: mone
	 * return [ districts]
	 */

   public function get_districts() 
	{
		$dist = District::orderBy('id','ASC')->get();
		$cat=CourseCategory::where('status',1)->where('id','>',1)->orderBy('id','ASC')->get();
	    if(!$dist->isEmpty()) 
		{
			$response = [
				'status'=>TRUE,
				'districts'=>$dist,
				'prefer_to_learn'=>$cat,
				'message'=>'Data found.',
			];
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
		}
		
		return response($response, 200);
    }	

   /**
	 * Function get_courses
	 * Function to list of available courses
	 * Method:POST
	 * @param: student_id (int)
	 * return [ districts]
	 */
		 

public function get_courses(Request $request) 
	{
		$stid=$request->student_id;
		
		$data['course_type']=[];
		$data['category']=[];
		$data['my_courses']=[];
		$data['success_story']=[];

		try
		{
			//course type wise courses --------------
			
			$ctypes=CourseType::orderBy('id','ASC')->get();
			
			foreach($ctypes as $r)
			{
				$data['course_type'][Str::slug(Str::lower($r->course_type))]=Course::where('course_type_id',$r->id)
				->where('status',1)
				->get()->map(function($q)
				{
					$q['course_wide_icon']=config('constants.course_icon').$q->course_wide_icon;
					$q['course_square_icon']=config('constants.course_icon').$q->course_square_icon;
					$q['video_file']=($q->video_file!="")?config('constants.course_exp_video').$q->video_file:null;
					return $q;
				});
			}
			
			//course category --------------
			$cats=CourseCategory::where('status',1)->orderBy('id','ASC')->get();
			$data['category']=$cats;
						
						
			//my courses -------------------
			
			$mcrs=Course::Join('subscriptions','courses.id','=','subscriptions.course_id')
				  ->where('subscriptions.student_id',$stid)
				  ->where('courses.status',1)
				  ->get()->map(function($q)
				  {
					$q['subscription_status']=true;
					$q['course_wide_icon']=config('constants.course_icon').$q->course_wide_icon;
					$q['course_square_icon']=config('constants.course_icon').$q->course_square_icon;
					$q['video_file']=($q->video_file!="")?config('constants.course_exp_video').$q->video_file:null;
					return $q;
				  });
				  
			$data['my_courses']=$mcrs;
			

			//success stories --------------
			
			$sstory=SuccessStory::where('status',1)->orderBy('id','ASC')->get()->map(function($q)
			{
				$q['story_icon']=config('constants.success_story').$q->story_icon;
				$q['story_video']=config('constants.success_story').$q->story_video;
				return $q;
			});
			
			$data['success_story']=$sstory;			
			
			$response = [
			'status'=>TRUE,
			'data'=>$data,
			'icon_path'=>config('constants.course_icon'),
			'video_path'=>config('constants.course_exp_video'),
			];
			
		}
		catch(\exception $e)
		{
			$response = ['status'=>FALSE, "message" =>$e->getMessage()];
		}
		
		return response($response, 200);
 }
 
 
 public function get_courses_by_category_id(Request $request)
 {
		$catid=$request->category_id;
				
		try
		{
			if($catid==1) //All category
			{			
				$crs=Course::where('status',1)->orderBy('id','ASC')->get()->map(function($q)
			    {
					$q['course_wide_icon']=config('constants.course_icon').$q->course_wide_icon;
					$q['course_square_icon']=config('constants.course_icon').$q->course_square_icon;
					$q['video_file']=($q->video_file!="")?config('constants.course_exp_video').$q->video_file:null;
					return $q;
				});
			}
			else
			{
				$crs=Course::where('course_category_id',$catid)->where('status',1)->orderBy('id','ASC')->get()->map(function($q)
			    {
					$q['course_wide_icon']=config('constants.course_icon').$q->course_wide_icon;
					$q['course_square_icon']=config('constants.course_icon').$q->course_square_icon;
					$q['video_file']=($q->video_file!="")?config('constants.course_exp_video').$q->video_file:null;
					return $q;
				});
			}

			if(!$crs->isEmpty())
			{
			  $response = [	'status'=>TRUE,	'data'=>$crs,
			  'icon_path'=>config('constants.course_icon'),
			  'video_path'=>config('constants.course_exp_video'),
			  'message'=>"Course were found." ];
			}
			else
			{
				$response = ['status'=>FALSE,'data'=>[],'message'=>"No course were found"];
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			$response = ['status'=>FALSE,'data'=>[],'message'=>"Something wrong, try again."
					];
		}	
		return response($response, 200);	
 }
   
 
    /**
	 * Function get_course_details
	 * Function to get course details for purchase
	 * Method:POST
	 * @params: course_id (int)
	 * return [ course details ]
	 */


	public function get_course_details(Request $request)  //for purchase
	{
		$student_id=$request->student_id;
		$course_id=$request->course_id;
		
		try
		{
			$crs=Course::where('id',$course_id)->where('status',1)->get()->map(function($q) use($course_id,$student_id)
			    {
	
					$scnt=Subscription::where('course_id',$course_id)->where('student_id',$student_id)->count();
					if($scnt<=0)
					{
						$q['subscription_status']=FALSE;
					}
					else{$q['subscription_status']=TRUE;
					}
					
					$q['course_wide_icon']=config('constants.course_icon').$q->course_wide_icon;
					$q['course_square_icon']=config('constants.course_icon').$q->course_square_icon;
					$q['video_file']=($q->video_file!="")?config('constants.course_exp_video').$q->video_file:null;
					
					return $q;
				});
				
			$recent_test=TestResult::select('test_results.score','test_results.question_paper_id','test_results.created_at','question_papers.question_paper_name')
				->Join('question_papers','test_results.question_paper_id','=','question_papers.id')
				->where('test_results.student_id',$student_id)
				->get()->map(function($q) use($student_id)
				{
					
					$acnt=QpaperAttended::where('student_id',$student_id)->where('question_paper_id',$q->question_paper_id)->count();
					$q['attended_count']=$acnt;
										
					$date = Carbon::createFromDate($q->created_at);
					$now = Carbon::now();
					$diff = $date->diffInDays($now);
					$q['test_days']=$diff." days";
					return $q;
				});
			
				
			$response = [
				'status'=>TRUE,
				'course_details'=>$crs,
				'recent_test'=>$recent_test,
			];
			
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE, "message" => $e->getMessage()];
			
		}
   
	return response($response, 200);
   
   }

 
   /**
	 * Function get_my_courses
	 * Function to get purchased courses
	 * Method:POST
	 * @params: student_id (int)
	 * @params: course_id (int)
	 * return [ courses ]
	 */
		
	public function get_my_courses(Request $request) 
	{
		$stid=$request->student_id;
		
		//my courses -------------------
		
		$data['my_courses']=[];
		$data['recent_tests']=[];
		
		try
		{
			
		$mcrs=Course::select('courses.course_name','subscriptions.course_id')
			->Join('subscriptions','courses.id','=','subscriptions.course_id')
			->where('subscriptions.student_id',$stid)
			->get()->map(function($q)
			  {
				  $q['subscription_status']=true;
				  $q['course_wide_icon']=config('constants.course_icon').$q->course_wide_icon;
				  $q['course_square_icon']=config('constants.course_icon').$q->course_square_icon;
				  $q['video_file']=($q->video_file!="")?config('constants.course_exp_video').$q->video_file:null;
					return $q;
				});
			  
		$data['my_courses']=$mcrs;
		
		$recent_test=TestResult::select('test_results.score','test_results.test_date','question_papers.question_paper_name')
				->Join('question_papers','test_results.question_paper_id','=','question_papers.id')
				->where('test_results.student_id',$stid)
				->get()->map(function($q)
				{
					$date = Carbon::createFromDate($q->test_date);
					$now = Carbon::now();
					$diff = $date->diffInDays($now);
					$q['test_days']=$diff." days";
					return $q;
				});
		
		$data['recent_tests']=$recent_test;
			
			$response = [
				'status'=>TRUE,
				'my_course_data'=>$data,  //$data;
			];
			
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE, "message" => $e->getMessage()];
			
		}
   
	return response($response, 200);
   
   }

   /**
	 * Function get_subjects
	 * Function to subjects based on course
	 * Method:POST
	 * @params: course_id
	 * return [ subjects ]
	 */
		
	public function get_subjects(Request $request) 
	{
		$cid=$request->course_id;
		$stid=$request->student_id;
		
		try
		{
			$subjects = Subject::where('course_id',$cid)->where('status',1)->orderBy('id','ASC')->get()->map(function($q)
			  {
				  
				  $tcnt=Chapter::where('subject_id',$q->id)->count();
				  $q['topic_count']=$tcnt;
				  $q['subject_icon']=config('constants.subject_icon').$q->subject_icon;
				  return $q;
				});
			
			if(!$subjects->isEmpty())
			{			
				$response = [
					'status'=>TRUE,
					'subject'=>$subjects,
					"message" => "Subjects found."
				];
				
			}
			else {
				$response = ['status'=>FALSE, "message" => "No data were found."];
			}
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE, "message" =>$e->getMessage()];
		}
		
     return response($response, 200);
   }

   /**
	 * Function get_topics
	 * Function to get topics/chapter based on subject
	 * Method:POST
	 * @params: subject_id
	 * return [ topics ]
	 */
		
	public function get_topics(Request $request)  //chapters
	{
		$sid=$request->subject_id;
		
		try
		{
			$data = Chapter::where('subject_id',$sid)->where('status',1)->orderBy('id','ASC')->get()
			->map(function ($q)
			{
				$vid_count=Video::where('chapter_id',$q->id)->count();
				$pdf_count=PdfFile::where('chapter_id',$q->id)->count();
				$q['chapter_icon']=config('constants.chapter_icon').$q->chapter_icon;
				
				$q['video_count']=$vid_count;
				$q['pdf_count']=$pdf_count;
				return $q;
			});
					
			if(!$data->isEmpty()) 
			{
				$response = [
					'status'=>TRUE,
					'topics'=>$data,
					'message'=>'Chapters found.',
				];
			}
			else {
				$response = ['status'=>FALSE, "message" => "No data were found."];
				
			}
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE, "message" =>$e->getMessage()];
		}
		
		return response($response, 200);
    }


/**
	 * Function get_video_pdf_classes
	 * Function to get video classes and pdf notes
	 * Method:POST
	 * @params: topic_id
	 * return [ video & pdf classes ]
	 */
		
	public function get_video_pdf_classes(Request $request)  //chapters
	{
		$tid=$request->topic_id;
		$stid=$request->student_id;
		
		try
		{
		
				$topic=Chapter::select('chapters.chapter_name','chapters.description')->where('id',$tid)->where('status',1)->first();
						
				$videos = Video::where('chapter_id',$tid)->where('status',1)->orderBy('id','ASC')->get()
				 ->map(function($q) use($stid)
			    {

				  $vcnt=VideoCompletedStatus::where('video_id',$q->id)->where('student_id',$stid)->count();
				  if($vcnt>0)
				  {
					  $q['video_watched']=true;
				  }
				  else
				  {
					  $q['video_watched']=false;
				  }
				  
				  $q['video_icon']=config('constants.video_file').$q->video_icon;
				  $q['video_file']=($q->video_file!="")?config('constants.video_file').$q->video_file:null;
				  return $q;
				});

			   $pdf_files = PdfFile::where('chapter_id',$tid)->where('status',1)->orderBy('id','ASC')->get()
			    ->map(function($q)
			    {
				  $q['pdf_icon']=config('constants.pdf_file').$q->pdf_icon;
				  $q['pdf_file']=config('constants.pdf_file').$q->pdf_file;
				  return $q;
				});

				$response = [
					'status'=>TRUE,
					'topic'=>$topic,
					'videos'=>$videos,
					'pdf_files'=>$pdf_files,
					'message'=>'Video & Pdf files found.',
				];
		
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE, "message" =>$e->getMessage()];
		}
		
		return response($response, 200);
    }


   /**
	 * Function get_video_class
	 * Function to get video details
	 * Method:POST
	 * @params: video_id
	 * return [ video details ]
	 */
	
	
	public function get_video_class(Request $request)  //chapters
	{
		$vid=$request->video_id;
		$stid=$request->student_id;
		
		try
		{
			$video = Video::where('id',$vid)->where('status',1)->get()->map(function($q) use($vid,$stid)
			  {
				  $vcnt=VideoCompletedStatus::where('video_id',$vid)->where('student_id',$stid)->count();
				  if($vcnt>0)
				  {
					  $q['video_watched']=true;
				  }
				  else
				  {
					  $q['video_watched']=false;
				  }
				  $q['video_icon']=config('constants.video_file_path').$q->video_icon;
				  $q['video_file']=($q->video_file!="")?config('constants.video_file_path').$q->video_file:null;
				  return $q;
				});
			
			if(!$video->isEmpty())
			{
			$response = [
					'status'=>TRUE,
					'video'=>$video,
					'message'=>"Video found.",
				];
			}
			else
			{
				$response = ['status'=>FALSE, "message" =>"No video were found"];
			}
		
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE, "message" =>$e->getMessage()];
		}
		
		return response($response, 200);
    }



/**
	 * Function get_pdf_note
	 * Function to get pdf note details
	 * Method:POST
	 * @params: pdf_id
	 * return [ pdf details ]
	 */
		
	public function get_pdf_note(Request $request)  //chapters
	{
		$pid=$request->pdf_id;
		
		try
		{
			$pdf = PdfFile::where('id',$pid)->where('status',1)->get()->map(function($q)
			  {
				  $q['pdf_icon']=config('constants.pdf_file_path').$q->pdf_icon;
				  $q['pdf_file']=($q->pdf_file!="")?config('constants.pdf_file_path').$q->pdf_file:null;
				  return $q;
				});
			
			if(!$pdf->isEmpty())
			{
			$response = [
					'status'=>TRUE,
					'pdf'=>$pdf,
					'message'=>'Pdf found.',
				];
			}
			else
			{
				$response = ['status'=>FALSE, "message" =>"No pdf were found"];
			}
		
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE, "message" =>$e->getMessage()];
		}
		
		return response($response, 200);
    }

   /**
	 * Function get_referral_code_value
	 * Function to get the referral code value
	 * Method:POST
	 * @params: referral_code
	 * return [ value ]
     */

  public function get_referral_code_value(Request $request) 
	{
		$rcode=strtoupper($request->referral_code);
		
		try
		{
			
			$res = Staff::where('referral_code',$rcode)->first();
			 
			if(!empty($res)) 
			{
				$response = [
					'status'=>TRUE,
					'referral_code'=>$rcode,
					'percentage'=>$res->percentage,
				];
			}
			else {
				$response = ['status'=>FALSE, "message" => "Referal code not found."];
				
			}
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE, "message" => $e->getMessage()];
			
		}
		return response($response, 200);

    }

  /**
	 * Function get_live_classes
	 * Function to get the live class details 
	 * Method:POST
	 * @params: course_id(int)
	 * return [ live classes ]
     */

public function get_live_classes(Request $request)  //live class for dashboard
{
	   $crsid=$request->course_id;

		try
		{

			$lvclas=LiveClass::where('course_id',$crsid)->where('status',1)->orderBy('start_date','ASC')
			->get()->map(function($q)
			  {
				  $q['class_icon']=config('constants.live_class_icon').$q->class_icon;
				  return $q;
				});
			
			if(!$lvclas->isEmpty())
			{
				$response = [
					'status'=>TRUE,
					'data'=>$lvclas,
					'message'=>"live class found.",
				];
			}
			else
			{
				$response = [
				'status'=>FALSE,
				'message'=>"No live class were found.",
				];
			}
		}catch(\Exception $e)
		{
			$response = ['status'=>FALSE,'message'=>$e->getMessage()];
		}
		
	return response($response, 200);	
}


	/**
	 * Function set_video_completed_status
	 * Function to set the video completed status
	 * Method:POST
	 * @params: course_id(int)
	 * @params: subject_id(int)
	 * @params: student_id (int)
	 * @params: video_id (int)
	 * @params: completed_status(int) - 1-completed , 0-not completed
	 * return [ details ]
	 */

public function set_video_completed_status(Request $request) 
	{
		$crs_id=$request->course_id;
		$sub_id=$request->subject_id;
		$stid=$request->student_id;
		$vid=$request->video_id;
		$cstatus=$request->completed_status;
		
		
	try
	{
		$where1=['video_id'=>$vid,'student_id'=>$stid];
		$res=VideoCompletedStatus::where($where1)->delete(); //delete old like and dislike
		
		$result=0;
		if($cstatus==1)
		{			
			$result=VideoCompletedStatus::create([
				'course_id'=>$crs_id,
				'subject_id'=>$sub_id,
				'student_id'=>$stid,
				'video_id'=>$vid,
				'completed_status'=>1,
			]);
		}
	
		if($result) 
		{
			$response = ['status'=>TRUE,'message'=>'Video completed status added.'];
		}
		else 
		{
			
			$response = ['status'=>FALSE,"message" => "something wrong, try again."];
			
		}
	}catch(\exception $e)
	{
		$response = ['status'=>TRUE, 'message'=>$e->getMessage()];
	}
		
		return response($response, 200);
    }


	/**
	 * Function share_video_comment
	 * Function to set the video comments
	 * Method:POST
	 * @params: course_id(int)
	 * @params: subject_id(int)
	 * @params: student_id (int)
	 * @params: video_id (int)
	 * @params: comment(string)
	 * return [ details ]
	 */

public function share_video_comment(Request $request) 
	{
		$crs_id=$request->course_id;
		$sub_id=$request->subject_id;
		$stid=$request->student_id;
		$vid=$request->video_id;
		$comment=$request->comment;
	try
	{
		$where1=['video_id'=>$vid,'student_id'=>$stid];
		$result=VideoComment::where($where1)->delete(); 

			$result=VideoComment::create([
				'course_id'=>$crs_id,
				'subject_id'=>$sub_id,
				'student_id'=>$stid,
				'video_id'=>$vid,
				'comments'=>$comment,
			]);

		if($result) 
		{
			$response = ['status'=>TRUE,'message'=>'Comment successfully added.'];
		}
		else 
		{
			$response = ['status'=>FALSE,"message" => "something wrong, try again."];
		}
	}catch(\exception $e)
	{
		\Log::info($e->getMessage());
		$response = ['status'=>FALSE, 'message'=>"Something wrong, try again."];
	}
		
		return response($response, 200);
    }
	
	/**
	 * Function share_recorded_video_comment
	 * Function to set the recorded live class video comments
	 * Method:POST
	 * @params: course_id(int)
	 * @params: student_id (int)
	 * @params: video_id (int)
	 * @params: comment(string)
	 * return [ details ]
	 */

public function share_recorded_video_comment(Request $request) 
	{
		$crs_id=$request->course_id;
		$stid=$request->student_id;
		$vid=$request->video_id;
		$comment=$request->comment;
	try
	{
		$where1=['recorded_live_class_id'=>$vid,'student_id'=>$stid];
		$result=RecordedVideoComment::where($where1)->delete(); 

			$result=RecordedVideoComment::create([
				'course_id'=>$crs_id,
				'student_id'=>$stid,
				'recorded_live_class_id'=>$vid,
				'comments'=>$comment,
			]);

		if($result) 
		{
			$response = ['status'=>TRUE,'message'=>'Comment successfully added.'];
		}
		else 
		{
			$response = ['status'=>FALSE,"message" => "Something wrong, try again."];
		}
	}catch(\exception $e)
	{
		\Log::info($e->getMessage());
		$response = ['status'=>FALSE, 'message'=>"Something wrong, Please check."];
	}
		
		return response($response, 200);
    }


	/**
	 * Function get_notifications
	 * Function to get the notifications
	 * Method:POST
	 * @params: student_id (int)
	 * return [ details ]
	 */
		
public function get_notifications(Request $request) 
	{
		$stid=$request->student_id;
		
		try
		{		
			$notify=Notification::select('notifications.*')->leftJoin('courses','notifications.course_id','=','courses.id')
				->leftJoin('subscriptions','courses.id','=','subscriptions.course_id')
				->where('subscriptions.student_id',$stid)
				->orWhere('notifications.notification_type_id',1)
				->where('notifications.status',1)
				->orderBy('notifications.created_at','DESC')->get();
						
			if(!$notify->isEmpty())
			{
			  $response = ['status'=>TRUE,'data'=>$notify,"message"=>"Notificatins"];
			}
			else
			{
				$response = ['status'=>FALSE,"message" => "No data were found."];
			}
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE,"message" =>$e->getMessage()];
		}	

		return response($response, 200);
	}

	/**
	 * Function get_purchase
	 * Function to purchase new course
	 * Method:POST
	 * @params: student_id (int)
	 * @params: course_id (int)
	 * @params: referral_code (string)
	 * @params: referral_value (float)
	 * @params: discount_rate (float)
	 * @params: net_amount (float)
	 * @params: payment_id (string)
	 * return [ details ]
	 */

public function purchase_course(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'student_id' => 'required', 
			'course_id' => 'required', 
		]);
		
		
		if ($validator->fails())
		{
			return response(["status"=>FALSE,'message'=>'Details missing.'], 200);
		}
		else
		{
			$stid=$request->student_id;
			$cuid=$request->course_id;
			
			$sub_cnt=Subscription::where('student_id',$stid)->where('course_id',$cuid)->count();
			if($sub_cnt>0)
			{
				$response = ['status'=>FALSE,'message'=>"Course already purchased."];
			}
			else
			{
				//for payments --------------------------------
				$ref_code=$request->referral_code;
				$ref_amt=$request->referral_value;
				$crs_rate=$request->discount_rate;
				$net_amt=$request->net_amount;
				$pmt_id=$request->payment_id;

				DB::beginTransaction();
				
				try
				{
				
				if($request->has('referral_code') and $request->referral_code!="")
				{
					$sta_id=Staff::where('referral_code',Str::upper($request->referral_code))->pluck('id')->first();
				}
				else
				{
					$sta_id=null;
				}

					$crs=Course::whereId($cuid)->first();
					if(!empty($crs))
					{
						$result=Subscription::create([
							'student_id'=>$stid,
							'course_id'=>$cuid,
							'referral_code'=>$ref_code,
							'referral_value'=>$ref_amt,
							'rate'=>$crs_rate,
							'net_amount'=>$net_amt,
							'start_date'=>$crs->start_date,
							'end_date'=>$crs->end_date,
							'staff_id'=>$sta_id,
							'status'=>1
						]);
						
						$ppkg_id=$result->id;
											
						$res=Payment::create([
							'student_id'=>$stid,
							'course_id'=>$cuid,
							'referral_code'=>$ref_code,
							'referral_value'=>$ref_amt,
							'discount_rate'=>$crs_rate,
							'net_amount'=>$net_amt,
							'payment_id'=>$pmt_id,
							'status'=>1
						]);	
						
						//$capture=$this->payment_capture($request);  //capture razorpay payament

						DB::commit();
						$response = ['status'=>TRUE,'message'=>"Purchase successfully Completed."];
					}
					else
					{
						$response = ['status'=>FALSE,'message'=>"Course not found."];
					}

				}
				catch(\Exception $e)
				{
				  \Log::info($e->getMessage());
					DB::rollback();
				  $response = ['status'=>FALSE,'message'=>"Something wrong, Try again.".$e->getMessage()];
				}
			}
		}
	  return response($response, 200);
}


	/**
	 * Function get_recorded_live_classes
	 * Function to get the all recorded live classes based on course
	 * Method:POST
	 * @params: course_id (int)
	 * return [ details ]
	 */


public function get_recorded_live_classes(Request $request) 
	{
		$crsid=$request->course_id;
		
		try
		{		
			$rlc=RecordedLiveClass::select('recorded_live_classes.*','courses.course_name')
					->Join('courses','recorded_live_classes.course_id','=','courses.id')
					->where('recorded_live_classes.course_id',$crsid)
					->orderBy('recorded_live_classes.id','ASC')->get()->map(function($q)
					{
						$q['class_icon']=config('constants.recorded_class').$q->class_icon;
						$q['video_file']=($q->video_file!="")?config('constants.recorded_class').$q->video_file:null;
						return $q;
					});
			
			if(!$rlc->isEmpty())
			{
			  $response = ['status'=>TRUE,'data'=>$rlc,"message"=>"recorded classes found."];
			}
			else
			{
				$response = ['status'=>FALSE,"message" => "No data were found."];
			}
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE,"message" =>$e->getMessage()];
		}	

		return response($response, 200);
	}


	/**
	 * Function get_recorded_live_classes
	 * Function to get the all recorded live classes based on course
	 * Method:POST
	 * @params: course_id (int)
	 * return [ details ]
	 */


public function get_easy_tips(Request $request) 
	{
		$crsid=$request->course_id;
		
		try
		{		
			$etips=EasyTips::where('course_id',$crsid)->get()->map(function($q)
			{
				$q['tips_icon']=config('constants.easy_tips').$q->tips_icon;
				$q['tips_file']=($q->tips_file!="")?config('constants.easy_tips').$q->tips_file:null;
				return $q;
			});
			
			if(!$etips->isEmpty())
			{
			  $response = ['status'=>TRUE,'data'=>$etips,"message"=>"easy tips found."];
			}
			else
			{
				$response = ['status'=>FALSE,"message" => "No data were found."];
			}
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE,"message" =>$e->getMessage()];
		}	

		return response($response, 200);
	}


	/**
	 * Function set_app_usage
	 * Function to set the  total app usage details 
	 * Method:POST
	 * @params: student_id (int)
	 * @params: usage_seconds (int)
	 * return [ details ]
	 */

public function set_app_usage(Request $request) 
	{
		$stid=$request->student_id;
		$utime=$request->usage_seconds;  //in seconds;
				
			$au=AppUsage::where('student_id',$stid)->whereDate('created_at',date('Y-m-d'))->first();
			
			Try{
				
			if(!empty($au))
			{
				$u_time=$au->usage_seconds+$utime;
				$new_dat=[ 
				'student_id'=>$stid,
				'usage_seconds'=>$u_time,
				];
				$result=AppUsage::where('id',$au->id)->update($new_dat);
			}
			else
			{
				$new_dat=[ 
				'student_id'=>$stid,
				'usage_seconds'=>$utime,
				];
				$result=AppUsage::create($new_dat);
			}
			
			if($result)
			{		
				$response = ['status'=>TRUE,"message"=>"Data submitted."];
			}
			else
			{
				$response = ['status'=>FALSE,"message"=>"Something wrong, Try again."];
			}
			
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			$response = ['status'=>FALSE,"message" =>$e->getMessage()];
		}	
		return response($response, 200);
	}


	/**
	 * Function get_my_activities
	 * Function to get the my all activities based on course
	 * Method:POST
	 * @params: course_id (int)
	 * @params: student_id (int)
	 * return [ details ]
	 */

public function get_my_activities(Request $request) 
	{
		$stid=$request->student_id;
		
		$data['video_attended']=0;
		$data['test_completed']=0;
	
		try
		{		
		  $vcs=VideoCompletedStatus::where('student_id',$stid)->count();
		  $trc=TestResult::where('student_id',$stid)->count();
			
		  $data['video_attended']=$vcs;
		  $data['test_completed']=$trc;
		  
		 $pdays=AppUsage::where('student_id',$stid)
		 ->whereDate('created_at', '>', now()->subDays(5))
		 ->orderBy('created_at','ASC')->get()->map(function($q)
		 {
			 
			 //$q['day']=Carbon::parse($q->created_at)->format('D');   //dayName;
			 $q['day']=$q->created_at;
			 return $q;
		 });
		 
		 
		  $response = ['status'=>TRUE,'data'=>$data,'pdays'=>$pdays,"message"=>"Data found."];
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			$response = ['status'=>FALSE,'data'=>$data,"message" =>$e->getMessage()];
		}	

		return response($response, 200);
	}



}

