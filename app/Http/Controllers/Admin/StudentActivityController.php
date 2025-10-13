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
use App\Models\AppUsage;
use App\Models\TestResult;
use App\Models\VideoCompletedStatus;

use Validator;
use DataTables;
use Session;
use DB;
use Auth;
use Carbon\Carbon;

class StudentActivityController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {

	$center=Center::where('status',1)->get();
	$dist=District::where('status',1)->get();		
	return view('admin.students.activity',compact('center','dist'));
  }	
  

public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getStudentsActivityData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
        }
	}
		
	public function getStudentsActivityData($request)  //view data
	{
		$search=$request->search;
		$scenter=$request->searchCenter;
		$sdist=$request->searchDist;
		
		//$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=Student::select('students.*','centers.center_name','districts.district')
		->leftJoin('centers','students.center_id','=','centers.id')
		->leftJoin('districts','students.district_id','=','districts.id')
		->where(function($where) use($search)
			    {
					$where->where("students.student_name", 'like', '%' .$search . '%')
					->orWhere("centers.center_name", 'like', '%' .$search . '%')
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
							  
		$dats=$dts->get()->map(function($q)
		{
			$excnt=TestResult::where('student_id',$q->id)->count();
			$q['exam_attended']=$excnt.' Nos';
			
			$vwcnt=VideoCompletedStatus::where('student_id',$q->id)->count();
			$q['video_watched']=$vwcnt.' Nos' ;
			
			$ausage=AppUsage::where('student_id',$q->id)->pluck('usage_seconds')->first();
			$usage=$q['app_usage']=$ausage??"0";
			$q['app_usage']=$usage.' Seconds';
			return $q;
		});
		
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {

					$uData['id'] = $r->id;
					$uData['center'] =$r->center_name;
					$uData['sname'] =$r->student_name;
					$uData['jdate'] =Carbon::parse($r->created_at)->format('Y-m-d');
					$uData['dist'] =$r->district;
					$uData['excnt'] =$r->exam_attended;
					$uData['vwcnt'] =$r->video_watched;
					$uData['ausage'] =$r->app_usage;
					
					/*$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item btnDel" href="javascript:void(0)"  id="'.$r->id.'">Delete</a></li>
                            </ul>
                        </div>';
					
					$uData['action'] = $dr_btn;*/
															
			    $data[] = $uData;
			}
        }
		return $data;
	}		

  
		
	
		
}
