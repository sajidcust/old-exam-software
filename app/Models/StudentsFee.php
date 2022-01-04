<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsFee extends Model
{
    use HasFactory;

    protected $fillable = array('semester_id', 'student_id', 'bank_id', 'challan_no', 'date_of_deposit');

	public static $rules = array(
        'student_id'=>'required|integer',
        'semester_id'=>'required|integer',
        'bank_id'=>'required|integer',
        'challan_no'=>'required|numeric',
        'date_of_deposit'=>'required|date|date_format:d-m-Y'
	);
}
