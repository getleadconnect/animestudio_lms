<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Center;
use App\Models\CourseCategory;
use App\Models\QbankSubject;
use App\Models\QbankQuestion;
use App\Imports\QbankQuestionImport;


use Validator;
use DataTables;
use Session;
use Auth;
use Log;

class QbankQuestionController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$qbsub=QbankSubject::where('status',1)->get();
   return view('admin.question_bank.questions',compact('qbsub'));
  }	
 
 public function add_qbank_question()
  {
	$qbsub=QbankSubject::where('status',1)->get();
   return view('admin.question_bank.add_qbank_question',compact('qbsub'));
  }	
 
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'subject_id'=>'required',
			 'quest_option'=>'required',
			 'answer1'=>'required',
			 'answer2'=>'required',
			 'answer3'=>'required',
			 'answer4'=>'required',
			 'correct_answer'=>'required'
        ]);

	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing1, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
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
									
			$result=QbankQuestion::create([
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
		
		return redirect('add-qbank-question');
		
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getQuestions($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','quest'])
                    ->make(true);
        }
	}
		
	public function getQuestions($request)  //view data
	{

		$search=$request->search;
		$subject_id=$request->searchSubjectId;
				
		$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=QbankQuestion::select('qbank_questions.*','qbank_subjects.subject_name')
		->leftJoin('qbank_subjects','qbank_questions.qbank_subject_id','=','qbank_subjects.id')
		->where(function($where) use($search)
			    {
					$where->where("qbank_questions.question", 'like', '%' .$search . '%')
					->orWhere("qbank_questions.answer1", 'like', '%' .$search . '%')
					->orWhere("qbank_questions.answer2", 'like', '%' .$search . '%')
					->orWhere("qbank_questions.answer3", 'like', '%' .$search . '%')
					->orWhere("qbank_questions.answer4", 'like', '%' .$search . '%')
					->orWhere("qbank_questions.correct_answer", 'like', '%' .$search . '%')
					->orWhere("qbank_subjects.subject_name", 'like', '%' .$search . '%');
				});
		
		if($subject_id!="")
		{
			$dts->where('qbank_questions.qbank_subject_id',$subject_id);
		}			
					  
		$dats=$dts->orderBy('qbank_questions.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				
				
				$uData['quest']=$r->question;
				$uData['type']='Text';
				if($r->question_type==1)
				{
					$uData['quest']='<a href="#" class="view-image" data-bs-toggle="modal" data-bs-target="#BasicModal3" data-image="'.config('constants.image_question').$r->question.'" ><img src="'.config('constants.image_question').$r->question.'" style="width:100px;height:40px;"></a>';
					$uData['type']='Image';
				}

				$uData['id'] = ++$key;
				$uData['subj'] =$r->subject_name;
				//$uData['quest'] =$r->question;
				$uData['ans1'] =$r->answer1;
				$uData['ans2'] =$r->answer2;
				$uData['ans3'] =$r->answer3;
				$uData['ans4'] =$r->answer4;
				$uData['cans'] =$r->correct_answer;
				
			
				$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item edit" href="'.route('edit-qbank-question',$r->id).'" >Edit</a></li>
							  <li><a class="dropdown-item btnDel" href="javascript:void(0)" id="'.$r->id.'" >Delete</a></li>
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
    $qs=QbankQuestion::where('id',$id)->first();
	$qbsub=QbankSubject::where('status',1)->get();
	return view('admin.question_bank.edit_qbank_question',compact('qs','qbsub'));
  }	
		
	public function update_qbank_question(Request $request)
	{

	   $validate = Validator::make(request()->all(),[
             'subject_id'=>'required',
			 'answer1'=>'required',
			 'answer2'=>'required',
			 'answer3'=>'required',
			 'answer4'=>'required',
			 'currect_answer'=>'required',
        ]);

		 
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
	try
		{
						
			$id=$request->quest_id;
			$fname1=$request->quest_image;
			
			if($request->file('image_question'))
			{ 
				Storage::disk('spaces')->delete("image_questions"."/".$fname1);
				$fname1=Storage::disk('spaces')->putFile("image_questions",$request->file('image_question'), 'public');
				$fname1=str_replace("image_questions/","",$fname1);
			}
			
			if($request->quest_type==0)
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
			 'correct_answer'=>$request->currect_answer
			];
			
			$result=QbankQuestion::where('id',$id)->update($new_dat);
						 
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
		
		return redirect('questions');

  }

	
   public function destroy($id)
	{
		$dat=QbankQuestion::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'Question successfuly removed.!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				
	}
	

//----------------------------------------------------------------------------------------------------------------


public function import_qbank_questions()
{
	$qbsub=QbankSubject::where('status',1)->get();
	return view('admin.question_bank.import_qbank_questions',compact('qbsub'));
}	

public function import(Request $request) 
   {
		$validate = Validator::make(request()->all(),[
           'subject_id'=>'required',
		   'question_file' => 'required|mimes:xlsx,xls',
        ]);
		 
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back();
		}
		
		try
		{
		   $sub_id=$request->subject_id;

		   $success=Excel::import(new QbankQuestionImport($sub_id),request()->file('question_file'));
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


}
