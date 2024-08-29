<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Division;
use App\Models\SubDivision;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ModelHasRolesTableSeeder extends Seeder
{

    public function run()
    {

        $users = User::all();

        foreach ( $users as $user ) {

//            if ( $user->id == 1 ) {

                $user->assignRole('Super Admin');

//            }

        }

    }
}
