<?php

namespace App\Services;

use App\Mail\CourseMail;
use App\Mail\ProfileApprovalMail;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailService
{
    // Build out service class

    public function sendProfileApprovalMail($request)
    {
        $data = [
            'subject' => 'Profile Approval Request',
            'message' => $request->name.' has requested for profile approval.',
        ];
        $supervisor_email = User::where('id', $request->supervisor_user_id)->first()->email;
        Mail::to($supervisor_email)->send(new ProfileApprovalMail($data));
    }

    public function sendProfileApprovedMail($email)
    {
        $data = [
            'subject' => 'Profile Approved',
            'message' => 'Your profile has been approved. Now you can enroll and create courses.',
        ];
        Mail::to($email)->send(new ProfileApprovalMail($data));
    }

    public function sendCourseCreatedMail($course_name)
    {
        $data = [
            'subject' => 'Course Created',
            'message' => auth()->user()->name.' has created a course '.$course_name.'. Please review the course and approve it.',
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
        $data = [
            'subject' => 'Course Completed',
            'message' => auth()->user()->name.' has completed the course '.$course_name.'. Please review the course and approve it.',
        ];

        //get supervisor email
        $admins =  $this->getAdmins();
        //send mail to admins
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
