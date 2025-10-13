<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use App\Models\Center;
use App\Models\Course;
use App\Models\BannerImage;
use App\Models\CourseCategory;

use Validator;
use DataTables;
use Session;
use Auth;

class BannerImageController extends Controller
{

  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {

	$cid=Auth::guard('admin')->user()->center_id;
    $crs=Course::where('center_id',$cid)->where('status',1)->get();
    $cat=CourseCategory::where('status',1)->where('id','!=',1)->get();
   return view('admin.banner_images.banner_images',compact('crs','cat'));
  }
  
 
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
			 'banner_image'=>'required',
			 'banner_link'=>'required',
			 'banner_type'=>'required',
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
			
			if($request->file('banner_image'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("banner_images",$request->file('banner_image'), 'public');
				$fname1=str_replace("banner_images/","",$fname1);
			}

			$result=BannerImage::create([
			 'course_category_id'=>$request->category_id,
			 'course_id'=>$request->course_id,
			 'banner_image'=>$fname1,
			 'banner_link'=>$request->banner_link,
			 'banner_type'=>$request->banner_type,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
				
		
			if($result)
			{
				Session::flash('message', 'success#Banner successfully added.');
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
		
		return redirect('banners');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) 
		{
            $data = $this->getBannerData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','bimage'])
                    ->make(true);
        }
	}
		
	public function getBannerData($request)  //view data
	{

		$search=$request->search;
		
		$dats=BannerImage::select('banner_images.*','courses.course_name','course_category.category','admins.name')
		->leftJoin('admins','banner_images.added_by','=','admins.id')
		->leftJoin('courses','banner_images.course_id','=','courses.id')
		->leftJoin('course_category','banner_images.course_category_id','=','course_category.id')
		->where(function($where) use($search)
			    {
					$where->where("banner_images.banner_link", 'like', '%' .$search . '%')
					->orWhere("banner_images.banner_type", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%');
				})->orderBy('banner_images.id','ASC')->get();

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
					$uData['cname'] =$r->course_name??"--";
					$uData['cat'] =$r->category;
					$uData['btype'] =($r->banner_type==1)?"Course":"Others";
					$uData['bimage'] ="<img src='".config('constants.banner_image').$r->banner_image."' style='width:100px;'>";
					$uData['blink'] =$r->banner_link??"--";
					$uData['status'] =$st;
					$uData['addedby'] =$r->name;
					
				
					$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item edit" href="javascript:void(0)" id="'.$r->id.'" data-bs-toggle="modal" data-bs-target="#BasicModal2" >Edit</a></li>
                              <li><a class="dropdown-item btnDel" href="javascript:void(0)"  id="'.$r->id.'">Delete</a></li>
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
	$cat=CourseCategory::where('status',1)->where('id','!=',1)->get();   //ALL option not used
    $bi=BannerImage::where('id',$id)->first();
	return view('admin.banner_images.edit_banner_image',compact('bi','crs','cat'));
  }	

		
	public function update_banner_image(Request $request)
	{

	    $validate = Validator::make(request()->all(),[
			 'banner_link_edit'=>'required',
			 'banner_type_edit'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{
			
			$fname1=$request->banner_image;
			$ex_fname1=$request->banner_image;
			
			$id=$request->banner_id;
			
			if($request->file('banner_image_edit'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("banner_images",$request->file('banner_image_edit'), 'public');
				$fname1=str_replace("banner_images/","",$fname1);
				Storage::disk('spaces')->delete("banner_images".'/'.$request->banner_image);
			}

			$new_dat=[
			 'course_category_id'=>$request->category_id_edit,
			 'banner_link'=>$request->banner_link_edit,
			 'banner_image'=>$fname1,
			 'course_id'=>$request->course_id_edit,
			 ];
			
			$result=BannerImage::whereId($id)->update($new_dat);
			
			if($result)
			{
				Session::flash('message', 'success#Banner image successfully updated.');
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
		
		return redirect('banners');
  }

	
  public function destroy($id)
	{
		$dat=BannerImage::findorfail($id);
		
			if(!empty($dat))
			{
				$sfile=$dat->banner_image;
				$dat->delete();
				Storage::disk('spaces')->delete("banner_images"."/".$sfile);
				
				return response()->json(['msg' =>'Banner successfuly removed.!' , 'status' => true]);
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
				
		$result=BannerImage::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Banner successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Banner successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}

}
