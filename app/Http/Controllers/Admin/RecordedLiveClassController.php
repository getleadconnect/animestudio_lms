<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Center;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseType;
use App\Models\RecordedLiveClass;
use App\Models\RecordedVideoComment;

use Validator;
use DataTables;
use Session;
use Auth;

class RecordedLiveClassController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }
  
  public function index()
  {
   $cid=Auth::guard('admin')->user()->center_id;
   $crs=Course::where('center_id',$cid)->where('status',1)->get();
   return view('admin.recorded_live_class.recorded_live_classes',compact('crs'));
  }	
     
  public function recorded_video_comments()
  {
	$subj=[];
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	
   return view('admin.recorded_live_class.recorded_live_class_comments',compact('crs'));
  }	
   

  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'course_id'=>'required',
			 'title'=>'required',
			 'description'=>'required',
			 'class_icon'=>'required',
			 'video_file'=>'required',
			 'duration'=>'required',
			 'class_by'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
			Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{
			
			$fname1="";
			$fname2="";
			
			$usr_id=Auth::guard('admin')->user()->id;
			
			if($request->file('class_icon'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("recorded_classes",$request->file('class_icon'), 'public');
				$fname1=str_replace("recorded_classes/","",$fname1);
			}

			if($request->file('video_file'))
			{ 
				$fname2=Storage::disk('spaces')->putFile("recorded_classes",$request->file('video_file'), 'public');
				$fname2=str_replace("recorded_classes/","",$fname2);
			}

			$result=RecordedLiveClass::create([
			 'course_id'=>$request->course_id,
			 'title'=>$request->title,
			 'description'=>$request->description,
			 'class_icon'=>$fname1,
			 'video_file'=>$fname2,
			 'duration'=>$request->duration,
			 'class_by'=>$request->class_by,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
			
			if($result)
			{
				Session::flash('message', 'success#Recorded class successfully added.');
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
		
		return redirect('recorded-live-classes');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getRecordedLiveClassData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','cicon','vfile'])
                    ->make(true);
        }
	}
		
	public function getRecordedLiveClassData($request)  //view data
	{

		$search=$request->search;
		$search_course=$request->searchCourse;
				
		$dts=RecordedLiveClass::select('recorded_live_classes.*','courses.course_name','admins.name')
		->leftJoin('courses','recorded_live_classes.course_id','=','courses.id')
		->leftJoin('admins','courses.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("recorded_live_classes.title", 'like', '%' .$search . '%')
					->orWhere("recorded_live_classes.description", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%');
				});
		

		if($search_course!="")
		{
			$dts->where('course_id',$search_course);
		}
		
		$dats=$dts->orderBy('recorded_live_classes.id','ASC')->get();

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
			
				$vf=str_replace('recorded_classes/',"",$r->video_file);
				
				$uData['id'] = ++$key;
				$uData['cname'] =$r->course_name;
				$uData['title'] =$r->title;
				$uData['desc'] =$r->description;
				$uData['cicon'] ="<img src='".config('constants.recorded_class').$r->class_icon."' style='width:70px;'>";
				$uData['vfile'] ='<a href="'.config('constants.recorded_class').$r->video_file.'" target="blank">'.$vf.'</a>';
				$uData['dura'] =$r->duration;
				$uData['cby'] =$r->class_by;
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
    $rlc=RecordedLiveClass::whereId($id)->first();
	$cid=Auth::guard('admin')->user()->center_id;
    $crs=Course::where('center_id',$cid)->where('status',1)->get();
    return view('admin.recorded_live_class.edit_recorded_live_class',compact('crs','rlc'));
  }	

  public function update_recorded_live_class(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'course_id_edit'=>'required',
			 'title_edit'=>'required',
			 'description_edit'=>'required',
			 'duration_edit'=>'required',
			 'class_by_edit'=>'required',
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
			$fname2=$request->video_file;
			$ex_fname2=$request->video_file;
			
			
						
			if($request->file('class_icon_edit'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("recorded_classes",$request->file('class_icon_edit'), 'public');
				$fname1=str_replace("recorded_classes/","",$fname1);
				Storage::disk('spaces')->delete("recorded_classes/".$ex_fname1);
			}

			if($request->file('video_file_edit'))
			{ 
				$fname2=Storage::disk('spaces')->putFile("recorded_classes",$request->file('video_file_edit'), 'public');
				$fname2=str_replace("recorded_classes/","",$fname2);
				Storage::disk('spaces')->delete("recorded_classes/".$ex_fname2);
			}
			
			$usr_id=Auth::guard('admin')->user()->id;
			$id=$request->rlclass_id;
			
			$new_dat=[
			 'course_id'=>$request->course_id_edit,
			 'title'=>$request->title_edit,
			 'description'=>$request->description_edit,
			 'class_icon'=>$fname1,
			 'video_file'=>$fname2,
			 'duration'=>$request->duration_edit,
			 'class_by'=>$request->class_by_edit,
			 'status'=>1,
			 'added_by'=>$usr_id
			];
			
			$result=RecordedLiveClass::where('id',$id)->update($new_dat);
			
			if($result)
			{
				Session::flash('message', 'success#Recorded class successfully updated.');
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
		
		return redirect('recorded-live-classes');
  }


   public function destroy($id)
	{
		$dat=RecordedLiveClass::findorfail($id);
		
			if(!empty($dat))
			{
				$cfile=$dat->class_icon;
				$vfile=$dat->video_file;

				$dat->delete();

				Storage::disk('spaces')->delete("recorded_classes".'/'.$cfile);
				Storage::disk('spaces')->delete("recorded_classes".'/'.$vfile);
				
				return response()->json(['msg' =>'Recorded class successfully removed.!' , 'status' => true]);
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

		$result=RecordedLiveClass::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Recorded class successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Recorded class successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}


//= VIEW COMMENTS==================================================================================================


  public function recorded_video_comment_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getRecordedVideoCommentsData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action',])
                    ->make(true);
        }
	}
		
	public function getRecordedVideoCommentsData($request)  //view data
	{

		$search=$request->search;
		$course_id=$request->searchCourse;
		
		$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=RecordedVideoComment::select('recorded_video_comments.*','courses.course_name','students.student_name','recorded_live_classes.title')
		->leftJoin('recorded_live_classes','recorded_video_comments.recorded_live_class_id','=','recorded_live_classes.id')
		->leftJoin('courses','recorded_video_comments.course_id','=','courses.id')
		->leftJoin('students','recorded_video_comments.student_id','=','students.id')
		->where(function($where) use($search)
			    {
					$where->where("recorded_live_classes.title", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%')
					->orWhere("students.student_name", 'like', '%' .$search . '%');
				});
		
		if($course_id!="")
		{
			$dts->where('recorded_video_comments.course_id',$course_id);
		}			
							  
		$dats=$dts->orderBy('recorded_video_comments.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					
					$uData['id'] = ++$key;
					$uData['cname'] =$r->course_name;
					$uData['stname'] =$r->student_name;
					$uData['vtitle'] =$r->title;
					$uData['comnt'] =$r->comments;
					
					$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></div>
                            <ul class="dropdown-menu">
                    		  <li><a class="dropdown-item btnDel" href="javascript:void(0)" id="'.$r->id.'" >Delete</a></li>
                            </ul>
                        </div>';

				$uData['action'] = $dr_btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	
   public function destroy_comment($id)
	{
		$dat=RecordedVideoComment::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'Video comment successfuly removed.!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				
	}













}

