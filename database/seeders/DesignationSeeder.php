<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {




      $designations = [
        [
            'name' => 'Techincal Officer (Public Health Laboratories)'
        ],
        [
            'name' => 'Techincal Officer (IPC)',
        ],
        [
            'name' => 'National Professional Officer (Health Information)'
        ],
        [
            'name' => 'National Professional Officer (Internatioanl Health Regualtion)'
        ],
        [
            'name' => 'National Professional Officer (Infectious Hazards Managment)'
        ],
        [
            'name' => 'National Professional Officer (AMR Labs)'
        ],
        [
            'name' => 'National Professional Officer (EPO)'
        ],
        [
            'name' => 'National Professional Officer (OSL)'
        ],
        [
            'name' => 'National Professional Officer (Admin)'
        ],
        [
            'name' => 'National Professional Officer (ERM)'
        ],
        [
            'name' => 'Executive Assistant (Budget and Finance)'
        ],
        [
            'name' => 'Executive Assistant (Finance)'
        ],
        [
            'name' => 'Executive Assistant (Programme)'
        ],
        [
            'name' => 'Executive Assistant (OSL)'
        ],
        [
            'name' => 'Executive Associate (HR)'
        ],
        [
            'name' => 'Executive Associate (Budget and Finance)'
        ],
        [
            'name' => 'Field Medical Officer'
        ],
        [
            'name' => 'Information Management Assistant'
        ],
        [
            'name' => 'Information Management Associate'
        ],
        [
            'name' => 'Covid Surveillance Associate'
        ],
        [
            'name' => 'Hospital Surveillance Associate'
        ],
        [
            'name' => 'Clinical Data Support Assistant'
        ],
        [
            'name' => 'Health Emergency Intervention Officer'
        ],
        [
            'name' => 'Software Developer'
        ],
        [
            'name' => 'Programme Support Officer'
        ],
        [
            'name' => 'Alert and Response Officer'
        ],
        [
            'name' => 'Covid Surveillance Officer'
        ],
        [
          'name' => 'ICT Associate'
        ],
        [
            'name' => 'Hospital Preparedness Officer'
        ],
        [
            'name' => 'Health Emergency Intervention Officer'
        ],
        [
            'name' => 'Driver'
        ],
        [
            'name' => 'HR Assistant'
        ],
        [
            'name' => 'Admin Finance Logistics Assistant'
        ],
        [
            'name' => 'Admin and Programme Assistant'
        ],
        [
            'name' => 'Executive Assistant'
        ],
        [
            'name' => 'Project Management Assistant'
        ],
        [
            'name' => 'Graphic Designer'
        ],
        [
            'name' => 'Communication and Liaison Officer'
        ],
        [
            'name' => 'AMR Support Officer'
        ],
        [
          'name' => 'Data Analyst'
        ]
    ];
    foreach ($designations as $designation) {
        Designation::create($designation);
    }
    }
}
