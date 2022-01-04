<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Session;
use App\Models\Institution;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use PDF;

class FeesController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Fees";
    protected $main_title = "Fees";
    protected $breadcrumb_title = "Fees";
    protected $selected_main_menu = "fees";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "fees_index";
        $this->card_title = "View and Manage all fees shown below.";
        if(request()->ajax())
        {
            return datatables()->of(Fee::select('fees.id', 'fees.title', 'fees.amount', 'fees.created_at', 'fees.updated_at')->get())
                    ->addColumn('action', function($data){
                        $button = '<a href="'.url('admin/fees/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span></a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('fees.destroy').'" data-feeid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('fees.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function generatefeedetailsbyinstitutions(Request $request) {
        $this->selected_sub_menu = "fees_details";
        $this->card_title = "View and print fee details.";

        $session_id = $request->input('session_id');

        if(request()->ajax())
        {
            return datatables()->of(DB::select(DB::raw("
                SELECT
                    i.id,
                    i.name,
                    t.name as tehsil_name
                    FROM institutions as i
                    JOIN tehsils as t
                    ON t.id = i.tehsil_id
                    WHERE i.is_center = 1;
                    ")))
                    ->addColumn('action', function($data) use ($session_id){
                        $button = '<a style="margin-bottom:5px;" href="'.url('admin/fees/downloadfeereport/'.$data->id.'/'.$session_id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span>&nbsp;&nbsp;Generate Fee Report</a>';

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('fees.feedetails')
            ->with('session_id', $session_id)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);

    }

    public function downloadcompletefeereport($id){
        if($id){

            $session = Session::find($id);

            $institutions = Student::join('students_fees', 'students_fees.student_id', '=', 'students.id')->join('institutions', 'institutions.id', '=', 'students.institution_id')->where('students.session_id', $id)->groupBy('institutions.id')->get(['institutions.id', 'institutions.name', DB::raw('SUM(students_fees.total_amount) AS total_amount')]);

            $data = [
                'session'    => $session,
                'institutions'=> $institutions,
            ];

            ini_set('max_execution_time', 5000);
            ini_set('memory_limit', '-1');

            $pdf = PDF::loadView('fees.downloadcompletefeereport', $data);

            return $pdf->download('complete_fee_report-'.$session->id.'-'.$session->title.'.pdf');
        }
    }

    public function downloadfeereport($id, $session_id){

        if($id && $session_id){

            $session = Session::find($session_id);
            $institution = Institution::find($id);

            if(DB::connection()->getDriverName() == 'mysql') {
                $date_of_deposit = "DATE_FORMAT(students_fees.date_of_deposit, '%d-%m-%Y') AS date_of_deposit";
            }

            if(DB::connection()->getDriverName() == 'sqlite') {
                $date_of_deposit = "strftime('%d-%m-%Y', students_fees.date_of_deposit) AS date_of_deposit";
            }

            $students = Student::join('students_fees', 'students_fees.student_id', '=', 'students.id')->join('banks', 'banks.id', '=', 'students_fees.bank_id')->where('students.session_id', $session_id)->where('students.institution_id', $id)->get(['students.id', 'students.name', DB::raw('banks.name AS bank_name'), 'students_fees.semester_id', 'students_fees.challan_no', DB::raw($date_of_deposit), 'students_fees.total_amount']);

            $data = [
                'session'    => $session,
                'institution'=> $institution,
                'students'   => $students
            ];

            $pdf = PDF::loadView('fees.downloadfeereportbyinstitution', $data);

            return $pdf->download('fee_report-'.$session_id.'-'.$session->title.'-'.$institution->id.'-'.$institution->name.'.pdf');
        }
    }

    public function generatefeedetails(){
        $this->selected_sub_menu = "fees_details";
        $this->card_title = "Select session to generate fee details.";

        $sessions = Session::all();

        return view('fees.generatefeedetails')
            ->with('sessions', $sessions)
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
        $this->selected_sub_menu = "fees_create";
        $this->card_title = "Please fill in the form to create a new fee.";
      
        return view('fees.create')
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
        $validator = Validator::make($request->all(), Fee::$rules);
        if ($validator->passes()) {
            $fee = new Fee;
            $fee->title = $request->input('title');
            $fee->amount = $request->input('amount');
            $fee->save();

            return Redirect::to('admin/fees/index')
                ->with('message', 'New fee created successfully.');
        } else {
            return Redirect::to('admin/fees/create')
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
        $this->selected_sub_menu = "fees_create";
        $this->card_title = "Please fill in the form to update the fee.";

        $fee = Fee::find($id);
        if (!$fee) {
            return Redirect::to('admin/fees/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        return view('fees.edit')
            ->with('fee', $fee)
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
        $fee = Fee::find($request->get('fee_id'));
        if($fee){
            $validator = Validator::make($request->all(), Fee::$rules);
            if ($validator->passes()) {
                $fee->title = $request->input('title');
                $fee->amount = $request->input('amount');
                $fee->save();

                return Redirect::to('admin/fees/index')
                    ->with('message', 'Fee updated successfully.');
            } else {
                return Redirect::to('admin/fees/edit/'.$fee->id)
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
        $fee = Fee::find($request->get('id'));

        if($fee){
            try {
                $fee->delete();
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
