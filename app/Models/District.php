<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class District extends Model
{
    use HasFactory;

    protected $fillable = array('name');

	public static $rules = array(
		'name'=>'required|min:3'
	);
}
