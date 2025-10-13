<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Course;
use App\Models\QbankSubject;
use App\Models\QbankQuestion;
use App\Models\QuestionPaper;
use App\Models\Subject;
use App\Models\Question;
use App\Models\PdfQuestion;

use App\Common\Common;

use Validator;
use DataTables;
use Session;
use Auth;

class PdfQuestionController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
		
	return view('admin.model_tests.pdf_questions',compact('crs'));
  }	
 
   public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'course_id'=>'required',
			 'title'=>'required',
			 'pdf_file'=>'required',
			 'start_date'=>'required',
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
			if($request->file('pdf_file'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("pdf_question_files",$request->file('pdf_file'), 'public');
				$fname1=str_replace("pdf_question_files/","",$fname1);
			}
			
			$result=PdfQuestion::create([
			 'course_id'=>$request->course_id,
			 'title'=>$request->title,
			 'start_date'=>$request->start_date,
			 'pdf_question_file'=>$fname1,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
 
			if($result)
			{
				return response()->json(['msg' =>'pdf question successfully added!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Some details are missing, Please check.' , 'status' => false]);
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['msg' =>'Something wrong, Try again.' , 'status' => false]);
		}
		
		//return redirect('pdf-questions');
  }
 
 
 
public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getPdfQuestions($request);

			return DataTables::of($data)
				->addIndexColumn()
				->rawColumns(['action','status','pdf_file'])
				->make(true);
        }
	}
	
	
public function getPdfQuestions($request)  //view data
	{

		$search=$request->search;

		$course_id=$request->searchCourseId;
				
		$dts=PdfQuestion::select('pdf_questions.*','courses.course_name','admins.name')
		->leftJoin('courses','pdf_questions.course_id','=','courses.id')
		->leftJoin('admins','pdf_questions.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("pdf_questions.title", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%');
				});
		
		if($course_id!="")
		{
			$dts->where('pdf_questions.course_id',$course_id);
		}
					  
		$dats=$dts->orderBy('pdf_questions.id','ASC')->get();
		
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

				$uData['id'] = $r->id;
				$uData['cname'] =$r->course_name;
				$uData['title'] =$r->title;
				$uData['pdf_file'] ='<a href="'.config('constants.pdf_question').$r->pdf_question_file.'" target="blank">'.$r->pdf_question_file.'</a>';
				$uData['sdate'] =$r->start_date;
				$uData['status'] =$st;
				$uData['added_by'] =$r->name;

				
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
    $pq=PdfQuestion::where('id',$id)->first();
	$cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	
	return view('admin.model_tests.edit_pdf_question',compact('pq','crs'));
  }	
  
  
public function update_pdf_question(Request $request)
	{
		
	
	   $validate = Validator::make(request()->all(),[
             'course_id_edit'=>'required',
			 'title_edit'=>'required',
			 'start_date_edit'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }

		try
		{
			
			$pdf_id=$request->pdf_quest_id;
			$fname1=$request->pdf_quest_file;
			$ex_fname1=$request->pdf_quest_file;
			
			if($request->file('pdf_file_edit'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("pdf_question_files",$request->file('pdf_file_edit'), 'public');
				$fname1=str_replace("pdf_question_files/","",$fname1);
				Storage::disk('spaces')->delete("pdf_question_files"."/".$ex_fname1);
			}
			
			$new_dat=[
				'course_id'=>$request->course_id_edit,
				'title'=>$request->title_edit,
				'start_date'=>$request->start_date_edit,
				'pdf_question_file'=>$fname1,
			  ];

  			$result=PdfQuestion::whereId($pdf_id)->update($new_dat);
			if($result)
			{
				return response()->json(['msg' =>'Pdf question successfully added!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Some details are missing, Please check.' , 'status' => false]);
			}
			
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['msg' =>'Something wrong, Try again.' , 'status' => false]);
		}
			
		return redirect('pdf-questions');
  }

	
  public function destroy($id)
	{
		$dat=PdfQuestion::findorfail($id);
		
		if(!empty($dat))
		{
			Storage::disk('spaces')->delete("pdf_question_files"."/".$dat->pdf_question_file);
			$dat->delete();
			return response()->json(['msg' =>'Question successfuly removed.!' , 'status' => true]);
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

		$result=PdfQuestion::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Pdf question successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Pdf question successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}
	










 
}
