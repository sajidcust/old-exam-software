<?php

namespace App\Http\Controllers;

use App\Models\Datesheet;
use App\Models\Session;
use App\Models\Subject;
use App\Models\Standard;
use App\Models\Semester;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\StudentsFeesSelection;
use App\Models\StudentsFee;

use DB;
use Faker;
use PDF;
use Config;


class DatesheetsController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Datesheets";
    protected $main_title = "Datesheets";
    protected $breadcrumb_title = "Datesheets";
    protected $selected_main_menu = "datesheets";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "datesheets_index";
        $this->card_title = "View and Manage all datesheets shown below.";

        if(DB::connection()->getDriverName() == 'mysql') {
            $paper_date = "DATE_FORMAT(d.paper_date, '%d-%m-%Y') AS paper_date,";
            $paper_starting_time = "DATE_FORMAT(d.paper_starting_time, '%h:%i:%s %p') AS paper_starting_time,";
            $paper_ending_time = "DATE_FORMAT(d.paper_ending_time, '%h:%i:%s %p') AS paper_ending_time,";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $paper_date = "strftime('%d-%m-%Y', d.paper_date) AS paper_date,";
            $paper_starting_time = "strftime('%H:%M:%S', d.paper_starting_time) AS paper_starting_time,";
            $paper_ending_time = "strftime('%H:%M:%S', d.paper_ending_time) AS paper_ending_time,";
        }


        if(request()->ajax())
        {
            return datatables()->of(DB::select(DB::raw("
                        SELECT 
                            d.id,
                            s.title,
                            sem.title AS semester_title,
                            sub.name,
                            std.name AS class,
                            ". $paper_date.$paper_starting_time.$paper_ending_time ."
                            d.created_at, 
                            d.updated_at 
                        FROM datesheets d 
                        JOIN subjects sub 
                        ON d.subject_id = sub.id
                        JOIN standards as std
                        ON d.class_id = std.id
                        JOIN sessions as s
                        ON s.id = d.session_id
                        JOIN semesters as sem
                        ON sem.id = d.semester_id;
                        ")))
                    ->addColumn('action', function($data){
                        $button = '<a href="'.url('admin/datesheets/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span></a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('datesheets.destroy').'" data-datesheetid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('datesheets.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->selected_sub_menu = "datesheets_create";
        $this->card_title = "Please fill in the form to create a new datesheet.";
        $sessions = Session::all();
        $subjects = Subject::all();
        $standards = Standard::all();
        //$semesters = Semester::all();
        return view('datesheets.create')
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*echo $request->input('paper_starting_time')."<br>";
        echo date('h:i A', strtotime($request->input('paper_starting_time')));
        exit;*/

        $validator = Validator::make($request->all(), Datesheet::$rules);
        if ($validator->passes()) {
            $datesheet = new Datesheet;
            $datesheet->session_id = $request->input('session_id');
            $datesheet->semester_id = $request->input('semester_id');
            $datesheet->subject_id = $request->input('subject_id');
            $datesheet->paper_date = date('Y-m-d', strtotime($request->input('paper_date')));
            $datesheet->paper_starting_time = date('Y-m-d h:i:s A', strtotime($request->input('paper_starting_time')));
            $datesheet->paper_ending_time = date('Y-m-d h:i:s A', strtotime($request->input('paper_ending_time')));
            $datesheet->class_id = $request->input('class_id');
            
            try {
                $datesheet->save();
            } catch (\Illuminate\Database\QueryException $e) {
                //var_dump($e->errorInfo);
                if($e->getCode()==23000) {
                    return Redirect::to('admin/datesheets/index')
                        ->with('message', 'Integrity Constraint Violation!. A same record already exists. Please verify and try again later.');
                } else {
                    return Redirect::to('admin/datesheets/index')
                        ->with('message', 'Something Went Wrong!');
                }
            }

            return Redirect::to('admin/datesheets/index')
                ->with('message', 'New datesheet created successfully.');
        } else {
            return Redirect::to('admin/datesheets/create')
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

    public function printdatesheets(){
        $this->selected_sub_menu = "print_datesheets";
        $this->card_title = "Download datesheets";

        $sessions = Session::all();
        $standards = Standard::all();

        return view('datesheets.printdatesheets')
            ->with('sessions', $sessions)
            ->with('standards', $standards)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function downloaddatesheet(Request $request){
        $session_id = $request->input('session_id');
        $class_id = $request->input('class_id');
        $semester_id = $request->input('semester_id');

        if($session_id && $class_id && $semester_id){
            $session = Session::find($session_id);
            $standard = Standard::find($class_id);
            $semester = Semester::find($semester_id);

            $subjects = DB::select(DB::raw('
                        SELECT
                            sub.id,
                            sub.name AS subject_name,
                            DATE_FORMAT(d.paper_date, "%W, %d %M %Y") AS paper_date,
                            DATE_FORMAT(d.paper_starting_time, "%h:%i %p") AS paper_starting_time,
                            DATE_FORMAT(d.paper_ending_time, "%h:%i %p") AS paper_ending_time
                        FROM datesheets as d
                        JOIN subjects as sub
                        ON sub.id = d.subject_id
                        WHERE d.session_id = :session_id
                        AND d.class_id = :class_id
                        AND d.semester_id = :semester_id;
                    '), array('session_id' => $session->id, 'class_id' => $standard->id, 'semester_id' => $semester->id));

        $data = [
            'session'   => $session,
            'standard'  => $standard,
            'semester'  => $semester,
            'subjects'  => $subjects,
            'setting'   => Setting::find(1)
        ];

        $pdf = PDF::loadView('datesheets.downloaddatesheet', $data);

        return $pdf->download('date-sheet-'.$session_id.'-'.$session->title.'-'.$semester_id.'-'.$semester->title.'-'.$standard->id.'-'.$standard->name.'.pdf');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->selected_sub_menu = "datesheets_create";
        $this->card_title = "Please fill in the form to update the institution.";

        $datesheet = Datesheet::find($id);
        $sessions = Session::all();
        $subjects = Subject::all();
        $standards = Standard::all();
        $semesters = Semester::where('session_id', $datesheet->session_id)->get();

        if (!$datesheet) {
            return Redirect::to('admin/datesheets/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        return view('datesheets.edit')
            ->with('datesheet', $datesheet)
            ->with('sessions', $sessions)
            ->with('subjects', $subjects)
            ->with('standards', $standards)
            ->with('semesters', $semesters)
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
        $datesheet = Datesheet::find($request->input('datesheet_id'));
        if($datesheet){
            $validator = Validator::make($request->all(), Datesheet::$rules);
            if ($validator->passes()) {
                $datesheet->session_id = $request->input('session_id');
                $datesheet->semester_id = $request->input('semester_id');
                $datesheet->subject_id = $request->input('subject_id');
                $datesheet->paper_date = date('Y-m-d', strtotime($request->input('paper_date')));
                $datesheet->paper_starting_time = date('Y-m-d h:i:s A', strtotime($request->input('paper_starting_time')));
                $datesheet->paper_ending_time = date('Y-m-d h:i:s A', strtotime($request->input('paper_ending_time')));
                $datesheet->class_id = $request->input('class_id');

                try {
                    $datesheet->save();
                } catch (\Illuminate\Database\QueryException $e) {
                    //var_dump($e->errorInfo);
                    if($e->getCode()==23000) {
                        return Redirect::to('admin/datesheets/index')
                            ->with('message', 'Integrity Constraint Violation!. A same record already exists. Please verify and try again later.');
                    } else {
                        return Redirect::to('admin/datesheets/index')
                            ->with('message', 'Something Went Wrong!');
                    }
                }

                return Redirect::to('admin/datesheets/index')
                    ->with('message', 'Datesheet updated successfully.');
            } else {
                return Redirect::to('admin/datesheets/edit/'.$datesheet->id)
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
        $datesheet = Datesheet::find($request->get('id'));

        if($datesheet){
            try {
                $datesheet->delete();
                return response()->json(['success'=>'true', 'message'=>'Success! Your request has been completed successfully.']);

            } catch (\Illuminate\Database\QueryException $e) {
                //var_dump($e->errorInfo);
                if($e->getCode()==23000) {
                    return response()->json(['success'=>'false', 'message'=>'<b>Integrity Constraint Violation!</b><br>You must delete child records first then you should delete this item to ensure referential integrity.']);
                } else {
                    return response()->json(['success'=>'false', 'message'=>'Something Went Wrong! Please Try Again Later.']);
                }
            }
        }

        return response()->json(['success'=>'false', 'message'=>'Something went wrong. Please try again later']);
    }
}
