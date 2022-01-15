<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentsSubject;
use App\Models\StudentsSemester;
use App\Models\StudentsExam;
use App\Models\Fee;
use App\Models\Institution;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Standard;
use App\Models\Bank;
use App\Models\StudentsFee;
use App\Models\StudentsFeesSelection;
use App\Models\SubjectsGroup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Image;

class StudentsController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Students";
    protected $main_title = "Students";
    protected $breadcrumb_title = "Students";
    protected $selected_main_menu = "students";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "students_index";
        $this->card_title = "View and Manage all students shown below.";

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
                    ->addColumn('fees', function($data){
                        $fees = StudentsFee::join('semesters', 'semesters.id', '=', 'students_fees.semester_id')->where('student_id', $data->id)->orderBy('semesters.id', 'ASC')->get(['students_fees.id', 'semesters.title', 'students_fees.total_amount']);

                        if(count($fees)) {

                            $result = '<table style="margin:0px;" class="table table-sm table-borderless">  
                                      <tbody>';

                            foreach($fees as $fee){
                                $fee_selections = StudentsFeesSelection::join('fees', 'fees.id', '=', 'students_fees_selections.fee_id')->where('students_fees_selections.students_fees_id', $fee->id)->orderBy('fees.id', 'ASC')->get(['fees.id', 'fees.title']);

                                $result.='<tr style="background:transparent">';
                                    $result.= '<td style="margin:0px;padding:0px;padding-right:5px;""><h5><span style="width:100%;" class="badge badge-warning">'.$fee->title.'</span></h5></td>';
                                    $result.= '<td style="margin:0px;padding:0px;padding-right:5px;""><h5><span style="width:100%;" class="badge badge-primary">'.$fee->total_amount.'</span></h5></td>';
                                    $result.= '<td style="margin:0px;padding:0px;padding-right:5px;""><h5>';

                                        foreach($fee_selections as $selection){
                                            $result.='<span style="width:100%;" class="badge badge-danger">'.$selection->title.'</span>';
                                        }
                                    $result.='</h5></td>';

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
                        $button = '<a style="margin-bottom:5px;" href="'.url('admin/students/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span>&nbsp;&nbsp;Edit</a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button style="margin-bottom:5px;" type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('students.destroy').'" data-studentid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span>&nbsp;&nbsp;Delete</button>';

                        $semesters = Semester::where('session_id', $data->session_id)->get();

                        foreach($semesters as $semester){
                            $button .= '<a style="margin-bottom:5px;" href="'.url('admin/students/updatefee/'.$data->id).'/'. $semester->id.'" name="edit" id="'.$data->id.'_'.$semester->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-dollar-sign"></span>&nbsp;&nbsp;'. $semester->title .' Fee</a>';
                        }

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('students.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function updatefee($id, $semester_id)
    {
        $this->selected_sub_menu = "students_create";
        $this->card_title = "Please fill in the form below to update fee details";

        $students_fees = StudentsFee::where('student_id', $id)->where('semester_id', $semester_id)->first();


        $fees = Fee::all();
        $banks = Bank::all();
        $semester = Semester::find($semester_id);
        $student = Student::find($id);

        return view('students.updatefee')
            ->with('fees', $fees)
            ->with('banks', $banks)
            ->with('semester', $semester)
            ->with('student', $student)
            ->with('studentsfee', $students_fees)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function updatefeebysearch($id, $semester_id, $session_id, $class_id, $center_id)
    {
        $this->selected_sub_menu = "students_create";
        $this->card_title = "Please fill in the form below to update fee details";

        $students_fees = StudentsFee::where('student_id', $id)->where('semester_id', $semester_id)->first();


        $fees = Fee::all();
        $banks = Bank::all();
        $semester = Semester::find($semester_id);
        $student = Student::find($id);

        return view('students.updatefee')
            ->with('fees', $fees)
            ->with('banks', $banks)
            ->with('semester', $semester)
            ->with('student', $student)
            ->with('studentsfee', $students_fees)
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


    public function storefee(Request $request){

        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $center_id = $request->input('center_id');

        $validator = Validator::make($request->all(), StudentsFee::$rules);
        if ($validator->passes()) {

            StudentsFeesSelection::where('student_id', $request->input('student_id'))->where('semester_id', $request->input('semester_id'))->delete();
            StudentsFee::where('student_id', $request->input('student_id'))->where('semester_id', $request->input('semester_id'))->delete();

            $studentfee = new StudentsFee;
            $studentfee->student_id = $request->input('student_id');
            $studentfee->semester_id = $request->input('semester_id');
            $studentfee->bank_id = $request->input('bank_id');
            $studentfee->challan_no = $request->input('challan_no');
            $studentfee->date_of_deposit = date('Y-m-d', strtotime($request->input('date_of_deposit')));
            $studentfee->total_amount = $request->input('total_amount');
            $studentfee->save();
            
            $counter = count($request->input('fee_id'));
            $fee_ids = $request->input('fee_id');

            for($i=0; $i<$counter; $i++){
                $students_fees_selection = new StudentsFeesSelection;
                $students_fees_selection->students_fees_id = $studentfee->id;
                $students_fees_selection->student_id = $request->input('student_id');
                $students_fees_selection->semester_id = $request->input('semester_id');
                $students_fees_selection->fee_id = $fee_ids[$i];
                $students_fees_selection->save();
            }

            if($session_id && $class_id && $center_id) {
                return redirect()->route('students.searchstudent', ['session_id'=>$session_id, 'class_id'=>$class_id, 'center_id'=>$center_id])->with('message', 'Fee Details Updated Successfully.');
            } else {
                return Redirect::to('admin/students/search')
                    ->with('message', 'Fee Details Updated Successfully.');
            }
        } else {
            if($session_id && $class_id && $center_id){
                return Redirect::to('admin/students/updatefeebysearch/'.$request->input('student_id').'/'.$request->input('semester_id').'/'.$session_id.'/'.$class_id.'/'.$center_id)
                    ->withErrors($validator)
                    ->withInput($request->all());      
            } else {
                return Redirect::to('admin/students/updatefee/'.$request->input('student_id').'/'.$request->input('semester_id'))
                    ->withErrors($validator)
                    ->withInput($request->all()); 
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->selected_sub_menu = "students_create";
        $this->card_title = "Please fill in the form to create a new student.";
        $institutions = Institution::all();
        $sessions = Session::all();
        $subjects = Subject::all();
        $standards = Standard::all();
        return view('students.create')
            ->with('institutions', $institutions)
            ->with('sessions', $sessions)
            ->with('subjects', $subjects)
            ->with('standards', $standards)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function createsearchedstudent($session_id, $class_id, $center_id)
    {
        $this->selected_sub_menu = "students_create";
        $this->card_title = "Please fill in the form to create a new student.";

        $institutions = Institution::all();
        $sessions = Session::all();
        $subjects = Subject::all();
        $standards = Standard::all();
        return view('students.create')
            ->with('institutions', $institutions)
            ->with('sessions', $sessions)
            ->with('subjects', $subjects)
            ->with('standards', $standards)
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

    public function getFeeData(Request $request){
        $s_class = $request->input('s_class');
        $s_type = $request->input('s_type');

        $fees = DB::select(
            DB::raw("
                SELECT * 
                FROM Fees
                WHERE f_class = :s_class
                AND f_type = :s_type;
            "), array(
                's_class'=>$s_class,
                's_type'=>$s_type
            )
        );
        $response = array();
        foreach($fees as $fee){
           $response[] = array(
              "id"=>$fee->id,
              "text"=>$fee->title
         );
        }
        echo json_encode($response);
        exit;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $center_id = $request->input('center_id');

        $validator = Validator::make($request->all(), Student::$rules);
        if ($validator->passes()) {

            $semesters = Semester::where('session_id', $request->input('session_id'))->get();

            if(count($semesters) == 0){
                return Redirect::to('admin/students/search')
                    ->with('message', 'The selected session for the user does not contain any semesters. Please add at least one semester to continue.');
            }

            $student = new Student;
            $student->name = $request->input('name');
            $student->father_name = $request->input('father_name');
            $student->date_of_birth = date('Y-m-d', strtotime($request->input('date_of_birth')));
            $student->dob_in_words = $request->input('dob_in_words');
            $student->gender = $request->input('gender');
            $student->home_address = $request->input('home_address');
            $student->cell_no = $request->input('cell_no');
            $student->email = $request->input('email');

            if($request->file('image')!='') {
                $originalImage= $request->file('image');
                $thumbnailImage = Image::make($originalImage);

                $web_path_orig = '/images/'.time().'-orig.'.$originalImage->getClientOriginalExtension();

                $orig_add = public_path().$web_path_orig;
                $thumbnailImage->save($orig_add);

                $student->image=$web_path_orig;
            }

            $student->student_type = $request->input('student_type');
            $student->session_id = $request->input('session_id');
            $student->institution_id = $request->input('institution_id');
            $student->center_id = $request->input('center_id');
            $student->class_id = $request->input('class_id');
            
            $student->save();

            $standard = Standard::find($request->input('class_id'));
            $counter = $standard->min_subjects;

            $subject_ids = $request->input('subject_id');

            for($i=0; $i<$counter; $i++){
                $students_subject = new StudentsSubject;
                $students_subject->student_id = $student->id;
                $students_subject->subject_id = $subject_ids[$i];
                $students_subject->save();
            }

            StudentsSemester::where('student_id', $request->input('student_id'))->delete();

            $semesters = Semester::where('session_id', $student->session_id)->get();
            foreach($semesters as $semester){
                $studentsemester = new StudentsSemester;
                $studentsemester->student_id = $student->id;
                $studentsemester->semester_id = $semester->id;
                $studentsemester->save();
            }

            if($session_id && $class_id && $center_id) {
                return redirect()->route('students.searchstudent', ['session_id'=>$session_id, 'class_id'=>$class_id, 'center_id'=>$center_id])->with('message', 'New student created successfully.');
            } else {
                return Redirect::to('admin/students/index')
                    ->with('message', 'New student created successfully.');
            }

        } else {
            return Redirect::to('admin/students/create')
                ->withErrors($validator)
                ->withInput($request->all());      
        }
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
    public function edit($id)
    {
        $this->selected_sub_menu = "students_create";
        $this->card_title = "Please fill in the form to update the student.";

        $student = Student::find($id);
        $institutions = Institution::all();
        if (!$student) {
            return Redirect::to('admin/students/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        $sessions = Session::all();
        $students_subjects = StudentsSubject::where('student_id', $student->id)->get();
        $subjects = Subject::all();
        $standards = Standard::all();
        return view('students.edit')
            ->with('student', $student)
            ->with('institutions', $institutions)
            ->with('sessions', $sessions)
            ->with('subjects', $subjects)
            ->with('standards', $standards)
            ->with('students_subjects', $students_subjects)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function editsearchedstudent($id, $session_id, $class_id, $center_id)
    {
        $this->selected_sub_menu = "students_create";
        $this->card_title = "Please fill in the form to update the student.";

        $student = Student::find($id);
        $institutions = Institution::all();
        if (!$student) {
            return Redirect::to('admin/students/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        $sessions = Session::all();
        $students_subjects = StudentsSubject::where('student_id', $student->id)->get();
        $subjects = Subject::all();
        $standards = Standard::all();
        return view('students.edit')
            ->with('student', $student)
            ->with('institutions', $institutions)
            ->with('sessions', $sessions)
            ->with('subjects', $subjects)
            ->with('standards', $standards)
            ->with('session_id', $session_id)
            ->with('class_id', $class_id)
            ->with('center_id', $center_id)
            ->with('students_subjects', $students_subjects)
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
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $center_id = $request->input('center_id');

        $student = Student::find($request->input('student_id'));
        if($student){
            $validator = Validator::make($request->all(), Student::$rules_edit);
            if ($validator->passes()) {

                $semesters = Semester::where('session_id', $request->input('session_id'))->get();

                if(count($semesters) == 0){
                    return Redirect::to('admin/students/index')
                        ->with('message', 'The selected session for the user does not contain any semesters. Please add at least one semester to continue.');
                }

                $student->name = $request->input('name');
                $student->father_name = $request->input('father_name');
                $student->date_of_birth = date('Y-m-d', strtotime($request->input('date_of_birth')));
                $student->dob_in_words = $request->input('dob_in_words');
                $student->gender = $request->input('gender');
                $student->home_address = $request->input('home_address');
                $student->cell_no = $request->input('cell_no');
                $student->email = $request->input('email');

                if($request->file('image')!='') {
                    $originalImage= $request->file('image');
                    $thumbnailImage = Image::make($originalImage);

                    $web_path_orig = '/images/'.time().'-orig.'.$originalImage->getClientOriginalExtension();

                    $orig_add = public_path().$web_path_orig;
                    $thumbnailImage->save($orig_add);

                    $student->image=$web_path_orig;
                }

                $student->student_type = $request->input('student_type');
                $student->session_id = $request->input('session_id');
                $student->institution_id = $request->input('institution_id');
                $student->center_id = $request->input('center_id');
                $student->class_id = $request->input('class_id');

                $student->save();

                $standard = Standard::find($request->input('class_id'));
                $counter = $standard->min_subjects;

                $subject_ids = $request->input('subject_id');

                StudentsSubject::where('student_id', $student->id)->delete();

                for($i=0; $i<$counter; $i++){
                    $students_subject = new StudentsSubject;
                    $students_subject->student_id = $student->id;
                    $students_subject->subject_id = $subject_ids[$i];
                    $students_subject->save();
                }

                StudentsSemester::where('student_id', $request->input('student_id'))->delete();
                $semesters = Semester::where('session_id', $student->session_id)->get();

                foreach($semesters as $semester){
                    $studentsemester = new StudentsSemester;
                    $studentsemester->student_id = $student->id;
                    $studentsemester->semester_id = $semester->id;
                    $studentsemester->save();
                }

                if($session_id && $class_id && $center_id) {
                    return redirect()->route('students.searchstudent', ['session_id'=>$session_id, 'class_id'=>$class_id, 'center_id'=>$center_id])->with('message', 'Student updated successfully.');
                } else {
                    return Redirect::to('admin/students/index')
                        ->with('message', 'Student updated successfully.');
                }
            } else {
                return Redirect::to('admin/students/edit/'.$student->id)
                    ->withErrors($validator)
                    ->withInput($request->all());      
            }
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
        $student = Student::find($request->get('id'));

        if($student){
            try {
                StudentsSubject::where('student_id', $student->id)->delete();
                StudentsSemester::where('student_id', $student->id)->delete();
                StudentsExam::where('student_id', $student->id)->delete();
                StudentsFeesSelection::where('student_id', $student->id)->delete();
                StudentsFee::where('student_id', $student->id)->delete();
                $student->delete();
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

    public function getsubjectsgroupdata(Request $request){
        $class_id = $request->input('class_id');

        $selectedsubjects = SubjectsGroup::where('class_id', $class_id)->get([DB::raw('subjects_groups.subject_id AS id')]);
        $selected_subs = array();

        $i=0;
        foreach($selectedsubjects as $subject){
            $selected_subs[$i] = $subject->id;
            $i++;
        }

        return json_encode($selected_subs);
    }

    public function search() {
        $this->selected_sub_menu = "search_students";
        $this->card_title = "Please fill in the fields shown below to search.";

        $sessions = Session::all();
        $standards = Standard::all();
        $centers = Institution::where('is_center', 1)->get();

        return view('students.search')
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

    public function searchstudent(Request $request)
    {
        $this->selected_sub_menu = "search_students";
        $this->card_title = "View and Manage all students shown below.";

        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $center_id = $request->input('center_id');

        if(DB::connection()->getDriverName() == 'mysql') {
            $date_of_birth = "DATE_FORMAT(s.date_of_birth, '%d-%m-%Y') AS date_of_birth,";
            $registration_no = "CONCAT(s.session_id, '-', s.class_id, '-', s.id) AS registration_no,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $date_of_birth = "strftime('%d-%m-%Y', s.date_of_birth) AS date_of_birth,";
            $registration_no = "(s.session_id || '-' || s.class_id || '-' || s.id) AS registration_no,";
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
                            ".$registration_no."
                            (CASE  WHEN s.gender=0 THEN 'Male' ELSE 'Female' END) AS gender,
                            s.home_address,
                            s.cell_no,
                            s.email,
                            s.image,
                            s.class_id,
                            s.center_id,
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
                        WHERE s.session_id = ". $session_id ."
                        AND s.class_id = ". $class_id ."
                        AND s.center_id = ". $center_id ."
                        ;")))
                    ->addColumn('image', function($data){
                        return "<img src='".url($data->image)."' style='height:auto;width:100px;'>";
                    })
                    ->addColumn('subjects', function($data){
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
                    ->addColumn('fees', function($data){
                        $fees = StudentsFee::join('semesters', 'semesters.id', '=', 'students_fees.semester_id')->where('student_id', $data->id)->orderBy('semesters.id', 'ASC')->get(['students_fees.id', 'semesters.title', 'students_fees.total_amount']);

                        if(count($fees)) {

                            $result = '<table style="margin:0px;" class="table table-sm table-borderless">  
                                      <tbody>';

                            foreach($fees as $fee){
                                $fee_selections = StudentsFeesSelection::join('fees', 'fees.id', '=', 'students_fees_selections.fee_id')->where('students_fees_selections.students_fees_id', $fee->id)->orderBy('fees.id', 'ASC')->get(['fees.id', 'fees.title']);

                                $result.='<tr style="background:transparent">';
                                    $result.= '<td style="margin:0px;padding:0px;padding-right:5px;""><h5><span style="width:100%;" class="badge badge-warning">'.$fee->title.'</span></h5></td>';
                                    $result.= '<td style="margin:0px;padding:0px;padding-right:5px;""><h5><span style="width:100%;" class="badge badge-primary">'.$fee->total_amount.'</span></h5></td>';
                                    $result.= '<td style="margin:0px;padding:0px;padding-right:5px;""><h5>';

                                        foreach($fee_selections as $selection){
                                            $result.='<span style="width:100%;" class="badge badge-danger">'.$selection->title.'</span>';
                                        }
                                    $result.='</h5></td>';

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
                        $button = '<a style="margin-bottom:5px;" href="'.url('admin/students/editsearchedstudent/'.$data->id).'/'.$data->session_id.'/'.$data->class_id.'/'.$data->center_id.'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span>&nbsp;&nbsp;Edit</a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button style="margin-bottom:5px;" type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('students.destroy').'" data-studentid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span>&nbsp;&nbsp;Delete</button>';

                        $semesters = Semester::where('session_id', $data->session_id)->get();

                        foreach($semesters as $semester){
                            $button .= '<a style="margin-bottom:5px;" href="'.url('admin/students/updatefeebysearch/'.$data->id).'/'. $semester->id.'/'.$data->session_id.'/'.$data->class_id.'/'.$data->center_id.'" name="edit" id="'.$data->id.'_'.$semester->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-dollar-sign"></span>&nbsp;&nbsp;'. $semester->title .' Fee</a>';
                        }

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('students.searchstudent')
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
}
