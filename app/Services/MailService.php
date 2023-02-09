<?php

namespace App\Services;

use App\Mail\ProfileApprovalMail;
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
}
