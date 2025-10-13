<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
		
	protected $table='notifications';
	
	protected $fillable = ['id','center_id','course_id','message','title','notification_type_id',
	'push_status','status','added_by'];
	 
    protected $hidden = [
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
