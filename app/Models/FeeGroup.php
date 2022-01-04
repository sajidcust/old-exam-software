<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeGroup extends Model
{
    use HasFactory;

    protected $fillable = array('fee_group_name', 'class_id');

	public static $rules = array(
		'fee_group_name'=>'required|min:3',
		'class_id'=>'required|integer'
	);
}
