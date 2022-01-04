<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\StudentsSubject;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentsExam;
use App\Models\Session;
use App\Models\Standard;
use App\Models\Institution;
use App\Models\Subject;

use DB;

class MarksController extends Controller
{
	protected $page_title = "Board of Elementary Examination, GB | Marks Update";
    protected $main_title = "Marks Update";
    protected $breadcrumb_title = "Marks Update";
    protected $selected_main_menu = "marks_update";
    protected $card_title;
    protected $selected_sub_menu;

    public function index()
    {
        $this->selected_sub_menu = "marks_index";
        $this->card_title = "View and Manage all students subject marks.";

        if(DB::connection()->getDriverName() == 'mysql') {
            $date_of_birth = "DATE_FORMAT(s.date_of_birth, '%d-%m-%Y') AS date_of_birth,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $date_of_birth = "strftime('%d-%m-%Y', s.date_of_birth) AS date_of_birth,";
        }

        if(request()->ajax())
        {
            return datatables()->of(DB::select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            ".$date_of_birth."
                            s.home_address,
                            s.cell_no,
                            (CASE  WHEN s.student_type=0 THEN 'Regular' ELSE 'Private' END) AS student_type,
                            ss.title,
                            i.name as center_name,
                            stds.name AS s_class,
                            ss.id AS session_id
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN standards as stds
                        ON s.class_id = stds.id;
                        ")))
                    ->addColumn('subjects', function($data){
                        $result = "";
                        $subjects = StudentsSubject::join('subjects', 'subjects.id', '=', 'students_subjects.subject_id')->where('students_subjects.student_id', $data->id)->get();
                        foreach($subjects as $subject){
                            $result.=$subject->name.", ";
                        }
                        return $result;
                    })
                    ->addColumn('action', function($data){
                        $semesters = Semester::where('session_id', $data->session_id)->get();
                        $button = "";

                        foreach($semesters as $semester){
                            $button .= '<a style="margin-bottom:5px;" href="'.url('assessmentcenter/marks/edit/'.$data->id).'/'. $semester->id.'" name="edit" id="'.$data->id.'_'.$semester->id.'" class="btn btn-success margin-2px btn-sm">Update '. $semester->title .' Marks</a>';
                        }

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('assessmentcenters.students')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function edit($id, $semester_id)
    {
        $this->selected_sub_menu = "marks_index";
        $this->card_title = "Please fill in the form to update the marks";


        $student = Student::find($id);
        $semester = Semester::find($semester_id);

        $subjects = StudentsSubject::join('subjects', 'subjects.id', '=', 'students_subjects.subject_id')->where('students_subjects.student_id', $student->id)->get(['subjects.*']);

        return view('assessmentcenters.updatemarks')
            ->with('student', $student)
            ->with('semester', $semester)
            ->with('subjects', $subjects)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function update(Request $request)
    {
        $subject_ids = $request->input('subject_id');
        $semester_id = $request->input('semester_id');
        $counter = count($subject_ids);     

        if($semester_id){

            if($counter > 0){
                for($i=0; $i<$counter; $i++){
                    $inputs_array = array(
                        '_token'=>$request->input('_token'),
                        'student_id'=>$request->input('student_id'),
                        'semester_id'=>$request->input('semester_id'),
                        'subject_id'=>$request->input('subject_id')[$i],
                        'is_absent'=>$request->input('is_absent_val')[$i],
                        'sheet_no'=>$request->input('sheet_no')[$i],
                        'theory_max_marks'=>$request->input('theory_max_marks')[$i],
                        'theory_obt_marks'=>$request->input('theory_obt_marks')[$i],
                        'practical_max_marks'=>$request->input('practical_max_marks')[$i],
                        'practical_obt_marks'=>$request->input('practical_obt_marks')[$i],
                        'total_max_marks'=>$request->input('total_max_marks')[$i],
                        'total_obt_marks'=>$request->input('total_obt_marks')[$i]
                    );

                    $validator = Validator::make($inputs_array, StudentsExam::$rules);
                    if($validator->passes()){

                        $total_max_marks = $request->input('theory_max_marks')[$i] + $request->input('practical_max_marks')[$i];
                        $total_obt_marks = $request->input('theory_obt_marks')[$i] + $request->input('practical_obt_marks')[$i];

                        $count = StudentsExam::where('student_id', $request->input('student_id'))->where('semester_id', $semester_id)->where('subject_id', $request->input('subject_id')[$i])->count();

                        if($count == 1) {
                            $studentexam = StudentsExam::where('student_id', $request->input('student_id'))->where('semester_id', $semester_id)->where('subject_id', $request->input('subject_id')[$i])->first();
                        } else {
                            $studentexam = new StudentsExam;
                        }

                        $studentexam->student_id= $request->input('student_id');
                        $studentexam->semester_id= $request->input('semester_id');
                        $studentexam->subject_id= $request->input('subject_id')[$i];
                        $studentexam->is_absent= $request->input('is_absent_val')[$i];
                        $studentexam->sheet_no = $request->input('sheet_no')[$i];
                        $studentexam->theory_max_marks= $request->input('theory_max_marks')[$i];
                        $studentexam->theory_obt_marks= $request->input('theory_obt_marks')[$i];
                        $studentexam->practical_max_marks= $request->input('practical_max_marks')[$i];
                        $studentexam->practical_obt_marks= $request->input('practical_obt_marks')[$i];
                        $studentexam->total_max_marks= $total_max_marks;
                        $studentexam->total_obt_marks= $total_obt_marks;
                        $studentexam->save();

                    }  else {
                        return Redirect::to('assessmentcenter/marks/edit/'.$request->input('student_id').'/'.$request->input('semester_id'))
                            ->withErrors($validator)
                            ->withInput($request->all());      
                    }
                }

                return Redirect::to('assessmentcenter/marks/index')
                        ->with('message', 'Exam record updated successfully.');
            }
            
        } else {
            return Redirect::to('assessmentcenter/marks/index')
                            ->with('message', 'Something Went Wrong! Please try again later.');
        }
    }

    public function updatemarksbycenters(){
        $this->selected_sub_menu = "update_marks_by_centers";
        $this->card_title = "Please fill in the form to update marks by centers.";

        $sessions = Session::all();
        $standards = Standard::all();
        $centers = Institution::where('is_center', 1)->get();
        $subjects = Subject::all();

        return view('assessmentcenters.updatemarksbycenters')
            ->with('sessions', $sessions)
            ->with('standards', $standards)
            ->with('centers', $centers)
            ->with('subjects', $subjects)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function storemarksbycenters(Request $request){
        $this->selected_sub_menu = "update_marks_by_centers";
        $this->card_title = "Please fill in the form to update the marks";

        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $class_id = $request->input('class_id');
        $center_id = $request->input('center_id');
        $subject_id = $request->input('subject_id');

        $students = Student::where('session_id', $session_id)->where('class_id', $class_id)->where('center_id', $center_id)->get(['id', 'name']);

        $subject = Subject::find($subject_id);
        $semester = Semester::find($semester_id);
        $session = Session::find($session_id);
        $class = Standard::find($class_id);
        $center = Institution::find($center_id);

        return view('assessmentcenters.storemarksbycenters')
            ->with('students', $students)
            ->with('subject', $subject)
            ->with('session', $session)
            ->with('semester', $semester)
            ->with('class', $class)
            ->with('center', $center)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function storedatabystudents(Request $request){
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $subject_id = $request->input('subject_id');
        $class_id = $request->input('class_id');
        $center_id = $request->input('center_id');

        if($session_id && $semester_id && $subject_id && $class_id && $center_id) {
            $student_ids = $request->input("student_id");
            $counter = count($student_ids);
            
            for($i=0; $i<$counter; $i++) {
                $inputs_array = array(
                    '_token'=>$request->input('_token'),
                    'student_id'=>$request->input('student_id')[$i],
                    'semester_id'=>$semester_id,
                    'subject_id'=>$subject_id,
                    'is_absent'=>$request->input('is_absent_val')[$i],
                    'sheet_no'=>$request->input('sheet_no')[$i],
                    'theory_max_marks'=>$request->input('theory_max_marks')[$i],
                    'theory_obt_marks'=>$request->input('theory_obt_marks')[$i],
                    'practical_max_marks'=>$request->input('practical_max_marks')[$i],
                    'practical_obt_marks'=>$request->input('practical_obt_marks')[$i],
                    'total_max_marks'=>$request->input('total_max_marks')[$i],
                    'total_obt_marks'=>$request->input('total_obt_marks')[$i]
                );

                $validator = Validator::make($inputs_array, StudentsExam::$rules);
                if($validator->passes()){

                    $total_max_marks = $request->input('theory_max_marks')[$i] + $request->input('practical_max_marks')[$i];
                    $total_obt_marks = $request->input('theory_obt_marks')[$i] + $request->input('practical_obt_marks')[$i];

                    $count = StudentsExam::where('student_id', $request->input('student_id')[$i])->where('semester_id', $semester_id)->where('subject_id', $subject_id)->count();

                    if($count == 0){
                        $studentexam = new StudentsExam;
                    } else {
                        $studentexam = StudentsExam::where('student_id', $request->input('student_id')[$i])->where('semester_id', $semester_id)->where('subject_id', $subject_id)->first();
                    }

                    $studentexam->student_id= $request->input('student_id')[$i];
                    $studentexam->semester_id= $semester_id;
                    $studentexam->subject_id= $subject_id;
                    $studentexam->is_absent= $request->input('is_absent_val')[$i];
                    $studentexam->sheet_no = $request->input('sheet_no')[$i];
                    $studentexam->theory_max_marks= $request->input('theory_max_marks')[$i];
                    $studentexam->theory_obt_marks= $request->input('theory_obt_marks')[$i];
                    $studentexam->practical_max_marks= $request->input('practical_max_marks')[$i];
                    $studentexam->practical_obt_marks= $request->input('practical_obt_marks')[$i];
                    $studentexam->total_max_marks= $total_max_marks;
                    $studentexam->total_obt_marks= $total_obt_marks;
                    $studentexam->save();
                } else {
                    return Redirect::to('assessmentcenter/marks/updatemarksbycenters')
                        ->withErrors($validator)
                        ->withInput($request->all());      
                }
            } // end for loop

            return Redirect::to('assessmentcenter/marks/updatemarksbycenters')
                        ->with('message', 'Exam record updated successfully.');
        }

        return Redirect::to('assessmentcenter/marks/updatemarksbycenters')
                        ->with('message', 'Something went wrong! Please try again later.');
    }


    public function getsemesters(Request $request){
        $session_id = $request->input('session_id');
        $course_category_id = $request->input('course_category_id');

        $semesters = DB::select(
            DB::raw("
                SELECT * 
                FROM semesters s
                WHERE s.session_id = :session_id;
            "), array(
                'session_id'=>$session_id
            )
        );
        $response = array();
        foreach($semesters as $semester){
           $response[] = array(
              "id"=>$semester->id,
              "text"=>$semester->title
         );
        }
        echo json_encode($response);
        exit;
    }
}
