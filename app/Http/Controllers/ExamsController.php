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
use App\Models\FailedJob;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

use DB;
use PDF;
use Hash;

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
    public function index(Request $request)
    {
        $this->selected_sub_menu = "exams_index";
        $this->card_title = "View and Manage all students subject marks.";

        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $center_id = $request->input('center_id');

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
                            ss.id AS session_id,
                            s.center_id
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN standards as stds
                        ON s.class_id = stds.id
                        WHERE s.session_id = ".$session_id."
                        AND s.class_id = ".$class_id."
                        AND s.center_id = ". $center_id .";
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
                            $button .= '<a style="margin-bottom:5px;" href="'.url('admin/exams/edit/'.$data->id.'/'. $semester->id.'/'.$data->session_id.'/'.$data->class_id.'/'.$data->center_id).'" name="edit" id="'.$data->id.'_'.$semester->id.'" class="btn btn-success margin-2px btn-sm">Update '. $semester->title .' Marks</a>';
                        }

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('exams.index')
            ->with('session_id', $session_id)
            ->with('class_id', $class_id)
            ->with('center_id', $center_id)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function editmarksbysearch() {
        $this->selected_sub_menu = "exams_index";
        $this->card_title = "View and Manage all students subject marks.";

        $sessions = Session::all();
        $standards = Standard::all();
        $centers = Institution::where('is_center', 1)->get();

        return view('exams.editmarksbysearch')
            ->with('sessions', $sessions)
            ->with('standards', $standards)
            ->with('centers', $centers)
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
        
    }

    public function generateslipbydistrictid(Request $request){
        
    }

    public function generateslipbytehsilid(Request $request){
        
    }

    public function generateslipbyinstitutionid(Request $request){
        
    }

    public function generateslipbycenterid(Request $request){
        
    }

    public function generateslipbyclassid(Request $request){
        
    }

    public function generateslipbystudenttype(Request $request){
        
    }

    public function generateawardsheetbydata(){
        $this->selected_sub_menu = "exams_awardsheets";
        $this->card_title = "View and print award sheets.";

        $sessions = Session::all();
        $standards = Standard::all();

        return view('exams.generateawardsheetbydata')
            ->with('sessions', $sessions)
            ->with('standards', $standards)
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
        
    }

    public function downloadgazettecombined(Request $request){
        
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
        $centers = Institution::where('is_center', 1)->get();

        return view('exams.generatecompletegazette')
            ->with('session_id', $session_id)
            ->with('class_id', $class_id)
            ->with('districts', $districts)
            ->with('centers', $centers)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
            
    }

    public function startautogeneration(Request $request){
        
    }

    public function downloadgazettecoverpage(Request $request){
        
    }

    public function downloadministermessagepage(Request $request){
        
    }

    public function downloadsecretarymessage(Request $request){
        
    }

    public function downloadcontrollermessage(Request $request){
        
    }

    public function downloadpreamble(Request $request){
        
    }

    public function downloadpositionholders(Request $request){
        
    }

    public function downloaddistrictwisepositionholders(Request $request){
        
    }

    public function districtwisetop10positionholders(Request $request){
        
    }

    public function overalltoptenpositionholders(Request $request){
        
    }

    public function generatetableofcontents(Request $request){
        

    }

    public function downloadpiegraphoverallsummary(Request $request){
        
    }

    public function downloadbargraphdistrictwisesummary(Request $request){
        
    }

    public function downloadsubjectwiseresultpercentage(Request $request){
        
    }

    public function bargraphsubjectwisedistrictsummary(Request $request){
        
    }

    public function printcompletegazettewithpages(Request $request){
        

    }

    public function printcenterwisegazettewithpages(Request $request){
        

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
        $semester_id = $request->input('semester_id');
        $class_id = $request->input('class_id');

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
                    ->addColumn('class_name', function() use ($class_id){
                        $standard = Standard::find($class_id);
                        return $standard->name;
                    })
                    ->addColumn('action', function($data) use ($session_id, $semester_id, $class_id){
                        $button = '<a style="margin-bottom:5px;" href="'.url('admin/exams/downloadawardsheet/'.$data->id.'/'.$session_id.'/'.$semester_id.'/'.$class_id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span>&nbsp;&nbsp;Generate Award Sheet</a>';

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('exams.generateawardsheet')
            ->with('session_id', $session_id)
            ->with('semester_id', $semester_id)
            ->with('class_id', $class_id)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function downloadawardsheet($id, $session_id, $semester_id, $class_id){
        
    }

    public function generatemarksheetsbysearch(){
        $this->selected_sub_menu = "exams_marksheets";
        $this->card_title = "View and print mark sheets.";

        $sessions = Session::all();
        $standards = Standard::all();
        $centers = Institution::where('is_center', 1)->get();

        return view('exams.generatemarksheetsbysearch')
            ->with('sessions', $sessions)
            ->with('standards', $standards)
            ->with('centers', $centers)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function generatemarksheets(Request $request) {
        $this->selected_sub_menu = "exams_marksheets";
        $this->card_title = "View and print mark sheets.";

        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $center_id = $request->input('center_id');

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
                            (CASE WHEN s.image IS NULL THEN '' ELSE s.image END) AS image,
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
                        ON i.id = s.center_id
                        WHERE s.session_id = ".$session_id."
                        AND s.class_id = ".$class_id."
                        AND s.center_id = ".$center_id."
                        ;")))
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
            ->with('session_id', $session_id)
            ->with('class_id', $class_id)
            ->with('center_id', $center_id)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function downloadalldetailedmarksheets(Request $request) {
        
    }

    public function downloaddetailedmarksheet($id){

    }

    public function downloadmarksheet($id) {
        
    }

    public function downloadallmarksheets(Request $request) {

        
    }

    public function generateslipsbysearch(Request $request){
        $this->selected_sub_menu = "exams_slips";
        $this->card_title = "View and print slips.";

        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $class_id = $request->input('class_id');
        $center_id = $request->input('center_id');

        if(DB::connection()->getDriverName() == 'mysql') {
            $date_of_birth = "DATE_FORMAT(s.date_of_birth, '%d-%m-%Y') AS date_of_birth,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $date_of_birth = "strftime('%d-%m-%Y', s.date_of_birth) AS date_of_birth,";
        }


        if(request()->ajax())
        {
            return datatables()->of(
                DB::select(
                    DB::raw("
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
                            (CASE WHEN s.image IS NULL THEN '' ELSE s.image END) AS image,
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
                        ON i.id = s.center_id
                        JOIN semesters sem
                        ON sem.session_id = ss.id
                        WHERE s.session_id = ". $session_id ." 
                        AND s.class_id = ". $class_id ." 
                        AND s.center_id = ". $center_id ."
                        AND sem.id = ". $semester_id ." 
                        ;")))
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
            ->with('session_id', $session_id)
            ->with('semester_id', $semester_id)
            ->with('class_id', $class_id)
            ->with('center_id', $center_id)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function generateslips(){
        $this->selected_sub_menu = "exams_slips";
        $this->card_title = "View and print slips.";

        $sessions = Session::all();
        $standards = Standard::all();
        $centers = Institution::where('is_center', 1)->get();

        return view('exams.generateslipsbysearch')
            ->with('sessions', $sessions)
            ->with('standards', $standards)
            ->with('centers', $centers)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function downloadall(Request $request){
        
    }


    public function downloadslip($id){

        
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
    public function edit($id, $semester_id, $session_id, $class_id, $center_id)
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
            ->with('session_id', $session_id)
            ->with('class_id', $class_id)
            ->with('center_id', $center_id)
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
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $center_id = $request->input('center_id');


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
                        return Redirect::to('admin/exams/edit/'.$request->input('student_id').'/'.$request->input('semester_id').'/'.$session_id.'/'.$class_id.'/'.$center_id)
                                ->withErrors($validator)
                                ->withInput($request->all());      
                    }
                }
                return redirect()->route('exams.index', ['session_id' => $session_id, 'class_id'=>$class_id, 'center_id'=>$center_id])->with('message', 'Exam record updated successfully.');
            }
            
        } else {
            return Redirect::to('admin/exams/editmarksbysearch')
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

        $students = Student::join('students_subjects', 'students_subjects.student_id', '=', 'students.id')->where('students_subjects.subject_id', $subject_id)->where('session_id', $session_id)->where('class_id', $class_id)->where('center_id', $center_id)->get(['students.id', 'students.name']);

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
