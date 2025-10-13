<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempotp extends Model
{
    use HasFactory;
		
	protected $table='tempotps';
	
	protected $fillable = ['id','mobile','otp'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
