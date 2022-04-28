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
                'name' => 'Epidemiology and Health Information'
            ],
            [
                'name' => 'Laboratory Capacity',
            ],
            [
                'name' => 'Technical Expertise and Training'
            ],
            [
                'name' => 'Operations Support and Logistics'
            ],
            [
                'name' => 'Partner Coordination & Donor Relations / Communication and Documentation'
            ],
            [
                'name' => 'Incident Management System'
            ],
            
        ];
        foreach ($pillars as $pillar) {
            Pillar::create($pillar);
        }
    }
}
