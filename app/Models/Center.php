<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;
		
	protected $table='centers';
	
	protected $fillable = ['id','center_name','address','contact_person','mobile','status','added_by'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';
		
	
	public const RULES=[
	'center_name'=>'required',
	'address'=>'required',
	'mobile'=>'required',
	'email'=>'required',
	];
	
	public const EDIT_RULES=[
	'center_name_edit'=>'required',
	'address_edit'=>'required',
	'mobile_edit'=>'required',
	'email_edit'=>'required',
	];
}
