<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StaffType;

class StaffTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffType::create(
          [
            'name' => 'International',
            'description' => 'International Staff',
            'slug' => 'is'
            ]
        );
        StaffType::create(
          [
            'name' => 'National',
            'description' => 'National Staff',
            'slug' => 'ns'
            ]
        );
        StaffType::create(
          [
            'name' => 'SSA',
            'description' => 'Non Staff',
            'slug' => 'ssa'
          ]
        );
    }
}