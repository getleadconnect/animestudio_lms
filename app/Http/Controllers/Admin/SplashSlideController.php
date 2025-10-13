<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use App\Models\Center;
use App\Models\Course;
use App\Models\SplashSlide;

use Validator;
use DataTables;
use Session;
use Auth;

class SplashSlideController extends Controller
{

  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {

	return view('admin.splash.splash_slides');
  }	
 
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'title'=>'required',
			 'description'=>'required',
			 'slide_image'=>'required',
			 'slide_position'=>'required'
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
			
			if($request->file('slide_image'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("splash_slides",$request->file('slide_image'), 'public');
				$fname1=str_replace("splash_slides/","",$fname1);
			}

			$res=SplashSlide::whereIn('slide_position',SplashSlide::select('slide_position')->get()->toArray())->update(['status'=>0]);
			
			$result=SplashSlide::create([
			 'title'=>$request->title,
			 'description'=>$request->description,
			 'slide_image'=>$fname1,
			 'slide_position'=>$request->slide_position,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
				
		
			if($result)
			{
				Session::flash('message', 'success#Slide successfully added.');
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
		
		return redirect('splash-slides');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) 
		{
            $data = $this->getSplashSlideData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','slide'])
                    ->make(true);
        }
	}
		
	public function getSplashSlideData($request)  //view data
	{

		$search=$request->search;
		
		$dats=SplashSlide::select('splash_slides.*','admins.name')
		->leftJoin('admins','splash_slides.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("splash_slides.title", 'like', '%' .$search . '%')
					->orWhere("splash_slides.description", 'like', '%' .$search . '%');
				})->orderBy('splash_slides.id','ASC')->get();

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
				
					if($r->slide_position==1){$pos="Slide-1";}
					else if($r->slide_position==2){$pos="Slide-2";}
					else if($r->slide_position==3){$pos="Slide-3";}
					else if($r->slide_position==4){$pos="Slide-4";}
									
					$uData['id'] = ++$key;
					$uData['title'] =$r->title;
					$uData['desc'] =$r->description;
					$uData['slide'] ="<img src='".config('constants.splash_slide').$r->slide_image."' style='width:100px;'>";
					$uData['pos'] =$pos;
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
    $ss=SplashSlide::where('id',$id)->first();
	return view('admin.splash.edit_splash_slide',compact('ss'));
  }	

		
	public function update_splash_slide(Request $request)
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
			
			$fname1=$request->slide_image;
			$ex_fname1=$request->slide_image;
			
			$id=$request->slide_id;
			
			if($request->file('slide_image_edit'))
			{ 
				$fname1=Storage::disk('spaces')->putFile("splash_slides",$request->file('slide_image_edit'), 'public');
				$fname1=str_replace("splash_slides/","",$fname1);
				Storage::disk('spaces')->delete("splash_slides".'/'.$request->slide_image);
				
			}

			$new_dat=[
			 'title'=>$request->title_edit,
			 'description'=>$request->description_edit,
			 'slide_image'=>$fname1,
			 'slide_position'=>$request->slide_position_edit,
			 ];
			
			$result=SplashSlide::whereId($id)->update($new_dat);
			
			if($result)
			{
				Session::flash('message', 'success#Slide successfully updated.');
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
		
		return redirect('splash-slides');
  }

	
  public function destroy($id)
	{
		$dat=SplashSlide::findorfail($id);
		
			if(!empty($dat))
			{
				$sfile=$dat->tips_file;
				
				$dat->delete();

				Storage::disk('spaces')->delete("splash_slides"."/".$sfile);
				
				return response()->json(['msg' =>'Slides successfuly removed.!' , 'status' => true]);
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
		
		$res=SplashSlide::whereIn('slide_position',SplashSlide::select('slide_position')->where('id',$id)->get()->toArray())->update(['status'=>0]);
				
		$result=SplashSlide::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Slide successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Slide successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}

}
