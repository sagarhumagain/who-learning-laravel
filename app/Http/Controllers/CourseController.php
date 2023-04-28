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
use App\Models\Employee;
use App\Models\User;
use App\Services\MailService;
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
                $query = Course::where('id', $request->id)->with('courseCategories')->with('courseAssignment');
                if ($auth_user->hasRole('normal-user') || $auth_user->hasRole('supervisor')) {
                    $query->with('users', function ($q) {
                        $q->where('users.id', auth()->user()->id);
                    });
                }
                $courses = $query->firstOrFail();
            } else {
                $query = Course::where('is_approved', 1)->filter($request->all())->with('courseCategories')->with('courseAssignment', function ($q) {
                    $q->with('createdBy');
                });
                if (auth()->user()->hasRole('normal-user') || auth()->user()->hasRole('supervisor')) {
                    $enrolled_courses = CourseUser::where('user_id', auth()->user()->id)->pluck('course_id')->toArray();
                    $query->whereNotIn('id', $enrolled_courses);
                }
                $courses = $query->orderBy('name')->paginate(20, ['*'], 'page', $request->page);
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
            $query = Course::where(function ($q) {
                $q->where('is_approved', 0)
                ->orWhereNull('is_approved');
            })->with('courseCategories')->with('courseAssignment', function ($q) {
                $q->with('createdBy');
            });

            if (auth()->user()->hasRole('supervisor')) {
                $supervisee_ids = [];
                $supervisee_ids = Employee::where('supervisor_user_id', auth()->user()->id)->pluck('user_id')->toArray();
                $query->whereHas('courseAssignment', function ($q) use ($supervisee_ids) {
                    $q->whereIn('assigned_by_user_id', $supervisee_ids);
                });
            } elseif (auth()->user()->hasRole('normal-user')) {
                $query->whereHas('courseAssignment', function ($q) {
                    $q->where('assigned_by_user_id', auth()->user()->id)->with('createdBy');
                });
            }

            $courses = $query->orderBy('updated_at')->paginate(20);

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
    public function store(CourseCreateValidation $request, MailService $mailService)
    {
        $user = auth()->user();

        //check duplicate courses
        $duplicateCourse = Course::where(function($q) use ($request){
            $q->where('url', $request->url)
            ->orWhere('url', '!=', 'N/A');
        })->orWhere(DB::raw('UPPER(name)'), 'LIKE', DB::raw("UPPER('%{$request->name}%')"))->first();
        if ($duplicateCourse) {
            return response()->json([
                'message' => 'Course already exists, please check course list to enroll the course.'
            ], 409);
        }

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
            if ($user->hasRole(['normal-user', 'supervisor'])) {
                event(new CourseCreatedEvent($course));
                $mailService->sendCourseCreatedMail($course->name, $course->id);
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
                    $mailService->sendCourseCompletedMail($course_user);
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
            if ($user->hasRole('normal-user') && $course->is_approved == 0) {
                $request['is_approved']= null;
            }
            $course->update($request->all());
            if ($user->hasRole(['normal-user', 'supervisor'])) {
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

    public function updateEnrolledCourse(UpdateCourseValidation $request, MailService $mailService)
    {
        $user = auth()->user();
        try {
            $request['due_date'] = $request->due_date == "null" ? null : $request->due_date;
            $request['description'] = $request->description == "null" ? null : $request->description;
            $course = Course::findOrFail($request->id);

            $course->update($request->all());
            if ($user->hasRole(['normal-user' , 'supervisor'])) {
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
                    $mailService->sendCourseCompletedMail($course_user);
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

        $query = CourseUser::join('courses', 'course_user.course_id', '=', 'courses.id')
            ->join('users', 'course_user.user_id', '=', 'users.id')
            ->select(DB::raw('course_user.user_id as user_id,courses.name as name, courses.credit_hours as credit_hours, course_user.is_approved as is_approved, users.name as createdBy, users.email as email, course_user.completed_date as completed_date, courses.id as course_id, courses.due_date as due_date,course_user.certificate_path as certificate'));

        if ($user->hasRole('supervisor')) {
            $supervisee_ids  = $this->getSuprerviseeIds();
            $query->where('course_user.user_id', $supervisee_ids);
        }
        $user_course = $query->where('course_user.is_approved', null)
        ->whereNotNull('course_user.completed_date')
        ->orderBy('course_user.completed_date', 'desc')
        ->paginate(50);

        // $query->where('course_user.is_approved', null);

        // if ($request->start_date && $request->end_date) {
        //     //filter by date
        //     $query->whereBetween('course_user.completed_date', [Carbon::parse($request->start_date)->startOfDay(), Carbon::parse($request->end_date)->endOfDay()]);
        // } else {
        //     //current year data
        //     $query->whereYear('course_user.completed_date', date('Y'));
        // }

        // $user_course = $query->paginate(50);

        return $user_course;
    }

    public function getUnapprovedCertificate(Request $request)
    {
        $user = auth()->user();
        $query = CourseUser::join('courses', 'course_user.course_id', '=', 'courses.id')
        ->join('users', 'course_user.user_id', '=', 'users.id')
        ->select(DB::raw('course_user.user_id as user_id,courses.name as name, courses.credit_hours as credit_hours, course_user.is_approved as is_approved, users.name as createdBy, users.email as email, course_user.completed_date as completed_date, courses.id as course_id, courses.due_date as due_date,course_user.certificate_path'))
        ->where('course_user.course_id', $request->course_id);

        if ($user->hasRole('super-admin')) {
            $query->where('course_user.user_id', $request->user_id);
        } elseif ($user->hasRole('supervisor')) {
            $supervisee_ids  = $this->getSuprerviseeIds();
            //check if the user is authorized to approve the certificate
            if (in_array($request->user_id, $supervisee_ids)) {
                $query->where('course_user.user_id', $request->user_id);
            } else {
                return response()->json(['error' => 'You are not authorized to approve this certificate'], 401);
            }
        } else {
            return response()->json(['error' => 'You are not authorized to approve this certificate'], 401);
        }


        $user_course = $query->first();

        return $user_course;
    }

    public function listSuggestedCourses()
    {
        $user = auth()->user();
        try {
            $course = CourseUser::where('user_id', $user->id)->whereNull('deleted_at')->pluck('course_id')->toArray();
            $suggestedCourses = CourseCategory::whereHas('courses', function ($q) use ($course) {
                $q->where('courses.is_approved', 1)->whereIn('courses.id', $course);
            })->with('randomCourses', function ($q) use ($course) {
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
    public function approveCourse(Request $request, MailService $mailService)
    {
        try {
            $course_user = CourseUser::where('user_id', $request->user_id)->where('course_id', $request->course_id)->first();
            $course_user->update(['is_approved'=> 1]);
            event(new CourseApprovalEvent($course_user));
            $mailService->sendCourseApprovedMail($course_user);
            $data['error'] = false;
            $data['message'] = "Course Approved Successfully";
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

    public function getSuprerviseeIds()
    {
        $supervisee_ids = [];
        $supervisee_ids = Employee::where('supervisor_user_id', auth()->user()->id)->pluck('user_id')->toArray();
        return $supervisee_ids;
    }
}
