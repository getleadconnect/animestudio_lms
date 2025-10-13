<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Course;
use App\Models\Subject;
use App\Models\LiveClass;
use App\Common\Common;

use Validator;
use DataTables;
use Session;
use Auth;

class LiveClassController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$subj=[];
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	if(!$crs->isEmpty())
	{
		$subj=Subject::where('course_id',$crs[0]->id)->get();
	}
    return view('admin.live_class.live_class',compact('crs','subj'));
  }	
 
 public function getLiveClassSubjectsByCourseId($id)
 {
	/*$subj=Subject::where('course_id',$id)->get();
	$opt='<option value="">--select--</option>';
	if(!$subj->isEmpty())
	{
		foreach($subj as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->subject_name.'</option>';
		}
	}
*/

$opt=Common::getSubjectsByCourseId($id);
	return $opt;
 }
 
  public function pdf_questions()
  {
    return view('admin.model_tests.pdf_questions');
  }	
 
 
 public function prepare_questions()
  {
    return view('admin.model_tests.prepare_questions');
  }	
 
 
  public function view_questions()
  {
    return view('admin.model_tests.view_qpaper_questions');
  }	
 
 
 
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'course_id'=>'required',
			 'subject_id'=>'required',
			 'title'=>'required',
			 'conducted_by'=>'required',
			 'description'=>'required',
			 'class_link'=>'required',
			 'class_icon'=>'required',
			 'start_date'=>'required',
			 'start_time'=>'required',
			 'end_time'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{
			
			$fname1="";
			
			$usr_id=Auth::guard('admin')->user()->id;
			
			if($request->file('class_icon'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("live_class_icons",$request->file('class_icon'), 'public');
				$fname1=str_replace("live_class_icons/","",$fname1);
			}

			$result=LiveClass::create([
			 'course_id'=>$request->course_id,
			 'subject_id'=>$request->subject_id,
			 'conducted_by'=>$request->conducted_by,
			 'title'=>$request->title,
			 'description'=>$request->description,
			 'class_icon'=>$fname1,
			 'class_link'=>$request->class_link,
			 'start_date'=>$request->start_date,
			 'start_time'=>$request->start_time,
			 'end_time'=>$request->end_time,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
			
			if($result)
			{
				Session::flash('message', 'success#Live class successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Some details are missing, Please check.');
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			Session::flash('message', 'danger#'.$e->getMessage());
		}
		
		return redirect('live-classes');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getLiveClassData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','cicon'])
                    ->make(true);
        }
	}
		
	public function getLiveClassData($request)  //view data
	{

		$search=$request->search;
		$subject_id=$request->searchSubject;
		$course_id=$request->searchCourse;
		
		$dts=LiveClass::select('live_classes.*','courses.course_name','subjects.subject_name','admins.name')
		->leftJoin('courses','live_classes.course_id','=','courses.id')
		->leftJoin('subjects','live_classes.subject_id','=','subjects.id')
		->leftJoin('admins','subjects.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("live_classes.title", 'like', '%' .$search . '%')
					->orWhere("live_classes.description", 'like', '%' .$search . '%')
					->orWhere("live_classes.start_date", 'like', '%' .$search . '%')
					->orWhere("subjects.subject_name", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%');
				});
				
		if($course_id!="")
		{
			$dts->where('live_classes.course_id',$course_id);
		}		
				
		if($subject_id!="")
		{
			$dts->where('live_classes.subject_id',$subject_id);
		}		
							  
		$dats=$dts->orderBy('live_classes.id','ASC')->get();

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
					$uData['cname'] =$r->course_name;
					$uData['sname'] =$r->subject_name;
					$uData['title'] =$r->title;
					$uData['cby'] =$r->conducted_by;
					$uData['desc'] =$r->description;
					$uData['cicon'] ="<img src='".config('constants.live_class_icon').$r->class_icon."' style='width:70px;'>";
					$uData['clink'] =$r->class_link;
					$uData['sdate'] =$r->start_date;
					$uData['stime'] =$r->start_time;
					$uData['etime'] =$r->end_time;
					$uData['status'] =$st;
					$uData['addedby'] =$r->name;

										
					$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item edit" href="javascript:void(0)" id="'.$r->id.'" data-bs-toggle="modal" data-bs-target="#BasicModal2" >Edit</a></li>
							  <li><a class="dropdown-item btnDel" href="javascript:void(0)" id="'.$r->id.'" >Delete</a></li>
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
    $cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	$lc=LiveClass::where('id',$id)->first();		
	$subj=Subject::where('course_id',$lc->course_id)->get();
	return view('admin.live_class.edit_live_class',compact('crs','subj','lc'));
  }	

		
	public function update_live_class(Request $request)
	{

	  $validate = Validator::make(request()->all(),[
             'course_id_edit'=>'required',
			 'subject_id_edit'=>'required',
			 'conducted_by_edit'=>'required',
			 'title_edit'=>'required',
			 'description_edit'=>'required',
			 'class_link_edit'=>'required',
			 'start_date_edit'=>'required',
			 'start_time_edit'=>'required',
			 'end_time_edit'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{
			
			$fname1=$request->class_icon;
			$ex_fname1=$request->class_icon;
			
			$id=$request->live_class_id;

			if($request->file('class_icon_edit'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("live_class_icons",$request->file('class_icon_edit'), 'public');
				$fname1=str_replace("live_class_icons/","",$fname1);
				Storage::disk('spaces')->delete("live_class_icons"."/".$ex_fname1);
			}

			$new_dat=[
			 'course_id'=>$request->course_id_edit,
			 'subject_id'=>$request->subject_id_edit,
			 'conducted_by'=>$request->conducted_by_edit,
			 'title'=>$request->title_edit,
			 'description'=>$request->description_edit,
			 'class_icon'=>$fname1,
			 'class_link'=>$request->class_link_edit,
			 'start_date'=>$request->start_date_edit,
			 'start_time'=>$request->start_time_edit,
			 'end_time'=>$request->end_time_edit,
			 ];
			
			$result=LiveClass::whereId($id)->update($new_dat);
			
			if($result)
			{
				Session::flash('message', 'success#Live class successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Some details are missing, Please check.');
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			Session::flash('message', 'danger#Something wrong, Try again.');
		}
		
		return redirect('live-classes');
  }


	
   public function destroy($id)
	{
		$dat=LiveClass::findorfail($id);
		
			if(!empty($dat))
			{
				$sfile=$dat->class_icon;
				
				$dat->delete();

				Storage::disk('spaces')->delete("live_class_icons"."/".$sfile);
				
				return response()->json(['msg' =>'Live class successfully removed.!' , 'status' => true]);
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

		$result=LiveClass::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'LiveClass successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'LiveClass successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}

}
