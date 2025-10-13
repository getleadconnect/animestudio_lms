<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Auth;
use Session;

use App\Models\Student;
use App\Models\User;
use App\Models\Subscription;

use App\Models\VideoCompletedStatus;
use App\Models\TestResult;
use App\Models\Course;

use DB;


class DashboardController extends Controller
{
  
  protected $guard = 'admin';
    
  public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
	{
		$course_cnt=Course::where('status',1)->count();
		$st_cnt=Student::count();
		$sub_cnt = Subscription::select('student_id')->groupBy('student_id')->get()->count();
				
		//---------chart data-----------------------------------
		$st_year=[0,0,0,0,0];
		$stud_count=[0,0,0,0,0];
		$subs_count=[0,0,0,0,0];
		
		$y=0;
		
		$yr=date('Y');
		$yr1=(date('Y')-4);
		
		for($x=$yr1;$x<=$yr;$x++)
		{
			$st_years[$y]=$x;
			$stud_count[$y]=Student::whereYear('created_at',$x)->count();
			$subs_count[$y]=Subscription::select('student_id')->whereYear('created_at',$x)->groupBy('student_id')->get()->count();
			$y++;
		}
		
		$stud_years=implode(',',$st_years);
		$stud_cnt=implode(',',$stud_count);
		$subs_cnt=implode(',',$subs_count);
		//-----------------PIE chart ----------------------------
		
		
		$csdat=Subscription::select('subscriptions.course_id','courses.course_name', DB::raw('COUNT(*) as cs_count'))
			  ->join('courses','subscriptions.course_id','=','courses.id')
			  ->groupBy('subscriptions.course_id','courses.course_name')
			  ->whereYear('subscriptions.created_at',date('Y'))
			  ->orderBy('cs_count','DESC')
			  ->take(10)->get();

		$crs_lbl=[];
		$crs_cnt=[];
		
		foreach($csdat as $key=>$r)
		{
			$crs_lbl[$key]=$r->course_name."(".$r->cs_count.")";
			$crs_cnt[$key]=$r->cs_count;
		}
		
		$cr_lbl=implode(',',$crs_lbl);
		$cr_cnt=implode(',',$crs_cnt);
			
			
		$data['st_cnt']=$st_cnt;
		$data['sub_cnt']=$sub_cnt;
		$data['stud_years']=$stud_years;
		$data['stud_cnt']=$stud_cnt;
		$data['subs_cnt']=$subs_cnt;
		$data['cr_lbl']=$cr_lbl;
		$data['cr_cnt']=$cr_cnt;
		$data['course_cnt']=$course_cnt;
		
		//-------------------------------------------------------
		//return view('admin.dashboard.dashboard',compact('st_cnt','sub_cnt','stud_years','stud_cnt','subs_cnt','cr_lbl','cr_cnt','crs_cnt'));
		return view('admin.dashboard.dashboard',compact('data'));
	}
	

	
	public function get_my_activities($id) 
	{
		//$stid=$request->student_id;
		$data['video_attended']=0;
		$data['test_completed']=0;
		
		try
		{		
		  $vcs=VideoCompletedStatus::where('student_id',$id)->count();
		  $trc=TestResult::where('student_id',$id)->count();
			
		  $data['video_attended']=$vcs;
		  $data['test_completed']=$trc;
		  
		}
		catch(\Exception $e)
		{
		}	

		return $data;
	}

	
}
