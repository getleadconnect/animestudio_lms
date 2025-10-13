<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemovedStudent extends Model
{
    use HasFactory;
		
	protected $table='removed_students';
	
	protected $fillable = ['id','center_id','student_name','date_of_birth','mobile',
						'email','district','place'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';
		
	
	
}
