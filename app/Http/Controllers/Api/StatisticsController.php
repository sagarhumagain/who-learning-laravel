<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseUser;
use App\Models\UserPillar;
use App\Models\CourseCategory;
use App\Models\CourseCourseCategory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    protected $panel = 'Permissions';
    protected $guard_name = 'api';
    private $colors = [
      '#009ADE',
      '#F26829',
      '#F4A81D',
      '#A6228C',
      '#5B2C86',
      '#80BC00',//color-sec-green
      '#EF3842' //color-red
    ];
    //superadmin-start

    public function fetchTopLearners()
    {
        $data =[];
        return response()->json($data);
    }

    public function fetchMandatoryCourses()
    {
        $data = [];
        $courseCategoryTitle = "WHO Mandatory Trainings";
        $courseCategoryId = CourseCategory::where('name', $courseCategoryTitle)->first()->id;
        $courses = Course::join('course_course_category', 'courses.id', '=', 'course_course_category.course_id')
        ->join('course_user', 'courses.id', '=', 'course_user.course_id')
        ->orderBy('courses.id', 'desc')
        ->select(DB::raw('courses.name as name, course_user.completed_date as completed_date'))
        ->where('course_course_category.course_category_id', $courseCategoryId)
        ->take(6)->get();

        $groupedCourses = $courses->groupBy('name');
        foreach ($groupedCourses as $courseName => $courses) {
            $completed = $remaining = 0;
            foreach ($courses as $course) {
                ($course->completed_date) ? ++$completed : ++$remaining;
            }
            $data[] = [
              'name' => $courseName,
              'labels' => ['Completed', 'Remaining'],
              'datasets' => [
                [
                  'data' => [$completed, $remaining],
                  'backgroundColor' => [$this->colors[5], $this->colors[6]]
                ]
              ]
            ];
        }
        return response()->json($data);
    }

    public function fetchMostPopularCourses()
    {
        $courses = CourseUser::join('courses', 'course_user.course_id', '=', 'courses.id')->orderBy('count', 'desc')
          ->select(DB::raw('courses.name as name, count(*) as count'))
          ->groupBy('course_user.course_id', 'courses.name')
          ->take(5)->get();
        $data =[
          'name' => 'Most Popular Courses',
          'labels' => [],
          'datasets' => [
            [
              'labels' => [],
              'data' => [],
              'backgroundColor' => []
            ]
          ]
        ];
        foreach ($courses as $index => $course) {
            $data['labels'][] = $course->name;
            $data['datasets'][0]['data'][] = $course->count;
            $data['datasets'][0]['backgroundColor'][] = $this->colors[$index];
        }
        return response()->json($data);
    }

    public function fetchStaffByPillar()
    {
        $pillars = UserPillar::join('pillars', 'pillar_user.pillar_id', '=', 'pillars.id')->orderBy('count', 'desc')
        ->select(DB::raw('pillars.name as name, count(*) as count'))
        ->groupBy('pillar_user.pillar_id', 'pillars.name')
        ->take(6)->get();
        $data =[
          'name' => 'Staffs by Pillar',
          'labels' => [],
          'datasets' => [
            [
              'label' => [],
              'data' => [],
              'backgroundColor' => []
            ]
          ]
        ];
        foreach ($pillars as $index => $pillar) {
            $data['labels'][] = $pillar->name;
            $data['datasets'][0]['data'][] = $pillar->count;
            $data['datasets'][0]['backgroundColor'][] = $this->colors[$index];
        }
        return response()->json($data);
    }

    public function fetchAdminDashboardStats()
    {
        $data = [];
        $data['total_courses'] = Course::count();
        $data['total_staffs'] = User::count();
        $data['total_course_duration'] = Course::where('is_approved', 1)->sum('credit_hours');
        $data['total_duration_completed'] = CourseUser::join('courses', 'course_user.course_id', '=', 'courses.id')
        ->whereNotNull('course_user.completed_date')
        ->where('course_user.is_approved', 1)
        ->sum('courses.credit_hours');
        return response()->json($data);
    }

    public function fetchPendingApprovals()
    {
        $user = auth()->user();
        $data = CourseUser::join('courses', 'course_user.course_id', '=', 'courses.id')
        ->select(DB::raw('courses.name as name, courses.credit_hours as credit_hours'))
        ->whereNotNull('course_user.completed_date')
        ->whereNull('course_user.is_approved')
        ->where('course_user.user_id', $user->id)
        ->get();

        return response()->json($data);
    }
    //superadmin-end

    //normal-user

    public function fetchUserDashboardStats()
    {
        $data = [];
        $user = auth()->user();
        $courseUsers = CourseUser::join('courses', 'course_user.course_id', '=', 'courses.id')
        ->select(DB::raw('courses.name as name, courses.credit_hours as credit_hours, course_user.is_approved as is_approved'))
        ->where('course_user.user_id', $user->id)->get();
        $data['total_enrolled_courses'] = $courseUsers->count();
        $data['total_completed_courses'] = 0;
        $data['course_duration_required'] = 100;
        $data['course_duration_completed'] = 0;
        foreach ($courseUsers as $courseUser) {
            if ($courseUser->credit_hours && $courseUser->is_approved) {
                $data['course_duration_completed'] +=  (float)$courseUser->credit_hours;
                $data['total_completed_courses']++;
            }
        }
        return response()->json($data);
    }
    public function fetchUserUpcomingDeadlines()
    {
        $user = auth()->user();
        $data = CourseUser::join('courses', 'course_user.course_id', '=', 'courses.id')
        ->select(DB::raw('courses.name as name, courses.credit_hours as credit_hours, courses.due_date as due_date'))
        ->whereNull('course_user.completed_date')
        ->whereNull('course_user.is_approved')
        ->where('course_user.user_id', $user->id)
        ->orderBy('course_user.completed_date', 'ASC')
        ->get();

        return response()->json($data);
    }

    public function fetchUserCompletedCourse()
    {
        $user = auth()->user();
        $data = CourseUser::join('courses', 'course_user.course_id', '=', 'courses.id')
        ->select(DB::raw('courses.name as name, courses.credit_hours as credit_hours'))
        ->whereNotNull('course_user.completed_date')
        ->where('course_user.is_approved', true)
        ->where('course_user.user_id', $user->id)
        ->get();

        return response()->json($data);
    }

    public function fetchUserYearlyProgress(Request $request)
    {
        // //get last three years
        // $years = [];
        // for ($i = 0; $i < 3; $i++) {
                //     $years[] = $year - $i;
        // }


        // $user = auth()->user();
        // $data = CourseUser::selectRaw('count(id) as count, year(completed_date) as year')
        //   ->whereYear('completed_date', '>=', $years[2])
        //   ->where('is_approved', 1)
        //   ->where('user_id', $user->id)
        //   ->groupBy('year')
        //   ->pluck('count', 'year')->toArray();

        try {
            $year = Carbon::now()->format('Y');
            if ($request->year) {
                $year = $request->year;
            }
            $user = auth()->user();
            $data = CourseUser::selectRaw('count(id) as count, month(completed_date) as month')
              ->whereYear('completed_date', $year)
              ->where('is_approved', 1)
              ->where('user_id', $user->id)
              ->groupBy('month')
              ->pluck('count', 'month')->toArray();
            $totalMonths = [1,2,3,4,5,6,7,8,9,10,11,12];
            $monthDataKeys = array_keys($data);
            $missingMonths = array_diff($totalMonths, $monthDataKeys);
            foreach ($missingMonths as $month) {
                $data[$month] = 0;
            }
            ksort($data);
            $finalData = array_values($data);

            return response()->json($finalData);
        } catch(\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
