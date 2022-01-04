<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    use HasFactory;

    protected $fillable = array('name', 'min_subjects', 'min_age');

	public static $rules = array(
		'name'=>'required|min:3',
		'min_subjects'=>'required|numeric',
		'min_age'=>'required|numeric'
	);
}
