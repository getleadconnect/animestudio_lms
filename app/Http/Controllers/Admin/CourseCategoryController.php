<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Center;
use App\Models\CourseCategory;

use Validator;
use DataTables;
use Session;
use Auth;

class CourseCategoryController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    return view('admin.courses.course_category');
  }	
  
  
  public function store(Request $request)
  {
		//try
		//{
			$usr_id=Auth::guard('admin')->user()->id;
			$cnt=$request->cat_count;

			$result="";
			
			for($x=0;$x<$cnt;$x++)
			{
				$cat=$request->category[$x];
				
				if($cat!="")
				{
					$result=CourseCategory::create([
					'category'=>$cat,
					'status'=>1,
					'added_by'=>$usr_id,
					]);
				}
			}
			
			if($result)
			{
				return response()->json(['msg' =>'Category successfully added!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Some details are missing, Please check.' , 'status' => false]);
			}
		//}
		//catch(\Exception $e)
		//{
			\Log::info($e->getMessage());
			return response()->json(['msg' =>'Something wrong, Try again.' , 'status' => false]);
		//}
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getCourseCategoryData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','stat'])
                    ->make(true);
        }
	}
		
	public function getCourseCategoryData($request)  //view data
	{

		$search=$request->search;
		
		$dats=CourseCategory::select('course_category.*','admins.name')
		->leftJoin('admins','course_category.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("course_category.category", 'like', '%' .$search . '%');
			  })->orderBy('course_category.id','ASC')->get();

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
					$uData['cat'] =$r->category;
					$uData['stat'] =$st;
					$uData['addedby'] =$r->name;
					
				
					$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item edit" href="javascript:void(0)" id="'.$r->id.'" data-bs-toggle="modal" data-bs-target="#BasicModal2" >Edit</a></li>
							  <li><a class="dropdown-item btnDel" href="javascript:void(0)" id="'.$r->id.'" >Delete</a></li>
                              <li>'.$btns.'</li>
                            </ul>
                        </div>';

					if($r->id==1)
					{
						$uData['action']="";
					}
					else
					{
						$uData['action'] = $dr_btn;
					}
					
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
		
	public function update_course_category(Request $request)
	{

		$validate=Validator::make($request->all(),CourseCategory::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		try
		{
			$new=[
				'category'=>$request->category_edit,
			];
					
			$result=CourseCategory::where('id',$request->category_id)->update($new);
			

			if($result)
			{
				return response()->json(['msg' =>'Category successfully updated!' , 'status' => true]);
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
		$dat=CourseCategory::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'Category successfuly removed.!' , 'status' => true]);
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

		$result=CourseCategory::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Category successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Category successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}

}
