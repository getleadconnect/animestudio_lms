<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfFile extends Model
{
    use HasFactory;
		
	protected $table='pdf_files';
	
	protected $fillable = ['id','course_id','subject_id','chapter_id','title',
						'pdf_icon','pdf_file','description','status','added_by'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';
		
	
	
}
