<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = array('title', 'sessions_id', 'division_percentage');

	public static $rules = array(
		'title'=>'required|min:3',
		'session_id'=>'required|integer',
		'division_percentage'=>'required|integer|numeric'
	);
}
