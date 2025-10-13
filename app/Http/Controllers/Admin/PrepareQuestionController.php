<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Center;
use App\Models\Course;
use App\Models\QuestionPaper;
use App\Models\QbankQuestion;
use App\Models\QbankSubject;
use App\Models\Question;
use App\Imports\QuestionImport;

use App\Common\Common;

use Validator;
use DataTables;
use Session;
use Auth;

class PrepareQuestionController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
		
	$subj=QbankSubject::where('status',1)->get();
	return view('admin.model_tests.prepare_questions',compact('crs','subj'));
  }	
  
  public function get_subjects_by_course_id($course_id)
  {
	  $res=Common::getSubjectsByCourseId($course_id);
	  return $res;
  }
  
  
 /* public function get_question_papers_by_subject_id($subject_id)
  {
	  $res=Common::getQuestionPapersBySubjectId($subject_id);
	  return $res;
  }*/
  
  
  public function get_question_papers_by_course_id($course_id)
  {
	  $res=Common::getQuestionPapersByCourseId($course_id);
	  return $res;
  }
  
  
   public function get_free_question_papers()
  {
	  $res=Common::getFreeQuestionPapers();
	  return $res;
  }
    
  public function get_total_questions($qpid)
	{
		$qcount=Question::where('question_paper_id',$qpid)->count();
		return $qcount;
	}

  
  public function pdf_questions()
  {
    return view('admin.model_tests.pdf_questions');
  }	
 
  public function view_questions()
  {
    return view('admin.model_tests.view_qpaper_questions');
  }	
 
 
   public function save_qpaper_questions(Request $request)
	{
		$qpaper_id=$request->qpaper_id;
		$quest_ids=$request->quest_id;
		$qids=substr($quest_ids,0,strlen($quest_ids)-1);
		$questid=explode(",",$qids);

		$result="";
		
		foreach($questid as $qid)
		{
		   $qdt=QbankQuestion::where('id',$qid)->first();
		
			$result=Question::create([
			'question_paper_id'=>$qpaper_id,
			'qbank_question_id'=>$qid,
			'qbank_subject_id'=>$qdt->qbank_subject_id,
			'question'=>$qdt->question,
			'answer1'=>$qdt->answer1,	
			'answer2'=>$qdt->answer2,	
			'answer3'=>$qdt->answer3,	
			'answer4'=>$qdt->answer4,	
			'correct_answer'=>$qdt->correct_answer,
			]);
		}
		
		 if($result)
			{
				return response()->json(['msg' =>'Questions successfully added!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Some details are missing, Please check.' , 'status' => false]);
			}

	}
	

//IMPORT QUESTIONS -------------------------------------------------------------

public function import_qpaper_questions()
{
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	return view('admin.model_tests.import_questions',compact('crs'));
}	

public function import(Request $request) 
   {
		$validate = Validator::make(request()->all(),[
           'course_id'=>'required',
		   'qpaper_id'=>'required',
		   'question_file' => 'required|mimes:xlsx,xls',
        ]);
		 
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back();
		}
		
		try
		{
		   $qp_id=$request->qpaper_id; 
 
		   $success=Excel::import(new QuestionImport($qp_id),request()->file('question_file'));
		   if($success)
		   {
		       Session::flash('message', 'success#Question successfully added.');
		   }
		   else
		   {
			   Session::flash('message', 'danger#Something wrong, Try again.');
		   }
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			Session::flash('message', 'danger#Something wrong, Try again.');
		}
	   
	   return back();
    }


public function view_question_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getQbankQuestions($request);

			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('selbtn',function($data)
				{
					return  '<button type="button" class="qselect btn btn-primary btn-rect btn-xs btn-sm fap pr8 " title="Select Question" style="padding: 5px 5px 5px 10px;"><i class="fa fa-plus"></i></button>';
				})
				->rawColumns(['delbtn','selbtn','action','course','quest','answer','status'])
				->make(true);
        }
	}
	
	
public function getQbankQuestions($request)  //view data
	{

		$search=$request->search;
		$subject_id=$request->searchSubjectId;

		$dts=QbankQuestion::select('qbank_questions.*','qbank_subjects.subject_name')
		->leftJoin('qbank_subjects','qbank_questions.qbank_subject_id','=','qbank_subjects.id')
		->where('qbank_questions.qbank_subject_id',$subject_id)
		->where(function($where) use($search)
			    {
					$where->where("qbank_questions.question", 'like', '%' .$search . '%')
					->orWhere("qbank_questions.answer1", 'like', '%' .$search . '%')
					->orWhere("qbank_questions.answer2", 'like', '%' .$search . '%')
					->orWhere("qbank_questions.answer3", 'like', '%' .$search . '%')
					->orWhere("qbank_questions.answer4", 'like', '%' .$search . '%')
					->orWhere("qbank_subjects.subject_name", 'like', '%' .$search . '%');
				});
		
		/*if($sub_id!="")
		{
			$dts->where('live_classes.subject_id',$sub_id);
		}*/			
					  
		$dats=$dts->orderBy('qbank_questions.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$uData['id'] = $r->id;
				$uData['subj'] =$r->subject_name;
				$uData['quest'] =$r->question;
				$uData['ans1'] =$r->answer1;
				$uData['ans2'] =$r->answer2;
				$uData['ans3'] =$r->answer3;
				$uData['ans4'] =$r->answer4;
				$uData['cans'] =$r->correct_answer;
				
			    $data[] = $uData;
			}
        }
		return $data;
	}		

	
   public function destroy($id)
	{
		$dat=Student::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'Student details successfuly removed.!' , 'status' => true]);
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

		$result=Student::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Student details successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Student details successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}
	
	public function getCourseFee($id)
	{
		$res=Course::whereId($id)->first();
		return response()->json(['data' =>$res, 'status' =>true]);
	}
	
	
	public function check_question_already_added($qpid,$qid)
	{
		$cnt=Question::where('qbank_question_id',$qid)->where('question_paper_id',$qpid)->count();
		return response()->json(['status' =>$cnt]);

	}
	
	
 
 
}
