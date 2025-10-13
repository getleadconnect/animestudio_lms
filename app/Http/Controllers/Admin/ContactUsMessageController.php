<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use App\Models\ContactUsMessage;

use Validator;
use DataTables;
use Session;
use Auth;

class ContactUsMessageController extends Controller
{

  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	return view('admin.general_files.view_contact_us_messages');
  }

public function view_data(Request $request)
	{

		if ($request->ajax()) 
		{
            $data = $this->getContactUsMessagesData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status','bimage'])
                    ->make(true);
        }
	}
		
	public function getContactUsMessagesData($request)  //view data
	{

		$search=$request->search;
		
		$dats=ContactUsMessage::where(function($where) use($search)
			{
				$where->where("contact_us_messages.name", 'like', '%' .$search . '%')
				->orWhere("contact_us_messages.mobile", 'like', '%' .$search . '%')
				->orWhere("contact_us_messages.email", 'like', '%' .$search . '%')
				->orWhere("contact_us_messages.message", 'like', '%' .$search . '%');
			})->orderBy('contact_us_messages.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
			
					$uData['id'] = ++$key;
					$uData['name'] =$r->name;
					$uData['mob'] =$r->mobile;
					$uData['ema'] =$r->email;
					$uData['mesg'] =$r->message;
				
					$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item btnDel" href="javascript:void(0)"  id="'.$r->id.'">Delete</a></li>
                            </ul>
                        </div>';
					
					$uData['action'] = $dr_btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

 
	
  public function destroy($id)
	{
		$dat=ContactUsMessage::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'Message successfuly removed.!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				
	}
		


}
