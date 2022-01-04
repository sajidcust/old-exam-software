<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;

class SemestersController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Semesters";
    protected $main_title = "Semesters";
    protected $breadcrumb_title = "Semesters";
    protected $selected_main_menu = "semesters";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "semesters_index";
        $this->card_title = "View and Manage all semesters shown below.";
        if(request()->ajax())
        {
            return datatables()->of(Semester::join('sessions', 'sessions.id', '=', 'semesters.session_id')->select('semesters.id', 'semesters.title', DB::raw('sessions.title as session_title'), 'semesters.division_percentage', 'semesters.created_at', 'semesters.updated_at')->get())
                    ->addColumn('action', function($data){
                        $button = '<a href="'.url('admin/semesters/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span></a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('semesters.destroy').'" data-semesterid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('semesters.index')
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
        $this->selected_sub_menu = "semesters_create";
        $this->card_title = "Please fill in the form to create a new semester.";
        $sessions = Session::all();
        return view('semesters.create')
            ->with('sessions', $sessions)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Semester::$rules);
        if ($validator->passes()) {
            $semester = new Semester;
            $semester->title = $request->input('title');
            $semester->session_id = $request->input('session_id');
            $semester->division_percentage = $request->input('division_percentage');
            $semester->save();

            return Redirect::to('admin/semesters/index')
                ->with('message', 'New semester created successfully.');
        } else {
            return Redirect::to('admin/semesters/create')
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
        $this->selected_sub_menu = "semesters_create";
        $this->card_title = "Please fill in the form to update the semester.";

        $semester = Semester::find($id);
        if (!$semester) {
            return Redirect::to('admin/semesters/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        $sessions = Session::all();

        return view('semesters.edit')
            ->with('semester', $semester)
            ->with('sessions', $sessions)
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
        $semester = Semester::find($request->get('semester_id'));
        if($semester){
            $validator = Validator::make($request->all(), Semester::$rules);
            if ($validator->passes()) {
                $semester->title = $request->input('title');
                $semester->session_id = $request->input('session_id');
                $semester->division_percentage = $request->input('division_percentage');
                $semester->save();

                return Redirect::to('admin/semesters/index')
                    ->with('message', 'Semester updated successfully.');
            } else {
                return Redirect::to('admin/semesters/edit/'.$semester->id)
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
        $semester = Semester::find($request->get('id'));

        if($semester){
            try {
                $semester->delete();
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
