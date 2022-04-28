<?php

namespace Database\Seeders;

use App\Models\Pillar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PillarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pillars = [
            [
                'name' => 'Epidemiology and Health Information',
                'slug' => 'ehi'
            ],
            [
                'name' => 'Laboratory Capacity',
                'slug' => 'lc'
            ],
            [
                'name' => 'Technical Expertise and Training',
                'slug' => 'tet'
            ],
            [
                'name' => 'Operations Support and Logistics',
                'slug' => 'osl'
            ],
            [
                'name' => 'Partner Coordination & Donor Relations / Communication and Documentation',
                'slug' => 'pcdr'
            ],
            [
                'name' => 'Incident Management System',
                'slug' => 'ims'
            ],
            
        ];
        foreach ($pillars as $pillar) {
            Pillar::create($pillar);
        }
    }
}
