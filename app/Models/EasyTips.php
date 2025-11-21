<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasyTips extends Model
{
    use HasFactory;
		
	protected $table='easy_tips';
	
	protected $fillable = ['id','course_id','subject_id','chapter_id','title','description','tips_icon','tips_file','file_type','status','added_by'];
							 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';
		

}
