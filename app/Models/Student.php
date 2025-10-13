<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
		
	protected $table='students';
	
	protected $fillable = ['id','center_id','student_name','date_of_birth','mobile',
						'email','district_id','place','status','staff_id',
						'learn_category_id','added_by'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';
		
	
	
}
