<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Center;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\District;
use App\Models\User;
use App\Models\StudentDevice;

use Validator;
use DataTables;
use Session;
use DB;
use Auth;

class StudentController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$cid=Auth::guard('admin')->user()->center_id;
	$center=Center::where('status',1)->get();	
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	$dist=District::where('status',1)->get();	
    return view('admin.students.students',compact('crs','dist','center'));
  }	
    
  public function activity()
  {
    return view('admin.students.activity');
  }	
  
	
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'student_name'=>'required',
			 'dob'=>'required',
			 'district'=>'required',
			 'place'=>'required',
			 'email'=>'required',
			 'mobile'=>'required',
        ]);
	  
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		$result="";
		DB::beginTransaction();
		
		try
		{
			
			$scnt=Student::where('mobile',$request->mobile)->count();
			if($scnt>0)
			{
				return response()->json(['msg' =>'Mobile already exists, try again.' , 'status' => false]);
			}
			else
			{
			
				if($request->has('referral_code') and $request->referral_code!="")
					{
						$sta_id=Staff::where('referral_code',Str::upper($request->referral_code))->pluck('id')->first();
					}
					else
					{
						$sta_id=null;
					}
						
				
				$usr_id=Auth::guard('admin')->user()->id;
				$cid=Auth::guard('admin')->user()->center_id;
				
				$result=Student::create([
				 'center_id'=>$cid,
				 'student_name'=>$request->student_name,
				 'date_of_birth'=>$request->dob,
				 'district_id'=>$request->district,
				 'place'=>$request->place,
				 'email'=>$request->email,
				 'mobile'=>$request->mobile,
				 'referral_code'=>$request->referral_code??"--",
				 'status'=>1,
				 'added_by'=>$usr_id
				]);
							
				$stid=$result->id;
				
				$res1=Subscription::create([
				 'course_id'=>$request->course_id,
				 'student_id'=>$stid,
				 'rate'=>$request->fee,
				 'referral_code'=>$request->discount,
				 'referral_value'=>$request->referral_value,
				 'net_amount'=>$request->net_amount,
				 'start_date'=>$request->start_date,
				 'end_date'=>$request->end_date,
				 'staff_id'=>$sta_id,
				 'status'=>1,
				]);
							
				$res2=User::create([
				 'name'=>$request->student_name,
				 'student_id'=>$stid,
				 'mobile'=>$request->mobile,
				 'email'=>$request->email,
				 'password'=>Hash::make('12345'),
				 'status'=>1,
				]);
							
				DB::commit();
				 
				if($result)
				{
					return response()->json(['msg' =>'Student details successfully added!' , 'status' => true]);
				}
				else
				{
					return response()->json(['msg' =>'Some details are missing, Please check.' , 'status' => false]);
				}
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			DB::rollback();
			return response()->json(['msg' =>'Something wrong, Try again.' , 'status' => false]);
		}
		
		//return redirect('students');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getStudentsData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
	}
		
	public function getStudentsData($request)  //view data
	{
		$search=$request->search;
		$scenter=$request->searchCenter;
		$sdist=$request->searchDist;
		
		//$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=Student::select('students.*','centers.center_name','staffs.staff_name','districts.district','admins.name')
		->leftJoin('admins','students.added_by','=','admins.id')
		->leftJoin('centers','students.center_id','=','centers.id')
		->leftJoin('staffs','students.staff_id','=','staffs.id')
		->leftJoin('districts','students.district_id','=','districts.id')
		->where(function($where) use($search)
			    {
					$where->where("students.student_name", 'like', '%' .$search . '%')
					->orWhere("students.place", 'like', '%' .$search . '%')
					->orWhere("districts.district", 'like', '%' .$search . '%');
				});
		
		if($scenter!="")
		{
			$dts->where('students.center_id',$scenter);
		}
		
		if($sdist!="")
		{
			$dts->where('students.district_id',$sdist);
		}
							  
		$dats=$dts->orderBy('students.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					if($r->status==1)
					{
						$st='<span class="badge bg-success">Active</span>';
						$btns='<a href="javascript:void(0)" id="'.$r->id.'" class="btnDeact dropdown-item">Deactivate </a>';
					}
					else
					{
						$st='<span class="badge bg-danger">Inactive</span>';
					 	$btns='<a href="javascript:void(0)" id="'.$r->id.'" class="btnAct dropdown-item">Activate </a>';
					}
				
					$uData['id'] = ++$key;
					$uData['center'] =$r->center_name;
					$uData['sname'] =$r->student_name;
					$uData['dob'] =$r->date_of_birth;
					$uData['dist'] =$r->district;
					$uData['place'] =$r->place;
					$uData['email'] =$r->email;
					$uData['mobile'] =$r->mobile;
					$uData['refby'] =$r->staff_name??"--";
					$uData['status'] =$st;
					$uData['addedby'] =$r->name;

					$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item edit" href="javascript:void(0)" id="'.$r->id.'" data-bs-toggle="modal" data-bs-target="#BasicModal2" >Edit</a></li>
                              <li><a class="dropdown-item btnDel" href="javascript:void(0)"  id="'.$r->id.'">Delete</a></li>
							  <li>'.$btns.'</li>
                            </ul>
                        </div>';
					
					$uData['action'] = $dr_btn;
										
			    $data[] = $uData;
			}
        }
		return $data;
	}		

  public function edit($id)
  {
    $st=Student::where('id',$id)->first();
	$dist=District::where('status',1)->get();
	return view('admin.students.edit_student',compact('st','dist'));
  }	
		
	public function update_student(Request $request)
	{

	  $validate = Validator::make(request()->all(),[
             'student_name_edit'=>'required',
			 'dob_edit'=>'required',
			 'district_edit'=>'required',
			 'place_edit'=>'required',
			 'email_edit'=>'required',
			 'mobile_edit'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{

			$id=$request->student_id;
			
			$new_dat=[
			 'student_name'=>$request->student_name_edit,
			 'date_of_birth'=>$request->dob_edit,
			 'district_id'=>$request->district_edit,
			 'place'=>$request->place_edit,
			 'email'=>$request->email_edit,
			 'mobile'=>$request->mobile_edit,
			];
			 
			$new_dat1=[
			  'email'=>$request->email_edit,
			  'mobile'=>$request->mobile_edit,
			 ];
			
			$result=Student::whereId($id)->update($new_dat);
			$res=User::whereId($id)->update($new_dat1);
			
			if($result)
			{
				return response()->json(['msg' =>'Student details successfully updated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Some details are missing, Please check!' , 'status' => false]);
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['msg' =>'Something wrong, Try again.' , 'status' => false]);
		}
			
		//return redirect('students');
  }

	
   public function destroy($id)
	{
		$dat=Student::findorfail($id);
		
			if(!empty($dat))
			{
				$res1=User::where('student_id',$id)->delete();
				$res2=StudentDevice::where('student_id',$id)->delete();
				$res3=Subscription::where('student_id',$id)->delete();
				
				$dat->delete();
				
				return response()->json(['msg' =>'Student details successfuly removed.!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				
	}
		
	
	public function activate_deactivate($op,$id)
	{
		if($op==1)
		{
		   $new=['status'=>1];
		}
		else
		{	
		   $new=['status'=>0];
		}

		$result=Student::where('id',$id)->update($new);
		$res=User::where('student_id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Student details successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Student details successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}
	
	public function getCourseFee($id)
	{
		$res=Course::whereId($id)->first();
		return response()->json(['data' =>$res, 'status' => true]);
	}
	
		
}
