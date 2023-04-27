<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $units =[
             [
            'name' => 'WHO Health Emergency Unit (WHE)'
            ],
            [
                'name' => 'Communicable Disease Surveillance(CDS)'
            ],
            [
                'name' => 'Health Systems Strengthening(HSS)'
            ],
            [
                'name' => 'Immunization Preventable Diseases (IPD)'
            ],
            [
                'name' => 'Non Communicable Diseases(NCD)'
            ],
            [
                'name' => 'Communication'
            ],
            [
                'name' => 'WR Office'
            ]
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
