<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedVideoComment extends Model
{
    use HasFactory;
		
	protected $table='recorded_video_comments';
	
	protected $fillable = ['id','course_id','student_id','recorded_live_class_id','comments'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
