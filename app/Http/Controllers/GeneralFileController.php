<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use App\Models\PrivacyPolicy;
use App\Models\DeleteAccountRequest;
use App\Models\ContactUsMessage;
use App\Models\Student;

use Validator;
use DataTables;
use Session;
use Auth;

class GeneralFileController extends Controller
{

  public function __construct()
  {
     //$this->middleware('admin');
  }
  
  public function index()
  {
   $privacy=PrivacyPolicy::where('status',1)->where('id',1)->first();
   return view('admin.general_files.privacy_policy')->with('privacy',$privacy);
  }
    
  public function terms()
  {
   $terms=PrivacyPolicy::where('status',1)->where('id',2)->first();
   return view('admin.general_files.terms_condition')->with('terms',$terms);
  }
  
 
 public function delete_account()
  {
   return view('admin.general_files.delete_account');
  }
  
  public function contact_us()
  {
   return view('admin.general_files.contact_us');
  }


public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
			 'name'=>'required',
			 'mobile'=>'required',
			 'message'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            return response()->json(['msg' =>'Some details are missing, Try again!' , 'status' => false]);
        }
	
		try
		{
			$sdt=Student::where('mobile',$request->mobile)->first();
			if(!empty($sdt))
			{
				$result=DeleteAccountRequest::create([
				'name'=>$request->name,
				'student_id'=>$sdt->id,
				'mobile'=>$request->mobile,
				'message'=>$request->message,
				]);

				if($result)
				{
					return response()->json(['msg' =>'Account delete request successfully send!' , 'status' => true]);
				}
				else
				{
					return response()->json(['msg' =>'Some details are missing, Please check.' , 'status' => false]);
				}
			}
			else
			{
				return response()->json(['msg' =>'Account Not Found, Please enter registred mobile correctly. Thank You' , 'status' => false]);
			}

		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['msg' =>'Something wrong, Please check.' , 'status' => false]);
		}
		
  }



public function save_contact_us(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
			 'name'=>'required',
			 'phone'=>'required',
			 'email'=>'required',
			 'subject'=>'required',
			 'message'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            return response()->json(['msg' =>'Some details are missing, Try again!' , 'status' => false]);
        }
	
		try
		{
			
			$result=ContactUsMessage::create([
			 'name'=>$request->name,
			 'mobile'=>$request->phone,
			 'email'=>$request->email,
			 'subject'=>$request->subject,
			 'message'=>$request->message,
			]);

			if($result)
			{
				Session::put(['success'=>"Message successfully send!"]);
				return redirect('/contact');
				//response()->json(['msg' =>'Message successfully send!' , 'status' => true]);
			}
			else
			{
				Session::put(['error'=>"Some details are missing, Please check.!"]);
				return redirect('/contact');
				//return response()->json(['msg' =>'Some details are missing, Please check.' , 'status' => false]);
			}

		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			Session::put(['error'=>$e->getMessage()]);
				return redirect('/contact');
			//return response()->json(['msg' =>'Something wrong, Please check.' , 'status' => false]);
		}
		
  }



}
