<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Nomination;
use App\Models\StudentAcademicQualification;
use App\Models\NominationPrequalification;


use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
//use Maatwebsite\Excel\Concerns\FromView;
//use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class DownloadExcelWithMinLimit implements FromCollection, WithHeadings, ShouldAutoSize //FromView, WithTitle, ShouldAutoSize //FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $data;
    protected $nomination_id;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /*public function view(): View
    {
    	$students = User::join('student_academic_qualifications', 'student_academic_qualifications.student_id', '=', 'users.id')
	                    ->join('academic_qualifications', 'academic_qualifications.id', '=', 'student_academic_qualifications.qualification_id')
	                    ->join('nominations', 'nominations.id', '=', 'student_academic_qualifications.nomination_id')
	                    ->join('students_nominations', function($join){
	                        $join->on('students_nominations.nomination_id', '=', 'nominations.id');
	                        $join->on('students_nominations.student_id','=','users.id');
	                    })
	                    ->join('provinces_cc_pre_qualifications', function($join){
	                        $join->on('provinces_cc_pre_qualifications.course_category_id', '=', 'nominations.course_category_id');
	                        $join->on('provinces_cc_pre_qualifications.qualification_id', '=', 'student_academic_qualifications.qualification_id');
	                    })->join('districts', 'districts.id', '=', 'users.district_id')->where('nominations.id', '=', $this->nomination_id)->where('students_nominations.is_completed', '=', 1)->where('students_nominations.is_verified', '=', 1)
	                    ->select([
	                        'users.id', 
                            'users.name',
                            'users.father_name',
                            'users.postal_address',
                            'users.permanent_address',
                            'users.gender',
                            'districts.district_name',
                            'users.cell_no',
                            'users.watsapp_no',
                            'users.telephone_no',
                            'users.email', 
	                        DB::raw('ROUND(SUM((student_academic_qualifications.obtained_marks/student_academic_qualifications.total_marks)*provinces_cc_pre_qualifications.division_percentage), 5) AS aggregate_marks'),
	                        DB::raw('DATE_FORMAT(users.date_of_birth, "%d-%m-%Y") as date_of_birth')
	                    ])->groupBY('users.id')->orderBy('aggregate_marks', 'DESC')->orderBy('student_academic_qualifications.obtained_marks', 'DESC')->orderBy('users.date_of_birth', 'ASC')->limit($this->min_records)->get();
	    $nomination = Nomination::find($this->nomination_id);

        return view('adminstudents.downloadexcelstudentpriorities', [
            'students' => $students,
            'nomination' => $nomination
        ]);
    }*/

    /*public function title(): string
    {
        return 'Waqar Ul Hassan';
    }*/

    public function collection()
    {

        /*$users = [
            [
                'id' => 1,
                'name' => 'Hardik',
                'email' => 'hardik@gmail.com'
            ],
            [
                'id' => 2,
                'name' => 'Vimal',
                'email' => 'vimal@gmail.com'
            ],
            [
                'id' => 3,
                'name' => 'Harshad',
                'email' => 'harshad@gmail.com'
            ]
        ];*/

        return collect($this->data);

    	/*$students = [
    		[
                'student_id' => 'Povilas',
                'name' => 'Korop',
                'father_name' => 'povilas@laraveldaily.com',
                'address' => '@povilaskorop',
                'aggregate_marks' => '@povilaskorop',
                'date_of_birth' => '@povilaskorop'
            ],
            [
                'student_id' => 'Povilas',
                'name' => 'Korop',
                'father_name' => 'povilas@laraveldaily.com',
                'address' => '@povilaskorop',
                'aggregate_marks' => '@povilaskorop',
                'date_of_birth' => '@povilaskorop'
            ]
        ];*/

        /*$students = User::join('student_academic_qualifications', 'student_academic_qualifications.student_id', '=', 'users.id')
	                    ->join('academic_qualifications', 'academic_qualifications.id', '=', 'student_academic_qualifications.qualification_id')
	                    ->join('nominations', 'nominations.id', '=', 'student_academic_qualifications.nomination_id')
	                    ->join('students_nominations', function($join){
	                        $join->on('students_nominations.nomination_id', '=', 'nominations.id');
	                        $join->on('students_nominations.student_id','=','users.id');
	                    })
	                    ->join('provinces_cc_pre_qualifications', function($join){
	                        $join->on('provinces_cc_pre_qualifications.course_category_id', '=', 'nominations.course_category_id');
	                        $join->on('provinces_cc_pre_qualifications.qualification_id', '=', 'student_academic_qualifications.qualification_id');
	                    })->join('districts', 'districts.id', '=', 'users.district_id')
	                    ->where('nominations.id', '=', $this->nomination_id)
	                    ->where('students_nominations.is_completed', '=', 1)
	                    ->where('students_nominations.is_verified', '=', 1)
	                    ->select([
	                        'users.id', 
                            'users.name',
                            'users.father_name',
                            'users.postal_address',
                            'users.permanent_address',
                             DB::raw('IF(users.gender=1, " FEMALE","MALE") as gender'),
                            'districts.district_name',
                            'users.cell_no',
                            'users.watsapp_no',
                            'users.telephone_no',
                            'users.email', 
	                        DB::raw('ROUND(SUM((student_academic_qualifications.obtained_marks/student_academic_qualifications.total_marks)*provinces_cc_pre_qualifications.division_percentage), 5) AS aggregate_marks'),
	                        DB::raw('DATE_FORMAT(users.date_of_birth, "%d-%m-%Y") as date_of_birth')
	                    ])->groupBY('users.id')
	                    ->orderBy('aggregate_marks', 'DESC')
	                    ->orderBy('student_academic_qualifications.obtained_marks', 'DESC')
	                    ->orderBy('users.date_of_birth', 'ASC')
	                    ->limit($this->min_records)->get();
	    $fields = array();
	    $rows = array();
	    $i=0;
        foreach($students as $student){
        	$courses = $student->course_priorities($student->id, $this->nomination_id);
        	$course_priorities = "";
        	foreach($courses as $course){
        		$course_priorities .= $course->short_code."-".$course->c_short_code." | ";
        	}

        	$academic_qualifications = $student->academic_qualifications($student->id, $this->nomination_id);
        	$data = $academic_qualifications->toArray();

        	$qualificationdets = array();

		    foreach ($data as $row => $columns) {
		      foreach ($columns as $row2 => $column2) {
		          $qualificationdets[$row2][$row] = $column2;
		      }
		    }

        	$fields[$i]["id"] = $student->id; 
        	$fields[$i]["name"] = $student->name;
        	$fields[$i]["father_name"] = $student->father_name;
        	$fields[$i]["postal_address"] = $student->postal_address;
			$fields[$i]["permanent_address"] = $student->permanent_address;
			$fields[$i]["gender"] = $student->gender;
			$fields[$i]["district_name"] = $student->district_name;
			$fields[$i]["cell_no"] = $student->cell_no;
			$fields[$i]["watsapp_no"] = $student->watsapp_no;
			$fields[$i]["telephone_no"] = $student->telephone_no;
			$fields[$i]["email"] = $student->email;
			$fields[$i]["aggregate_marks"] = $student->aggregate_marks;
			$fields[$i]["date_of_birth"] = $student->date_of_birth;
			$fields[$i]["course_priorities"] = $course_priorities;
			$counter = count($qualificationdets["qualification_name"]);
			for ($j=0; $j < $counter; $j++) { 
				$fields[$i][$qualificationdets['qualification_name'][$j]." - Total Marks"] = $qualificationdets['total_marks'][$j];
				$fields[$i][$qualificationdets['qualification_name'][$j]." - Obtained Marks"] = $qualificationdets['obtained_marks'][$j];
				$fields[$i][$qualificationdets['qualification_name'][$j]." - Percentage"] = $qualificationdets['percentage_marks'][$j];
			}
        	$i++;
        }

        return collect($fields);*/
    }

    /*public function map($user):array
	{
	    return [
            [
                $user->id,
				$user->name,
				$user->father_name,
				$user->postal_address,
				$user->aggregate_marks,
				$user->date_of_birth,
            ]
        ];
	 }*/

    public function headings():array
    {
        $headings = array();
        $headings[0] = "id";
        $headings[1] = "name";
        $headings[2] = "email";

        return $headings;

    	/*$headings = array();
    	$headings[0] = "id";
		$headings[1] = "name";
		$headings[2] = "father_name";
		$headings[3] = "postal_address";
		$headings[4] = "permanent_address";
		$headings[5] = "gender";
		$headings[6] = "district_name";
		$headings[7] = "cell_no";
		$headings[8] = "watsapp_no";
		$headings[9] = "telephone_no";
		$headings[10] = "email";
		$headings[11] = "aggregate_marks";
		$headings[12] = "date_of_birth";
		$headings[13] = "course_priorities";
        $i=14;
        $qualifications = NominationPrequalification::join('academic_qualifications', 'academic_qualifications.id', '=', 'nomination_prequalifications.qualification_id')
        					->where('nomination_prequalifications.nomination_id', '=', $this->nomination_id)
        					->get(['qualification_name']);
        foreach($qualifications as $qualification){
        	$headings[$i] = $qualification->qualification_name ." - Total Marks";
        	$i++;
        	$headings[$i] = $qualification->qualification_name ." - Obtained Marks";
        	$i++;
        	$headings[$i] = $qualification->qualification_name ." - Percentage";
        	$i++;
        }

        return $headings;*/
    }
}
