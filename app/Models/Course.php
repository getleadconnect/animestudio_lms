<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
		
	protected $table='courses';
	
	protected $fillable = ['id','center_id','course_name','description','start_date','end_date',
							'course_category_id','course_type_id','course_wide_icon','course_square_icon',
							'video_file','rate','discount_rate','ios_rate','app_store_product_id',
							'subscription_type','course_details','premium','status','added_by'];
							 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';
		
	
	
	
	
	
	
	
	
	
}
