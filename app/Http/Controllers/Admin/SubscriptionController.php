<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Center;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subscription;

use Validator;
use DataTables;
use Session;
use Auth;

class SubscriptionController extends Controller
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
    return view('admin.students.subscriptions',compact('crs','center'));
  }	
  
   public function store(Request $request)
	{

	}

public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getSubscriptionsData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','cicon'])
                    ->make(true);
        }
	}
		
	public function getSubscriptionsData($request)  //view data
	{

		$search=$request->search;
		$center_id=$request->searchCenterId;
		$course_id=$request->searchCourseId;
		
		$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=Subscription::select('subscriptions.*','students.student_name','students.mobile','centers.center_name','courses.course_name')
		->leftJoin('students','subscriptions.student_id','=','students.id')
		->leftJoin('centers','students.center_id','=','centers.id')
		->leftJoin('courses','subscriptions.course_id','=','courses.id')
		
		->where(function($where) use($search)
			    {
					$where->where("students.student_name", 'like', '%' .$search . '%')
					->orWhere("students.mobile", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%');
				});
		
		if($center_id!="" and $course_id!="")
		{
			$dts->where('students.center_id',$center_id)->where('subscriptions.course_id',$course_id);
		}	
		else if($center_id!="" and $course_id=="")
		{
			$dts->where('students.center_id',$center_id);
		}	
		elseif($center_id=="" and $course_id!="")
		{
			$dts->where('courses.id',$course_id);
		}				
					  
		$dats=$dts->orderBy('subscriptions.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				
				if($r->status==1)
				$st='<span class="badge bg-success">Active</span>';
				else
				$st='<span class="badge bg-danger">Inactive</span>';
								
				$uData['id'] = $r->id;
				$uData['center'] =$r->center_name;
				$uData['sname'] =$r->student_name;
				$uData['mob'] =$r->mobile;
				$uData['cname'] =$r->course_name;
				$uData['rate'] =number_format($r->rate,2);
				$uData['rcode'] =$r->referral_code??"--";
				$uData['rvalue'] =$r->referral_value?number_format($r->referral_value,2):"--";
				$uData['netamt'] =number_format($r->net_amount,2);
				$uData['sdate'] =$r->start_date;
				$uData['edate'] =$r->end_date;
				$uData['status'] =$st;

													
				
				$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item btnDel" href="javascript:void(0)" id="'.$r->id.'" >Delete</a></li>';
							  
					if(Session::get('admin_role_id')==1)  //super admin
					{
						$dr_btn.='<li><a class="dropdown-item renew" href="javascript:void(0)" id="'.$r->id.'" data-bs-toggle="modal" data-bs-target="#BasicModal1"  >Re-New Subscription</a></li>';
					}
					
					$dr_btn.='</ul>
                        </div>';

					$uData['action'] = $dr_btn;
				
				

			    $data[] = $uData;
			}
        }
		return $data;
	}	

	
  public function destroy($id)
	{
		$dat=Subscription::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'Subscription successfully removed.!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				
	}


 public function edit_subscription_period($id)
	{
		$dat=Subscription::select('subscriptions.*','students.student_name','students.mobile')
		->join('students','subscriptions.student_id','students.id')
		->where('subscriptions.id',$id)->first();
		
		return view('admin.students.renew_subscriptions',compact('dat'));
		
	}	

public function update_subscription_period(Request $request)
  {
	   $validate = Validator::make(request()->all(),[
             'start_date_new'=>'required',
			 'end_date_new'=>'required',
        ]);
		
		if ($validate->fails())
        {
            return response()->json(['msg' =>'Details are missing, Please check.' , 'status' => false]);
        }
		else
		{
			try
			{
				$id=$request->subscription_id;
				
				$new_dat=[
				 'start_date'=>$request->start_date_new,
				 'end_date'=>$request->end_date_new,
				];
				
				$result=Subscription::where('id',$id)->update($new_dat);
		 
				if($result)
				{
					return response()->json(['msg' =>'Subscription successfully renewed!' , 'status' => true]);
				}
				else
				{
					return response()->json(['msg' =>'Details are missing, Please check.' , 'status' => false]);
				}
				
			}
			catch(\Exception $e)
			{
				\Log::info($e->getMessage());
				return response()->json(['msg' =>'Something wrong, Try again.' , 'status' => false]);
			}
		}
		//return redirect('students');
  }






}
