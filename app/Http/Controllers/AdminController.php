<?php

namespace App\Http\Controllers;

use App\Models\AcademicQualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;

class AdminController extends Controller
{
    protected $page_title = "Directorate of Education Colleges GB | Admin";
    protected $main_title = "Dashboard";
    protected $breadcrumb_title = "Dashboard";
    protected $selected_main_menu = "admin_dashboard";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //$database = DB::connection()->getPdo();
        //$driver_name = DB::connection()->getDriverName();
        //dd($driver_name);

        //strftime('%d-%m-%Y', s.date_of_birth) AS date_of_birth,
        //(CASE  WHEN s.gender=0 THEN 'Male' ELSE 'Female' END) AS gender,
        //(CASE  WHEN s.student_type=0 THEN 'Regular' ELSE 'Private' END) AS student_type,

        $this->selected_sub_menu = "admin_dashboard";
        $this->card_title = "Admin Dashboard";

        return view('admin.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

}