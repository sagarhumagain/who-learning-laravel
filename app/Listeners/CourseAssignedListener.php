<?php

namespace App\Listeners;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use App\Notifications\CourseAssignedNotification;
use App\Notifications\CourseCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Queue\InteractsWithQueue;

class CourseAssignedListener extends BaseController
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $referee;
    public function __construct(Request $request)
    {
        $this->data = $this->buildAssignmentSettings($request);
    }

    private function buildAssignmentSettings(Request $request)
    {
        $assignment_setting_value['course_name'] = $request->name;
        
        $assignment_setting_value['assigned_pillar_name'] = parent::filterArrayByKey($request->pillar_ids, 'name');
        $assignment_setting_value['assigned_staff_type_name'] = parent::filterArrayByKey($request->staff_type_ids, 'name');
        $assignment_setting_value['assigned_contract_type_name'] = parent::filterArrayByKey($request->contract_type_ids, 'name');
        $assignment_setting_value['assigned_staff_category_name'] = parent::filterArrayByKey($request->staff_category_ids, 'name');
        $assignment_setting_value['assigned_staff_designation_name'] = parent::filterArrayByKey($request->staff_designation_ids, 'name');
        $assignment_setting_value['pillar_ids'] = parent::filterArrayByKey($request->pillar_ids, 'id');
        $assignment_setting_value['staff_type_ids'] = parent::filterArrayByKey($request->staff_type_ids, 'id');
        $assignment_setting_value['contract_type_ids'] = parent::filterArrayByKey($request->contract_type_ids, 'id');
        $assignment_setting_value['staff_category_ids'] = parent::filterArrayByKey($request->staff_category_ids, 'id');
        $assignment_setting_value['staff_designation_ids'] = parent::filterArrayByKey($request->staff_designation_ids, 'id');

        return $assignment_setting_value;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $assignmentFields = $this->data;

        $users =  User::leftJoin(\DB::raw('(SELECT * FROM contracts A WHERE created_at = (SELECT MAX(created_at)  FROM contracts B WHERE A.user_id=B.user_id)) AS t2'), function ($join) {
            $join->on('users.id', '=', 't2.user_id');
        })
        ->where(function ($q) use ($assignmentFields) {
            $q->whereHas('roles', function ($query) {
                $query->where(function ($q) {
                    $q->where('name', '=', 'course-admin')
                    ->orWhere('name', '=', 'super-admin');
                });
            })->orWhere(function ($q) use ($assignmentFields) {
                $q->whereHas('pillars', function ($q) use ($assignmentFields) {
                    $q->whereIn('pillar_id', $assignmentFields['pillar_ids']);
                })
                ->orWhereIn('staff_type_id', $assignmentFields['staff_type_ids'])
                ->orWhereIn('contract_type_id', $assignmentFields['contract_type_ids'])
                ->orWhereIn('staff_category_id', $assignmentFields['staff_category_ids'])
                ->orWhereIn('designation_id', $assignmentFields['staff_designation_ids'])
                ->orWhere('users.id', auth()->user()->id);
            });
        })->select('users.id as id')->get();

        Notification::send($users, new CourseAssignedNotification($this->data));
    }
}
