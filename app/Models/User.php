<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\District;
use DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role'
    ];

    public static $rules_personalinfo = array(
        'name'=>'required|min:3',
        'father_name'=>'required|min:3',
        'postal_address'=>'required|min:10',
        'date_of_birth'=>'required|date|date_format:d-m-Y|isgtminage|isltmaxage',
        'cell_no'=>'required|min:12',
        'watsapp_no'=>'min:12',
        'telephpne_no'=>'min:11',
        'gender'=>'required|integer',
        'district_id'=>'required',
        'is_disabled'=>'required|integer'
    );

    public static $rules_personalinfo_edit = array(
        'name'=>'required|min:3',
        'father_name'=>'required|min:3',
        'postal_address'=>'required|min:10',
        'date_of_birth'=>'required|date|date_format:d-m-Y|isgtminage|isltmaxage',
        'cell_no'=>'required|min:12',
        'watsapp_no'=>'min:12',
        'telephpne_no'=>'min:11',
        'gender'=>'required|integer',
        'district_id'=>'required',
        'is_disabled'=>'required|integer'
    );

    public static $rules_createuser = array(
        'name'=>'required|min:3',
        'email' => 'required|min:8|unique:users',
        'password' => [
            'required',
            'string',
            'min:8',             // must be at least 8 characters in length
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[0-9]/',      // must contain at least one digit
        ],
        'confirm_password' => 'required|min:8|same:password',
        'district_id'=>'required'
    );

    public static $rules_createuserinnomination = array(
        'name'=>'required|min:3',
        'email' => 'required|min:8|unique:users',
        'password' => [
            'required',
            'string',
            'min:8',             // must be at least 8 characters in length
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[0-9]/',      // must contain at least one digit
        ],
        'confirm_password' => 'required|min:8|same:password',
        'nomination_id'=>'required|integer',
        'district_id'=>'required',
    );

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getDistrict($district_id){
        $district = District::find($district_id);
        return $district->district_name;
    }

    public function academic_qualifications($student_id, $nomination_id){
        $academic_qualifications = StudentAcademicQualification::join('academic_qualifications', 'student_academic_qualifications.qualification_id', '=', 'academic_qualifications.id')->where('student_academic_qualifications.student_id', '=', $student_id)->where('student_academic_qualifications.nomination_id', '=', $nomination_id)->get(['student_academic_qualifications.*', 'academic_qualifications.qualification_name']);
        return $academic_qualifications;
    }

    public function course_priorities($student_id, $nomination_id){
        $excourses = DB::select(
            DB::raw("
                SELECT sucp.course_id, c.course_name, c.c_short_code, sucp.university_id, u.university_name, sucp.priority, u.short_code
                FROM courses c 
                INNER JOIN students_university_courses_priorities sucp 
                ON sucp.course_id = c.id 
                INNER JOIN universities u
                ON u.id = sucp.university_id
                WHERE sucp.nomination_id = :nomination_id 
                AND sucp.student_id = :student_id
                GROUP BY u.id, c.id
                ORDER BY sucp.priority;
            "), array('nomination_id'=>$nomination_id, 'student_id'=>$student_id)
        );

        return $excourses;
    }
}
