<?php

namespace App\Http\Controllers;

use App\Events\CertificateUpdateEvent;
use App\Events\CourseApprovalEvent;
use App\Events\CourseAssignedEvent;
use App\Events\CourseCreatedEvent;
use App\Events\CourseUpdateEvent;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Course\CourseCreateValidation;
use App\Http\Requests\Course\UpdateCourseValidation;
use App\Models\Course;
use App\Models\CourseAssignmentSetting;
use App\Models\CourseCategory;
use App\Models\CourseUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        try {
            if ($request->id) {
                $query = Course::where('id', $request->id)->with('courseCategories');
                if ($auth_user->hasRole('super-admin')) {
                    $query->with('courseAssignment', function ($q) {
                        $q->with('createdBy');
                    });
                } elseif ($auth_user->hasRole('normal-user') || $auth_user->hasRole('supervisor')) {
                    $query->with('users', function ($q) {
                        $q->where('users.id', auth()->user()->id);
                    });
                }
                $courses = $query->firstOrFail();
            } else {
                $query = Course::where('is_approved', 1)->filter($request->all())->with('courseCategories');
                if (auth()->user()->hasRole('normal-user') || auth()->user()->hasRole('supervisor')) {
                    $enrolled_courses = CourseUser::where('user_id', auth()->user()->id)->pluck('course_id')->toArray();
                    $query->whereNotIn('id', $enrolled_courses);
                }
                $courses = $query->orderBy('name')->paginate(20);
            }
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return $courses;
    }
    public function getApprovalCourseList()
    {
        try {
            $courses = Course::where(function ($q) {
                $q->where('is_approved', 0);
                $q->orWhereNull('is_approved');
            })
            ->with('courseAssignment', function ($q) {
                $q->with('createdBy');
            })->orderBy('is_approved')->with('courseCategories')->paginate(200);
            return $courses;
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
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

        $courseFields['is_approved'] = $this->setApprovalStatusForUser($user);

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

            //course assigned event
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
            if ($course->is_approved == 1 && !$user->hasRole(['super-admin', 'course-admin'])) {
                throw new \Exception('Please contact the admin to edit courses which are already approved in the system.');
            }
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
     * Remove the specified course from enrolled course.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function withdrawCourse($id)
    {
        try {
            $enrolled_course = CourseUser::findOrFail($id);
            if ($enrolled_course->user_id != auth()->user()->id) {
                throw new \Exception('You are not authorized to withdraw this course.');
            }
            $enrolled_course->delete();
            $data['error'] = false;
            $data['message'] = "Course Withdrawn Successfully";
        } catch(Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        try {
            $course->users()->detach();
            $course->courseCategories()->detach();
            $course->courseAssignment()->delete();
            $course->delete();
            return response()->json(true);
        } catch(Exception $e) {
            return response()->json(['message', $e->getMessage()], 500);
        }
    }

    public function updateEnrolledCourse(UpdateCourseValidation $request)
    {
        $user = auth()->user();
        try {
            $request['due_date'] = $request->due_date == "null" ? null : $request->due_date;
            $request['description'] = $request->description == "null" ? null : $request->description;
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
                    $users = User::leftJoin(DB::raw('(SELECT * FROM contracts A WHERE created_at = (SELECT MAX(created_at)  FROM contracts B WHERE A.user_id=B.user_id)) AS t2'), function ($join) {
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
                    $course->users()->syncWithoutDetaching($users);

                    CourseAssignmentSetting::updateOrCreate(
                        ['course_id' => $course->id],
                        $assignmentFields
                    );
                } catch (Exception $e) {
                    $data['error'] = true;
                    $data['message'] = $e->getMessage();
                }
            } elseif (($user->hasRole('normal-user') || $user->hasRole('supervisor')) && $request->certificate_path != 'null') {
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
            $data['message'] = 'Course updated successfully';
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
            $user_course = CourseUser::join('courses', 'course_user.course_id', '=', 'courses.id')
            ->join('users', 'course_user.user_id', '=', 'users.id')
            ->select(DB::raw('course_user.user_id as user_id,courses.name as name, courses.credit_hours as credit_hours, course_user.is_approved as is_approved, users.name as createdBy, users.email as email, course_user.completed_date as completed_date, courses.id as course_id, courses.due_date as due_date,course_user.certificate_path as certificate'))
            ->where('course_user.is_approved', null)
            ->whereNotNull('course_user.completed_date')
            ->paginate(20);
        } else {
            $user_course = [];
        }
        return $user_course;
    }

    public function listSuggestedCourses()
    {
        $user = auth()->user();
        try {
            $course = $user->courses()->pluck('course_id');
            $suggestedCourses = CourseCategory::whereHas('courses', function ($q) use ($course) {
                $q->where('courses.is_approved', 1)->whereIn('courses.id', $course);
            })->with('courses', function ($q) use ($course) {
                $q->where('courses.is_approved', 1)->whereNotIn('courses.id', $course);
            })->inRandomOrder()->get()->take(10);
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return $suggestedCourses;
    }

    public function enrollToCourse(Request $request)
    {
        $course_id = $request->course_id;
        $user = auth()->user();
        $count = CourseUser::where('user_id', $user->id)->where('course_id', $course_id)->count();
        if ($count == 0) {
            CourseUser::create([
          'user_id' => $user->id,
          'course_id' => $course_id
        ]);
        }
        response()->json(['success' => 'success'], 200);
    }

    /**
     * Display a listing of the user enrolled courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function listEnrolledCourse(Request $request)
    {
        try {
            $auth_user = auth()->user();
            $course_user = Course::join('course_user', 'courses.id', '=', 'course_user.course_id')
            ->where('course_user.user_id', $auth_user->id)->whereNull('course_user.deleted_at')->filter($request->all())->get();
            return $course_user;
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getExceededDeadlines()
    {
        $user = auth()->user();
        //#TODO Check for permission
        if ($user->hasRole('super-admin')) {
            $user_course = CourseUser::join('courses', 'course_user.course_id', '=', 'courses.id')
            ->join('users', 'course_user.user_id', '=', 'users.id')
            ->select(DB::raw('courses.name as name, courses.credit_hours as credit_hours, course_user.is_approved as is_approved, users.email as email, course_user.completed_date as completed_date, courses.id as course_id, courses.due_date as due_date'))
            ->whereDate('courses.due_date', '>', date('Y-m-d'))
            ->whereNull('course_user.completed_date')
            ->get();
        } else {
            $user_course = [];
        }
        return $user_course;
    }
    public function approveCourse(Request $request)
    {
        try {
            $course_user = CourseUser::where('user_id', $request->user_id)->where('course_id', $request->course_id)->first();
            $course_user->update(['is_approved'=> 1]);
            event(new CourseApprovalEvent($course_user));
            $data['error'] = false;
            $data['message'] = "Course Updated Successfully";
        } catch (Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }
    public function assignCourseToNewUsers()
    {
        try {
            $course_assignment_settings = CourseAssignmentSetting::get();

            foreach ($course_assignment_settings as $assignment) {
                $users = User::leftJoin(DB::raw('(SELECT * FROM contracts A WHERE created_at = (SELECT MAX(created_at)  FROM contracts B WHERE A.user_id=B.user_id)) AS t2'), function ($join) {
                    $join->on('users.id', '=', 't2.user_id');
                })
                ->where(function ($q) use ($assignment) {
                    $q->whereHas('pillars', function ($q) use ($assignment) {
                        $q->whereIn('pillar_id', $assignment['pillar_ids']);
                    })
                    ->orWhereIn('staff_type_id', $assignment['staff_type_ids'])
                    ->orWhereIn('contract_type_id', $assignment['contract_type_ids'])
                    ->orWhereIn('staff_category_id', $assignment['staff_category_ids'])
                    ->orWhereIn('designation_id', $assignment['staff_designation_ids']);
                })->select('users.id as id')->get();
                $course = Course::findOrFail($assignment->course_id);
                $course->users()->syncWithoutDetaching($users);
            }
            $response['error'] = false;
            $response['message'] = 'Course assigned to users successfully';
            return $response;
        } catch(\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            return $response;
        }
    }

    public function setApprovalStatusForUser($user)
    {
        return $user->hasRole(['super-admin', 'course-admin', 'supervisor']) ? true : null;
    }
}
