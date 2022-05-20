<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash as FacadesHash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(
            [
          'name' => 'Super Admin',
          'email' => 'superadmin@who.int',
          'password' => FacadesHash::make('superadmin123'),
          'is_first_time_login' => 1
        ]
        );
        $course_admin = User::factory()->create(
            [
          'name' => 'Course Admin',
          'email' => 'courseadmin@who.int',
          'password' => FacadesHash::make('courseadmin123'),
          'is_first_time_login' => 1
        ]
        );
        User::factory()->create(
            [
          'name' => 'Normal User',
          'email' => 'normaluser@who.int',
          'password' => FacadesHash::make('normaluser123'),
          'is_first_time_login' => 1
        ]
        );
    }
}
