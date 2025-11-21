<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Center;
use App\Models\Course;
use App\Models\EasyTips;

use Validator;
use DataTables;
use Session;
use Auth;

class EasyTipsController extends Controller
{

  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    $cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	
	return view('admin.courses.easy_tips',compact('crs'));
  }	
 
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'course_id'=>'required',
			 'subject_id'=>'required',
			 'chapter_id'=>'required',
			 'title'=>'required',
			 'description'=>'required',
			 'tips_file'=>'required',
			 'file_type'=>'required'
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
			
			if($request->file('tips_icon'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("easy_tips",$request->file('tips_icon'), 'public');
				$fname1=str_replace("easy_tips/","",$fname1);
			}
			
			if($request->file('tips_file'))
			{ 
				$fname2=Storage::disk('spaces')->putFile("easy_tips",$request->file('tips_file'), 'public');
				$fname2=str_replace("easy_tips/","",$fname2);
			}

			$result=EasyTips::create([
			 'course_id'=>$request->course_id,
			 'subject_id'=>$request->subject_id,
			 'chapter_id'=>$request->chapter_id,
			 'title'=>$request->title,
			 'description'=>$request->description,
			 'tips_icon'=>$fname1,
			 'file_type'=>$request->file_type,
			 'tips_file'=>$fname2,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
			
			if($result)
			{
				Session::flash('message', 'success#Easy Tips details successfully added.');
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
		
		return redirect('easy-tips');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getEasyTipsData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','icon','ftype','tfile'])
                    ->make(true);
        }
	}
		
	public function getEasyTipsData($request)  //view data
	{

		$search=$request->search;
		$scourse=$request->searchCourse;
		
		$dts=EasyTips::select('easy_tips.*','courses.course_name','admins.name')
		->leftJoin('courses','easy_tips.course_id','=','courses.id')
		->leftJoin('admins','easy_tips.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("easy_tips.title", 'like', '%' .$search . '%')
					->orWhere("easy_tips.description", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%');
				});
				
		if($scourse!="")
		{
			$dts->where('course_id',$scourse);
		}			
		
		$dats=$dts->orderBy('easy_tips.id','ASC')->get();

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
						$btns='<a href="javascript:void(0)" id="'.$r->id.'" class="btnDeact dropdown-item">Deactivate </a>';
					}
				
					if($r->file_type==1)
					{
						$ft='<span class="badge bg-info">Video</span>';
					}
					else if($r->file_type==2)
					{
						$ft='<span class="badge bg-info">PDF</span>';
					}
					else
					{
						$ft='<span class="badge bg-secondary">Image</span>';
					}
				
					$uData['id'] = ++$key;
					$uData['cname'] =$r->course_name;
					$uData['title'] =$r->title;
					$uData['desc'] =$r->description;
					$uData['icon'] ="<img src='".config('constants.easy_tips').$r->tips_icon."' style='width:70px;'>";
					$uData['tfile'] ='<a href="'.config('constants.easy_tips').$r->tips_file.'" target="blank">'.$r->tips_file.'</a>';
					$uData['ftype'] =$ft;
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
	$et=EasyTips::where('id',$id)->first();
	return view('admin.courses.edit_easy_tips',compact('crs','et'));
  }	

		
	public function update_easy_tips(Request $request)
	{

	    $validate = Validator::make(request()->all(),[
             'title_edit'=>'required',
			 'description_edit'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{
			
			$fname1=$request->tips_icon;
			$ex_fname1=$request->tips_icon;
			
			$fname2=$request->tips_file;
			$ex_fname2=$request->tips_file;
			
			$ftype=$request->file_type;
			$id=$request->tips_id;
			
			if($request->file('tips_icon_edit'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("easy_tips",$request->file('tips_icon_edit'), 'public');
				$fname1=str_replace("easy_tips/","",$fname1);
				Storage::disk('spaces')->delete("easy_tips"."/".$ex_fname1);
			}

			if($request->file('tips_file_edit'))
			{ 
				$fname2=Storage::disk('spaces')->putFile("easy_tips",$request->file('tips_file_edit'), 'public');
				$fname2=str_replace("easy_tips/","",$fname2);
				Storage::disk('spaces')->delete("easy_tips"."/".$ex_fname2);
			}
			
			$new_dat=[
			 'course_id'=>$request->course_id_edit,
			 'title'=>$request->title_edit,
			 'description'=>$request->description_edit,
			 'tips_icon'=>$fname1,
			 'tips_file'=>$fname2,
			 'file_type'=>$request->file_type_edit??$ftype,
			 ];
			
			$result=EasyTips::whereId($id)->update($new_dat);
			
			if($result)
			{
				Session::flash('message', 'success#Easy tips successfully updated.');
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
		
		return redirect('easy-tips');
  }

	
  public function destroy($id)
	{
		$dat=EasyTips::findorfail($id);
		
			if(!empty($dat))
			{
				$ticon=$dat->tips_icon;
				$tfile=$dat->tips_file;
				
				$dat->delete();

				Storage::disk('spaces')->delete("easy_tips"."/".$ticon);
				Storage::disk('spaces')->delete("easy_tips"."/".$tfile);
				
				return response()->json(['msg' =>'Easy Tips successfuly removed.!' , 'status' => true]);
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

		$result=EasyTips::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Easy tips successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Easy tips successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}

}
