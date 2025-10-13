<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\ExamTabHeading;

use Validator;
use DataTables;
use Session;
use Auth;

class ExamTabHeadingController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    $cid=Auth::guard('admin')->user()->center_id;
	$crs=Course::where('center_id',$cid)->where('status',1)->get();	
	return view('admin.model_tests.tab_headings',compact('crs'));
  }	
   
   
  public function store(Request $request)
  {
		 $validate = Validator::make(request()->all(),[
             'course_id'=>'required',
			 'tab_heading'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		
		try
		{
			$usr_id=Auth::guard('admin')->user()->id;
			$cnt=$request->tab_count;

			$result="";
			
			for($x=0;$x<$cnt;$x++)
			{
				$tab_head=$request->tab_heading[$x];
				
				if($tab_head!="")
				{
					$result=ExamTabHeading::create([
					'course_id'=>$request->course_id,
					'tab_heading'=>$tab_head,
					'status'=>1,
					]);
				}
			}
			
			if($result)
			{
				Session::flash('message', 'success#Tab heading successfully added.');
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
		
		return redirect('tab-headings');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getTabHeadings($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
	}
		
	public function getTabHeadings($request)  //view data
	{

		$search=$request->search;
		
		$dats=ExamTabHeading::select('exam_tab_headings.*','courses.course_name')
		->leftJoin('courses','exam_tab_headings.course_id','=','courses.id')
		->where(function($where) use($search)
			    {
					$where->where("exam_tab_headings.tab_heading", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%');
			  })->orderBy('exam_tab_headings.id','ASC')->get();

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
					$uData['tabh'] =$r->tab_heading;
					$uData['status'] =$st;

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
		$cid=Auth::guard('admin')->user()->center_id;
		$crs=Course::where('center_id',$cid)->where('status',1)->get();	
		$eth=ExamTabHeading::whereId($id)->first();
		return view('admin.model_tests.edit_tab_heading',compact('crs','eth'));
	}
		
	public function update_tab_heading(Request $request)
	{

		$validate=Validator::make($request->all(),[
			'course_id_edit'=>'required',
			'tab_heading_edit'=>'required'
		]);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		try
		{
			$new=[
				'course_id'=>$request->course_id_edit,
				'tab_heading'=>$request->tab_heading_edit,
			];
					
			$result=ExamTabHeading::where('id',$request->tab_head_id)->update($new);
			

			if($result)
			{
				return response()->json(['msg' =>'Tab heading successfully updated!' , 'status' => true]);
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
		$dat=ExamTabHeading::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'Tab heading successfully removed.!' , 'status' => true]);
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

		$result=ExamTabHeading::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Tab heading successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Tab heading successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}

}
