<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ContractTypeSeeder;
use Database\Seeders\CourseCategorySeeder;
use Database\Seeders\StaffCategorySeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\StaffTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
          UsersTableSeeder::class,
          RolesTableSeeder::class,
          PillarsTableSeeder::class,
          PermissionSeeder::class,
          ContractTypeSeeder::class,
          CourseCategorySeeder::class,
          StaffCategorySeeder::class,
          StaffTypeSeeder::class,
      ]);
    }
}
