<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseCategory;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories =  array(
            array(
                "name" => "Antimicrobial Resistance Channel",
                "description" => ""
            ),
            array(
                "name" => "Clinical Management Channel - OPTIONAL",
                "description" => ""
            ),
            array(
                "name" => "Risk Communication",
                "description" => ""
            ),
            array(
              "name" => "Lab-related",
              "description" => ""
            ),
            array(
              "name" => "Infection Prevention and Control Channel",
              "description" => ""
            ),
            array(
              "name" => "One Health Channel",
              "description" => ""
            ),
            array(
              "name" => "Outbreak Channel",
              "description" => ""
            ),
            array(
              "name" => "COVID-19 related",
              "description" => ""
            ),
            array(
              "name" => "OSL",
              "description" => ""
            ),
            array(
              "name" => "Preparing for Pandemics Channel",
              "description" => ""
            ),
            array(
              "name" => "Ready for Response Channel",
              "description" => ""
            ),
            array(
              "name" => "Risk Management",
              "description" => ""
            ),
            array(
              "name" => "COVID-19",
              "description" => ""
            ),
            array(
              "name" => "Data Analysis and Data Vizualization",
              "description" => ""
            ),
            array(
              "name" => "Data Skills",
              "description" => ""
            ),
            array(
              "name" => "Information Management",
              "description" => ""
            ),
            array(
              "name" => "WHO Mandatory Trainings",
              "description" => ""
            ),
            array(
              "name" => "Other",
              "description" => ""
            ),
        );
        foreach ($categories as $category) {
            CourseCategory::create(
                [
                  'name' => $category['name'],
                  'description' => $category['description']
                ]
            );
        }
    }
}
