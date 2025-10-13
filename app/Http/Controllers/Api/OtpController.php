<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use App\Models\User;
use App\Models\Student;
use App\Models\StudentDevice;
use App\Models\Tempotp;
use App\Models\Subscription;

use Log;

use Mail;
use App\Models\OtpApi;

class OtpController extends Controller
{

	public function send_otp(Request $request) // for login
    {
		try
		{
			if($request->mobile!="1234567890")
			{

				$api_url=OtpApi::where('status',1)->pluck('api_url')->first();
				
				$mob=$request->mobile;
			
				$otp=mt_rand(1000, 9999);
				
				Tempotp::where('mobile','=',$mob)->delete();
				Tempotp::Create(['mobile' =>$mob, 'otp'=>$otp ]);

				$message="Hi, Your OTP to login to AIM PSC App is ".$otp." Thank you AIM.";
				$message=rawurlencode($message);
				
				$url=$api_url;
				
				$url=str_replace("%mobile%",$mob,$url);
				$url=str_replace("%message%",$message,$url);			
				
				$ch = curl_init();
				curl_setopt_array($ch, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
				));

				//Ignore SSL certificate verification
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

				//get response
				$output = curl_exec($ch);
				$err = curl_error($ch);
				curl_close($ch);
				
				
				if (!$err)
				{
					$response = [ 'status'=>TRUE,'message'=>"Otp successfully send."];
					
				} else {
					$response = [ 'status'=>FALSE,'message'=>"Failed."];
				}
			}
			else
			{
				$response = [ 'status'=>TRUE,'message'=>"Otp successfully send."];
			}
			
		}
		catch(\Exception $e)
		{
			$response = [ 'status'=>FALSE,'message'=>$e->getMessage()];
		}
	
		return response($response, 200);
    }
	
	 /**
	 * Function verify_otp
	 * Function to check the entered otp is correct
	 * Method:POST
	 * @params: mobile(int),
	 * @params: otp (int)
	 * @params: new_registration (int) - 1 new registration, 0 - for login 
	 * return [ status ]
	 */
	
	public function verify_otp(Request $request)
    {

		$validator = Validator::make($request->all(), [
		   'otp'=>'required',
		   'mobile'=>'required',
		   'version_release'=> 'required',
		   'manufacturer'=> 'required',
		   'model'=> 'required',
		   'androidid'=>'required',
		   //'fcm_token'=>'required',
		]);
	
		if ($validator->fails())
		{
			return response(['otp_status'=>False,'errors'=>'Details missing, try again.'],200);
		}
		
		$data=[];
		
		try
		{

			$usr_otp=$request->otp;
			$mobile=$request->mobile;
			$otp=Tempotp::where('mobile',$mobile)->pluck('otp')->first();
			
			/*$user=User::select('users.*','students.student_name')
			->leftJoin('students','users.student_id','=','students.id')
			->where('users.mobile',$mobile)->get()->first();*/
			
				$user=User::where('users.mobile',$mobile)->get()->first();

			   if(!empty($user) and $otp==$usr_otp)
			   {
				   
				   if($user->status==1)
				   {
				   //$res = Tempotp::where('mobile',$mobile)->delete();	
		
					$lgcnt=StudentDevice::where('student_id',$user->student_id)->get()->count();

					$sddata=[  'student_id'=> $user->student_id,
							   'mobile'=>$user->mobile,
							   'version_release'=> $request->version_release,
							   'manufacturer'=> $request->manufacturer,
							   'model'=> $request->model,
							   'androidid'=>$request->androidid,
							   'device'=> $request->device,
							   'status'=>'1',
							];
					
					if($lgcnt<=0)
					{
						StudentDevice::create($sddata);
					}
					else
					{
					   $res1=StudentDevice::where('student_id',$user->student_id)->update($sddata);	
					}
					
					//fcm_token update--------------
					$fcm_dt=['fcm_token'=>$request->fcm_token,];
					$ures=User::where('id',$user->id)->update($fcm_dt);					
					//------------------------------
													
					$androidid=$request->androidid;
					$stud_name=Student::where('id',$user->student_id)->pluck('student_name')->first();

					Auth::login($user);
					$token = $user->createToken('aim-balussery')->accessToken;
					
					$subs=Subscription::select('subscriptions.course_id','courses.id as course_id','courses.course_name')
						->leftJoin('courses','subscriptions.course_id','=','courses.id')
						->where('subscriptions.student_id',$user->student_id)->get();
						
					
						 $data = [
							'login_status'=>TRUE,
							'message'=>"Login Success.",
							'token' => $token,
							'user_id'=> Auth::id(),
							'student_id'=>$user->student_id,
							'student_name'=>$stud_name,
							'mobile'=>$request->mobile,
							'email'=>$request->email,
							'subscriptions'=>$subs,   
							'android_ios_id'=>$androidid,
						];
						
						$response = ['status'=>TRUE,'account_status'=>TRUE,'message'=>"Otp verification success.",'user_data'=>$data];
				   }
				   else
				   {
					 $response = [ 'status'=>FALSE,'account_status'=>FALSE,'user_data'=>$data,"message" =>'Account temporarily disabled.'];  
				   }
				}
				else
				{

					if($otp==$usr_otp)
					{
						$response = [ 'status'=>TRUE,'account_status'=>TRUE,'user_data'=>$data,'message'=>"Otp verification success."];
					}
					else if($otp!=$usr_otp)
					{
						$response = [ 'status'=>FALSE, 'account_status'=>TRUE, 'user_data'=>$data,'message'=>"Incorrect Otp."];
					}
					else 
					{
					    $response = [ 'status'=>FALSE,'account_status'=>FALSE,'user_data'=>$data,"message" =>'Account temporarily disabled.'];  
					}
				}
		}
		 catch(\Exception $e)
		 {
			 \Log::info($e->getMessage());
			$response = [ 'status'=>FALSE,'message'=>"Something wrong, Try again.".$e->getMessage()];
		 }
		 
		return response($response, 200);
    }
		
   
}