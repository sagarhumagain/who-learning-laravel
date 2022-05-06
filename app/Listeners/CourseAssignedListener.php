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
        $users =  User::whereHas('roles', function ($query) {
            $query->where('name', 'course-admin')->orWhere('name', 'super-admin')->orWhere('name', 'normal-user');
        })->when($this->data['pillar_ids'], function ($query) {
            $query->orWhereHas('pillars', function ($query) {
                return $query->whereIn('pillar_id', $this->data['pillar_ids']);
            });
        })->when($this->data['staff_type_ids'], function ($query) {
            $query->whereHas('staffTypse', function ($query) {
                return $query->whereIn('staff_type_id', $this->data['staff_type_ids']);
            });
        })->when($this->data['contract_type_ids'], function ($query) {
            $query->whereHas('contractTypes', function ($query) {
                return $query->whereIn('contract_type_id', $this->data['contract_type_ids']);
            });
        })->when($this->data['staff_category_ids'], function ($query) {
            $query->whereHas('staffCategories', function ($query) {
                return $query->whereIn('staff_category_id', $this->data['staff_category_ids']);
            });
        })->when($this->data['staff_designation_ids'], function ($query) {
            $query->whereHas('staffDesignations', function ($query) {
                return $query->whereIn('staff_designation_id', $this->data['staff_designation_ids']);
            });
        })->get();


        Notification::send($users, new CourseAssignedNotification($this->data));
    }
}
