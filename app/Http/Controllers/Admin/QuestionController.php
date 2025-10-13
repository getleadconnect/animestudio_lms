<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Course;
use App\Models\QbankSubject;
use App\Models\QbankQuestion;
use App\Models\QuestionPaper;
use App\Models\Question;

use App\Common\Common;

use Validator;
use DataTables;
use Session;
use Auth;

class QuestionController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
		
	return view('admin.model_tests.view_qpaper_questions',compact('crs'));
  }	
 
 
public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getQpaperQuestions($request);

			return DataTables::of($data)
				->addIndexColumn()
				->rawColumns(['action','status','quest'])
				->make(true);
        }
	}
	
	
public function getQpaperQuestions($request)  //view data
	{

		$search=$request->search;

		$qpaper_id=$request->searchQpaperId;
				
		$dts=Question::select('questions.*','question_papers.question_paper_name','qbank_subjects.subject_name')
		->leftJoin('question_papers','questions.question_paper_id','=','question_papers.id')
		->leftJoin('qbank_subjects','questions.qbank_subject_id','=','qbank_subjects.id')
		->where(function($where) use($search)
			    {
					$where->where("questions.question", 'like', '%' .$search . '%')
					->orWhere("questions.question_type", 'like', '%' .$search . '%')
					->orWhere("questions.answer1", 'like', '%' .$search . '%')
					->orWhere("questions.answer2", 'like', '%' .$search . '%')
					->orWhere("questions.answer3", 'like', '%' .$search . '%')
					->orWhere("questions.answer4", 'like', '%' .$search . '%')
					->orWhere("qbank_subjects.subject_name", 'like', '%' .$search . '%')
					->orWhere("question_papers.question_paper_name", 'like', '%' .$search . '%');
				});
		
		if($qpaper_id!="")
		{
			$dts->where('questions.question_paper_id',$qpaper_id);
		}
					  
		$dats=$dts->orderBy('questions.id','ASC')->get();
		
		//$totQ=$dats->count();
				
		$data = array();
		$uData = array();
		$qpname="";
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				
				$uData['quest']=$r->question;
				$uData['type']="Text";
				if($r->question_type==1)
				{
					$uData['quest']='<a href="#" class="view-image" data-bs-toggle="modal" data-bs-target="#BasicModal3" data-image="'.config('constants.image_question').$r->question.'" ><img src="'.config('constants.image_question').$r->question.'" style="width:100px;height:40px;"></a>';
					$uData['type']="Image";
				}
				
				$uData['id'] = $r->id;
				$uData['qpname'] =$r->question_paper_name;
				$uData['qb_subject'] =$r->subject_name;
				//$uData['quest'] =$r->question;
				$uData['ans1'] =$r->answer1;
				$uData['ans2'] =$r->answer2;
				$uData['ans3'] =$r->answer3;
				$uData['ans4'] =$r->answer4;
				$uData['cans'] =$r->correct_answer;
				
				
				$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item " href="'.route('edit-question',$r->id).'" >Edit</a></li>
							  <li><a class="dropdown-item btnDel" href="javascript:void(0)" id="'.$r->id.'" >Delete</a></li>
                            </ul>
                        </div>';

				$uData['action'] = $dr_btn;

			    $data[] = $uData;

				//if($qpaper_id!=""){$qpname=$r->question_paper_name;}else{$qpname="";}
			}
        }

		return $data;
	}		


  public function edit($id)
  {
    $qs=Question::where('id',$id)->first();
	$qsubj=QbankSubject::where('status',1)->get();
	return view('admin.model_tests.edit_question',compact('qs','qsubj'));
  }	

public function update_question(Request $request)
	{

	  $validate = Validator::make(request()->all(),[
             'subject_id'=>'required',
			 'answer1'=>'required',
			 'answer2'=>'required',
			 'answer3'=>'required',
			 'answer4'=>'required',
			 'correct_answer'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{

			$qid=$request->question_id;
			$qbid=$request->qbank_question_id;
			$qtype=$request->question_type;
			
			$fname1=$request->quest_image;
			
			if($request->file('image_question'))
			{ 
				Storage::disk('spaces')->delete("image_questions"."/".$request->quest_image);
				$fname1=Storage::disk('spaces')->putFile("image_questions",$request->file('image_question'), 'public');
				$fname1=str_replace("image_questions/","",$fname1);
			}
				
			if($qtype==0)
			{
				$fname1=$request->question;
			}
									
			$new_dat=[
			 'qbank_subject_id'=>$request->subject_id,
			 'question'=>$fname1,
			 'answer1'=>$request->answer1,
			 'answer2'=>$request->answer2,
			 'answer3'=>$request->answer3,
			 'answer4'=>$request->answer4,
			 'correct_answer'=>$request->correct_answer,
			];

			$result=Question::whereId($qid)->update($new_dat);
			
			if($request->qbank_question_id!="")
			{
				$new_dat1=[
				 'qbank_subject_id'=>$request->subject_id,
				 'question'=>$fname1,
				 'answer1'=>$request->answer1,
				 'answer2'=>$request->answer2,
				 'answer3'=>$request->answer3,
				 'answer4'=>$request->answer4,
				 'correct_answer'=>$request->correct_answer,
				];
				$result=QbankQuestion::whereId($qbid)->update($new_dat1);
			}
			
			if($result)
			{
				Session::flash('message', 'success#Question successfully updated.');
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
		
		return redirect()->route('view-questions');
  }


   public function destroy($id)
	{
		$dat=Question::findorfail($id);
		
			if(!empty($dat))
			{
				
				if($dat->question_type==1)
				{ 
					Storage::disk('spaces')->delete("image_questions"."/".$dat->question);
				}
				
				$dat->delete();
				return response()->json(['msg' =>'Question successfuly removed.!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				
	}
		
	
	public function get_qpapers_by_course_id($id)
	{
		$opt=Common::getQuestionPapersByCourseIdForViewQuestions($id);
		return $opt;
	}
	
 //----------------------------------------------------------------------------------------------------------
 
 public function add_question()
 {
	$crs=Course::where('status',1)->get();
	$qsubj=QbankSubject::where('status',1)->get();
	return view('admin.model_tests.add_question',compact('crs','qsubj'));
 }
  
 public function save_question(Request $request)
	{

		try
		{

			$fname1="";
			if($request->file('image_question'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("image_questions",$request->file('image_question'), 'public');
				$fname1=str_replace("image_questions/","",$fname1);
			}
			else
			{
				$fname1=$request->question;
			}
									
			$result=Question::create([
			 'question_paper_id'=>$request->qpaper_id,
			 'qbank_subject_id'=>$request->subject_id,
			 'question_type'=>$request->quest_option,
			 'question'=>$fname1,
			 'answer1'=>$request->answer1,
			 'answer2'=>$request->answer2,
			 'answer3'=>$request->answer3,
			 'answer4'=>$request->answer4,
			 'correct_answer'=>$request->correct_answer,
			]);

			if($result)
			{
				Session::flash('message', 'success#Question successfully added.');
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
		
		return redirect()->route('add-question');
  }

 
}
