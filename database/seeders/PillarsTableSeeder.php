<?php

namespace Database\Seeders;

use App\Models\Pillar;
use App\Models\User;
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
        $user1 = User::where('email','normaluser@who.int')->first();
        $user2 = User::where('email','normaluser2@who.int')->first();
        $pillarConditions = [true, false];
        foreach ($pillars as $pillar) {
            shuffle($pillarConditions);
            $createdPillar = Pillar::create($pillar);
            if($pillarConditions[0] == true) {
              $user1->pillars()->attach($createdPillar->id);
            } else {
              $user2->pillars()->attach($createdPillar->id);
            }
        }
    }
}
