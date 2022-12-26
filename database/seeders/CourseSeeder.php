<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseCourseCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      #TODO Course source in course_source table with foreign key. 
      $courses =  array(
        array(
            "name" => "AMR-competency",
            "description" => "",
            "credit_hours" => 8,
            "source" => "Open WHO",
            "url" => "https://openwho.org/courses/AMR-competency",
            "due_date" => '2022-05-22',
            "course_categories" => ["Antimicrobial Resistance Channel"],
            "is_approved" => 1
        ),
        array(
          "name" => "RCCE-COVID-19",
          "description" => "",
          "credit_hours" => 2,
          "source" => "Open WHO",
          "url" => "https://openwho.org/courses/RCCE-COVID-19",
          "due_date" => '2022-05-15',
          "course_categories" => ["Risk communication", "WHO Mandatory Trainings"],
          "is_approved" => 1
        ),
        array(
          "name" => "Data Analysis and Data Vizualization",
          "description" => "",
          "credit_hours" => 8,
          "source" => "iLearn",
          "url" => "https://who.csod.com/ui/lms-learning-details/app/course/ac716a33-6379-5a22-88e9-37c574c06106",
          "due_date" => '2022-05-22',
          "course_categories" => ["Data Analysis and Data Vizualization", "WHO Mandatory Trainings"],
          "is_approved" => 1
        ),
      );
      foreach ($courses as $course) {
        $createdCourse = Course::create(
          [
            'name' => $course['name'],
            'description' => $course['description'],
            'credit_hours' => $course['credit_hours'],
            'source' => $course['source'],
            'url' => $course['url'],
            'due_date' => $course['due_date']
          ]
        );
        $user1 = User::where('email','normaluser@who.int')->first();
        $user2 = User::where('email','normaluser2@who.int')->first();
        foreach($course['course_categories'] as $courseCategory) {
          $courseCategoryId = CourseCategory::where(DB::raw('lower(name)'), strtolower($courseCategory))
          ->pluck('id')->first();
          CourseCourseCategory::create([
            "course_id" => $createdCourse->id,
            "course_category_id" => $courseCategoryId
          ]);
        }
       
        $user1->courses()->attach($createdCourse->id);
        $user2->courses()->attach($createdCourse->id);
      }
    }
}
