<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteAccountRequest extends Model
{
    use HasFactory;
		
	protected $table='delete_account_requests';
	
	protected $fillable = ['id','name','mobile','student_id','message'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
