<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCompletedStatus extends Model
{
    use HasFactory;
		
	protected $table='video_completed_status';
	
	protected $fillable = ['id','course_id','subject_id','chapter_id','student_id','video_id','completed_status'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
