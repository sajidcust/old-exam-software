<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\SubjectsGroup;
use App\Models\Subject;
use App\Models\Standard;
use DB;

class SubjectGroupsController extends Controller
{
	protected $page_title = "Directorate of Education Colleges GB | Subject Groups";
    protected $main_title = "Dashboard";
    protected $breadcrumb_title = "Dashboard";
    protected $selected_main_menu = "subject_groups";
    protected $card_title;
    protected $selected_sub_menu;


    public function index(){
    	$this->selected_sub_menu = "subject_groups_index";
        $this->card_title = "View and Manage all subject groups shown below.";


        if(request()->ajax())
        {
            return datatables()->of(DB::select(DB::raw("
                        SELECT
                            sg.id,
                            s.id as class_id,
                            s.name as class_name,
                            sub.name as subject_name,
                            sg.created_at,
                            sg.updated_at
                        FROM subjects_groups AS sg
                        JOIN standards AS s
                        ON sg.class_id = s.id
                        JOIN subjects AS sub
                        ON sub.id = sg.subject_id;")))
                    ->addColumn('action', function($data){
                        $button = '<a style="margin-bottom:5px;" href="'.url('admin/subjectgroups/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span>&nbsp;&nbsp;Edit</a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button style="margin-bottom:5px;" type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('subjectgroups.destroy').'" data-subjectgroupid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span>&nbsp;&nbsp;Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('subjectsgroups.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function create()
    {
        $this->selected_sub_menu = "subject_groups_create";
        $this->card_title = "Please fill in the form to create a new subject group.";

        $subjects = Subject::all();
        $standards = Standard::all();
        return view('subjectsgroups.create')
            ->with('subjects', $subjects)
            ->with('standards', $standards)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), SubjectsGroup::$rules);
        if ($validator->passes()) {
            $subjectgroup = new SubjectsGroup;
            $subjectgroup->class_id = $request->input('class_id');
            $subjectgroup->subject_id = $request->input('subject_id');
            
            try {
                $subjectgroup->save();
            } catch (\Illuminate\Database\QueryException $e) {
                //var_dump($e->errorInfo);
                if($e->getCode()==23000) {
                    return Redirect::to('admin/subjectgroups/index')
                        ->with('message', 'Integrity Constraint Violation!. A same record already exists. Please verify and try again later.');
                } else {
                    return Redirect::to('admin/subjectgroups/index')
                        ->with('message', 'Something Went Wrong!');
                }
            }

            return Redirect::to('admin/subjectgroups/index')
                ->with('message', 'New subject group created successfully.');
        } else {
            return Redirect::to('admin/subjectgroups/create')
                ->withErrors($validator)
                ->withInput($request->all());      
        }
    }

    public function edit($id) {
    	$this->selected_sub_menu = "subject_groups_create";
        $this->card_title = "Please fill in the form to update the subject group.";

        $subjectgroup = SubjectsGroup::find($id);
        if (!$subjectgroup) {
            return Redirect::to('admin/subjectgroups/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        $standards = Standard::all();
        $subjects = Subject::all();

        return view('subjectsgroups.edit')
            ->with('subjectgroup', $subjectgroup)
            ->with('standards', $standards)
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
        $subjectgroup = SubjectsGroup::find($request->get('subject_group_id'));
        if($subjectgroup){
            $validator = Validator::make($request->all(), SubjectsGroup::$rules);
            if ($validator->passes()) {
                $subjectgroup->class_id = $request->input('class_id');
                $subjectgroup->subject_id = $request->input('subject_id');

                try {
	                $subjectgroup->save();
	            } catch (\Illuminate\Database\QueryException $e) {
	                //var_dump($e->errorInfo);
	                if($e->getCode()==23000) {
	                    return Redirect::to('admin/subjectgroups/index')
	                        ->with('message', 'Integrity Constraint Violation!. A same record already exists. Please verify and try again later.');
	                } else {
	                    return Redirect::to('admin/subjectgroups/index')
	                        ->with('message', 'Something Went Wrong!');
	                }
	            }

                return Redirect::to('admin/subjectgroups/index')
                    ->with('message', 'Subject group updated successfully.');
            } else {
                return Redirect::to('admin/subjectgroups/edit/'.$subjectgroup->id)
                    ->withErrors($validator)
                    ->withInput($request->all());      
            }
        }
    }

    public function destroy(Request $request)
    {
        $subjectsgroup = SubjectsGroup::find($request->get('id'));

        if($subjectsgroup){
            try {
                $subjectsgroup->delete();
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
