<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerImage extends Model
{
    use HasFactory ;
		
	protected $table='banner_images';
	
	protected $fillable = ['id','banner_image','banner_link','course_category_id','course_id','banner_type','status','added_by'];
							 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';
		
	
	
	
	
	
	
	
	
	
}
