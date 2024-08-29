<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{

	public function run()
	{

		$roles = [
			'Super Admin',
			'Admin',
			'Entry Operator',
		];

		foreach ( $roles as $role ) {

			$model             = new Role();
			$model->name       = $role;
			$model->guard_name = "web";

			$model->save();
		}

	}
}
