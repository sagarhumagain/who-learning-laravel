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
            Permission::create(['name' => 'create_'.$item,'guard_name'=>'api']);
            Permission::create(['name' => 'read_'.$item,'guard_name'=>'api']);
            Permission::create(['name' => 'update_'.$item,'guard_name'=>'api']);
            Permission::create(['name' => 'delete_'.$item,'guard_name'=>'api']);
        }

        Permission::create(['name' => 'update_supervisee','guard_name'=>'api']);
        Permission::create(['name' => 'create_supervisee','guard_name'=>'api']);

        Permission::create(['name' => 'create_course','guard_name'=>'api']);
        Permission::create(['name' => 'update_course','guard_name'=>'api']);
        Permission::create(['name' => 'delete_course','guard_name'=>'api']);
        Permission::create(['name' => 'view_course','guard_name'=>'api']);

        //TODO supervisor permission?
        $course_permission = Permission::create(['name' => 'course_assignment','guard_name'=>'api']);
        $course_approve_permission = Permission::create(['name' => 'course_approve','guard_name'=>'api']);
        $courseuser_approve_permission = Permission::create(['name' => 'courseuser_approve','guard_name'=>'api']);

        $admin = Role::where('name', 'super-admin')->first();
        $course_permission->assignRole($admin);
        $course_approve_permission->assignRole($admin);
        $courseuser_approve_permission->assignRole($admin);
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
