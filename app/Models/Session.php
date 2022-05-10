<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = array('title', 'year', 'expiry_date', 'result_declaration_date', 'is_active');

	public static $rules = array(
		'title'=>'required|min:3',
		'year'=>'required|integer|min:4',
		'expiry_date'=>'required|date|date_format:d-m-Y',
		'result_declaration_date'=>'required|date|date_format:d-m-Y',
		'is_active' => 'required|isoneactive'
	);
}
