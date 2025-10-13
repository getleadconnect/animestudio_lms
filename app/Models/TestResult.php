<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;
		
	protected $table='test_results';
	
	protected $fillable = ['id','subject_id','question_paper_id','student_id','test_date',
						   'answer','wrong','skipped','marks','total_questions',
						   'negative','score','total_time','status'];
	 
    protected $hidden = [
		'updated_at',
    ];
	
	protected $primaryKey='id';

	// Add percentage attribute
	public function getPercentageAttribute()
	{
		if ($this->total_questions > 0) {
			return round(($this->score / ($this->total_questions * $this->marks)) * 100, 2);
		}
		return 0;
	}

	// Add test_name attribute (you might want to adjust this based on your actual data)
	public function getTestNameAttribute()
	{
		return 'Test #' . $this->id;
	}
}
