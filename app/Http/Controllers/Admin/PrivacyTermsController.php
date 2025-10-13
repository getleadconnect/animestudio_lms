<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Center;
use App\Models\PrivacyPolicy;

use Validator;
use DataTables;
use Session;
use Auth;
use DB;

class PrivacyTermsController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 return view('admin.policy.policy');
  }	
  

public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getPolicyData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','cat','policy'])
                    ->make(true);
        }
	}
		
	public function getPolicyData($request)  //view data
	{

		$search=$request->search;
		
				
		$dts=PrivacyPolicy::select('privacy_policy.*','admins.name')
		->leftJoin('admins','privacy_policy.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("privacy_policy.policy", 'like', '%' .$search . '%')
					->orWhere("privacy_policy.category", 'like', '%' .$search . '%');
				});
						  
		$dats=$dts->orderBy('privacy_policy.id','ASC')->get();
		
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
					
					if($r->category==1)
					{
						$pt='<span class="badge bg-info">Privacy</span>';
					}
					else
					{
						$pt='<span class="badge bg-primary">Terms</span>';
					}
				
					$uData['id'] = ++$key;
					$uData['cat'] =$pt;
					$uData['policy'] =substr($r->policy,0,300)."..." ."<a href='' class='more' id='".$r->id."' data-bs-toggle='modal' data-bs-target='#BasicModal3'><b>more</b></a>";
					$uData['status'] =$st;
					$uData['addedby'] =$r->name;

										
					$dr_btn='<a href="'.url('edit-policy').'/'.$r->id.'" class="edit btn btn-primary btn-rect btn-xs btn-sm fap" title="Edit" ><i class="fa fa-edit" ></i></a>'; 
					
				   $uData['action'] = $dr_btn;
				

			    $data[] = $uData;
			}
        }
		return $data;
	}		

  public function edit($id)
  {
    if($id==1)
	{
		$ss=PrivacyPolicy::where('id',$id)->first();
		return view('admin.policy.edit_privacy',compact('ss'));
	}
	else
	{
		$ss=PrivacyPolicy::where('id',$id)->first();
		return view('admin.policy.edit_terms',compact('ss'));
	}
	
  }	
  		
	public function update_policy(Request $request)
	{

		$validate = Validator::make(request()->all(),[
			 'policy'=>'required',
        ]);
	  	  
	    if ($validate->fails())
        {
            Session::flash('message', 'danger#Some details are missing, try again.');
			return back()->withErrors($validate)->withInput();
        }

		try
		{
			$id=$request->policy_id;
			
			$new_dat=[
			 'policy'=>$request->policy,
			 ];
			
			$result=PrivacyPolicy::whereId($id)->update($new_dat);
		
				if($result)
			{
				Session::flash('message', 'success#Policy successfully updated.');
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
		
		return redirect('policy');
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

		$result=PrivacyPolicy::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Policy successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Policy successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}
	
	
	public function get_policy_data($id)
	{
		
		$policy=PrivacyPolicy::where('id',$id)->first();

		if(!empty($policy))
		{
			return response()->json(['policy' =>$policy->policy, 'status' => true]);
		}
		else
		{
			return response()->json(['policy' =>"data not found!", 'status' =>false]);
		}
	}
	
	
	
}
