<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Models\Center;
use App\Models\Notification;
use App\Models\Course;
use App\Models\User;
use App\Models\Subscription;
use App\Models\NotificationType;
use App\Notification\FirebasePushNotification;

use Validator;
use DataTables;
use Session;
use Auth;

class NotificationController extends Controller
{
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$center=Auth::guard('admin')->user()->center_id;
    $crs=Course::where('status',1)->where('center_id',$center)->get();
    $ntype=NotificationType::all();  
    return view('admin.notification.notifications',compact('crs','ntype'));
  }	
   
  public function store(Request $request)
  {
	  $validate = Validator::make(request()->all(),[
             'notification_type'=>'required',
			 'message'=>'required',
			 'notification_title'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{
			$usr_id=Auth::guard('admin')->user()->id;
			
			$result=Notification::create([
			 'center_id'=>Auth::guard('admin')->user()->center_id,
			 'course_id'=>$request->course_id,
			 'notification_type_id'=>$request->notification_type,
			 'title'=>$request->notification_title,
			 'message'=>$request->message,
			 'required'=>$request->description,
			 'status'=>1,
			 'added_by'=>$usr_id
			]);
			
			if($result)
			{
				return response()->json(['msg' =>'Notification successfully added!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Some details are missing , try again.' , 'status' => false]);
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['msg' =>'Something wrong, Try again.'.$e->getMessage() , 'status' => false]);
		}
				
		//return redirect('notifications');
  }



public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->getNotificationData($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','pstatus','status'])
                    ->make(true);
        }
	}
		
	public function getNotificationData($request)  //view data
	{

		$search=$request->search;
		$search_course=$request->searchCourse;
		$search_mtype=$request->searchMtype;
				
		$dts=Notification::select('notifications.*','centers.center_name','courses.course_name','admins.name','notification_types.type_name')
		->leftJoin('centers','notifications.center_id','=','centers.id')
		->leftJoin('admins','notifications.added_by','=','admins.id')
		->leftJoin('courses','notifications.course_id','=','courses.id')
		->leftJoin('notification_types','notifications.notification_type_id','=','notification_types.id')
		->where(function($where) use($search)
			    {
					$where->where("notifications.message", 'like', '%' .$search . '%')
					->orWhere("courses.course_name", 'like', '%' .$search . '%')
					->orWhere("notification_types.type_name", 'like', '%' .$search . '%')
					->orWhere("notifications.push_status", 'like', '%' .$search . '%')
					->orWhere("notifications.status", 'like', '%' .$search . '%');
				});
				
		if($search_course!="")
		{
			$dts->where('notifications.course_id',$search_course);
		}
		
		if($search_mtype!="")
		{
			$dts->where('notifications.notification_type_id',$search_mtype);
		}
						
		$dats=$dts->orderBy('notifications.id','ASC')->get();

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
				$uData['cname'] =$r->course_name??"--";
				$uData['title'] =$r->title;
				$uData['mess'] =$r->message;
				$uData['ntype'] =$r->type_name;
				$uData['pstatus'] =($r->push_status==1)?"<span style='color:green'>Send</send>":"<span style='color:blue'>No</send>";
				$uData['status'] =$st;
				$uData['addedby'] =$r->name;
				

					$dr_btn='<div class="fs-5 ms-auto dropdown">
                          <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="fadeIn animated bx bx-dots-vertical"></i></div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item edit" href="javascript:void(0)" id="'.$r->id.'"  data-bs-toggle="modal" data-bs-target="#BasicModal2" >Edit</a></li>
							  <li><a class="dropdown-item btnDel" href="javascript:void(0)" id="'.$r->id.'" >Delete</a></li>
                              <li>'.$btns.'</li>
							  <li><a class="dropdown-item btnSend" href="javascript:void(0)" id="'.$r->id.'" >Send Push Notification</a></li>
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
    $center=Auth::guard('admin')->user()->center_id;
    $crs=Course::where('status',1)->where('center_id',$center)->get();
	$nt=Notification::where('id',$id)->first();
    $ntype=NotificationType::all();
	return view('admin.notification.edit_notification',compact('crs','ntype','nt'));
  }	


public function update_notification(Request $request)
  {
		$validate = Validator::make(request()->all(),[
             'notification_type_edit'=>'required',
			 'message_edit'=>'required',
			 'notification_title_edit'=>'required',
        ]);
	  
	    if ($validate->fails())
        {
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
        }
	
		try
		{
			$id=$request->notify_id;
			$usr_id=Auth::guard('admin')->user()->id;
					
			$new_dt=[
			 'course_id'=>$request->course_id_edit,
			 'notification_type_id'=>$request->notification_type_edit,
			 'title'=>$request->notification_title_edit,
			 'message'=>$request->message_edit,
			 'added_by'=>$usr_id
			];
			
			$result=Notification::where('id',$id)->update($new_dt);
			
			if($result)
			{
				Session::flash('message', 'success#Notification successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Some details are missing, Try again.');
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			Session::flash('message', 'danger#'.$e->getMessage());
		}
				
		return redirect('notifications');
  }

	
   public function destroy($id)
	{
		$dat=Notification::findorfail($id);
		
			if(!empty($dat))
			{
				$dat->delete();
				return response()->json(['msg' =>'Notification successfuly removed.!' , 'status' => true]);
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

		$result=Notification::where('id',$id)->update($new);

			if($result)
			{
				if($op==1)
					return response()->json(['msg' =>'Notification successfully activated!' , 'status' => true]);
				else
				    return response()->json(['msg' =>'Notification successfully deactivated!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
			}				

	}


/*public function sendNotification() //test function
{
	$deviceToken="cwMTyPm4Q02AeIpT3BkL9y:APA91bGlztGCDv512ciJCD5MCQFKkn4vpuproApwrPEeRp1RtSPcAntDYI-NWwBnjRqLkKzOvyBoR8jGCuj3VaSE_Vtx3-5wC2OmaVf9loegdoP5yZHswh6BfT7-wQzGxDzFZvjfZ_jC";

	$notificationPayload=[
	'title'=>"This is testing notification",
	'body'=>'You have a new message from aim balussery. Thank You.',
	];

	$result=FirebasePushNotification::sendPushNotification($deviceToken,$notificationPayload);
	$res=json_decode($result);
	if($res->success==1)
	{
		$response=['msg' =>'Notification Successfully send!' , 'status' => true];
	}
	else
	{
		$reponse=['msg' =>'Something wrong, try again!' , 'status' => false];
	}
	
	return response()->json($response);
}*/


public function sendPushNotification($noti_id)
{
	$noti=Notification::whereId($noti_id)->first();
		
	$token=[];
	if(!empty($noti) and $noti->notification_type_id==1)	
	{
		$stid=Subscription::where('status',1)->pluck('student_id');
		$tokens=User::whereIn('student_id',Subscription::where('status',1)->pluck('student_id'))->where('fcm_token','!=',null)->pluck('fcm_token');
	
		if(!empty($tokens))
		{
		
			$deviceToken=$tokens; //tokens array for send message to multiple user

			$notificationPayload=[
			'title'=>$noti->title,
			'body'=>$noti->message,
			];

			$result=FirebasePushNotification::sendPushNotification($deviceToken,$notificationPayload);
	
			// update status ------------------------
			$not_dt=['push_status'=>1];
			$noti_res=Notification::whereId($noti_id)->update($not_dt);
			//------------------
			
			$response=['msg' =>'Notification successfully send!' , 'status' => true];

		}
		else
		{
			$reponse=['msg' =>'Something wrong, try again!' , 'status' => false];
		}
		
	}
	else if(!empty($noti) and $noti->notification_type_id==2)	
	{
		
		
		$stid=Subscription::where('status',1)->where('course_id',$noti->course_id)->pluck('student_id');
		$tokens=User::whereIn('student_id',Subscription::where('status',1)->pluck('student_id'))->where('fcm_token','!=',null)->pluck('fcm_token');
	
		if(!empty($tokens))
		{
		
			$deviceToken=$tokens;  //tokens array for send message to multiple user

			$notificationPayload=[
			'title'=>$noti->title,
			'body'=>$noti->message,
			];

			$result=FirebasePushNotification::sendPushNotification($deviceToken,$notificationPayload);
	
			// update status ------------------------
			$not_dt=['push_status'=>1];
			$noti_res=Notification::whereId($noti_id)->update($not_dt);
			//------------------
			
			$response=['msg' =>'Notification successfully send!' , 'status' => true];

		}
		else
		{
			$reponse=['msg' =>'Something wrong, try again!' , 'status' => false];
		}	
	
	}
	else
	{
		$reponse=['msg' =>'Something wrong, try again!' , 'status' => false];
	}

return response()->json($response);

}



}
