<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    use HasFactory;
		
	protected $table='notification_types';
	
	protected $fillable = ['id','type_name',];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
