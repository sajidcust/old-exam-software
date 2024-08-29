<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreUsersRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Hash;
use Session;
use URL;
use App\Http\Requests\StoreRegistrationFormRequest;

class UserManagementController extends Controller
{
	protected $page_title         = "Board of Elementary Examination, GB | User Management";
	protected $main_title         = "User Management";
	protected $breadcrumb_title   = "User Management";
	protected $selected_main_menu = "user";
	protected $card_title;
	protected $selected_sub_menu;


	public function index()
	{
		$this->selected_sub_menu = "user_index";
		$this->card_title        = "View and Manage all districts shown below.";

		$models = User::get();

		return view('backend.settings.add-users.index', compact('models'))->with('main_title', $this->main_title)
		                                                                  ->with('selected_main_menu', $this->selected_main_menu)
		                                                                  ->with('breadcrumb_title', $this->breadcrumb_title)
		                                                                  ->with('card_title', $this->card_title)
		                                                                  ->with('selected_sub_menu', $this->selected_sub_menu)
		                                                                  ->with('page_title', $this->page_title);
	}

	public function registrationRequests()
	{
		$this->main_title         = "User Registration Approvals";
		$this->breadcrumb_title   = "User Registration Approvals";
		$this->selected_main_menu = "user_approvals";
		$this->selected_sub_menu  = "registration_requests";
		$this->card_title         = "View and Manage all requests shown below.";

		$models = User::isRegistered()->get();

		return view('backend.settings.add-users.registration_approvals', compact('models'))->with('main_title', $this->main_title)
		                                                                                   ->with('selected_main_menu', $this->selected_main_menu)
		                                                                                   ->with('breadcrumb_title', $this->breadcrumb_title)
		                                                                                   ->with('card_title', $this->card_title)
		                                                                                   ->with('selected_sub_menu', $this->selected_sub_menu)
		                                                                                   ->with('page_title', $this->page_title);
	}

	public function create()
	{
		$this->selected_sub_menu = "user_create";

		$roles = Role::pluck('name', 'id');

		return view('backend.settings.add-users.create', compact('roles'))->with('main_title', $this->main_title)
		                                                                  ->with('selected_main_menu', $this->selected_main_menu)
		                                                                  ->with('breadcrumb_title', $this->breadcrumb_title)
		                                                                  ->with('card_title', $this->card_title)
		                                                                  ->with('selected_sub_menu', $this->selected_sub_menu)
		                                                                  ->with('page_title', $this->page_title);
	}

	public function register()
	{
		return view('backend.settings.add-users.register')->with('main_title', $this->main_title)
		                                                  ->with('selected_main_menu', $this->selected_main_menu)
		                                                  ->with('breadcrumb_title', $this->breadcrumb_title)
		                                                  ->with('card_title', $this->card_title)
		                                                  ->with('selected_sub_menu', $this->selected_sub_menu)
		                                                  ->with('page_title', $this->page_title);
	}

	public function submitRegistration( StoreRegistrationFormRequest $request )
	{
		try {

			DB::beginTransaction();

			$model = new User();

			$model->name          = $request->name;
			$model->user_role     = 1;
			$model->email         = $request->email;
			$model->password      = \Hash::make($request->password);
			$model->status        = 0;
			$model->is_registered = 0;

			$model->save();

			DB::commit();

		} catch ( \Exception $e ) {

			Log::error($e->getMessage() . 'New User adding');
			DB::rollBack();

			toastr()->error('Server Ran Into Problem');
		}


		//		return Redirect::to('admin/user-management/index')
		//		               ->with('message', 'Your request for registration has been submitted.');
		toastr()->success('Your request for registration has been submitted.');

		return Redirect::to('/');

	}

	public function store( StoreUsersRequest $request )
	{
		try {

			DB::beginTransaction();

			$model = new User();

			$model->name      = $request->name;
			$model->user_role = 1;
			$model->email     = $request->email_address;
			$model->password  = \Hash::make($request->password);

			$model->save();


			if ( request()->filled('role') ) {

				$model->assignRole(request('role'));
			}

			DB::commit();

		} catch ( \Exception $e ) {

			Log::error($e->getMessage() . 'New User adding');
			DB::rollBack();

			toastr()->error('Server Ran Into Problem');
		}


		return Redirect::to('admin/user-management/index')
		               ->with('message', 'New user created successfully.');
	}

	public function show( $id )
	{
		$roles = Role::pluck('name', 'id');

		$user = User::find($id);

		return view('backend.settings.add-users.show', compact('user', 'roles'))->with('main_title', $this->main_title)
		                                                                        ->with('selected_main_menu', $this->selected_main_menu)
		                                                                        ->with('breadcrumb_title', $this->breadcrumb_title)
		                                                                        ->with('card_title', $this->card_title)
		                                                                        ->with('selected_sub_menu', $this->selected_sub_menu)
		                                                                        ->with('page_title', $this->page_title);
	}

	public function edit( $id )
	{
		//
	}

	public function update( Request $request, $id )
	{
		$this->validate($request, [

			'name'             => 'required|max:180',
			'password'         => 'nullable|min:8',
			'confirm_password' => 'nullable|same:password|min:8',
			'status'           => 'required',

			'email_address' => 'required|max:30|unique:users,email,' . $id,
		]);

		try {

			DB::beginTransaction();

			$model = User::find($id);

			$model->name   = $request->name;
			$model->email  = $request->email_address;
			$model->status = $request->status;

			if ( $request->password != '' && $request->password != NULL ) {

				$model->password = \Hash::make($request->password);
			}

			$model->save();

			if ( request()->filled('role') ) {

				$model->roles()->detach();

				if ( !$model->hasRole(request('role')) ) {

					$model->assignRole(request('role'));
				}
			}

			DB::commit();

		} catch ( \Exception $e ) {

			Log::error($e->getMessage() . 'Update User Details');
			DB::rollBack();

			toastr()->error('Server Ran Into Problem');
		}

		return Redirect::to('admin/user-management/index')
		               ->with('message', 'User updated successfully.');
	}


	public function destroy( $id )
	{
		$model = User::find($id);

		$model->delete();

		return Redirect::to('/admin/dashboard')
		               ->with('message', 'User deleted successfully.');
	}

}