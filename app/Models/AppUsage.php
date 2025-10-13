<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUsage extends Model
{
    use HasFactory;
		
	protected $table='app_usages';
	
	protected $fillable = ['id','student_id','usage_seconds'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	

	
}
