<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamTabHeading extends Model
{
    use HasFactory;
		
	protected $table='exam_tab_headings';
	
	protected $fillable = ['id','course_id','tab_heading','status'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
    public function questionPaper()
    {
		return $this->hasMany(QuestionPaper::class,'exam_tab_heading_id','id',)->where('status','=',1);
    }


}
