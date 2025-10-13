<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedLiveClass extends Model
{
    use HasFactory;
		
	protected $table='recorded_live_classes';
	
	protected $fillable = ['id','course_id','title','description','class_icon','video_file',
	'duration','class_by','status','added_by'];
							 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';
		
	
	
	
	
	
	
	
	
	
}
