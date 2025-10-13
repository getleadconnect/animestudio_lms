<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectProficiency extends Model
{
    use HasFactory;
		
	protected $table='subject_proficiency';
	
	protected $fillable = ['id','student_id','qbank_subject_id','subject_name','subject_average'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';
	

}
