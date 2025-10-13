<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Center;
use App\Models\Course;
use App\Models\ExamTabHeading;
use App\Models\QuestionPaper;
use App\Models\Question;

use App\Common\Common;

use Validator;
use DataTables;
use Session;
use Auth;

class ModelQpaperController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	return view('admin.model_tests.question_papers',compact('crs'));
  }	
    
  public function get_tab_headings_by_course_id($id)
  {
	  
	  $tabhead=Common::getTabHeadingsByCourseId($id);
	  return $tabhead;
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
			 'question_paper'=>'required',
			 'start_date'=>'required',
			 'duration'=>'required',
			 'description'=>'required',
			 'exp_video'=>'required',
        ]);
	  	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	

		try
		{
			
			$usr_id=Auth::guard('admin')->user()->id;
			
			$fname1="";
			
			if($request->file('exp_video'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("exam_explanation_videos",$request->file('exp_video'), 'public');
				$fname1=str_replace("exam_explanation_videos/","",$fname1);
			}
			
			
			$result=QuestionPaper::create([
			 'free_test'=>$request->free_test,
			 'course_id'=>$request->course_id,
			 'exam_tab_heading_id'=>$request->tab_heading_id,
			 'question_paper_name'=>$request->question_paper,
			 'start_date'=>$request->start_date,
			 'duration'=>$request->duration,
			 'description'=>$request->description,
			 'explanation_video'=>$fname1,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
						 
			if($result)
			{
				return response()->json(['msg' =>'Question paper successfully added!' , 'status' => true]);
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
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getQuestionPapers($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','sdat','evideo','qpaper','status'])
                    ->make(true);
        }
	}
		
	public function getQuestionPapers($request)  //view data
	{

		$search=$request->search;
		$course_id=$request->searchCourseId;
		$tabhead_id=$request->searchTabHead;
		
		$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=QuestionPaper::select('question_papers.*','courses.course_name','exam_tab_headings.tab_heading','admins.name')
		->leftJoin('admins','question_papers.added_by','=','admins.id')
		->leftJoin('courses','question_papers.course_id','=','courses.id')
		->leftJoin('exam_tab_headings','question_papers.exam_tab_heading_id','=','exam_tab_headings.id')
		->where(function($where) use($search)
			    {
					$where->where("question_papers.question_paper_name", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%')
					->orWhere("exam_tab_headings.tab_heading", 'like', '%' .$search . '%');
				});
		
		if($course_id!="" && $tabhead_id=="")
		{
			$dts->where('question_papers.course_id',$course_id);
		}			
		else if($course_id!="" && $tabhead_id!="")
		{
			$dts->where('question_papers.course_id',$course_id)->where('question_papers.exam_tab_heading_id',$tabhead_id);
		}
					  
		$dats=$dts->orderBy('question_papers.id','ASC')->get();
		
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
					$uData['crs'] =$r->course_name??"--";
					$uData['tabh'] =$r->tab_heading??"--";
					
					if($r->free_test==1)
						$uData['qpaper'] =$r->question_paper_name.'<span class="badge bg-info">free</span>';
					else
						$uData['qpaper'] =$r->question_paper_name;
					$uData['desc'] =$r->description;
					$uData['sdat'] =date_create($r->start_date)->format('Y-m-d');
					$uData['dura'] =$r->duration." Minutes";
					$uData['evideo'] ='<a href="'.config('constants.exam_exp_video').$r->explanation_video.'" target="blank">'.$r->explanation_video.'</a>';;
					$uData['status'] =$st;
					$uData['addedby'] =$r->name;
					
				
					$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item edit" href="javascript:void(0)" id="'.$r->id.'"  data-bs-toggle="modal" data-bs-target="#BasicModal2" >Edit</a></li>
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
    $qp=QuestionPaper::where('id',$id)->first();
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	$tabhead=ExamTabHeading::where('course_id',$qp->course_id)->get();
	return view('admin.model_tests.edit_question_paper',compact('qp','crs','tabhead'));
  }	
  
		
  public function update_question_paper(Request $request)
	{

	  $validate = Validator::make(request()->all(),[
			 'question_paper_edit'=>'required',
			 'start_date_edit'=>'required',
			 'duration_edit'=>'required',
			 'description_edit'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            //Session::flash('message', 'danger#Some details are missing, try again.');
			return response()->json(['msg' =>'Some details are missing, try again' , 'status' => false]);
        }
	
		try
		{

			$id=$request->qpaper_id;
			
			$fname1=$request->expl_video;
			$ex_fname1=$request->expl_video;
			
			if($request->file('exp_video_edit'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("exam_explanation_videos",$request->file('exp_video_edit'), 'public');
				$fname1=str_replace("exam_explanation_videos/","",$fname1);
				Storage::disk('spaces')->delete("exam_explanation_videos"."/".$ex_fname1);
			}
	
			$new_dat=[
			 'free_test'=>$request->free_test_edit,
			 'course_id'=>$request->course_id_edit,
			 'exam_tab_heading_id'=>$request->tab_heading_id_edit,
			 'question_paper_name'=>$request->question_paper_edit,
			 'start_date'=>$request->start_date_edit,
			 'duration'=>$request->duration_edit,
			 'description'=>$request->description_edit,
			 'explanation_video'=>$fname1,
			];
			
			$result=QuestionPaper::whereId($id)->update($new_dat);
			
			if($result)
			{
				return response()->json(['msg' =>'Question paper successfully updated!' , 'status' => true]);
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
		$dat=QuestionPaper::findorfail($id);
		
			if(!empty($dat))
			{
				
				Storage::disk('spaces')->delete("exam_explanation_videos"."/".$dat->explanation_video);
				
				$res=Question::where('question_paper_id',$id)->delete();
				$dat->delete();
				return response()->json(['msg' =>'Question paper successfully removed.!' , 'status' => true]);
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

		$result=QuestionPaper::where('id',$id)->update($new);

		if($result)
		{
			if($op==1)
				return response()->json(['msg' =>'Question paper successfully activated!' , 'status' => true]);
			else
				return response()->json(['msg' =>'Question paper successfully deactivated!' , 'status' => true]);
		}
		else
		{
			return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
		}				
	}
	

}
