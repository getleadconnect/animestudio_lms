<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
		
	protected $table='videos';
	
	protected $fillable = ['id','course_id','subject_id','chapter_id','title',
						'video_icon','video_file','duration','teacher_name',
						'description','explanation','status','added_by'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
