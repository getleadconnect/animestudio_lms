<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Center;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Chapter;

use Validator;
use DataTables;
use Session;
use Auth;

class ChapterController extends Controller
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
	if(!$crs->isEmpty()){ 
		$subj=Subject::where('course_id',$crs[0]->id)->get();
	}
	return view('admin.chapter.chapters',compact('crs','subj'));
  }	
 
 public function getSubjectsByCourseId($id)
 {
	$subj=Subject::where('course_id',$id)->get();
	$opt='<option value="">--select--</option>';
	if(!$subj->isEmpty())
	{
		foreach($subj as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->subject_name.'</option>';
		}
	}

	return $opt;
 }
 
 
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'chapter_name'=>'required',
			 'description'=>'required',
			 'chapter_icon'=>'required',
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
			
			if($request->file('chapter_icon'))
			{ 
				
				$fname1=Storage::disk('spaces')->putFile("chapter_icons",$request->file('chapter_icon'), 'public');
				$fname1=str_replace("chapter_icons/","",$fname1);
			}

			$result=Chapter::create([
			 'course_id'=>$request->course_id,
			 'subject_id'=>$request->subject_id,
			 'chapter_name'=>$request->chapter_name,
			 'description'=>$request->description,
			 'chapter_icon'=>$fname1,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
			
			if($result)
			{
				Session::flash('message', 'success#Chapter/Tpoics successfully added.');
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
		
		return redirect('chapters');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getChapterData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','cicon'])
                    ->make(true);
        }
	}
		
	public function getChapterData($request)  //view data
	{

		$search=$request->search;
		$scourse=$request->searchCourse;
		$ssubject=$request->searchSubject;
		
		$dts=Chapter::select('chapters.*','subjects.subject_name','courses.course_name','admins.name')
		->leftJoin('courses','chapters.course_id','=','courses.id')
		->leftJoin('subjects','chapters.subject_id','=','subjects.id')
		->leftJoin('admins','chapters.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("chapters.chapter_name", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%')
					->orWhere("subjects.subject_name", 'like', '%' .$search . '%');
					
				});
				
		
		if($scourse!="")
		{
			$dts->where('chapters.course_id',$scourse);
		}
		
		if($ssubject!="")
		{
			$dts->where('chapters.subject_id',$ssubject);
		}		
				
		$dats=$dts->orderBy('chapters.id','ASC')->get();

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
					$uData['chapter'] =$r->chapter_name;
					$uData['cicon'] ="<img src='".config('constants.chapter_icon').$r->chapter_icon."' style='width:70px;'>";
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
	$ch=Chapter::where('id',$id)->first();
	$subj=Subject::where('course_id',$ch->course_id)->get();
	return view('admin.chapter.edit_chapter',compact('crs','subj','ch'));
  }	

		
	public function update_chapter(Request $request)
	{

	  $validate = Validator::make(request()->all(),[
             'chapter_name_edit'=>'required',
			 'description_edit'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{
			
			$fname1=$request->chapter_icon;
			$ex_fname1=$request->chapter_icon;
			
			$id=$request->chapter_id;

			if($request->file('chapter_icon_edit'))
			{ 
				
				$fname1=Storage::disk('spaces')->putFile("chapter_icons",$request->file('chapter_icon_edit'), 'public');
				$fname1=str_replace("chapter_icons/","",$fname1);
				Storage::disk('spaces')->delete("chapter_icons"."/".$ex_fname1);
			}

			$new_dat=[
			 'course_id'=>$request->course_id_edit,
			 'subject_id'=>$request->subject_id_edit,
			 'chapter_name'=>$request->chapter_name_edit,
			 'description'=>$request->description_edit,
			 'chapter_icon'=>$fname1,
			 ];
			
			$result=Chapter::whereId($id)->update($new_dat);
			
			if($result)
			{
				Session::flash('message', 'success#Chapter successfully updated.');
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
		
		return redirect('chapters');
  }


	
   public function destroy($id)
	{
		$dat=Chapter::findorfail($id);
		
			if(!empty($dat))
			{
				$cfile=$dat->chapter_icon;
				
				$dat->delete();

				Storage::disk('spaces')->delete("chapter_icons"."/".$cfile);
				
				return response()->json(['msg' =>'Chapter successfuly removed.!' , 'status' => true]);
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

		$result=Chapter::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Chapter successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Chapter successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}
	
	
}
