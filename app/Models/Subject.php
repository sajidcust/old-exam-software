<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = array('name', 'short_name', 'is_optional', 'has_practical');

	public static $rules = array(
		'name'=>'required|min:3',
        'short_name'=>'required|min:1',
        'is_optional'=>'required|integer',
        'has_practical'=>'required|integer'
	);


	public static function getSubjectDatesheet($student_id, $session_id, $semester_id){
        $subjects = DB::select(DB::raw('
                        SELECT
                            sub.name AS subject_name,
                            d.class_id,
                            d.paper_date,
                            d.paper_starting_time,
                            d.paper_ending_time
                        FROM datesheets as d
                        JOIN students_subjects as ss
                        ON ss.subject_id = d.subject_id
                        JOIN subjects as sub
                        ON sub.id = ss.subject_id AND sub.id = d.subject_id
                        JOIN students AS s
                        ON s.id = ss.student_id AND s.class_id = d.class_id
                        WHERE ss.student_id = '.$student_id.'
                        AND d.session_id = '.$session_id.'
                        AND d.semester_id = '.$semester_id.'
                        ORDER BY d.paper_date;

                    '));
		return $subjects;
	}
}
