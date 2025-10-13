<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QpaperAttended extends Model
{
    use HasFactory;
		
	protected $table='qpaper_attended';
	
	protected $fillable = ['id','student_id','question_paper_id' ];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
	
}
