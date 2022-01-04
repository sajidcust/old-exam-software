<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = array('title', 'f_type', 'amount');

	public static $rules = array(
		'title'=>'required|min:3',
		'amount'=>'required|numeric|min:2'
	);
}
