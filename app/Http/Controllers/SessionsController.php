<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;

class SessionsController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Sessions";
    protected $main_title = "Sessions";
    protected $breadcrumb_title = "Sessions";
    protected $selected_main_menu = "sessions";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "sessions_index";
        $this->card_title = "View and Manage all sessions shown below.";

        if(DB::connection()->getDriverName() == 'mysql') {
            $expiry_date = "DATE_FORMAT(sessions.expiry_date, '%d-%m-%Y') AS expiry_date";
            $result_declaration_date = "DATE_FORMAT(sessions.result_declaration_date, '%d-%m-%Y') AS result_declaration_date";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $expiry_date = "strftime('%d-%m-%Y', sessions.expiry_date) AS expiry_date";
            $result_declaration_date = "strftime('%d-%m-%Y', sessions.result_declaration_date) AS result_declaration_date";
        }

        if(request()->ajax())
        {
            return datatables()->of(Session::select('sessions.id', 'sessions.title', 'sessions.year', DB::raw($expiry_date), DB::raw($result_declaration_date), DB::raw("(CASE  WHEN sessions.is_active=0 THEN 'NO' ELSE 'YES' END) AS is_active"), 'sessions.created_at', 'sessions.updated_at')->get())
                    ->addColumn('action', function($data){
                        $button = '<a href="'.url('admin/sessions/edit/'.$data->id).'" name="edit" id="'.$data->id.'" class="btn btn-success margin-2px btn-sm"><span class="fa fa-edit"></span></a>';
                        $button .='&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('sessions.destroy').'" data-sessionid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('sessions.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function activesessions(Request $request){
        $count_previous_actives = Session::where('is_active', 1)->count();

        if($count_previous_actives == 0){
            return 1;
        }

        return 0;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->selected_sub_menu = "sessions_create";
        $this->card_title = "Please fill in the form to create a new session.";
        return view('sessions.create')
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
        $validator = Validator::make($request->all(), Session::$rules);
        if ($validator->passes()) {
            $session = new Session;
            $session->title = $request->input('title');
            $session->year = $request->input('year');
            $session->expiry_date = date('Y-m-d', strtotime($request->input('expiry_date')));
            $session->result_declaration_date = date('Y-m-d', strtotime($request->input('result_declaration_date')));
            $session->is_active = $request->input('is_active');
            $session->save();

            return Redirect::to('admin/sessions/index')
                ->with('message', 'New session created successfully.');
        } else {
            return Redirect::to('admin/sessions/create')
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
        $this->selected_sub_menu = "sessions_create";
        $this->card_title = "Please fill in the form to update the session.";

        $session = Session::find($id);
        if (!$session) {
            return Redirect::to('admin/sessions/index')
                ->with('error', 'Something went wrong! Please try again later.');
        }

        return view('sessions.edit')
            ->with('session', $session)
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
        $session = Session::find($request->get('session_id'));
        if($session){
            $validator = Validator::make($request->all(), Session::$rules);
            if ($validator->passes()) {
                $session->title = $request->input('title');
                $session->year = $request->input('year');
                $session->expiry_date = date('Y-m-d', strtotime($request->input('expiry_date')));
                $session->result_declaration_date = date('Y-m-d', strtotime($request->input('result_declaration_date')));
                $session->is_active = $request->input('is_active');
                $session->save();

                return Redirect::to('admin/sessions/index')
                    ->with('message', 'Session updated successfully.');
            } else {
                return Redirect::to('admin/sessions/edit/'.$session->id)
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
        $session = Session::find($request->get('id'));

        if($session){
            try {
                $session->delete();
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
