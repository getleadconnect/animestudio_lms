<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QbankSubject extends Model
{
    use HasFactory;
		
	protected $table='qbank_subjects';
	
	protected $fillable = ['id','subject_name','status','added_by'];
	 
    protected $hidden = [
		'created_at',
		'updated_at',
    ];
	
	protected $primaryKey='id';	
		
}
