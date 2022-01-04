<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsSemester extends Model
{
    use HasFactory;

    protected $fillable = array('semester_id', 'student_id');

	public static $rules = array(
        'student_id'=>'required|integer',
        'semester_id'=>'required|integer'
	);
}
