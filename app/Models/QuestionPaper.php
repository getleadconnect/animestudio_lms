<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionPaper extends Model
{
    use HasFactory;
		
	protected $table='question_papers';
	
	protected $fillable = ['id','free_test','course_id','subject_id','exam_tab_heading_id','question_paper_name',
						'start_date','duration','description','explanation_video','status','added_by'
						];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
	
	
	protected $casts = [
    'start_date'  =>'datetime:Y-m-d H:i:s',
	];
	
	
}
