<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
		
	protected $table='subscriptions';
	
	protected $fillable = ['id','student_id','course_id','rate','referral_code','referral_value',
						    'net_amount','start_date','end_date','staff_id','status'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';

	// Define relationship with Course model
	public function course()
	{
		return $this->belongsTo(Course::class, 'course_id', 'id');
	}

	// Define relationship with Student model
	public function student()
	{
		return $this->belongsTo(Student::class, 'student_id', 'id');
	}
}
