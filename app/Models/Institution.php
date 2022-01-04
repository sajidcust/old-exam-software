<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = array('name', 'is_ddo', 'ddo_id', 'is_center', 'center_id', 'tehsil_id');

	public static $rules = array(
		'name'=>'required|min:3',
        'is_ddo'=>'required|integer',
        'ddo_id'=>'integer',
        'is_center'=>'required|integer',
        'center_id'=>'integer',
        'tehsil_id'=>'required|integer',
	);
}
