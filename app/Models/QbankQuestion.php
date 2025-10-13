<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QbankQuestion extends Model
{
    use HasFactory;
		
	protected $table='qbank_questions';
	
	protected $fillable = ['id','qbank_subject_id','question_type','question','answer1','answer2',
							'answer3','answer4','correct_answer'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
