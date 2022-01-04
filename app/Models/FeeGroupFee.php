<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeGroupFee extends Model
{
    use HasFactory;

    protected $fillable = array('fee_group_id', 'fee_id');

	public static $rules = array(
		'fee_group_id'=>'required|integer',
		'fee_id'=>'required|integer'
	);
}
