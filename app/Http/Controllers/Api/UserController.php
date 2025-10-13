<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Http\JsonResponse;

use App\Models\User;
use App\Models\Student;
use App\Models\StudentDevice;
use App\Models\Subscription;
use App\Models\RemovedStudent;
use App\Models\Staff;


class UserController extends Controller
{

    /**
	 * Function login
	 * Function to login students
     * Method : post
     * parameters : mobile,passsword,version_release,manufacturer,model,androidid,device
	 * return [details]
	 */
 
	public function login(Request $request)   // not used -  using verify otp api for login
	{
			
		//status = 0-inactive , 1-active, 2-disabled;
	
		$validator = Validator::make($request->all(), [
		  'mobile' => 'required|string',   //mobile no
		  'version_release'=> 'required',
		  'manufacturer'=> 'required',
		  'model'=> 'required',
		  'androidid'=>'required',
		]);
	
	
		if ($validator->fails())
		{
			return response(['errors'=>'Invalid user details.'],200);
		}
		
		$where=['mobile'=> $request->mobile];
		$user = User::where($where)->first();
		
		$mob=$request->mobile;   //mobile no
					
		if (!empty($user)) 
		{
			
			$lgcnt=StudentDevice::where('student_id',$user->student_id)->get()->count();
			
			$sddata=[  'student_id'=> $user->student_id,
					   'mobile'=>$mob,
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
					
			$androidid=$request->androidid;

				if($user->status==1)
				{
				
						Auth::login( $user );
						$token = $user->createToken('aim-balussery')->accessToken;
						
						$stdt=Student::whereId($user->student_id)->first();
						if(!empty($stdt))		
						{
							
						$subs=Subscription::select('subscriptions.course_id','courses.id as course_id','courses.course_name')
							->leftJoin('courses','subscriptions.course_id','=','courses.id')
							->where('subscriptions.student_id',$user->student_id)->get();
						
							 $response = [
								'status'=>TRUE,
								'message'=>"Login Success.",
								'token' => $token,
								'user_id'=> Auth::id(),
								'student_id'=>$user->student_id,
								'student_name'=>$stdt->student_name,
								'mobile'=>$user->mobile,
								'email'=>$stdt->email,
								'subscriptions'=>$subs,   
								'android_ios_id'=>$androidid,
							];

						}
						else
						{
							$response = ['status'=>False, "message" => "Student details not found."];
						}

				}
				else
				{
					$response = ['status'=>FALSE, "message" =>'Account temporarily disabled.'];
					return response($response, 200);
				}
		} 
		else {
			$response = ['status'=>False, "message" =>'User does not exist'];
		}
		
		return response()->json($response, 200);
}

   /**
	 * Function register
	 * Function to new student registration
     * Method : post
     * parameters : center_id (int)
	 * parameters : name (string)
	 * parameters : birth_date,(date-string)
	 * parameters : mobile (string)
	 * parameters : email (string)
	 * parameters : district_id (int)
	 * parameters : place (string)
	 * parameters :'version_release (string),
	 * parameters :manufacturer(string),
	 * parameters :model(string),
	 * parameters :androidid (string),
	 * parameters :prefer_to_learn (int)
	 return [true/false]
	 */


public function register_student(Request $request)  
{

		$validator = Validator::make($request->all(), [
		  
		   'center_id'=>'required',
		   'student_name'=>'required',
		   'birth_date'=>'required',
		   'mobile'=>'required',
		   'email'=>'required',
		   'district_id'=>'required',
		   'place'=>'required',
		   'version_release'=> 'required',
		   'manufacturer'=> 'required',
		   'model'=> 'required',
		   'androidid'=>'required',
		   'prefer_to_learn'=>'required'
		   //'fcm_token'=>'required',
		]);
	
	
		if ($validator->fails())
		{
			return response(['errors'=>'user details missing, try again.'],200);
		}

		$mob_check=Student::where('mobile',trim($request->mobile))->get()->count();
		if($mob_check<=0)
		{
		
		 $result="";
			DB::beginTransaction();
			
			try{

				if($request->has('referral_code') and $request->referral_code!="")
				{
					$sta_id=Staff::where('referral_code',Str::upper($request->referral_code))->pluck('id')->first();
				}
				else
				{
					$sta_id=null;
				}
				
				$res=Student::create([
					'center_id'=>$request->center_id,
					'student_name'=>$request->student_name,
					'date_of_birth'=>date_create($request->birth_date)->format('Y-m-d'),
					'mobile'=>$request->mobile,
					'email'=>$request->email,
					'district_id'=>$request->district_id,
					'place'=>$request->place,
					'staff_id'=>$sta_id,   //referral staff id
					'learn_category_id'=>$request->prefer_to_learn,
					'status'=>1,
				]);

				 $stid=$res->id;
				//student user

				$result=User::create([
					'student_id'=>$stid,
					'mobile'=>$request->mobile,
					'email'=>$request->email,
					//'password'=>Hash::make($request->password),
					'status'=>1
				]);
				
				$usrid=$result->id;
				
				//fcm_token update--------------
				$fcm_dt=['fcm_token'=>$request->fcm_token,];
				$ures=User::where('id',$usrid)->update($fcm_dt);					
				//------------------------------
								
				DB::commit();
				
				if ($result) 
					{

						$lgcnt=StudentDevice::where('student_id',$stid)->get()->count();
						
						$sddata=[  'student_id'=> $stid,
								   'mobile'=>$request->mobile,
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
					
						$androidid=$request->androidid;

						$user=User::where('id',$usrid)->first();
						if($user->status==1)
						{
				
						Auth::login($user);
						$token = $user->createToken('aim-balussery')->accessToken;
						
						$subs=Subscription::select('subscriptions.course_id','courses.id as course_id','courses.course_name')
							->leftJoin('courses','subscriptions.course_id','=','courses.id')
							->where('subscriptions.student_id',$stid)->get();
						
							 $data = [
								'login_status'=>TRUE,
								'message'=>"Login Success.",
								'token' => $token,
								'user_id'=> Auth::id(),
								'student_id'=>$stid,
								'student_name'=>$request->student_name,
								'mobile'=>$request->mobile,
								'email'=>$request->email,
								'subscriptions'=>$subs,   
								'android_ios_id'=>$androidid,
							];
							
							$response = ['status'=>TRUE,'message'=>"Registration Successfully Completed.",'user_data'=>$data];
						}
						else
						{
							$response = ['status'=>FALSE, "message" =>'Account temporarily disabled.'];
						}
					}
					else {
						$response = ['status'=>FALSE, "message" => "Something wrong, Please try again."];
					}
				
			}
			catch(\Exception $e)
			{
				DB::rollback();
				$response = ['status'=>FALSE,'message'=>$e->getMessage()];
			}
		}
		else
		{
		   $response = ['status'=>FALSE,'message'=>"Mobile already exisit, Try again"];	
		}
	
	return response($response, 200);
}


/**
	 * Function remove_user_account
	 * Function to permanantly remove user account
     * Method : post
     * parameters : mobile (string)
	 * return [true/false]
	 */


public function remove_user_account(Request $request)  
{
	
		$stdt=Student::where('mobile',$request->mobile)->first();
		$st=$stdt;
		
		if(!empty($stdt))
		{
			
			try
			{
			
			$result=User::where('student_id',$stdt->id)->delete();
			$result=$stdt->delete();
			
				if ($result) 
				{
						
					if(!empty($st))
					{
						$res=RemovedStudent::create([
						'center_id'=>$st->center_id,
						'student_id'=>$st->id,
						'name'=>$st->student_name,
						'date_of_birth'=>$st->date_of_birth,
						'mobile'=>$st->mobile,
						'email'=>$st->email,
						'district'=>$st->district,
						'place'=>$st->place,
						'status'=>1
						]);
					}
		
					$response = ['status'=>TRUE,'message'=>"User account Successfully removed."];
				}
				else {
					$response = ['status'=>FALSE, "message" => "Something wrong, Please try again."];
				}
			}
			catch(\Exception $e)
			{
				$response = ['status'=>FALSE, "message" => $e->getMessage()];
			}
		}
		else
		{
			$response = ['status'=>FALSE, "message" => "No user were found."];
		}
			
	return response($response, 200);
}


/**
	 * Function get_user_profile
	 * Function to get student details
     * Method : post
     * parameters : student_id (int)
	 * return [user details]
	 */

public function get_user_profile(Request $request)  
{
		$stid=$request->student_id;
		
		try
		{
			$stdt=Student::where('id',$stid)->get()->first();
			if(!empty($stdt))
			{
				$response = ['status'=>TRUE,
							 'data'=>$stdt,
							];
			}
			else
			{
				$response = ['status'=>FALSE,'message'=>"No data were found."];	
			}
		}catch(\Exception $e)
		{
			$response = ['status'=>FALSE,'message'=>$e->getMessage()];	
		}

	return response($response, 200);
}


/**
	 * Function update_user_profile
	 * Function to update profile
     * Method : post
     * parameters : center_id (int)
	 * parameters : name (string)
	 * parameters : birth_date,(date-string)
	 * parameters : mobile (string)
	 * parameters : email (string)
	 * parameters : district (string)
	 * parameters : place (string)
	 * parameters : password (string)
	 * return [true/false]
 */

public function update_user_profile(Request $request)  
{
		$status=TRUE;
		$stid=$request->student_id;
		
		$validator = Validator::make($request->all(), [
		  
		   'student_name'=>'required',
		   'birth_date'=>'required',
		   'mobile'=>'required',
		   'email'=>'required',
		   'district_id'=>'required',
		   'place'=>'required',
		   'prefer_to_learn'=>'required'
		]);
		
		if ($validator->fails())
		{
			return response(['errors'=>'User details missing, try again.'],200);
		}
		
		$sdt=Student::where('id',$stid)->get()->first();
		
		if(empty($sdt))
		{
			$response = ['status'=>FALSE,'message'=>"Student details not found."];
		}
		else
		{
			if($sdt->mobile!=$request['mobile'])
			{
				$mob_check=Student::where('mobile',$request['mobile'])->get()->count();
				if($mob_check>0)
				{
					$status=FALSE;
				}
				else
				{	
					$status=TRUE;
				}
			}
			else
			{
				$status=TRUE;
			}
		
		//updating data
		
			if($status==TRUE)
			{
		
				$result="";
				DB::beginTransaction();
				try
				{

					$sdat=[
						'student_name'=>$request->student_name,
						'date_of_birth'=>date_create($request->birth_date)->format('Y-m-d'),
						'mobile'=>$request->mobile,
						'email'=>$request->email,
						'district_id'=>$request->district_id,
						'place'=>$request->place,
						'learn_category_id'=>$request->prefer_to_learn,
					];

					$result=Student::where('id',$stid)->update($sdat);
					
					$sudat=[
						'mobile'=>$request->mobile,
						'email'=>$request->email,
					];
					
					$result=User::where('student_id',$stid)->update($sudat);
									
					DB::commit();
					
					if ($result) 
						{
						$response = ['status'=>TRUE,'message'=>"Profile successfully updated."];
					}
					else {
						$response = ['status'=>FALSE, "message" => "Something wrong, Please try again."];
					}
					
				}
				catch(\Exception $e)
				{
					DB::rollback();
					$response = ['status'=>TRUE,'message'=>$e->getMessage()];
				}
			}
			else
			{
			   $response = ['status'=>FALSE,'message'=>"Mobile already exist."];	
			}
		}

	return response($response, 200);
}


  /**
	 * Function check_user_device
	 * Function to check the application installed device
     * Method : post
     * params : student_id (int)
	 * params : android_ios_id (string)
	 * return [ true/false]
	 */

public function check_user_device_status(Request $request)   //to open app check this device/user status is active.
{

	$validator = Validator::make($request->all(), [
        'student_id' => 'required',  
		'android_ios_id' => 'required',
    ]);
	
    if ($validator->fails())
    {
        $response = ['status'=>False, "message" =>'Details missing.'];
    }
	else
	{
		
		try
		{
			$stid=$request->student_id;
			$an_ios_id=$request->android_ios_id;
			
			$rs=StudentDevice::join('students','student_devices.student_id','=','students.id')
			->where('student_devices.student_id',$stid)
			->where('student_devices.androidid',$an_ios_id)
			->where('students.status',1)->count();
			
			if($rs>0)
			{
					$response = ['status'=>True, "message" =>'Device verified.'];
			}
			else
			{
				$response = ['status'=>False, "message" =>'Device/User status invalid.'];
			}
			
		}
		catch(\Exception $e)
		{
			$response = ['status'=>False, "message" =>$e->getMessage()];
		}
	
	}

	return response($response, 200);
}

  /**
	 * Function change_user_password
	 * Function to change the user password
     * Method : post
     * params :old_password (string)
	 * params :password (string)
	 * params :mobile(string)
	 * return [ true/false]
	 */

 public function change_user_password(Request $request) 
	{
		$oldpass=$request->old_password; 
		$mob=$request->mobile;  
		$pass=$request->password;
	
		try
		{

			$udt=User::where('mobile',$mob)->get()->first();
			if(!empty($udt))
			{
				if(Hash::check($request->old_password, $udt->password))
				{
					$ps=['password'=>Hash::make($pass) ];
					$res=User::where('mobile',$mob)->update($ps);

					if($res) 
					{
						$response = [
							'status'=>TRUE,
							'message'=>"Password changed.!",
						];
					}
					else {
						$response = ['status'=>FALSE, "message" => "Student not Found."];
					}
				}
				else
				{
					$response = ['status'=>FALSE, "message" => "Old Password is invalid."];
						
				}
			}
			else
			{
				$response = ['status'=>FALSE, "message" => "User not found."];
			}
		}
		catch(\Exception $e)
		{
		  $response = ['status'=>FALSE, "message" => $e->getMessage()];	
		}
		
		
		return response($response, 200);
    }


   /**
	 * Function forgot_password 
	 * Function to reset user password
	 * Method: post
	 * @params:mobile (string)
	 * @params:password (string)
	 * return [ true/false ]
	 */


    public function forgot_password(Request $request) 
	{
		$mob=$request->mobile;
		$pass=$request->password;
		
		try{
		
			$res=Student::where('mobile','=',$mob)->get()->first();
			
			if(!empty($res))
			{			
				$ps=['password'=>Hash::make($pass) ];
				
				$where=['student_id'=>$res->id];
								
				$result=User::where($where)->update($ps);

				if($result) 
				{
					$response = [
						'status'=>TRUE,
						'message'=>"Password changed.!",
					];
				}
				else {
					$response = ['status'=>FALSE, "message" => "User not Found."];
				}
			}
			else
			{
				$response = ['status'=>FALSE, "message" => "User not Found."];
			}
		}
		catch(\Exception $e)
		{
			$response = ['status'=>FALSE, "message" =>$e->getMessage()];
		}
		return response($response, 200);
    }


}
