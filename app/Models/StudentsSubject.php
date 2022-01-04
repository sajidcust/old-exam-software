<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsSubject extends Model
{
    use HasFactory;

    protected $fillable = array('student_id', 'subject_id');

	public static $rules = array(
		'student_id'=>'required|integer',
		'subject_id'=>'required|integer'
	);
}
