<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory;
		
	protected $table='course_category';
	
	protected $fillable = ['id','category','status','added_by'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';
		
	
	public const RULES=[
	
	];
	
	public const EDIT_RULES=[
	'category_edit'=>'required',
	];
	
	
}
