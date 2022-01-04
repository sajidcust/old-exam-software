<?php

namespace App\Http\Controllers;

use App\Models\Tehsil;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;

class TehsilsController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Tehsils";
    protected $main_title = "Tehsils";
    protected $breadcrumb_title = "Tehsils";
    protected $selected_main_menu = "tehsils";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "tehsils_index";
        $this->card_title = "View and Manage all tehsils shown below.";
        if(request()->ajax())
        {
            return datatables()->of(Tehsil::join('districts', 'districts.id', '=', 'tehsils.district_id')->select('tehsils.id', 'tehsils.name', DB::raw('districts.name as district_name'), 'tehsils.created_at', 'tehsils.updated_at')->get())
                    ->addColumn('action', function($data){
                        $button = '<a href="'.url('admin/tehsils/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span></a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('tehsils.destroy').'" data-tehsilid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('tehsils.index')
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
        $this->selected_sub_menu = "tehsils_create";
        $this->card_title = "Please fill in the form to create a new tehsil.";
        $districts = District::all();
        return view('tehsils.create')
            ->with('districts', $districts)
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
        $validator = Validator::make($request->all(), Tehsil::$rules);
        if ($validator->passes()) {
            $tehsil = new Tehsil;
            $tehsil->name = $request->input('name');
            $tehsil->district_id = $request->input('district_id');
            $tehsil->save();

            return Redirect::to('admin/tehsils/index')
                ->with('message', 'New tehsil created successfully.');
        } else {
            return Redirect::to('admin/tehsils/create')
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
        $this->selected_sub_menu = "tehsils_create";
        $this->card_title = "Please fill in the form to update the tehsil.";

        $tehsil = Tehsil::find($id);
        if (!$tehsil) {
            return Redirect::to('admin/tehsils/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        $districts = District::all();

        return view('tehsils.edit')
            ->with('tehsil', $tehsil)
            ->with('districts', $districts)
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
        $tehsil = Tehsil::find($request->get('tehsil_id'));
        if($tehsil){
            $validator = Validator::make($request->all(), Tehsil::$rules);
            if ($validator->passes()) {
                $tehsil->name = $request->input('name');
                $tehsil->district_id = $request->input('district_id');
                $tehsil->save();

                return Redirect::to('admin/tehsils/index')
                    ->with('message', 'Tehsil updated successfully.');
            } else {
                return Redirect::to('admin/tehsils/edit/'.$tehsil->id)
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
        $tehsil = Tehsil::find($request->get('id'));

        if($tehsil){
            try {
                $tehsil->delete();
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
