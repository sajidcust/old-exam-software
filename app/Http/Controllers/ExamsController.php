<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Session;
use App\Models\StudentsSubject;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentsExam;
use App\Models\StudentsSemester;
use App\Models\Datesheet;
use App\Models\District;
use App\Models\Tehsil;
use App\Models\Institution;
use App\Models\Standard;
use App\Models\Gazette;
use App\Models\Setting;
use App\Models\TableOfContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use PDF;

class ExamsController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Exams";
    protected $main_title = "Exams";
    protected $breadcrumb_title = "Exams";
    protected $selected_main_menu = "exams";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "exams_index";
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
                            s.class_id,
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
                    ->addColumn('subs', function($data){
                        $result = "";
                        $subjects = StudentsSubject::join('subjects', 'subjects.id', '=', 'students_subjects.subject_id')->where('students_subjects.student_id', $data->id)->get();
                        if(count($subjects)){

                            $result = '<table style="margin:0px;" class="table table-sm table-borderless">  
                                      <tbody>';

                            foreach($subjects as $subject){
                                $result.='<tr style="background:transparent">';
                                    $result.= '<td style="margin:0px;padding:0px;padding-right:5px;""><h5><span style="width:100%;" class="badge badge-danger">'.$subject->id.'</span></h5></td>';
                                    $result.= '<td style="margin:0px;padding:0px;padding-right:5px;""><h5><span style="width:100%;" class="badge badge-secondary">'.$subject->name.'</span></h5></td>';
                                $result.='</tr>';
                            }

                            $result.= '</tbody>
                                    </table>';
                        } else {
                            $result = '';
                        }
                        return $result;
                    })
                    ->addColumn('subjects', function($data){
                        $result = "";
                        $subjects = StudentsSubject::join('subjects', 'subjects.id', '=', 'students_subjects.subject_id')->join('students_exams', 'students_exams.subject_id', '=', 'subjects.id')->join('semesters', 'semesters.id', '=', 'students_exams.semester_id')->where('students_exams.student_id', $data->id)->where('students_subjects.student_id', $data->id)->orderBy('semesters.id', 'ASC')->orderBy('subjects.id', 'ASC')->get(['subjects.id', 'subjects.name', 'semesters.title', 'students_exams.total_obt_marks']);

                        if(count($subjects)){
                            $result = '<table style="margin:0px;" class="table table-sm table-borderless">  
                                      <tbody>';
                                            foreach($subjects as $subject) {
                                                $result.='<tr style="background:transparent">';
                                                    $result.= '<td style="margin:0px;padding:0px;padding-right:5px;""><h5><span style="width:100%;" class="badge badge-primary">'.$subject->name.'</span></h5></td>
                                                                <td style="margin:0px;padding:0px;padding-right:5px;text-align:center;"><h5><span style="width:100%;" class="badge badge-warning">'.$subject->title.'</span></h5></td>
                                                                <td style="margin:0px;padding:0px;padding-right:5px;text-align:center;"><h5><span style="width:100%;" class="badge badge-success">'.$subject->total_obt_marks.'</span></h5></td>';
                                                $result.='</tr>';
                                            }
                                 $result.= '</tbody>
                                    </table>';
                        } else {
                            $result = '';
                        }

                        return $result;
                    })
                    ->addColumn('action', function($data){
                        $semesters = Semester::where('session_id', $data->session_id)->get();
                        $button = "";

                        foreach($semesters as $semester){
                            $button .= '<a style="margin-bottom:5px;" href="'.url('admin/exams/edit/'.$data->id).'/'. $semester->id.'" name="edit" id="'.$data->id.'_'.$semester->id.'" class="btn btn-success margin-2px btn-sm">Update '. $semester->title .' Marks</a>';
                        }

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('exams.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function generateinbulk(Request $request){
        $this->selected_sub_menu = "exams_slips";
        $this->card_title = "View and Generate Roll No Slips in bulk.";

        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $semester = Semester::find($semester_id);
        $session = Session::find($session_id);

        $districts = District::all();
        $tehsils = Tehsil::all();
        $institutions = Institution::all();
        $standards = Standard::all();

        return view('exams.generateinbulk')
            ->with('session', $session)
            ->with('semester', $semester)
            ->with('districts', $districts)
            ->with('tehsils', $tehsils)
            ->with('institutions', $institutions)
            ->with('standards', $standards)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function generateslipbysessionid(Request $request){
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $skip_records = $request->input('skip_records');
        $limit_records = $request->input('limit_records');

        if(DB::connection()->getDriverName() == 'mysql') {
            $registration_no = "CONCAT(ss.id, '-', stds.id, '-', s.id) AS registration_no,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $registration_no = "(ss.id || '-' || stds.id || '-' || s.id) AS registration_no,";
        }

        if($session_id){
            $students = DB::select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            s.image,
                            ss.title as session_title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.id as center_id,
                            i.name as center_name,
                            stds.name as class_name,
                            d.name as district_name,
                            ". $registration_no ."
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN tehsils as t
                        ON t.id = i.tehsil_id
                        JOIN districts as d
                        ON d.id = t.district_id
                        JOIN semesters as sem
                        WHERE s.session_id = ".$session_id."
                        LIMIT ".$skip_records.", ".$limit_records.";
                    "));

        $semester = Semester::find($semester_id);
        $session = Session::find($session_id);

        $data = [
            'students'     => $students,
            'session_id'   => $session_id,
            'semester_id'  => $semester_id,
            'setting'      => Setting::find(1)
        ];

        $pdf = PDF::loadView('exams.downloadinbulk', $data);

        return $pdf->download('roll-no-slip-'.$session_id.'-'.$session->title.'-'.$semester_id.'-'.$semester->title.'-'.$skip_records.'-'.$limit_records.'.pdf');
        }
    }

    public function generateslipbydistrictid(Request $request){
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $district_id = $request->input('district_id');
        $skip_records = $request->input('skip_records');
        $limit_records = $request->input('limit_records');
        $district = District::find($district_id);

        if(DB::connection()->getDriverName() == 'mysql') {
            $registration_no = "CONCAT(ss.id, '-', stds.id, '-', s.id) AS registration_no,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $registration_no = "(ss.id || '-' || stds.id || '-' || s.id) AS registration_no,";
        }

        if($district_id){
            $students = DB::select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            s.image,
                            ss.title as session_title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.id as center_id,
                            i.name as center_name,
                            stds.name as class_name,
                            d.name as district_name,
                            ".$registration_no."
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN tehsils as t
                        ON t.id = i.tehsil_id
                        JOIN districts as d
                        ON d.id = t.district_id
                        WHERE d.id = ".$district_id."
                        LIMIT ".$skip_records.", ".$limit_records.";
                    "));

        $semester = Semester::find($semester_id);
        $session = Session::find($session_id);

        $data = [
            'students'     => $students,
            'session_id'   => $session_id,
            'semester_id'  => $semester_id,
            'setting'      => Setting::find(1)
        ];

        $pdf = PDF::loadView('exams.downloadinbulk', $data);

        return $pdf->download('roll-no-slip-'.$session_id.'-'.$session->title.'-'.$semester_id.'-'.$semester->title.'-'.$district_id.'-'.$district->name.'-'.$skip_records.'-'.$limit_records.'.pdf');
        }
    }

    public function generateslipbytehsilid(Request $request){
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $tehsil_id = $request->input('tehsil_id');
        $skip_records = $request->input('skip_records');
        $limit_records = $request->input('limit_records');
        $tehsil = Tehsil::find($tehsil_id);

        if(DB::connection()->getDriverName() == 'mysql') {
            $registration_no = "CONCAT(ss.id, '-', stds.id, '-', s.id) AS registration_no,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $registration_no = "(ss.id || '-' || stds.id || '-' || s.id) AS registration_no,";
        }

        if($tehsil_id){
            $students = DB::select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            s.image,
                            ss.title as session_title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.id as center_id,
                            i.name as center_name,
                            stds.name as class_name,
                            d.name as district_name,
                            ".$registration_no."
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN tehsils as t
                        ON t.id = i.tehsil_id
                        JOIN districts as d
                        ON d.id = t.district_id
                        WHERE t.id = ".$tehsil_id."
                        LIMIT ".$skip_records.", ".$limit_records.";
                    "));

        $semester = Semester::find($semester_id);
        $session = Session::find($session_id);

        $data = [
            'students'     => $students,
            'session_id'   => $session_id,
            'semester_id'  => $semester_id,
            'setting'      => Setting::find(1)
        ];

        $pdf = PDF::loadView('exams.downloadinbulk', $data);

        return $pdf->download('roll-no-slip-'.$session_id.'-'.$session->title.'-'.$semester_id.'-'.$semester->title.'-'.$tehsil_id.'-'.$tehsil->name.'-'.$skip_records.'-'.$limit_records.'.pdf');
        }
    }

    public function generateslipbyinstitutionid(Request $request){
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $institution_id = $request->input('institution_id');
        $skip_records = $request->input('skip_records');
        $limit_records = $request->input('limit_records');
        $institution = Institution::find($institution_id);

        if(DB::connection()->getDriverName() == 'mysql') {
            $registration_no = "CONCAT(ss.id, '-', stds.id, '-', s.id) AS registration_no,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $registration_no = "(ss.id || '-' || stds.id || '-' || s.id) AS registration_no,";
        }

        if($institution_id){
            $students = DB::select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            s.image,
                            ss.title as session_title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.id as center_id,
                            i.name as center_name,
                            stds.name as class_name,
                            d.name as district_name,
                            ".$registration_no."
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN tehsils as t
                        ON t.id = i.tehsil_id
                        JOIN districts as d
                        ON d.id = t.district_id
                        WHERE s.institution_id = ".$institution_id."
                        LIMIT ".$skip_records.", ".$limit_records.";
                    "));

        $semester = Semester::find($semester_id);
        $session = Session::find($session_id);

        $data = [
            'students'     => $students,
            'session_id'   => $session_id,
            'semester_id'  => $semester_id,
            'setting'      => Setting::find(1)
        ];

        $pdf = PDF::loadView('exams.downloadinbulk', $data);

        return $pdf->download('roll-no-slip-'.$session_id.'-'.$session->title.'-'.$semester_id.'-'.$semester->title.'-'.$institution_id.'-'.$institution->name.'-'.$skip_records.'-'.$limit_records.'.pdf');
        }
    }

    public function generateslipbycenterid(Request $request){
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $center_id = $request->input('center_id');
        $skip_records = $request->input('skip_records');
        $limit_records = $request->input('limit_records');
        $institution = Institution::find($center_id);

        if(DB::connection()->getDriverName() == 'mysql') {
            $registration_no = "CONCAT(ss.id, '-', stds.id, '-', s.id) AS registration_no,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $registration_no = "(ss.id || '-' || stds.id || '-' || s.id) AS registration_no,";
        }

        if($center_id){
            $students = DB::select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            s.image,
                            ss.title as session_title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.id as center_id,
                            i.name as center_name,
                            stds.name as class_name,
                            d.name as district_name,
                            ".$registration_no."
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN tehsils as t
                        ON t.id = i.tehsil_id
                        JOIN districts as d
                        ON d.id = t.district_id
                        WHERE s.center_id = ".$center_id."
                        LIMIT ".$skip_records.", ".$limit_records.";
                    "));

        $semester = Semester::find($semester_id);
        $session = Session::find($session_id);

        $data = [
            'students'     => $students,
            'session_id'   => $session_id,
            'semester_id'  => $semester_id,
            'setting'      => Setting::find(1)
        ];

        $pdf = PDF::loadView('exams.downloadinbulk', $data);

        return $pdf->download('roll-no-slip-'.$session_id.'-'.$session->title.'-'.$semester_id.'-'.$semester->title.'-'.$center_id.'-'.$institution->name.'-'.$skip_records.'-'.$limit_records.'.pdf');
        }
    }

    public function generateslipbyclassid(Request $request){
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $class_id = $request->input('class_id');
        $skip_records = $request->input('skip_records');
        $limit_records = $request->input('limit_records');
        $standard = Standard::find($class_id);

        if(DB::connection()->getDriverName() == 'mysql') {
            $registration_no = "CONCAT(ss.id, '-', stds.id, '-', s.id) AS registration_no,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $registration_no = "(ss.id || '-' || stds.id || '-' || s.id) AS registration_no,";
        }

        if($class_id){
            $students = DB::select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            s.image,
                            ss.title as session_title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.id as center_id,
                            i.name as center_name,
                            stds.name as class_name,
                            d.name as district_name,
                            ".$registration_no."
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN tehsils as t
                        ON t.id = i.tehsil_id
                        JOIN districts as d
                        ON d.id = t.district_id
                        WHERE s.class_id = ".$class_id."
                        LIMIT ".$skip_records.", ".$limit_records.";
                    "));

        $semester = Semester::find($semester_id);
        $session = Session::find($session_id);

        $data = [
            'students'     => $students,
            'session_id'   => $session_id,
            'semester_id'  => $semester_id,
            'setting'      => Setting::find(1)
        ];

        $pdf = PDF::loadView('exams.downloadinbulk', $data);

        return $pdf->download('roll-no-slip-'.$session_id.'-'.$session->title.'-'.$semester_id.'-'.$semester->title.'-'.$class_id.'-'.$standard->name.'-'.$skip_records.'-'.$limit_records.'.pdf');
        }
    }

    public function generateslipbystudenttype(Request $request){
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $student_type = $request->input('student_type');
        $skip_records = $request->input('skip_records');
        $limit_records = $request->input('limit_records');

        if(DB::connection()->getDriverName() == 'mysql') {
            $registration_no = "CONCAT(ss.id, '-', stds.id, '-', s.id) AS registration_no,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $registration_no = "(ss.id || '-' || stds.id || '-' || s.id) AS registration_no,";
        }

        if($student_type != ''){
            $students = DB::select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            s.image,
                            ss.title as session_title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.id as center_id,
                            i.name as center_name,
                            stds.name as class_name,
                            d.name as district_name,
                            ".$registration_no."
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN tehsils as t
                        ON t.id = i.tehsil_id
                        JOIN districts as d
                        ON d.id = t.district_id
                        WHERE s.student_type = ".$student_type."
                        LIMIT ".$skip_records.", ".$limit_records.";
                    "));

        $semester = Semester::find($semester_id);
        $session = Session::find($session_id);

        $data = [
            'students'     => $students,
            'session_id'   => $session_id,
            'semester_id'  => $semester_id,
            'setting'      => Setting::find(1)
        ];

        $text = $student_type == 1 ? 'PRIVATE':'REGULAR';

        $pdf = PDF::loadView('exams.downloadinbulk', $data);

        return $pdf->download('roll-no-slip-'.$session_id.'-'.$session->title.'-'.$semester_id.'-'.$semester->title.'-'.$student_type.'-'.$text.'-'.$skip_records.'-'.$limit_records.'.pdf');
        }
    }

    public function generateawardsheetbydata(){
        $this->selected_sub_menu = "exams_awardsheets";
        $this->card_title = "View and print award sheets.";

        $sessions = Session::all();

        return view('exams.generateawardsheetbydata')
            ->with('sessions', $sessions)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function generategazette() {
        $this->selected_sub_menu = "exams_gazettes";
        $this->card_title = "View and print gazette";

        $sessions = Session::all();
        $institutions = Institution::all();
        $standards = Standard::all();

        return view('exams.generategazette')
            ->with('sessions', $sessions)
            ->with('institutions', $institutions)
            ->with('standards', $standards)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function downloadgazettebyss(Request $request){
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $center_id = $request->input('center_id');

        $standards = Standard::join('students', 'students.class_id', '=', 'standards.id')->join('institutions', 'institutions.id', '=', 'students.center_id')->where('students.session_id', $session_id)->where('students.center_id', $center_id)->groupBy('standards.id')->get(['standards.id', 'standards.name']);

        $session = Session::find($session_id);
        $semester = Semester::find($semester_id);

        $center = Institution::find($center_id);

        $data = [
            'standards'  => $standards,
            'center_id'  => $center_id, 
            'center'     => $center, 
            'session'    => $session,
            'semester'   => $semester
        ];

        $pdf = PDF::loadView('exams.downloadgazette', $data);

        return $pdf->download('awardsheet-'.$center_id.'-'.$center->name.'-'.$session_id.'-'.$session->title.'-'.$semester_id.'-'.$semester->title.'.pdf');
    }

    public function downloadgazettecombined(Request $request){
        $session_id = $request->input('session_id');
        $center_id = $request->input('center_id');

        $standards = Standard::join('students', 'students.class_id', '=', 'standards.id')->join('institutions', 'institutions.id', '=', 'students.center_id')->where('students.session_id', $session_id)->where('students.center_id', $center_id)->groupBy('standards.id')->get(['standards.id', 'standards.name']);

        $session = Session::find($session_id);

        $center = Institution::find($center_id);

        $data = [
            'standards'  => $standards,
            'center_id'  => $center_id, 
            'center'     => $center, 
            'session'    => $session
        ];

        $pdf = PDF::loadView('exams.downloadgazettecombined', $data);

        return $pdf->download('awardsheet-'.$center_id.'-'.$center->name.'-'.$session_id.'-'.$session->title.'-combined.pdf');
    }

    public function downloadcompletegazette(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
    }

    public function generatecompletegazette(Request $request){
        $this->selected_sub_menu = "exams_gazettes";
        $this->card_title = "View and print gazette";

        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');

        $districts = District::all();

        return view('exams.generatecompletegazette')
            ->with('session_id', $session_id)
            ->with('class_id', $class_id)
            ->with('districts', $districts)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
            
    }

    public function startautogeneration(Request $request){
        ini_set('max_execution_time', 5000);
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');

        if($session_id && $class_id){
            $students = DB::select(DB::raw("
                        SELECT
                            d.id AS district_id,
                            d.name AS district_name,
                            t.id AS tehsil_id,
                            t.name AS tehsil_name,
                            s.center_id,
                            s.institution_id,
                            i.name AS center_name,
                            s.name AS student_name,
                            s.father_name,
                            s.class_id,
                            std.name AS class_name,
                            s.id AS roll_no
                            FROM students AS s
                            JOIN institutions AS i
                            ON s.center_id = i.id
                            JOIN tehsils AS t
                            ON i.tehsil_id = t.id
                            JOIN districts AS d
                            ON t.district_id = d.id
                            JOIN standards AS std
                            ON s.class_id = std.id
                            JOIN students_exams AS se
                            ON se.student_id = s.id
                            WHERE s.session_id = ". $session_id ."
                            AND s.class_id = ". $class_id ."
                            GROUP BY s.id
                            ORDER BY i.id;
                    "));

            Gazette::where('session_id', $session_id)->where('class_id', $class_id)->delete();
            TableOfContent::where('session_id', $session_id)->where('class_id', $class_id)->delete();

            foreach($students as $student) {

                //$gazette =  Gazette::where('session_id', $session_id)->where('class_id', $class_id)->where('student_id', $student->roll_no)->first(['created_at']);

                //if($gazette) {
                //    continue;
                    /*$created_at = date_create(date('Y-m-d H:i:s', strtotime($gazette->created_at)));
                    $current_date = date_create(date('Y-m-d H:i:s'));
                    $diff = date_diff($created_at, $current_date);
                    $diff_in_days = (int)$diff->format("%R%a");

                    if($diff_in_days > 1){
                        $gazette->delete();
                    } else {
                        continue;
                    }*/
                //} 

                $all_subjects_pass_arr = array();
                $all_subjects_pass_arr['optional_fails'] = array();
                $all_subjects_pass_arr['compulsory_fails'] = array();
                $all_subjects_pass_arr['less_than_10_optional_fails'] = array();
                $all_subjects_pass_arr['less_than_10_compulsory_fails'] = array();

                $gazette = new Gazette;
                $gazette->district_id = $student->district_id;
                $gazette->tehsil_id = $student->tehsil_id;
                $gazette->center_id = $student->center_id;
                $gazette->class_id = $student->class_id;
                $gazette->session_id = $session_id;
                $gazette->student_id = $student->roll_no;
                $gazette->institution_id = $student->institution_id;

                $subjects = DB::select(DB::raw("
                        select 
                            subjects.id, 
                            subjects.name, 
                            subjects.is_optional, 
                            students_exams.student_id, 
                            students_exams.semester_id, 
                            (CASE  WHEN SUM(students_exams.total_obt_marks)=0 AND SUM(students_exams.is_absent)=2 THEN 1 ELSE 0 END) AS is_absent,
                            students_exams.sheet_no, 
                            ROUND(((SUM(students_exams.theory_max_marks)/100)*semesters.division_percentage), 0) AS theory_max_marks, 
                            ROUND(((SUM(students_exams.theory_obt_marks)/100)*semesters.division_percentage), 0) AS theory_obt_marks, 
                            ROUND(((SUM(students_exams.practical_max_marks)/100)*semesters.division_percentage), 0) AS practical_max_marks, 
                            ROUND(((SUM(students_exams.practical_obt_marks)/100)*semesters.division_percentage), 0) AS practical_obt_marks, 
                            ROUND(((SUM(students_exams.total_max_marks)/100)*semesters.division_percentage), 0) AS total_max_marks, 
                            ROUND(((SUM(students_exams.total_obt_marks)/100)*semesters.division_percentage), 0) AS total_obt_marks 
                        from subjects 
                        inner join students_exams 
                        on students_exams.subject_id = subjects.id 
                        inner join students 
                        on students.id = students_exams.student_id
                        inner join semesters
                        on semesters.id = students_exams.semester_id
                        where students.class_id = ".$class_id." 
                        and students.session_id = ".$session_id." 
                        and students.id = ".$student->roll_no." 
                        GROUP BY subjects.id
                        order by subjects.id asc;
                    "));

                $j=0;
                $found = true;
                $total_obt_marks = 0;
                $total_max_marks = 0;
                foreach($subjects as $subject) {
                    $total_obt_marks += $subject->total_obt_marks;
                    $total_max_marks += $subject->total_max_marks;
                    if(!($subject->is_absent)) {
                        if((($subject->total_obt_marks/$subject->total_max_marks)*100) >= 33) {

                          $all_subjects_pass_arr['all_pass'][$j] = true;

                        } else {
                          $all_subjects_pass_arr['all_pass'][$j] = false;

                          if($subject->is_optional == true){

                            $all_subjects_pass_arr['optional_fails'][$j] = true;

                            if((($subject->total_obt_marks/$subject->total_max_marks)*100) < 10) {
                                $all_subjects_pass_arr['less_than_10_optional_fails'][$j] = true;
                            }
                          } else {
                            $all_subjects_pass_arr['compulsory_fails'][$j] = true;

                            if((($subject->total_obt_marks/$subject->total_max_marks)*100) < 10) {

                                $all_subjects_pass_arr['less_than_10_compulsory_fails'][$j] = true;
                            }
                          }
                        }
                      } else {
                        $all_subjects_pass_arr['all_pass'][$j] = false;

                        if($subject->is_optional == true){
                          $all_subjects_pass_arr['optional_fails'][$j] = true;
                          $all_subjects_pass_arr['less_than_10_optional_fails'][$j] = true;
                        } else {
                          $all_subjects_pass_arr['compulsory_fails'][$j] = true;
                          $all_subjects_pass_arr['less_than_10_compulsory_fails'][$j] = true;
                        }
                    }

                    $j++;

                }

                if(!in_array(0, $all_subjects_pass_arr['all_pass'])) {
                    $gazette->result = 0;
                } else {
                    if(count($all_subjects_pass_arr['optional_fails']) == 1 && count($all_subjects_pass_arr['compulsory_fails']) == 0) {
                        $gazette->result = 1;
                    }
                    else if(count($all_subjects_pass_arr['compulsory_fails']) == 1 && count($all_subjects_pass_arr['less_than_10_compulsory_fails']) == 0 && count($all_subjects_pass_arr['optional_fails']) == 0) {
                        $gazette->result = 1;
                    }
                    else if(count($all_subjects_pass_arr['compulsory_fails']) == 0 && count($all_subjects_pass_arr['optional_fails']) == 2 && count($all_subjects_pass_arr['less_than_10_optional_fails']) == 0){
                        $gazette->result = 1;
                    }
                    else if(count($all_subjects_pass_arr['compulsory_fails']) == 1 && count($all_subjects_pass_arr['optional_fails']) == 1 && count($all_subjects_pass_arr['less_than_10_optional_fails']) == 0 && count($all_subjects_pass_arr['less_than_10_compulsory_fails']) == 0) {
                        $gazette->result = 1;
                    }
                    else {
                        $gazette->result = 2;
                    }
                }

                $gazette->total_obt_marks = $total_obt_marks;
                $gazette->total_max_marks = $total_max_marks;
                $percentage_marks = round((($total_obt_marks/$total_max_marks)*100), 2);
                $gazette->percentage_marks = $percentage_marks;
                if($percentage_marks >= 80) {
                    $gazette->grade = 'A+';
                } else if($percentage_marks >=70 && $percentage_marks <= 79.99) {
                    $gazette->grade = 'A';
                } else if($percentage_marks >= 60 && $percentage_marks <= 69.99){
                    $gazette->grade = 'B';
                } else if($percentage_marks >= 50 && $percentage_marks <= 59.99){
                    $gazette->grade = 'C';
                } else if($percentage_marks >=40 && $percentage_marks <= 49.99) {
                    $gazette->grade = 'D';
                } else if($percentage_marks>=33 && $percentage_marks <= 39.99) {
                    $gazette->grade = 'E';
                } else {
                    $gazette->grade = 'F';
                }

                $gazette->save();
            }

            return response()->json(['success'=>'true', 'message'=>'Successfully Updated Gazette List']);

        }
        return response()->json(['success'=>'false', 'message'=>'Something Went Wrong!. Please try again later.']);
    }

    public function downloadgazettecoverpage(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');

        if($session_id && $class_id){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);

            $data = [
                'session'    => $session,
                'standard'   => $standard,
                'setting'    => Setting::find(1)
            ];

            $pdf = PDF::loadView('gazettepages.new_coverpage', $data);

            return $pdf->download('gazette_cover_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function downloadministermessagepage(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $page_no = $request->input('page_no');

        if($session_id && $class_id && $page_no){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);

            $data = [
                'session'    => $session,
                'standard'   => $standard,
                'page_no'    => $page_no,
                'setting'    => Setting::find(1)
            ];

            $pdf = PDF::loadView('gazettepages.new_ministermessage', $data);

            return $pdf->download('gazette_minister_message_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function downloadsecretarymessage(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $page_no = $request->input('page_no');

        if($session_id && $class_id && $page_no){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);

            $data = [
                'session'    => $session,
                'standard'   => $standard,
                'page_no'    => $page_no,
                'setting'    => Setting::find(1)
            ];

            $pdf = PDF::loadView('gazettepages.new_secretarymessage', $data);

            return $pdf->download('gazette_secretary_message_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function downloadcontrollermessage(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $page_no = $request->input('page_no');

        if($session_id && $class_id && $page_no){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);

            $data = [
                'session'    => $session,
                'standard'   => $standard,
                'page_no'    => $page_no,
                'setting'    => Setting::find(1)
            ];

            $pdf = PDF::loadView('gazettepages.new_controllermessage', $data);

            return $pdf->download('gazette_controller_message_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function downloadpreamble(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $page_no = $request->input('page_no');

        if($session_id && $class_id && $page_no){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);
            $pass_fail_students = StudentsExam::getSessionCombinedResultDetail($session_id, $class_id);

            $data = [
                'session'            => $session,
                'standard'           => $standard,
                'page_no'            => $page_no,
                'setting'            => Setting::find(1),
                'result'             => $pass_fail_students[0]
            ];

            $pdf = PDF::loadView('gazettepages.new_preamble', $data);

            return $pdf->download('gazette_preamble_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function downloadpositionholders(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $page_no = $request->input('page_no');

        if($session_id && $class_id && $page_no){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);

            $results = DB::select(DB::raw("
                SELECT s.id, s.name, s.father_name, i.name AS institution_name, d.name AS district_name, g.total_obt_marks, ROUND((g.total_obt_marks/g.total_max_marks)*100, 2) AS marks_percentage
                    FROM students AS s
                    JOIN gazettes AS g
                    ON g.student_id = s.id
                    JOIN institutions AS i
                    ON i.id = s.institution_id
                    JOIN districts AS d
                    ON d.id = g.district_id
                    WHERE g.result = 0 AND g.session_id = :session_id AND g.class_id = :standard_id
                    ORDER BY g.total_obt_marks DESC;
            "), array('session_id'=>$session_id, 'standard_id'=>$class_id));

            $results_arr = array();

            $i = 1;
            $index = 0;
            $total_obt_marks_arr = array();
            foreach($results as $result){
                $total_obt_marks_arr[$index] = $result->total_obt_marks;
                $index++;
            }

            $occurences = array_count_values($total_obt_marks_arr);

            $counter = 1;
            $index = 0;
            $count = 0;
            foreach($occurences as $occurence){
                if($counter != 4){    
                    for($j=0; $j<$occurence; $j++){
                        $results_arr[$index][$j]['id'] = $results[$count+$j]->id;
                        $results_arr[$index][$j]['name'] = $results[$count+$j]->name;
                        $results_arr[$index][$j]['father_name'] = $results[$count+$j]->father_name;
                        $results_arr[$index][$j]['institution_name'] = $results[$count+$j]->institution_name;
                        $results_arr[$index][$j]['district_name'] = $results[$count+$j]->district_name;
                        $results_arr[$index][$j]['total_obt_marks'] = $results[$count+$j]->total_obt_marks;
                        $results_arr[$index][$j]['marks_percentage'] = $results[$count+$j]->marks_percentage;
                        $results_arr[$index][$j]['position'] = $counter;
                    }
                    $count = $count+$occurence;
                } else {
                    break;
                }
                $counter++;
                $index++;
            }

            $data = [
                'session'          => $session,
                'standard'         => $standard,
                'page_no'          => $page_no,
                'position_holders' => $results_arr,
                'setting'          => Setting::find(1)
            ];

            $pdf = PDF::loadView('gazettepages.new_positionholders', $data);

            return $pdf->download('gazette_position_holders_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function downloaddistrictwisepositionholders(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $page_no = $request->input('page_no');

        if($session_id && $class_id && $page_no){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);
            $districts = District::all();

            $data = [
                'session'    => $session,
                'standard'   => $standard,
                'page_no'    => $page_no,
                'districts'  => $districts,
                'setting'    => Setting::find(1)
            ];

            $pdf = PDF::loadView('gazettepages.new_downloaddistrictwisepositionholders', $data);

            return $pdf->download('gazette_district_wise_position_holders_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function overalltoptenpositionholders(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $page_no = $request->input('page_no');

        if($session_id && $class_id && $page_no){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);
            $districts = District::all();

            $data = [
                'session'    => $session,
                'standard'   => $standard,
                'page_no'    => $page_no,
                'districts'  => $districts,
                'setting'    => Setting::find(1)
            ];

            $pdf = PDF::loadView('gazettepages.new_overalltoptenpositionholders', $data);

            return $pdf->download('gazette_overall_top_ten_position_holders_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function generatetableofcontents(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $minister_page_no = $request->input('minister_page_no');
        $secretary_page_no = $request->input('secretary_page_no');
        $controller_page_no = $request->input('controller_page_no');
        $preamble_page_no = $request->input('preamble_page_no');
        $top_position_holders_page_no = $request->input('top_position_holders_page_no');
        $top_district_wise_position_holders_page_no = $request->input('top_district_wise_position_holders_page_no');
        $overall_top_ten_position_holders_page_no = $request->input('overall_top_ten_position_holders_page_no');
        $pie_graph_overall_result_summary_page_no = $request->input('pie_graph_overall_result_summary_page_no');
        $bar_graph_districtwise_result_summary_page_no = $request->input('bar_graph_districtwise_result_summary_page_no');
        $bar_graph_subjectwise_result_summary_page_no = $request->input('bar_graph_subjectwise_result_summary_page_no');
        $bar_graph_subjectwise_districtwise_result_summary_page_no = $request->input('bar_graph_subjectwise_districtwise_result_summary_page_no');
    
        if($session_id && $class_id){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);
            $districts = District::all();

            $data = [
                'session' => $session,
                'standard' => $standard,
                'minister_page_no' => $minister_page_no,
                'secretary_page_no' => $secretary_page_no,
                'controller_page_no' => $controller_page_no,
                'preamble_page_no' => $preamble_page_no,
                'top_position_holders_page_no' => $top_position_holders_page_no,
                'top_district_wise_position_holders_page_no' => $top_district_wise_position_holders_page_no,
                'overall_top_ten_position_holders_page_no' => $overall_top_ten_position_holders_page_no,
                'pie_graph_overall_result_summary_page_no' => $pie_graph_overall_result_summary_page_no,
                'bar_graph_districtwise_result_summary_page_no' => $bar_graph_districtwise_result_summary_page_no,
                'bar_graph_subjectwise_result_summary_page_no' => $bar_graph_subjectwise_result_summary_page_no,
                'bar_graph_subjectwise_districtwise_result_summary_page_no' => $bar_graph_subjectwise_districtwise_result_summary_page_no,
                'setting'=>Setting::find(1),
                'districts'=>$districts
            ];

            $pdf = PDF::loadView('gazettepages.new_downloadtableofcontents', $data);

            return $pdf->download('gazette_table_of_contents_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }

    }

    public function downloadpiegraphoverallsummary(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $page_no = $request->input('page_no');
        $total_students_appeared = $request->input('total_students_appeared');
        $pass_students = $request->input('pass_students');
        $promoted_students = $request->input('promoted_students');
        $reappear_students = $request->input('reappear_students');
        $pie_graph_image = $request->input('pie_graph_image');

        if($session_id && $class_id && $page_no){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);

            $data = [
                'session'                 => $session,
                'standard'                => $standard,
                'page_no'                 => $page_no,
                'image_address'           => $pie_graph_image,
                'total_students_appeared' => $total_students_appeared,
                'pass_students'           => $pass_students,
                'promoted_students'       => $promoted_students,
                'reappear_students'       => $reappear_students,
                'setting'                 => Setting::find(1)
            ];

            $pdf = PDF::loadView('gazettepages.new_downloadpiegraphoverallsummary', $data);

            return $pdf->download('gazette_pie_graph_overall_result_summary_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function downloadbargraphdistrictwisesummary(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $page_no = $request->input('page_no');
        $bar_graph_image = $request->input('bar_graph_image');
        $table_data = $request->input('table_data');

        if($session_id && $class_id && $page_no){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);

            $data = [
                'session'       => $session,
                'standard'      => $standard,
                'page_no'       => $page_no,
                'image_address' => $bar_graph_image,
                'table_data'    => json_decode($table_data),
                'setting'       => Setting::find(1)
            ];

            $pdf = PDF::loadView('gazettepages.new_downloadbargraphdistrictwiseresultsummary', $data);

            return $pdf->download('gazette_bar_graph_districtwiese_result_summary_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function downloadsubjectwiseresultpercentage(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $page_no = $request->input('page_no');
        $bar_graph_image = $request->input('bar_graph_image');
        $table_data = $request->input('table_data');

        if($session_id && $class_id && $page_no){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);

            $data = [
                'session'       => $session,
                'standard'      => $standard,
                'page_no'       => $page_no,
                'image_address' => $bar_graph_image,
                'table_data'    => json_decode($table_data),
                'setting'       => Setting::find(1)
            ];

            $pdf = PDF::loadView('gazettepages.new_downloadsubjectwiseresultpercentage', $data);

            return $pdf->download('gazette_bar_graph_subjectwise_percentage_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function bargraphsubjectwisedistrictsummary(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $page_no = $request->input('page_no');
        $bar_graph_images = $request->input('bar_graph_image');

        if($session_id && $class_id && $page_no){

            $session = Session::find($session_id);
            $standard = Standard::find($class_id);

            $data = [
                'session'       => $session,
                'standard'      => $standard,
                'page_no'       => $page_no,
                'image_addresses' => $bar_graph_images
            ];

            $pdf = PDF::loadView('gazettepages.new_bargraphsubjectwisedistrictsummary', $data);

            return $pdf->download('gazette_bar_graph_subjectwise_districtwise_result_summary_page-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    public function printcompletegazettewithpages(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $district_id = $request->input('district_id');
        $page_no = $request->input('page_no');

        $district = District::find($district_id);

        @ini_set('max_execution_time', 5000);

        if($session_id && $class_id && $page_no) {
            $session = Session::find($session_id);
            $standard = Standard::find($class_id);
            $districts = District::all();

            $data = [
                'session'       => $session,
                'standard'      => $standard,
                'page_no'       => $page_no,
                'district'      => $district,
                'setting'       => Setting::find(1)
            ];

            @ini_set('memory_limit', '-1');

            $pdf = PDF::loadView('gazettepages.new_printcompletegazettewithpages', $data);

            return $pdf->download('complete gazettes_by_districts-'.$session_id.'-'.$session->title.'-'.$standard->id.'-'.$standard->name. '-'.$district->name.'.pdf');
        }

    }

    public function resetautgeneratedmeritlist(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');

        if($session_id && $class_id) {
            Gazette::where('session_id', '=', $session_id)->where('class_id', $class_id)->delete();
            TableOfContent::where('session_id', $session_id)->where('class_id', $class_id)->delete();
            return response()->json(['success'=>'true', 'message'=>'Successfully removed all records from the table.']);
        }

        return response()->json(['success'=>'false', 'message'=>'Something Went Wrong!. Please try again later.']);
    }

    public function generateawardsheet(Request $request) {
        $this->selected_sub_menu = "exams_awardsheets";
        $this->card_title = "View and print award sheets.";

        $session_id = $request->input('session_id');
        $semester_id = $request->input('session_id');

        if(request()->ajax())
        {
            return datatables()->of(DB::select(DB::raw("
                SELECT
                    i.id,
                    i.name,
                    t.name as tehsil_name
                    FROM institutions as i
                    JOIN tehsils as t
                    ON t.id = i.tehsil_id
                    WHERE i.is_center = 1;
                    ")))
                    ->addColumn('action', function($data) use ($session_id, $semester_id){
                        $button = '<a style="margin-bottom:5px;" href="'.url('admin/exams/downloadawardsheet/'.$data->id.'/'.$session_id.'/'.$semester_id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span>&nbsp;&nbsp;Generate Award Sheet</a>';

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('exams.generateawardsheet')
            ->with('session_id', $session_id)
            ->with('semester_id', $semester_id)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function downloadawardsheet($id, $session_id, $semester_id){
        $this->selected_sub_menu = "exams_awardsheets";
        $this->card_title = "Download award sheet";

        $center = Institution::join('tehsils', 'tehsils.id', '=', 'institutions.tehsil_id')->where('is_center', 1)->where('institutions.id', $id)->first(['institutions.id', 'institutions.name', DB::raw('tehsils.name as tehsil_name')]);

        $standards = Standard::join('students', 'students.class_id', '=', 'standards.id')->join('institutions', 'institutions.id', '=', 'students.center_id')->where('students.center_id', $center->id)->where('students.session_id', $session_id)->groupBy('standards.id')->get(['standards.id', 'standards.name']);

        if(DB::connection()->getDriverName() == 'mysql') {
            $paper_date = "DATE_FORMAT(datesheets.paper_date, '%d-%m-%Y') AS paper_date";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $paper_date = "strftime('%d-%m-%Y', datesheets.paper_date) AS paper_date";
        }

        $subjects = Subject::join('students_subjects', 'students_subjects.subject_id', '=', 'subjects.id')->join('students', 'students.id', 'students_subjects.student_id')->join('datesheets', 'datesheets.subject_id', '=', 'subjects.id')->where('students.center_id', $center->id)->where('datesheets.semester_id', $semester_id)->where('students.session_id', $session_id)->groupBy('subjects.id')->get(['subjects.id', 'subjects.name', DB::raw($paper_date)]);

        $session = Session::find($session_id);
        $semester = Semester::find($semester_id);

        $data = [
            'center'     => $center,
            'standards'  => $standards,
            'subjects'   => $subjects,
            'session'    => $session,
            'semester'   => $semester
        ];

        $pdf = PDF::loadView('exams.downloadawardsheet', $data);

        return $pdf->download('awardsheet-'.$session_id.'-'.$session->title.'-'.$semester_id.'-'.$semester->title.'-'.$center->id.'-'.$center->name.'-'.$center->tehsil_name.'.pdf');
    }

    public function generatemarksheets() {
        $this->selected_sub_menu = "exams_marksheets";
        $this->card_title = "View and print mark sheets.";

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
                            s.dob_in_words,
                            (CASE  WHEN s.gender=0 THEN 'Male' ELSE 'Female' END) AS gender,
                            s.home_address,
                            s.cell_no,
                            s.email,
                            s.image,
                            (CASE  WHEN s.student_type=0 THEN 'Regular' ELSE 'Private' END) AS student_type,
                            ss.title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.name as center_name,
                            stds.name as class_name,
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id;")))
                    ->addColumn('image', function($data){
                        return "<img src='".url($data->image)."' style='height:auto;width:100px;'>";
                    })
                    ->addColumn('subjects', function($data){
                        $result = "";
                        $subjects = StudentsSubject::join('subjects', 'subjects.id', '=', 'students_subjects.subject_id')->where('students_subjects.student_id', $data->id)->get();
                        foreach($subjects as $subject){
                            $result.=$subject->name.", ";
                        }
                        return $result;
                    })
                    ->addColumn('action', function($data){
                        $button = '<a style="margin-bottom:5px;" href="'.url('admin/exams/downloadmarksheet/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-primary margin-2px btn-sm"><span class="fa fa-share-square"></span>&nbsp;&nbsp;Generate Marks Sheet Certificate</a>';
                        $button .= '<a style="margin-bottom:5px;" href="'.url('admin/exams/downloaddetailedmarksheet/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-warning margin-2px btn-sm"><span class="fa fa-share-square"></span>&nbsp;&nbsp;Detailed Marks Sheet</a>';

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $sessions = Session::all();

        return view('exams.generatemarksheets')
            ->with('sessions', $sessions)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function downloaddetailedmarksheet($id){

        if(DB::connection()->getDriverName() == 'mysql') {
            $date_of_birth = "DATE_FORMAT(s.date_of_birth, '%d-%m-%Y') AS date_of_birth,";
            $registration_no = "CONCAT(ss.id, '-', stds.id, '-', s.id) AS registration_no,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $date_of_birth = "strftime('%d-%m-%Y', s.date_of_birth) AS date_of_birth,";
            $registration_no = "(ss.id || '-' || stds.id || '-' || s.id) AS registration_no,";
        }

        $student = DB::select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            s.image,
                            s.gender,
                            s.student_type as status,
                            ".$date_of_birth."
                            s.dob_in_words,
                            ss.title as session_title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.id as center_id,
                            s.class_id,
                            ss.year,
                            i.name as center_name,
                            stds.name as class_name,
                            d.name as district_name,
                            ".$registration_no."
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN tehsils as t
                        ON t.id = i.tehsil_id
                        JOIN districts as d
                        ON d.id = t.district_id
                        WHERE s.id = ".$id.";
                    "));

        $student = $student[0];

        $count = StudentsExam::where('student_id', $id)->count();

        if($count == 0) {
            return Redirect::to('admin/exams/generatemarksheets')
                ->with('message', 'There are no any marks entered for any of the semesters for the selected student.');
        }

        $semesters=Semester::join('students_exams', 'students_exams.semester_id', '=', 'semesters.id')->groupBy('semesters.id')->where('students_exams.student_id', $student->id)->where('session_id', $student->session_id)->get(['semesters.id', 'semesters.title']);

        $data = [
            'student'     => $student,
            'semesters'   => $semesters,
            'setting'     => Setting::find(1)
        ];

        $pdf = PDF::loadView('exams.downloaddetailedmarksheet', $data);

        return $pdf->download('getailed_marksheet-'.$student->id.'-'.$student->name.'-'.$student->father_name.'.pdf');
    }

    public function downloadmarksheet($id) {

        if(DB::connection()->getDriverName() == 'mysql') {
            $date_of_birth = "DATE_FORMAT(s.date_of_birth, '%d-%m-%Y') AS date_of_birth,";
            $registration_no = "CONCAT(ss.id, '-', stds.id, '-', s.id) AS registration_no,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $date_of_birth = "strftime('%d-%m-%Y', s.date_of_birth) AS date_of_birth,";
            $registration_no = "(ss.id || '-' || stds.id || '-' || s.id) AS registration_no,";
        }

        $count = StudentsExam::where('student_id', $id)->count();

        if($count == 0) {
            return Redirect::to('admin/exams/generatemarksheets')
                ->with('message', 'There are no any marks entered for any of the semesters for the selected student.');
        }

        $student = DB::select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            s.image,
                            s.gender,
                            s.student_type as status,
                            ".$date_of_birth."
                            s.dob_in_words,
                            ss.title as session_title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.id as center_id,
                            s.class_id,
                            ss.year,
                            i.name as center_name,
                            stds.name as class_name,
                            d.name as district_name,
                            ".$registration_no."
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN tehsils as t
                        ON t.id = i.tehsil_id
                        JOIN districts as d
                        ON d.id = t.district_id
                        WHERE s.id = ".$id.";
                    "));

        $student = $student[0];

        $data = [
            'student'     => $student,
            'setting'     => Setting::find(1)
        ];

        $pdf = PDF::loadView('exams.downloadmarksheet', $data);

        return $pdf->download('marksheet-'.$student->id.'-'.$student->name.'-'.$student->father_name.'.pdf');
    }

    public function generateslips(){
        $this->selected_sub_menu = "exams_slips";
        $this->card_title = "View and print slips.";

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
                            s.dob_in_words,
                            (CASE  WHEN s.gender=0 THEN 'Male' ELSE 'Female' END) AS gender,
                            s.home_address,
                            s.cell_no,
                            s.email,
                            s.image,
                            (CASE  WHEN s.student_type=0 THEN 'Regular' ELSE 'Private' END) AS student_type,
                            ss.title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.name as center_name,
                            stds.name as class_name,
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id;")))
                    ->addColumn('image', function($data){
                        return "<img src='".url($data->image)."' style='height:auto;width:100px;'>";
                    })
                    ->addColumn('subjects', function($data){
                        $result = "";
                        $subjects = StudentsSubject::join('subjects', 'subjects.id', '=', 'students_subjects.subject_id')->where('students_subjects.student_id', $data->id)->get();
                        foreach($subjects as $subject){
                            $result.=$subject->name.", ";
                        }
                        return $result;
                    })
                    ->addColumn('action', function($data){
                        $button = '<a style="margin-bottom:5px;" href="'.url('admin/exams/downloadslip/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span>&nbsp;&nbsp;Generate Slip</a>';

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $sessions = Session::all();

        return view('exams.generateslips')
            ->with('sessions', $sessions)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }


    public function downloadslip($id){

        if(DB::connection()->getDriverName() == 'mysql') {
            $registration_no = "CONCAT(ss.id, '-', stds.id, '-', s.id) AS registration_no,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $registration_no = "(ss.id || '-' || stds.id || '-' || s.id) AS registration_no,";
        }

        $student = DB::select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            s.image,
                            ss.title as session_title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.id as center_id,
                            i.name as center_name,
                            stds.name as class_name,
                            d.name as district_name,
                            ".$registration_no."
                            s.session_id,
                            s.created_at,
                            s.updated_at
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN tehsils as t
                        ON t.id = i.tehsil_id
                        JOIN districts as d
                        ON d.id = t.district_id
                        WHERE s.id = ".$id.";
                    "));


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
                        WHERE ss.student_id = '.$id.';

                    '));
        $student = $student[0];

        $data = [
            'student'     => $student,
            'subjects'    => $subjects,
            'setting'     => Setting::find(1)
        ];

        $pdf = PDF::loadView('exams.downloadslip', $data);

        return $pdf->download('roll-no-slip-'.$student->id.'-'.$student->name.'-'.$student->father_name.'.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $semester_id)
    {
        $this->selected_sub_menu = "exams_index";
        $this->card_title = "Please fill in the form to update the marks";

        $student = Student::find($id);
        $semester = Semester::find($semester_id);

        $subjects = StudentsSubject::join('subjects', 'subjects.id', '=', 'students_subjects.subject_id')->where('students_subjects.student_id', $student->id)->get(['subjects.*']);

        return view('exams.edit')
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
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
                        return Redirect::to('admin/exams/edit/'.$request->input('student_id').'/'.$request->input('semester_id'))
                            ->withErrors($validator)
                            ->withInput($request->all());      
                    }
                }

                return Redirect::to('admin/exams/index')
                        ->with('message', 'Exam record updated successfully.');
            }
            
        } else {
            return Redirect::to('admin/exams/index')
                            ->with('message', 'Something Went Wrong! Please try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $semester = Semester::find($request->get('id'));

        if($semester){
            try {
                $semester->delete();
                return response()->json(['success'=>'true', 'message'=>'Success! Your request has been completed successfully.']);

            } catch (\Illuminate\Database\QueryException $e) {

                if($e->getCode()==23000) {
                    return response()->json(['success'=>'false', 'message'=>'<b>Integrity Constraint Violation!</b><br>You must delete child records first then you should delete this item to ensure referential integrity.']);
                } else {
                    return response()->json(['success'=>'false', 'message'=>'Something Went Wrong! Please Try Again Later.']);
                }
            }
        }

        return response()->json(['success'=>'false', 'message'=>'Something went wrong. Please try again later']);
    }

    public function updatemarksbycenters(){
        $this->selected_sub_menu = "update_marks_by_centers";
        $this->card_title = "Please fill in the form to update marks by centers.";

        $sessions = Session::all();
        $standards = Standard::all();
        $centers = Institution::where('is_center', 1)->get();
        $subjects = Subject::all();

        return view('exams.updatemarksbycenters')
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

        return view('exams.storemarksbycenters')
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
                    return Redirect::to('admin/exams/updatemarksbycenters')
                        ->withErrors($validator)
                        ->withInput($request->all());      
                }
            } // end for loop

            return Redirect::to('admin/exams/updatemarksbycenters')
                        ->with('message', 'Exam record updated successfully.');
        }

        return Redirect::to('admin/exams/updatemarksbycenters')
                        ->with('message', 'Something went wrong! Please try again later.');
    }
}
