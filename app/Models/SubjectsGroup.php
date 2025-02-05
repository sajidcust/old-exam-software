<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectsGroup extends Model
{
    use HasFactory;

    protected $fillable = array('class_id', 'subject_id');

	public static $rules = array(
		'class_id'=>'required|integer',
        'subject_id'=>'required|integer'
	);
}
