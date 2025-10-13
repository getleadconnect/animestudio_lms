<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use App\Models\Center;
use App\Models\Staff;

use Validator;
use DataTables;
use Session;
use Auth;
use DB;

class StaffController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
 	$center=Center::where('status',1)->get();	
	return view('admin.staff.staffs',compact('center'));
  }	
  	
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'center_id'=>'required',
			 'staff_name'=>'required',
			 'address'=>'required',
			 'email'=>'required',
			 'mobile'=>'required',
			 'ref_code'=>'required',
			 'percentage'=>'required',
        ]);
	  
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }

		try
		{
			
			$usr_id=Auth::guard('admin')->user()->id;
			$cid=Auth::guard('admin')->user()->center_id;

			$result=Staff::create([
			 'center_id'=>$request->center_id,
			 'staff_name'=>$request->staff_name,
			 'address'=>$request->address,
			 'email'=>$request->email,
			 'mobile'=>$request->mobile,
			 'referral_code'=>Str::upper($request->ref_code),
			 'percentage'=>$request->percentage,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
						
			if($result)
			{
				Session::flash('message', 'success#Staff details successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Some details are missing. try again');
			}
			
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			Session::flash('message', 'danger#Something wrong, Try again.');
		}
		
		return redirect('staffs');
  }


public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getStaffsData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
	}
		
	public function getStaffsData($request)  //view data
	{

		$search=$request->search;
		$center_id=$request->searchCenterId;
		
		//$cid=Auth::guard('admin')->user()->center_id;
		
		$dts=Staff::select('staffs.*','centers.center_name','admins.name')
		->leftJoin('admins','staffs.added_by','=','admins.id')
		->leftJoin('centers','staffs.center_id','=','centers.id')
		->where(function($where) use($search)
			    {
					$where->where("staffs.staff_name", 'like', '%' .$search . '%')
					->orWhere("staffs.email", 'like', '%' .$search . '%')
					->orWhere("staffs.mobile", 'like', '%' .$search . '%')
					->orWhere("centers.center_name", 'like', '%' .$search . '%');
				});
		
		if($center_id!="")
		{
			$dts->where('staffs.center_id',$center_id);
		}			
					  
		$dats=$dts->orderBy('staffs.id','ASC')->get();
		
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
					$uData['center'] =$r->center_name;
					$uData['sname'] =$r->staff_name;
					$uData['add'] =$r->address;
					$uData['email'] =$r->email;
					$uData['mob'] =$r->mobile;
					$uData['rcode'] =$r->referral_code;
					$uData['per'] =$r->percentage."%";
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
    $st=Staff::where('id',$id)->first();
	$center=Center::where('status',1)->get();	
	return view('admin.staff.edit_staff',compact('st','center'));
  }	
		
	public function update_staff(Request $request)
	{

	  $validate = Validator::make(request()->all(),[
             'center_id_edit'=>'required',
			 'staff_name_edit'=>'required',
			 'address_edit'=>'required',
			 'email_edit'=>'required',
			 'mobile_edit'=>'required',
			 'ref_code_edit'=>'required',
			 'percentage_edit'=>'required',
        ]);
	  
	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }

		try
		{

			$id=$request->staff_id;

			$new_dat=[
			 'center_id'=>$request->center_id_edit,
			 'staff_name'=>$request->staff_name_edit,
			 'address'=>$request->address_edit,
			 'email'=>$request->email_edit,
			 'mobile'=>$request->mobile_edit,
			 'referral_code'=>Str::upper($request->ref_code_edit),
			 'percentage'=>$request->percentage_edit,
			];
			
			$result=Staff::whereId($id)->update($new_dat);
			
			if($result)
			{
				Session::flash('message', 'success#Staff details successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Some details are missing. try again');
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			Session::flash('message', 'danger#Something wrong, Try again.');
		}
		
		return redirect('staffs');
  }

	
   public function destroy($id)
	{
		$dat=Staff::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'Staff details successfuly removed.!' , 'status' => true]);
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

		$result=Staff::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Staff details successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Staff details successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}
	
	
}
