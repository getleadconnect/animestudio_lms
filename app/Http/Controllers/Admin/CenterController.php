<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Center;

use Validator;
use DataTables;
use Session;
use Auth;
use Log;

class CenterController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    return view('admin.center.center');
  }	
  
   public function store(Request $request)
	{

	}
	
	public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getCenterData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','stat'])
                    ->make(true);
        }
	}
		
	public function getCenterData($request)  //view data
	{

		$search=$request->search;
		
		$dats=Center::select('centers.*','admins.name')
		->leftJoin('admins','centers.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("centers.center_name", 'like', '%' .$search . '%')
						->orWhere("centers.email", 'like', '%' .$search . '%')
						->orWhere("centers.mobile", 'like', '%' .$search . '%')
						->orWhere("centers.address", 'like', '%' .$search . '%');
			  })->orderBy('centers.id','ASC')->get();

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
					$uData['cname'] =$r->center_name;
					$uData['add'] =$r->address;
					$uData['email'] =$r->email;
					$uData['mob'] =$r->mobile;
					$uData['stat'] =$st;
					$uData['addedby'] =$r->name;
					
					$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item edit" href="javascript:void(0)" id="'.$r->id.'" data-bs-toggle="modal" data-bs-target="#BasicModal2" >Edit</a></li>
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
	
	public function update_center(Request $request)
	 {

		$validate=Validator::make($request->all(),Center::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		try
		{
		
			$new=[
			'center_name'=>$request->center_name_edit,
			'address'=>$request->address_edit,
			'mobile'=>$request->mobile_edit,
			'email'=>$request->email_edit,
			];
					
			$result=Center::where('id',$request->center_id)->update($new);
				
			if($result)
			{
				Session::flash('message', 'success#Center successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}
		}
		catch(\Exception $e)
		{
			\LOG::info($e->getMessage());
			Session::flash('message', 'danger#Something wrong, try again.');
		}
		
		return redirect('centers');
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

		$result=Center::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
				return response()->json(['msg' =>'Center successfulyy Activated!' , 'status' => true]);
				else
				return response()->json(['msg' =>'Center successfulyy deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, Try again.' , 'status' =>false]);
			}				

	}
	
  /* public function destroy($id)
	{

		$result=(new Company())->deleteCompany($id);
		
			if($result)
			{
				$res=1;
			}
			else
			{
				$res=0;
			}				
			return $res;
	}
	
   public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new Company())->viewCompany($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','status'])
                    ->make(true);
        }
		
	}

	
	*/
}
