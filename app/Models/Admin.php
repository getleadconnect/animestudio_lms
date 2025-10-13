<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

use Session;

class Admin extends Authenticatable
{
    use HasFactory;
	
	protected $table='admins';
	
    protected $fillable = [
      'name','center_id','role_id','email','mobile','password','status',
    ];

    protected $hidden = [
		'password',
		'created_at',
		'updated_at',
    ];
	
	
	public const PASS_RULES=[
	'new_password'=>'required',
	'conf_password'=>'required|same:new_password',
	];
	
	
	
	
}
