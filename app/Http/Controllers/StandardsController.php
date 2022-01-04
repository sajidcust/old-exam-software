<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;

class StandardsController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Classes";
    protected $main_title = "Classes";
    protected $breadcrumb_title = "Classes";
    protected $selected_main_menu = "classes";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "classes_index";
        $this->card_title = "View and Manage all classes shown below.";
        if(request()->ajax())
        {
            return datatables()->of(Standard::select('standards.id', 'standards.name', 'standards.min_subjects', 'standards.min_age', 'standards.created_at', 'standards.updated_at')->get())
                    ->addColumn('action', function($data){
                        $button = '<a href="'.url('admin/classes/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span></a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('classes.destroy').'" data-standardid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('classes.index')
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
        $this->selected_sub_menu = "classes_create";
        $this->card_title = "Please fill in the form to create a new class.";
        return view('classes.create')
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
        $validator = Validator::make($request->all(), Standard::$rules);
        if ($validator->passes()) {
            $standard = new Standard;
            $standard->name = $request->input('name');
            $standard->min_subjects = $request->input('min_subjects');
            $standard->min_age = $request->input('min_age');
            $standard->save();

            return Redirect::to('admin/classes/index')
                ->with('message', 'New class created successfully.');
        } else {
            return Redirect::to('admin/classes/create')
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
        $this->selected_sub_menu = "classes_create";
        $this->card_title = "Please fill in the form to update the class.";

        $standard = Standard::find($id);
        if (!$standard) {
            return Redirect::to('admin/classes/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        return view('classes.edit')
            ->with('standard', $standard)
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
        $standard = Standard::find($request->get('standard_id'));
        if($standard){
            $validator = Validator::make($request->all(), Standard::$rules);
            if ($validator->passes()) {
                $standard->name = $request->input('name');
                $standard->min_subjects = $request->input('min_subjects');
                $standard->min_age = $request->input('min_age');
                $standard->save();

                return Redirect::to('admin/classes/index')
                    ->with('message', 'Class updated successfully.');
            } else {
                return Redirect::to('admin/classes/edit/'.$class->id)
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
        $standard = Standard::find($request->get('id'));

        if($standard){
            try {
                $standard->delete();
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
