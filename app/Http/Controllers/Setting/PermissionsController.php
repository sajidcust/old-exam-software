<?php

namespace App\Http\Controllers\Setting;

use App\Models\Designation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreDesignationsRequest;

class PermissionsController extends Controller
{
	protected $page_title         = "Board of Elementary Examination, GB | User Permissions";
	protected $main_title         = "User Permissions";
	protected $breadcrumb_title   = "User Permissions";
	protected $selected_main_menu = "permissions";
	protected $card_title;
	protected $selected_sub_menu;

	public function index()
	{
		$this->selected_sub_menu = "permissions_index";
		$this->card_title        = "View and Manage all user permissions shown below.";


		$models = Permission::all();

		return view('backend.settings.permissions.index', compact('models'))->with('main_title', $this->main_title)
		                                                                    ->with('selected_main_menu', $this->selected_main_menu)
		                                                                    ->with('breadcrumb_title', $this->breadcrumb_title)
		                                                                    ->with('card_title', $this->card_title)
		                                                                    ->with('selected_sub_menu', $this->selected_sub_menu)
		                                                                    ->with('page_title', $this->page_title);
	}

	public function create()
	{
		$this->selected_sub_menu = "permissions_create";

		return view('backend.settings.permissions.create')->with('main_title', $this->main_title)
		                                                  ->with('selected_main_menu', $this->selected_main_menu)
		                                                  ->with('breadcrumb_title', $this->breadcrumb_title)
		                                                  ->with('card_title', $this->card_title)
		                                                  ->with('selected_sub_menu', $this->selected_sub_menu)
		                                                  ->with('page_title', $this->page_title);
	}

	public function store( Request $request )
	{
		$validated = $request->validate([ 'name' => [ 'required', 'min:3' ] ]);

		Permission::create($validated);

		return back()
			->with('message', 'New user permission created successfully.');
	}

	public function show( $id )
	{
		//
	}

	public function edit( $id )
	{
		$this->selected_sub_menu = "permissions_edit";

		$model = Permission::find($id);

		return view('backend.settings.permissions.edit', compact('model'))->with('main_title', $this->main_title)
		                                                                  ->with('selected_main_menu', $this->selected_main_menu)
		                                                                  ->with('breadcrumb_title', $this->breadcrumb_title)
		                                                                  ->with('card_title', $this->card_title)
		                                                                  ->with('selected_sub_menu', $this->selected_sub_menu)
		                                                                  ->with('page_title', $this->page_title);
	}

	public function update( Request $request, $id )
	{
		$model = Permission::find($id);

		$model->name = $request->name;

		$model->save();

		return back()
			->with('message', 'User permission updated successfully.');
	}

	public function destroy( $id )
	{
		//
	}
}
