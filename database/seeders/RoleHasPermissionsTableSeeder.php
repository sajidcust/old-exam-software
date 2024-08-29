<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Division;
use App\Models\SubDivision;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleHasPermissionsTableSeeder extends Seeder
{

    public function run()
    {

        $permissions = Permission::all();

        foreach ( $permissions as $permission ) {

            $role = Role::find(1);
            
            $role->givePermissionTo($permission->id);
        }

    }
}
