<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    use HasFactory;
		
	protected $table='live_classes';
	
	protected $fillable = ['id','course_id','subject_id','conducted_by','title','description',
						'class_icon','class_link','start_date','start_time','end_time','status','added_by'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
