<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Facades\Excel;

use App\Exports\StudentList;
use App\Exports\StudentSubscriptionList;

use App\Models\Center;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\District;
use App\Models\User;
use App\Models\Staff;

use Validator;
use DataTables;
use Session;
use DB;
use Auth;

class ReportController extends Controller
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
    return view('admin.reports.students_report',compact('crs','dist','center'));
  }	

public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getStudentsReportData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
	}
		
	public function getStudentsReportData($request)  //view data
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
					}
					else
					{
						$st='<span class="badge bg-danger">Inactive</span>';
					}
				
					$uData['slno'] = ++$key;
					$uData['id'] = $r->id;
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

			    $data[] = $uData;
			}
        }
		return $data;
	}		

 public function export_student_list($center, $distid)
	{
		 //return Excel::download($export, 'test.xlsx');
        return Excel::download(new StudentList($center, $distid), 'student_list'.'_'.date('Y-m-d').'.'.'xlsx');
    }
//===============================================================================================================


 public function subscription_report()
  {
	$cid=Auth::guard('admin')->user()->center_id;
	$center=Center::where('status',1)->get();	
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	
    return view('admin.reports.subscriptions_report',compact('crs','center'));
  }	
  
  
public function view_subscription_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getSubscriptionsReportData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','cicon'])
                    ->make(true);
        }
	}
		
	public function getSubscriptionsReportData($request)  //view data
	{

		$search=$request->search;
		$center_id=$request->searchCenterId;
		$course_id=$request->searchCourseId;
		
		$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=Subscription::select('subscriptions.*','students.student_name','centers.center_name','courses.course_name')
		->leftJoin('students','subscriptions.student_id','=','students.id')
		->leftJoin('centers','students.center_id','=','centers.id')
		->leftJoin('courses','subscriptions.course_id','=','courses.id')
		
		->where(function($where) use($search)
			    {
					$where->where("students.student_name", 'like', '%' .$search . '%')
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

				$uData['slno'] = ++$key;
				$uData['id'] = $r->student_id;
				$uData['center'] =$r->center_name;
				$uData['sname'] =$r->student_name;
				$uData['cname'] =$r->course_name;
				$uData['rate'] =number_format($r->rate,2);
				$uData['rcode'] =$r->referral_code??"--";
				$uData['rvalue'] =$r->referral_value?number_format($r->referral_value,2):"--";
				$uData['netamt'] =number_format($r->net_amount,2);
				$uData['sdate'] =$r->start_date;
				$uData['edate'] =$r->end_date;

			    $data[] = $uData;
			}
        }
		return $data;
	}	

public function get_course_by_center_id($id)
{
	$opt=Common::getCourseByCenterId($id);
	return $opt;
}


 public function export_subscription_list($center, $crsid)
	{
		 //return Excel::download($export, 'test.xlsx');
        return Excel::download(new StudentSubscriptionList($center, $crsid), 'student_subscription_list'.'_'.date('Y-m-d').'.'.'xlsx');
    }
}
