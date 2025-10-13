<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SplashSlide extends Model
{
    use HasFactory;
		
	protected $table='splash_slides';
	
	protected $fillable = ['id','title','description','slide_image','slide_position','status','added_by'];
							 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';
		

}
