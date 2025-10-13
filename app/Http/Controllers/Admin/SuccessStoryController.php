<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Center;
use App\Models\SuccessStory;

use Validator;
use DataTables;
use Session;
use Auth;
use DB;

class SuccessStoryController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
 	$center=Center::where('status',1)->get();	
	return view('admin.success_story.success_story',compact('center'));
  }	
  	
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
			 'name'=>'required',
			 'place'=>'required',
			 'description'=>'required',
			 'story_icon'=>'required',
			 'story_video'=>'required',
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
			$fname2="";
			
			if($request->file('story_icon'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("success_story",$request->file('story_icon'), 'public');
				$fname1=str_replace("success_story/","",$fname1);
			}
			
			if($request->file('story_video'))
			{ 
	
				$fname2=Storage::disk('spaces')->putFile("success_story",$request->file('story_video'), 'public');
				$fname2=str_replace("success_story/","",$fname2);
			}

			$result=SuccessStory::create([
			 'name'=>$request->name,
			 'place'=>$request->place,
			 'description'=>$request->description,
			 'story_icon'=>$fname1,
			 'story_video'=>$fname2,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
						
			if($result)
			{
				return response()->json(['msg' =>'Success story successfully added!' , 'status' => true]);
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
		
		//return redirect('success-story');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getSuccessStoryData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','sicon','svideo'])
                    ->make(true);
        }
	}
		
	public function getSuccessStoryData($request)  //view data
	{

		$search=$request->search;
		
				
		$dts=SuccessStory::select('success_story.*','admins.name')
		->leftJoin('admins','success_story.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("success_story.name", 'like', '%' .$search . '%')
					->orWhere("success_story.place", 'like', '%' .$search . '%')
					->orWhere("success_story.description", 'like', '%' .$search . '%');
				});
						  
		$dats=$dts->orderBy('success_story.id','ASC')->get();
		
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
					$uData['nam'] =$r->name;
					$uData['place'] =$r->place;
					$uData['desc'] =$r->description;
					$uData['sicon'] ='<img src="'.config('constants.success_story').$r->story_icon.'" style="width:70px;">';
					$uData['svideo'] ='<a href="'.config('constants.success_story').$r->story_video.'" target="blank">'.$r->story_video.'</a>';
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
    $ss=SuccessStory::where('id',$id)->first();
	return view('admin.success_story.edit_success_story',compact('ss'));
  }	
		
	public function update_success_story(Request $request)
	{

	 $validate = Validator::make(request()->all(),[
			 'name_edit'=>'required',
			 'place_edit'=>'required',
			 'description_edit'=>'required',
        ]);
	  
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }

		try
		{

			$id=$request->story_id;
			
			
			$fname1=$request->story_icon;
			$ex_fname1=$request->story_icon;
			
			$fname2=$request->story_video;
			$ex_fname2=$request->story_video;
			
			if($request->file('story_icon_edit'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("success_story",$request->file('story_icon_edit'), 'public');
				$fname1=str_replace("success_story/","",$fname1);
				Storage::disk('spaces')->delete("success_story"."/".$ex_fname1);
			}
			
			if($request->file('story_video_edit'))
			{ 
				$fname2=Storage::disk('spaces')->putFile("success_story",$request->file('story_video_edit'), 'public');
				$fname2=str_replace("success_story/","",$fname2);
				Storage::disk('spaces')->delete("success_story"."/".$ex_fname2);
			}

			$new_dat=[
			 'name'=>$request->name_edit,
			 'place'=>$request->place_edit,
			 'story_icon'=>$fname1,
			 'story_video'=>$fname2,
			 'description'=>$request->description_edit,
			 ];
			
			$result=SuccessStory::whereId($id)->update($new_dat);
		
			if($result)
			{
				return response()->json(['msg' =>'Success story successfully updated!' , 'status' => true]);
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
		
		//return redirect('success-story');
  }

	
   public function destroy($id)
	{
		$dat=SuccessStory::findorfail($id);
		
			if(!empty($dat))
			{
				$icon=$dat->story_icon;
				$video=$dat->story_video;
				$dat->delete();
				Storage::disk('spaces')->delete("success_story"."/".$icon);
				Storage::disk('spaces')->delete("success_story"."/".$video);
				
				return response()->json(['msg' =>'Success story successfuly removed.!' , 'status' => true]);
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

		$result=SuccessStory::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Success story successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Success story successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}
	
	
}
