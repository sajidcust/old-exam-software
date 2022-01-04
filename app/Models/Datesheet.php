<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datesheet extends Model
{
    use HasFactory;

    protected $fillable = array('session_id', 'semester_id', 'subject_id', 'paper_date', 'paper_starting_time', 'paper_ending_time');

	public static $rules = array(
		'session_id'=>'required|integer',
		'semester_id'=>'required|integer',
        'subject_id'=>'required|integer',
        'paper_date'=>'required|date|date_format:d-m-Y',
        'paper_starting_time'=>'required|date_format:h:i A',
        'paper_ending_time'=>'required|date_format:h:i A',
	);
}
