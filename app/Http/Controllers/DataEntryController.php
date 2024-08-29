<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataEntryController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Dashboard";
    protected $main_title = "Dashboard";
    protected $breadcrumb_title = "Dashboard";
    protected $selected_main_menu = "data_entry_dashboard";
    protected $card_title;
    protected $selected_sub_menu;

    public function index() {
    	$this->selected_sub_menu = "admin_dashboard";
        $this->card_title = "Datentry Dashboard";

        return view('admin.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }
}
