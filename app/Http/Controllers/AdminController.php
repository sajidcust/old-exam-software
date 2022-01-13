<?php

namespace App\Http\Controllers;

use App\Exports\DownloadExcelWithMinLimit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Excel;

use App\Models\Institution;
use App\Models\StudentsExam;
use App\Models\Student;
use App\Models\Semester;
use App\Models\StudentsSubject;
use App\Models\StudentsSemester;
use App\Models\StudentsFee;
use App\Models\StudentsFeesSelection;


class AdminController extends Controller
{
    protected $page_title = "Directorate of Education Colleges GB | Admin";
    protected $main_title = "Dashboard";
    protected $breadcrumb_title = "Dashboard";
    protected $selected_main_menu = "admin_dashboard";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*ini_set('max_execution_time', 5000);

        $array = Excel::toArray([], storage_path('imports/exportable_data/students_data/ready_to_import/data_hunza_class_8th.xlsx'));*/

        /*$breaker = 0;

        foreach($array[0] as $arr){

            $session_id = 2022;
            $class_id = 1001;

            $center_id = (int)$arr[0];
            $school_id = (int)$arr[1];
            $name = trim($arr[2]);
            $father_name = trim($arr[3]);

            $date_of_birth = "";
            $dob_in_words = "";

            if($arr[4] != NULL || $arr[4] != ''){
                $date_of_birth = date('Y-m-d', strtotime($arr[4]));

                $e_arr = explode('-', $date_of_birth);

                $year = $e_arr[0];
                $month = $e_arr[1];
                $day = $e_arr[2];

                $se = new StudentsExam;

                $year_text = $se->convert_number($year);
                $day_text = $se->convert_day($day);
                $month_text = date('F', mktime(0, 0, 0, $month, 10));

                $dob_in_words = $day_text.' '.$month_text.' '.$year_text;
            }
            
            $gender = (int)$arr[5];
            $email = trim($arr[6]);
            $cell_no = trim($arr[7]);
            $home_address = trim($arr[8]);
            $student_type = (int)$arr[9];
            
            $bank_id = (int)$arr[10];
            $challan_no = (int)$arr[11];

            $deposit_date = "";

            if($arr[12] != NULL || $arr[12] != '') {
                $deposit_date = date('Y-m-d', strtotime($arr[12]));
            }
            
            $amount = (int)$arr[13];



            $student = new Student;
            $student->name = $name;
            $student->father_name = $father_name;

            if($date_of_birth != "") {
                $student->date_of_birth = $date_of_birth;
                $student->dob_in_words = $dob_in_words;
            }

            $student->gender = $gender;
            $student->home_address = $home_address;
            $student->cell_no = $cell_no;
            $student->email = $email;
            $student->student_type = $student_type;
            $student->session_id = $session_id;
            $student->institution_id = $school_id;
            $student->center_id = $center_id;
            $student->class_id = $class_id;

            $student->save();

            // Subjects
            $sub_array = [1001, 1002, 1003, 1004, 1005, 1006];

            foreach($sub_array as $sarr) {
                $students_subject = new StudentsSubject;
                $students_subject->student_id = $student->id;
                $students_subject->subject_id = $sarr;
                $students_subject->save();
            }

            // Add Semesters

            StudentsSemester::where('student_id', $student->id)->delete();

            $semesters = Semester::where('session_id', $session_id)->get();
            foreach($semesters as $semester){
                $studentsemester = new StudentsSemester;
                $studentsemester->student_id = $student->id;
                $studentsemester->semester_id = $semester->id;
                $studentsemester->save();
            }


            // Students Fees

            if($deposit_date != "" && $bank_id != ""){
                $studentfee = new StudentsFee;
                $studentfee->student_id = $student->id;
                $studentfee->semester_id = 1;
                $studentfee->bank_id = $bank_id;
                $studentfee->challan_no = $challan_no;
                $studentfee->date_of_deposit = $deposit_date;
                $studentfee->total_amount = $amount;
                $studentfee->save();

                $fee_ids = array();
                if($student_type == 0) {
                    $fee_ids = [1001, 1002, 1003];
                } else {
                    $fee_ids = [1001, 1002, 1004];
                }

                $counter = count($fee_ids);

                for($i=0; $i<$counter; $i++){
                    $students_fees_selection = new StudentsFeesSelection;
                    $students_fees_selection->students_fees_id = $studentfee->id;
                    $students_fees_selection->student_id = $student->id;
                    $students_fees_selection->semester_id = 1;
                    $students_fees_selection->fee_id = $fee_ids[$i];
                    $students_fees_selection->save();
                }
            }

            echo $breaker.":::".$student->name."<br>";

            $breaker ++;
        }

        exit;*/

