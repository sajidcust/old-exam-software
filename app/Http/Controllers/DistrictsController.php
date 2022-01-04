<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;


class DistrictsController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Districts";
    protected $main_title = "Districts";
    protected $breadcrumb_title = "Districts";
    protected $selected_main_menu = "districts";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "districts_index";
        $this->card_title = "View and Manage all districts shown below.";
        if(request()->ajax())
        {
            return datatables()->of(District::select('districts.id', 'districts.name', 'districts.created_at', 'districts.updated_at')->get())
                    ->addColumn('action', function($data){
                        $button = '<a href="'.url('admin/districts/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span></a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('districts.destroy').'" data-districtid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('districts.index')
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
        $this->selected_sub_menu = "districts_create";
        $this->card_title = "Please fill in the form to create a new district.";
        return view('districts.create')
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
        $validator = Validator::make($request->all(), District::$rules);
        if ($validator->passes()) {
            $district = new District;
            $district->name = $request->input('name');
            $district->save();

            return Redirect::to('admin/districts/index')
                ->with('message', 'New district created successfully.');
        } else {
            return Redirect::to('admin/districts/create')
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
        $this->selected_sub_menu = "districts_create";
        $this->card_title = "Please fill in the form to update the district.";

        $district = District::find($id);
        if (!$district) {
            return Redirect::to('admin/districts/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        return view('districts.edit')
            ->with('district', $district)
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
        $district = District::find($request->get('district_id'));
        if($district){
            $validator = Validator::make($request->all(), District::$rules);
            if ($validator->passes()) {
                $district->name = $request->input('name');
                $district->save();

                return Redirect::to('admin/districts/index')
                    ->with('message', 'District updated successfully.');
            } else {
                return Redirect::to('admin/districts/edit/'.$district->id)
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
        $district = District::find($request->get('id'));

        if($district){
            try {
                $district->delete();
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
