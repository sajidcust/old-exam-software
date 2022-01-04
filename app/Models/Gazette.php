<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gazette extends Model
{
    use HasFactory;

    protected $fillable = array('student_id', 'result');

	public static $rules = array(
		'student_id'=>'required',
		'result'=>'required|integer'
	);
}
