<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
		
	protected $table='payments';
	
	protected $fillable = ['id','student_id','course_id','referral_code','referral_value',
	'course_rate','net_amount','payment_id'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
