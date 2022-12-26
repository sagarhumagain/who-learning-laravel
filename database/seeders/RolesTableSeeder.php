<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdmin = Role::create(['name' => 'super-admin','guard_name'=>'api']);
        $courseAdmin = Role::create(['name' => 'course-admin','guard_name'=>'api']);
        $normalUser = Role::create(['name' => 'normal-user','guard_name'=>'api']);
        $supervisor = Role::create(['name' => 'supervisor','guard_name'=>'api']);
        
        $sa_user = User::where('email', 'superadmin@who.int')->first();
        $sa_user->assignRole([$superAdmin,$supervisor]);

        $ca_user = User::where('email', 'courseadmin@who.int')->first();
        $ca_user->assignRole([$courseAdmin,$supervisor]);

        $nu_user = User::where('email', 'normaluser@who.int')->first();
        $nu_user->assignRole($normalUser);
    }
}
