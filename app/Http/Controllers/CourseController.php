<?php

namespace App\Http\Controllers;

use App\Events\CertificateUpdateEvent;
use App\Events\CourseAssignedEvent;
use App\Events\CourseCreatedEvent;
use App\Events\CourseUpdateEvent;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Course\CourseCreateValidation;
use App\Http\Requests\Course\UpdateCourseValidation;
use App\Models\Course;
use App\Models\CourseAssignmentSetting;
use App\Models\CourseUser;
use App\Models\User;
use App\Notifications\CourseEnrolledNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use function PHPUnit\Framework\isEmpty;

class CourseController extends BaseController
{
    protected $folder = 'users';
    public function __construct(Course $model)
    {
        $this->model = $model;
        $this->folder_path = 'images'.DIRECTORY_SEPARATOR.$this->folder;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auth_user = auth()->user();
        if ($auth_user->hasRole('normal-user') && !$request->id) {
            $user_course = User::where('id', $auth_user->id)->firstOrFail();
            $courses['data'] = $user_course->courses(function ($q) {
                $q->where('is_approved', 1);
            })->paginate(20);
        } elseif ($request->id) {
            if ($auth_user->hasRole('super-admin')) {
                $courses =  Course::where('id', $request->id)->with('courseAssignment', 'courseCategories')->firstOrFail();
            } elseif ($auth_user->hasRole('normal-user')) {
                $courses =  Course::where('id', $request->id)->with('courseCategories')->with('users', function ($q) {
                    $q->where('users.id', auth()->user()->id);
                })->firstOrFail();
            }
        } else {
            $courses['data'] = Course::with('courseCategories')->paginate(200);
        }
        return $courses;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'create' => 'create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseCreateValidation $request)
    {
        $user = auth()->user();
        $courseFields = [
            'name' => $request->name,
            'description' => $request->description,
            'credit_hours' => $request->credit_hours,
            'url' => $request->url,
            'source' => $request->source,
            'due_date' => $request->due_date,
        ];
        if ($user->hasRole(['super-admin'])) {
            $courseFields['is_approved'] = true;
        } else {
            $courseFields['is_approved'] = false;
        }
        try {
            //course create
            $course = Course::create($courseFields);
            //course created event
            if ($user->hasRole(['super-admin','course-admin'])) {
                event(new CourseCreatedEvent($course));
            }
            //attached course categories
            if ($request->course_category_ids) {
                $courseCategoryIds = parent::filterArrayByKey($request->course_category_ids, 'id');
                $course->courseCategories()->attach($courseCategoryIds);
            }
            $assignmentFields = [
                'pillar_ids' => parent::filterArrayByKey($request->pillar_ids, 'id'),
                'staff_type_ids' => parent::filterArrayByKey($request->staff_type_ids, 'id'),
                'contract_type_ids' => parent::filterArrayByKey($request->contract_type_ids, 'id'),
                'staff_category_ids' => parent::filterArrayByKey($request->staff_category_ids, 'id'),
                'staff_designation_ids' => parent::filterArrayByKey($request->staff_designation_ids, 'id'),
                'course_id' => $course->id,
                'assigned_by_user_id' => $user->id,
            ];
            $users = User::leftJoin(\DB::raw('(SELECT * FROM contracts A WHERE created_at = (SELECT MAX(created_at)  FROM contracts B WHERE A.user_id=B.user_id)) AS t2'), function ($join) {
                $join->on('users.id', '=', 't2.user_id');
            })
            ->where(function ($q) use ($assignmentFields) {
                $q->whereHas('pillars', function ($q) use ($assignmentFields) {
                    $q->whereIn('pillar_id', $assignmentFields['pillar_ids']);
                })
                ->orWhereIn('staff_type_id', $assignmentFields['staff_type_ids'])
                ->orWhereIn('contract_type_id', $assignmentFields['contract_type_ids'])
                ->orWhereIn('staff_category_id', $assignmentFields['staff_category_ids'])
                ->orWhereIn('designation_id', $assignmentFields['staff_designation_ids'])
                ->orWhere('users.id', $assignmentFields['assigned_by_user_id']);
            })->select('users.id as id')
            ->get();

            //attached course to users
            $course->users()->attach($users);

            //course assignement setting create
            CourseAssignmentSetting::create($assignmentFields);
            event(new CourseAssignedEvent($request));
            //update certificate for normal users
            try {
                if ($user->hasRole('normal-user') && $request->certificate_path && $request->completed_date) {
                    $course_user = CourseUser::where('course_id', $course->id)->where('user_id', $user->id)->firstOrFail();
        
                    $path =  $this->folder_path.DIRECTORY_SEPARATOR.auth()->user()->id;
                    parent::checkFolderExist($path);
                    $fileName = $course->id.'_certificate'.'.'.$request->certificate_path->getClientOriginalExtension();
                    $request->certificate_path->move($path, $fileName);
                    $data = [
                            'certificate_path' => $path.DIRECTORY_SEPARATOR.$fileName,
                            'completed_date' => $request->completed_date
                        ];
                    $course_user->update($data);
                    event(new CertificateUpdateEvent($course_user));
                }
            } catch (Exception $e) {
                $data['error'] = true;
                $data['message'] = $e->getMessage();
            }
            $data['error'] = false;

            $data['message'] = 'Course Created successfully';
        } catch (Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return response()->json([
            'course' => $course
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return response()->json([
            'course' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        try {
            $course = Course::findOrFail($id);
            $course->update($request->all());
            if ($user->hasRole(['super-admin','course-admin'])) {
                event(new CourseUpdateEvent($course));
            }

            $data['error'] = false;
            $data['message'] = "Course Updated Successfully";
        } catch (Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(true);
    }

    public function updateEnrolledCourse(UpdateCourseValidation $request)
    {
        $user = auth()->user();
        try {
            $course = Course::findOrFail($request->id);
            $course->update($request->all());
            if ($user->hasRole(['super-admin','course-admin'])) {
                event(new CourseUpdateEvent($course));
            }
            if ($request->course_category_ids) {
                $courseCategoryIds = parent::filterArrayByKey($request->course_category_ids, 'id');
                $course->courseCategories()->sync($courseCategoryIds);
            }
            if ($user->hasRole(['super-admin'])) {
                try {
                    $assignmentFields = [
                        'pillar_ids' => parent::filterArrayByKey($request->pillar_ids, 'id'),
                        'staff_type_ids' => parent::filterArrayByKey($request->staff_type_ids, 'id'),
                        'contract_type_ids' => parent::filterArrayByKey($request->contract_type_ids, 'id'),
                        'staff_category_ids' => parent::filterArrayByKey($request->staff_category_ids, 'id'),
                        'staff_designation_ids' => parent::filterArrayByKey($request->staff_designation_ids, 'id'),
                        'course_id' => $course->id,
                        'assigned_by_user_id' => $user->id,
                    ];
                    $users = User::leftJoin(\DB::raw('(SELECT * FROM contracts A WHERE created_at = (SELECT MAX(created_at)  FROM contracts B WHERE A.user_id=B.user_id)) AS t2'), function ($join) {
                        $join->on('users.id', '=', 't2.user_id');
                    })
                    ->where(function ($q) use ($assignmentFields) {
                        $q->whereHas('pillars', function ($q) use ($assignmentFields) {
                            $q->whereIn('pillar_id', $assignmentFields['pillar_ids']);
                        })
                        ->orWhereIn('staff_type_id', $assignmentFields['staff_type_ids'])
                        ->orWhereIn('contract_type_id', $assignmentFields['contract_type_ids'])
                        ->orWhereIn('staff_category_id', $assignmentFields['staff_category_ids'])
                        ->orWhereIn('designation_id', $assignmentFields['staff_designation_ids']);
                    })->select('users.id as id')
                    ->get();
                    $course->users()->sync($users);
                    
                    CourseAssignmentSetting::where('course_id', $course->id)->update($assignmentFields);
                } catch (Exception $e) {
                    $data['error'] = true;
                    $data['message'] = $e->getMessage();
                }
            } elseif ($user->hasRole('normal-user') && $request->certificate_path != 'null') {
                try {
                    $course_user = CourseUser::where('course_id', $course->id)->where('user_id', $user->id)->firstOrFail();
                    if ($request->certificate_path != $course_user->certificate_path) {
                        $path =  $this->folder_path.DIRECTORY_SEPARATOR.auth()->user()->id;
                        parent::checkFolderExist($path);
                        $fileName = $course->id.'_certificate'.'.'.$request->certificate_path->getClientOriginalExtension();
                        $request->certificate_path->move($path, $fileName);
                        $data = [
                            'certificate_path' => $path.DIRECTORY_SEPARATOR.$fileName,
                            'completed_date' => $request->completed_date
                        ];
                    } else {
                        $data['completed_date'] = $request->completed_date;
                    }

                    $course_user->update($data);
                    event(new CertificateUpdateEvent($course_user));
                } catch (Exception $e) {
                    $data['error'] = true;
                    $data['message'] = $e->getMessage();
                }
            }
            $data['error'] = false;
            $data['message']='Course Info! Has Been Updated';
        } catch (\Exception $e) {
            $data['error'] = true;
            $data['message']=$e->getMessage();
        }
        return response()->json($data);
    }

    public function listUnapprovedCourses()
    {
        $user = auth()->user();
        //#TODO Check for permission
        if ($user->hasRole('super-admin')) {
            $user_course = CourseUser::where('is_approved', null)
            ->orWhere('is_approved', 0)
            ->with(['courses', 'users'])->paginate(20);
        } else {
            $user_course = [];
        }
        return $user_course;
    }

    public function listSuggestedCourses()
    {
        $user = auth()->user();
        $suggestedCourses = Course::inRandomOrder()
        ->limit(3) // here is yours limit
        ->get();
        return $suggestedCourses;
    }

    public function enrollToCourse(Request $request)
    {
        $user = auth()->user();
        $count = CourseUser::where('user_id', $user->id)->where('course_id', $request->course_id)->count();
        if ($count == 0) {
            CourseUser::create([
          'user_id' => $user->id,
          'course_id' => $request->course_id
        ]);
        }
        response()->json(['success' => 'success'], 200);
    }
}
