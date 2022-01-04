<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentsFeesSelection;

class StudentsFeesSelection extends Model
{
    use HasFactory;

    protected $fillable = array('students_fees_id', 'student_id', 'semester_id', 'fee_id');

	public static $rules = array(
        'students_fees_id'=>'required|integer',
        'student_id'=>'required|integer',
        'semester_id'=>'required|integer',
        'fee_id'=>'required|integer'
	);

	public static function returnfeeidsarray($student_id, $semester_id) {
		$selected_fees = StudentsFeesSelection::where('student_id', $student_id)->where('semester_id', $semester_id)->get();
		$fee_ids = array();
		$i = 0;
		foreach($selected_fees as $fee) {
			$fee_ids[$i] = $fee->fee_id;
			$i++;
		}

		return $fee_ids;
	}
}
