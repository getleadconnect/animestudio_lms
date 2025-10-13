<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDevice extends Model
{
    use HasFactory;

	protected $table='student_devices';
	
    protected $fillable = [
        'reg_date','student_id','student_name','mobile','version_release','manufacturer','model',
		'androidid','device','status'
    ];

	protected $primaryKey = 'id';


    protected $hidden = [
		'created_at',
		'updated_at',
    ];

	
}
