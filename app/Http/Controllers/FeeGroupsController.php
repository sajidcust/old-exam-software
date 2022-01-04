<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\FeeGroupFee;
use App\Models\FeeGroup;
use App\Models\Standard;
use App\Models\Fee;

use DB;

class FeeGroupsController extends Controller
{
    protected $page_title = "Directorate of Education Colleges GB | Fee Groups";
    protected $main_title = "Dashboard";
    protected $breadcrumb_title = "Dashboard";
    protected $selected_main_menu = "fees_groups";
    protected $card_title;
    protected $selected_sub_menu;


    public function index(){
    	$this->selected_sub_menu = "fees_groups_index";
        $this->card_title = "View and Manage all fee groups shown below.";


        if(request()->ajax())
        {
            return datatables()->of(DB::select(DB::raw("
                        SELECT
                            fg.id,
                            fg.fee_group_name,
                            s.id as class_id,
                            s.name as class_name,
                            fg.created_at,
                            fg.updated_at
                        FROM fee_groups AS fg
                        JOIN standards AS s
                        ON fg.class_id = s.id;")))
            		->addColumn('fees', function($data){
                        $result = "";
                        $fee_groups = FeeGroupFee::join('fees', 'fees.id', '=', 'fee_group_fees.fee_id')->where('fee_group_fees.fee_group_id', $data->id)->get(['fees.id', 'fees.title']);
                        foreach($fee_groups as $fg){
                        	$result .= '<h5><span class="badge badge-primary">'. $fg->title .'</span></h5>';
                        }
                        return $result;
                    })
                    ->addColumn('action', function($data){
                        $button = '<a style="margin-bottom:5px;" href="'.url('admin/feegroups/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span>&nbsp;&nbsp;Edit</a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button style="margin-bottom:5px;" type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('feegroups.destroy').'" data-feegroupid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span>&nbsp;&nbsp;Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('feesgroups.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function create()
    {
        $this->selected_sub_menu = "fee_groups_create";
        $this->card_title = "Please fill in the form to create a new fee group.";

        $fees = Fee::all();
        $standards = Standard::all();
        return view('feesgroups.create')
            ->with('fees', $fees)
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

        $validator = Validator::make($request->all(), FeeGroup::$rules);
        if ($validator->passes()) {
            $feegroup = new FeeGroup;
            $feegroup->fee_group_name = $request->input('fee_group_name');
            $feegroup->class_id = $request->input('class_id');
            $feegroup->save();

            $fee_ids = $request->input('fee_id');

            foreach($fee_ids as $fee_id) {
            	$fee_group_fee = new FeeGroupFee;
            	$fee_group_fee->fee_group_id = $feegroup->id;
            	$fee_group_fee->fee_id = $fee_id;
            	$fee_group_fee->save();
            }

            return Redirect::to('admin/feegroups/index')
                ->with('message', 'New fee group created successfully.');
        } else {
            return Redirect::to('admin/feegroups/create')
                ->withErrors($validator)
                ->withInput($request->all());      
        }
    }

    public function edit($id) {
    	$this->selected_sub_menu = "fee_groups_create";
        $this->card_title = "Please fill in the form to update the fee group.";

        $feegroup = FeeGroup::find($id);
        if (!$feegroup) {
            return Redirect::to('admin/feegroups/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        $standards = Standard::all();
        $fees = Fee::all();

        $selected_fees = FeeGroupFee::where('fee_group_id', $id)->get();
		$fee_ids = array();
		$i = 0;
		foreach($selected_fees as $fee) {
			$fee_ids[$i] = $fee->fee_id;
			$i++;
		}

        return view('feesgroups.edit')
            ->with('feegroup', $feegroup)
            ->with('standards', $standards)
            ->with('fees', $fees)
            ->with('selected_fee', $fee_ids)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function update(Request $request)
    {	
        $feegroup = FeeGroup::find($request->get('fee_group_id'));
        if($feegroup){
            $validator = Validator::make($request->all(), FeeGroup::$rules);
            if ($validator->passes()) {
                $feegroup->fee_group_name = $request->input('fee_group_name');
	            $feegroup->class_id = $request->input('class_id');
	            $feegroup->save();

	            $fee_ids = $request->input('fee_id');
	            FeeGroupFee::where('fee_group_id', $feegroup->id)->delete();

	            foreach($fee_ids as $fee_id) {
	            	$fee_group_fee = new FeeGroupFee;
	            	$fee_group_fee->fee_group_id = $feegroup->id;
	            	$fee_group_fee->fee_id = $fee_id;
	            	$fee_group_fee->save();
	            }

                return Redirect::to('admin/feegroups/index')
                    ->with('message', 'Fee group updated successfully.');
            } else {
                return Redirect::to('admin/feegroups/edit/'.$feegroup->id)
                    ->withErrors($validator)
                    ->withInput($request->all());      
            }
        }
    }

    public function destroy(Request $request)
    {
        $feegroup = FeeGroup::find($request->get('id'));

        if($feegroup){
            try {
            	FeeGroupFee::where('fee_group_id', $feegroup->id)->delete();
                $feegroup->delete();
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
