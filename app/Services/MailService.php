<?php

namespace App\Services;

use App\Mail\CourseMail;
use App\Mail\ProfileApprovalMail;
use App\Models\Course;
use App\Models\User;
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
            'message' => $request->name.' has requested for profile approval.',
            'url' => FacadesRequest::root().'/'.'users',
        ];
        $supervisor_email = User::where('id', $request->supervisor_user_id)->first()->email;
        Mail::to($supervisor_email)->send(new ProfileApprovalMail($data));
    }

    public function sendProfileApprovedMail($email)
    {
        $data = [
            'subject' => 'Profile Approved',
            'message' => 'Your profile has been approved. Now you can enroll and create courses.',
            'url' => FacadesRequest::root().'/'.'courses',
        ];
        Mail::to($email)->send(new ProfileApprovalMail($data));
    }

    public function sendCourseCreatedMail($course_name, $course_id)
    {
        $data = [
            'subject' => 'Course Created',
            'message' => auth()->user()->name.' has created a course '.$course_name.'. Please review the course and approve it.',
            'url' => FacadesRequest::root().'/'.'courses/'.$course_name.'/edit',
        ];
        //get supervisor email
        $admins = $this->getAdmins();
        //send mail to admins
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new CourseMail($data));
        }
    }


    public function sendCourseCompletedMail($data)
    {
        $course_name = Course::where('id', $data->course_id)->first()->name;
        $link = FacadesRequest::root().'/'.'approve/certificate/user_id/'.$data->user_id.'/course_id/'.$data->course_id.'';
        $data = [
            'subject' => 'Course Completed',
            'message' => auth()->user()->name.' has completed the course '.$course_name.'. Please review the course and approve it.',
            'url' => $link,
        ];

        //get supervisor email
        $admins =  $this->getAdmins();

        send mail to admins
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new CourseMail($data));
        }
    }

    public function sendCourseApprovedMail($data)
    {
        $course_name = Course::where('id', $data->course_id)->first()->name;
        $user = User::where('id', $data->user_id)->first();
        $data = [
            'subject' => 'Course Approved',
            'message' => 'Your course '.$course_name.' has been approved.',
            'url' => FacadesRequest::root().'/enrolled/courses',
        ];

        Mail::to($user->email)->send(new CourseMail($data));
    }

    public function getAdmins()
    {
        $admins =  User::whereHas('roles', function ($query) {
            $query->where('name', 'course-admin')->orWhere('name', 'super-admin');
        })->get();
        return $admins;
    }
}
