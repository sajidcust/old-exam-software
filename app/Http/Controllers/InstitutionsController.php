<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\Tehsil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;

class InstitutionsController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Institutions";
    protected $main_title = "Institutions";
    protected $breadcrumb_title = "Institutions";
    protected $selected_main_menu = "institutions";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "institutions_index";
        $this->card_title = "View and Manage all institutions shown below.";


        if(request()->ajax())
        {
            return datatables()->of(DB::select(DB::raw("
                        SELECT 
                            i2.id, 
                            i2.name, 
                            (CASE  WHEN i2.is_ddo=1 THEN 'Yes' ELSE 'No' END) AS is_ddo,
                            (CASE  WHEN i2.is_center=1 THEN 'Yes' ELSE 'No' END) AS is_center, 
                            (CASE  WHEN i1.name IS NULL THEN i2.name ELSE i1.name END) AS ddo_name,
                            t.name as tehsil_name,
                            i2.created_at, 
                            i2.updated_at 
                        FROM institutions i1 
                        RIGHT JOIN institutions i2 
                        ON i2.ddo_id = i1.id
                        JOIN tehsils as t
                        ON t.id = i2.tehsil_id;")))
                    ->addColumn('action', function($data){
                        $button = '<a href="'.url('admin/institutions/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span></a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('institutions.destroy').'" data-institutionid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('institutions.index')
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
        $this->selected_sub_menu = "institutions_create";
        $this->card_title = "Please fill in the form to create a new institution.";
        $institutions = Institution::all();
        $tehsils = Tehsil::all();
        return view('institutions.create')
            ->with('institutions', $institutions)
            ->with('tehsils', $tehsils)
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
        $validator = Validator::make($request->all(), Institution::$rules);
        if ($validator->passes()) {
            $institution = new Institution;
            $institution->name = $request->input('name');
            $institution->is_ddo = $request->input('is_ddo');
            $institution->is_center = $request->input('is_center');
            $institution->ddo_id = $request->input('ddo_id');
            $institution->tehsil_id = $request->input('tehsil_id');
            $institution->save();

            return Redirect::to('admin/institutions/index')
                ->with('message', 'New institution created successfully.');
        } else {
            return Redirect::to('admin/institutions/create')
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
        $this->selected_sub_menu = "institutions_create";
        $this->card_title = "Please fill in the form to update the institution.";

        $institution = Institution::find($id);
        $institutions = Institution::all();
        if (!$institution) {
            return Redirect::to('admin/institutions/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        $tehsils = Tehsil::all();
        return view('institutions.edit')
            ->with('institution', $institution)
            ->with('institutions', $institutions)
            ->with('tehsils', $tehsils)
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
        $institution = Institution::find($request->input('institution_id'));
        if($institution){
            $validator = Validator::make($request->all(), Institution::$rules);
            if ($validator->passes()) {
                $institution->name = $request->input('name');
                $institution->is_ddo = $request->input('is_ddo');
                $institution->is_center = $request->input('is_center');
                $institution->ddo_id = $request->input('ddo_id');
                $institution->tehsil_id = $request->input('tehsil_id');
                $institution->save();

                return Redirect::to('admin/institutions/index')
                    ->with('message', 'Institution updated successfully.');
            } else {
                return Redirect::to('admin/institutions/edit/'.$institution->id)
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
        $institution = Institution::find($request->get('id'));

        if($institution){
            try {
                $institution->delete();
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
