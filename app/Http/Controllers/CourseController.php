<?php

namespace App\Http\Controllers;

use App\Events\CourseAssignedEvent;
use App\Events\CourseCreatedEvent;
use App\Http\Controllers\Api\BaseController;
use App\Models\Course;
use App\Models\CourseAssignmentSetting;
use App\Models\User;
use App\Notifications\CourseAssignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses['data'] = Course::paginate(20);
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
            'url' => $request->credit_hours,
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
        ];
        $users = User::whereHas('pillars', function ($q) use ($assignmentFields) {
            $q->whereIn('pillar_id', $assignmentFields['pillar_ids']);
        })->pluck('id');
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
}
