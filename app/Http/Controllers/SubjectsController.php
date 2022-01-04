<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;

class SubjectsController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Subjects";
    protected $main_title = "Subjects";
    protected $breadcrumb_title = "Subjects";
    protected $selected_main_menu = "subjects";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "subjects_index";
        $this->card_title = "View and Manage all subjects shown below.";


        if(request()->ajax())
        {
            return datatables()->of(DB::select(DB::raw("
                        SELECT 
                            s.id, 
                            s.name,
                            s.short_name, 
                            (CASE  WHEN s.is_optional=1 THEN 'Yes' ELSE 'No' END) AS is_optional,
                            (CASE  WHEN s.has_practical=1 THEN 'Yes' ELSE 'No' END) AS has_practical, 
                            s.created_at, 
                            s.updated_at 
                        FROM subjects s;")))
                    ->addColumn('action', function($data){
                        $button = '<a href="'.url('admin/subjects/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span></a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('subjects.destroy').'" data-subjectid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('subjects.index')
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
        $this->selected_sub_menu = "subjects_create";
        $this->card_title = "Please fill in the form to create a new subjects.";
        return view('subjects.create')
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
        $validator = Validator::make($request->all(), Subject::$rules);
        if ($validator->passes()) {
            $subject = new Subject;
            $subject->name = $request->input('name');
            $subject->short_name = $request->input('short_name');
            $subject->is_optional = $request->input('is_optional');
            $subject->has_practical = $request->input('has_practical');
            $subject->save();

            return Redirect::to('admin/subjects/index')
                ->with('message', 'New subject created successfully.');
        } else {
            return Redirect::to('admin/subjects/create')
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
        $this->selected_sub_menu = "subjects_create";
        $this->card_title = "Please fill in the form to update the subject.";

        $subject = Subject::find($id);
        if (!$subject) {
            return Redirect::to('admin/subjects/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        return view('subjects.edit')
            ->with('subject', $subject)
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
        $subject = Subject::find($request->input('subject_id'));
        if($subject){
            $validator = Validator::make($request->all(), Subject::$rules);
            if ($validator->passes()) {
                $subject->name = $request->input('name');
                $subject->short_name = $request->input('short_name');
                $subject->is_optional = $request->input('is_optional');
                $subject->has_practical = $request->input('has_practical');
                $subject->save();

                return Redirect::to('admin/subjects/index')
                    ->with('message', 'Subject updated successfully.');
            } else {
                return Redirect::to('admin/subjects/edit/'.$institution->id)
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
        $subject = Subject::find($request->get('id'));

        if($subject){
            try {
                $subject->delete();
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
