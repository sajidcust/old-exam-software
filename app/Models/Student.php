<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = array('name', 'father_name', 'date_of_birth', 'dob_in_words', 'home_address', 'cell_no', 'email', 'image', 'student_type', 'session_id', 'institution_id', 'center_id', 'class_id');

	public static $rules = array(
		'name'=>'required|min:3',
        'father_name'=>'required|min:3',
        'date_of_birth'=>'required|date|date_format:d-m-Y',
        'dob_in_words'=>'required|min:10',
        'home_address'=>'min:1',
        'image'=>'mimes:jpeg,jpg,png,gif|required|max:10000',
        'student_type'=>'required|integer',
        'session_id'=>'required|integer',
        'institution_id'=>'required|integer',
        'center_id'=>'required|integer',
        'class_id'=>'required|integer'
	);

    public static $rules_edit = array(
        'name'=>'required|min:3',
        'father_name'=>'required|min:3',
        'date_of_birth'=>'required|date|date_format:d-m-Y',
        'dob_in_words'=>'required|min:10',
        'home_address'=>'min:1',
        'image'=>'mimes:jpeg,jpg,png,gif|max:10000',
        'student_type'=>'required|integer',
        'session_id'=>'required|integer',
        'institution_id'=>'required|integer',
        'center_id'=>'required|integer',
        'class_id'=>'required|integer'
    );


    public static function getStudentsByCAndSubs($center_id, $class_id, $subject_id, $session_id, $semester_id){
        $students = Student::join('students_subjects', 'students_subjects.student_id', 'students.id')->join('students_semesters', 'students_semesters.student_id', '=', 'students.id')->where('students.center_id', $center_id)->where('students.class_id', $class_id)->where('students_subjects.subject_id', $subject_id)->where('students.session_id', $session_id)->where('students_semesters.semester_id', $semester_id)->get(['students.id', 'students.name', 'students.father_name']);

        return $students;
    }
}
