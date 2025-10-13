<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpApi extends Model
{
    use HasFactory;
		
	protected $table='otp_apis';
	
	protected $fillable = ['id','api_url','status'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
