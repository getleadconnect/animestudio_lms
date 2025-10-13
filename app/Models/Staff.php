<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
		
	protected $table='staffs';
	
	protected $fillable = ['id','center_id','staff_name','address','email','mobile',
						'referral_code','percentage','status','added_by'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
