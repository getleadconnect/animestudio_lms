<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\Center;
use App\Models\Admin;
use App\Models\Role;

use Validator;
use DataTables;
use Session;
use Auth;
use Log;

class AdminUserController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    $center=Center::where('status',1)->get();	
	$rol=Role::where('id','!=',1)->get();	
	return view('admin.users.admin_users',compact('center','rol'));
  }	
  
 
   public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'admin_name'=>'required',
			 'email'=>'required',
			 'mobile'=>'required',
			 'role_id'=>'required',
			 'password'=>'required',
        ]);
	  	  
	    if ($validate->fails())
        {
           return response()->json(['msg' =>'Some details are missing, try again.' , 'status' => false]);
        }

		$cnt=Admin::where('email',$request->email)->count();
		if($cnt>0)
		{
			
			return response()->json(['msg' =>'User email already exist, try again.' , 'status' => false]);
		}

		try
		{
			
			$cid=Auth::guard('admin')->user()->center_id;

			$result=Admin::create([
			 'center_id'=>$cid,
			 'name'=>$request->admin_name,
			 'email'=>$request->email,
			 'mobile'=>$request->mobile,
			 'role_id'=>$request->role_id,
			 'password'=>Hash::make($request->password),
			 'status'=>1,
			]);
						
			if($result)
			{
				return response()->json(['msg' =>'User details successfully added!' , 'status' => true]);
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
		
		//return redirect('admin-users');
  }
	
	
	public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getAdminUserData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
	}
		
	public function getAdminUserData($request)  //view data
	{

		$search=$request->search;
		
		$dats=Admin::select('admins.*','centers.center_name','roles.role')
		->leftJoin('centers','admins.center_id','=','centers.id')
		->leftJoin('roles','admins.role_id','=','roles.id')
		->where('role_id','!=',1)
		->where(function($where) use($search)
			    {
					$where->where("admins.name", 'like', '%' .$search . '%')
						->orWhere("admins.email", 'like', '%' .$search . '%')
						->orWhere("admins.mobile", 'like', '%' .$search . '%')
						->orWhere("roles.role", 'like', '%' .$search . '%')
						->orWhere("centers.center_name", 'like', '%' .$search . '%');
			  })->orderBy('admins.id','ASC')->get();

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
					$uData['name'] =$r->name;
					$uData['email'] =$r->email;
					$uData['mob'] =$r->mobile;
					$uData['rol'] =$r->role;
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
		$au=Admin::whereId($id)->first();
		$rol=Role::where('id','!=',1)->get();
		return view('admin.users.edit_admin_user',compact('au','rol'));
	}
	
	public function update_admin_user(Request $request)
	 {

		$validate=Validator::make($request->all(),
		[ 'name_edit'=>'required',
		  'email_edit'=>'required',
		  'mobile_edit'=>'required',
		  'role_id_edit'=>'required'
		 ]);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		try
		{
			
			if($request->has('password_edit'))
			{
				$new=[
					'name'=>$request->name_edit,
					'mobile'=>$request->mobile_edit,
					'email'=>$request->email_edit,
					'role_id'=>$request->role_id_edit,
					'password'=>Hash::make($request->password_edit)
					];
				
			}
			else
			{
				$new=[
				'name'=>$request->name_edit,
				'mobile'=>$request->mobile_edit,
				'email'=>$request->email_edit,
				'role_id'=>$request->role_id_edit,
				];
			}
					
			$result=Admin::where('id',$request->admin_id)->update($new);
				
			if($result)
			{
				Session::flash('message', 'success#User successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.1');
			}
		}
		catch(\Exception $e)
		{
			\LOG::info($e->getMessage());
			Session::flash('message', 'danger#Something wrong, try again.');
		}
		
		return redirect('admin-users');
	}
	
	public function destroy($id)
	{
		$dat=Admin::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'User successfuly removed.!' , 'status' => true]);
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

		$result=Admin::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
				return response()->json(['msg' =>'User successfulyy Activated!' , 'status' => true]);
				else
				return response()->json(['msg' =>'User successfulyy deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, Try again.' , 'status' =>false]);
			}				

	}


}
