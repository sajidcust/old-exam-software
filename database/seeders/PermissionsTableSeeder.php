<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\SubDivision;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{

	public function run()
	{

		$permissions = [
			'menu approvals',
			'menu user management',
			'menu user roles',
			'menu user permissions',
			'menu districts',
			'menu tehsils',
			'menu sessions',
			'menu semesters',
			'menu banks',
			'menu fees',
			'menu classes',
			'menu subjects',
			'menu subject groups',
			'menu datasheets',
			'menu institutions',
			'menu students',
			'menu exams',
			'menu import or export',
			'menu settings',
			'menu failed jobs',

		];

		foreach ( $permissions as $permission ) {

			$model             = new Permission();
			$model->name       = $permission;
			$model->guard_name = "web";

			$model->save();
		}

	}
}
