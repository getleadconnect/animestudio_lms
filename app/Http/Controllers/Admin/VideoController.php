<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Common\Common;

use App\Models\Center;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Video;
use App\Models\VideoComment;
use App\Models\VideoCompletedStatus;

use Validator;
use DataTables;
use Session;
use Auth;
use DB;

class VideoController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
 	$subj=$chap=collect();
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	
	if(!$crs->isEmpty())
	{$subj=Subject::where('course_id',$crs[0]->id)->where('status',1)->get();}
	
	if(!$subj->isEmpty())
	{$chap=Chapter::where('subject_id',$subj[0]->id)->where('status',1)->get();	}

	return view('admin.videos.video_classes',compact('crs','subj','chap'));
  }	
   
  public function add_videos()
  {
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
    return view('admin.videos.add_videos',compact('crs'));
  }	
  
  
 public function getSubjectsForVideo($course_id)
 {
	$opt=Common::getSubjectsByCourseId($course_id);
	return $opt;
 }
  
  
   public function getChaptersForVideo($subject_id)
 {
	$opt=Common::getChaptersBySubjectId($subject_id);
	return $opt;
 }
 
 

  public function view_comments()
  {
	$subj=[];
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	
	if(!$crs->isEmpty())
	{$subj=Subject::where('course_id',$crs[0]->id)->where('status',1)->get();}

   return view('admin.videos.view_comments',compact('crs','subj'));
  }	
  
  	
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'chapter_id'=>'required',
			 'subject_id'=>'required',
			 'chapter_id'=>'required',
			 'title'=>'required',
			 'video_file'=>'required',
			 'description'=>'required',
			 'explanation'=>'required',
			 'duration'=>'required',
			 'teacher_name'=>'required',
        ]);
	  
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }

		try
		{
			
			$usr_id=Auth::guard('admin')->user()->id;
			//$cid=Auth::guard('admin')->user()->center_id;

			$fname2="";
			
			
			if($request->file('video_file'))
			{ 
				
				$fname2=Storage::disk('spaces')->putFile("video_files",$request->file('video_file'), 'public');
				$fname2=str_replace("video_files/","",$fname2);
			}
			
			$result=Video::create([
			 'course_id'=>$request->course_id,
			 'subject_id'=>$request->subject_id,
			 'chapter_id'=>$request->chapter_id,
			 'title'=>$request->title,
			 'video_file'=>$fname2,
			 'duration'=>$request->duration,
			 'teacher_name'=>$request->teacher_name,
			 'description'=>$request->description,
			 'explanation'=>$request->explanation,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
						
			if($result)
			{
				Session::flash('message', 'success#Video successfully added.');
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
		
		return redirect('add-videos');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getVideosData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','icon','vfile','status'])
                    ->make(true);
        }
	}
		
	public function getVideosData($request)  //view data
	{

		$search=$request->search;
		$course_id=$request->searchCourse;
		$subject_id=$request->searchSubject;
		$chapter_id=$request->searchChapter;
		
		$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=Video::select('videos.*','courses.course_name','subjects.subject_name','chapters.chapter_name','admins.name')
		->leftJoin('admins','videos.added_by','=','admins.id')
		->leftJoin('courses','videos.course_id','=','courses.id')
		->leftJoin('subjects','videos.subject_id','=','subjects.id')
		->leftJoin('chapters','videos.chapter_id','=','chapters.id')
		->where(function($where) use($search)
			    {
					$where->where("videos.title", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%')
					->orWhere("subjects.subject_name", 'like', '%' .$search . '%')
					->orWhere("chapters.chapter_name", 'like', '%' .$search . '%');
				});
		
		if($course_id!="")
		{
			$dts->where('videos.course_id',$course_id);
		}			
		if($subject_id!="")
		{
			$dts->where('videos.subject_id',$subject_id);
		}
		if($chapter_id!="")
		{
			$dts->where('videos.chapter_id',$chapter_id);
		}
					  
		$dats=$dts->orderBy('videos.id','ASC')->get();
		
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
					$uData['chname'] =$r->chapter_name;
					$uData['title'] =$r->title;
					$uData['vfile'] ='<a href="'.config('constants.video_file').$r->video_file.'" target="blank">'.$r->video_file.'</a>';
					$uData['dura'] =$r->duration;
					$uData['tname'] =$r->teacher_name;
					$uData['desc'] =$r->description;
					$uData['expl'] =$r->explanation;
					$uData['status'] =$st;
					$uData['addedby'] =$r->name;
					
										
					$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item edit" href="'.url('edit-video').'/'.$r->id.'" >Edit</a></li>
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
    $vd=Video::where('id',$id)->first();
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	$subj=Subject::where('course_id',$vd->course_id)->where('status',1)->get();	
	$chpt=Chapter::where('subject_id',$vd->subject_id)->where('status',1)->get();	
	return view('admin.videos.edit_video',compact('vd','crs','subj','chpt'));
  }	
		
	public function update_video(Request $request)
	{

	  $validate = Validator::make(request()->all(),[
             'course_id_edit'=>'required',
			 'subject_id_edit'=>'required',
			 'chapter_id_edit'=>'required',
			 'title_edit'=>'required',
			 'description_edit'=>'required',
			 'explanation_edit'=>'required',
			 'duration_edit'=>'required',
			 'teacher_name_edit'=>'required',
        ]);
	  
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }

		try
		{
			
			$fname2=$request->video_file;
			$ex_fname2=$request->video_file;
			
			$id=$request->video_id;
			
		
			if($request->file('video_file_edit'))
			{ 
				$fname2=Storage::disk('spaces')->putFile("video_files",$request->file('video_file_edit'), 'public');
				$fname2=str_replace("video_files/","",$fname2);
				Storage::disk('spaces')->delete("video_files"."/".$ex_fname2);
			}
			
			$new_dat=[
			 'course_id'=>$request->course_id_edit,
			 'subject_id'=>$request->subject_id_edit,
			 'chapter_id'=>$request->chapter_id_edit,
			 'title'=>$request->title_edit,
			 'video_file'=>$fname2,
			 'duration'=>$request->duration_edit,
			 'teacher_name'=>$request->teacher_name_edit,
			 'description'=>$request->description_edit,
			 'explanation'=>$request->explanation_edit,
			];
			
			$result=Video::whereId($id)->update($new_dat);
			
			if($result)
			{
				Session::flash('message', 'success#Video successfully updated.');
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
		
		return redirect('videos');
  }


	
   public function destroy($id)
	{
		$dat=Video::findorfail($id);
		
			if(!empty($dat))
			{
				$res1=VideoComment::where('video_id',$dat->id)->delete();
				$res2=VideoCompletedStatus::where('video_id',$dat->id)->delete();
				Storage::disk('spaces')->delete("video_files"."/".$dat->video_file);
				$dat->delete();
				return response()->json(['msg' =>'Video successfuly removed.!' , 'status' => true]);
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

		$result=Video::where('id',$id)->update($new);

		if($result)
		{
			if($op==1)
				return response()->json(['msg' =>'Video successfully activated!' , 'status' => true]);
			else
				return response()->json(['msg' =>'Video successfully deactivated!' , 'status' => true]);
		}
		else
		{
			return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
		}				

	}
	
	//= VIEW COMMENTS==================================================================================================


  public function view_comment_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getVideoCommentsData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action',])
                    ->make(true);
        }
	}
		
	public function getVideoCommentsData($request)  //view data
	{

		$search=$request->search;
		$course_id=$request->searchCourse;
		$subject_id=$request->searchSubject;
		
		$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=VideoComment::select('video_comments.*','courses.course_name','subjects.subject_name','students.student_name','videos.title')
		->leftJoin('videos','video_comments.video_id','=','videos.id')
		->leftJoin('courses','video_comments.course_id','=','courses.id')
		->leftJoin('subjects','video_comments.subject_id','=','subjects.id')
		->leftJoin('students','video_comments.student_id','=','students.id')
		->where(function($where) use($search)
			    {
					$where->where("videos.title", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%')
					->orWhere("subjects.subject_name", 'like', '%' .$search . '%')
					->orWhere("students.student_name", 'like', '%' .$search . '%');
				});
		
		if($course_id!="")
		{
			$dts->where('video_comments.course_id',$course_id);
		}			
		if($subject_id!="")
		{
			$dts->where('video_comments.subject_id',$subject_id);
		}
							  
		$dats=$dts->orderBy('video_comments.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					
					$uData['id'] = ++$key;
					$uData['cname'] =$r->course_name;
					$uData['sname'] =$r->subject_name;
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
		$dat=VideoComment::findorfail($id);
		
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
