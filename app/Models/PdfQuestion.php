<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfQuestion extends Model
{
    use HasFactory;
		
	protected $table='pdf_questions';
	
	protected $fillable = ['id','course_id','title','pdf_question_file','start_date','status','added_by'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
