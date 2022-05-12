<?php

namespace App\Http\Controllers;

use App\Events\CourseAssignedEvent;
use App\Events\CourseCreatedEvent;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Course\UpdateCourseValidation;
use App\Models\Course;
use App\Models\CourseAssignmentSetting;
use App\Models\CourseUser;
use App\Models\User;
use App\Notifications\CourseAssignedNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

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
        if ($request->id) {
            $user_course = User::where('id', $request->id)->firstOrFail();
            $courses['data'] = $user_course->courses(function ($q) {
                $q->where('is_approved', 1);
            })->paginate(20);
        } else {
            $courses['data'] = Course::paginate(20);
        }
        return  $courses;
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'credit_hours' => 'required|numeric',
            'url' => 'required|url',
            'source' => 'required',
            'due_date' => '',
        ]);
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
        $course = Course::create($courseFields);

        if ($user->hasRole(['super-admin','course-admin'])) {
            event(new CourseCreatedEvent($course));
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
            ->orWhereIn('designation_id', $assignmentFields['staff_designation_ids']);
        })->get();
        $course->users()->attach($users);
        CourseAssignmentSetting::create($assignmentFields);

        

        event(new CourseAssignedEvent($request));

        return response()->json(true);
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
    public function update(Request $request, Course $course)
    {
        $course->update($request->all());
        return response()->json(true);
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
    public function updateAssignedCourse(UpdateCourseValidation $request)
    {
        try {
            $path =  $this->folder_path.DIRECTORY_SEPARATOR.auth()->user()->id;
            parent::checkFolderExist($path);
            $fileName = 'certificate'.'.'.$request->certificate_path->getClientOriginalExtension();
            $request->certificate_path->move($path, $fileName);
            $request['certificate_path'] = $path.DIRECTORY_SEPARATOR.$fileName;
            $course_user = CourseUser::where('course_id', $request->course_id)->firstOrFail();
            $data = [
                'certificate_path' => $path.DIRECTORY_SEPARATOR.$fileName,
                'completed_date' => $request->completed_date
            ];
            $course_user->update($data);
            
            $data['error'] = false;
            $data['message'] = 'Certification details updated successfully';
        } catch (Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }
}
