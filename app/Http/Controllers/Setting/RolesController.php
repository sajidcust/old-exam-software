<?php

namespace App\Http\Controllers\Setting;

use App\Models\Designation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreDesignationsRequest;

class RolesController extends Controller
{
	protected $page_title         = "Board of Elementary Examination, GB | User Roles";
	protected $main_title         = "User Roles";
	protected $breadcrumb_title   = "User Roles";
	protected $selected_main_menu = "roles";
	protected $card_title;
	protected $selected_sub_menu;

	public function index()
	{
		$this->selected_sub_menu = "roles_index";
		$this->card_title        = "View and Manage all user roles shown below.";

		$models = Role::all();

		return view('backend.settings.roles.index', compact('models'))->with('main_title', $this->main_title)
		                                                              ->with('selected_main_menu', $this->selected_main_menu)
		                                                              ->with('breadcrumb_title', $this->breadcrumb_title)
		                                                              ->with('card_title', $this->card_title)
		                                                              ->with('selected_sub_menu', $this->selected_sub_menu)
		                                                              ->with('page_title', $this->page_title);
	}

	public function create()
	{
		$this->selected_sub_menu = "roles_create";

		$permissions = Permission::pluck('name', 'id');

		return view('backend.settings.roles.create', compact('permissions'))->with('main_title', $this->main_title)
		                                                                    ->with('selected_main_menu', $this->selected_main_menu)
		                                                                    ->with('breadcrumb_title', $this->breadcrumb_title)
		                                                                    ->with('card_title', $this->card_title)
		                                                                    ->with('selected_sub_menu', $this->selected_sub_menu)
		                                                                    ->with('page_title', $this->page_title);
	}

	public function store( Request $request )
	{
		$permissions = $request->get('permissions');
		$permissions = array_filter($permissions);

		$model = new Role();

		$model->name = $request->name;

		$model->save();

		$model->permissions()->sync($permissions);

		return back()
			->with('message', 'User role created successfully.');
	}

	public function show( $id )
	{
		//
	}

	public function edit( $id )
	{
		$this->selected_sub_menu = "roles_edit";

		$model       = Role::find($id);
		$permissions = Permission::pluck('name', 'id');

		return view('backend.settings.roles.edit', compact('model', 'permissions'))->with('main_title', $this->main_title)
		                                                                           ->with('selected_main_menu', $this->selected_main_menu)
		                                                                           ->with('breadcrumb_title', $this->breadcrumb_title)
		                                                                           ->with('card_title', $this->card_title)
		                                                                           ->with('selected_sub_menu', $this->selected_sub_menu)
		                                                                           ->with('page_title', $this->page_title);
	}

	public function update( Request $request, $id )
	{
		$model = Role::find($id);

		$model->name = $request->name;

		$model->save();


		if ( request()->filled('permissions') ) {

			$model->permissions()->detach();

			$model->givePermissionTo(request('permissions'));
		}

		return back()
			->with('message', 'User role updated successfully.');
	}

	public function destroy( $id )
	{
		//
	}
}
