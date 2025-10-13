<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Center;
use App\Models\User;
use App\Models\Student;

use Validator;
use DataTables;
use Session;
use Auth;
use DB;

class UserController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
 	$center=Center::where('status',1)->get();	
	//dd(Auth::guard('admin')->user()->center_id);
	
	return view('admin.users.users',compact('center'));
  }	
  	
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'center_id'=>'required',
			 'staff_name'=>'required',
			 'address'=>'required',
			 'email'=>'required',
			 'mobile'=>'required',
			 'reff_code'=>'required',
			 'percentage'=>'required',
        ]);
	  
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }

		try
		{
			
			$usr_id=Auth::guard('admin')->user()->id;
			$cid=Auth::guard('admin')->user()->center_id;

			$result=Staff::create([
			 'center_id'=>$request->center_id,
			 'staff_name'=>$request->staff_name,
			 'address'=>$request->address,
			 'email'=>$request->email,
			 'mobile'=>$request->mobile,
			 'reff_code'=>$request->reff_code,
			 'percentage'=>$request->percentage,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
						
			if($result)
			{
				Session::flash('message', 'success#Staff details successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Some details are missing. try again');
			}
			
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			Session::flash('message', 'danger#Something wrong, Try again.');
		}
		
		return redirect('staffs');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getUserData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
	}
		
	public function getUserData($request)  //view data
	{

		$search=$request->search;
		$center_id=$request->searchCenterId;
		
		if($center_id=="")
		{
			$center_id=Auth::guard('admin')->user()->center_id;
		}
		
		$dts=User::select('users.*','students.student_name','centers.center_name')
		->leftJoin('students','users.student_id','=','students.id')
		->leftJoin('centers','students.center_id','=','centers.id')
		->where(function($where) use($search)
			    {
					$where->where("users.email", 'like', '%' .$search . '%')
					->orWhere("users.mobile", 'like', '%' .$search . '%')
					->orWhere("students.student_name", 'like', '%' .$search . '%');
				});
		
		if($center_id!="")
		{
			$dts->where('students.center_id',$center_id);
		}			
					  
		$dats=$dts->orderBy('users.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					if($r->status==1)
					{
						$st='<span class="badge bg-success">Active</span>';
						$btns='<a href="javascript:void(0)" id="'.$r->student_id.'" class="btnDeact dropdown-item">Deactivate </a>';
					}
					else
					{
						$st='<span class="badge bg-danger">Inactive</span>';
					    $btns='<a href="javascript:void(0)" id="'.$r->id.'" class="btnAct dropdown-item">Activate </a>';
					}
				
					$uData['id'] = ++$key.$center_id;
					$uData['center'] =$r->center_name;
					$uData['sname'] =$r->student_name;
					$uData['email'] =$r->email;
					$uData['mob'] =$r->mobile;
					$uData['fcmt'] =$r->fcm_token;
					$uData['status'] =$st;
	
					$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li>'.$btns.'</li>
                            </ul>
                        </div>';

					$uData['action'] = $dr_btn;
					

			    $data[] = $uData;
			}
        }
		return $data;
	}		

 	
	public function activate_deactivate($op,$stud_id)
	{
		if($op==1)
		{
		   $new=['status'=>1];
		}
		else
		{	
		   $new=['status'=>0];
		}
				
		$result=Student::where('id',$stud_id)->update($new);
		$result=User::where('student_id',$stud_id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Staff details successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Staff details successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}
	
	
}
