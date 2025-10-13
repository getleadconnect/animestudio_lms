<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAllResult extends Model
{
    use HasFactory;
		
	protected $table='test_all_results';
	
	protected $fillable = ['id','qbank_subject_id','question_paper_id','student_id','question_id',
						   'correct_answer','answer','wrong_status','skipped_status'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