        //---------------------------Class 8th Code-------------------------------

        /*$breaker = 0;

        foreach($array[0] as $arr){

            $session_id = 2022;
            $class_id = 1002;

            $center_id = (int)$arr[0];
            $school_id = (int)$arr[1];
            $name = trim($arr[2]);
            $father_name = trim($arr[3]);

            $date_of_birth = "";
            $dob_in_words = "";

            if($arr[4] != NULL || $arr[4] != ''){
                $date_of_birth = date('Y-m-d', strtotime($arr[4]));

                $e_arr = explode('-', $date_of_birth);

                $year = $e_arr[0];
                $month = $e_arr[1];
                $day = $e_arr[2];

                $se = new StudentsExam;

                $year_text = $se->convert_number($year);
                $day_text = $se->convert_day($day);
                $month_text = date('F', mktime(0, 0, 0, $month, 10));

                $dob_in_words = $day_text.' '.$month_text.' '.$year_text;
            }
            
            $gender = (int)$arr[5];
            $email = trim($arr[6]);
            $cell_no = trim($arr[7]);
            $home_address = trim($arr[8]);
            $student_type = (int)$arr[9];
            
            $bank_id = (int)$arr[10];
            $challan_no = (int)$arr[11];

            $deposit_date = "";

            if($arr[12] != NULL || $arr[12] != '') {
                $deposit_date = date('Y-m-d', strtotime($arr[12]));
            }
            
            $amount = (int)$arr[13];

            $elective1 = (int)$arr[14];
            $elective2 = (int)$arr[15];



            $student = new Student;
            $student->name = $name;
            $student->father_name = $father_name;

            if($date_of_birth != "") {
                $student->date_of_birth = $date_of_birth;
                $student->dob_in_words = $dob_in_words;
            }

            $student->gender = $gender;
            $student->home_address = $home_address;
            $student->cell_no = $cell_no;
            $student->email = $email;
            $student->student_type = $student_type;
            $student->session_id = $session_id;
            $student->institution_id = $school_id;
            $student->center_id = $center_id;
            $student->class_id = $class_id;

            $student->save();

            // Subjects
            $sub_array = [1001, 1002, 1003, 1004, 1005, 1007, $elective1, $elective2];

            foreach($sub_array as $sarr) {
                $students_subject = new StudentsSubject;
                $students_subject->student_id = $student->id;
                $students_subject->subject_id = $sarr;
                $students_subject->save();
            }

            // Add Semesters

            StudentsSemester::where('student_id', $student->id)->delete();

            $semesters = Semester::where('session_id', $session_id)->get();
            foreach($semesters as $semester){
                $studentsemester = new StudentsSemester;
                $studentsemester->student_id = $student->id;
                $studentsemester->semester_id = $semester->id;
                $studentsemester->save();
            }


            // Students Fees

            if($deposit_date != "" && $bank_id != ""){
                $studentfee = new StudentsFee;
                $studentfee->student_id = $student->id;
                $studentfee->semester_id = 1;
                $studentfee->bank_id = $bank_id;
                $studentfee->challan_no = $challan_no;
                $studentfee->date_of_deposit = $deposit_date;
                $studentfee->total_amount = $amount;
                $studentfee->save();

                $fee_ids = array();
                if($student_type == 0) {
                    $fee_ids = [1001, 1002, 1005];
                } else {
                    $fee_ids = [1001, 1002, 1006];
                }

                $counter = count($fee_ids);

                for($i=0; $i<$counter; $i++){
                    $students_fees_selection = new StudentsFeesSelection;
                    $students_fees_selection->students_fees_id = $studentfee->id;
                    $students_fees_selection->student_id = $student->id;
                    $students_fees_selection->semester_id = 1;
                    $students_fees_selection->fee_id = $fee_ids[$i];
                    $students_fees_selection->save();
                }
            }

            echo $breaker.":::".$student->name."<br>";

            $breaker ++;
        }

        exit;*/


        $this->selected_sub_menu = "admin_dashboard";
        $this->card_title = "Admin Dashboard";

        return view('admin.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

}