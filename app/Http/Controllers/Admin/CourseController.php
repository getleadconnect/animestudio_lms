<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Center;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseType;

use Validator;
use DataTables;
use Session;
use Auth;

class CourseController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }
  
  public function index()
  {
   $center=Center::where('status',1)->get();
   $ccat=CourseCategory::where('status',1)->where('id','!=',1)->get();
   $ctype=CourseType::all();
   return view('admin.courses.courses',compact('center','ccat','ctype'));
  }	
     
  public function add_course()
  {
    $cat=CourseCategory::where('status',1)->where('id','!=',1)->get();
	$ctype=CourseType::get();
	return view('admin.courses.add_course',compact('cat','ctype'));
  }	
  
  public function latest_batches()
  {
    return view('admin.courses.latest_batches');
  }	
  
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'course_name'=>'required',
			 'course_category'=>'required',
			 'course_type'=>'required',
			 'start_date'=>'required',
			 'end_date'=>'required',
			 'rate'=>'required',
			 'discount_rate'=>'required',
			 'course_icon_wide'=>'required',
			 'course_icon_square'=>'required',
			 'video_file'=>'required',
			 'description'=>'required',
			 'course_details'=>'required',
			 'premium'=>'required'
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
			$fname3="";
			
			$usr_id=Auth::guard('admin')->user()->id;
			
			if($request->file('course_icon_wide'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("course_icons",$request->file('course_icon_wide'), 'public');
				$fname1=str_replace("course_icons/","",$fname1);
			}
			
			if($request->file('course_icon_square'))
			{ 
				$fname2=Storage::disk('spaces')->putFile("course_icons",$request->file('course_icon_square'), 'public');
				$fname2=str_replace("course_icons/","",$fname2);
			}
			
			if($request->file('video_file'))
			{ 
				$fname3=Storage::disk('spaces')->putFile("course_explanation_videos",$request->file('video_file'), 'public');
				$fname3=str_replace("course_explanation_videos/","",$fname3);
			}

			$result=Course::create([
				 'center_id'=>Auth::guard('admin')->user()->center_id,
				 'course_name'=>$request->course_name,
				 'course_category_id'=>$request->course_category,
				 'course_type_id'=>$request->course_type,
				 'start_date'=>$request->start_date,
				 'end_date'=>$request->end_date,
				 'rate'=>$request->rate,
				 'discount_rate'=>$request->rate,
				 'course_wide_icon'=>$fname1,
				 'course_square_icon'=>$fname2,
				 'ios_rate'=>$request->ios_rate,
				 'app_store_product_id'=>$request->app_store_id,
				 'subscription_type'=>$request->subscription_type,
				 'video_file'=>$fname3,
				 'description'=>$request->description,
				 'course_details'=>$request->course_details,
				 'premium'=>$request->premium,
				 'status'=>1,
				 'added_by'=>$usr_id
			]);
			
			if($result)
			{
				Session::flash('message', 'success#Course successfully added.');
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
		
		return redirect('add-course');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getCourseData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','cwicon','csicon','vfile','sdate','rate','pre'])
                    ->make(true);
        }
	}
		
	public function getCourseData($request)  //view data
	{

		$search=$request->search;
		$search_center=$request->searchCenter;
		$search_cat=$request->searchCat;
		$search_ctype=$request->searchCtype;
		
		
		$dts=Course::select('courses.*','centers.center_name','course_category.category','course_types.course_type','admins.name')
		->leftJoin('centers','courses.center_id','=','centers.id')
		->leftJoin('admins','courses.added_by','=','admins.id')
		->leftJoin('course_category','courses.course_category_id','=','course_category.id')
		->leftJoin('course_types','courses.course_type_id','=','course_types.id')
		->where(function($where) use($search)
			    {
					$where->where("courses.course_name", 'like', '%' .$search . '%')
					->orWhere("courses.start_date", 'like', '%' .$search . '%')
					->orWhere("courses.subscription_type", 'like', '%' .$search . '%')
					->orWhere("courses.description", 'like', '%' .$search . '%')
					->orWhere("courses.course_details", 'like', '%' .$search . '%')
					->orWhere("course_category.category", 'like', '%' .$search . '%');
				});
				
		/*if(search_center!="" and search_cat!="" and search_ctype!="")
		{
			$dts->where('course_category_id',$search_cat)->where('center_id',$search_center)
			->where('course_type_id',$search_ctype);
		}*/
		
		if($search_center!="")
		{
			$dts->where('courses.center_id',$search_center);
		}
		if($search_cat!="")
		{
			$dts->where('courses.course_category_id',$search_cat);
		}
		if($search_ctype!="")
		{
			$dts->where('courses.course_type_id',$search_ctype);
		}
		
		$dats=$dts->orderBy('courses.id','ASC')->get();

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
				
				if($r->premium==1)
				{
					$pre='<span class="badge bg-danger">Premium</span>';
				}
				else
				{
					$pre='<span class="badge bg-success">Free</span>';
				}
			
				$uData['slno'] = ++$key;
				$uData['id'] = $r->id;
				$uData['comp'] =$r->center_name;
				$uData['cname'] =$r->course_name;
				$uData['cat'] =$r->category;
				$uData['ctype'] =$r->course_type;
				$uData['sdate'] = "Start: ".$r->start_date."<br>End: ".$r->end_date;
				$uData['cwicon'] ="<img src='".config('constants.course_icon').$r->course_wide_icon."' style='width:70px;'>";
				$uData['csicon']="<img src='".config('constants.course_icon').$r->course_square_icon."' style='width:70px;'>";
				$uData['rate'] ="Rate:".$r->rate."<br>Disc.Rate: ".$r->discount_rate;
				$uData['irate'] =$r->ios_rate;
				$uData['appid'] =$r->app_store_product_id;
				$uData['subtype'] =$r->subscription_type;
				$uData['vfile'] ='<a href="'.config('constants.course_exp_video').$r->video_file.'" target="blank">'.$r->video_file.'</a>';
				$uData['desc'] =$r->description;
				$uData['cdetails'] =$r->course_details;
				$uData['pre'] =$pre;
				$uData['status'] =$st;
				$uData['addedby'] =$r->name;
				

				$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item edit" href="'.url('/edit-course')."/".$r->id.'" >Edit</a></li>
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
    $crs=Course::whereId($id)->first();
	$cat=CourseCategory::where('status',1)->where('id','!=',1)->get();
	$ctype=CourseType::get();
	return view('admin.courses.edit_course',compact('cat','ctype','crs'));
  }	

		
  public function update_course(Request $request)
	{

	  $validate = Validator::make(request()->all(),[
             'course_name_edit'=>'required',
			 'course_category_edit'=>'required',
			 'course_type_edit'=>'required',
			 'start_date_edit'=>'required',
			 'end_date_edit'=>'required',
			 'rate_edit'=>'required',
			 'discount_rate_edit'=>'required',
			 'description_edit'=>'required',
			 'course_details_edit'=>'required',
			 'premium_edit'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{
			
			$fname1=$request->course_wide_icon;
			$fname2=$request->course_square_icon;
			$fname3=$request->course_video_file;

			$ex_fname1=$request->course_wide_icon;
			$ex_fname2=$request->course_square_icon;
			$ex_fname3=$request->course_video_file;
			
			$id=$request->course_id;

			if($request->file('course_icon_wide_edit'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("course_icons",$request->file('course_icon_wide_edit'), 'public');
				$fname1=str_replace("course_icons/","",$fname1);
				Storage::disk('spaces')->delete("course_icons/".$ex_fname1);
				
			}
			
			if($request->file('course_icon_square_edit'))
			{ 
				$fname2=Storage::disk('spaces')->putFile("course_icons",$request->file('course_icon_square_edit'), 'public');
				$fname2=str_replace("course_icons/","",$fname2);
				Storage::disk('spaces')->delete("course_icons/".$ex_fname2);
			}
			
			if($request->file('video_file_edit'))
			{ 
				$fname3=Storage::disk('spaces')->putFile("course_explanation_videos",$request->file('video_file_edit'), 'public');
				$fname3=str_replace("course_explanation_videos/","",$fname3);
				Storage::disk('spaces')->delete("course_explanation_videos/".$ex_fname3);
			}

			$new_dat=[
			 'course_name'=>$request->course_name_edit,
			 'course_category_id'=>$request->course_category_edit,
			 'course_type_id'=>$request->course_type_edit,
			 'start_date'=>$request->start_date_edit,
			 'end_date'=>$request->end_date_edit,
			 'rate'=>$request->rate_edit,
			 'discount_rate'=>$request->discount_rate_edit,
			 'course_wide_icon'=>$fname1,
			 'course_square_icon'=>$fname2,
			 'ios_rate'=>$request->ios_rate_edit,
			 'app_store_product_id'=>$request->app_store_id_edit,
			 'subscription_type'=>$request->subscription_type_edit,
			 'video_file'=>$fname3,
			 'description'=>$request->description_edit,
			 'course_details'=>$request->course_details_edit,
			 'premium'=>$request->premium_edit,
			];
			
			$result=Course::whereId($id)->update($new_dat);
			
			if($result)
			{
				Session::flash('message', 'success#Course successfully updated.');
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

		return redirect('admin/courses');
  }


	
   public function destroy($id)
	{
			
			$dat=Course::findorfail($id);
			if(!empty($dat))
			{
				
				try
				{
					$cfile1=$dat->course_wide_icon;
					$cfile2=$dat->course_square_icon;
					$vfile=$dat->video_file;

					$dat->delete();

					Storage::disk('spaces')->delete("course_icons"."/".$cfile1);
					Storage::disk('spaces')->delete("course_icons"."/".$cfile2);
					Storage::disk('spaces')->delete("course_explanation_videos"."/".$vfile);
					
					return response()->json(['msg' =>'Course successfuly removed.!' , 'status' => true]);
					
				}
				catch(\Exception $e)
				{
					return response()->json(['msg' =>"The course has sub-items; you can't remove this course!" , 'status' => false]);
				}
			}
			else
			{
				return response()->json(['msg' =>"Course  not found!" , 'status' => false]);
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

		$result=Course::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Course successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Course successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}

}

