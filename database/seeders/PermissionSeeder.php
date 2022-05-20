<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getData() as $item) {
            Permission::create(['name' => 'create_'.$item,'guard_name'=>'auth']);
            Permission::create(['name' => 'read_'.$item,'guard_name'=>'auth']);
            Permission::create(['name' => 'update_'.$item,'guard_name'=>'auth']);
            Permission::create(['name' => 'delete_'.$item,'guard_name'=>'auth']);
        }

        Permission::create(['name' => 'update_supervisee','guard_name'=>'auth']);
        Permission::create(['name' => 'create_supervisee','guard_name'=>'auth']);


        Permission::create(['name' => 'create_mandatory_course','guard_name'=>'auth']);
        Permission::create(['name' => 'update_mandatory_course','guard_name'=>'auth']);
        Permission::create(['name' => 'delete_mandatory_course','guard_name'=>'auth']);


        Permission::create(['name' => 'create_course','guard_name'=>'auth']);
        Permission::create(['name' => 'update_course','guard_name'=>'auth']);
        Permission::create(['name' => 'delete_course','guard_name'=>'auth']);
        $course_permission = Permission::create(['name' => 'course_assignment','guard_name'=>'web']);

        $admin = Role::where('name', 'super-admin')->first();

        $course_permission->assignRole($admin);
    }
    public function getData()
    {
        return [
           'permission',
           'role',
           'user',
       ];
    }
}
