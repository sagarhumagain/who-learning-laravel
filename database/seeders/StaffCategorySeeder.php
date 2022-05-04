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
            'description' => 'National Professional Officer',
            'slug' => 'npo'
            ]
        );
        StaffCategory::create(
          [
            'name' => 'General Staff',
            'description' => 'General Staff',
            'slug' => 'gs'
            ]
        );
        StaffCategory::create(
          [
            'name' => 'Team Leader',
            'description' => 'Team Leader',
            'slug' => 'tl'
            ]
        );
        StaffCategory::create(
          [
            'name' => 'Technical Officer',
            'description' => 'Technical Officer',
            'slug' => 'to'
            ]
        );
        StaffCategory::create(
          [
            'name' => 'Medical Officer',
            'description' => 'Medical Officer',
            'slug' => 'mo'
            ]
        );
        StaffCategory::create(
          [
            'name' => 'Scientist',
            'description' => 'Scientist',
            'slug' => 's'
          ]
        );
        StaffCategory::create(
          [
            'name' => 'Epidemiologist',
            'description' => 'Epidemiologist',
            'slug' => 'e'
            ]
        );
        StaffCategory::create(
          [
            'name' => 'SSA',
            'description' => 'SSA',
            'slug' => 'ssa'
            ]
        );
    }
}