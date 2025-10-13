<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestRankList extends Model
{
    use HasFactory;
		
	protected $table='test_rank_list';
	
	protected $fillable = ['id','subject_id','question_paper_id','student_id','test_date',
						   'answer','wrong','skipped','marks','total_questions',
						   'negative','score','total_time','status'];
	 
    protected $hidden = [
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
