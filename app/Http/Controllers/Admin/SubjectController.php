<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Center;
use App\Models\Course;
use App\Models\Subject;

use Validator;
use DataTables;
use Session;
use Auth;

class SubjectController extends Controller
{

  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    $cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	
	return view('admin.subjects.subjects',compact('crs'));
  }	
 
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'subject_name'=>'required',
			 'description'=>'required',
			 'subject_icon'=>'required',
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
			
			if($request->file('subject_icon'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("subject_icons",$request->file('subject_icon'), 'public');
				$fname1=str_replace("subject_icons/","",$fname1);
			}

			$result=Subject::create([
			 'course_id'=>$request->course_id,
			 'subject_name'=>$request->subject_name,
			 'description'=>$request->description,
			 'subject_icon'=>$fname1,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
			
			if($result)
			{
				Session::flash('message', 'success#Subject successfully added.');
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
		
		return redirect('subjects');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getSubjectData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','sicon'])
                    ->make(true);
        }
	}
		
	public function getSubjectData($request)  //view data
	{

		$search=$request->search;
		$scourse=$request->searchCourse;
		
		$dts=Subject::select('subjects.*','courses.course_name','admins.name')
		->leftJoin('courses','subjects.course_id','=','courses.id')
		->leftJoin('admins','subjects.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("subjects.subject_name", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%');
				});
				
				
		if($scourse!="")
		{
			$dts->where('course_id',$scourse);
		}
				
		$dats=$dts->orderBy('subjects.id','ASC')->get();

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
					$uData['desc'] =$r->description;
					$uData['sicon'] ="<img src='".config('constants.subject_icon').$r->subject_icon."' style='width:70px;'>";
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
	$subj=Subject::where('id',$id)->first();
	return view('admin.subjects.edit_subject',compact('crs','subj'));
  }	
		
	public function update_subject(Request $request)
	{

	  $validate = Validator::make(request()->all(),[
             'subject_name_edit'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{
			
			$fname1=$request->subject_icon;
			$ex_fname1=$request->subject_icon;
			
			$id=$request->subject_id;

			if($request->file('subject_icon_edit'))
			{ 

				$fname1=Storage::disk('spaces')->putFile("subject_icons",$request->file('subject_icon_edit'), 'public');
				$fname1=str_replace("subject_icons/","",$fname1);
				Storage::disk('spaces')->delete("subject_icons"."/".$ex_fname1);
			}

			$new_dat=[
			 'course_id'=>$request->course_id_edit,
			 'subject_name'=>$request->subject_name_edit,
			 'description'=>$request->description_edit,
			 'subject_icon'=>$fname1,
			 ];
			
			$result=Subject::whereId($id)->update($new_dat);
			
			if($result)
			{
				Session::flash('message', 'success#Subject successfully updated.');
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
		
		return redirect('subjects');
  }


	
   public function destroy($id)
	{
		$dat=Subject::findorfail($id);
		
			if(!empty($dat))
			{
				$sfile=$dat->subject_icon;
				
				$dat->delete();

				Storage::disk('spaces')->delete("subject_icons"."/".$sfile);
				
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

		$result=Subject::where('id',$id)->update($new);

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
