<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Center;
use App\Models\CourseCategory;
use App\Models\QbankSubject;

use Validator;
use DataTables;
use Session;
use Auth;

class QbankSubjectController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
     return view('admin.question_bank.question_bank_subjects');
  }	
  
  public function store(Request $request)
  {
		try
		{
			$usr_id=Auth::guard('admin')->user()->id;
			$subj=$request->sub_count;

			$result="";
			
			for($x=0;$x<$subj;$x++)
			{
				$subname=$request->subject[$x];
				
				if($subname!="")
				{
				   $result=QbankSubject::create([
					'subject_name'=>$subname,
					'status'=>1,
					'added_by'=>$usr_id,
					]);
				}
			}

			if($result)
			{
				return response()->json(['msg' =>'Subject successfully added!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Some details are missing, Please check.'.$result , 'status' => false]);
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
            $data = $this->getQuestionBankSubjects($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
	}
		
	public function getQuestionBankSubjects($request)  //view data
	{

		$search=$request->search;
		
		$dats=QbankSubject::select('qbank_subjects.*','admins.name')
		->leftJoin('admins','qbank_subjects.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("qbank_subjects.subject_name", 'like', '%' .$search . '%');
			  })->orderBy('qbank_subjects.id','ASC')->get();

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
				
					$uData['slno'] = ++$key;
					$uData['id'] = $r->id;
					$uData['subj'] =$r->subject_name;
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
		$ce=Center::whereId($id)->first();
		return view('admin.center.edit_center',compact('ce'));
	}
	
		
	public function update_qbank_subject(Request $request)
	{

		$validate=Validator::make($request->all(),['subject_name_edit'=>'required']);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		try
		{
			$new=[
				'subject_name'=>$request->subject_name_edit,
			];
					
			$result=QbankSubject::where('id',$request->subject_id_edit)->update($new);
				
			if($result)
			{
				return response()->json(['msg' =>'Subject successfully updated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Some details are missing, Please check.'.$result , 'status' => false]);
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['msg' =>'Something wrong, Try again.' , 'status' => false]);
		}
	}
	
   public function destroy($id)
	{
		$dat=QbankSubject::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'Subject successfuly removed.!' , 'status' => true]);
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

		$result=QbankSubject::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Subject successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Subject successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}

	
}
