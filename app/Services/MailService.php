<?php

namespace App\Services;

use App\Mail\ContractUpdate;
use App\Mail\CourseMail;
use App\Mail\ProfileApprovalMail;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\User;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request as FacadesRequest;

class MailService
{
    // Build out service class

    public function sendProfileApprovalMail($request)
    {
        $data = [
            'subject' => 'Profile Approval Request',
            'message' => $request->name . ' has requested for profile approval.',
            'url' => FacadesRequest::root() . '/' . 'users',
        ];
        $supervisor_email = User::where('id', $request->supervisor_user_id)->first()->email;
        Mail::to($supervisor_email)->send(new ProfileApprovalMail($data));
    }

    public function sendProfileApprovedMail($email)
    {
        $data = [
            'subject' => 'Profile Approved',
            'message' => 'Your profile has been approved. Now you can enroll and create courses.',
            'url' => FacadesRequest::root() . '/' . 'courses',
        ];
        Mail::to($email)->send(new ProfileApprovalMail($data));
    }

    public function sendContractApproveMail($request)
    {
        try {

            $data = [
                'subject' => 'Contract Update',
                'message' => $request->name . ' has updated his contract. Please review the contract and if the contract details are not correct, please update the contract.',
                'url' => FacadesRequest::root() . '/' . 'users',
            ];
            $supervisor_email = $request->employee->supervisor->email;
            Mail::to($supervisor_email)->send(new ContractUpdate($data));
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }




    public function sendCourseCreatedMail($course_name, $course_id, $user)
    {
        $data = [
            'subject' => 'Course Created',
            'message' => auth()->user()->name . ' has created a course ' . $course_name . '. Please review the course and approve it.',
            'url' => FacadesRequest::root() . '/' . 'courses/' . $course_name . '/edit',
        ];
        //get supervisor email
        $supervisor_email = $user->employee->supervisor->email;

        $admins =  $this->getAdmins();

        Mail::to($supervisor_email)->cc($admins)->send(new CourseMail($data));

    }


    public function sendCourseCompletedMail($data, $user)
    {
        $course_name = Course::where('id', $data->course_id)->first()->name;
        $link = FacadesRequest::root() . '/' . 'approve/certificate/user_id/' . $data->user_id . '/course_id/' . $data->course_id . '';
        $data = [
            'subject' => 'Course Completed',
            'message' => auth()->user()->name . ' has completed the course ' . $course_name . '. Please review the course and approve it.',
            'url' => $link,
        ];
        $admins =  $this->getAdmins();
        $supervisor_email = $user->employee->supervisor->email;

        Mail::to($supervisor_email)->cc($admins)->send(new CourseMail($data));

    }

    public function sendCertificateApprovedMail($data)
    {
        $course_name = Course::where('id', $data->course_id)->first()->name;
        $user = User::where('id', $data->user_id)->first();

        if($data->is_approved == 1) {
            $data = [
                'subject' => 'Certificate approved for ' . $course_name,
                'message' => 'Your certificate for course ' . $course_name . ' has been approved.',
                'url' => FacadesRequest::root() . '/enrolled/courses',
            ];
        } else {
            $data = [
                'subject' => 'Certificate rejected for ' . $course_name,
                'message' => 'Your certificate for course ' . $course_name . ' has been rejected.',
                'url' => FacadesRequest::root() . '/enrolled/courses',
            ];
        }
        Mail::to($user->email)->send(new CourseMail($data));
    }

    public function getAdmins()
    {
        $admins =  User::whereHas('roles', function ($query) {
            $query->where('name', 'course-admin')->orWhere('name', 'super-admin');
        })->pluck('email')->toArray();
        return $admins;
    }

    public function sendCourseAssignedMail($old_course_assignment, $data, $course_name, $due_date)
    {
        $old_users = User::leftJoin(\DB::raw('(SELECT * FROM contracts A WHERE created_at = (SELECT MAX(created_at)  FROM contracts B WHERE A.user_id=B.user_id)) AS t2'), function ($join) {
            $join->on('users.id', '=', 't2.user_id');
        })
        ->where(function ($q) use ($old_course_assignment) {
            $q->where(function ($q) use ($old_course_assignment) {
                $q->whereHas('pillars', function ($q) use ($old_course_assignment) {
                    $q->whereIn('pillar_id', $old_course_assignment['pillar_ids']);
                })
                ->orWhereIn('staff_type_id', $old_course_assignment['staff_type_ids'])
                ->orWhereIn('contract_type_id', $old_course_assignment['contract_type_ids'])
                ->orWhereIn('staff_category_id', $old_course_assignment['staff_category_ids'])
                ->orWhereIn('designation_id', $old_course_assignment['staff_designation_ids']);
            });
        })->select('users.id as id', 'email')->get();


        $users =  User::leftJoin(\DB::raw('(SELECT * FROM contracts A WHERE created_at = (SELECT MAX(created_at)  FROM contracts B WHERE A.user_id=B.user_id)) AS t2'), function ($join) {
            $join->on('users.id', '=', 't2.user_id');
        })
        ->where(function ($q) use ($data) {
            $q->where(function ($q) use ($data) {
                $q->whereHas('pillars', function ($q) use ($data) {
                    $q->whereIn('pillar_id', $data['pillar_ids']);
                })
                ->orWhereIn('staff_type_id', $data['staff_type_ids'])
                ->orWhereIn('contract_type_id', $data['contract_type_ids'])
                ->orWhereIn('staff_category_id', $data['staff_category_ids'])
                ->orWhereIn('designation_id', $data['staff_designation_ids']);
            });
        })->select('users.id as id', 'email')->get();

        //get unique users by comparing old and new users
        $users = $users->diff($old_users);

        $mail_data = [
            'subject' => 'Course Assigned',
            'message' => 'You have been assigned a ' . $course_name . ' course to complete within a specified deadline ' . $due_date ?? '' ,
            'url' => FacadesRequest::root() . '/' . 'courses/' . $data['course_id'] . '/edit',
        ];
        $cc_users = $users->pluck('email')->toArray();

        Mail::cc($cc_users)->send(new CourseMail($mail_data));
    }



}
