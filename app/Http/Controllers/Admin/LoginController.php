<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Validator;
use Session;

use Illuminate\Foundation\Auth\User as Authenticatable;

class LoginController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        /*$this->middleware('admin')->except([
            'logout', 'dashboard'
        ]);*/
    }

    
    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	   return view('admin.login.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
 
		$validate=Validator::make($request->all(),[
	        'email'    => 'required|email',
	        'password' => 'required',
	       ]);        
    
		if($validate->fails())
		{
			return back()->withErrors(['err'=>"Email/Password is invalid."])->withInput();
		}
		
		$email=trim($request->email);
		
		if (Auth::guard('admin')->attempt($request->only('email','password')))
		{
			$ad=Admin::where('email',$email)->get()->first();
			Session::put(['admin_id'=>$ad->id]);
			Session::put(['admin_name'=>$ad->name]);
			Session::put(['admin_role_id'=>$ad->role_id]);
			return redirect('dashboard');
		 }
		
		return back()->withErrors(['err' => 'Invalid Email/Password.']);

    } 
    
    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
	 
	public function dashboard()
    {
        if(Auth::check())
        {
			return redirect()->route('dashboard');
        }
        
        return redirect()->route('admin.login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    } 
    
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')
            ->withSuccess('You have logged out successfully!');;
    }    


	public function change_password(Request $request)
	{
		$uname=$request->user_name;
		$npass=$request->new_pass;
		$cpass=$request->confirm_pass;
		
		$uid=$request->admin_id;
		
		if($npass==$cpass)
		{
			$new=['password'=>Hash::make($cpass)];
			$result=Admin::whereId($uid)->update($new);
			
			if($result)
			{
				return response()->json(['msg' =>'Password successfully Changed!' , 'status' => true]);
			}
			else
			{
				return response()->json(['msg' =>'Something wrong, Try again.' , 'status' => false]);
			}
		}
		else
		{
			return response()->json(['msg' =>'Password does not match, Try again.' , 'status' => false]);
		}
		
	}



}
