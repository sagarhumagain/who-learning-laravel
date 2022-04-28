<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StaffCategory;

class StaffCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffCategory::create(
          [
            'name' => 'National Professional Officer',
            'description' => 'National Professional Officer'
          ]
        );
        StaffCategory::create(
          [
            'name' => 'General Staff',
            'description' => 'General Staff'
          ]
        );
        StaffCategory::create(
          [
            'name' => 'Team Leader',
            'description' => 'Team Leader'
          ]
        );
        StaffCategory::create(
          [
            'name' => 'Technical Officer',
            'description' => 'Technical Officer'
          ]
        );
        StaffCategory::create(
          [
            'name' => 'Medical Officer',
            'description' => 'Medical Officer'
          ]
        );
        StaffCategory::create(
          [
            'name' => 'Scientist',
            'description' => 'Scientist'
          ]
        );
        StaffCategory::create(
          [
            'name' => 'Epidemiologist',
            'description' => 'Epidemiologist'
          ]
        );
        StaffCategory::create(
          [
            'name' => 'SSA',
            'description' => 'SSA'
          ]
        );
    }
}